<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Login</title>
</head>
<body>
	<header class="container">
		<div>
			<a href=""> <img src="" alt="logo" title="logo"> </a>
		</div>
		<div class="title">
			<h3>Entre</h3>
		</div>
	</header>
	<div class="sub_header"></div>

	<section class="bg-img">
		<div class="forms">
			<div>
				<h4>Entre</h4>
				<form action="php/log.php">
					<input type="email" name="email" placeholder="Email">
					<input type="password" name="pass" placeholder="Password">
					<a href="esq.php">Esqueceu a senha?</a>
					<input type="submit" name="submit" value="Entre">
				</form>
			</div>
			<div class="separ">
				<div class="line"></div>
				<span> Ou </span>
				<div class="line"></div>
			</div>
			<div class="sociais">
				<?php include("php/authg.php")?>

			</div>

			<p>Não tem uma conta? <a href="register.php">Increver-se</a></p>
		</div>
	</section>

	<footer class="container footer1">
		
	</footer>
	<footer class="container footer2">
		
	</footer>


</body>
</html>