<?php
include_once("dycFunctions/f_seguridad.php");

f_sessionopen();

include_once('dycFunctions/f_database.php');
include_once('dycFunctions/f_mensajes.php');
include_once('dycFunctions/f_generalphp.php');
require_once("dycXajax/xajax_core/xajax.inc.php");
include_once('libs/menu.php');

function f_conusuperfil()
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');

	$divDetIzq = f_conusuperfilcpo();
	$divDetDer = f_conimgperfilcpo();
	
	$divDetBtn = "
		<button type='button' class='btn btn-primary btn-sm textBotonMin' onClick='xajax_f_modusuperfil();' >Modificar Datos</button>
		<button type='button' class='btn btn-success btn-sm textBotonMin' data-toggle='modal' data-target='#fm-modal-grid' onClick='xajax_f_limpiamensaje();'>Cambio de Clave</button>";
	
	$respuesta->Assign("divDetIzq", "innerHTML", $divDetIzq);
	$respuesta->Assign("divDetDer", "innerHTML", $divDetDer);
	$respuesta->Assign("divDetBtn", "innerHTML", $divDetBtn);
	return $respuesta;
}
function f_conusuperfilcpo()
{
	$link = conectar_db();
	$c_conusu = "call sp_con_usu_x_codusuario('".$_SESSION['cod_user']."')";
	$r_conusu = mysqli_query($link, $c_conusu);
	$d_conusu = mysqli_fetch_array($r_conusu);
	desconectar_db();

	$cpo = "
		<div class='row'>
			<div class='col'>
				<form name = 'frmConUsu' action='' method='post' class='justify-content-center'>
					<h6 class='textSubTitulo'>Datos Personales</h6>
					
					<div class='form-group row mb-1'>
						<div class='col-12 col-md-2'>
							<label for='txtUsuario' class='textDescripcion01'>Usuario</label>
							<input type='text' name='txtUsuario' id='txtUsuario' class='form-control form-control-sm textContenido01' value='".$d_conusu[0]."' readonly>
						</div>
						<div class='col-12 col-md-3'>
							<label for='txtTipDocPer' class='textDescripcion01'>Tipo de Documento</label>
							<input type='text' name='txtTipDocPer' id='txtTipDocPer' class='form-control form-control-sm textContenido01' value='".$d_conusu[20]."' readonly>
						</div>
						<div class='col-12 col-md-3'>
							<label for='txtNumDocPer' class='textDescripcion01'>N&uacute;mero de Documento</label>
							<input type='text' name='txtNumDocPer' id='txtNumDocPer' class='form-control form-control-sm textContenido01' value='".$d_conusu[21]."' readonly>
						</div>
						<div class='col-12 col-md-3'>
							<label for='txtFecNacPer' class='textDescripcion01'>Fecha de Nacimiento</label>
							<input type='text' name='txtFecNacPer' id='txtFecNacPer' class='form-control form-control-sm textContenido01' value='".modifica_formato_fecha03($d_conusu[22])."' readonly>
						</div>
					</div>
					
					<div class='form-group row mb-1'>
						<div class='col-12 col-md-5'>
							<label for='txtApellido' class='textDescripcion01'>Apellidos</label>
							<input type='text' name='txtApellido' id='txtApellido' class='form-control form-control-sm textContenido01' value='".$d_conusu[1]."' readonly>
						</div>
						<div class='col-12 col-md-5'>
							<label for='txtNombre' class='textDescripcion01'>Nombres</label>
							<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' value='".$d_conusu[2]."' readonly>
						</div>
					</div>
					
					<div class='form-group row mb-1'>
						<div class='col-12 col-md-6'>
							<label for='txtDomicilio' class='textDescripcion01'>Domicilio</label>
							<input type='text' name='txtDomicilio' id='txtDomicilio' class='form-control form-control-sm textContenido01' value='".$d_conusu[3]."' readonly>
						</div>
						<div class='col-12 col-md-6'>
							<label for='txtRefDom' class='textDescripcion01'>Referencia</label>
							<input type='text' name='txtRefDom' id='txtRefDom' class='form-control form-control-sm textContenido01 ' value='".$d_conusu[4]."' readonly>
						</div>
					</div>
				
					<div class='form-group row mb-3'>
						<div class='col-12 col-md-3 col-lg-3'>
							<label for='txtTelMovilPers' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilPers' id='txtTelMovilPers' class='form-control form-control-sm textContenido01' value='".$d_conusu[5]."' readonly>
						</div>
						<div class='col-12 col-md-3 col-lg-3'>
							<label for='txtTelFijoHogar' class='textDescripcion01'>Tel&eacute;fono Hogar</label>
							<input type='number' name='txtTelFijoHogar' id='txtTelFijoHogar' class='form-control form-control-sm textContenido01' value='".$d_conusu[6]."' readonly>
						</div>
						<div class='col-12 col-md-6 col-lg-4'>
							<label for='txtMailPers' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailPers' id='txtMailPers' class='form-control form-control-sm textContenido01min' value='".$d_conusu[7]."' readonly>
						</div>
					</div>
					
					<h6 class='textSubTitulo'>Datos Laborales</h6>
					
					<div class='form-group row mb-1'>
						<div class='col-12 col-md-3 col-lg-3'>
							<label for='slcSector' class='textDescripcion01'>Sector</label>
							<input type='text' name='slcSector' id='slcSector' class='form-control form-control-sm textContenido01' value='".$d_conusu[16]."' readonly>
						</div>
						<div class='col-12 col-md-3 col-lg-3'>
							<label for='slcCargo' class='textDescripcion01'>Cargo</label>
							<input type='text' name='slcCargo' id='slcCargo' class='form-control form-control-sm textContenido01' value='".$d_conusu[17]."' readonly>
						</div>
						<div class='col-12 col-md-4 col-lg-4'>
							<label for='slcLocal' class='textDescripcion01'>Local</label>
							<input type='text' name='slcLocal' id='slcLocal' class='form-control form-control-sm textContenido01' value='".$d_conusu[18]."' readonly>
						</div>
					</div>
					
					<div class='form-group row mb-1'>
						<div class='col-12 col-md-3'>
							<label for='txtTelMovilLab' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilLab' id='txtTelMovilLab' class='form-control form-control-sm textContenido01' value='".$d_conusu[11]."' readonly>
						</div>
						<div class='col-12 col-md-3'>
							<label for='txtTelFijoLab' class='textDescripcion01'>Tel&eacute;fono Fijo</label>
							<input type='number' name='txtTelFijoLab' id='txtTelFijoLab' class='form-control form-control-sm textContenido01' value='".$d_conusu[12]."' readonly>
						</div>
						<div class='col-12 col-md-2'>
							<label for='txtTelAnexoLab' class='textDescripcion01'>Anexo</label>
							<input type='number' name='txtTelAnexoLab' id='txtTelAnexoLab' class='form-control form-control-sm textContenido01' value='".$d_conusu[13]."' readonly>
						</div>
						<div class='col-12 col-md-4'>
							<label for='txtMailLab' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailLab' id='txtMailLab' class='form-control form-control-sm textContenido01min' value='".$d_conusu[14]."' readonly>
						</div>
					</div>
				</form>
			</div>
		</div>";
	
	return $cpo;
}
function f_conimgperfilcpo()
{
	$link = conectar_db();
	$c_conimgusu = "call sp_con_img_usuario('".$_SESSION['cod_user']."')";
	$r_conimgusu = mysqli_query($link, $c_conimgusu);
	$d_conimgusu = mysqli_fetch_array($r_conimgusu);
	desconectar_db();
	
	$img = "
		<div class='row justify-content-center align-center text-center'>
			<div class='col-12'>
				<div id='divImgEmpl'>
					<img class='img-fluid rounded float-center img-thumbnail' src='imgEmpl/".$d_conimgusu[0]."' alt=''>
				</div>
			</div>
		</div>";
	return $img;
}
function f_cambioclavedb($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');

	if (trim($form['txtClave']) ==  "" or trim($form['txtNueClave']) == "" or trim($form['txtConNueClave']) == "" )
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000017')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();

		$divMsjPass = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		$respuesta->Assign("divMsjPass", "innerHTML", $divMsjPass);
		return $respuesta;
	}
	elseif (trim($form['txtNueClave']) <> trim($form['txtConNueClave']) )
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000016')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();

		$divMsjPass = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		$respuesta->Assign("divMsjPass", "innerHTML", $divMsjPass);
		return $respuesta;
	}
	else
	{
		$link = conectar_db();
		$c_regclave = "call sp_reg_clave_usuario('".$_SESSION['cod_user']."','".trim($form['txtNueClave'])."', '".trim($form['txtClave'])."')";
		$r_regclave = mysqli_query($link, $c_regclave);
		$d_regclave = mysqli_fetch_array($r_regclave);
		desconectar_db();

		if ($d_regclave[0] == '2')
		{
			$link = conectar_db();
			$c_msj = "CALL sp_con_det_mensajes ('M000000018')";
			$r_msj = mysqli_query($link, $c_msj);
			$d_msj = mysqli_fetch_array($r_msj);
			desconectar_db();

			$divMsjPass = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
			$respuesta->Assign("divMsjPass", "innerHTML", $divMsjPass);
			return $respuesta;
		}
		elseif ($d_regclave[0] == '3')
		{
			$link = conectar_db();
			$c_msj = "CALL sp_con_det_mensajes ('M000000019')";
			$r_msj = mysqli_query($link, $c_msj);
			$d_msj = mysqli_fetch_array($r_msj);
			desconectar_db();

			$divMsjPass = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
			$respuesta->Assign("divMsjPass", "innerHTML", $divMsjPass);
			return $respuesta;
		}
		elseif ($d_regclave[0] == '0')
		{
			$link = conectar_db();
			$c_msj = "CALL sp_con_det_mensajes ('M000000020')";
			$r_msj = mysqli_query($link, $c_msj);
			$d_msj = mysqli_fetch_array($r_msj);
			desconectar_db();
			
			$divBtnCamCla = "<button type='button' class='btn btn-primary textBotonMin btn-sm' data-dismiss='modal'>Cerrar</button>";
			$divMsjPass = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."</div>";
			
			$respuesta->Assign("divBtnCamCla", "innerHTML", $divBtnCamCla);
			$respuesta->Assign("divMsjPass", "innerHTML", $divMsjPass);
			return $respuesta;
		}
	}
}
function f_modusuperfil()
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');

	$link = conectar_db();
	$c_conusu = "call sp_con_usu_x_codusuario('".$_SESSION['cod_user']."')";
	$r_conusu = mysqli_query($link, $c_conusu);
	$d_conusu = mysqli_fetch_array($r_conusu);
	desconectar_db();
	
	$divDetIzq = "
		<form name='frmModUsu' action='' method='post'>
			<div class='row'>
				<div class='col'>
					<form name = 'frmConUsu' action='' method='post' class='justify-content-center'>
						<h6 class='textSubTitulo'>Datos Personales</h6>
						
						<div class='form-group row mb-1'>
							<div class='col-12 col-md-2'>
								<label for='txtUsuario' class='textDescripcion01'>Usuario</label>
								<input type='text' name='txtUsuario' id='txtUsuario' class='form-control form-control-sm textContenido01' value='".$d_conusu[0]."' readonly>
							</div>
							<div class='col-12 col-md-3'>
								<label for='txtTipDocPer' class='textDescripcion01'>Tipo de Documento</label>
								<input type='text' name='txtTipDocPer' id='txtTipDocPer' class='form-control form-control-sm textContenido01' value='".$d_conusu[20]."' readonly>
							</div>
							<div class='col-12 col-md-3'>
								<label for='txtNumDocPer' class='textDescripcion01'>N&uacute;mero de Documento</label>
								<input type='text' name='txtNumDocPer' id='txtNumDocPer' class='form-control form-control-sm textContenido01' value='".$d_conusu[21]."' readonly>
							</div>
							<div class='col-12 col-md-3'>
								<label for='txtFecNacPer' class='textDescripcion01'>Fecha de Nacimiento</label>
								<input type='text' name='txtFecNacPer' id='txtFecNacPer' class='form-control form-control-sm textContenido01' value='".modifica_formato_fecha03($d_conusu[22])."' readonly>
							</div>
						</div>
						
						<div class='form-group row mb-1'>
							<div class='col-12 col-md-5'>
								<label for='txtApellido' class='textDescripcion01'>Apellidos</label>
								<input type='text' name='txtApellido' id='txtApellido' class='form-control form-control-sm textContenido01' value='".$d_conusu[1]."' readonly>
							</div>
							<div class='col-12 col-md-5'>
								<label for='txtNombre' class='textDescripcion01'>Nombres</label>
								<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' value='".$d_conusu[2]."' readonly>
							</div>
						</div>
						
						<div class='form-group row mb-1'>
							<div class='col-12 col-md-6'>
								<label for='txtDomicilio' class='textDescripcion01'>Domicilio</label>
								<input type='text' name='txtDomicilio' class='form-control form-control-sm textContenido01' maxlength='100' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' value='".$d_conusu[3]."' placeholder='Direcci&oacute;n'>
							</div>
							<div class='col-12 col-md-6'>
								<label for='txtRefDom' class='textDescripcion01'>Referencia</label>
								<input type='text' name='txtRefDom' class='form-control form-control-sm textContenido01'  maxlength='100' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' value='".$d_conusu[4]."' placeholder='Referencia del domicilio'>
							</div>
						</div>
					
						<div class='form-group row mb-3'>
							<div class='col-12 col-md-3 col-lg-3'>
								<label for='txtTelMovilPers' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
								<input type='text' name='txtTelMovilPers' class='form-control form-control-sm textContenido01' maxlength='12' onKeyPress='return onlyNumeric(event);' value='".$d_conusu[5]."' placeholder='Tel. Personal'>
							</div>
							<div class='col-12 col-md-3 col-lg-3'>
								<label for='txtTelFijoHogar' class='textDescripcion01'>Tel&eacute;fono Hogar</label>
								<input type='text' name='txtTelFijoHogar' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);' value='".$d_conusu[6]."' placeholder='Tel. Hogar'>
							</div>
							<div class='col-12 col-md-6 col-lg-4'>
								<label for='txtMailPers' class='textDescripcion01'>Correo electr&oacute;nico</label>
								<input type='email' name='txtMailPers' id='txtMailPers' class='form-control form-control-sm textContenido01min' maxlength='50'  value='".$d_conusu[7]."' placeholder='Correo Electr&oacute;nico'>
							</div>
						</div>
						
						<h6 class='textSubTitulo'>Datos Laborales</h6>
						
						<div class='form-group row mb-1'>
							<div class='col-12 col-md-3 col-lg-3'>
								<label for='slcSector' class='textDescripcion01'>Sector</label>
								<input type='text' name='slcSector' id='slcSector' class='form-control form-control-sm textContenido01' value='".$d_conusu[16]."' readonly>
							</div>
							<div class='col-12 col-md-3 col-lg-3'>
								<label for='slcCargo' class='textDescripcion01'>Cargo</label>
								<input type='text' name='slcCargo' id='slcCargo' class='form-control form-control-sm textContenido01' value='".$d_conusu[17]."' readonly>
							</div>
							<div class='col-12 col-md-4 col-lg-4'>
								<label for='slcLocal' class='textDescripcion01'>Local</label>
								<input type='text' name='slcLocal' id='slcLocal' class='form-control form-control-sm textContenido01' value='".$d_conusu[18]."' readonly>
							</div>
						</div>
						
						<div class='form-group row mb-1'>
							<div class='col-12 col-md-3'>
								<label for='txtTelMovilLab' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
								<input type='text' name='txtTelMovilLab' class='form-control form-control-sm textContenido01' maxlength='12' onKeyPress='return onlyNumeric(event);' value='".$d_conusu[11]."' placeholder='Tel. Personal'>
							</div>
							<div class='col-12 col-md-3'>
								<label for='txtTelFijoLab' class='textDescripcion01'>Tel&eacute;fono Fijo</label>
								<input type='text' name='txtTelFijoLab' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);' value='".$d_conusu[12]."' placeholder='Tel. Hogar'>
							</div>
							<div class='col-12 col-md-2'>
								<label for='txtTelAnexoLab' class='textDescripcion01'>Anexo</label>
								<input type='text' name='txtTelAnexoLab' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);' value='".$d_conusu[13]."' placeholder='Tel. Hogar'>
							</div>
							<div class='col-12 col-md-4'>
								<label for='txtMailLab' class='textDescripcion01'>Correo electr&oacute;nico</label>
								<input type='email' name='txtMailLab' id='txtMailLab' class='form-control form-control-sm textContenido01min' value='".$d_conusu[14]."' readonly>
							</div>
						</div>
					</form>
				</div>
			</div>
		</form>";
	
	$divDetBtn = "
		<button type='button' class='btn btn-success textBotonMin btn-sm' onClick='xajax_f_modusuperfildb(xajax.getFormValues(frmModUsu), xajax.getFormValues(frmUpload));'>Grabar Modificaci&oacute;n</button>
		<button type='button' class='btn btn-primary textBotonMin btn-sm' onClick='xajax_f_conusuperfil();'>Cancelar Modificación</button>";
	
	
	$link = conectar_db();
	$c_conimgusu = "call sp_con_img_usuario('".$_SESSION['cod_user']."')";
	$r_conimgusu = mysqli_query($link, $c_conimgusu);
	$d_conimgusu = mysqli_fetch_array($r_conimgusu);
	desconectar_db();
	
	if ($d_conimgusu[0] == 'pica01.jpg')
	
	
	$divDetDer = "
		<div class='row justify-content-center align-center text-center'>
			<div class='col-12 text-center'>
				<div id='divImgEmpl'>
					<img class='img-fluid rounded float-center img-thumbnail text-center' src='imgEmpl/".$d_conimgusu[0]."' alt='' >
				</div>
			</div>
		</div>
		<div class='row justify-content-center align-center text-center'>
			<div class='col-12'>
				<form name='frmUpload' method='post' enctype='multipart/form-data' action='libs/CtrlUploadDeleteImgNiv01.php' target='iframeUpload' >
					<input type='hidden' name='hddRutaBase' value='../imgEmpl' >
					<input type='hidden' name='hddRepositorio' value='".$_SESSION['cod_user']."' >
					<input type='hidden' name='hddCodFile' value='imgempl'>
					<input type='hidden' name='hddUsuario' value='".$_SESSION['cod_user']."'>
					<iframe name='iframeUpload' style='display:none'></iframe>
					<div class='form-group row justify-content-center'>
						<div class='col-auto col-md-auto mb-1'>
							<div id='fil_imgempl'>
								<input name='fileUpload' type='file' class='textBotonMin' onchange='submit(); xajax_f_ActImgPerfil(document.frmUpload.hddFile.value);'>
							</div>
						</div>
						<div class='col-auto col-md-auto mb-1'>
							<div id='opc_imgempl'><input type='hidden' name='hddAccion' value='upload' ></div>
						</div>
					</div>
				</form>
			</div>
		</div>";
	
	
	
	
	
	$respuesta->Assign("divDetIzq", "innerHTML", $divDetIzq);
	$respuesta->Assign("divDetDer", "innerHTML", $divDetDer);
	$respuesta->Assign("divDetBtn", "innerHTML", $divDetBtn);
	return $respuesta;
}
function f_modusuperfildb($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');

	if (trim($form['txtDomicilio']) == "")
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000017')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();

		$divMsjModUsu = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		
		$respuesta->Assign("divMsjModUsu", "innerHTML", $divMsjModUsu);
	}
	else
	{
		$link = conectar_db();
		$c_modperfil = "call sp_act_miperfil('".$_SESSION['cod_user']."','".trim($form['txtDomicilio'])."', '".trim($form['txtRefDom'])."', '".trim($form['txtTelMovilPers'])."', '".trim($form['txtTelFijoHogar'])."', '".trim($form['txtMailPers'])."', '".trim($form['txtTelMovilLab'])."', '".trim($form['txtTelFijoLab'])."',   '".trim($form['txtTelAnexoLab'])."')";
		$r_modperfil = mysqli_query($link, $c_modperfil);
		$d_modperfil = mysqli_fetch_array($r_modperfil);
		desconectar_db();

		if ($d_modperfil[0] ==  '0')
		{
			$divDetIzq = f_conusuperfilcpo();
			$divMsjModUsu = "";
			$divDetBtn = "
				<button type='button' class='btn btn-primary btn-sm textBotonMin' onClick='xajax_f_modusuperfil();' >Modificar Datos</button>
				<button type='button' class='btn btn-success btn-sm textBotonMin' data-toggle='modal' data-target='#fm-modal-grid' onClick='xajax_f_limpiamensaje();'>Cambio de Clave</button>";
			
			$respuesta->Assign("divDetBtn", "innerHTML", $divDetBtn);
			$respuesta->Assign("divDetIzq", "innerHTML", $divDetIzq);
			$respuesta->Assign("divMsjModUsu", "innerHTML", $divMsjModUsu);
		}
		else
		{
			$link = conectar_db();
			$c_msj = "CALL sp_con_det_mensajes ('M000000021')";
			$r_msj = mysqli_query($link, $c_msj);
			$d_msj = mysqli_fetch_array($r_msj);
			desconectar_db();

			$divMsjModUsu = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
			$respuesta->Assign("divMsjModUsu", "innerHTML", $divMsjModUsu);
		}
	}
	return $respuesta;
}
function f_limpiamensaje()
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');

	$divMsjPass = "";
	$respuesta->Assign("divMsjPass", "innerHTML", $divMsjPass);
	return $respuesta;
}
function f_ActImgPerfil($NomFile)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_actimgusu = "call sp_act_img_usuario('".$_SESSION['cod_user']."', '".$NomFile."')";
	$r_actimgusu = mysqli_query($link, $c_actimgusu);
	$d_actimgusu = mysqli_fetch_array($r_actimgusu);
	desconectar_db();	
	
	$link = conectar_db();
	$c_conimgusu = "call sp_con_img_usuario('".$_SESSION['cod_user']."')";
	$r_conimgusu = mysqli_query($link, $c_conimgusu);
	$d_conimgusu = mysqli_fetch_array($r_conimgusu);
	desconectar_db();
	
	$divImgEmpl = "<img class='img-fluid rounded float-center img-thumbnail' src='imgEmpl/MSALAZARC/".$d_conimgusu[0]."' alt=''>";
	
	$respuesta->Assign("divImgEmpl", "innerHTML", $divImgEmpl);
	return $respuesta;
}

