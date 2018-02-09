<?php
require_once 'core/init.php';

$user = new User();
$doing = new Doing();
$todo = new Todo();
$done = new Done();

if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

if(Input::get('as') && Input::get('item')) {
	$as = Input::get('as');

	switch($as){
		case 'doing':
			if($todo->exists()) {

				$doing->create(array(
					'title' =>	$todo->get('title', array('id', '=', Input::get('item'))),
					'area' => $todo->get('area', array('id', '=', Input::get('item'))),
					'user_id' => $todo->get('user_id', array('id', '=', Input::get('item'))),
					'created' => date('Y-m-d H:i:s')
				));

				
			}
		break;
		case 'done':
			if($doing->find()) {
				$done->create(array(
					'title' =>	$doing->getDoing('title', array('id', '=', Input::get('item'))),
					'area' => $doing->getDoing('area', array('id', '=', Input::get('item'))),
					'user_id' => $doing->getDoing('user_id', array('id', '=', Input::get('item'))),
					'created' => date('Y-m-d H:i:s')
				));

				$doing->delete(array('id', '=', Input::get('item')));
			}
		break;
		case 'delete':
			if($done->find()) {
				$done->delete(array('id', '=', Input::get('item')));
			}
		break;
	}
}

Redirect::to('index.php');