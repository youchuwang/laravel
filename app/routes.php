<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Session Routes
Route::get('login',  array('as' => 'login', 'uses' => 'SessionController@create'));
Route::get('logout', array('as' => 'logout', 'uses' => 'SessionController@destroy'));
Route::resource('sessions', 'SessionController', array('only' => array('create', 'store', 'destroy')));

// User Routes
Route::get('register', array('as' => 'register', 'uses' => 'UserController@create'));
Route::get('users/{id}/activate/{code}', 'UserController@activate')->where('id', '[0-9]+');
Route::get('resend', array('as' => 'resendActivationForm', function()
{
	return View::make('users.resend');
}));
Route::post('resend', 'UserController@resend');
Route::get('forgot', array('as' => 'forgotPasswordForm', function()
{
	return View::make('users.forgot');
}));
Route::post('forgot', 'UserController@forgot');
Route::post('users/{id}/change', 'UserController@change');
Route::get('users/{id}/reset/{code}', 'UserController@reset')->where('id', '[0-9]+');
Route::get('users/{id}/suspend', array('as' => 'suspendUserForm', function($id)
{
	return View::make('users.suspend')->with('id', $id);
}));
Route::post('users/{id}/suspend', 'UserController@suspend')->where('id', '[0-9]+');
Route::get('users/{id}/unsuspend', 'UserController@unsuspend')->where('id', '[0-9]+');
Route::get('users/{id}/ban', 'UserController@ban')->where('id', '[0-9]+');
Route::get('users/{id}/unban', 'UserController@unban')->where('id', '[0-9]+');
Route::resource('users', 'UserController');

// Group Routes
Route::resource('groups', 'GroupController');

Route::get('/', array('as' => 'home', function()
{
	return View::make('realhome');
}));

Route::get('/home', array('as' => 'realhome', function()
{
	return View::make('home');
}));

Route::get('/dashboard', array('as' => 'dashboard', 'uses' => 'DashboardController@index'));
Route::get('/walkthrough', array('as' => 'walkthrough', 'uses' => 'DashboardController@walkthrough'));

Route::post('/contacts/send', array('as' => 'contacts.send', 'uses' => 'ContactsController@send'));

Route::get('/privacy-policy', array('as' => 'privacy-policy', function()
{
	return View::make('privacy-policy');
}));

Route::get('/terms-of-use', array('as' => 'terms-of-use', function()
{
	return View::make('terms-of-use');
}));

Route::get('/account', array('as' => 'account', 'uses' => 'UserController@accountpage'));
Route::post('/accountupdate-personal', array('as' => 'accountupdate-personal', 'uses' => 'UserController@accountpageupdate_personal'));
Route::post('/accountupdate-password', array('as' => 'accountupdate-password', 'uses' => 'UserController@accountpageupdate_password'));

Route::post('/addaccountalertemail', array('as' => 'addaccountalertemail', 'uses' => 'UserController@addAccountAlertEmail'));
Route::post('/deleteaccountalertemail', array('as' => 'deleteaccountalertemail', 'uses' => 'UserController@deleteAccountAlertEmail'));
Route::post('/sendconfirmaccountalertemail', array('as' => 'sendconfirmaccountalertemail', 'uses' => 'UserController@sendConfirmAccountAlertEmail'));

Route::post('/checksite/addsiteinfohttp', array('as' => 'checksite.addsiteinfohttp', 'uses' => 'CheckSiteController@postAddSiteInfoHTTP'));
Route::post('/checksite/addsiteinfohttps', array('as' => 'checksite.addsiteinfohttps', 'uses' => 'CheckSiteController@postAddSiteInfoHTTPS'));
Route::post('/checksite/addsiteinfodns', array('as' => 'checksite.addsiteinfodns', 'uses' => 'CheckSiteController@postAddSiteInfoDNS'));
Route::post('checksite/addsiteinfoauto',array('as'=>'checksite.addsiteinfoauto','uses'=>'CheckSiteController@postAddSiteInfoAuto'));
Route::post('/checksite/deletecheck',array('as'=>'checksite.deletecheck','uses'=>'CheckSiteController@deleteCheck'));
Route::post('/checksite/suspendcheck',array('as'=>'checksite.suspendcheck','uses'=>'CheckSiteController@suspendCheck'));
Route::post('/checksite/refresh',array('as'=>'checksite.refresh','uses'=>'CheckSiteController@refresh'));
Route::get('/alerts/{id}/activate/{code}', 'UserController@activateAlertEmail')->where('id', '[0-9]+');


Route::post('/getgraphdata', array('as' => 'getgraphdata', 'uses' => 'DashboardController@getGraphData'));
Route::post('/getgraphdatawalkthrough', array('as' => 'getgraphdatawalkthrough', 'uses' => 'DashboardController@getGraphDataWalkthrough'));
Route::post('/getsiteinfoforedit', array('as' => 'getsiteinfoforedit', 'uses' => 'CheckSiteController@getSiteInfo'));

Route::post('/edithttpsiteinfoforedit', array('as' => 'edithttpsiteinfoforedit', 'uses' => 'CheckSiteController@editHTTPSiteInfo'));
Route::post('/edithttpssiteinfoforedit', array('as' => 'edithttpssiteinfoforedit', 'uses' => 'CheckSiteController@editHTTPSSiteInfo'));
Route::post('/editdnssiteinfoforedit', array('as' => 'editdnssiteinfoforedit', 'uses' => 'CheckSiteController@editDNSSiteInfo'));

Route::post('/editdnssiteinfoforedit', array('as' => 'editdnssiteinfoforedit', 'uses' => 'CheckSiteController@editDNSSiteInfo'));

Route::get('/contact-support', array('as' => 'contact-support', 'uses' => 'ContactsController@contactSupport'));

// function()
// {
	// if( !Sentry::check() ) {
		// return Redirect::to('login');
	// }
	
	// return View::make('dashboard.account');
// }
// App::missing(function($exception)
// {
    // App::abort(404, 'Page not found');
    // return Response::view('errors.missing', array(), 404);
// });





