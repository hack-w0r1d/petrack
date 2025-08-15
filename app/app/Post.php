<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Tag;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
