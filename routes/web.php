<?php

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

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $users = User::all();
    return view('welcome', compact('users'));
});

Auth::routes();

Route::resource('tasks', 'TaskController')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
