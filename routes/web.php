<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DictionaryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dictionary', function () {
    return view('dictionary');
})->name('dictionary');

Route::get('/dictionary', function () {
    return view('dictionary');
})->name('dictionary');

Route::get('/phrasal_verbs', function () {
    return view('phrasal_verbs');
})->name('phrasal_verbs');

Route::get('/insert', function () {
    return view('insert');
})->name('insert');

Route::patch('api/dictionary/', 'DictionaryController@updateAll');

// Route::get('/delete_all_data', 'DictionaryController@deleteAllData')->name('delete_all_data');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
