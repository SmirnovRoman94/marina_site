<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Models\User;
use \Nette\Schema\ValidationException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me']);

    Route::group(['middleware' => 'jwt.auth'], function (){
        Route::get('/user', [\App\Http\Controllers\User\UserController::class, 'index'])->name('user.index');

        Route::post('/comments', [\App\Http\Controllers\Comment\CommentController::class, 'store'])->name('comment.store');

        // Здесь находятся маршруты, доступные только для администраторов
        Route::group(['middleware' => 'admin'], function () {
            //ROSTS
            Route::post('/posts', [\App\Http\Controllers\Post\PostController::class, 'store'])->name('post.store');
            Route::post('/posts/edit/{id}', [\App\Http\Controllers\Post\PostController::class, 'update'])->name('post.update');
            Route::delete('/posts/{id}', [\App\Http\Controllers\Post\PostController::class, 'destroy'])->name('post.destroy');

            //SERVICES
            Route::post('/services', [\App\Http\Controllers\Service\ServiceController::class, 'store'])->name('services.store');
            Route::delete('/services/{id}', [\App\Http\Controllers\Service\ServiceController::class, 'destroy'])->name('services.destroy');
            Route::post('/services/edit/{id}', [\App\Http\Controllers\Service\ServiceController::class, 'update'])->name('services.update');

            //DIPLOMS
            Route::post('/diploms', [\App\Http\Controllers\Diplom\DiplomControler::class, 'store'])->name('diploms.store');
            Route::delete('/diploms/{id}', [\App\Http\Controllers\Diplom\DiplomControler::class, 'destroy'])->name('diploms.destroy');
            Route::post('/diploms/edit/{id}', [\App\Http\Controllers\Diplom\DiplomControler::class, 'update'])->name('diploms.update');
        });
    });
});

//ROSTS
Route::get('/posts', [\App\Http\Controllers\Post\PostController::class, 'index'])->name('post.index');
Route::get('/posts/{id}', [\App\Http\Controllers\Post\PostController::class, 'show'])->name('post.show');
//SERVICES
Route::get('/services', [\App\Http\Controllers\Service\ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [\App\Http\Controllers\Service\ServiceController::class, 'show'])->name('services.show');
//DIPLOMS
Route::get('/diploms', [\App\Http\Controllers\Diplom\DiplomControler::class, 'index'])->name('diploms.index');
Route::get('/diploms/{id}', [\App\Http\Controllers\Diplom\DiplomControler::class, 'show'])->name('diploms.show');


//REGISTER
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, '__invoke'])->name('register');

//MAIL (подписка)
Route::post('/email', [\App\Http\Controllers\Mail\MailController::class, 'sendMail'])->name('email.sendMail');


//PRODUCTCARD
Route::post('/product', [\App\Http\Controllers\ProductCard\ProductCardController::class, 'store'])->name('product.store');
Route::get('/product/{id}', [\App\Http\Controllers\ProductCard\ProductCardController::class, 'show'])->name('product.show');









