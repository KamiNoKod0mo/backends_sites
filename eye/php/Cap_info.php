<?php
session_start();


class Localizacao {
    public function salvar($latitude, $longitude) {
        $_SESSION["latitude"] = $latitude;
        $_SESSION["longitude"] = $longitude;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lat = $_POST["latitude"] ?? null;
    $lon = $_POST["longitude"] ?? null;

    if ($lat && $lon) {
        $localizacao = new Localizacao();
        echo $localizacao->salvar($lat, $lon);
    } else {
        echo "Erro: Latitude ou Longitude ausente!";
    }
}



/*
use Sinergi\BrowserDetector\Browser;
require('vendor/autoload.php');

$browser = new Browser();
echo $browser->getName() ;		
*/
// Informações do IP com geoiploc
class Cap_info{
	function __construct(){
		$name_user = $this->cap_user();
		$ip_user = $this->cap_ip();
		$lat = $_SESSION['latitude'] ?? null;
		$lon = $_SESSION['longitude'] ?? null;
		$dete = date('Y-m-d H:i:s',time()+(60));

		$sql = Mysql::connect()->prepare('SELECT * FROM user_logs where username = ? and ip_address = ?');
		$sql->execute(array($name_user,$ip_user));
		
		if ($sql->rowCount()){
			$info = $sql->fetch();
			//print_r($info);
			$sqlUp = Mysql::connect()->prepare('UPDATE user_logs SET latitude = ?, longitude = ?, last_online = ? WHERE username = ? and ip_address = ?');
			$sqlUp->execute(array($lat, $lon, $dete, $name_user,$ip_user));

		}else{
			$sqlIn = Mysql::connect()->prepare('INSERT INTO user_logs (username, ip_address, latitude, longitude)  VALUES (?,?,?,?)');
			$sqlIn->execute(array($name_user,$ip_user,$lat,$lon));
		}


	}

	private function cap_ip(){
		$ip = $_SERVER["REMOTE_ADDR"];
		return $ip;
	}
	private function cap_user(){
		$user = 'CarlosFarias2';
		return $user;
	}
}


?>