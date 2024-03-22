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
    // Method to delete a Home
    public function deleteHome($id) {
        $home = self::find($id);
        $home->delete();
    }
}
