<?php include("config.php");
if ($_SESSION['login'] != true) {
	header('Location: login.php');
}
if(isset($_GET['loggout'])){
	setcookie('lembrar',$_COOKIE['lembrar'],time() - (60*60*24), '/');
	setcookie('user',$_COOKIE['user'],time() - (60*60*24), '/');
	setcookie('password',$_COOKIE['password'],time() - (60*60*24), '/');
	session_destroy();
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style/">
	<style type="text/css">
		.tables{
			display: flex;
			gap: 3%;
		}
		.tables div{
			border: 1px solid black;

		}
		.w33{
			width: 33%;
		}
	</style>
</head>
<body>
	<header>
		<div class="loggout">
			<a href="?loggout"> <i class="fa fa-window-close"></i> <span>Sair</span></a>
		</div><!--loggout-->
	</header>

	<section class='tables' id="tables">
	
	</section>
	<div class="tables ">
		<div class="w33">
			<form method="get" action="php/taskst.php" id="add">
		        <input type="text" name="task" id="texto">
		        <input type="submit" name="submit" value="add">
		    </form>
		</div>
	</div>


	<section id="grafico">
		
	</section>

	<footer>
		
	</footer>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script>
	$(document).ready(function(){
		show();    	
		$("#add").ajaxForm({

			success: function(response){
				$('#texto').val('');
				show();
			},
			error: function(xhr){
				console.log('erro ao enviar');
			}
		});
		
	});
	function show(){
		$.ajax({
			'beforeSend': function(){
				//console.log('teste');
			},
			'timeout': 1000,
			'url': "php/tasksinfo.php",
			'error':function(){
				console.log('Ocorreu um erro');
			},
			'success':function(data){
				$('#tables').html(data);
			}

		})
		return false;
	};
	function change(value,tsrc,tsrv){
		$.ajax({
			'beforeSend': function(){
				//console.log(value,tsrc,tsrv);
			},
			'timeout': 1000,
			'type': 'GET',
			'url': "php/taskchange.php",
			'data': {value: value,tsrc:tsrc, tsrv:tsrv},
			'error':function(){
				console.log('Ocorreu um erro');
			},
			'success':function(data){
				//console.log(data);
				show();
			}
		})
	}
	graph();
	setInterval(function(){
			graph();
	},10000)


	function graph() {
		$.ajax({
			'beforeSend': function(){
				//console.log(value,tsrc,tsrv);
			},
			'type': 'GET',
			'url': "php/infograph.php",
			'error':function(){
				console.log('Ocorreu um erro');
			},
			'success':function(data){
				//console.log(data);
				$('#grafico').html(data);
			}
		})
	}
</script>
</html>