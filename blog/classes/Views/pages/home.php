<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
				<form id="searchForm">
					<input type="text" name="search" id="search" placeholder="Search" value"a">
					<input type="submit" name="search_button" id="searchSubmit">
				</form>
			</div>
		</div>
	</header>

	<section class="container w70">
		<div class="title">
			<h2>Newest Questions</h2>
			<a href="<?php echo INCLUDE_PATH ?>post" class="btn-b purple-dark">Add</a>
		</div>
		<div class="posts">
			<?php
				$collection = \classes\Mongo::conexao1();
				$cursor = $collection->find();
				//echo "ID numérico: " . ($document['id'] ?? 'N/A') . "\n";
				    //echo "Título: " . $document['title'] . "\n";
				    //echo "Texto: " . $document['text'] . "\n";
				    //echo "Tipo: " . ($document['type'] ?? 'N/A') . "\n";
				    
				    
				    //echo "Capa: " . $document['cover'] . "\n";
				foreach ($cursor as $document) {
					if ($document['type'] === 0) {
						
					
			?>
				
				    
				    
					    <article>
							<span class="views">2 views</span>
							<a href="<?php echo INCLUDE_PATH . "article?id=". $document['id']?>"> 
								<h3><?php echo $document['title'];?></h3>
							</a>
							<p><?php echo $document['text']?> ...</p>
							<span class="timepost">1 hour and 35 secs ago</span>
						</article>
			<?php  
					}
				}

			?>	
			
		</div>
	</section>

	<aside class="w30">
		<?php include("includes/sidebar.php"); ?>
	</aside>

	<footer>
		<!-- Adicionar oque quiser-->
	</footer>

</body>

</html>