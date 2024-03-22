<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Appliances extends Eloquent
{
    use HasFactory;
    protected $fillable = ['ModelName', 'Year','Maker', 'Name','Price'];
}
