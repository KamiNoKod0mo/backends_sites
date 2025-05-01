<?php
include('../config.php');
$email = $_GET['email'];
$pass = $_GET['pass'];

if (isset($email) and isset($pass)) {
	$sql = Mysql::connect()->prepare('SELECT * FROM usuarios WHERE email = ? and senha_hash = ? and auth_provider = ?');
	$sql->execute(array($email,$pass,'google'));

	if ($sql->rowCount() == 1) {
		$info = $sql->fetch();
		$_SESSION['login'] = true;
		
		$_SESSION['user_id'] = $info['id'];
		$_SESSION['user'] = $info['username'];

		session_write_close();
		header('Location: ../index.php');
	}
}else{
	header("Location: ../login.php");
}


?>