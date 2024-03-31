<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId; //For native use
class Location extends Eloquent
{
    use HasFactory;
    protected $fillable = [
       'HomeID','LocationID', 'Street','City','State','County','Zip','Apt'
    ];
    public function getLocation($id) {
        $objectId = new ObjectId($id);
        return self::raw(function($collection) use ($objectId) {
            return $collection->findOne(['_id' => $objectId]);
        });
       
    }
    public function getLocationDetails() {
        return self::raw(function($collection) {
            // The find method returns a cursor for the documents
            return $collection->find();
        });
    }
    public function addLocation($data){
        return self::raw(function($collection) use ($data) {
            return $collection->insertOne($data);
        });
    }
    public function updateLocation($id,$updateData){
        return self::raw(function($collection) use ($id, $updateData) {
            $objectId = new ObjectId($id); 
            return $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => $updateData]
            );
        });
    }
}
