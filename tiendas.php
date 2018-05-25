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
			<!-- Seccion xxxxxxxx -->
			<div class="row cuerpo">
				<div class="col">
					<table width="800" border="0" align="center">
						<tr>
							<td height="90"></td>
						</tr>
						<tr>
							<td class="textCabTextos" colspan="2">CONT&Aacute;CTENOS</td>
						</tr>
						<tr>
							<td colspan="2"><hr></td>
						</tr>
					</table>
					<table width="800" border="0" align="center">
						<tr>
							<td colspan="3"  class="textTextos" >Para mayores detalles de nuestros productos, consultas, cotizaciones, o si deseas saber sobre los convenios con los colegios y universidades de nuestra región, puedes visitarnos en nuestras tiendas:</td>
						</tr>
						<tr>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
						</tr>
						<tr>
							<td colspan='3'>
								<table border='0' align='center' width='80%'>
									<tr>
										<td width='15%'></td>
										<td width='35%'></td>
										<td width='50%'></td>
									</tr>
						<?php
						$link = conectar_db();
						$c_local = "call sp_con_local_web()";
						$r_local = mysqli_query($link, $c_local);
						while($d_local = mysqli_fetch_array($r_local))
						{
							echo "
									<tr>
										<td align='center' class='textCabTabla' colspan='2'>".$d_local[1]."</td>
										<td rowspan='5' align='center'><iframe src='".$d_local[3]."' width='100%' height='100%' frameborder='0' style='border:0' allowfullscreen></iframe></td>
									</tr>
									<tr>
										<td colspan='2'>&nbsp;</td>
									</tr>
									<tr height='25'>
										<td class='textDescripcion' valign='top'>Direcci&oacute;n:</td>
										<td class='textDetalle' valign='top'>".$d_local[2]."</td>
									</tr>
									<tr height='25'>
										<td class='textDescripcion' valign='top'>Horario:</td>
										<td class='textDetalle' valign='top'>";
						$link = conectar_db();
						$c_hora = "call sp_con_horario_x_codlocal('".$d_local[0]."', 'A')";
						$r_hora = mysqli_query($link, $c_hora);
						while($d_hora = mysqli_fetch_array($r_hora))
						{
							echo  $d_hora[1].", ".$d_hora[2]."<br>";
						}
						desconectar_db();
							echo "								
										</td>
									</tr>
									<tr height='25'>
										<td class='textDescripcion' valign='top'>Tel&eacute;fono:</td>
										<td class='textDetalle' valign='top'>".$d_local[4]."</td>
									</tr>
									<tr height='25'>
										<td colspan='3'><hr></td>
									</tr>
									<tr height='20'>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>";
						}
						desconectar_db();
						?>
								</table>
							</td>
						</tr>
					</table>
				
				
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
