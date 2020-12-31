<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'main', 'priority', 'comment'];
}
