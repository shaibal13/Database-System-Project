<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId; //For native use

class Homes extends Eloquent
{
    use HasFactory;
    protected $fillable = [
        'HomeID','FloorSpace', 'Floors', 'BedRooms', 'BathRooms',
        'LandSize', 'YearConstructed', 'Type', 'LocationId'
    ];

    // Method to create a new Home
    public function addHome($data){
        return self::raw(function($collection) use ($data) {
            return $collection->insertOne($data);
        });
    }

    // Method to retrieve a Home
    public function getHome($id) {
        $objectId = new ObjectId($id);
        return self::raw(function($collection) use ($objectId) {
            return $collection->findOne(['_id' => $objectId]);
        });
       
    }
    
    // Method to update a Home
    public function updateHome($id,$updateData){
        return self::raw(function($collection) use ($id, $updateData) {
            $objectId = new ObjectId($id); 
            return $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => $updateData]
            );
        });
    }

    //FInd all the Home
    public function getHomeDetails() {
        return self::raw(function($collection) {
            // The find method returns a cursor for the documents
            return $collection->find();
        });
    }
    // Find by the status owned or for sale

    public function getHomeDetailsByAvailability($type){
        
        return self::raw(function($collection) use ($type) {
            return $collection->find(['Status' => $type]);
        });
    }
    // Method to delete a Home
    public function deleteHome($id) {
        $home = self::find($id);
        $home->delete();
    }
    //Add appliances to the home collection
    public function addAppliancesToHome($id, $appliances){



        return self::raw(function($collection) use ($id, $appliances) {
            $objectId = new ObjectId($id); 

               // First, set the Appliances field to an empty array
            $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => ['Appliances' => []]]
            );


            return $collection->updateOne(
                ['_id' => $objectId],
                ['$push' => ['Appliances' => ['$each' => $appliances]]]
            );
        });
    }
