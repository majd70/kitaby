<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ProfilesController extends Controller
{
    public function index()
    {
        $active = '1';
        $user = Auth::user();
        $profile_user = Profile::where('user_id', $user->id)->first();

        return view('Profiles.profile')->with(['user' => $user, 'profile' => $profile_user]);
    }
    public function show(User $user)
    {
        $active = '1';
        $profile_user = Profile::where('user_id', $user->id)->first();
        return view('Profiles.profile')->with(['user' => $user, 'profile' => $profile_user]);
    }
    public function store_image(Request $request, Profile $profile)
    {
        $user_name = Auth::user()->name;
        if ($request->hasFile('profilePhoto')) {
            $file = $request->file('profilePhoto');
            $fileName = time() . '_'  . $user_name . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('profile-images'), $fileName);
            $profile->image = $fileName;
            $profile->save();
            return redirect()->back();
        }
        if ($request->hasFile('profileCover')) {
            $file = $request->file('profileCover');
            $fileName = time() . '_'  . $user_name . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('profile-covers'), $fileName);
            $profile->cover = $fileName;
            $profile->save();
            return redirect()->back();
        }
    }

    public function show_info(User $user)
    {

        $profile_user = Profile::where('user_id', $user->id)->first();
        return view('Profiles.profile-info')->with(['user' => $user, 'profile' => $profile_user]);
    }


    public function general_info(Request $request, Profile $profile)
    {
        $validate = $request->validate([
            'bio' => 'required',
            'inetrests' => 'required',
        ]);
        $profile->bio = $request->bio;
        $profile->inetrests = $request->inetrests;

        $profile->save();
        return redirect('/profile');
    }



}
