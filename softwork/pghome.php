<?php
include_once("dycFunctions/f_seguridad.php");

f_sessionopen();

include_once('dycFunctions/f_database.php');
include_once('dycFunctions/f_mensajes.php');
include_once('dycFunctions/f_generalphp.php');	
require_once("dycXajax/xajax_core/xajax.inc.php");
include_once('libs/menu.php');

function f_delFecImp($codfecha)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_delfec = "CALL sp_del_fechas_notifica_cliente('".$codfecha."', '".$_SESSION['cod_user']."')";
	$r_delfec = mysqli_query($link, $c_delfec);
	$d_delfec = mysqli_fetch_array($r_delfec);
	desconectar_db();
	
	$divCpoNotCli = f_conFecImp();
	
	$respuesta->Assign("divCpoNotCli", "innerHTML", $divCpoNotCli);
	return $respuesta;
}
function f_conFecImp()
{
	$cpo ="
		<table width='100%' border='0'>
			<tr>
				<td width='25%'></td>
				<td width='50%'></td>
				<td width='15%'></td>
				<td width='10%'></td>
			</tr>
			<tr class='textCabTabla2' height='20px'>
				<td align='left'>Documento</td>
				<td align='left'>Nombre / Raz&oacute;n Social</td>
				<td align='left'>Fecha</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='4'><hr></td>
			</tr>";

	$link = conectar_db();
	$c_confec = "CALL sp_con_fechas_notifica_cliente()";
	$r_confec = mysqli_query($link, $c_confec);
	$n_confec = mysqli_num_rows($r_confec);

	if($n_confec == 0)
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000060')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();
		
		$cpo.="
				<tr>
					<td colspan='4' class='".$d_msj[1]."'>".$d_msj[0]."</td>
				</tr>";
	}
	else
	{
		while ($d_confec = mysqli_fetch_array($r_confec))
		{
			$cpo.="
				<tr class='textDetalle' onmouseover='this.style.backgroundColor=\"#C1DA83\"' onmouseout='this.style.backgroundColor=\"#FFFFFF\"'>
					<td>".$d_confec[1]." - ".$d_confec[2]."</td>
					<td>".$d_confec[3]."</td>
					<td>".modifica_formato_fecha02($d_confec[4])."</td>
					<td align='center'>
						<button name='btnDelCal' type='button' onClick='xajax_f_delFecImp(\"".$d_confec[0]."\");'  title='Notificaci&oacute;n atendida'><img src='dycImages/button_cancel.gif'></button></td>
				</tr>";
		}
	}
	desconectar_db();

	$cpo."	
		</table>";	

	return $cpo;
}


