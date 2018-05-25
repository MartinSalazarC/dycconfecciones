<?php
session_start();
session_destroy();

include_once('libs/f_mensajes.php');
include_once('libs/f_database.php');
include_once('libs/f_headfooter.php');
require_once("xajax/xajax_core/xajax.inc.php" );

function f_ValidaReclamo($frmCliente, $frmProducto, $frmReclamo)
{  
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if ( trim($frmCliente['slcTipDoc']) =='' or trim($frmCliente['txtNroDoc'])=='' or trim($frmCliente['txtNombres'])=='' or trim($frmCliente['txtApellidos'])=='' or trim($frmCliente['txtDireccion'])=='' or trim($frmProducto['slcLocal'])=='' or trim($frmProducto['slcTipoBien'])=='' or trim($frmReclamo['slcTipo'])=='' or trim($frmReclamo['txtDetalle'])=='' )
	{
		$Msj = "Por favor completar todos los campos";
		$divMsj = "
	 		<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
	 			<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
	 				<span aria-hidden='true'>&times;</span>
	 			</button>
	 		</div>";
		$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	}
	else
	{	
		if ($frmCliente['slcIndMenor']=='N')
		{ 
			$frmCliente['txtNomPadres']='';
		}
		
		$link = conectar_db();
		$c_reclamo = "SELECT f_reg_reclamo( '".$frmCliente['slcTipDoc']."',  '".$frmCliente['txtNroDoc']."', '".$frmCliente['txtNombres']."', '".$frmCliente['txtApellidos']."', '".$frmCliente['txtDireccion']."', '".$frmCliente['txtTelefono']."', '".$frmCliente['txtCorreo']."', '".$frmCliente['slcIndMenor']."', '".$frmCliente['txtNomPadres']."', '".$frmProducto['slcLocal']."', '".$frmProducto['slcTipoBien']."', '".$frmProducto['txtMontoReclamado']."', '".$frmProducto['txtDescripcion']."', '".$frmReclamo['slcTipo']."', '".$frmReclamo['txtDetalle']."', '".$frmReclamo['txtPedido']."') from dual";
		$r_reclamo = mysqli_query($link, $c_reclamo);
		$d_reclamo = mysqli_fetch_array($r_reclamo);
		desconectar_db();
		
		$EnlaceConsultaReclamo = "http://localhost/dyccompe/consultareclamo.php";
		$divRegReclamo = "
			<div class='row justify-content-center mt-5'>
				<div class='col-10 col-md-8 justify-content-center text-center textSubTitulo'>
					Su reclamo ha sido registrado. <br>
					En un m&aacute;ximo de <b>30 d&iacute;as calendario</b> usted tendr&aacute; una respuesta a su reclamo.<br><br><br>
					Recuerde que podr&aacute; consultar en cualquier momento la respuesta de su registro a trav&eacute;s de este medio haciendo uso de la opci&oacute;n <em><a href='".$EnlaceConsultaReclamo."'>Consulta de Reclamaciones</a></em> con su tipo y n&uacute;mero de documento de identidad.<br><br><br><br><br>
					
				</div>
			</div>";
			
		$respuesta->Assign("divRegReclamo", "innerHTML", $divRegReclamo);
	}
	
	return $respuesta;
}
function f_ActivaNombrePadre($ind)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if ($ind=='N')
	{
		$divNomPadres = "<input type='text' name='txtNomPadres' id='txtNomPadres' class='form-control form-control-sm textContenido01' placeholder='Nombre del Padre o Apoderado' disabled>";
	}
	else
	{
		$divNomPadres = "<input type='text' name='txtNomPadres' id='txtNomPadres' maxlength='200' onKeyPress='return onlyAlpha(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' value='' class='form-control form-control-sm textContenido01' placeholder='Nombre del Padre o Apoderado'>";
	}
	
	$respuesta->Assign("divNomPadres", "innerHTML", $divNomPadres);
	return $respuesta;
}

