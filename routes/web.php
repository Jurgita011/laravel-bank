<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController as C;
use App\Http\Controllers\AuthorsController as A;

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

Route::prefix('clients')->name('clients-')->group(function () {

    Route::get('/', [R::class, 'index'])->name('index'); // GET /colors from URL:  colors Name: colors-index
    Route::get('/create', [R::class, 'create'])->name('create'); // GET /colors/create from URL:  colors/create Name: colors-create
    //Route::post('/', [R::class, 'store'])->name('store'); // POST /colors from URL:  colors Name: colors-store
   // Route::get('/delete/{color}', [R::class, 'delete'])->name('delete'); // GET /colors/delete/{color} from URL:  colors/delete/{color} Name: colors-delete
   // Route::delete('/{color}', [R::class, 'destroy'])->name('destroy'); // DELETE /colors/{color} from URL:  colors/{color} Name: colors-destroy 
    //Route::get('/edit/{color}', [R::class, 'edit'])->name('edit'); // GET /colors/edit/{color} from URL:  colors/edit/{color} Name: colors-edit
    //Route::put('/{color}', [R::class, 'update'])->name('update'); // PUT /colors/{color} from URL:  colors/{color} Name: colors-update

});

//Route::prefix('authors')->name('authors-')->group(function () {

    //Route::get('/', [A::class, 'index'])->name('index');
    //Route::get('/create', [A::class, 'create'])->name('create');
   // Route::post('/', [A::class, 'store'])->name('store');
   // Route::get('/delete/{author}', [A::class, 'delete'])->name('delete');
    //Route::delete('/{author}', [A::class, 'destroy'])->name('destroy');
    //Route::get('/edit/{author}', [A::class, 'edit'])->name('edit');
    //Route::put('/{author}', [A::class, 'update'])->name('update');

//});






Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