$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_delFecImp");
$xajax->processRequest();
$xajax->configure('javascript URI','dycXajax/');
?>
<!DOCTYPE html>
<html lang='es'> <!-- <html xmlns="http://www.w3.org/1999/xhtml">   -->
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="IE=edge, width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" >
		
        <title><?php  echo $pestana; ?></title>
        
		<script src="bootstrap4/js/jquery-3.2.1.min.js"></script>
		<script src="bootstrap4/js/popper.min.js"></script>
		<script src="bootstrap4/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" href="bootstrap4/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/csshtml.css">
		<link rel="stylesheet" href="css/csstext.css">
		
		<link rel="stylesheet" type="text/css" href="dycCss/style03.css" >
        <script type='text/javascript' src='dycFunctions/f_javascript.js'></script>
		
		
	</head>
	<body>
		<?php  menu();  ?>
		<div class="container">
			<header class="row">
				<div class="col-12">
					<h5>Inicio / <small class="text-muted">Inicio</small></h5>
					<hr>
				</div>
			</header>
			<section class="contenedor-main row">
				<div class="col-md-4">
					<div class="card border-success">
						<div class="card-body">
							<?php
							$link = conectar_db();
							$c_cuadro01 = "call sp_con_datos_cuadro01('".$_SESSION['cod_user']."')";
							$r_cuadro01 = mysqli_query($link, $c_cuadro01);
							$n_cuadro01 = mysqli_num_rows($r_cuadro01);
							$d_cuadro01 = mysqli_fetch_array($r_cuadro01);
							desconectar_db();
							
							echo "<p class='textContenido01'>BIENVENIDO SR(A) <a href='pgmiperfil.php' class='textEnlace'>".$d_cuadro01[0]." ".$d_cuadro01[1]."</a></p>";
							echo "<p class='textContenido01'>&nbsp;&nbsp;USTED TIENES REGISTRADO ".$d_cuadro01[3]. " ACCESOS<p>";
							
							if (trim($d_cuadro01[5]) <> '')
								echo "<p class='textContenido01'>&nbsp;&nbsp;SU &Uacute;LTIMO ACCESO  FUE ".modifica_formato_fecha02($d_cuadro01[5])."</p>"; 
							if (trim($d_cuadro01[6]) <> '')
								echo "<p class='textContenido01'>&nbsp;&nbsp;SU &Uacute;LTIMO INTENTO ERRADO DE ACCESO  FUE ".modifica_formato_fecha02($d_est_cuadro01[6])."</p>"; 
							
							?>
						</div>
					</div>
				</div>

				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
								Accesos Directos
						</div>
						<div class="card-body">
							<button type="button" class="btn btn-primary ">Perfil</button>
							<button type="button" class="btn btn-primary ">Ventas</button>
							<button type="button" class="btn btn-primary ">Clientes</button>
							<button type="button" class="btn btn-primary ">Movimientos</button>
							<button type="button" class="btn btn-primary ">Inventario</button>
						</div>
					</div>
				</div>
			</section>
			<section class="row mt-3">
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							Productos por agotarse
						</div>
						<div class="card-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat.</p>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							Notificaciones Importantes
						</div>
						<div class="card-body">
						
							<ul class="list-group">
							<?php
								
								$link = conectar_db();
								$c_not = "CALL sp_con_not_msj_contacto()";
								$r_not = mysqli_query($link, $c_not);
								$d_not = mysqli_fetch_array($r_not);
								desconectar_db();
								
								if($d_not[0] <> 0)
								{
									echo "
										<li class='list-group-item d-flex justify-content-between align-items-center textContenido01'>
											Tiene mensajes sin responder registrados a través de la opción \"Contacto\"
											<h6><a href='pgadmmensajes.php' class='badge badge-pill badge-success'>".$d_not[0]." Mensaje(s)</a></h6>
										</li>";
								}
								
								
								$link = conectar_db();
								$c_rec = "CALL sp_con_not_msj_reclamo()";
								$r_rec = mysqli_query($link, $c_rec);
								$d_rec = mysqli_fetch_array($r_rec);
								desconectar_db();
								
								if($d_rec[0] <> 0)
								{
									echo "
										<li class='list-group-item d-flex justify-content-between align-items-center textContenido01'>
											Tiene registros de reclamos y/o sugerencias pendientes por atender en su bandeja
											<h6><a href='pgadmreclamos.php' class='badge badge-pill badge-success'>".$d_rec[0]." Mensaje(s)</a></h6>
										</li>";
								}
								
								$link = conectar_db();
								$c_recmax = "CALL sp_con_not_msj_reclamo_max()";
								$r_recmax = mysqli_query($link, $c_recmax);
								$d_recmax = mysqli_fetch_array($r_recmax);
								desconectar_db();
								
								if($d_recmax[0] <> 0)
								{
									echo "
										<li class='list-group-item d-flex justify-content-between align-items-center textContenido01'>
											Tiene registros de reclamos y/o sugerencias que superan los 25 días.  Recuerde, legalmente tiene hasta 30 días para responder.
											<h6><a href='pgadmreclamos.php' class='badge badge-pill badge-danger'>".$d_recmax[0]." Mensaje(s)</a></h6>
										</li>";
								}
							?>
							</ul>
							
						</div>
					</div>
					<br>
					<div class="card">
						<div class="card-header">
							Fechas Importantes de Clientes
						</div>
						<div class="card-body">
							<?php
							
							echo"
								<table class='table table-bordered table-hover table-sm'>
									<thead class='thead-default'>
										<th>Documento</th>
										<th>Nombre / Raz&oacute;n Social</th>
										<th>Fecha</th>
									</thead>";
							
							$link = conectar_db();
							$c_confec = "CALL sp_con_fechas_notifica_cliente()";
							$r_confec = mysqli_query($link, $c_confec);
							$n_confec = mysqli_num_rows($r_confec);
							
							if($n_confec == 0)
							{
								$link = conectar_db();
								$c_msj = "CALL sp_con_det_mensajes ('M000000060')";
								$r_msj = mysqli_query($link, $c_msj);
								$d_msj = mysqli_fetch_array($r_msj);
								desconectar_db();
								
								echo "	<tr>
											<td colspan='3' class='".$d_msj[1]."'><br><br>".$d_msj[0]."</td>
										</tr>";
							}
							else
							{
								while ($d_confec = mysqli_fetch_array($r_confec))
								{
									echo "
											<tr>
												<td>".$d_confec[1]." - ".$d_confec[2]."</td>
												<td>".$d_confec[3]."</td>
												<td>".modifica_formato_fecha02($d_confec[4])."</td>
											</tr>";
								}
							}
							desconectar_db();
							
							
							
						
							echo "	
								</table>";
							
							
							
							
							?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</body>
</html>