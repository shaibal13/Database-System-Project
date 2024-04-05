<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId; //For native use

class Saleshistory extends Eloquent
{
    use HasFactory;
    protected $fillable = ['Agent', 'Company', 'HomeId', 'OwnerId', 'PreviousOwnerId', 'agentcommision'];
    public function addSalesHistory($data)
    {
        return self::raw(function ($collection) use ($data) {
            return $collection->insertOne($data);
        });
    }
    public function getSaleHistoryDetails()
    {
        return self::raw(function ($collection) {
            // The find method returns a cursor for the documents
            return $collection->find();
        });
    }
    public function getCommission($agentId)
    {
        return self::raw(function ($collection) use ($agentId) {
            $result = $collection->aggregate([
                [
                    '$match' => [
                        'Agent' => $agentId
                    ]
                ],
                [
                    '$group' => [
                        '_id' => "$agentId",
                        'totalCommission' => [
                            '$sum' => '$agentcommision'
                        ]
                    ]
                ]
            ])->toArray();

            return $result[0]['totalCommission'] ?? 0;
        });
    }
    public function findThePreviousOwner($currentOwnerId, $homeId)
    {
        // $homeId = new ObjectId($homeIds);
        return self::raw(function ($collection) use ($currentOwnerId, $homeId) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'HomeId' => $homeId,
                        // exclude null because first sale and mathc with previous owner
                        '$and' => [
                            [
                                'PreviousOwnerId' => [

                                    '$ne' => null,
                                ],
                            ],
                            [
                                'PreviousOwnerId' => [
                                    '$ne' => $currentOwnerId,
                                ],
                            ],
                        ],
                    ]
                ],
                [
                    // Group to deduplicate PreviousOwnerIds
                    '$group' => [
                        '_id' => null, // Grouping without a specific field to aggregate unique PreviousOwnerIds
                        'uniquePreviousOwners' => ['$addToSet' => '$PreviousOwnerId'], // Collect unique PreviousOwnerIds
                    ]
                ],
                //flatten
                [
                    '$unwind' => '$uniquePreviousOwners', // Unwind the array for further processing
                ],
                //convert to object id to match in owner table
                [
                    '$addFields' => [
                        'uniquePreviousOwnersObjectId' => ['$toObjectId' => '$uniquePreviousOwners'],
                    ]
                ],
                //join
                [
                    // Fetch owner details for each PreviousOwnerId
                    '$lookup' => [
                        'from' => 'owners',
                        'localField' => 'uniquePreviousOwnersObjectId',
                        'foreignField' => '_id',
                        'as' => 'ownerDetails'
                    ]
                ],
                [
                    '$unwind' => [
                        'path' => '$ownerDetails',
                        'preserveNullAndEmptyArrays' => false // Remove items that did not match in lookup
                    ]
                ],
                [
                    // Project to format the output
                    '$project' => [
                        '_id' => 0,
                        'ownerDetails' => 1
                    ]
                ]
            ]);
        });
    }
    // public function getHomesSoldMoreThanOnce()
    // {
    //     return $this->raw(function ($collection) {
    //         // The aggregation pipeline to find homes sold more than once
    //         $pipeline = [
    //             [
    //                 '$group' => [
    //                     '_id' => '$HomeId', // Group by HomeId
    //                     'count' => ['$sum' => 1], // Count the number of sales for each HomeId
    //                     'lastSale' => ['$last' => '$$ROOT'] // Get the last sale document
    //                 ]
    //             ],
    //             [
    //                 '$match' => [
    //                     'count' => ['$gt' => 1] // Only consider documents where count is greater than 1
    //                 ]
    //             ],
    //             [
    //                 '$lookup' => [
    //                     'from' => 'homes',
    //                     'localField' => '_id',
    //                     'foreignField' => '_id',
    //                     'as' => 'homeDetails'
    //                 ]
    //             ],
    //             [
    //                 '$unwind' => [
    //                     'path' => '$homeDetails',
    //                     'preserveNullAndEmptyArrays' => true // Preserve documents that do not match
    //                 ]
    //             ],
    //             [
    //                 '$lookup' => [
    //                     'from' => 'locations',
    //                     'localField' => 'homeDetails.LocationId',
    //                     'foreignField' => '_id',
    //                     'as' => 'locationDetails'
    //                 ]
    //             ],
    //             [
    //                 '$unwind' => [
    //                     'path' => '$locationDetails',
    //                     'preserveNullAndEmptyArrays' => true // Preserve documents that do not match
    //                 ]
    //             ],
    //             [
    //                 '$project' => [
    //                     'FloorSpace' => '$homeDetails.FloorSpace',
    //                     'Floors' => '$homeDetails.Floors',
    //                     'BedRooms' => '$homeDetails.BedRooms',
    //                     'BathRooms' => '$homeDetails.BathRooms',
    //                     'Street' => '$locationDetails.Street',
    //                     'City' => '$locationDetails.City',
    //                     'State' => '$locationDetails.State',
    //                     'SalesCount' => '$count',
    //                     '_id' => 0 // Exclude the _id field
    //                 ]
    //             ]
    //         ];


    //         return $collection->aggregate($pipeline);
    //     });
    // }

    public function findMostExpensiveHome($ownerId) {
        $result = self::raw(function($collection) use ($ownerId) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'OwnerId' => $ownerId // 
                    ]
                ],
                [
                    '$sort' => [
                        'price' => -1 // 
                    ]
                ],
                [
                    '$limit' => 1 // 
                ],
                [
                    '$project' => [ // 
                        'HomeId' => 1, // 
                        'price' => 1, // 
                        '_id' => 0, // 
                    ]
                ]
            ]);
        });
    
        return $result;
    }

    
    public function getHomesSoldMoreThanOnce()
{
    return $this->raw(function ($collection) {
        // Define the aggregation pipeline
        $pipeline = [
            [
                '$group' => [
                    '_id' => ['$toObjectId' => '$HomeId'], // Convert HomeId to ObjectId before grouping
                    'count' => ['$sum' => 1],
                    'lastSale' => ['$last' => '$$ROOT']
                ]
            ],
            [
                '$match' => [
                    'count' => ['$gt' => 1]
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'homes',
                    'localField' => '_id',
                    'foreignField' => '_id',
                    'as' => 'homeDetails'
                ]
            ],
            [
                '$unwind' => [
                    'path' => '$homeDetails',
                    'preserveNullAndEmptyArrays' => true
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'locations',
                    'localField' => 'homeDetails.LocationId',
                    'foreignField' => '_id',
                    'as' => 'locationDetails'
                ]
            ],
            [
                '$unwind' => [
                    'path' => '$locationDetails',
                    'preserveNullAndEmptyArrays' => true
                ]
            ],
            [
                '$project' => [
                    'FloorSpace' => '$homeDetails.FloorSpace',
                    'Floors' => '$homeDetails.Floors',
                    'BedRooms' => '$homeDetails.BedRooms',
                    'BathRooms' => '$homeDetails.BathRooms',
                    'Street' => '$locationDetails.Street',
                    'City' => '$locationDetails.City',
                    'State' => '$locationDetails.State',
                    'SalesCount' => '$count',
                    '_id' => 0
                ]
            ]
        ];

        // Execute the aggregation pipeline
        return $collection->aggregate($pipeline);
    });
}

}
