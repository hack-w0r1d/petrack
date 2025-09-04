<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Pet;
use App\Tag;
use App\Like;
use App\Comment;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'pet_id', 'image_path', 'caption'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            if ($post->isForceDeleting() && $post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
        });
    }

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

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
