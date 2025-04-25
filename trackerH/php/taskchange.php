<?php
include('../config.php');
if (isset($_GET['value']) and isset($_GET['tsrc']) and isset($_GET['tsrv'])) {

	if ($_GET['tsrc'] == 'a_fazer' and $_GET['tsrv'] == 'fazendo') {
		$sql = Mysql::connect()->prepare("SELECT a_fazer FROM tasks where id_usuario = ?");
		$sql->execute(array($_SESSION['user_id']));

		$info = $sql->fetch();
		//print_r($info);
		if ($info and isset($info['a_fazer'])) {
			$aFazer = json_decode($info['a_fazer']);

			$key = array_search($_GET['value'], $aFazer);

			if ($key !== false) {
				unset($aFazer[$key]);
				$aFazer = array_values($aFazer);
	            $newAFazer = json_encode($aFazer);

	            $upsql = Mysql::connect()->prepare("UPDATE tasks SET a_fazer = ? WHERE id_usuario = ?");
	            $upsql->execute(array($newAFazer,$_SESSION['user_id']));

	            $movsql = Mysql::connect()->prepare("UPDATE tasks SET fazendo = JSON_ARRAY_APPEND(fazendo, '$', ?) where id_usuario = ?");
				$movsql->execute(array($_GET['value'],$_SESSION['user_id']));
			}
		}
	}


	if ($_GET['tsrc'] == 'fazendo' and $_GET['tsrv'] == 'feito') {
		$sql = Mysql::connect()->prepare("SELECT fazendo FROM tasks where id_usuario = ?");
		$sql->execute(array($_SESSION['user_id']));

		$info = $sql->fetch();
		//print_r($info);
		if ($info and isset($info['fazendo'])) {
			$aFazendo = json_decode($info['fazendo']);

			$key = array_search($_GET['value'], $aFazendo);

			if ($key !== false) {
				unset($aFazendo[$key]);
				$aFazendo = array_values($aFazendo);
	            $newAFazendo = json_encode($aFazendo);

	            $upsql = Mysql::connect()->prepare("UPDATE tasks SET fazendo = ? WHERE id_usuario = ?");
	            $upsql->execute(array($newAFazendo,$_SESSION['user_id']));

	            $movsql = Mysql::connect()->prepare("UPDATE tasks SET feito = JSON_ARRAY_APPEND(feito, '$', ?) where id_usuario = ?");
				$movsql->execute(array($_GET['value'],$_SESSION['user_id']));
			}
		}
	}

	if ($_GET['tsrc'] == 'fazendo' and $_GET['tsrv'] == 'a_fazer') {
		$sql = Mysql::connect()->prepare("SELECT fazendo FROM tasks where id_usuario = ?");
		$sql->execute(array($_SESSION['user_id']));

		$info = $sql->fetch();
		//print_r($info);
		if ($info and isset($info['fazendo'])) {
			$aFazendo = json_decode($info['fazendo']);

			$key = array_search($_GET['value'], $aFazendo);

			if ($key !== false) {
				unset($aFazendo[$key]);
				$aFazendo = array_values($aFazendo);
	            $newAFazendo = json_encode($aFazendo);

	            $upsql = Mysql::connect()->prepare("UPDATE tasks SET fazendo = ? WHERE id_usuario = ?");
	            $upsql->execute(array($newAFazendo,$_SESSION['user_id']));

	            $movsql = Mysql::connect()->prepare("UPDATE tasks SET a_fazer = JSON_ARRAY_APPEND(a_fazer, '$', ?) where id_usuario = ?");
				$movsql->execute(array($_GET['value'],$_SESSION['user_id']));
			}
		}
	}
}

?>