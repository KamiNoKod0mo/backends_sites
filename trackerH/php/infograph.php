<?php
	include('../config.php');
	$sql = Mysql::connect()->prepare('SELECT * FROM tasks where id_usuario = ?');
	$sql->execute(array($_SESSION['user_id']));

	if ($sql->rowCount() == 1) {
		$info = $sql->fetch();

		print_r(json_encode($info));


	}
	
?>