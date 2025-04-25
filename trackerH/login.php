<?php
	include_once('config.php');
	if (isset($_COOKIE['lembrar'])) {
		$user = $_COOKIE['user'];
		$pass = $_COOKIE['password'];
		if ($user != '' AND $pass != ''){
			$sql = Mysql::connect()->prepare('SELECT * FROM usuario WHERE username = ? AND password = ?');
			$sql->execute(array($user,$pass));

			if($sql->rowCount() == 1){
				
				$info = $sql->fetch();

				$_SESSION['login'] = true;
				
				$_SESSION['user_id'] = $info['id'];
				$_SESSION['user'] = $info['username'];

				session_write_close();
				header('Location: index.php');
			}	
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="style/">
</head>
<body>
	<div class="poli1">
		
	</div>

	<section class="container flex">
		<div class="login">
			<form method="get" action="php/infouser.php">
				<label for="username">Usename</label>
				<input type="text" name="username">
				<label for="password">Password</label>
				<input type="password" name="password">
				<input type="checkbox" name="remember">
				<label for="remember"> Remember me</label>
				<a href="">Esqueçeu a Senha?</a>
				<input type="submit" name="sub" value="Entrar">
			</form>
			<p>Não tem uma Conta? <a href="registro.php">Increver-se</a></p>
			<h5>Locar com</h5>
			<?php include("php/authg.php")?>
			
		</div>
		<div class="welcome">
			<img src="imgs/imageremovebgpreview1.png" alt="noway" title="noway">
		</div>
	</section>

	<div class="poli2">
		
	</div>


</body>
</html>