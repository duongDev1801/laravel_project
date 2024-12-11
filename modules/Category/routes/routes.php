<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Modules\Category\src\Http\Controllers', 'middleware' => 'web'], function () {
   Route::prefix('admin')->name('admin.')->group(function () {
      Route::prefix('categories')->name('categories.')->group(function () {
         Route::get('', 'CategoryController@index')->name('index');
         Route::get('create', 'CategoryController@create')->name('create');
         Route::post('create', 'CategoryController@store')->name('store');
         Route::get('data', 'CategoryController@data')->name('data');
         Route::get('edit/{category}', 'CategoryController@edit')->name('edit');
         Route::put('edit/{category}', 'CategoryController@update')->name('update');
         Route::delete('delete/{category}', 'CategoryController@delete')->name('delete');
      });
   });
});