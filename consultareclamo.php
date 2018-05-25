<?php
session_start();
session_destroy();

include_once('libs/f_mensajes.php');
include_once('libs/f_database.php');
include_once('libs/f_headfooter.php');
include_once('libs/f_generalphp.php');
require_once("xajax/xajax_core/xajax.inc.php" );

function f_listareclamo($form)
{	
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if ( trim($form['slcTipDoc']) =="" or trim($form['txtNroDoc'])=="")
	{
		$Msj = "Debe seleccionar el tipo de documento y luego digitar el n&uacute;mero correspondiente";
		$divCpo = "
	 		<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
	 			<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
	 				<span aria-hidden='true'>&times;</span>
	 			</button>
	 		</div>";
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	}
	else
	{
		$link = conectar_db();
		$c_detRec = "call sp_con_reclamo('".trim($form['slcTipDoc'])."', '".trim($form['txtNroDoc'])."')";
		$r_detRec = mysqli_query($link, $c_detRec);
		$n_detRec = mysqli_num_rows($r_detRec);
		
		if($n_detRec == 0)
		{
			$Msj = "NO HAY REGISTROS DE RECLAMOS PARA EL TIPO Y N&Uacute;MERO DE DOCUMENTO INGRESADOS";
			$divCpo = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
			$respuesta->Assign("divCpo", "innerHTML", $divCpo);
		}
		else
		{
			$divCpo = "
				<div class='row justify-content-center'>
					<div class='col-12 justify-content-center'>
						<form name = 'frmLisRec' action='' method='post' class='justify-content-center'>
							<table class='table table-responsive table-hover table-sm'>
								<thead class='table-primary textThTabla01'>
									<th width='12%' class='text-center'>Fec. Registro</th>
									<th width='15%' class='text-center'>Documento</th>
									<th width='35%' class='text-center'>Apellidos y Nombres</th>
									<th width='15%' class='text-center'>Tipo Reclamo</th>
									<th width='15%' class='text-center'>Estado</th>
									<th width='8%'  class='text-center'>Acciones</th>
								</thead>";
			
			while($d_detRec = mysqli_fetch_array($r_detRec))
			{
				$divCpo.= "	<tr class='table-sm'>
									<td class='text-center textContenido01'>".modifica_formato_fecha03($d_detRec[1])."</td>
									<td class='text-center textContenido01'>".$d_detRec[6]." - ".$d_detRec[4]."</td>
									<td class='textContenido01'>".$d_detRec[5]."</td>
									<td class='text-center textContenido01'>".$d_detRec[2]."</td>
									<td class='text-center textContenido01'>".$d_detRec[7]."</td>
									<td class='text-center textContenido01'>
										<input name='cmdConsulta' type='button' class='btn btn-info btn-sm textBotonMin' value='Consultar' onClick='xajax_f_conreclamo(\"".$d_detRec[0]."\");' /></td>
								</tr>";			
			}
			
			$divCpo.= "
							</table>
						</form>
					</div>
				</div>";
			
			desconectar_db(); 
			
			$respuesta->Assign("divCpo", "innerHTML", $divCpo);
		}  
	}
	return $respuesta;
}
function f_conreclamo($codigo)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_detRec = "call sp_con_reclamo_x_cod(".$codigo.")";
	$r_detRec = mysqli_query($link, $c_detRec);
	$d_detRec = mysqli_fetch_array($r_detRec);
	desconectar_db();
	
	$divCpo = "
		<div class='card border-warning'>
			<div class='card-header textSubTitulo'>
				<b>Registro presentado</b>
			</div>
			<div class='card-body'>
				<h6>
					<b>Identificaci&oacute;n del consumidor que presenta el reclamo</b>
				</h6>
				<form name = 'frmDatConsumidor' action='' method='post' class='justify-content-center'>
					<div class='form-group row'>
						<div class='col-12 col-sm-5 col-lg-4 mb-1'>
							<label for='txtTipDoc' class='textDescripcion01'>Tipo de Documento </label>
							<input type='text' name='txtTipDoc' id='txtTipDoc' class='form-control form-control-sm textContenido01' value='".$d_detRec[1]."' disabled>
						</div>
						<div class='col-12 col-sm-7 col-lg-4 mb-1'>
							<label for='txtNroDoc' class='textDescripcion01'>N&uacute;mero </label>
							<input type='number' name='txtNroDoc' id='txtNroDoc' class='form-control form-control-sm textContenido01' value='".$d_detRec[2]."' disabled>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-6 mb-1'>
							<label for='txtApellidos' class='textDescripcion01'>Apellidos </label>
							<input type='text' name='txtApellidos' id='txtApellidos' class='form-control form-control-sm textContenido01' value='".$d_detRec[3]."' disabled>
						</div>
						<div class='col-12 col-md-6 mb-1'>
							<label for='txtNombres' class='textDescripcion01'>Nombres  </label>
							<input type='text' name='txtNombres' id='txtNombres' class='form-control form-control-sm textContenido01' value='".$d_detRec[4]."' disabled>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-12 mb-1'>
							<label for='txtDireccion' class='textDescripcion01'>Direcci&oacute;n  </label>
							<input type='text' name='txtDireccion' id='txtDireccion' class='form-control form-control-sm textContenido01' value='".$d_detRec[5]."' disabled>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-3 mb-1'>
							<label for='txtTelefono' class='textDescripcion01'>Tel&eacute;fono</label>
							<input type='number' name='txtTelefono' id='txtTelefono' class='form-control form-control-sm textContenido01' value='".$d_detRec[6]."' disabled>
						</div>
						<div class='col-12 col-md-9 mb-1'>
							<label for='txtCorreo' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtCorreo' id='txtCorreo' class='form-control form-control-sm textContenido01min' value='".$d_detRec[7]."' disabled>
						</div>
					</div>";
	
	$menor = "SI";
	if ($d_detRec[8] == "N")
		$menor = "NO";
	
	$divCpo.= "		<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtIndMenor' class='textDescripcion01'>Menor de edad?</label>
							<input type='text' name='txtIndMenor' id='txtIndMenor' class='form-control form-control-sm textContenido01' value='".$menor."' disabled>
						</div>
						<div class='col-12 col-md-10 mb-1'>
							<label for='txtNomPadres' class='textDescripcion01'>Nombre del Padre o Apoderado</label>
							<input type='text' name='txtNomPadres' id='txtNomPadres' class='form-control form-control-sm textContenido01' value='".$d_detRec[9]."' disabled>
						</div>
					</div>
				</form>
				<h6>
					<b>Datos del producto o servicio contratado</b>
				</h6>
				<form name = 'frmDatProducto' action='' method='post' class='justify-content-center'>
					<div class='form-group row'>
						<div class='col-12 col-sm-10 mb-1'>
							<label for='txtLocal' class='textDescripcion01'>Local </label>
							<input type='text' name='txtLocal' id='txtLocal' class='form-control form-control-sm textContenido01' value='".$d_detRec[10]."' disabled>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-4'>
							<label for='txtTipoBien' class='textDescripcion01'>Tipo de bien contratado </label>
							<input type='text' name='txtTipoBien' id='txtTipoBien' class='form-control form-control-sm textContenido01' value='".$d_detRec[11]."' disabled>
							<label for='txtMontoReclamado' class='textDescripcion01 mt-4 mb-3'>Monto Reclamado</label>
							<input type='number' name='txtMontoReclamado' id='txtMontoReclamado' class='form-control form-control-sm textContenido01' value='".$d_detRec[12]."' disabled>
						</div>
						<div class='col-12 col-md-8'>
							<label for='txtDescripcion' class='textDescripcion01'>Descripci&Oacute;n:</label>
							<textarea name='txtDescripcion' id='txtDescripcion' rows='6' class='form-control form-control-sm textContenido01' readonly>".$d_detRec[13]."</textarea>
						</div>
					</div>
				</form>
				<h6>
					<b>Detalle de la reclamaci&oacute;n y pedido del consumidor</b>
				</h6>
				<form name = 'frmDatReclamo' action='' method='post' class='justify-content-center'>
					<div class='form-group row'>
						<div class='col-12 col-sm-3 mb-1'>
							<label for='txtTipo' class='textDescripcion01'>Tipo Pedido </label>
							<input type='text' name='txtTipo' id='txtTipo' class='form-control form-control-sm textContenido01' value='".$d_detRec[14]."' disabled>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-6'>
							<label for='txtDetalle' class='textDescripcion01'>Detalle del Reclamo </label>
							<textarea name='txtDetalle' id='txtDetalle' rows='6' class='form-control form-control-sm textContenido01' readonly>".$d_detRec[15]."</textarea>
						</div>
						<div class='col-12 col-md-6'>
							<label for='txtPedido' class='textDescripcion01'>Pedido </label>
							<textarea name='txtPedido' id='txtPedido' rows='6' class='form-control form-control-sm textContenido01' readonly>".$d_detRec[16]."</textarea>
						</div>
					</div>
				</form>
			</div>
		</div>
		<br>
		<div class='card border-warning'>
			<div class='card-body'>
				<h6>
					<b>Respuesta del Reclamo</b>
				</h6>
				<form name = 'frmRptaRec' action='' method='post' class='justify-content-center'>
					<div class='form-group row justify-content-around'>
						<div class='col-12 col-sm-5 mb-1'>
							<label for='txtTipDoc' class='textDescripcion01'>Fecha de Registro</label>
							<input type='text' name='txtTipDoc' id='txtTipDoc' class='form-control form-control-sm textContenido01' value='".$d_detRec[17]."' disabled>
						</div>
						<div class='col-12 col-sm-5 mb-1'>
							<label for='txtNroDoc' class='textDescripcion01'>Fecha de Respuesta</label>
							<input type='number' name='txtNroDoc' id='txtNroDoc' class='form-control form-control-sm textContenido01' value='".$d_detRec[18]."' disabled>
						</div>
					</div>
					<div class='form-group row justify-content-center'>
						<div class='col-12 col-md-11'>
							<label for='txtDescripcion' class='textDescripcion01'>Descripci&Oacute;n:</label>
							<textarea name='txtDescripcion' id='txtDescripcion' rows='6' class='form-control form-control-sm textContenido01' readonly>".$d_detRec[19]."</textarea>
						</div>
					</div>
				</form>
			</div>
		</div>
		<br>";
		
		$divFrm = "";
		
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
		$respuesta->Assign("divFrm", "innerHTML", $divFrm);
		return $respuesta;
}

