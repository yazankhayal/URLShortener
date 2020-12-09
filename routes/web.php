<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', 'ShortLinkController@test')->name('test');

Route::get('/delete', 'ShortLinkController@delete')->name('shorten.delete');
Route::get('/show', 'ShortLinkController@show')->name('shorten.show');

Route::get('/', 'ShortLinkController@index')->name('index');
Route::post('generate-shorten-link', 'ShortLinkController@store')->name('generate.shorten.link.post');

Route::get('{code?}', 'ShortLinkController@shortenLink')->name('shorten.link');

