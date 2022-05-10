<?php

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



/*Route pour les produits*/
Route::get('/maboutique', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/maboutique/{slug}', [App\Http\Controllers\ProductController::class, 'details'])->name('products.details');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');

/*Route pour le panier*/
Route::group(['middleware' => ['auth']], function(){
    Route::get('/panier', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/ajouter', [App\Http\Controllers\CartController::class, 'ajouter'])->name('cart.ajouter');
    Route::patch('/panier/{rowId}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/panier/{rowId}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
});


/*Route pour la caisse*/
Route::group(['middleware' => ['auth']], function(){
    Route::get('/payement', [App\Http\Controllers\CaisseController::class, 'index'])->name('caisse.index');
    Route::post('/enregistrerPayement', [App\Http\Controllers\CaisseController::class, 'enregistrer'])->name('caisse.enregistrer');
    Route::get('/merci', [App\Http\Controllers\CaisseController::class, 'merci'])->name('caisse.merci');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
