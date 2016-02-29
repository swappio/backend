<?php


// Auth routes
Route::post('/api/v1/auth', 'AuthController@login');
Route::get('/api/v1/auth/{name}', 'AuthController@social');
Route::get('/api/v1/auth/{name}/callback', 'AuthController@socialCallback');

// Swaps routes
Route::post('/api/v1/swaps', 'SwapsController@create');
Route::get('/api/v1/swaps/{id}/matches', 'SwapsController@matches');


// Recommendations routes
Route::get('/api/v1/recommendations', 'RecommendationsController@index');


// Various toutes
Route::get('/debug', function () {
    return 'Welcome!';
});
