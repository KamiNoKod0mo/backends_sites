<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ipsium</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH_STATIC ?>style/style.css">
</head>
</head>
<body>
	<header>
		<div class="purple-dark"></div>
		<div class="purple container flex">
			<div class="logo">
				<a href="<?php echo INCLUDE_PATH ?>home"><img src="<?php echo INCLUDE_PATH_STATIC ?>imgs/logo.png" alt="logo" title="logo"></a>
			</div>

			<div class="search purple">
				<img class="icon" src="<?php echo INCLUDE_PATH_STATIC ?>imgs/search.png">
				<form>
					<input type="text" name="search" placeholder="Search">
					<input type="submit" name="submit">
				</form>
			</div>
		</div>
	</header>

	<section class="container">
		<div class="title">
			<h2>Public article</h2>
		</div>
		<form method="post" enctype="multipart/form-data">
			<h3>Title</h3>
			<input type="text" name="title">
			<h3>Article</h3>
			<textarea name="textarea"></textarea>
			<input type="checkbox" name="new" id="new" value="1"><label for="new">Noticia?</label>
			<input type="file" name="imagem" placeholder="sdad">
			<!-- Usar o label para deixar esse type=file melhor-->
			<input type="submit" name="submit" value="add">
			<input type="hidden" name="post">
		</form>
	</section>

	<footer>
		<!-- Adicionar oque quiser-->
	</footer>

</body>
</html>