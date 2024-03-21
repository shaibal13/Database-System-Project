<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use MongoDB\Laravel\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Owners extends Eloquent
{
    use HasFactory;
    protected $fillable = ['Name', 'SSN','Familymember', 'Income','Age','Profession'];

}
