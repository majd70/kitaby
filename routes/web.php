<?php

use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\GroupsController as AdminGroupsController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\Groups\GroupsController;
use App\Http\Controllers\Posts\PostsController;
use App\Http\Controllers\Posts\CommentsController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\CategoriesController as ControllersCategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    $profile = null;
    if (auth()->check()) {
        $profile = auth()->user()->profile;
    }
    return view('welcome')->with('profile', $profile);
})->name('home');
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/
require __DIR__ . '/auth.php';


Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('auth.socilaite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.socilaite.callback');

Route::get('/test', [TestLog::class, 'testuser'])->middleware('auth');
Route::get('/logout', [SocialLoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfilesController::class, 'index'])->name('profile');
    Route::get('/profile/{user}', [ProfilesController::class, 'show']);
    Route::get('/profile-info/{user}', [ProfilesController::class, 'show_info']);
    Route::post('/store/{profile}', [ProfilesController::class, 'store_image']);
    Route::post('/general-info/{profile}', [ProfilesController::class, 'general_info']);

});

Route::middleware(['auth'])->group(function () {
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories2.index');;
});

Route::middleware(['auth'])->group(function () {
    Route::get('/all-books/{category}', [GroupsController::class, 'index'])->name('all-books');
    Route::get('/book-page/{group}', [GroupsController::class, 'show'])->name('book-page');
    Route::get('/book-member/{group}', [GroupsController::class, 'member']);
    Route::get('/book-about/{group}', [GroupsController::class, 'about']);
    Route::post('/store', [GroupsController::class, 'store']);                     //create groups
    Route::post('/group/{group}/join/{role?}', [GroupsController::class, 'join']);
    Route::post('/group/{group}/leave', [GroupsController::class, 'leave']);

    Route::delete('/groups/{groupId}/members/{memberId}', [GroupsController::class, 'deleteMember'])->name('groups.members.delete');
    Route::post('/groups/{groupId}/members/{memberId}/make-admin', [GroupsController::class, 'makeAdmin'])
    ->name('groups.members.make-admin');
    Route::post('/group/{group}/leave-admin', [GroupsController::class, 'leaveAdmin'])->name('groups.leaveAdmin');
    Route::post('/group/{groupId}/report-user/{userId}', [GroupsController::class, 'reportUser'])->name('groups.users.report');
    Route::get('/search', [GroupsController::class, 'search'])->name('search');


});


Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
    Route::get('/post/{post}', [PostsController::class, 'show'])->name('posts.show');
    Route::get('/post/{post}/{group}', [PostsController::class, 'edit'])->name('posts.edit');

    Route::post('/post/{group}', [PostsController::class, 'store'])->name('posts.store');
    Route::put('/post/{post}', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('/post/{post}', [PostsController::class, 'destroy']);
    Route::post('/post/{post}/like', [PostsController::class, 'like'])->name('posts.like');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/comments/{post}', [CommentsController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{post}/{comment}', [CommentsController::class, 'destroy']);
});



Route::prefix('admin')->middleware('auth', 'auth.type:super-admin')->group(function () {
    Route::get('/categories', [AdminCategoriesController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/create', [AdminCategoriesController::class, 'create'])
        ->name('categories.create');

    Route::post('/categories', [AdminCategoriesController::class, 'store'])
        ->name('categories.store');

    Route::get('/categories/{id}', [AdminCategoriesController::class, 'show'])
        ->name('categories.show');

    Route::get('/categories/{id}/edit', [AdminCategoriesController::class, 'edit'])
        ->name('categories.edit');

    Route::put('/categories/{id}', [AdminCategoriesController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/{id}', [AdminCategoriesController::class, 'destroy'])
        ->name('categories.destroy');
});


Route::prefix('admin')->middleware('auth', 'auth.type:super-admin')->group(function () {
    Route::get('/groups', [AdminGroupsController::class, 'index'])
        ->name('groups.index');

    Route::delete('/groups/{id}', [AdminGroupsController::class, 'destroy'])
        ->name('groups.destroy');
});


Route::prefix('admin')->middleware('auth', 'auth.type:super-admin')->group(function () {
    Route::get('/users', [UsersController::class, 'index'])
        ->name('users.index');

    Route::delete('/users/{id}', [UsersController::class, 'destroy'])
        ->name('users.destroy');
});




Route::get('/about-us', function () {
    $profile = null;
    if (auth()->check()) {
        $profile = auth()->user()->profile;
    }
    return view('Nav.aboutus', compact('profile'));
})->name('aboutus');

Route::get('/contact-us', function () {
    return view('Nav.contactus');
})->name('contactus');



Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::get('/notifications/{id}', [NotificationsController::class, 'show'])->name('notifications.read');

});





// Route::get('auth/{provider}/user', [SocialController::class, 'index']);
