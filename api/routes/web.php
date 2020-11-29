<?php

/** @var \Laravel\Lumen\Routing\Router $router */
/**
 * @OA\Info(title="API", version="1.0")
 */

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

$router->group(['prefix' => 'v1', 'middleware' => 'auth'], function($router){
    $router->get('', $router->app->version());
    $router->group(['prefix' => 'person'], function($router){
        $router->get('',                'PeopleController@getAll');
        $router->get('/{id_person}',    'PeopleController@getPerson');
        $router->post('',               'PeopleController@addPerson');
        $router->put('/{id_person}',    'PeopleController@putPerson');
        $router->delete('/{id_person}', 'PeopleController@removePerson');
    });
    $router->group(['prefix' => 'contact'], function($router){
        $router->get('/{id_person}',                 'ContactController@getContacts');
        $router->get('/unique/{id_contact}',         'ContactController@getContact');
        $router->post('',                            'ContactController@addContact');
        $router->put('/{id_contact}',                'ContactController@putContact');
        $router->delete('/{id_contact}',             'ContactController@removeContact');
    });
});