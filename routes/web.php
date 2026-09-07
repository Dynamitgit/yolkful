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
use App\Models\Post;
use App\Models\Tag;
use App\Models\Collection;
use App\Models\LandingPage;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [PostController::class, 'home']);


// Public recipes list
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');


// Search suggestions
Route::get('/search/suggestions', [PostController::class, 'suggestions'])
    ->name('search.suggestions');


// RSS
Route::get('/rss', [PostController::class, 'rss'])
    ->name('posts.rss');


// About
Route::view('/about', 'about')
    ->name('about');


// Public users
Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('users.show');


// Public tags
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])
    ->name('tags.show');


// Public collections
Route::get('/collections/{collection:slug}', [CollectionController::class, 'show'])
    ->name('collections.show');


// XML Sitemap
Route::get('/sitemap.xml', function () {
    $posts = Post::where('status', 'published')
        ->whereNotNull('slug')
        ->latest('updated_at')
        ->get();

    $tags = Tag::whereNotNull('slug')->get();

    $collections = Collection::whereNotNull('slug')->get();

    $landingPages = LandingPage::whereNotNull('slug')->get();

    return response()
        ->view('sitemap', compact(
            'posts',
            'tags',
            'collections',
            'landingPages'
        ))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

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
    | Create Recipe
    |--------------------------------------------------------------------------
    */

    // IMPORTANT: this must be before /posts/{post}
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');


    /*
    |--------------------------------------------------------------------------
    | Store Recipe
    |--------------------------------------------------------------------------
    */

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');


    /*
    |--------------------------------------------------------------------------
    | Edit Recipe
    |--------------------------------------------------------------------------
    */

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');


    /*
    |--------------------------------------------------------------------------
    | Update Recipe
    |--------------------------------------------------------------------------
    */

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::patch('/posts/{post}', [PostController::class, 'update']);


    /*
    |--------------------------------------------------------------------------
    | Delete Recipe
    |--------------------------------------------------------------------------
    */

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');


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
| PUBLIC POST ROUTES
|--------------------------------------------------------------------------
*/

// Public likes
Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
    ->name('posts.like');


// SEO-friendly recipe URL using the post slug
Route::get('/posts/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');



/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| LANDING PAGES
|--------------------------------------------------------------------------
*/

// Keep this at the very bottom because it contains a dynamic slug.
Route::get('/{landingPage:slug}', [LandingPageController::class, 'show'])
    ->name('landing-pages.show');