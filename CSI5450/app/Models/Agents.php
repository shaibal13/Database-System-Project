<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use MongoDB\Laravel\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\BSON\ObjectId; //For native use
class Agents extends Eloquent
{
    use HasFactory;
    protected $fillable = ['Name', 'dob','address', 'company','commission'];

    public function getAgents($id) {
        $objectId = new ObjectId($id);
        return self::raw(function($collection) use ($objectId) {
            return $collection->findOne(['_id' => $objectId]);
        });
       
    }
    public function getAgentsDetails() {
        return self::raw(function($collection) {
            // The find method returns a cursor for the documents
            return $collection->find();
        });
    }
    public function addAgents($data){
        return self::raw(function($collection) use ($data) {
            return $collection->insertOne($data);
        });
    }
    public function updateAgents($id,$updateData){
        return self::raw(function($collection) use ($id, $updateData) {
            $objectId = new ObjectId($id); 
            return $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => $updateData]
            );
        });
    }
    public function updateAgentsBYAddingNewCompanies($id, $company){

     
        return self::raw(function($collection) use ($id, $company) {
            $objectId = new ObjectId($id);
            $collection->updateOne(
                ['_id' => $objectId],
                ['$set' => ['company' => []]] 
            );
            
            foreach ($company as $companyData) {
                
                // print_r($agentData);
                $collection->updateOne(
                    ['_id' => $objectId, 'company.CompanyId' => ['$ne' => $companyData['CompanyId']]],
                    ['$push' => ['company' => $companyData]]
                );
            }
         
            // $collection->updateOne(
            //     ['_id' => $objectId],
            //     ['$pull' => ['company' => ['CompanyId' => ['$nin' => $company]]]]
            // );
        });
    }
}
