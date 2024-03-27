<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId; //For native use
class Appliances extends Eloquent
{
    use HasFactory;
    protected $fillable = ['ModelName', 'Year','Maker', 'Name','Price'];
    //get by id
    public function getAppliances($id) {
        $objectId = new ObjectId($id);
        return self::raw(function($collection) use ($objectId) {
            return $collection->findOne(['_id' => $objectId]);
        });
       
    }
    // get all appliances
    public function getAppliancesDetails() {
        return self::raw(function($collection) {
            // The find method returns a cursor for the documents
            return $collection->find();
        });
    }
    // Add
    public function addAppliances($data){
        return self::raw(function($collection) use ($data) {
            return $collection->insertOne($data);
        });
    }
    //APpliances update
    public function updateAppliances($id,$updateData){
        
        return self::raw(function($collection) use ($id, $updateData) {
            $objectId = new ObjectId($id); 
            return $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => $updateData]
            );
        });
    }
    // Unique name of the maker
    public function get_unique_maker_list() {
       
        return self::raw(function($collection) {
            return $collection->distinct('Maker');
        });
    }
  
}
