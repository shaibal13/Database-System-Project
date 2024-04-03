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

    public function getHomesSoldMoreThanOnce() {
        return $this->raw(function($collection) {
            // The aggregation pipeline to find homes sold more than once
            $pipeline = [
                [
                    '$group' => [
                        '_id' => '$HomeId', // Group by HomeId
                        'count' => ['$sum' => 1], // Count the number of sales for each HomeId
                        'lastSale' => ['$last' => '$$ROOT'] // Get the last sale document
                    ]
                ],
                [
                    '$match' => [
                        'count' => ['$gt' => 1] // Only consider documents where count is greater than 1
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
                    '$unwind' => '$homeDetails' // Unwind the results from the lookup
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
                    '$unwind' => '$locationDetails' // Unwind the results from the lookup
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
                        '_id' => 0 // Exclude the _id field
                    ]
                ]
            ];
    
            return $collection->aggregate($pipeline);
        });
    }
    
}
