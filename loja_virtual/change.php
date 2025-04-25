<?php
include('config.php');
$token =  $_GET['token'];
$pass1 = $_GET['pass1'] ?? null;
$pass2 = $_GET['pass2'] ?? null;
//echo date('Y-m-d H:i:s');

if (($pass1 !== $pass2) or $pass1 == null or $pass2 == null) {
	echo "Error nas senhas";
}else{
	$sql = Mysql::connect()->prepare('SELECT * FROM tokens_recuperacao WHERE token = ?');
	$sql->execute(array($token));

	$sqlE = Mysql::connect()->prepare('UPDATE `tokens_recuperacao` SET utilizado=? WHERE token = ?');
	$sqlE->execute(array(1,$token));	

	if ($sql->rowCount() == 1) {
		$info = $sql->fetch();
		if ($info['utilizado']!=1 or date('Y-m-d H:i:s') < $info['data_expiracao']) {

			$sqlU = Mysql::connect()->prepare('UPDATE `usuarios` SET senha_hash=? WHERE id = ?');
			$sqlU->execute(array($pass2,$info['usuario_id']));

			if ($sqlU->rowCount() == 1) {
				header('Location: login.php');
			}
		}
	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>change</title>
</head>
<body>
	<header class="container">
		<div>
			<a href=""> <img src="" alt="logo" title="logo"> </a>
		</div>
		<div class="title">
			<h3>Change</h3>
		</div>
	</header>	
	<div class="sub_header"></div>
	
	<section class="bg-img">
		<div class="forms">
			<div>
				<h4>Change</h4>
				<form action="">
					<input type="password" name="pass1" placeholder="Password">
					<input type="password" name="pass2" placeholder="Password">
					<input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
					<input type="submit" name="submit" value="Update">
				</form>
			</div>
			
		</div>
	</section>

	<footer class="container footer1">
		
	</footer>
	<footer class="container footer2">
		
	</footer>


</body>
</html>