<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/message', [MessageController::class, 'store']);


Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
Route::get('/get-users', [UserController::class, 'getUsers'])->name('get.users');
Route::get('/user-chat/{user}', [ChatController::class, 'getChatHistory'])->name('user.chat');
Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');

Route::get('/test/echo-demo', function () {
    return view('Test.echo-demo');
})->name('echo.demo');


require __DIR__.'/auth.php';

