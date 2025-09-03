<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Pet;
use App\Tag;
use App\Comment;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'pet_id', 'image_path', 'caption'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet() {
        return $this->belongsTo(Pet::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
