<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | Registered user
        |--------------------------------------------------------------------------
        */
        if (auth()->check()) {
            $userId = auth()->id();

            $like = DB::table('likes')
                ->where('post_id', $post->id)
                ->where('user_id', $userId)
                ->first();

            if ($like) {
                DB::table('likes')
                    ->where('id', $like->id)
                    ->delete();
            } else {
                DB::table('likes')->insert([
                    'user_id' => $userId,
                    'guest_token' => null,
                    'post_id' => $post->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return back();
        }

        /*
        |--------------------------------------------------------------------------
        | Guest user
        |--------------------------------------------------------------------------
        */

        $guestToken = request()->cookie('yolkful_guest_token');

        if (!$guestToken) {
            $guestToken = Str::random(64);

            Cookie::queue(
                'yolkful_guest_token',
                $guestToken,
                60 * 24 * 365
            );
        }

        $like = DB::table('likes')
            ->where('post_id', $post->id)
            ->where('guest_token', $guestToken)
            ->first();

        if ($like) {
            DB::table('likes')
                ->where('id', $like->id)
                ->delete();
        } else {
            DB::table('likes')->insert([
                'user_id' => null,
                'guest_token' => $guestToken,
                'post_id' => $post->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back();
    }
}