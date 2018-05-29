<?php
session_start();
session_destroy();

//include_once('libs/f_mensajes.php');
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
                f_headerslider();
      ?>
		</div>
	</header>

	<main>
		<div class="container">
			
			<div class="row my-3">
				<div class="col">
					<div class="card bg-warning text-white">
						<div class="card-body">
							<h3 class="card-title">Lorem ipsum dolor.</h3>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo, quibusdam.</p>
							<a href="#" class="btn btn-light">Ir al post</a>
						</div>
					</div>
				</div>
				
				<div class="col">
					<div class="card border-warning">
						<div class="card-body">
							<h3 class="card-title">Lorem ipsum dolor.</h3>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo, quibusdam.</p>
							<a href="#" class="btn btn-warning">Ir al post</a>
						</div>
					</div>
				</div>
				
				<div class="col">
					<div class="card border-warning">
						<div class="card-body">
							<h3 class="card-title">Lorem ipsum dolor.</h3>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo, quibusdam.</p>
							<a href="#" class="btn btn-warning">Ir al post</a>
						</div>
					</div>
				</div>
				
				<div class="col">
					<div class="card bg-warning text-white">
						<div class="card-body">
							<h3 class="card-title">Lorem ipsum dolor.</h3>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo, quibusdam.</p>
							<a href="#" class="btn btn-light">Ir al post</a>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Seccion Portafolio -->
			<div class="row portafolio">
				<div class="col">
					<div class="row mt-3 mb-3 justify-content-center">
						<div class="col-10 text-center">
							<button type="button" class="btn btn-outline-warning textCabeceraSector">Los <b>mejores productos</b> en un solo lugar</button>
						</div>
					</div>
					
					<div class="row galeria justify-content-center">
						<div class="contenedor-imagen col-6 col-lg-4">
							<a href="#" data-toggle="modal" data-target="#modal">
								<img src="img/img-1.jpg" class="img-fluid imagen" alt="">
							</a>
						</div>
						<div class="contenedor-imagen col-12 col-lg-8">
							<a href="#" data-toggle="modal" data-target="#modal">
								<img src="img/img-2.jpg" class="img-fluid imagen" alt="">
							</a>
						</div>
						<div class="contenedor-imagen col-12 col-lg-8">
							<a href="#" data-toggle="modal" data-target="#modal">
								<img src="img/img-3.jpg" class="img-fluid imagen" alt="">
							</a>
						</div>
						<div class="contenedor-imagen col-6 col-lg-4">
							<a href="#" data-toggle="modal" data-target="#modal">
								<img src="img/img-4.jpg" class="img-fluid imagen" alt="">
							</a>
						</div>
						<div class="contenedor-imagen col-6 col-lg-4">
							<a href="#" data-toggle="modal" data-target="#modal">
								<img src="img/img-5.jpg" class="img-fluid imagen" alt="">
							</a>
						</div>
						<div class="contenedor-imagen col-6 col-lg-4">
							<a href="#" data-toggle="modal" data-target="#modal">
								<img src="img/img-6.jpg" class="img-fluid imagen" alt="">
							</a>
						</div>
						<div class="contenedor-imagen col-6 col-lg-4">
							<a href="#" data-toggle="modal" data-target="#modal">
								<img src="img/img-7.jpg" class="img-fluid imagen" alt="">
							</a>
						</div>

						<!-- Ventana Modal -->
						<div class="modal fade" id="modal">
							<div class="modal-dialog d-flex justify-content-center align-items-center">
								<div class="modal-content">
									<img src="img/img-1.jpg" alt="" id="imagen-modal" class="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row mt-3 mb-3 justify-content-center">
				<div class="col-10 text-center">
					<button type="button" class="btn btn-outline-warning textCabeceraSector">Nuestros clientes quedan satisfechos</button>
				</div>
			</div>
			
			
			<div class="row mt-3">
				<div class="col-6">
					<div class="card">
						<img src="img/bg.jpg" class="card-img-top img-fluid" alt="">
						<div class="card-body">
							<h3 class="card-title">Titulo</h3>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium similique vero perferendis dolorem in libero id omnis, esse nesciunt corrupti?</p>
							<a href="#" class="btn btn-primary btn-lg btn-block">Boton</a>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="card">
						<img src="img/bg2.jpg" class="card-img-top img-fluid" alt="">
						<div class="card-body">
							<h3 class="card-title">Titulo</h3>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium similique vero perferendis dolorem in libero id omnis, esse nesciunt corrupti?</p>
							<a href="#" class="btn btn-primary btn-lg btn-block">Boton</a>
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
