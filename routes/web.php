<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SpendingController;
use App\Http\Controllers\SpendingCategoryController;

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

Auth::routes();

$files = collect(File::files(base_path() . '/resources/views/dashboards'));

$files = $files->filter(function($file) {
    return preg_match("/^[0-9]+\.blade\.php$/", $file->getFilename());
});

$dashboards = $files->count();

Route::get('/', function () use ($dashboards) {
    return view('wallboard', compact('dashboards'));
});

for ($i = 1; $i <= $dashboards; $i++) {
    Route::get('/' . $i, function () use ($i) {
        return view('dashboards.' . $i);
    });    
}

Route::group(['middleware' => 'auth'], function () {

    Route::resource('spending', SpendingController::class);
    Route::resource('spending_category', SpendingCategoryController::class);
    
});
