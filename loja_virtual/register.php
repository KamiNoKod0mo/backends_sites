<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Registrar</title>
</head>
<body>
	<header class="container">
		<div>
			<a href=""> <img src="" alt="logo" title="logo"> </a>
		</div>
		<div class="title">
			<h3>Registrar</h3>
		</div>
	</header>	
	<div class="sub_header"></div>
	
	<section class="bg-img">
		<div class="forms">
			<div>
				<h4>Registrar</h4>
				<form action="php/reg.php">
					<input type="email" name="email" placeholder="Email">
					<input type="password" name="pass1" placeholder="Password">
					<input type="password" name="pass2" placeholder="Password">
					<input type="submit" name="submit" value="Registrar">
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

			<p>Já tem uma conta? <a href="login.php">Enter</a></p>
		</div>
	</section>

	<footer class="container footer1">
		
	</footer>
	<footer class="container footer2">
		
	</footer>


</body>
</html>