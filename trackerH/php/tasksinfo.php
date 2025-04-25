<?php
	include('../config.php');
	$sql = Mysql::connect()->prepare('SELECT * FROM tasks where id_usuario = ?');
	$sql->execute(array($_SESSION['user_id']));

	if ($sql->rowCount() == 1) {
		$info = $sql->fetch();

		$a_fazer = json_decode($info['a_fazer']);
		$fazendo = json_decode($info['fazendo']);
		$feito = json_decode($info['feito']);
	}
	
?>

<div class="fazer w33">
    <h4>A Fazer</h4>
    <div id="task">

	    <?php
	    	foreach ($a_fazer as $key => $value){
	    ?>
	    
	    <p class='item'><?php echo $value;?><button onclick="change('<?php echo $value;?>','a_fazer','fazendo')">Move</button></p>

	    <?php		
	    	}
	    ?>
    </div>
    
</div>
<div class="fazendo w33">
    <h4>Fazendo</h4>
    <?php
    	foreach ($fazendo as $key => $value){
    ?>
    
    <p class='item'><button onclick="change('<?php echo $value;?>','fazendo','a_fazer')">Move</button><?php echo $value;?><button onclick="change('<?php echo $value;?>','fazendo','feito')">Move</button></p>

    <?php		
    	}
    ?>
</div>
<div class="feito w33">
    <h4>Feito</h4>
    <?php
    	foreach ($feito as $key => $value){
    ?>
    
    <p class='item'><?php echo $value;?></p>

    <?php		
    	}
    ?>
</div>	

