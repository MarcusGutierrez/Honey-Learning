<?php






Auth::routes();

Route::get('/', 'RegistrationController@create')->name('login');

Route::get('/home', 'GamesController@index')->name('home');

Route::get('/next', 'GamesController@next')->name('next');

Route::get('/instruction', 'InstructionsController@instruction');

Route::get('/instruction/test', 'InstructionsController@show'); ////TESTING

Route::get('/instruction/concept', 'GamesController@concept');

Route::post('/instruction/concept', 'GamesController@store_concept');

Route::get('/survey/{type}', 'GamesController@startsurvey');

Route::post('storesurvey/{type}', 'GamesController@storesurvey');

Route::post('/instruction', 'GamesController@showinstruction');

Route::get('/games/{id}', 'GamesController@startgame');

Route::post('/gamehistory/save', 'GamehistoryController@storehoneymove');

Route::post('/gamehistory/savetentative', 'GamehistoryController@storehoneytentative');

Route::get('/signin', 'RegistrationController@create');

Route::post('/signin', 'RegistrationController@store');

Route::get('/login', 'RegistrationController@store');

Route::post('/login', 'SessionsController@store');

Route::get('/logout', 'SessionsController@destroy');

Route::get('/signout', 'SessionsController@destroy');

Route::get('/defender/{dtype}/{gid}', 'RoundsController@defender_move');

use honeysec\Honey_Network;
use honeysec\Honey_Node;
use honeysec\Honey_History;
use honeysec\Honey_Tentative;
use Illuminate\Http\Request;

Route::get('/sessions/create', 'GameSessionsController@create');

Route::post('/honeytotal', 'RoundsController@network_params');

Route::get('/honey/games/{did}/{gid}', 'RoundsController@defround')->name('defgame');

Route::get('/play/round/{rid}', 'RoundsController@round_create'); //Store round

Route::get('/play/practice', 'RoundsController@practice_round'); //Store round

Route::post('/round/store', 'RoundsController@round_store');

Route::get('/session/create/{def_type}', 'GameSessionsController@create');

Route::get('/results', 'GameSessionsController@results');

Route::get('/session/destroy', 'GameSessionsController@destroy');

Route::get('/honey/play/nextround/', 'RoundsController@next_round');

Route::get('/consent', 'InstructionsController@consent');

Route::post('/consent', 'InstructionsController@consent_store');

Route::get('/ineligible', 'InstructionsController@ineligible');