// Question 4	Find all the homes that include all e ques by the same maker
    public function findAllHomesUsedBySameMaker($maker){
        return self::raw(function($collection) use ($maker) {
            return $collection->aggregate([
                [
                    '$lookup' => [
                        'from' => 'appliances',
                        'localField' => 'Appliances.ModelName',
                        'foreignField' => 'ModelName',
                        'as' => 'ApplianceDetails'
                    ]
                ],
                [
                    '$unwind' => [
                        'path' => '$ApplianceDetails',
                        'preserveNullAndEmptyArrays' => true // keeps the homes without matching appliances
                    ]
                ],
                [
                    '$match' => [
                        'ApplianceDetails.Maker' => $maker
                    ]
                ],
                [
                    '$group' => [ // Group the results back to the original home document structure
                        '_id' => '$_id',
                        'FloorSpace' => ['$first' => '$FloorSpace'],
                        'Floors' => ['$first' => '$Floors'],
                        'BedRooms' => ['$first' => '$BedRooms'],
                        'BathRooms' => ['$first' => '$BathRooms'],
                        'LandSize' => ['$first' => '$LandSize'],
                        'YearConstructed' => ['$first' => '$YearConstructed'],
                        'Type' => ['$first' => '$Type'],
                        'HomeID' => ['$first' => '$HomeID'],
                        'LocationId' => ['$first' => '$LocationId'],
                        'ApplianceDetails' => ['$push' => '$ApplianceDetails'] // Push appliances into an array
                    ]
                ],
                [
                    '$project' => [ // Project the final structure
                        'FloorSpace' => 1,
                        'Floors' => 1,
                        'BedRooms' => 1,
                        'BathRooms' => 1,
                        'LandSize' => 1,
                        'YearConstructed' => 1,
                        'Type' => 1,
                        'HomeID' => 1,
                        'LocationId' => 1,
                        'Appliances' => '$ApplianceDetails',
                        '_id' => 0
                    ]
                ],
                [
                    '$match' => [ // Ensure that only homes with the appliances are included
                        'Appliances' => [
                            '$not' => [
                                '$size' => 0
                            ]
                        ]
                    ]
                ]
            ]);
        });
    }

  
    public function get_unique_maker_list($attribute_name) {
       
        return self::raw(function($collection) use ($attribute_name) {
            return $collection->distinct($attribute_name);
        });
    }
    public function filterHomeListForCustomLocation($city,$owner, $minPrice, $bedrooms,$bathrooms, $status){
        // $locationIdsToString = $locationIds->map(function ($id) {
        //     return (string) $id;
        // });

        $pipeline = [];

        $pipeline[] = [
            '$lookup' => [
                'from' => 'locations', 
                'localField' => 'LocationId', 
                'foreignField' => '_id', 
                'as' => 'location' 
            ]
        ];
        $pipeline[] = [
            '$unwind' => [
                'path' => '$location',
                'preserveNullAndEmptyArrays' => true // Keep homes without a location
            ]
        ];
        // Match on city name if it's not all
        if ($city !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'location.City' => $city
                ]
            ];
        }
        // Filter on owner's name if provided
        if ($owner !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'OwnerId' => $owner
                ]
            ];
        }
        if ($minPrice > 0 ||$minPrice > '0') {
            $pipeline[] = [
                '$match' => [
                    'price' => [
                        '$ne' => '',
                        '$lt' => $minPrice
                    ]
                ]
            ];
        }
        if ($bedrooms !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'BedRooms' => $bedrooms
                ]
            ];
        }
        if ($bathrooms !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'BathRooms' => $bathrooms
                ]
            ];
        }
        if ($status !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'Status' => $status
                ]
            ];
        }
      
        return self::raw(function($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        });
    }
    public function filterHomeListForAll($owner, $minPrice, $bedrooms,$bathrooms, $status){
        $pipeline = [];

       
        // Filter on owner's name if provided
        if ($owner !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'OwnerId' => $owner
                ]
            ];
        }
        if ($minPrice > 0 ||$minPrice > '0') {
            $pipeline[] = [
                '$match' => [
                    'price' => [
                        '$ne' => '',
                        '$lt' => $minPrice
                    ]
                ]
            ];
        }
        if ($bedrooms !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'BedRooms' => $bedrooms
                ]
            ];
        }
        if ($bathrooms !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'BathRooms' => $bathrooms
                ]
            ];
        }
        if ($status !== 'all') {
            $pipeline[] = [
                '$match' => [
                    'Status' => $status
                ]
            ];
        }
      
        return self::raw(function($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        });
    }


    // public function getUsedHomes() {
    //     // Access the MongoDB collection through the raw method.
    //     return $this->raw(function($collection) {
    //         // Build the aggregation pipeline
    //         return $collection->aggregate([
    //             // First, perform a lookup to join with the sales histories collection.
    //             [
    //                 '$lookup' => [
    //                     'from' => 'saleshistories',
    //                     'localField' => '_id',
    //                     'foreignField' => 'HomeId',
    //                     'as' => 'SalesHistory'
    //                 ]
    //             ],
    //             // Unwind the SalesHistory for easier access.
    //             [
    //                 '$unwind' => [
    //                     'path' => '$SalesHistory',
    //                     'preserveNullAndEmptyArrays' => true
    //                 ]
    //             ],
    //             // Group by HomeId to count each HomeId occurrence.
    //             [
    //                 '$group' => [
    //                     '_id' => '$_id',
    //                     'count' => ['$sum' => 1],
    //                     'HomeDetails' => ['$first' => '$$ROOT']
    //                 ]
    //             ],
    //             // Filter out homes with a count less than 2 (sold once).
    //             [
    //                 '$match' => [
    //                     'count' => ['$gt' => 1]
    //                 ]
    //             ],
    //             // Perform a lookup to join with the locations collection.
    //             [
    //                 '$lookup' => [
    //                     'from' => 'locations',
    //                     'localField' => 'HomeDetails.LocationId',
    //                     'foreignField' => '_id',
    //                     'as' => 'LocationData'
    //                 ]
    //             ],
    //             // Unwind the LocationData for easier access.
    //             [
    //                 '$unwind' => [
    //                     'path' => '$LocationData',
    //                     'preserveNullAndEmptyArrays' => true
    //                 ]
    //             ],
    //             // Project the required fields.
    //             [
    //                 '$project' => [
    //                     'FloorSpace' => '$HomeDetails.FloorSpace',
    //                     'Floors' => '$HomeDetails.Floors',
    //                     'BedRooms' => '$HomeDetails.BedRooms',
    //                     'BathRooms' => '$HomeDetails.BathRooms',
    //                     'Street' => '$LocationData.Street',
    //                     'City' => '$LocationData.City',
    //                     'State' => '$LocationData.State',
    //                     'count' => 1,
    //                     '_id' => 0 // Exclude the _id field.
    //                 ]
    //             ]
    //         ]);
    //     });
    // }

    // Question 7	Find people who own apartments as well as mansions. 
    public function findowners($type1,$type2){
        return self::raw(function($collection) use ($type1,$type2) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$OwnerId',
                        'types' => ['$addToSet' => '$Type']
                    ]
                ],
                [
                    '$match' => [
                        'types' => ['$all' =>  [$type1, $type2]]
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'owners',
                        'let' => ['ownerId' => ['$toObjectId' => '$_id']],
                        'pipeline' => [
                            [
                                '$match' => [
                                    '$expr' => ['$eq' => ['$_id', '$$ownerId']]
                                ]
                            ]
                        ],
                        'as' => 'ownerInfo'
                    ]
                ],
                ['$unwind' => '$ownerInfo'],
                [
                    '$project' => [
                        '_id' => '$ownerInfo._id',
                        'Name' => '$ownerInfo.Name',
                        'SSN' => '$ownerInfo.SSN',
                        'Familymember' => '$ownerInfo.Familymember',
                        'Income' => '$ownerInfo.Income',
                        'Age' => '$ownerInfo.Age',
                        'Profession' => '$ownerInfo.Profession'
                    ]
                ]
            ]);
        });
    }
}
