<?php
	@include('../config.php');
	require('vendor/autoload.php');

	$gClient = new Google_Client();

	$gClient->setClientId("x");
	$gClient->setClientSecret("x");

	$gClient->setRedirectUri('http://localhost/Projeto_etapa3/loja_virtual/php/authg.php'); // tenho que habilitar no console do google

	//$gClient->addScope('email');
	$gClient->addScope(['email', 'profile','openid']);


	if(!isset($_GET['code'])){
		//Precisamos logar.
		echo '<a href="'.$gClient->createAuthUrl().'"><img src="imgs/google.png"></a>';
	}else{
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		//print_r($token);
		if(!isset($token['error'])){
			
			$gClient->setAccessToken($token['access_token']);

			$_SESSION['access_token'] = $token['access_token'];


			$google_service = new Google_Service_Oauth2($gClient);

			$data = $google_service->userinfo->get();
			//print_r($data);
			

			
			if ($data['name'] != '' AND $data['id'] != '' AND $data['email'] != ''){
				$sql = Mysql::connect()->prepare('SELECT * FROM usuarios WHERE nome = ? AND email = ? and auth_provider = ? and provider_id = ?');
				$sql->execute(array($data['name'],$data['email'],'google',$data['id']));
				//echo $sql->rowCount();

				if($sql->rowCount() != 0){
					
					$info = $sql->fetch();

					$_SESSION['login'] = true;
					
					$_SESSION['user'] = $data['name'];
					$_SESSION['user_id'] = $info['id'];
					session_write_close();
					header('Location: ../index.php');

				}else{
					$sql = Mysql::connect()->prepare("INSERT INTO usuarios VALUES (null,?,?,null,?,?,null)");
					$sql->execute(array($data['name'],$data['email'],'google',$data['id']));
					header('Location: ../index.php');
				}
			}
			

		}

	}
	
?>