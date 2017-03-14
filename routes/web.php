<?php




Route::get('/', 'GamesController@index');


Route::get('/instruction', 'GamesController@show');


Route::post('/instruction', 'GamesController@showinstruction');


Route::get('/games/{id}', 'GamesController@startgame');


