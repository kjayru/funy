<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/','LandingController@index');
//Route::get('/cuenta/test','cuentaController@test');
/* Bojan */
Route::group(['middleware' => 'user'], function(){

	Route::get('/speed-limits', 'PointHomeController@index')->name('speed_limits');
	Route::get('/points', 'PointHomeController@getPoints');
	Route::post('/points/delete', 'PointHomeController@deletePoint');
	Route::post('/points/update', 'PointHomeController@updatePoint');
	Route::post('/points/save', 'PointHomeController@savePoint');

});

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('admin/home','AdminController@index');

//Route::get('admin/usuario','UsuarioController@index');


//Route::get('admin','Admin\LoginController@showLoginForm')->name('admin.login');
Route::get('admin','Admin\CustomAuthController@showLoginForm')->name('admin.custom.login');
Route::post('admin','Admin\CustomAuthController@login');



Route::post('admin-password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin-password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/reset','Admin\ResetPasswordController@reset');
Route::get('admin-password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

Route::get('admin/registro','Admin\CustomAuthController@showRegisterForm')->name('admin.custom.register');
Route::post('admin/registro','Admin\CustomAuthController@register');

Route::get('admin/ingresar','Admin\CustomAuthController@showLoginForm')->name('admin.custom.login');
Route::post('admin/ingresar','Admin\CustomAuthController@login')->name('admin.login');

Route::get('admin/login/google', 'Admin\CustomAuthController@redirectToProvider');
Route::get('admin/login/google/callback', 'Admin\CustomAuthController@handleProviderCallback');

Route::post('admin/updategoogle','Admin\CustomAuthController@updategoogle')->name('admin.custom.updategoogle');


Route::resource('admin/profile','Admin\ProfileController');
Route::resource('admin/servicios','Admin\ServiceController');
Route::resource('admin/photo','Admin\PhotoController');

Route::resource('admin/solicitudes','Admin\SolicitudesController');

Route::get('admin/categorias','Admin\ServiceController@getcategory')->name('admin.categorias');
Route::post('admin/setcat','Admin\ServiceController@setcategory');
Route::put('admin/updatecat/{id}','Admin\ServiceController@updatecategory');
Route::delete('admin/borrarcat/{id}','Admin\ServiceController@borrarcat');
Route::get('getmarker/{id}','ServiceController@getmarker');

Route::post('verificar','LandingController@verificar')->name('verify');
Route::post('admin/salir','Admin\CustomAuthController@logout')->name('admin.custom.logout');
Route::resource('servicios','ServiceController');


Route::get('/redirect','ServiceController@redirect');
Route::get('/callback','ServiceController@callback');


Route::put('admin/estado/{id}','Admin\ProfileController@estado');
Route::put('admin/estadocat/{id}','Admin\ServiceController@estadocat');
Route::put('admin/estadoparent/{id}','Admin\ServiceController@estadoparent');

//super
Route::resource('admin/listclientes','Admin\ListclientController');
Route::resource('admin/listasociados','Admin\ListpartnerController');
Route::resource('admin/listsolicitudes','Admin\ListrequestController');
Route::resource('admin/entorno','Admin\EnvironmentController');