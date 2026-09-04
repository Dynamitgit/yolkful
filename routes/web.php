<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
| These pages are accessible without an account.
*/


// Home
Route::get('/', [PostController::class, 'home']);


// Public recipes
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');


// Public users
Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('users.show');


// RSS
Route::get('/rss', [PostController::class, 'rss'])
    ->name('posts.rss');


// Public tags
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])
    ->name('tags.show');


// Public collections
Route::get('/collections/{collection:slug}', [CollectionController::class, 'show'])
    ->name('collections.show');


// About
Route::view('/about', 'about')
    ->name('about');


// Search suggestions
Route::get('/search/suggestions', [PostController::class, 'suggestions'])
    ->name('search.suggestions');



/*
|--------------------------------------------------------------------------
| AUTHENTICATED + VERIFIED USER ROUTES
|--------------------------------------------------------------------------
| These actions require the user to be logged in AND
| have a verified email address.
*/


Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Create / Edit / Delete Recipes
    |--------------------------------------------------------------------------
    */

    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::patch('/posts/{post}', [PostController::class, 'update']);

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');


    /*
    |--------------------------------------------------------------------------
    | Likes
    |--------------------------------------------------------------------------
    */

    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
        ->name('posts.like');


    /*
    |--------------------------------------------------------------------------
    | Comments
    |--------------------------------------------------------------------------
    */

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
| Login, Register, Password Reset, Email Verification, Logout...
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| LANDING PAGES
|--------------------------------------------------------------------------
| Keep this route at the very bottom because it contains
| a dynamic slug.
|--------------------------------------------------------------------------
*/

Route::get('/{landingPage:slug}', [LandingPageController::class, 'show'])
    ->name('landing-pages.show');