$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_listareclamo");
$xajax->register(XAJAX_FUNCTION, "f_conreclamo");
$xajax->processRequest();
$xajax->configure('javascript URI','xajax/');
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
		<?php
			$xajax->printJavascript('xajax/');
		?>
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
			<!-- Seccion contacto -->
			<div class="container">
				<div class="row cuerpo justify-content-center">
					<div class="col-12 col-md-11">
						<div class='row justify-content-center mt-4'>
							<div class='col-3 col-md-1 justify-content-center text-center'><img src='dycImages/libroreclamaciones.png' width='60'></div>
							<div class='col-9 col-md-11 textTitulo'>CONSULTA DE RECLAMOS</div>
						</div>
						<hr>
						<div class='row justify-content-center mt-2'>
							<div class='col-10 col-md-10 text-justify textSubTitulo'>
								Usted tiene este medio para consultar su registro realizado a trav&eacute;s del Libro de Reclamaciones.  Seleccione su tipo de documento, luego digite su n&uacute;mero de documento y consulte el estado de su registro.  
								<br><br>
								Si su registro figura como atendido podrá visualizar la respuesta emitida por nosotros.  Tenga en cuenta que tenemos hasta 30 d&iacute;as calendarios desde que hizo su registro para otorgarle una respuesta.
								<br><br>
							</div>
						</div>
						<br>
						<div id="divFrm">
							<div class='row justify-content-center mt-2'>
								<div class='col-10 col-md-8 text-center'>
									<form action="" method="post" name="frmConReclamo" class="justify-content-center">	
										<div class='form-group row'>
											<div class='col-12 col-md-5 col-lg-5 text-left'>
												<label for='slcTipDoc' class='textDescripcion01'>Tipo de Documento</label>
												<select name='slcTipDoc' id='slcTipDoc' class='form-control textContenido01 form-control-sm'>
													<option value=''>[Documento]</option>
										<?php
										$link = conectar_db();
										$c_tipdoc = "call sp_con_mae_tabla_det_x_cod_tabla('P001')";
										$r_tipdoc = mysqli_query($link, $c_tipdoc);
										while ($d_tipdoc = mysqli_fetch_array($r_tipdoc))
										{
											echo "	<option value='".$d_tipdoc[0]."'>".$d_tipdoc[4]."</option>";
										}
										desconectar_db();
										?>
												</select>
											</div>
											<div class='col-12 col-md-5 col-lg-5 text-left'>
												<label for='txtNroDoc' class='textDescripcion01'>N&uacute;mero de Documento</label>
												<input type='number' name='txtNroDoc' id='txtNroDoc' class='form-control form-control-sm textContenido01' maxlength='20' onKeyPress='return onlyNumeric(event);' placeholder='N&uacute;mero' >
											</div>
											<div class='col-12 col-md-2 col-lg-2 mt-4 text-center'>
												<button name='cmdBuscar' type='button' class='btn btn-success textBotonMin mr-3' title='Buscar' onClick="xajax_f_listareclamo(xajax.getFormValues(frmConReclamo));" >Consultar</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div id="divCpo" class="justify-content-center"></div>
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
	