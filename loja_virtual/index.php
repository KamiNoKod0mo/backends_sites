<?php
include("config.php");
if ($_SESSION['login'] != true) {
	header('Location: login.php');
}
if(isset($_GET['loggout'])){
	setcookie('lembrar',$_COOKIE['lembrar'],time() - (60*60*24), '/');
	setcookie('user',$_COOKIE['user'],time() - (60*60*24), '/');
	setcookie('password',$_COOKIE['password'],time() - (60*60*24), '/');
	session_destroy();
	header('Location: index.php');
}



?>

<header>
	<div class="loggout">
		<a href="?loggout"> <i class="fa fa-window-close"></i> <span>Sair</span></a>
	</div><!--loggout-->
</header>