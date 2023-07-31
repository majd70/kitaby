<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use App\Models\Group;
use App\Models\Comment;
use App\Models\Profile;
use App\Notifications\likenotification;
use App\Notifications\postcreatednotification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostsController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;

        $posts = Post::all();
        $users = User::all();
        $profiles = Profile::all();

        return view('Books.book-page')
            ->with(['posts' => $posts, 'users' => $users, $profile => 'profile', 'profiles' => $profiles]);
    }


    public function show($id)
    {
        $post = Post::findOrFail($id);
        $profile = auth()->user()->profile;
        $users = User::all();
        $profiles = Profile::all();
        $group = Group::findOrFail($post->group_id);
        $userId = auth()->user()->id;

        return view('Post.show', [
            'post' => $post,
            'users' => $users,
            'profile' => $profile,
            'profiles' => $profiles,
            'group' => $group,
            'userId' => $userId
        ]);
    }


    public function store(Request $request, Group $group)
    {

        $request->validate([
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->group_id = $group->id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_path = $file->store('/', 'uploads'); // Use 'uploads' as the disk name
            $post->image = $image_path;
        }

        $post->save();

        // Send notification to group members
        $group->users()->where('users.id', '!=', $post->user_id)->each(function ($user) use ($post) {
            $user->notify(new postcreatednotification($post));
        });


        return redirect()->back();
    }

    /*
    public function update(Request $request, $post)
    {

        $request->validate([
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
        $post = Post::find($post);

        $post->update($request->all());

        return Redirect::route('book-page', ['group' => $post->group->id]);
    }
*/

    public function update(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::findOrFail($postId);
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_path = $file->store('/', 'uploads');
            $post->image = $image_path;
        }

        $post->save();

        return redirect()->route('book-page', ['group' => $post->group->id]);
    }

    public function destroy($post)
    {
        $post = Post::find($post);
        $post->delete();
        return redirect()->back();
    }

    /*
    public function like($post)
    {
        try {
            $posts = Post::findOrFail($post);
            $user = auth()->user();
            $group = Group::findOrFail($posts->group_id);

            if (!$group->users->contains($user->id)) {
                if (request()->ajax()) {
                    return response()->json(['error' => 'You are not in this group'], 403);
                } else {
                    return redirect()->back()->with('errors', 'You are not in this group');
                }
            }

            if (!$posts->likes()->where('user_id', $user->id)->exists()) {
                $posts->likes()->create([
                    'user_id' => $user->id,
                ]);
                $posts->increment('likes_count');


            } else {
                $posts->likes()->where('user_id', $user->id)->delete();
                $posts->decrement('likes_count');
            }

            if (request()->ajax()) {
                return response()->json([
                    'likes_count' => $posts->likes_count,
                    'post_id' => $posts->id, // Add the post_id to the response
                ]);
            } else {
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return response()->json(['error' => 'The post has not been liked']);
            } else {
                return redirect()->back()->with('errors', 'The post has not been liked');
            }
        }
    }
*/

    public function like($post)
    {
        try {
            $post = Post::findOrFail($post);
            $user = auth()->user();
            $group = Group::findOrFail($post->group_id);

            if (!$group->users->contains($user->id)) {
                if (request()->ajax()) {
                    return response()->json(['error' => 'You are not in this group'], 403);
                } else {
                    return redirect()->back()->with('errors', 'You are not in this group');
                }
            }

            if (!$post->likes()->where('user_id', $user->id)->exists()) {
                $post->likes()->create([
                    'user_id' => $user->id,
                ]);
                $post->increment('likes_count');

                $postMaker = $post->user;
                $authenticatedUser = auth()->user();

                if ($authenticatedUser && $postMaker->id !== $authenticatedUser->id) {
                    $postMaker->notify(new likenotification($user, $post));
                }
            } else {
                $post->likes()->where('user_id', $user->id)->delete();
                $post->decrement('likes_count');
            }

            if (request()->ajax()) {
                return response()->json([
                    'likes_count' => $post->likes_count,
                    'post_id' => $post->id,
                ]);
            } else {
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return response()->json(['error' => 'The post has not been liked'], 500);
            } else {
                return redirect()->back()->with('errors', 'The post has not been liked');
            }
        }
    }

    public function edit(Request $request, $post, $groupId)
    {
        $post = Post::findOrFail($post);
        $postContent = $post->content;
        $postImage = $post->image;
        $group = Group::find($groupId);
        $profile = auth()->user()->profile;

        return view('Post.edit', [
            'post' => $post,
            'postContent' => $postContent,
            'postImage' => $postImage,
            'group' => $group,
            'profile' => $profile,
        ]);
    }
}
