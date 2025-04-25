<?php
include('config.php');
$id = $_GET['id'];
$sqlP = Mysql::connect()->prepare('SELECT * FROM produtos where id = ?');
$sqlP->execute(array($id));

if ($sqlP->rowCount() ==1){
	$info = $sqlP->fetch();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Buy</title>
</head>
<body>
	<header class="container">
		<div>
			<a href=""> <img src="" alt="logo" title="logo"> </a>
		</div>
		<div class="forms">
			<div>
				
				<form action="show_prod.php">
					<input type="text" name="search" placeholder="Search">
					<input type="submit" name="submit" value="">
				</form>
			</div>
			
		</div>
		<p><?php echo $_SESSION['user']?></p>
		<a href="car_prod.php">Carrinho</a>
	</header>	
	<div class="sub_header"></div>
	

	<section class="container">
		<div class="w60 imgs">
			<!--<img src="<?php echo $info['imagem_url'];?>"> -->
			<img src="imgs_prods/pc.png">
		</div>

		<aside class="w40">
			<div class="buy">
				<p> <?php echo $info['nome'];?>, <?php echo $info['descricao'];?> </p>
				<p>R$ <?php echo $info['preco'];?> </p>

				<p>Estoque disponivel: <?php echo $info['estoque'];?> </p>

				<a onclick="return false;" href="https://pay.hotmart.com/E17257212N?checkoutMode=2" class="hotmart-fb ">Compre Agora</a> 

				<button>Adicionar ao carrinho</button>

				<p>Devolução grátis. Você tem 30 dias a partir da data de recebimento.</p>
				<p>Compra Garantida, receba o produto que está esperando ou devolvemos o dinheiro.</p>
			</div>
			<div class="meios">
				<h5>Meios de pagamento</h5>
				<div>
					<p>Linha de credito</p>
					<img src="imgs/image12.png">
				</div>
				<div>
					<p>Cartões de credito</p>
					<img src="imgs/image13.png">
					<img src="imgs/image14.png">
					<img src="imgs/image15.png">
					<img src="imgs/image16.png">
				</div>
				<div>
					<p>Cartões debito</p>
					<img src="imgs/image17.png">
				</div>
				<div>
					<p>Pix</p>
					<img src="imgs/image18.png">
				</div>
				<div>
					<p>Boleto bancário</p>
					<img src="imgs/image19.png">
				</div>
				
			</div>
		</aside>

		<div class="w60 desc">
			<h4>Descrição</h4>
			<!--<p><?php echo $info['descricao'];?></p>-->
			<p>
				Construímos Computadores com o mais alto padrão de qualidade.Buscamos oferecer produtos com tecnologia de ponta, que atendem às necessidades de hardware para os softwares que você utiliza.COMPUTADOR PROJETADO PARA QUALQUER ÁREA DE ATUAÇÃO:- ARQUITETURA- CONSTRUÇÃO- INDÚSTRIA CRIATIVA- ENGENHARIA- TOPOGRAFIA- MAPEAMENTO- PESQUISA- DESENVOLVIMENTOProcessador Intel Core I9 14900k- Socket LGA 1700 14ª Geração- Número de núcleos: 24- Nº de Performance-cores: 8- Nº de Efficient-cores: 16- Nº de threads: 32- Frequência Base: 3.2 GHz- Frequência Turbo Max: 6 GHz- Cache: 36 MB
			</p>
			
		</div>
	</section>


	<?php
		$sqlR = Mysql::connect()->prepare('SELECT * FROM produtos where categoria_id = ?');
		$sqlR->execute(array($info['categoria_id']));

		if ($sqlR->rowCount()!=0) {
			$infoR = $sqlR->fetchAll();
			//$infoR = $sqlR->fetchAll(PDO::FETCH_ASSOC);
			//print_r($infoR);
		}
	?>
	<section class="container">
		<h5>Produtos relacionados</h5>
		<div class="flex">
			<?php 
				foreach ($infoR as $key => $value){
			?>
			<div class="single__prod">
				<div>
					<img src="">
				</div>
				<div>
					<img width="10%" src="<?php echo $value['imagem_url'];?>">
					<p><?php echo $value['nome'];?></p>
					<p><?php echo $value['preco'];?></p>
					<p>Frete gratis</p>
				</div>
			</div>
			<?php
				}
			?>
			
		</div>
	</section>

	<?php
		$sqlN = Mysql::connect()->prepare('SELECT * FROM avaliacoes where produto_id = ?');
		$sqlN->execute(array($info['id']));

		if ($sqlN->rowCount()!=0) {
			$infoN = $sqlN->fetchAll();
			//$infoN = $sqlN->fetchAll(PDO::FETCH_ASSOC);
			//print_r($infoN);
		}
	?>
	<section class="container">
		<h5>Opiniões do produto</h5>
		<div class="op__box">

			<?php 
				foreach ($infoN as $key => $value){
			?>
			<div class="single__box">
				<p> <?php echo $value['nome_usuario'];?>, Nota: <?php echo $value['nota'];?> </p>
				<p><?php echo $value['comentario'];?></p>
			</div>

			<?php
				}
			?>
			
		</div>

	</section>



	<footer class="container footer1">
		
	</footer>
	<footer class="container footer2">
		
	</footer>


</body>
<script type="text/javascript">
	function importHotmart(){ 
 		var imported = document.createElement('script'); 
 		imported.src = 'https://static.hotmart.com/checkout/widget.min.js'; 
 		document.head.appendChild(imported); 
		var link = document.createElement('link'); 
		link.rel = 'stylesheet'; 
		link.type = 'text/css'; 
		link.href = 'https://static.hotmart.com/css/hotmart-fb.min.css'; 
		document.head.appendChild(link);	} 
 	importHotmart(); 
 </script> 

</html>