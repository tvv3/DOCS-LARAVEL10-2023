<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CursController;
use App\Http\Controllers\CapitolController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\SiteController;
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
Route::get('/welcome', function () {
    return view('welcome');
});
*/

Route::post('/home', [HomeController::class,'verifica_parola'])->name('verifica_parola');
Route::get('/logout', [HomeController::class,'logout'])->name('logout');

Route::get('/', function () {
    return view('homepage');
})->name('loginhomepage');

Route::middleware(['customAutologout'])->group(function () {

Route::get('/myhome', [HomeController::class,'myhome'])->name('myhome');
Route::post('/search', [CursController::class,'search'])->name('search');
Route::get('/visitor_home', [HomeController::class,'show_test_home'])->name('visitor_home');


Route::get('/creeaza_curs', [CursController::class,'creeaza_curs'])->name('creeaza_curs');//->middleware('verific_activ');
Route::get('/show_cursuri', [CursController::class,'show_cursuri'])->name('show_cursuri');//->middleware('verific_activ');
Route::post('/store_curs', [CursController::class,'store_curs'])->name('store_curs');
Route::get('/modifica_curs/{curs}', [CursController::class,'edit_curs'])->name('edit_curs');//->middleware('verific_activ');
Route::put('/update_curs/{curs}', [CursController::class,'update_curs'])->name('update_curs');
Route::delete('/delete_curs/{curs}',[CursController::class,'delete_curs'])->name('delete_curs');
Route::get('/search',[CursController::class,'search'])->name('search');


//Route::get('/creeaza_capitol/{curs}', [CapitolController::class,'creeaza_capitol'])->name('creeaza_capitol');
Route::get('/show_capitole/{curs}', [CapitolController::class,'show_capitole'])->name('show_capitole');

Route::get('/creeaza_capitol/{curs}', [CapitolController::class,'creeaza_capitol'])->name('creeaza_capitol');

Route::post('/store_capitol', [CapitolController::class,'store_capitol'])->name('store_capitol');

Route::get('/modifica_capitol/{capitol}', [CapitolController::class,'edit_capitol'])->name('edit_capitol');
Route::put('/update_capitol/{capitol}', [CapitolController::class,'update_capitol'])->name('update_capitol');
Route::delete('/delete_capitol/{capitol}',[CapitolController::class,'delete_capitol'])->name('delete_capitol');
Route::get('/visitor_home/capitol/{capitol}', [CapitolController::class,'show_capitol_content'])->name('show_capitol_content');
Route::get('/visitor_home/capitol/{capitol}/nota/{nota}/site/{site}/{tab}',
 [CapitolController::class,'show_capitol_content_with_nota_and_site'])->name('show_capitol_content_with_nota_and_site');
 Route::get('/visitor_home/capitol/{capitol}/nota/{nota}',
 [CapitolController::class,'show_capitol_content_with_nota_and_no_site'])->name('show_capitol_content_with_nota_and_no_site');
 Route::get('/visitor_home/capitol/{capitol}/site/{site}',
 [CapitolController::class,'show_capitol_content_with_site'])->name('show_capitol_content_with_site');

Route::get('/creeaza_nota/{capitol}', [NotaController::class,'creeaza_nota'])->name('creeaza_nota');
Route::get('/show_note/{capitol}', [NotaController::class,'show_note'])->name('show_note');
Route::post('/store_nota', [NotaController::class,'store_nota'])->name('store_nota');
Route::get('/modifica_nota/{nota}', [NotaController::class,'edit_nota'])->name('edit_nota');
Route::put('/update_nota/{nota}', [NotaController::class,'update_nota'])->name('update_nota');
Route::delete('/delete_nota/{nota}',[NotaController::class,'delete_nota'])->name('delete_nota');

Route::get('/creeaza_site/{capitol}', [SiteController::class,'creeaza_site'])->name('creeaza_site');
Route::get('/show_siteuri/{capitol}', [SiteController::class,'show_siteuri'])->name('show_siteuri');
Route::post('/store_site', [SiteController::class,'store_site'])->name('store_site');
Route::get('/modifica_site/{site}', [SiteController::class,'edit_site'])->name('edit_site');
Route::put('/update_site/{site}', [SiteController::class,'update_site'])->name('update_site');
Route::delete('/delete_site/{site}',[SiteController::class,'delete_site'])->name('delete_site');

});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
