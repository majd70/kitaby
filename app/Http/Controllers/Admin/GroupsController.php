<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = Group::latest()->get();
        $profile = auth()->user()->profile;
        return view('admin.groups.index', [
            'groups' => $groups,
            'profile'=>$profile
        ]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect(route('groups.index'))
            ->with('success', 'تم حذف المجموعة');
    }
}


