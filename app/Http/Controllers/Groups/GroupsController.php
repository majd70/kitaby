<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Profile;
use App\Notifications\adminmakernotification;
use Illuminate\Support\Facades\Redirect;

class GroupsController extends Controller
{
    public function index($id)
    {
        $category = Category::FindOrFail($id);
        $groups = $category->groups;
        $profile = auth()->user()->profile;
        $profiles = Profile::all();
        return view('Groups.index')
            ->with(['groups' => $groups, 'profile' => $profile, 'profiles' => $profiles, 'category' => $category]);
    }

    public function show(Group $group)
    {
        $userId = auth()->user()->id;
        $posts = $group->posts;
        $users = $group->users;
        $profile = auth()->user()->profile;
        $profiles = Profile::all();
        return view('Books.book-page')
            ->with([
                'posts' => $posts,
                'users' => $users,
                'group' => $group,
                'profile' => $profile,
                'profiles' => $profiles,
                'userId'=> $userId
            ]);
    }
/*
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:1024',
            'description' => 'required|max:1024',
            'image' => 'image|max:1999'
        ]);

        if ($request->hasFile('image')) {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('image')->move(public_path('images'), $fileNameToStore);
        } else {
            $fileNameToStore = $request->file('image');
        }

        $group = new Group;

        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->category_id = $request->input('category_id');
        $group->image = $fileNameToStore;
        $group->save();
        $this->join($request, $group->id, 'admin'); //

        $groups = Group::all();

        return redirect('show')->with('groups', $groups);
    }
*/
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'image' => 'image'
    ]);

    try {
        if ($request->hasFile('image')) {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('image')->move(public_path('images'), $fileNameToStore);
        } else {
            $fileNameToStore = $request->file('image');
        }

        $group = new Group;
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->category_id = $request->input('category_id');
        $group->image = $fileNameToStore;
        $group->save();
        $this->join($request, $group->id, 'admin'); //

        $groups = Group::all();

        return redirect('show')->with('groups', $groups);
    } catch (\Exception $e) {
        // Handle the error
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to store the data. Please try again.']);
    }
}

    public function join(Request $request, $group, $role = null)
    {
        try {

            $group = Group::findOrFail($group);
            $user = auth()->user();
            if ($group->users->contains($user->id)) {
                return response()->json(['data' => 'You are already in this group'], 403);
            }
            $groupUser = new GroupUser();
            $groupUser->user_id = $user->id;
            $groupUser->group_id = $group->id;
            if (!$role) {
                $groupUser->group_user_role = 'member';
            } else {
                $groupUser->group_user_role = $role;
            }
            $groupUser->save();
            // return response()->json(['data' => 'You have joined the group'], 200);
            return redirect()->back();
        } catch (\Throwable $th) {
            // return response()->json(['data' => 'Group not found'], 404);
            return $th;
        }
    }

    /*
    public function leave(Request $request, $group)
    {
        try {
            $group = Group::findOrFail($group);
            $user = auth()->user();
            $groupUser = GroupUser::where('user_id', $user->id)->where('group_id', $group->id)->first();
            if (!$groupUser) {
                return response()->json(['data' => 'You are not in this group'], 403);
            }

            // Check if the leaving member is the admin
            $isAdmin = $groupUser->group_user_role === 'admin';

            $groupUser->delete();

            if ($isAdmin) {
                // Find the oldest member in the group
                $oldestMember = $group->users()->orderBy('created_at')->first();

                if ($oldestMember) {
                    // Retrieve the GroupUser record for the oldest member
                    $oldestMemberGroupUser = GroupUser::where('user_id', $oldestMember->id)
                        ->where('group_id', $group->id)
                        ->first();

                    if ($oldestMemberGroupUser) {
                        // Assign the admin role to the oldest member
                        $oldestMemberGroupUser->group_user_role = 'admin';
                        $oldestMemberGroupUser->save();
                    }
                }
            }

            // Deleting the posts, comments, and likes of the leaving user
            $group->posts()->where('user_id', $user->id)->delete();
            $group->posts()->each(function ($post) use ($user) {
                $post->comments()->where('user_id', $user->id)->delete();
                $post->likes()->where('user_id', $user->id)->delete();
            });

            return redirect()->back();
        } catch (\Throwable $th) {
            return response()->json(['data' => "errors"], 404);
        }
    }
    */

    public function leave(Request $request, $group)
{
    try {
        $group = Group::findOrFail($group);
        $user = auth()->user();
        $groupUser = GroupUser::where('user_id', $user->id)->where('group_id', $group->id)->first();
        if (!$groupUser) {
            return response()->json(['data' => 'You are not in this group'], 403);
        }

        // Check if the leaving member is the admin
        $isAdmin = $groupUser->group_user_role === 'admin';

        $groupUser->delete();

        // Check if the leaving member is the last member in the group
        if ($group->users()->count() === 0) {
            // Deleting the posts, comments, and likes of the leaving user
            $group->posts()->where('user_id', $user->id)->delete();
            $group->posts()->each(function ($post) use ($user) {
                $post->comments()->where('user_id', $user->id)->delete();
                $post->likes()->where('user_id', $user->id)->delete();
            });

            // Delete the group
            $group->delete();
            return Redirect::route('all-books', ['category' => $group->category]);

        } elseif ($isAdmin) {
            // Find the oldest member in the group
            $oldestMember = $group->users()->orderBy('created_at')->first();

            if ($oldestMember) {
                // Retrieve the GroupUser record for the oldest member
                $oldestMemberGroupUser = GroupUser::where('user_id', $oldestMember->id)
                    ->where('group_id', $group->id)
                    ->first();

                if ($oldestMemberGroupUser) {
                    // Assign the admin role to the oldest member
                    $oldestMemberGroupUser->group_user_role = 'admin';
                    $oldestMemberGroupUser->save();
                }
            }
        }

        return redirect()->back();
    } catch (\Throwable $th) {
        return response()->json(['data' => 'errors'], 404);
    }
}


