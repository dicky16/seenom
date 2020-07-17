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

$router->get('/', 'IndexController@index');

$router->group(['prefix' => 'admin', 'middleware' => 'cekAdmin'], function () use ($router) {
    $router->get('/', 'AdminController@index');
    $router->get('coba', 'AdminController@coba');
    //katalog
    $router->get('katalog-tambah', 'AdminController@getTambahKatalog');
    $router->post('katalog-tambah', 'AdminController@tambahKatalog');
    //testimoni
    $router->get('testi-tambah', 'AdminController@getTambahTesti');
    $router->post('testi-tambah', 'AdminController@tambahTesti');
    //galeri
    $router->get('galeri-tambah', 'AdminController@getTambahGaleri');
    $router->post('galeri-tambah', 'AdminController@tambahGaleri');
});

$router->get('login', 'LoginController@login');
$router->post('login', 'LoginController@cekLogin');
$router->get('logout', 'LoginController@logout');

$router->get('/{any}', function () use ($router) {
    return $router->app->version();
});
