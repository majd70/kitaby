<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image' ,

    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users')->withTimestamps();
    }
    public function group_user()
    {
        return $this->hasMany(GroupUser::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
