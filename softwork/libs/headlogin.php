<?php
function head()
{
	$EnlaceHome = "http://localhost/dyccompe";
	
	echo"
		<nav class='navbar navbar-expand-lg navbar-light bg-warning fixed-top'>
			<!-- .container nos permite centrar el contenido de nuestro menu, esta clase es opcional y podemos encerrar el menu <nav> o incluir el contenedor dentro del <nav> -->
			<div class='container'>
				<!-- Nos sirve para agregar un logotipo al menu -->
				<a href='".$EnlaceHome."'><img class='img-fluid float-left img-thumbnail navbar-brand' src='dycImages/logo01.png' alt='' width='75px'></a>
				<p>D&C Confecciones</p>
				<!-- Nos permite usar el componente collapse para dispositivos moviles -->
			</div>
		</nav>
		<!-- Menu -->
		<nav class='col-md-12 col-lg-auto menu d-flex align-items-stretch flex-wrap flex-sm-nowrap'>
		</nav>
		
		";
		
}
?>