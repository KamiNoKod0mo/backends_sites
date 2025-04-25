<?php
@include('../config.php');
$email = $_GET['email'];
$pass1 = $_GET['pass1'];
$pass2 = $_GET['pass2'];

if (($pass1 !== $pass2) or $email == null or $pass1 == null or $pass2 == null) {
	header('Location: ../register.php');
	die();
}else{
	$sql = Mysql::connect()->prepare('INSERT INTO usuarios VALUES (null,?,?,?,?,null,null)');
	$sql->execute(array($email,$email,$pass1,'email'));
	if ($sql->rowCount()==1){
		header('Location: ../login.php');
	}else{
		header("Location: ../register.php");
	}

}



?>