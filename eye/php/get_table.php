<?php
include('../config.php');
if (!isset($_POST['nome']) or !isset($_POST['ip'])) {


$sql = Mysql::connect()->prepare('SELECT * FROM user_logs');
$sql->execute();

$info = $sql->fetchAll(PDO::FETCH_ASSOC);
//print_r($info);


?>

<table>
	<thead>
		<tr>
			<th>Nome do usuario</th>
			<th>Endereço IP</th>
			<th>Latítude</th>
			<th>Longitude</th>
			<th>Status</th>
		</tr>
	</thead>
	<?php foreach ($info as $key => $row){ ?>
		<tr>
		    <td><?= htmlspecialchars($row['username']) ?></td>
		    <td><?= htmlspecialchars($row['ip_address']) ?></td>
		    <td><?= htmlspecialchars($row['latitude']) ?></td>
		    <td><?= htmlspecialchars($row['longitude']) ?></td>
		    <td>
		        <?php
					$tempoOffline = time() - strtotime($row['last_online']);

					if ($tempoOffline < 300) {
						echo "On";
					} else {
						echo $row['last_online'];
					}
				?>

		    </td>
		</tr>
	<?php }?>
</table>

<?php }else{
	$params = [];
	$conditions = [];


	if (isset($_POST['nome']) and $_POST['ip']=='') {
		$sql = Mysql::connect()->prepare('SELECT * FROM user_logs WHERE username LIKE :termo');
		$sql->bindValue(':termo', $_POST['nome'].'%'); // Adiciona o % para busca parcial
		$sql->execute();

		$info = $sql->fetchAll(PDO::FETCH_ASSOC);
	}else if(isset($_POST['ip']) and $_POST['nome'] == ''){

		$sql = Mysql::connect()->prepare('SELECT * FROM user_logs WHERE ip_address LIKE :termo');
		$sql->bindValue(':termo', $_POST['ip'].'%'); // Adiciona o % para busca parcial
		$sql->execute();

		$info = $sql->fetchAll(PDO::FETCH_ASSOC);

	}else{
		$params[':nome'] = $_POST['nome'] . '%';
		$params[':ip'] = $_POST['ip'] . '%';

		$sql = Mysql::connect()->prepare('SELECT * FROM user_logs WHERE ip_address LIKE :ip and username LIKE :nome');
		//$sql->bindValue(':termo', $_POST['ip'].'%'); // Adiciona o % para busca parcial
		foreach ($params as $key => $value) {
		    $sql->bindValue($key, $value);
		}
		$sql->execute();

		$info = $sql->fetchAll(PDO::FETCH_ASSOC);

	}

?>


<table>
	<thead>
		<tr>
			<th>Nome do usuario</th>
			<th>Endereço IP</th>
			<th>Latítude</th>
			<th>Longitude</th>
			<th>Status</th>
		</tr>
	</thead>
	<?php foreach ($info as $key => $row){ ?>
		<tr>
		    <td><?= htmlspecialchars($row['username']) ?></td>
		    <td><?= htmlspecialchars($row['ip_address']) ?></td>
		    <td><?= htmlspecialchars($row['latitude']) ?></td>
		    <td><?= htmlspecialchars($row['longitude']) ?></td>
		    <td>
		        <?php
					$tempoOffline = time() - strtotime($row['last_online']);

					if ($tempoOffline < 300) {
						echo "On";
					} else {
						echo $row['last_online'];
					}
				?>

		    </td>
		</tr>
	<?php }?>
</table>


<?php
	}
?>