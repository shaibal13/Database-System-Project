<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId; //For native use

class Saleshistory extends Eloquent
{
    use HasFactory;
    protected $fillable = ['Agent', 'Company','HomeId', 'OwnerId','PreviousOwnerId','agentcommision'];
    public function addSalesHistory($data){
        return self::raw(function($collection) use ($data) {
            return $collection->insertOne($data);
        });
    }
    public function getSaleHistoryDetails() {
        return self::raw(function($collection) {
            // The find method returns a cursor for the documents
            return $collection->find();
        });
    }
    public function getCommission($agentId){
        return self::raw(function($collection) use ($agentId) {
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
    public function findThePreviousOwner($currentOwnerId,$homeId){
       // $homeId = new ObjectId($homeIds);
        return self::raw(function ($collection) use ($currentOwnerId,$homeId) {
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
}
