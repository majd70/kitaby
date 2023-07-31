<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;
class GroupUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'user_id',
        'group_user_role',
        'report_count'
    ];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
