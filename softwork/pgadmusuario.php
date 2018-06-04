<?php
include_once("dycFunctions/f_seguridad.php");

f_sessionopen();

include_once('dycFunctions/f_database.php');
include_once('dycFunctions/f_mensajes.php');
include_once('dycFunctions/f_generalphp.php');
require_once("dycXajax/xajax_core/xajax.inc.php");
include_once('libs/menu.php');

function f_admusuario_ini()
{
		$respuesta = new xajaxResponse();
		$respuesta->setCharacterEncoding('ISO-8859-1');
		
		$divCab = f_admusuario_form();
		$divCpo = "";
		$divDet = "";
		$divMsj = "";
		
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
		$respuesta->Assign("divDet", "innerHTML", $divDet);
		$respuesta->Assign("divCab", "innerHTML", $divCab);
		$respuesta->Assign("divMsj", "innerHTML", $divMsj);
		return $respuesta;
}
	
function f_admusuario_form()
{
	$cab = "
		<div class='row'>
			<div class='col'>
				<div class='card'>
					<div class='card-body'>
						<form name='frmLisUsu' action='' method='post' class='justify-content-center'>
							<div class='form-group row justify-content-center'>
								<div class='col-12 col-lg-4 mt-1'>
									<label for='txtNombre' class='textDescripcion01 pr-1'>Usuario, Nombre o Apellidos:</label>
									<input type='text' name='txtNombre' id='txtNombre' class='form-control mr-3 textContenido01 form-control-sm' maxlength='50' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='' >
								</div>
								<div class='col-12 col-lg-4 mt-1'>
									<label for='slcLocal' class='textDescripcion01 pr-1'>Local</label>
									<select name='slcLocal' id='slcLocal' class='form-control textContenido01 form-control-sm'>";
					$link = conectar_db();
					$c_detTabla = "call sp_con_local_x_usuario('".$_SESSION['cod_user']."')";
					$r_detTabla = mysqli_query($link, $c_detTabla);
					while ($d_detTabla = mysqli_fetch_array($r_detTabla))
					{
						if ($d_detTabla[0] == $_SESSION['loc_user'])
							$cab.= "	<option value='".$d_detTabla[0]."' selected>".$d_detTabla[1]."</option>";
						else
							$cab.= "	<option value='".$d_detTabla[0]."'>".$d_detTabla[1]."</option>";
					} 
									
	$cab.= "							<option value='%' >Todos los locales</option>
									</select>
								</div>
								<div class='col-12 col-lg-2 mt-1 justify-content-center text-center'>
									<button name='cmdBusca' type='button' class='btn btn-primary btn-sm textBotonMin btn-block' title='Buscar Usuario' onClick='xajax_f_listausuarios(xajax.getFormValues(frmLisUsu));'>BUSCAR USUARIO</button>
									<button name='cmdNuevo' type='button' class='btn btn-info btn-sm textBotonMin btn-block' title='Registrar Nuevo Usuario' onClick='xajax_f_regusuario();' >NUEVO USUARIO</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>";

    return $cab;
	
	return $cab;
}
function f_listausuarios($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCpo = f_listausuariosdb($form['txtNombre'], $form['slcLocal']);
	$divDet = "";
	$divMsj = "";
	
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	$respuesta->Assign("divDet", "innerHTML", $divDet);
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	return $respuesta;
}
function f_listausuariosdb($desnombre, $codlocal)
{
	
	$link = conectar_db();
	$c_detTabla = "call sp_con_usuarios('".$desnombre."', '".$codlocal."')";
	$r_detTabla = mysqli_query($link, $c_detTabla);
	$n_detTabla = mysqli_num_rows($r_detTabla);
	
	if($n_detTabla == 0)
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000032')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();
		
		$cpo = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
	}
	else
	{
		$cpo = "
			<div class='row'>
				<div class='col'>
					<form name = 'frmDetLisUsu' action='' method='post' class='justify-content-center'>
						<table class='table table-responsive table-hover table-sm table-bordered mt-3'>
							<thead class='thead-default textThTabla01'>
								<th width='7%'  >Usuarios</th>
								<th width='20%' >Nombre y Apellidos</th>
								<th width='15%' >Sector</th>
								<th width='15%' >Cargo</th>
								<th width='15%' >Local</th>
								<th width='28%' ></th>
							</thead>";
		
					while($d_detTabla = mysqli_fetch_array($r_detTabla))
					{
						$cpo.= "
							<tr class='table-sm textContenido01'>
								<td>".$d_detTabla[0]."</td>
								<td>".$d_detTabla[1]."</td>	
								<td>".$d_detTabla[2]."</td>	
								<td>".$d_detTabla[3]."</td>	
								<td>".$d_detTabla[4]."</td>
								<td class='text-center'>
									<button type='button' name='cmdEdita' class='btn btn-primary btn-sm textBotonMin mr-1' onClick='xajax_f_conusuario(\"".$d_detTabla[0]."\");' >CONSULTAR</button>
									<button type='button' name='cmdMenu' class='btn btn-primary btn-sm textBotonMin mr-1' onClick='xajax_f_menuusuario(\"".$d_detTabla[0]."\", \"S\", \"\");'  >MEN&Uacute;</button>";

						if($d_detTabla[6] == "A")
						{
							$cpo.= "<button type='button' name='cmdBloquea' class='btn btn-primary btn-sm textBotonMin mr-1' onClick='xajax_f_bloqusuario(\"".$d_detTabla[0]."\", \"".$d_detTabla[6]."\", \"".$desnombre."\", \"".$codlocal."\");' >BLOQUEAR</button>";
						}
						elseif($d_detTabla[6] == "B")
						{
							$cpo.= "<button type='button' name='cmdBloquea' class='btn btn-primary btn-sm textBotonMin mr-1' onClick='xajax_f_bloqusuario(\"".$d_detTabla[0]."\", \"".$d_detTabla[6]."\", \"".$desnombre."\", \"".$codlocal."\");' >DESBLOQUEAR</button>";
						}
						
						$cpo.= "<button type='button' name='cmdReset' class='btn btn-primary btn-sm textBotonMin' onClick='xajax_f_resusuario(\"".$d_detTabla[0]."\");' >RESETEAR</button>
								</td>
							</tr>";
					}
		$cpo.= "
						</table>
					</form>
				</div>
			</div>";
	}
	desconectar_db();
	
	return $cpo;
}
function f_resusuario($codusuario)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_regusuario = "call sp_act_reset_usuario('".$codusuario."', '".$_SESSION['cod_user']."' )";
	$r_regusuario = mysqli_query($link, $c_regusuario);
	$d_regusuario = mysqli_fetch_array($r_regusuario);
	desconectar_db();
	
	if($d_regusuario[0]==0)
	{
		$Msj = "SE RESETE&Oacute; LA CLAVE DEL USUARIO '".$codusuario."'. INDICAR AL USUARIO QUE SU CLAVE Y USUARIO SON LOS MISMOS.";
		$divMsj = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
	}
	else
	{
		$Msj = "SE PRODUJO UN ERROR, INTÉNTELO NUEVAMENTE O COMUNÍQUESE CON EL ADMINISTRADOR DEL SISTEMA.";
		$divMsj = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
	}
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	return $respuesta;
}
function f_bloqusuario($codusuario, $estadoactual, $desnombre, $codlocal)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if ($estadoactual == 'A')
	{	
		$estadonuevo = 'B';
		$Msj = "SE HA PROCEDIDO A BLOQUEAR AL USUARIO.'".$codusuario."'. EN ADELANTE NO PODR&AACUTE; INGRESAR AL SISTEMA.";
	}
	else
	{
		$estadonuevo = 'A';
		$Msj = "SE HA PROCEDIDO A DESBLOQUEAR AL USUARIO.'".$codusuario."'. EN ADELANTE PODR&AACUTE; ACCEDER AL SISTEMA.";
	}
	
	$link = conectar_db();
	$c_regusuario = "call sp_act_bloquea_usuario('".$codusuario."', '".$estadonuevo."', '".$_SESSION['cod_user']."')";
	$r_regusuario = mysqli_query($link, $c_regusuario);
	$d_regusuario = mysqli_fetch_array($r_regusuario);
	desconectar_db();
	
	$divCpo = f_listausuariosdb($desnombre, $codlocal);
	$divDet = ""; 
	$divMsj = "
		<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
			<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
				<span aria-hidden='true'>&times;</span>
			</button>
		</div>";
	
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	$respuesta->Assign("divDet", "innerHTML", $divDet);
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	return $respuesta;
}
function f_regusuario()
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCab = "
		<div class='row'>
			<div class='col'>
				<form name = 'frmRegUsu' action='' method='post' class='justify-content-center'>
					<h6 class='textSubTitulo'>Datos Personales</h6>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtUsuario' class='textDescripcion01'>Usuario</label>
							<input type='text' name='txtUsuario' id='txtUsuario' class='form-control form-control-sm textContenido01' maxlength='20' onKeyPress='return onlyAlpha2(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Usuario'  >
						</div>
						<div class='col-12 col-md-3 mb-1'>
							<label for='txtTipDocPer' class='textDescripcion01'>Tipo de Documento</label>
							<select name='txtTipDocPer' id='txtTipDocPer' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tipdoc = "call sp_con_mae_tabla_det_x_cod_tabla('P001')";
			$r_tipdoc = mysqli_query($link, $c_tipdoc);
			while ($d_tipdoc = mysqli_fetch_array($r_tipdoc))
			{
				$divCab.= "	<option value='".$d_tipdoc[0]."'>".$d_tipdoc[4]."</option>";
			}
			desconectar_db();
							
	$divCab.= "				</select>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtNumDocPer' class='textDescripcion01'>N&uacute;mero de Documento</label>
							<input type='number' name='txtNumDocPer' id='txtNumDocPer' class='form-control form-control-sm textContenido01' maxlength='20' onKeyPress='return onlyNumeric(event);' placeholder='N&uacute;mero de Documento'  >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtFecNacPer' class='textDescripcion01'>Fecha de Nacimiento</label>
							<input type='date' name='txtFecNacPer' id='txtFecNacPer' class='form-control form-control-sm textContenido01'  placeholder='Fecha'  >
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtApellido' class='textDescripcion01'>Apellidos</label>
							<input type='text' name='txtApellido' id='txtApellido' class='form-control form-control-sm textContenido01' maxlength='50' onKeyPress='return onlyAlpha(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Apellido del usuario'  >
						</div>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtNombre' class='textDescripcion01'>Nombres</label>
							<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' maxlength='50' onKeyPress='return onlyAlpha(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Nombre del usuario'  >
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtDomicilio' class='textDescripcion01'>Domicilio</label>
							<input type='text' name='txtDomicilio' id='txtDomicilio' class='form-control form-control-sm textContenido01' maxlength='150' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Domicilio del usuario'  >
						</div>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtRefDom' class='textDescripcion01'>Referencia</label>
							<input type='text' name='txtRefDom' id='txtRefDom' class='form-control form-control-sm textContenido01 ' maxlength='150' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Referencia del domicilio'  >
						</div>
					</div>
				
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelMovilPers' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilPers' id='txtTelMovilPers' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);'  min='900000000' max='999999999' placeholder='##########'  >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelFijoHogar' class='textDescripcion01'>Tel&eacute;fono Hogar</label>
							<input type='number' name='txtTelFijoHogar' id='txtTelFijoHogar' class='form-control form-control-sm textContenido01' maxlength='6' onKeyPress='return onlyNumeric(event);' min='100000' max='999999' placeholder='######'  >
						</div>
						<div class='col-12 col-md-4 mb-1'>
							<label for='txtMailPers' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailPers' id='txtMailPers' class='form-control form-control-sm textContenido01min' maxlength='50' placeholder='Correo'  >
						</div>
					</div>
					
					<h6 class='textSubTitulo'>Datos Laborales</h6>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='slcSector' class='textDescripcion01'>Sector</label>
							<select name='slcSector' id='slcSector' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tipsec = "call sp_con_mae_tabla_det_x_cod_tabla('P005')";
			$r_tipsec = mysqli_query($link, $c_tipsec);
			while ($d_tipsec = mysqli_fetch_array($r_tipsec))
			{
				$divCab.= "	<option value='".$d_tipsec[0]."'>".$d_tipsec[3]."</option>";
			}
			desconectar_db();
							
	$divCab.= "				</select>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='slcCargo' class='textDescripcion01'>Cargo</label>
							<select name='slcCargo' id='slcCargo' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tipcar = "call sp_con_mae_tabla_det_x_cod_tabla('P007')";
			$r_tipcar = mysqli_query($link, $c_tipcar);
			while ($d_tipcar = mysqli_fetch_array($r_tipcar))
			{
				$divCab.= "	<option value='".$d_tipcar[0]."'>".$d_tipcar[3]."</option>";
			}
			desconectar_db();
							
	$divCab.= "				</select>
						</div>
						<div class='col-12 col-md-3 mb-1'>
							<label for='slcLocal' class='textDescripcion01'>Local</label>
							<select name='slcLocal' id='slcLocal' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tiploc = "call sp_con_locales('A')";
			$r_tiploc = mysqli_query($link, $c_tiploc);
			while ($d_tiploc = mysqli_fetch_array($r_tiploc))
			{
				$divCab.= "	<option value='".$d_tiploc[0]."'>".$d_tiploc[1]."</option>";
			}
			desconectar_db();
							
	$divCab.= "				</select>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelMovilLab' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilLab' id='txtTelMovilLab' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);'  min='900000000' max='999999999' placeholder='##########'  >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelFijoLab' class='textDescripcion01'>Tel&eacute;fono Fijo</label>
							<input type='number' name='txtTelFijoLab' id='txtTelFijoLab' class='form-control form-control-sm textContenido01' maxlength='6' onKeyPress='return onlyNumeric(event);' min='100000' max='999999' placeholder='######'  >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelAnexoLab' class='textDescripcion01'>Anexo</label>
							<input type='number' name='txtTelAnexoLab' id='txtTelAnexoLab' class='form-control form-control-sm textContenido01' maxlength='8' onKeyPress='return onlyNumeric(event);' min='0000' max='9999' placeholder='####'  >
						</div>
						<div class='col-12 col-md-4 mb-1'>
							<label for='txtMailLab' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailLab' id='txtMailLab' class='form-control form-control-sm textContenido01min' maxlength='50' placeholder='Correo'  >
						</div>
					</div>
					<div class='row justify-content-center '>
						<div class='col-12 col-md-3 mt-4 text-center'>
							<button name='cmdGrabar' type='button' class='btn btn-primary textBotonMin' title='Grabar' onClick='xajax_f_regusuariodb(xajax.getFormValues(frmRegUsu));' >GRABAR</button>
							<button name='cmdLimpiar' type='reset' class='btn btn-info textBotonMin' title='Limpiar'>LIMPIAR</button>
							<button name='cmdRetornar' type='button' class='btn btn-info textBotonMin' title='Salir' onClick='xajax_f_admusuario_ini();' >RETORNAR</button>
						</div>
					</div>
				</form>
			</div>
		</div>";
	
	$divCpo ="";
	$divDet="";
	$divMsj="";
	
	$respuesta->Assign("divCab", "innerHTML", $divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	return $respuesta;
}
function f_regusuariodb($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if (trim($form['txtUsuario']) == "" or trim($form['txtTipDocPer']) == "" or trim($form['txtNumDocPer']) == "" or trim($form['txtFecNacPer']) == "" or trim($form['txtApellido']) == "" or trim($form['txtNombre']) == "" or trim($form['txtDomicilio']) == "" or trim($form['txtTelMovilPers']) == "" or $form['slcSector'] == "" or $form['slcCargo'] == "" or $form['slcLocal'] == "" )
	{
		$Msj = "DEBE INGRESAR LOS DATOS OBLIGATORIOS";
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
		$link = conectar_db();
		$c_regusuario = "call sp_reg_usuario('".trim($form['txtUsuario'])."', '".trim($form['txtApellido'])."', '".trim($form['txtNombre'])."', '".trim($form['txtDomicilio'])."', '".trim($form['txtRefDom'])."', '".trim($form['txtTelMovilPers'])."', '".trim($form['txtTelFijoHogar'])."', '".trim($form['txtMailPers'])."', '".$form['slcSector']."', '".$form['slcCargo']."', '".$form['slcLocal']."',  '".trim($form['txtTelMovilLab'])."', '".trim($form['txtTelFijoLab'])."', '".trim($form['txtTelAnexoLab'])."', '".trim($form['txtMailLab'])."', '".trim($form['txtTipDocPer'])."', '".trim($form['txtNumDocPer'])."', '".trim($form['txtFecNacPer'])."', '".$_SESSION['cod_user']."')";
		$r_regusuario = mysqli_query($link, $c_regusuario);
		$d_regusuario = mysqli_fetch_array($r_regusuario);
		desconectar_db();
		
		if($d_regusuario[0]==0)
		{
			$divCab = f_conusuariodb($d_regusuario[1]);
			$divCpo ="";
			$divDet="";
			$divMsj="";
			
			$respuesta->Assign("divCab", "innerHTML", $divCab);
			$respuesta->Assign("divCpo", "innerHTML", $divCpo);
			$respuesta->Assign("divDet", "innerHTML", $divDet);
			$respuesta->Assign("divMsj", "innerHTML", $divMsj);
		}
		else
		{
			$Msj = "VERIFIQUE, USUARIO YA EXISTE.";
			$divMsj = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
			
			$respuesta->Assign("divMsj", "innerHTML", $divMsj);
		}
	}
	return $respuesta;
}
function f_conusuario($codusuario)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCab = f_conusuariodb($codusuario);
	$divCpo ="";
	$divDet="";
	$divMsj="";
	
	$respuesta->Assign("divCab", "innerHTML", $divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	$respuesta->Assign("divDet", "innerHTML", $divDet);
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	
	return $respuesta;	
}
function f_conusuariodb($codusuario)
{
	$link = conectar_db();
	$c_conusuario = "call sp_con_usu_x_codusuario('".$codusuario."')";
	$r_conusuario = mysqli_query($link, $c_conusuario);
	$d_conusuario = mysqli_fetch_array($r_conusuario);
	desconectar_db();
	
	$cpo = "
		<div class='row'>
			<div class='col'>
				<form name = 'frmConUsu' action='' method='post' class='justify-content-center'>
					<h6 class='textSubTitulo'>Datos Personales</h6>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtUsuario' class='textDescripcion01'>Usuario</label>
							<input type='text' name='txtUsuario' id='txtUsuario' class='form-control form-control-sm textContenido01' value='".$d_conusuario[0]."' readonly>
						</div>
						<div class='col-12 col-md-3 mb-1'>
							<label for='txtTipDocPer' class='textDescripcion01'>Tipo de Documento</label>
							<input type='text' name='txtTipDocPer' id='txtTipDocPer' class='form-control form-control-sm textContenido01' value='".$d_conusuario[20]."' readonly>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtNumDocPer' class='textDescripcion01'>N&uacute;mero de Documento</label>
							<input type='text' name='txtNumDocPer' id='txtNumDocPer' class='form-control form-control-sm textContenido01' value='".$d_conusuario[21]."' readonly>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtFecNacPer' class='textDescripcion01'>Fecha de Nacimiento</label>
							<input type='text' name='txtFecNacPer' id='txtFecNacPer' class='form-control form-control-sm textContenido01' value='".modifica_formato_fecha03($d_conusuario[22])."' readonly>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtApellido' class='textDescripcion01'>Apellidos</label>
							<input type='text' name='txtApellido' id='txtApellido' class='form-control form-control-sm textContenido01' value='".$d_conusuario[1]."' readonly>
						</div>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtNombre' class='textDescripcion01'>Nombres</label>
							<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' value='".$d_conusuario[2]."' readonly>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtDomicilio' class='textDescripcion01'>Domicilio</label>
							<input type='text' name='txtDomicilio' id='txtDomicilio' class='form-control form-control-sm textContenido01' value='".$d_conusuario[3]."' readonly>
						</div>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtRefDom' class='textDescripcion01'>Referencia</label>
							<input type='text' name='txtRefDom' id='txtRefDom' class='form-control form-control-sm textContenido01 ' value='".$d_conusuario[4]."' readonly>
						</div>
					</div>
				
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelMovilPers' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilPers' id='txtTelMovilPers' class='form-control form-control-sm textContenido01' value='".$d_conusuario[5]."' readonly>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelFijoHogar' class='textDescripcion01'>Tel&eacute;fono Hogar</label>
							<input type='number' name='txtTelFijoHogar' id='txtTelFijoHogar' class='form-control form-control-sm textContenido01' value='".$d_conusuario[6]."' readonly>
						</div>
						<div class='col-12 col-md-4 mb-1'>
							<label for='txtMailPers' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailPers' id='txtMailPers' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[7]."' readonly>
						</div>
					</div>
					
					<h6 class='textSubTitulo'>Datos Laborales</h6>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='slcSector' class='textDescripcion01'>Sector</label>
							<input type='text' name='slcSector' id='slcSector' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[16]."' readonly>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='slcCargo' class='textDescripcion01'>Cargo</label>
							<input type='text' name='slcCargo' id='slcCargo' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[17]."' readonly>
						</div>
						<div class='col-12 col-md-3 mb-1'>
							<label for='slcLocal' class='textDescripcion01'>Local</label>
							<input type='text' name='slcLocal' id='slcLocal' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[18]."' readonly>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelMovilLab' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilLab' id='txtTelMovilLab' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[11]."' readonly>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelFijoLab' class='textDescripcion01'>Tel&eacute;fono Fijo</label>
							<input type='number' name='txtTelFijoLab' id='txtTelFijoLab' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[12]."' readonly>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelAnexoLab' class='textDescripcion01'>Anexo</label>
							<input type='number' name='txtTelAnexoLab' id='txtTelAnexoLab' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[13]."' readonly>
						</div>
						<div class='col-12 col-md-4 mb-1'>
							<label for='txtMailLab' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailLab' id='txtMailLab' class='form-control form-control-sm textContenido01min' value='".$d_conusuario[14]."' readonly>
						</div>
					</div>
					<div class='row'>
						<div class='col-12 col-sl-2 mt-4 justify-content-center text-center'>
							<button name='cmdEdita' type='button' class='btn btn-primary textBotonMin' title='Editar' onClick='xajax_f_modusuario(\"".$codusuario."\");' >EDITAR INFORMACI&Oacute;N</button>
							<button name='cmdRetornar' type='button' class='btn btn-info textBotonMin' title='Salir' onClick='xajax_f_admusuario_ini();' >RETORNAR</button>
						</div>
					</div>
				</form>
			</div>
		</div>";
	
	return $cpo;	
}
function f_modusuario($codusuario)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_conusuario = "call sp_con_usu_x_codusuario('".$codusuario."')";
	$r_conusuario = mysqli_query($link, $c_conusuario);
	$d_conusuario = mysqli_fetch_array($r_conusuario);
	desconectar_db();
	
	$divCab = "
		<div class='row'>
			<div class='col'>
				<form name = 'frmModUsu' action='' method='post' class='justify-content-center'>
					<h6 class='textSubTitulo'>Datos Personales</h6>
					<input type='hidden' name='hddCodUsu' value='".$codusuario."' >
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtUsuario' class='textDescripcion01'>Usuario</label>
							<input type='text' name='txtUsuario' id='txtUsuario' class='form-control form-control-sm textContenido01' value='".$d_conusuario[0]."'>
						</div>
						<div class='col-12 col-md-3 mb-1'>
							<label for='txtTipDocPer' class='textDescripcion01'>Tipo de Documento</label>
							<select name='txtTipDocPer' id='txtTipDocPer' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tipdoc = "call sp_con_mae_tabla_det_x_cod_tabla('P001')";
			$r_tipdoc = mysqli_query($link, $c_tipdoc);
			while ($d_tipdoc = mysqli_fetch_array($r_tipdoc))
			{
				if ($d_conusuario[19] == $d_tipdoc[0])
					$divCab.= "<option value='".$d_tipdoc[0]."' selected>".$d_tipdoc[4]."</option>";
				else
					$divCab.= "<option value='".$d_tipdoc[0]."'>".$d_tipdoc[4]."</option>";
			}
			desconectar_db();
					
	$divCab.= "				</select>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtNumDocPer' class='textDescripcion01'>N&uacute;mero de Documento</label>
							<input type='number' name='txtNumDocPer' id='txtNumDocPer' class='form-control form-control-sm textContenido01' maxlength='20' onKeyPress='return onlyNumeric(event);' placeholder='N&uacute;mero de Documento' value='".$d_conusuario[21]."' >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtFecNacPer' class='textDescripcion01'>Fecha de Nacimiento</label>
							<input type='date' name='txtFecNacPer' id='txtFecNacPer' class='form-control form-control-sm textContenido01'  placeholder='Fecha' value='".$d_conusuario[22]."' >
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtApellido' class='textDescripcion01'>Apellidos</label>
							<input type='text' name='txtApellido' id='txtApellido' class='form-control form-control-sm textContenido01' maxlength='50' onKeyPress='return onlyAlpha(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Apellido del usuario' value='".$d_conusuario[1]."'  >
						</div>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtNombre' class='textDescripcion01'>Nombres</label>
							<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' maxlength='50' onKeyPress='return onlyAlpha(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Nombre del usuario' value='".$d_conusuario[2]."'  >
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtDomicilio' class='textDescripcion01'>Domicilio</label>
							<input type='text' name='txtDomicilio' id='txtDomicilio' class='form-control form-control-sm textContenido01' maxlength='150' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Domicilio del usuario' value='".$d_conusuario[3]."'  >
						</div>
						<div class='col-12 col-md-5 mb-1'>
							<label for='txtRefDom' class='textDescripcion01'>Referencia</label>
							<input type='text' name='txtRefDom' id='txtRefDom' class='form-control form-control-sm textContenido01 ' maxlength='150' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Referencia del domicilio' value='".$d_conusuario[4]."'  >
						</div>
					</div>
				
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelMovilPers' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilPers' id='txtTelMovilPers' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);'  min='900000000' max='999999999' placeholder='##########' value='".$d_conusuario[5]."'  >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelFijoHogar' class='textDescripcion01'>Tel&eacute;fono Hogar</label>
							<input type='number' name='txtTelFijoHogar' id='txtTelFijoHogar' class='form-control form-control-sm textContenido01' maxlength='6' onKeyPress='return onlyNumeric(event);' min='100000' max='999999' placeholder='######' value='".$d_conusuario[6]."'  >
						</div>
						<div class='col-12 col-md-4 mb-1'>
							<label for='txtMailPers' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailPers' id='txtMailPers' class='form-control form-control-sm textContenido01min' maxlength='50' placeholder='Correo' value='".$d_conusuario[7]."'  >
						</div>
					</div>
					
					<h6 class='textSubTitulo'>Datos Laborales</h6>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='slcSector' class='textDescripcion01'>Sector</label>
							<select name='slcSector' id='slcSector' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tipsec = "call sp_con_mae_tabla_det_x_cod_tabla('P005')";
			$r_tipsec = mysqli_query($link, $c_tipsec);
			while ($d_tipsec = mysqli_fetch_array($r_tipsec))
			{
				if ($d_conusuario[8] == $d_tipsec[0])
					$divCab.= "	<option value='".$d_tipsec[0]."' selected>".$d_tipsec[3]."</option>";
				else
					$divCab.= "	<option value='".$d_tipsec[0]."' >".$d_tipsec[3]."</option>";
			}
			desconectar_db();
							
	$divCab.= "				</select>
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='slcCargo' class='textDescripcion01'>Cargo</label>
							<select name='slcCargo' id='slcCargo' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tipcar = "call sp_con_mae_tabla_det_x_cod_tabla('P007')";
			$r_tipcar = mysqli_query($link, $c_tipcar);
			while ($d_tipcar = mysqli_fetch_array($r_tipcar))
			{
				if ($d_conusuario[9] == $d_tipcar[0])
					$divCab.= "	<option value='".$d_tipcar[0]."' selected>".$d_tipcar[3]."</option>";
				else
					$divCab.= "	<option value='".$d_tipcar[0]."'>".$d_tipcar[3]."</option>";
			}
			desconectar_db();
							
	$divCab.= "				</select>
						</div>
						<div class='col-12 col-md-3 mb-1'>
							<label for='slcLocal' class='textDescripcion01'>Local</label>
							<select name='slcLocal' id='slcLocal' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
			$link = conectar_db();
			$c_tiploc = "call sp_con_locales('A')";
			$r_tiploc = mysqli_query($link, $c_tiploc);
			while ($d_tiploc = mysqli_fetch_array($r_tiploc))
			{
				if ($d_conusuario[10] == $d_tiploc[0])
					$divCab.= "	<option value='".$d_tiploc[0]."' selected>".$d_tiploc[1]."</option>";
				else
					$divCab.= "	<option value='".$d_tiploc[0]."'>".$d_tiploc[1]."</option>";
			}
			desconectar_db();
							
	$divCab.= "				</select>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelMovilLab' class='textDescripcion01'>Tel&eacute;fono M&oacute;vil</label>
							<input type='number' name='txtTelMovilLab' id='txtTelMovilLab' class='form-control form-control-sm textContenido01' maxlength='9' onKeyPress='return onlyNumeric(event);'  min='900000000' max='999999999' placeholder='##########' value='".$d_conusuario[11]."' >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelFijoLab' class='textDescripcion01'>Tel&eacute;fono Fijo</label>
							<input type='number' name='txtTelFijoLab' id='txtTelFijoLab' class='form-control form-control-sm textContenido01' maxlength='6' onKeyPress='return onlyNumeric(event);' min='100000' max='999999' placeholder='######' value='".$d_conusuario[12]."' >
						</div>
						<div class='col-12 col-md-2 mb-1'>
							<label for='txtTelAnexoLab' class='textDescripcion01'>Anexo</label>
							<input type='number' name='txtTelAnexoLab' id='txtTelAnexoLab' class='form-control form-control-sm textContenido01' maxlength='8' onKeyPress='return onlyNumeric(event);' min='0000' max='9999' placeholder='####' value='".$d_conusuario[13]."' >
						</div>
						<div class='col-12 col-md-4 mb-1'>
							<label for='txtMailLab' class='textDescripcion01'>Correo electr&oacute;nico</label>
							<input type='email' name='txtMailLab' id='txtMailLab' class='form-control form-control-sm textContenido01min' maxlength='50' placeholder='Correo' value='".$d_conusuario[14]."'  >
						</div>
					</div>
					<div class='row justify-content-center'>
						<div class='col-12 col-sl-2 mt-4 text-center'>
							<button name='cmdGrabar' type='button' class='btn btn-primary textBotonMin' title='Grabar' onClick='xajax_f_modusuariodb(xajax.getFormValues(frmModUsu));' >GRABAR MODIFICACI&Oacute;N</button>
							<button name='cmdRetornar' type='button' class='btn btn-info textBotonMin' title='Salir' onClick='xajax_f_admusuario_ini();' >RETORNAR</button>
						</div>
					</div>
				</form>
			</div>
		</div>";
	
	$divCpo ="";
	$divDet="";
	$divMsj="";
	
	$respuesta->Assign("divCab", "innerHTML", $divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	$respuesta->Assign("divDet", "innerHTML", $divDet);
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	
	return $respuesta;
}
function f_modusuariodb($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCpo ="";
	$divDet="";
	$divMsj="";
	
	if (trim($form['txtApellido']) == "" or trim($form['txtNombre']) == "" or trim($form['txtDomicilio']) == "" or trim($form['txtTelMovilPers']) == "" or trim($form['txtTelFijoHogar']) == "" or $form['slcSector'] == "" or $form['slcCargo'] == "" or $form['slcLocal'] == "" or $form['txtTipDocPer'] == "" or $form['txtNumDocPer'] == "" or $form['txtFecNacPer'] == "" )
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000017')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();
		
		$divMsj = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		
		$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	}
	else
	{
		$link = conectar_db();
		$c_regusuario = "call sp_act_usuario('".$form['hddCodUsu']."','".trim($form['txtApellido'])."', '".trim($form['txtNombre'])."', '".trim($form['txtDomicilio'])."', '".trim($form['txtRefDom'])."', '".trim($form['txtTelMovilPers'])."', '".trim($form['txtTelFijoHogar'])."', '".trim($form['txtMailPers'])."', '".$form['slcSector']."', '".$form['slcCargo']."', '".$form['slcLocal']."',  '".trim($form['txtTelMovilLab'])."', '".trim($form['txtTelFijoLab'])."', '".trim($form['txtTelAnexoLab'])."', '".trim($form['txtMailLab'])."', '".trim($form['txtTipDocPer'])."', '".trim($form['txtNumDocPer'])."', '".trim($form['txtFecNacPer'])."', '".$_SESSION['cod_user']."')";
		$r_regusuario = mysqli_query($link, $c_regusuario);
		$d_regusuario = mysqli_fetch_array($r_regusuario);
		desconectar_db();
		
		
		if($d_regusuario[0]==0)
		{
			$link = conectar_db();
			$c_msj = "CALL sp_con_det_mensajes ('M000000036')";
			$r_msj = mysqli_query($link, $c_msj);
			$d_msj = mysqli_fetch_array($r_msj);
			desconectar_db();
			
			$divMsj = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
			
			$divCab = f_conusuariodb($form['hddCodUsu']);
			$respuesta->Assign("divCab", "innerHTML", $divCab);
		}
		else
		{
			$link = conectar_db();
			$c_msj = "CALL sp_con_det_mensajes ('M000000021')";
			$r_msj = mysqli_query($link, $c_msj);
			$d_msj = mysqli_fetch_array($r_msj);
			desconectar_db();
			
			$divMsj = "
				<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
					<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>";
		}
	}
	
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	$respuesta->Assign("divDet", "innerHTML", $divDet);
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	return $respuesta;
}
function f_menuusuario($codusuario, $opc_menu, $accion)
{	
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCab = "";
	$divCpo ="";
	$divDet="";
	$divMsj="";
	
	if (trim($codusuario) <> "")
	{
		
		if ($accion <> '')
		{
			$link = conectar_db();
			$c_act_menu = "SELECT f_act_menu_usuario('".$codusuario."', '".$opc_menu."', '".$accion."') FROM dual";
			$r_act_menu = mysqli_query($link, $c_act_menu);
			$d_act_menu = mysqli_fetch_array($r_act_menu);
			desconectar_db();
		}
		
		$link = conectar_db();
		$c_nomusu = "SELECT f_con_nombre_usuario_x_cod_usuario('".$codusuario."', 'A') FROM dual";
		$r_nomusu = mysqli_query($link, $c_nomusu);
		$d_nomusu = mysqli_fetch_array($r_nomusu);
		desconectar_db();
		
		$divCab = "
		<div class='row justify-content-center'>
			<div class='col-12 col-lg-12 mt-1'>
				<form name = 'frmMenUsu' action='' method='post' class='justify-content-center'>
					<div class='form-group row justify-content-center'>
						<div class='col-12 col-md-4 mb-1'>
							<label for='' class='textDescripcion01'>Usuario:  </label>
							<label for='' class='textContenido01'>".$d_nomusu[0]."</label>
						</div>
						<div class='col-12 col-md-4 mb-1 text-right'>
							<button name='cmdRetornar' type='button' class='btn btn-info textBotonMin btn-sm' title='Salir' onClick='xajax_f_admusuario_ini();' >RETORNAR</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class='row justify-content-center'>
			<div class='col-12 col-lg-10 mt-1'>
				<table class='table table-responsive table-hover table-sm table-bordered'>
					<thead>
						<th class='textContenido01 text-right' colspan='4'><img src='dycImages/button_ok.gif'>TIENE ACCESO&nbsp;&nbsp;<img src='dycImages/button_cancel.gif'>NO TIENE ACCESO</th>
					</thead>
					<thead class='thead-default textThTabla01'>
						<th width='15%' class='text-center'>CODIGO</th>
						<th width='40%' class='text-center'>OPCION DE MENU</th>
						<th width='40%' class='text-center'>RUTA</th>
						<th width='5%'  class='text-center'></th>
					</thead>";
			$link = conectar_db();
			$c_opcmenu = "call sp_con_opc_menu()";
			$r_opcmenu = mysqli_query($link, $c_opcmenu);
			while($d_opcmenu = mysqli_fetch_array($r_opcmenu))
			{  
				if ( $d_opcmenu[1] == 1)
				{	
					$divCab.= "<tr class='table-sm textContenido01' bgcolor='#CACACA'>";
				}
				else
				{ 	
					$divCab.= "<tr class='table-sm textContenido01'>";				
				}	
				$divCab.="
					<td>".$d_opcmenu[0]."</td>
					<td>".$d_opcmenu[2]."</td>
					<td class='textContenido01min'>".$d_opcmenu[3]."</td>
					<td class='text-center'>";
				
				if(trim($d_opcmenu[3]) <> "")
				{	
					$link = conectar_db();
					$c_opcmenuusu = "SELECT f_con_acc_usu_opc_menu('".$codusuario."' , '".$d_opcmenu[0]."' ) from dual";				
					$r_opcmenuusu = mysqli_query($link, $c_opcmenuusu);
					$d_opcmenuusu = mysqli_fetch_array($r_opcmenuusu);
					desconectar_db();
					
					if( $d_opcmenuusu[0] == '1' )
					{	
						$divCab.="<button type='button' name='boton' onClick='xajax_f_menuusuario(\"".$codusuario."\", ".$d_opcmenu[0].", 1);'><img src='dycImages/button_ok.gif' ></button>";
					}
					else 
					{	
						$divCab.="<button type='button' name='boton' onClick='xajax_f_menuusuario(\"".$codusuario."\", ".$d_opcmenu[0].", 2);'><img src='dycImages/button_cancel.gif' ></button>";
					}
				}
				$divCab.= "</td></tr>";						
			}
		$divCab.= "
				</table>
			</div>
		</div>";
	}
	$respuesta->Assign("divCab", "innerHTML", $divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	$respuesta->Assign("divDet", "innerHTML", $divDet);
	$respuesta->Assign("divMsj", "innerHTML", $divMsj);
	return $respuesta;		
}
/*
function f_perfilusuario_cpo($codusuario, $flag)
{
	$cpo = "
		<table width='100%' border='0' align='center'>";
	$link = conectar_db();
	$c_opcperfil =  "CALL sp_con_mae_tabla_det_x_cod_tabla('P006')";
	$r_opcperfil = mysqli_query($link, $c_opcperfil);
	while($d_opcperfil = mysqli_fetch_array($r_opcperfil))
	{  
		if ( $d_opcperfil[1] == 1)
		{	
			$cpo.= "<tr class='textDetalle' bgcolor='#CACACA' height='20'>";
		}
		else
		{ 	
			$cpo.= "<tr height='20' onmouseover='this.style.backgroundColor=\"#C1DA83\"' onmouseout='this.style.backgroundColor=\"#FFFFFF\"'>";				
		}	
		$cpo.="
			<td class='textDetalle'  >&nbsp;&nbsp;&nbsp;*)&nbsp;".$d_opcperfil[3]."</td>
			<td align='center'>";
		
		if(trim($d_opcperfil[3]) <> "")
		{	
			$link = conectar_db();
			$c_opcperusu = "CALL sp_con_reg_perfil_usuario('".$codusuario."' , '".$d_opcperfil[0]."' )";				
			$r_opcperusu = mysqli_query($link, $c_opcperusu);
			$d_opcperusu = mysqli_fetch_array($r_opcperusu);
			desconectar_db();
			
			if ($flag == 'M')
			{
				if( $d_opcperusu[0]  > 0)
				{
					$cpo.= "<button name='boton' type='button'  onClick='xajax_f_perfilusuariodb(\"".$codusuario."\",  \"".$d_opcperfil[0]."\", 1);'><img src='dycImages/button_ok.gif' ></button>";
				}
				else 
				{	
					$cpo.= "<button name='boton' type='button' onClick='xajax_f_perfilusuariodb(\"".$codusuario."\",  \"".$d_opcperfil[0]."\", 2);'><img src='dycImages/button_cancel.gif' ></button>";
				}
			}
			elseif ($flag == 'C')
			{
				if( $d_opcperusu[0]  > 0)
				{
					$cpo.= "<button name='boton' type='button'><img src='dycImages/button_ok.gif' ></button>";
				}
				else 
				{	
					$cpo.= "<button name='boton' type='button'><img src='dycImages/button_cancel.gif' ></button>";
				}
			}
		}
		
		$cpo.= "</td></tr>";						
	}
	$cpo.= "</table>";
	return $cpo;
}
function f_perfilusuariodb($codusuario, $codperfil, $codaccion)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divUsuPer = "";
	
	if ($codaccion <> '')
	{
		$link = conectar_db();
		$c_act_menu = "CALL sp_act_perfiles_usuario('".$codusuario."', '".$codperfil."', '".$codaccion."')";
		$r_act_menu = mysqli_query($link, $c_act_menu);
		$d_act_menu = mysqli_fetch_array($r_act_menu);
		desconectar_db();
	}
	$divUsuPer = f_perfilusuario_cpo($codusuario, 'M');
	
	$respuesta->Assign("divUsuPer", "innerHTML", $divUsuPer);
	return $respuesta;	
}
*/
$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_admusuario_ini");	
$xajax->register(XAJAX_FUNCTION, "f_listausuarios");
$xajax->register(XAJAX_FUNCTION, "f_regusuario");
$xajax->register(XAJAX_FUNCTION, "f_regusuariodb");
$xajax->register(XAJAX_FUNCTION, "f_conusuario");	
$xajax->register(XAJAX_FUNCTION, "f_conusuariodb");	
$xajax->register(XAJAX_FUNCTION, "f_modusuario");	
$xajax->register(XAJAX_FUNCTION, "f_modusuariodb");	
$xajax->register(XAJAX_FUNCTION, "f_bloqusuario");	
$xajax->register(XAJAX_FUNCTION, "f_resusuario");
$xajax->register(XAJAX_FUNCTION, "f_menuusuario");
//$xajax->register(XAJAX_FUNCTION, "f_perfilusuariodb");	

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

		<?php
			$xajax->printJavascript('dycXajax/');
		?>
	</head>
	<body onLoad='xajax_f_admusuario_ini();'>
		<?php  menu();  ?>
		<div class="container">
			<header class="row">
				<div class="col-12">
					<h5>Usuarios / <small class="text-muted">Registro de Usuarios</small></h5>
					<hr>
				</div>
			</header>
			<div id="divCab"></div>
			<div id="divCpo"></div>
			<div id="divDet"></div>
			<div id="divMsj"></div>
		</div>
	</body>
</html>