/*
    public function member(Group $group)
    {
        $users = $group->users;
        $group_users = GroupUser::where('group_id', $group->id)->get();
        $members = $group_users->where('group_user_role', 'member');
        $members_name = [];
        foreach ($members as $member) {
            $member_name = User::where('id', $member->user_id)->first();
            array_push($members_name, $member_name);
        }
        $admins = $group_users->where('group_user_role', 'admin');
        $admins_name = [];
        foreach ($admins as $admin) {
            $admin_name = User::where('id', $admin->user_id)->first();
            array_push($admins_name, $admin_name);
        }
        $number_of_users = $group->users->count();
        $profiles = Profile::all();
        // return response()->json(['data' => $admins_name], 202);
        $profile = auth()->user()->profile;


        // Check if the current user is an admin of the group
        $currentUserId = auth()->user()->id;
        $isGroupAdmin = $group_users->where('user_id', $currentUserId)->where('group_user_role', 'admin')->isNotEmpty();


        return view('books.book-member')
            ->with([
                'admins_name' => $admins_name, 'group' => $group,
                'members_name' => $members_name,
                'number_of_users' => $number_of_users,
                'profile' => $profile,
                'profiles' => $profiles,
                'isGroupAdmin' => $isGroupAdmin,
                'currentUserId' =>  $currentUserId,


            ]);
    }

    */

    public function member(Group $group)
    {
        $users = $group->users;
        $group_users = GroupUser::where('group_id', $group->id)->get();
        $members = $group_users->where('group_user_role', 'member');
        $members_name = [];
        foreach ($members as $member) {
            $member_name = User::where('id', $member->user_id)->first();
            $member_name->report_count = $member->report_count; // Add the report_count to the member object

            array_push($members_name, $member_name);
        }
        $admins = $group_users->where('group_user_role', 'admin');
        $admins_name = [];
        foreach ($admins as $admin) {
            $admin_name = User::where('id', $admin->user_id)->first();
            array_push($admins_name, $admin_name);
        }
        $number_of_users = $group->users->count();
        $profiles = Profile::all();
        // return response()->json(['data' => $admins_name], 202);
        $profile = auth()->user()->profile;


        // Check if the current user is an admin of the group
        $currentUserId = auth()->user()->id;
        $isGroupAdmin = $group_users->where('user_id', $currentUserId)->where('group_user_role', 'admin')->isNotEmpty();


        return view('books.book-member')
            ->with([
                'admins_name' => $admins_name,
                'group' => $group,
                'members_name' => $members_name,
                'number_of_users' => $number_of_users,
                'profile' => $profile,
                'profiles' => $profiles,
                'isGroupAdmin' => $isGroupAdmin,
                'currentUserId' =>  $currentUserId,


            ]);
    }


    public function about(Group $group)
    {
        $group_users = GroupUser::where('group_id', $group->id)->get();

        $admins = $group_users->where('group_user_role', 'admin');
        $admins_name = [];
        foreach ($admins as $admin) {
            $admin_name = User::where('id', $admin->user_id)->first();
            array_push($admins_name, $admin_name);
        }
        $number_of_members = $group->users->count();
        $users = $group->users;
        $profile = auth()->user()->profile;
        $profiles = Profile::all();
        return view('books.book-about')
            ->with([
                'group' => $group, 'users' => $users,
                'admins_name' => $admins_name,
                'members' => $number_of_members,
                'profile' => $profile,
                'profiles' => $profiles
            ]);
    }


    public function deleteMember($groupId, $memberId)
    {
        // Retrieve the group
        $group = Group::find($groupId);



        // Find the group user record for the member
        $groupUser = GroupUser::where('group_id', $group->id)->where('user_id', $memberId)->first();

        if ($groupUser) {
            // Delete the group user record
            $groupUser->delete();



            // Return a response, such as a success or error message
            return redirect()->back();
        }

        // Return an error response if the group user record was not found
        return response()->json(['message' => 'Group user record not found'], 404);
    }




    public function makeAdmin($groupId, $memberId)
    {
        $group = Group::findOrFail($groupId);
        $member = GroupUser::where('group_id', $group->id)
            ->where('user_id', $memberId)
            ->first();

        if (!$member) {
            return response()->json(['data' => 'Member not found'], 404);
        }

        $member->group_user_role = 'admin';
        $member->save();

        // Notify the user about being made an admin
    $user = $member->user;
    $user->notify(new adminmakernotification($group));

        return redirect()->back()->with('success', 'Member successfully made an admin');
    }


    /*
    public function leaveAdmin($group)
{
    try {
        $group = Group::findOrFail($group);
        $user = auth()->user();
        $groupUser = GroupUser::where('user_id', $user->id)->where('group_id', $group->id)->first();

        if (!$groupUser) {
            return response()->json(['data' => 'You are not in this group'], 403);
        }

        $groupUser->group_user_role = 'member'; // Set the user's role to 'member'
        $groupUser->save();

        return redirect()->back();
    } catch (\Throwable $th) {
        return response()->json(['data' => "errors"], 404);
    }
}
*/

