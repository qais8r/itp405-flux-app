<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Make sure User model is imported

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'caption',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Check if the post is favorited by a specific user.
     *
     * @param User $user
     * @return bool
     */
    public function isFavoritedBy(User $user): bool
    {
        // Check if the user's ID exists in the collection of users who favorited this post
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }
}