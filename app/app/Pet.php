<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name', 'gender', 'birthday', 'species', 'breed'
    ];
}
