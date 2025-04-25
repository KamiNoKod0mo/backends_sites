<?php include("config.php");

$ini = new Cap_info();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
	<title>God eye</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style type="text/css">
		#map {
		  height: 375px;
		  width: 100%;
		}

	</style>
</head>
<body>

	<?php include("sidebar.php");?>

	<header class="container">
		<div class="title">
			<h3>God eyes - HOME</h3>
		</div>
		<div class="filter_box">
			<form>
				<input type="text" name="nome" id="nome" placeholder="Nome">
				<input type="text" name="ip" id="ip" placeholder="Ip">
				<input type="submit" name="filter" value="Pesquisar">
			</form>
		</div>
	</header>

	<section class="container">
		<div id="tabela_info">
			
		</div>

		<div class="box_info">
			<div>
				
			</div>
			<div>
				
			</div>
			<div>
				
			</div>
		</div>
	</section>

	<section class="container">
		<div id="map"></div>

			
		</div>
	</section>



</body>
<script type="text/javascript">
	var inpN = ''
	var ip = ''
	document.addEventListener("DOMContentLoaded", function () {
		setInterval(function(){
		    inpN = document.getElementById('nome').value;
		    ip = document.getElementById('ip').value;
		   	//console.log(inpN); // Para verificar se o valor foi capturado corretamente
		},500);

		setInterval(function(){
		if (inpN == '' && ip == '' ) {
			//console.log(inpN);
			let tab = document.getElementById('tabela_info');
			fetch("php/get_table.php")
			    .then(response => response.text()) // Converte resposta para texto
			    .then(data => tab.innerHTML=data)   // Exibe a resposta no console
			    .catch(error => console.error("Erro:", error));
		}else{
			//console.log(inpN);
			let tab = document.getElementById('tabela_info');
			fetch("php/get_table.php", {
		        method: "POST",
		        headers: { "Content-Type": "application/x-www-form-urlencoded" },
		        body: "nome=" + encodeURIComponent(inpN) + "&ip=" + encodeURIComponent(ip)
		    })
		    .then(response => response.text())
		    .then(data => tab.innerHTML=data)
		    .catch(error => console.error("Erro na requisição:", error));
		}

	    },1000);
	});
	
</script>
<script>

navigator.geolocation.getCurrentPosition(function(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;

    fetch("php/Cap_info.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "latitude=" + lat + "&longitude=" + lon
    })
    .then(response => response.text())
    .then(data => console.log("Concluidi:",data))
    .catch(error => console.error("Erro na requisição:", error));
});

</script>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.3.0/dist/ol.js"></script>
<script>
    // Inicializa o mapa
    const map = new ol.Map({
      target: 'map',
      layers: [
        new ol.layer.Tile({ source: new ol.source.OSM() }) // Base map (OpenStreetMap)
      ],
      view: new ol.View({
        //center: ol.proj.fromLonLat([-47.879, -15.788]), // Centro do mapa (Brasília)
        //zoom: 12
      })
    });

    // Estilo do marcador
    const markerStyle = new ol.style.Style({
      image: new ol.style.Icon({
        src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png', // Ícone personalizado
        scale: 0.05,
        anchor: [0.5, 1]
      })
    });

	async function carregarLocations() {
	    try {
	        const response = await fetch("php/get_lat_lon.php");
	        const locations = await response.json();
	        //console.log("Locations pronto:", locations);
	        return locations;
	    } catch (error) {
	        console.error("Erro:", error);
	        return [];
	    }
	}

	carregarLocations().then(locations => {
	    const filteredLocations = locations.filter(coord => {  // Parâmetro renomeado para 'coord'
	        return coord[0] !== null && coord[1] !== null;  // Usando o parâmetro correto
	    });

	    var locations = filteredLocations; // ✅ Agora funciona
	    //console.log(typeof(locations));	    
	    //console.log(locations);

	    const markers = locations.map(coords => {
	      const marker = new ol.Feature({
	        geometry: new ol.geom.Point(ol.proj.fromLonLat(coords))
	      });
	      marker.setStyle(markerStyle);
	      return marker;
	    });

	    // Adiciona todos os marcadores ao mapa
	    const vectorLayer = new ol.layer.Vector({
	      source: new ol.source.Vector({
	        features: markers
	      })
	    });
	    map.addLayer(vectorLayer);

	    // Opcional: Ajusta a visualização para englobar todos os marcadores
	    map.getView().fit(vectorLayer.getSource().getExtent(), {
	      padding: [50, 50, 50, 50], // Margens
	      maxZoom: 14
	    });
	});    
  </script>
</html>