public function leaveAdmin($group)
{
    try {
        $group = Group::findOrFail($group);
        $user = auth()->user();
        $groupUser = GroupUser::where('user_id', $user->id)->where('group_id', $group->id)->first();

        if (!$groupUser) {
            return response()->json(['data' => 'You are not in this group'], 403);
        }

        if ($groupUser->group_user_role === 'admin') {
            $adminsCount = GroupUser::where('group_id', $group->id)->where('group_user_role', 'admin')->count();
            if ($adminsCount <= 1) {
                return redirect()->back()->with('alert', 'الرجاء اختيار مشرف جديد');
            }
        }

        $groupUser->group_user_role = 'member'; // Set the user's role to 'member'
        $groupUser->save();

        return redirect()->back();
    } catch (\Throwable $th) {
        return response()->json(['data' => 'errors'], 404);
    }
}


public function reportUser($groupId, $userId)
{
    try {
        // Find the group user record
        $groupUser = GroupUser::where('group_id', $groupId)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Increment the report count
        $groupUser->report_count = $groupUser->report_count + 1;
        $groupUser->save();

        return redirect()->back()->with('success', 'User reported successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to report the user.');
    }
}

public function search(Request $request)
{
    $query = $request->input('query');
    $categoryId = $request->input('category_id');

    $groups = Group::where('name', 'like', '%' . $query . '%')
                   ->where('category_id', $categoryId)
                   ->whereRaw('LENGTH(name) - LENGTH(REPLACE(name, "'.$query.'", "")) >= 3')
                   ->get();

    $profile = auth()->user()->profile;

    return view('Groups.search_results', compact('groups', 'query', 'profile'));
}


}
