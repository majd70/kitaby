<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Group;
use App\Models\User;
use App\Notifications\commentcreatednotification;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(Request $request, $post)
    {

        $validatedData = $request->validate([
            'content' => 'required',
        ]);
        $comment = new Comment($validatedData);
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post;
        $comment->save();

        // Retrieve the user and post information
        $comment->load('user.profile', 'post');

        // Notify the post maker about the new comment
        $postMaker = $comment->post->user;
        $authenticatedUser = auth()->user();

        if ($authenticatedUser && $postMaker->id !== $authenticatedUser->id) {
            $postMaker->notify(new commentcreatednotification($comment));
        }


        return response()->json(['comment' => $comment->toArray()]);
    }
    public function destroy($post, $comment)
    {
        $comment = Comment::find($comment);
        $comment->delete();
        // return redirect()->back();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
