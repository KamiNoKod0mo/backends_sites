<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	require('vendor/autoload.php');
	
	define('INCLUDE_PATH_STATIC', 'http://localhost/Projeto_etapa3/blog/classes/Views/pages/');
	define('INCLUDE_PATH', 'http://localhost/Projeto_etapa3/blog/');
	
	$app = new classes\Application();

	$app->run();
?>
