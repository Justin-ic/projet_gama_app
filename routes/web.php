<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\PageSectionOrderController;



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



Route::get('/', [DataController::class, 'index'])->name('home');
 Route::get('/{slug}.html', [DataController::class, 'makePage'])
->where('slug', '[A-Za-z-]+')
->name('page');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
Route::get('page-sections/order/{page_id?}', [PageSectionOrderController::class, 'order'])->name('voyager.page-sections.order');


});
