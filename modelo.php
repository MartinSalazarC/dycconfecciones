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
                f_headerslider();
            ?>
		</div>
	</header>

	<main>
		<div class="container">
			<!-- Seccion xxxxxxxx -->
			<div class="row cuerpo">
				<div class="col">
				
				
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
