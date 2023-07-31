<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User ;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'id' ,
        'user_id',
        'address' ,
        'phone' ,
        'bio' ,
        'image' ,
        'cover' ,
        'inetrests' 
    ];
    public function user()
    {
        return $this->belongsTo(User::class) ;
    }
}
