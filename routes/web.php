<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\StatusLikesController;
use App\Http\Controllers\UsersStatusController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\StatusCommentsController;
use App\Http\Controllers\AcceptFriendshipController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('statuses', [StatusController::class, 'index'])->name('statuses.index');
Route::post('statuses', [StatusController::class, 'store'])->name('statuses.store')->middleware('auth');
Route::post('statuses/{status}/likes', [StatusLikesController::class, 'store'])->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', [StatusLikesController::class, 'destroy'])->name('statuses.likes.destroy')->middleware('auth');
Route::post('statuses/{status}/comments', [StatusCommentsController::class, 'store'])->name('statuses.comments.store')->middleware('auth');
Route::post('comments/{comment}/likes', [CommentLikesController::class, 'store'])->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', [CommentLikesController::class, 'destroy'])->name('comments.likes.destroy')->middleware('auth');
Route::get('@{user}', [UserController::class, 'show'])->name('users.show');
Route::get('users/{user}/statuses', [UsersStatusController::class, 'index'])->name('users.statuses.index');
Route::post('friendships/{recipient}', [FriendshipController::class, 'store'])->name('friendships.store')->middleware('auth');
Route::delete('friendships/{recipient}', [FriendshipController::class, 'destroy'])->name('friendships.destroy')->middleware('auth');
Route::post('accept-friendships/{sender}', [AcceptFriendshipController::class, 'store'])->name('accept-friendships.store')->middleware('auth');
Route::delete('accept-friendships/{sender}', [AcceptFriendshipController::class, 'destroy'])->name('accept-friendships.destroy')->middleware('auth');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
