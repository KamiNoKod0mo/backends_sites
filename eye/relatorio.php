<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Report</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<?php include("sidebar.php");?>
	<header class="container">
		<div class="title">
			<h3>God eyes - Reports</h3>
		</div>
	</header>

	<section class="center">
		<form action="php/rel.php" method="post">
			<select name="tipo_relatorio">
				<option value="" disabled selected>Tipo de relatorio</option>
				<option value="tudo">Tudo</option>
			</select>
			<label for="date_ini">Data inicial</label>
			<input type="date" name="date_ini" placeholder="Data inicial">
			<label for="date_fin">Data final</label>
			<input type="date" name="date_fin" placeholder="Data final">
			<select name="tipo_arquivo">
				<option value="" disabled selected>Escolha um formato</option>
				<option>PDF</option>
				<option>Word</option>
				<option>Excel</option>
			</select>
			<input type="password" name="pass_admin" placeholder="Senha do Admin">
			<!-- <input type="password" name="pass_crip" placeholder="Senha de criptografia">-->
			<input type="checkbox" name="check" id="checkEmail">
			<input type="email" name="email" id="emailDestino" placeholder="email de destino" disabled>
			<input type="submit" name="submit" value="Concluir">
		</form>
	</section>

</body>
<script>
document.getElementById('checkEmail').addEventListener('change', function() {
    const emailField = document.getElementById('emailDestino');
    emailField.disabled = !this.checked;
    
    // Opcional: focar no campo quando habilitado
    if (this.checked) {
        emailField.focus();
    }
});
</script>
</html>