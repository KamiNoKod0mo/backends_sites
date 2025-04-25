<div class="title">
	<h2>--Trending News</h2>
</div>		
<div class="news">
	<?php
		$collection = \classes\Mongo::conexao1();
		$cursor = $collection->find(['type'=>1]);	
		foreach ($cursor as $document) {


	?>
		<div class="news__single">
			<img src="<?php echo $document['cover'];?>">
			<p><?php echo $document['title'];?></p>
		</div>
	<?php
		}
	?>
</div>