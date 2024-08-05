<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RecoverPasswordController;
use App\Http\Controllers\Authentication\ResetPasswordController;
use App\Http\Controllers\AdminPanel\Blog\BlogController;
use App\Http\Controllers\AdminPanel\Settings\SettingsController;
use App\Http\Controllers\AdminPanel\Users\UsersController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Sitemap\SitemapController;

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
    return ['Laravel' => app()->version()];
});

require __DIR__ . '/auth.php';

Route::post('/login', [LoginController::class, 'login']);
Route::post('/recover-password', [RecoverPasswordController::class, 'recoverPassword']);
Route::post('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword']);

Route::post('/blog-add-post', [BlogController::class, 'addBlogPost']);
Route::post('/blog-add-meta/{slug}', [BlogController::class, 'addBlogMeta']);
Route::post('/blog-add-content', [BlogController::class, 'addBlogContent']);
Route::get('/blog-download-content/{slug}', [BlogController::class, 'downloadBlogContent']);
Route::put('/blog-edit-content/{slug}', [BlogController::class, 'editBlogContent']);
Route::get('/blog-list', [BlogController::class, 'downloadBlogList']);
Route::delete('/blog-delete-article/{slug}', [BlogController::class, 'deleteBlogArticle']);
Route::get('/blog-download-all-data', [BlogController::class, 'downloadBlogAllData']);
Route::get('/blog-download-article/{slug}', [BlogController::class, 'downloadBlogArticle']);
Route::get('/blog-download-meta/{slug}', [BlogController::class, 'downloadBlogMeta']);

Route::get('/admin-settings-account', [SettingsController::class, 'adminSettingsAccount']);
Route::put('/admin-change-password/{user_name}', [SettingsController::class, 'adminChangePassword']);
Route::put('/admin-change-email/{user_name}', [SettingsController::class, 'adminChangeEmail']);

Route::get('/users-list', [UsersController::class, 'downloadUsersList']);

Route::post('/send-form', [ContactController::class, 'sendForm']);

Route::get('/sitemap', [SitemapController::class, 'generate']);
