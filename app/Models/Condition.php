<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'main', 'priority', 'comment'];

}
