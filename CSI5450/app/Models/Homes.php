<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Homes extends Eloquent
{
    use HasFactory;
    protected $fillable = [
        'floorSpace', 'floors', 'bedrooms', 'bathrooms',
        'landSize', 'yearConstructed', 'type', 'location_id'
    ];

    // Method to create a new Home
    public function createHome($data) {
        // Validation and business logic to set type based on criteria
        return Home::create($data);
    }

    // Method to retrieve a Home
    public function getHome($id) {
        return Home::find($id);
    }
    
    // Method to update a Home
    public function updateHome($id, $data) {
        $home = Home::find($id);
        // Business logic to enforce rules based on home type
        $home->update($data);
    }

    // Method to delete a Home
    public function deleteHome($id) {
        $home = Home::find($id);
        $home->delete();
    }
}
