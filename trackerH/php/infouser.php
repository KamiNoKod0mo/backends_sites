<?php
include('../config.php');
$user = $_GET['username'];
$pass = md5($_GET['password']);

if ($user != '' AND $pass != ''){
	$sql = Mysql::connect()->prepare('SELECT * FROM usuario WHERE username = ? AND password = ?');
	$sql->execute(array($user,$pass));

	if($sql->rowCount() == 1){
		
		$info = $sql->fetch();

		$_SESSION['login'] = true;
		
		$_SESSION['user_id'] = $info['id'];
		$_SESSION['user'] = $info['username'];

		if (isset($_GET['remember'])) {
			setcookie('lembrar',true,time()+(60*60*24),'/');
			setcookie('user',$user,time()+(60*60*24),'/');
			setcookie('password',$pass,time()+(60*60*24),'/');
		}

		session_write_close();
		header('Location: ../index.php');

	}else{
		echo 'Usuario ou senha incorretos';
	}

}else{
	header('Location: ../login.php');
}
?>