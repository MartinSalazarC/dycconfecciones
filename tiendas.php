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
							NUESTRAS TIENDAS
							<br>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-12 textContenido02min">
							Para mayores detalles de nuestros productos, consultas, cotizaciones, o si deseas saber sobre los convenios con los colegios y universidades de nuestra región, puedes visitarnos en nuestras tiendas:
							<br>
						</div>
					</div>
					<?php
					
					$link = conectar_db();
					$c_local = "call sp_con_local_web()";
					$r_local = mysqli_query($link, $c_local);
					$n_local = mysqli_num_rows($r_local);
					
					if ($n_local % 2 == 0)
					{
						$num_filas = $n_local / 2;
						$ind_par = 'S';
					}
					else
					{
						$num_filas = ($n_local + 1) / 2;
						$ind_par = 'N';
					}
					
					for ($i = 1; $i <= $num_filas; $i++)
					{
						if ($i < $num_filas or ($i == $num_filas and $ind_par == 'S'))
						{
							//pinto 2
							$d_local = mysqli_fetch_array($r_local);
							echo "
								<div class='card-group mt-3'>
											<div class='card border-warning'>
												<div class='card-header textTitulo'>".$d_local[1]."</div>
												<div class='text-center'><iframe src='".$d_local[3]."' width='90%' height='100%' frameborder='0' style='border:0' allowfullscreen ></iframe></div>
												<div class='card-body'>
													<p class='textContenido02min'><b><u>Direcci&oacute;n</u>: </b>".$d_local[2]."</p>
													<p class='textContenido02min'><b><u>Tel&eacute;fono</u>: </b>".$d_local[4]."</p>
													<p class='textContenido02min'><b><u>Horario</u>: </b></p>";
							$link = conectar_db();
							$c_hora = "call sp_con_horario_x_codlocal('".$d_local[0]."', 'A')";
							$r_hora = mysqli_query($link, $c_hora);
							while($d_hora = mysqli_fetch_array($r_hora))
							{
								echo  "<p class='textContenido02min'>&nbsp;&nbsp;&nbsp;".$d_hora[1].", ".$d_hora[2]."<p>";
							}
							desconectar_db();
							
							echo "
												</div>
											</div>";
							$d_local = mysqli_fetch_array($r_local);
							echo "		
											<div class='card border-warning'>
												<div class='card-header textSubTitulo'>".$d_local[1]."</div>
												<div class='text-center'><iframe src='".$d_local[3]."' width='90%' height='100%' frameborder='0' style='border:0' allowfullscreen ></iframe></div>
												<div class='card-body'>
													<p class='textContenido02min'><b><u>Direcci&oacute;n</u>: </b>".$d_local[2]."</p>
													<p class='textContenido02min'><b><u>Tel&eacute;fono</u>: </b>".$d_local[4]."</p>
													<p class='textContenido02min'><b><u>Horario</u>: </b></p>";
							$link = conectar_db();
							$c_hora = "call sp_con_horario_x_codlocal('".$d_local[0]."', 'A')";
							$r_hora = mysqli_query($link, $c_hora);
							while($d_hora = mysqli_fetch_array($r_hora))
							{
								echo  "<p class='textContenido02min'>&nbsp;&nbsp;&nbsp;".$d_hora[1].", ".$d_hora[2]."<p>";
							}
							desconectar_db();
							
							echo "	
												</div>
											</div>
								</div>";
						}
						else
						{
							//pinto 1
							$d_local = mysqli_fetch_array($r_local);
							echo "
								<div class='row mt-3  justify-content-center'>
									<div class='col-6'>
										<div class='card border-warning'>
											<div class='card-header textSubTitulo'>".$d_local[1]."</div>
											<div class='text-center'><iframe src='".$d_local[3]."' width='90%' height='100%' frameborder='0' style='border:0' allowfullscreen ></iframe></div>
											<div class='card-body'>
												<p class='textContenido02min'><b><u>Direcci&oacute;n</u>: </b>".$d_local[2]."</p>
												<p class='textContenido02min'><b><u>Tel&eacute;fono</u>: </b>".$d_local[4]."</p>
												<p class='textContenido02min'><b><u>Horario</u>: </b></p>";
							$link = conectar_db();
							$c_hora = "call sp_con_horario_x_codlocal('".$d_local[0]."', 'A')";
							$r_hora = mysqli_query($link, $c_hora);
							while($d_hora = mysqli_fetch_array($r_hora))
							{
								echo  "<p class='textContenido02min'>&nbsp;&nbsp;&nbsp;".$d_hora[1].", ".$d_hora[2]."<p>";
							}
							desconectar_db();
							
							echo "
											</div>
										</div>
									</div>
								</div>";
							
						}
					}
					desconectar_db();
					
					?>
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
