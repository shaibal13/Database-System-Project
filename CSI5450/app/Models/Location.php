<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Location extends Eloquent
{
    use HasFactory;
    protected $fillable = [
        'identificationNumber', 'addressLine1', 'addressLine2', 'city', 
        'zipCode', 'county', 'unitNumber'
    ];
}
