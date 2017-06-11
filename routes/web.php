<?php






Auth::routes();

Route::get('/', 'GamesController@index')->name('home');


Route::get('/home', 'GamesController@index');


Route::get('/instruction', 'GamesController@show');


Route::get('/survey', 'GamesController@startsurvey');



Route::post('storesurvey', 'GamesController@storesurvey');

Route::post('/instruction', 'GamesController@showinstruction');


Route::get('/games/{id}', 'GamesController@startgame');


Route::post('/gamehistory/save', 'GamehistoryController@storehoneymove');

Route::post('/gamehistory/savetentative', 'GamehistoryController@storehoneytentative');





Route::get('/register', 'RegistrationController@create');

Route::post('/register', 'RegistrationController@store');


Route::get('/login', 'SessionsController@create');

Route::post('/login', 'SessionsController@store');

Route::get('/logout', 'SessionsController@destroy');

Route::get('/defender/{dtype}/{gid}', 'DefenderController');

use honeysec\Honey_Game;
use honeysec\Honey_Node;
use honeysec\Honey_History;
use honeysec\Honey_Tentative;

//Route::get('/honey/{id}', 'GamesController@starthoneygame');
Route::post('/post/honey/{gid}', function($id){
    
    //$honeygames = DB::table('honey_game')->get();
    
    //$honey_game = Honey_Game::where('gid', '=', $id)->get();
    
    $honey_nodes = Honey_Node::gameID($id);
    
    return $honey_nodes;
    
});

Route::post('/honeytotal/{gid}', function($id){
    
    $atkBudget = Honey_Game::where('gid', $id)->first()->atk_budget;
    $atkAttempts = Honey_Game::where('gid', $id)->first()->atk_attempts;
    $instance = Honey_History::nextInstance(0, $id);
    
    $totalValue = Honey_Node::inGameID($id)->valueSum();
    
    $params = array();
    $params['atk_budget'] = $atkBudget;
    $params['atk_attempts'] = $atkAttempts;
    $params['total_value'] = $totalValue;
    $params['instance'] = $instance;
    
    return $params;
    
});

//Route::get('/honey/{id}', 'GamesController@starthoneygame');
Route::get('/honey/{gid}', function($id){
    $honey_game = Honey_Game::find($id);
    $honey_nodes = Honey_Node::inGameID($id)->get();
    
    $rpath = '/defender/uni/' + $id;
    $request = Request::create("/defender/test/$id", 'GET');
    $responsestring = Route::dispatch($request)->getContent();
    
    //$responsestring = $responsestring->content();
    $testvar = json_decode($responsestring, true);
    
    //$honey_game->gid = $testvar['details'];
    
    return view('honey.honey_one', compact('honey_game'), compact('honey_nodes'));
    
});
