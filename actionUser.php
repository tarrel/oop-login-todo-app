<?php
require_once 'core/init.php';
$user = new User();
$db = DB::getInstance();

if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

if(Input::get('as') && Input::get('item')) {
	$as = Input::get('as');

	switch($as) {
		case 'remove':
			$user->delete(Input::get('item'));
			Redirect::to('users.php');
		break;
	}
}