<?php

	
	require_once '../vendor/autoload.php';
	Twig_Autoloader::register();

	$router = new Core\Router();

	$router->add('', ['controller' => 'Home', 'action' => 'index']);
	$router->add('login', ['controller' => 'Login', 'action' => 'index']);
	$router->add('register', ['controller' => 'Register', 'action' => 'index']);
	$router->add('forgot', ['controller' => 'Forgot', 'action' => 'index']);
	$router->add('reset', ['controller' => 'Reset', 'action' => 'index']);
	$router->add('{controller}/{action}');
	$router->add('{controller}/{id:\d+}/{action}');

	$url = $_SERVER['QUERY_STRING'];

	$router->dispatch($url);

?>