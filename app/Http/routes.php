<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('test',function(){
	// Create instance of Direct
	$sagepay = new dwmsw\sagepay\Direct();
	$sagepay->setConnectionMode('test');
	$output = $sagepay->threeDResponse($_POST['MD'], $_POST['PaRes']);
	print '<h1>RESPONSE</h1>';
	var_dump($output);

	print '<h1>THESE MUST MATCH</h1>';

	// Look in database for MD

	// If we find one then the payment must be true

	// check if PaRes Matches

	// If true check Status = OK and 3DSecureStatus = OK

	// Allocate Payment

	// redirect User

	// Delete Pending payment from database where MD / ID

	var_dump($_POST['MD']);
	var_dump($_POST['PaRes']);
});