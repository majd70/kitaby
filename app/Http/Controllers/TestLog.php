<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestLog extends Controller
{
    public function testuser(){
            $userinfo=[];
            $name=Auth::user()->name;
            $email=Auth::user()->email;
            $id=Auth::user()->id;
            $userinfo=[
                'id'=>$id,
               'name'=>$name,
               'email'=>$email
            ];
            dd($userinfo);
    }
}
