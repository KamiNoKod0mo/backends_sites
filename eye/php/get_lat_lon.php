<?php
	include("../config.php");
    $sql = Mysql::connect()->prepare('SELECT latitude, longitude FROM user_logs');
    $sql->execute();
    $info = $sql->fetchAll(PDO::FETCH_ASSOC);
    //print_r($info);
    $coords = [];

    foreach ($info as $key => $value){
    	$coords[$key] = [$value['longitude'],$value['latitude']];
    	//echo $value['latitude'].','.$value['longitude'];

    }
    print_r(json_encode($coords));

?>