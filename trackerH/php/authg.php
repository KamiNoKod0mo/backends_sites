<?php
	require('vendor/autoload.php');

	$gClient = new Google_Client();

	$gClient->setClientId("174055669550-p1idlgdbr01792v2cr6ek4l4om8ok4bu.apps.googleusercontent.com");
	$gClient->setClientSecret("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");

	$gClient->setRedirectUri('http://localhost/Projeto_etapa3/trackerH/login.php'); // tenho que habilitar no console do google

	//$gClient->addScope('email');
	$gClient->addScope(['email', 'profile']);


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
			
			$pass = md5($data['id']);

			
			if ($data['name'] != '' AND $pass != '' AND $data['email'] != ''){
				$sql = Mysql::connect()->prepare('SELECT * FROM usuario WHERE username = ? AND password = ?');
				$sql->execute(array($data['name'],$pass));
				//echo $sql->rowCount();

				if($sql->rowCount() != 0){
					
					$info = $sql->fetch();

					$_SESSION['login'] = true;
					
					$_SESSION['user'] = $data['name'];
					$_SESSION['user_id'] = $info['id'];
					session_write_close();
					header('Location: index.php');

				}else{
					$sql = Mysql::connect()->prepare("INSERT INTO usuario VALUES (null,?,?,?)");
					$sql->execute(array($data['name'],$data['email'],$pass));
					header('Location: index.php');
				}
			}

		}

	}
	
?>