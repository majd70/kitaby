<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Notifications\categorycreatednotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CategoriesController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile ;
        $categories=Category::all();

        return view('Categories.index',[
            'profile'=>$profile,
            'categories'=>$categories,
        ]);
}
}
