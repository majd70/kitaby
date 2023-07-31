<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index(){
    $categories=Category::all();
    $profile = null;
    if (auth()->check()) {
        $profile = auth()->user()->profile;
    }
    return view('welcome',[
          'categories'=>$categories,
          'profile'=>$profile
    ]);
}
}
