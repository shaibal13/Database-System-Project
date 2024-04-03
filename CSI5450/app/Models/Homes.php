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

    public function findThePreviousOwner($homeId){
        return self::raw(function($collection) use ($homeId) {
            $objectId = new ObjectId($homeId); 

            return $collection->aggregate([
                [
                    '$match' => [
                        'HomeId' => $objectId,
                        // Ensure the document fetched does not represent a current ownership transfer
                        '$expr' => [
                            '$ne' => ['$PreviousOwnerId', '$OwnerId']
                        ]
                    ],
                ],
                [
                    '$lookup' => [
                        // Join with the 'owners' collection to get previous owner details
                        'from' => 'owners',
                        'localField' => 'PreviousOwnerId',
                        'foreignField' => '_id',
                        'as' => 'PreviousOwnerDetails'
                    ]
                ],
                [
                    '$unwind' => [
                        
                        'path' => '$PreviousOwnerDetails',
                        'preserveNullAndEmptyArrays' => true // Handle cases where there's no previous owner
                    ]
                ],
                [
                    '$project' => [
                        'PreviousOwnerDetails' => 1,
                    ]
                ],
                [
                    '$match' => [
                        'PreviousOwnerDetails' => [
                            '$ne' => null
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
}
