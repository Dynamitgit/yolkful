<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['post_id'] = $post->id;

        Comment::create($validated);

        return redirect()
            ->route('posts.show', $post->id)
            ->with('success', 'Comment added successfully!');
    }


    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        // Only the comment owner can delete it.
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'You are not authorized to delete this comment.');
        }

        $postId = $comment->post_id;

        $comment->delete();

        return redirect()
            ->route('posts.show', $postId)
            ->with('success', 'Comment deleted.');
    }
}
