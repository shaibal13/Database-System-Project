<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId; //For native use

class Companies extends Eloquent
{
    use HasFactory;
    protected $fillable = ['Name','Address', 'Percentage'];

    public function getCompanies($id) {
        $objectId = new ObjectId($id);
        return self::raw(function($collection) use ($objectId) {
            return $collection->findOne(['_id' => $objectId]);
        });
       
    }
    public function getCompaniesDetails() {
        return self::raw(function($collection) {
            // The find method returns a cursor for the documents
            return $collection->find();
        });
    }
    public function addCompanies($data){
        return self::raw(function($collection) use ($data) {
            return $collection->insertOne($data);
        });
    }
    public function updateCompanies($id,$updateData){
        return self::raw(function($collection) use ($id, $updateData) {
            $objectId = new ObjectId($id); 
            return $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => $updateData]
            );
        });
    }
    public function updateCompaniesBYAddingNewAgent($id, $agent){

     
        return self::raw(function($collection) use ($id, $agent) {
            $objectId = new ObjectId($id);
    
            // Check and add each agent only if it's not already in the array
            foreach ($agent as $agentData) {
                $collection->updateOne(
                    ['_id' => $objectId, 'Agent.AgentId' => ['$ne' => $agentData['AgentId']]],
                    ['$push' => ['Agent' => $agentData]]
                );
            }
        });
    }
}
