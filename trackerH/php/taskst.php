<?php
include('../config.php');

if (isset($_GET['task'])) {

	$sql = Mysql::connect()->prepare("UPDATE tasks SET a_fazer = JSON_ARRAY_APPEND(a_fazer, '$', ?) where id_usuario = ?");
	$sql->execute(array($_GET['task'],$_SESSION['user_id']));
	
}
?>