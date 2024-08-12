<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PageController;
use App\Http\Controllers\SurveyController;

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


Route::get('/', [PageController::class,'messages'])->name('welcome');

Route::get('/rezepte', [PageController::class,'recipes'])->name('rezepte');

Route::get('/rezepte/{slug}', [PageController::class,'category'])->name('rezept');

Route::get('/betriebsanweisungen', [PageController::class,'operatingInstructions'])->name('betriebsanweisungen');

Route::get('/gebrauchsanweisungen', [PageController::class,'manuals'])->name('gebrauchsanweisungen');

Route::get('/ansprechpartner', [PageController::class,"ansprechpartner"])->name('ansprechpartner');

Route::get('/einkauf', function () {
    return view('einkauf');
})->name('einkauf');

Route::get('/survey', [SurveyController::class, 'show'])->name('survey');
Route::post('/survey', [SurveyController::class, 'submit'])->name('survey');


