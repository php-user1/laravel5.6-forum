<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/discuss', function () {
    return view('discuss');
});

Auth::routes();

Route::get('/forum', [
    'uses' => 'ForumsController@index',
    'as' => 'forum'
]);

Route::get('{provider}/auth', [
    'uses' => 'SocialsController@auth',
    'as'   => 'social.auth',
]);

Route::get('{provider}/redirect', [
    'uses' => 'SocialsController@auth_callback',
    'as'   => 'social.callback',
]);

Route::get('discussion/{slug}', [
    'uses' => 'DiscussionsController@show',
    'as'   => 'discussion',
]);

Route::get('channel/{slug}', 'ForumsController@channel')->name('channel');

Route::get('/reply/edit/{reply}', 'RepliesController@edit')->name('reply.edit');
Route::post('/reply/update/{reply}', 'RepliesController@update')->name('reply.update');

Route::group(['middleware' => 'auth'], function(){
    Route::resource('channels', 'ChannelController');
    
    Route::get('discussion/create/new', [
        'uses' => 'DiscussionsController@create',
        'as'   => 'discussions.create',
    ]);
    
    Route::post('discussions/store', [
        'uses' => 'DiscussionsController@store',
        'as'   => 'discussions.store',
    ]);
    
    Route::post('/discussion/reply/{discussion}', [
        'uses' => 'DiscussionsController@reply',
        'as'   => 'discussion.reply',
    ]);
    
    Route::get('/reply/like/{reply}', 'RepliesController@like')->name('reply.like');
    
    Route::get('/reply/unlike/{reply}', 'RepliesController@unlike')->name('reply.unlike');
    
    Route::get('/discussion/watch/{discussion}', 'WatchersController@watch')->name('discussion.watch');
    Route::get('/discussion/unwatch/{discussion}', 'WatchersController@unwatch')->name('discussion.unwatch');
    Route::get('/discussion/best/reply/{reply}', 'RepliesController@best_answer')->name('discussion.best.answer');
    
    Route::get('/discussion/edit/{slug}', 'DiscussionsController@edit')->name('discussion.edit');
    Route::post('/discussion/update/{discussion}', 'DiscussionsController@update')->name('discussion.update');
});

Route::get('/portfolio', 'PortfolioController@index')->name('portfolio');