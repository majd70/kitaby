<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $fillable=[
        'name','description','image_path'
       ];


       //model->image-url
    public function getImageUrlAttribute()
    {
        if(!$this->image_path){
            return asset('assets/images/placeholder-image.png');
        }

      /*  if(stripos($this->image_path,'http')===0){
            return $this->image_path;
        } //رابط خارجي
*/
        return asset('uploads/'.$this->image_path);
    }



    public function groups()
    {
        return $this->hasMany(Group::class);
    }

}
