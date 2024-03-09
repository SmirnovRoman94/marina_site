<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Diplom\DiplomControler;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Pay\PayController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProductCard\ProductCardController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service_combo\Service_comboController;
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

        Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');

        // Здесь находятся маршруты, доступные только для администраторов
        Route::group(['middleware' => 'admin'], function () {
            //ROSTS
            Route::post('/posts', [PostController::class, 'store'])->name('post.store');
            Route::post('/posts/edit/{id}', [PostController::class, 'update'])->name('post.update');
            Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('post.destroy');

            //SERVICES
            Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
            Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
            Route::post('/services/edit/{id}', [ServiceController::class, 'update'])->name('services.update');

            //DIPLOMS
            Route::post('/diploms', [DiplomControler::class, 'store'])->name('diploms.store');
            Route::delete('/diploms/{id}', [DiplomControler::class, 'destroy'])->name('diploms.destroy');
            Route::post('/diploms/edit/{id}', [DiplomControler::class, 'update'])->name('diploms.update');

            //COMMENTS
            Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('comment.delete');

            //PRODUCTS
            Route::post('/products', [ProductController::class, 'store'])->name('product.store');
            Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
            Route::post('/products/edit/{id}', [ProductController::class, 'update'])->name('product.update');

            //COMBO
            Route::post('/combo', [Service_comboController::class, 'store'])->name('service_combo.store');
            Route::delete('/combo{id}', [Service_comboController::class, 'destroy'])->name('service_combo.destroy');
            Route::post('/combo/edit/{id}', [Service_comboController::class, 'update'])->name('service_combo.update');

            //PAY
            Route::post('/paying', [PayController::class, 'store'])->name('pay.store');
            Route::get('/paying/{pay}', [PayController::class, 'show'])->name('pay.show');
            Route::put('/paying/{pay}', [PayController::class, 'update'])->name('pay.update');
            Route::delete('/paying/{pay}', [PayController::class, 'delete'])->name('pay.delete');

            //PATIENTS
            Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
        });
    });
});
//PAYING
Route::get('/paying', [PayController::class, 'index'])->name('pay.index');
//PATIENTS
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
//ROSTS
Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');

//SERVICES
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');

//DIPLOMS
Route::get('/diploms', [DiplomControler::class, 'index'])->name('diploms.index');
Route::get('/diploms/{id}', [DiplomControler::class, 'show'])->name('diploms.show');

//PRODUCTS
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

//COMBO
Route::get('/combo', [Service_comboController::class, 'index'])->name('service_combo.index');
Route::get('/combo/{id}', [Service_comboController::class, 'show'])->name('service_combo.show');

//REGISTER
Route::post('/register', [RegisterController::class, '__invoke'])->name('register');

//MAIL (подписка)
Route::post('/email', [MailController::class, 'sendMail'])->name('email.sendMail');

//COMMETS
Route::get('/comments', [CommentController::class, 'index'])->name('comment.index');








