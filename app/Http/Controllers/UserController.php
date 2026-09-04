<?php
namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the author's profile with their posts.
     */
    public function show(User $user)
    {
        $posts = $user->posts()
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('users.show', compact('user', 'posts'));
    }
}