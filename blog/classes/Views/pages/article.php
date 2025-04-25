<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ipsium</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH_STATIC ?>style/style.css">
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

	<section class="container w70">
		<?php
			$collection = \classes\Mongo::conexao1();
			$doc = $collection->findOne(['id'=> intval($_GET['id'])]);
			//var_dump($doc);
			//echo $doc['text'];

		?>
		<div class="title">
			<h2><?php echo $doc['title'];?></h2>
			<span class="timepost">1 hour and 35 secs ago</span>
		</div>
		<div class="desc">
			<img src="<?php echo $doc['cover'];?>" alt="cover" title="cover">
			<p><?php echo $doc['text'];?></p>
		</div>

		<?php

		?>
	</section>


	<aside class="w30">
		<?php include("includes/sidebar.php"); ?>
	</aside>

	<footer>
		<!-- Adicionar oque quiser-->
	</footer>
</body>
</html>