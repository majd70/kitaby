<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;
use App\Models\Group;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'user_id',
        'likes_count',
        'image',
    ];




    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    /*
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    */

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
