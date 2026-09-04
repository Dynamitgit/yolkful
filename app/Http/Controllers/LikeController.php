<?php
namespace App\Http\Controllers;
use App\Models\Post;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($post->likedBy->contains($user->id)) {
            $post->likedBy()->detach($user->id);
        } else {
            $post->likedBy()->attach($user->id);
        }

        return back();
    }
}