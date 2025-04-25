<?php
include('../config.php');
$user = $_GET['username'];
$email = $_GET['email'];
$pass = md5($_GET['password']);

if ($user != '' AND $email != '' AND $pass != ''){
	// Aqui eu iria ter que verificar se é uma email valido, se já não existe no BD e se a senha é boa
	$sql = Mysql::connect()->prepare("INSERT INTO usuario VALUES (null,?,?,?)");
	$sql->execute(array($user,$email,$pass));

	if ($sql->rowCount()==1){
		header('Location: ../login.php');
	}

}else{
	header('Location: ../registro.php');
}


?>