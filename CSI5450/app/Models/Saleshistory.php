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
}
