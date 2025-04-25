<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
	<title>registro</title>
	<link rel="stylesheet" type="text/css" href="style/">
</head>
<body>
	<div class="poli1">
		
	</div>

	<section class="container flex">
		<div class="login">
			<form method="get" action='php/reguser.php'>
				<label for="username">Usename</label>
				<input type="text" name="username">
				<label for="email">Email</label>
				<input type="text" name="email">
				<label for="password">Passwod</label>
				<input type="password" name="password">
				<input type="submit" name="sub" value="Entrar">
			</form>
			<p>Já tem uma Conta? <a href="login.php">Logar</a></p>
			<h5>Inscrever-se com</h5>
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