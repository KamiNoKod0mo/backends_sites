<?php
	$autoload = function($class){
		include('php/'.$class.'.php');
	};
	spl_autoload_register($autoload);
	date_default_timezone_set('America/Sao_Paulo');


	//Conectar com banco de dados!
	define('HOST','localhost');
	define('USER','carlos');
	define('PASSWORD','1234');
	define('DATABASE','tarefas_db');


	session_set_cookie_params([
	    'lifetime' => 0,       // Sessão expira ao fechar o navegador
	    'path' => '/',         // Disponível em todo o site
	    'domain' => '',        // Domínio do site
	    'secure' => false,      // Somente HTTPS
	    'httponly' => true    // Impede acesso via JavaScript
	]);
	session_start();	
?>