$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_ActivaNombrePadre");
$xajax->register(XAJAX_FUNCTION, "f_ValidaReclamo");
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
					<div class="col-12 col-md-10">
						<div class='row justify-content-center mt-4'>
							<div class='col-3 col-md-1 justify-content-center text-center'><img src='img/libroreclamacion.png' width='60'></div>
							<div class='col-9 col-md-11 textTitulo'>LIBRO DE RECLAMACIONES</div>
						</div>
						<hr>
						
						<div id='divRegReclamo'>						
							<div class='row justify-content-center mt-2'>
								<div class='col-10 col-md-8 justify-content-center text-center textSubTitulo'>Conforme a lo establecido en el C&Oacute;digo de Protecci&Oacute;n y Defensa del Consumidor, contamos con un Libro de Reclamaciones virtual a tu disposici&Oacute;n.</div>
							</div>
							
							<div class="card border-warning">
								<div class="card-header textSubTitulo">
									<b>Identificaci&Oacute;n del consumidor que presenta el reclamo</b>
								</div>
								<div class="card-body">
									<form name = 'frmDatConsumidor' action='' method='post' class='justify-content-center'>
										<div class='form-group row'>
											<div class='col-12 col-sm-5 col-lg-3 mb-1'>
												<label for='slcTipDoc' class='textDescripcion01'>Tipo de Documento *</label>
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
											<div class='col-12 col-sm-7 col-lg-4 mb-1'>
												<label for='txtNroDoc' class='textDescripcion01'>N&uacute;mero *</label>
												<input type='number' name='txtNroDoc' id='txtNroDoc' class='form-control form-control-sm textContenido01' maxlength='20' onKeyPress='return onlyNumeric(event);' placeholder='N&uacute;mero' >
											</div>
										</div>
										<div class='form-group row'>
											<div class='col-12 col-md-6 mb-1'>
												<label for='txtApellidos' class='textDescripcion01'>Apellidos *</label>
												<input type='text' name='txtApellidos' id='txtApellidos' class='form-control form-control-sm textContenido01' maxlength='50' onKeyPress='return onlyAlpha(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Apellido del Consumidor'  >
											</div>
											<div class='col-12 col-md-6 mb-1'>
												<label for='txtNombres' class='textDescripcion01'>Nombres * </label>
												<input type='text' name='txtNombres' id='txtNombres' class='form-control form-control-sm textContenido01' maxlength='50' onKeyPress='return onlyAlpha(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Nombre del Consumidor'  >
											</div>
										</div>
										<div class='form-group row'>
											<div class='col-12 col-md-12 mb-1'>
												<label for='txtDireccion' class='textDescripcion01'>Direcci&oacute;n * </label>
												<input type='text' name='txtDireccion' id='txtDireccion' class='form-control form-control-sm textContenido01' maxlength='150' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Direcci&oacute;n del Consumidor'  >
											</div>
										</div>
										<div class='form-group row'>
											<div class='col-12 col-md-3 mb-1'>
												<label for='txtTelefono' class='textDescripcion01'>Tel&eacute;fono</label>
												<input type='number' name='txtTelefono' id='txtTelefono' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);'  min='900000000' max='999999999' placeholder='Tel&eacute;fono'  >
											</div>
											<div class='col-12 col-md-9 mb-1'>
												<label for='txtCorreo' class='textDescripcion01'>Correo electr&oacute;nico</label>
												<input type='email' name='txtCorreo' id='txtCorreo' class='form-control form-control-sm textContenido01min' maxlength='50' placeholder='CORREO ELECTR&Oacute;NICO'  >
											</div>
										</div>
										<div class='form-group row'>
											<div class='col-12 col-md-2 mb-1'>
												<label for='slcIndMenor' class='textDescripcion01'>Menor de edad?</label>
												<select name='slcIndMenor' id='slcIndMenor' class='form-control textContenido01 form-control-sm' onChange="xajax_f_ActivaNombrePadre(document.frmDatConsumidor.slcIndMenor.options[document.frmDatConsumidor.slcIndMenor.selectedIndex].value);">
													<option value="N" selected>No</option>
													<option value="S">S&iacute;</option>
												</select>
											</div>
											<div class='col-12 col-md-10 mb-1'>
												<label for='txtNomPadres' class='textDescripcion01'>Nombre del Padre o Apoderado</label>
												<div id="divNomPadres"><input type='text' name='txtNomPadres' id='txtNomPadres' class='form-control form-control-sm textContenido01' placeholder='Nombre del Padre o Apoderado' disabled></div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<br>
							<div class="card border-warning">
								<div class="card-header textSubTitulo">
									<b>Datos del producto o servicio contratado</b>
								</div>
								<div class="card-body">
									<form name = 'frmDatProducto' action='' method='post' class='justify-content-center'>
										<div class='form-group row'>
											<div class='col-12 col-sm-10 mb-1'>
												<label for='slcLocal' class='textDescripcion01'>Local *</label>
												<select name='slcLocal' id='slcLocal' class='form-control textContenido01 form-control-sm'>
													<option value="">[Local de Venta]</option>
											<?php
											$link = conectar_db();
											$c_local = "call sp_con_local_web()";
											$r_local = mysqli_query($link, $c_local);
											
											while($d_local=mysqli_fetch_array($r_local))
											{
												echo "<option value='".$d_local[0]."'>".$d_local[1]." - ".$d_local[2]."</option>";
											}
											desconectar_db();
											?>
												</select>
											</div>
										</div>
										<div class='form-group row'>
											<div class='col-12 col-md-4'>
												<label for='slcTipoBien' class='textDescripcion01'>Tipo de bien contratado *</label>
												<select name="slcTipoBien" id='slcTipoBien' class='form-control textContenido01 form-control-sm'>
													<option value="">[Tipo de Bien]</option>
											<?php
											$link = conectar_db();
											$c_bien = "call sp_con_mae_tabla_det_x_cod_tabla('P002')";
											$r_bien = mysqli_query($link, $c_bien);
											while($d_bien = mysqli_fetch_array($r_bien))
											{
												echo "<option value='".$d_bien[0]."'>".$d_bien[4]."</option>";
											}
											desconectar_db();
											?> 
													</select>
												<label for='txtMontoReclamado' class='textDescripcion01 mt-4 mb-3'>Monto Reclamado</label>
												<input type='number' name='txtMontoReclamado' id='txtMontoReclamado' class='form-control form-control-sm textContenido01' maxlength='12' onKeyPress='return onlyNumeric2(event);' placeholder='Importe'  >
											</div>
											<div class='col-12 col-md-8'>
												<label for='txtDescripcion' class='textDescripcion01'>Descripci&Oacute;n:</label>
												<textarea name="txtDescripcion" id="txtDescripcion" rows="6" onKeyPress="return onlyAlphaNumeric(event);" onChange="aMayusculas(this);" onBlur="aMayusculas(this);" class='form-control form-control-sm textContenido01' placeholder='Descripción del producto o servicio contratado'></textarea>
											</div>
										</div>
									</form>
								</div>
							</div>
							<br>
							<div class="card border-warning">
								<div class="card-header textSubTitulo">
									<b>Detalle de la reclamaci&oacute;n y pedido del consumidor</b>
								</div>
								<div class="card-body">
									<form name = 'frmDatReclamo' action='' method='post' class='justify-content-center'>
										<div class='form-group row'>
											<div class='col-12 col-sm-3 mb-1'>
												<label for='slcTipo' class='textDescripcion01'>Tipo Pedido *</label>
												<select name='slcTipo' id='slcTipo' class='form-control textContenido01 form-control-sm'>
													<option value="">[Tipo de Pedido]</option>
											<?php
											$link = conectar_db();
											$c_tipserv = "call sp_con_mae_tabla_det_x_cod_tabla('P003')";
											$r_tipserv = mysqli_query($link, $c_tipserv);
											while($d_tipserv = mysqli_fetch_array($r_tipserv))
											{
												echo "<option value='".$d_tipserv[0]."'>".$d_tipserv[4]."</option>";
											}
											desconectar_db();
											?> 
												</select>
											</div>
										</div>
										<div class='form-group row'>
											<div class='col-12 col-md-6'>
												<label for='txtDetalle' class='textDescripcion01'>Detalle del Reclamo *</label>
												<textarea name="txtDetalle" id="txtDetalle" rows="6" onKeyPress="return onlyAlphaNumeric(event);" onChange="aMayusculas(this);" onBlur="aMayusculas(this);" class='form-control form-control-sm textContenido01' placeholder='Descripción del reclamo'></textarea>
											</div>
											<div class='col-12 col-md-6'>
												<label for='txtPedido' class='textDescripcion01'>Pedido </label>
												<textarea name="txtPedido" id="txtPedido" rows="6" onKeyPress="return onlyAlphaNumeric(event);" onChange="aMayusculas(this);" onBlur="aMayusculas(this);" class='form-control form-control-sm textContenido01' placeholder='Descripción del pedido o lo que solicita'></textarea>
											</div>
										</div>
									</form>
								</div>
							</div>
							<br>					
							<div class=' row'>
								<div class='col-12 col-md-12 mb-0 text-right textDescripcion01Der'>
									* Campos obligatorios
								</div>
							</div>
							<div id="divMsj"></div>
							<div class='form-group row'>
								<div class='col-12 col-sl-12 mt-2 justify-content-center text-center'>
									<button name='cmdGrabar' type='button' class='btn btn-warning textBotonMin2' title='Enviar' onClick='xajax_f_ValidaReclamo(xajax.getFormValues(frmDatConsumidor), xajax.getFormValues(frmDatProducto), xajax.getFormValues(frmDatReclamo));' >REGISTRAR</button>
									<button name='cmdLimpiar' type='reset' class='btn btn-info textBotonMin2' title='Limpiar'>LIMPIAR</button>
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
