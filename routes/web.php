<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::group(['middleware' => ['auth']], function($router){
	$router->get('/members', 'MembersController@index');
	$router->post('/members', 'MembersController@store');
	$router->get('/members/{id}', 'MembersController@show');
	$router->put('/members/{id}', 'MembersController@update');
	$router->delete('/members/{id}', 'MembersController@destroy');

	$router->post('/profiles', 'ProfilesController@store');
});

Route::group(['middleware' => ['auth']], function($router){
	$router->get('/users', 'UsersController@index');
	$router->post('/users', 'UsersController@store');
	$router->get('/users/{id}', 'UsersController@show');
	$router->put('/users/{id}', 'UsersController@update');
	$router->delete('/users/{id}', 'UsersController@destroy');
});

Route::group(['middleware' => ['auth']], function($router){
	$router->get('/borrows', 'BorrowsController@index');
	$router->post('/borrows', 'BorrowsController@store');
	$router->get('/borrows/{id}', 'BorrowsController@show');
	$router->put('/borrows/{id}', 'BorrowsController@update');
	$router->delete('/borrows/{id}', 'BorrowsController@destroy');
});

Route::group(['middleware' => ['auth']], function($router){
	$router->get('/categories', 'CategoriesController@index');
	$router->post('/categories', 'CategoriesController@store');
	$router->get('/categories/{id}', 'CategoriesController@show');
	$router->put('/categories/{id}', 'CategoriesController@update');
	$router->delete('/categories/{id}', 'CategoriesController@destroy');
});

Route::group(['middleware' => ['auth']], function($router){
	$router->get('/books', 'BooksController@index');
	$router->post('/books', 'BooksController@store');
	$router->get('/books/{id}', 'BooksController@show');
	$router->put('/books/{id}', 'BooksController@update');
	$router->delete('/books/{id}', 'BooksController@destroy');
});

$router->group(['prefix' => 'auth'], function () use ($router){
	$router->post('/register', 'AuthController@register');
	$router->post('/login', 'AuthController@login');

});

//Relationship Books
$router->get('/public/books', 'PublicController\BooksController@index');
$router->get('/public/books/{id}', 'PublicController\BooksController@show');

//Relationship Borrows
$router->get('/public/borrows', 'PublicController\BorrowsController@index');
$router->get('/public/borrows/{id}', 'PublicController\BorrowsController@show');

//Upload Media Get
$router->get('/profiles/{membersId}', 'ProfilesController@show');
$router->get('/profiles/image/{imageName}', 'ProfilesController@image' );