$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_conusuperfil");
$xajax->register(XAJAX_FUNCTION, "f_cambioclavedb");
$xajax->register(XAJAX_FUNCTION, "f_cerrarcambioclave");
$xajax->register(XAJAX_FUNCTION, "f_modusuperfil");
$xajax->register(XAJAX_FUNCTION, "f_modusuperfildb");
$xajax->register(XAJAX_FUNCTION, "f_limpiamensaje");
$xajax->register(XAJAX_FUNCTION, "f_ActImgPerfil");
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

		<script type='text/javascript' src='dycFunctions/f_javascript.js'></script>
		<script type='text/javascript' src='dycFunctions/f_upload.js'></script>

		<?php
			$xajax->printJavascript('dycXajax/');
		?>
		
		<style>
			#customFile .custom-file-control:lang(es)::after {
				content: "Seleccione Archivo";
			}
		</style>
		
		
	</head>
	<body onLoad='xajax_f_conusuperfil();'>
		<?php  menu();  ?>
		<div class="container">
			<header class="row">
				<div class="col-12">
					<h5>Usuarios / <small class="text-muted">Perfil Personal</small></h5>
					<hr>
				</div>
			</header>
			<div class='row justify-content-center '>
				<div class='col-12 col-lg-9 mt-3 order-2 order-lg-1'>
					<div id="divDetIzq"></div> 
				</div>
				<div class='col-4 col-sm-5 col-lg-3 mt-1 order-1 order-lg-2 text-center align-center'>
					<div id="divDetDer"></div>
				</div>
			</div>
			<div class='row'>
				<div class='col-12 col-lg-12 mt-1 text-center'>
					<div id="divMsjModUsu"></div>
				</div>
			</div>
			<div class='row mt-3 mb-4'>
				<div class='col-12 col-lg-12 text-center'>
					<div id="divDetBtn">
						<button type='button' class='btn btn-primary btn-sm textBotonMin' onClick='xajax_f_modusuperfil();' >Modificar Datos</button>
						<button type='button' class='btn btn-success btn-sm textBotonMin' data-toggle='modal' data-target='#fm-modal-grid' onClick='xajax_f_limpiamensaje();'>Cambio de Clave</button>
					</div>
						<div class='modal fade' id='fm-modal-grid' tabindex='-1' role='dialog' aria-labelledby='fm-modal-grid' aria-hidden='true'>
							<div class='modal-dialog  modal-sm'>
								<div class='modal-content'>
									<div class='modal-header'>
										<h5 class='modal-title textSubTitulo' id='btncerrarx'>Cambio de clave</h5>
										<button name='btncerrarx' id='btncerrarx' class='close' data-dismiss='modal' aria-label='Cerrar'>
											<span aria-hidden='true'>&times;</span>
										</button>
									</div>

									<div class='modal-body'>
										<div class='container-fluid'>
											<div class='row justify-content-center'>
												<div class='col-12 col-sm-12'>
													<form name='frmPassUsu' action='' method='post'>
														<div class="form-group text-left">
															<label for="txtClave" class='textDescripcion01'>Clave Actual</label>
															<input name='txtClave' id='txtClave' type='password' class='form-control textContenido01' maxlength='15' onKeyPress='return onlyAlphaNumeric(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Clave Actual'>
														</div>

														<div class="form-group text-left">
															<label for="txtNueClave" class='textDescripcion01'>Nueva CLave</label>
															<input name='txtNueClave' id='txtNueClave' type='password' class='form-control textContenido01' maxlength='15' onKeyPress='return onlyAlphaNumeric(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Clave Actual'>
														</div>

														<div class="form-group text-left">
															<label for="txtConNueClave" class='textDescripcion01'>Confirme Nueva CLave</label>
															<input name='txtConNueClave' id='txtConNueClave' type='password' class='form-control textContenido01' maxlength='15' onKeyPress='return onlyAlphaNumeric(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Clave Actual'>
														</div>

														<div id='divMsjPass'>&nbsp;</div>

													</form>
												</div>
											</div>
										</div>
									</div>

									<div class='modal-footer'>
										<div id='divBtnCamCla'>
											<button type='button' class='btn btn-success textBotonMin btn-sm' onClick='xajax_f_cambioclavedb(xajax.getFormValues(frmPassUsu));'>Grabar</button>
											<button type='button' class='btn btn-primary textBotonMin btn-sm' data-dismiss='modal'>Cerrar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
