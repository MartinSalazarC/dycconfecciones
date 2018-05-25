<?php 
session_start();
session_destroy();

include_once('libs/f_mensajes.php');
include_once('libs/f_database.php');
include_once('libs/f_headfooter.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php  echo $pestana; ?></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<link rel="stylesheet" href="css/fontello.css">
	<link rel="stylesheet" href="css/estilos.css">
	<link rel="stylesheet" href="css/estilosfont.css">
</head>
<body>
	<header>
		<div class='container'>
			<?php
                f_headermenu();
            ?>
		</div>
	</header>

	<main>
		<div class="container">
			<div class="row cuerpo">
				<div class="col mb-5">
					<div class="row">
						<div class="col-12 textTitulo">
							NUESTRA EMPRESA
							<br>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-lg-3 col-md-4 textSubTitulo mb-3">
							<div class="list-group " id="lista" role="tablist">
								<a class="list-group-item list-group-item-action list-group-item-warning active" data-toggle="list" href="#elemento1" role="tab" aria-controls="elemento1">Qui&eacute;nes somos</a>
								<a class="list-group-item list-group-item-action list-group-item-warning" data-toggle="list" href="#elemento2" role="tab" aria-controls="elemento2">Nuestra Historia</a>
								<a class="list-group-item list-group-item-action list-group-item-warning" data-toggle="list" href="#elemento3" role="tab" aria-controls="elemento3">Misi&oacute;n</a>
								<a class="list-group-item list-group-item-action list-group-item-warning" data-toggle="list" href="#elemento4" role="tab" aria-controls="elemento4">Visi&oacute;n</a>
							</div>						
						</div>
						<div class="col-sm-12 col-lg-9 col-md-8">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="elemento1" role="tabpanel" aria-labelledby="elemento1">
									<h5>Qui&eacute;nes Somos</h5>
									<p class='textContenido02min text-justify'>Somos una empresa industrial de confecci&oacute;n y venta de uniformes en general. 
									Utilizamos insumos de muy buena calidad y empleamos dise&ntilde;os innovadores para lograr 
									superar las expectativas de nuestros clientes y que &eacute;stos se encuentren satisfechos 
									con nuestros productos.</p>
								</div>
								
								<div class="tab-pane fade show" id="elemento2" role="tabpanel" aria-labelledby="elemento2">
									<h5>Nuestra Historia</h5>
									<p class='textContenido02min text-justify'>La historia de DYC comienza hace algunos a&ntilde;os, cuando Claudia y Diego a&uacute;n eran enamorados. 
									Inicialmente abrieron un peque&ntilde;o puesto de lencer&iacute;a en el mercado de Piura, luego se fueron expandiendo 
									al Centro de Piura, pero debido a algunos problemas con la administraci&oacute;n del centro comercial, se tuvo que cerrar la tienda.  
									Posteriormente se casaron y decidieron poner su propia empresa DYC de venta y confecci&oacute;n de uniformes, la cual se form&oacute; 
									gracias a que Claudia hab&iacute;a trabajado durante varios a&ntilde;os en la empresa de sus padres.
									
									Siempre tuvieron miras en los negocios y en elaborar sus propias prendas, de esta forma fueron adquiriendo su maquinaria, recta, 
									remalladora y una bordadora SWF que les permit&iacute;a realizar los bordados de manera r&aacute;pida y con excelente calidad.
									
									Poco a poco fueron haci&eacute;ndose conocidos en el mercado de Piura por la calidad de sus prendas y llegaron a expandir su negocio a 
									Sechura gracias a una pareja de esposos sechuranos que un a&ntilde;o llegaron a solicitar la confecci&oacute;n de uniformes y al a&ntilde;o 
									siguiente regresaron para solicitar la confecci&oacute;n de uniformes para todos los alumnos del colegio. Gracias a la buena acogida de los 
									sechuranos, lograron poner una tienda en Sechura y tienen a su cargo la confecci&oacute;n de la mayor&iacute;a de uniforme de dicho distrito.
									
									Actualmente han expandido su negocio al centro de Piura, en una de las avenidas principales, con las ganas de seguir luchando y avanzando.</p>
								</div>
								
								<div class="tab-pane fade show" id="elemento3" role="tabpanel" aria-labelledby="elemento3">
									<h5>Nuestra Misi&oacute;n</h5>
									<p class='textContenido02min text-justify'>Nuestra misi&oacute;n es la confecci&oacute;n y venta de uniformes de excelente calidad, con dise&ntilde;os innovadores, 
									que nos permita cubrir las necesidades de nuestros clientes y que &eacute;stos se encuentren satisfechos con nuestros productos. Para ello contamos con un equipo humano 
									identificado y comprometido con la empresa que nos permite atender al cliente de manera personalizada y entregar sus productos de manera puntual.</p>
								</div>
								
								<div class="tab-pane fade show" id="elemento4" role="tabpanel" aria-labelledby="elemento4">
									<h5>Nuestra Visi&oacute;n</h5>
									<p class='textContenido02min text-justify'>Consolidarnos como una empresa l&iacute;der en el mercado de la confecci&oacute;n y venta de uniformes y 
									expandirnos a nivel nacional.</p>
								</div>
								
							</div>						
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<footer>
		<?php
			f_footer();
		?>
	</footer>

	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.js"></script>
</body>
</html>
