<?php

use Illuminate\Support\Facades\Route;

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

// Middleware authentication Group
Route::middleware('CheckAuthMiddleware')->group(function(){
    Route::get('dashboard', function () {
        return view('home/index');
    })->name('dashboard');
    Route::get('logout','authentication\AuthController@logout')->name('logout');
});

// Category Training =====================================
Route::prefix('categories')->middleware('CheckAuthMiddleware','CheckAdminMiddleware')->group(function(){
    Route::get('','CategoryController@index')->name('categories.index');
    Route::get('{category:slug}','CategoryController@show')->name('categories.show');
    Route::post('store','CategoryController@store')->name('categories.store');
    Route::patch('{category:slug}/edit','CategoryController@update')->name('categories.update');
    Route::delete('{category:slug}/delete','CategoryController@destroy')->name('categories.destroy');
});
// Training =====================================
Route::prefix('trainings')->middleware('CheckAuthMiddleware','CheckAdminMiddleware')->group(function(){
    Route::get('','TrainingController@index')->name('trainings.index');
    Route::post('','TrainingController@search')->name('trainings.search');
    Route::get('{training:slug}','TrainingController@show')->name('trainings.show');
    Route::post('store','TrainingController@store')->name('trainings.store');
    Route::patch('{training:slug}/edit','TrainingController@update')->name('trainings.update');
    Route::delete('{training:slug}/delete','TrainingController@destroy')->name('trainings.destroy');
});
// Dashboard Training =====================================
Route::prefix('dashtraining')->middleware('CheckAuthMiddleware')->group(function(){
    Route::get('','DashtrainingController@index')->name('dashtrainings.index');
    Route::get('{training:slug}','TrainingController@show')->name('dashtrainings.show');
    Route::post('store','DashtrainingController@store')->name('dashtrainings.store');
    // File Lesson
    Route::get('{id}/showlesson','DashtrainingController@showLesson')->name('dashtrainings.showLesson');
    Route::delete('{id}','DashtrainingController@deleteLesson')->name('dashtrainings.deleteLesson');
    Route::get('{id}/downloadlesson','DashtrainingController@downloadLesson')->name('dashtrainings.downloadLesson');
    // File Task
    Route::get('{id}/showTask','DashtrainingController@showTask')->name('dashtrainings.showTask');
    Route::delete('{id}/deletetask','DashtrainingController@deleteTask')->name('dashtrainings.deleteTask');
    Route::get('{id}/downloadtask','DashtrainingController@downloadTask')->name('dashtrainings.downloadTask');
    Route::get('{id}/downloadreturntask','DashtrainingController@downloadReturnTask')->name('dashtrainings.downloadReturnTask');
    Route::get('{id}/datareturntask','DashtrainingController@dataReturnTask')->name('dashtrainings.dataReturn');
    // Employees
    Route::delete('{diuser_id}/{training_id}/deleteemployee','DashtrainingController@deleteEmployee')->name('dashtrainings.deleteEmployee');
    Route::get('{id}/showemployee','DashtrainingController@showEmployee')->name('dashtrainings.showEmployee');
});
// User =====================================
Route::prefix('users')->middleware('CheckAuthMiddleware','CheckAdminMiddleware')->group(function(){
    Route::get('','UserController@index')->name('users.index');
    Route::get('{user}','UserController@show')->name('users.show');
    Route::post('store','UserController@store')->name('users.store');
    Route::patch('{user}/edit','UserController@update')->name('users.update');
    Route::delete('{user}/delete','UserController@destroy')->name('users.destroy');
});
// E-library
Route::prefix('elibraries')->middleware('CheckAuthMiddleware','CheckAdminMiddleware')->group(function(){
    Route::get('','ElibraryController@index')->name('elibraries.index');
    Route::get('{elibrary}','ElibraryController@show')->name('elibraries.show');
    Route::post('store','ElibraryController@store')->name('elibraries.store');
    Route::patch('{elibrary}/edit','ElibraryController@update')->name('elibraries.update');
    Route::delete('{elibrary}/delete','ElibraryController@destroy')->name('elibraries.destroy');
    Route::get('{elibrary}/downloadelibrary','ElibraryController@downloadElibrary')->name('elibraries.downloadElibrary');
});
Route::prefix('dashelibraries')->middleware('CheckAuthMiddleware')->group(function(){
    Route::get('dashboard','ElibraryController@dashboard')->name('dashelibraries.index');
    Route::get('{elibrary}/downloadelibrary','ElibraryController@downloadElibrary')->name('dashelibraries.downloadElibrary');
});
// Report
Route::prefix('reports')->middleware('CheckAuthMiddleware')->group(function(){
    Route::get('','ReportController@index')->name('reports.index');
    Route::post('','ReportController@search')->name('reports.search');
});

Route::get('/','authentication\AuthController@index')->name('login');
Route::post('login','authentication\AuthController@login')->name('login');


// code below is login laravel
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
