<?php
include_once("dycFunctions/f_seguridad.php");

f_sessionopen();

include_once('dycFunctions/f_database.php');
include_once('dycFunctions/f_mensajes.php');
include_once('dycFunctions/f_generalphp.php');	
require_once("dycXajax/xajax_core/xajax.inc.php");
include_once('libs/menu.php');

function f_FrmBuscaReclamos()
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCab = f_FrmBuscaReclamosDb();
	$divCpo = f_ListaReclamosCpo('', '',  '%',  'D023');
	
	$respuesta->Assign("divCab", "innerHTML", $divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	
	return $respuesta;
}
function f_FrmBuscaReclamosDb()
{
	$Cab = "
		<div class='row mt-3'>
			<div class='col'>
				<form name='frmBuscaMensajes' action='' method='post'>
					<div class='form-group row'>
						
						<div class='col-12 col-md-2 text-left'>
							<label for='txtFecIni' class='textDescripcion01'>Fecha Inicio Registro:</label>
							<input name='txtFecIni' id='txtFecIni' type='date' class='form-control form-control-sm textContenido01'>
						</div>
						
						<div class='col-12 col-md-2 text-left'>
							<label for='txtFecFin' class='textDescripcion01'>Fecha Fin Registro:</label>
							<input name='txtFecFin' id='txtFecFin' type='date' class='form-control form-control-sm textContenido01'>
						</div>
						
						<div class='col-12 col-md-3 text-left'>
							<label for='slcTipRegistro' class='textDescripcion01'>Tipo de Registro:</label>
							<select name='slcEstado' id='slcEstado' class='form-control form-control-sm textContenido01'  >
								<option value = 'D017'>QUEJA</option>
								<option value = 'D016'>RECLAMO</option>
								<option value = 'D026'>SUGERENCIA</option>
								<option value = '%' selected>TODOS</option>
							</select>
							
						</div>
						
						<div class='col-12 col-md-3 text-left'>
							<label for='slcEstado' class='textDescripcion01'>Estado:</label>
							<select name='slcEstado' id='slcEstado' class='form-control form-control-sm textContenido01'  >
								<option value = 'D024'>ATENDIDO</option>
								<option value = 'D023' selected>SIN ATENDER</option>
								<option value = '%'>TODOS</option>
							</select>
						</div>
						
						<div class='col-12 col-md-2 mt-2 text-center'>
							<label for='' class='textDescripcion01'></label>
							<input name='cmdBuscar' type='button' class='btn btn-success btn-sm textBotonMin btn-block' value='BUSCAR' onClick='xajax_f_ListaReclamos(xajax.getFormValues(frmBuscaMensajes) );'>
						</div>
					</div>
				</form>
			</div>
		</div>";
	
	return $Cab;
}
function f_ListaReclamos($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if (($form['txtFecIni'] <> "" and $form['txtFecFin'] <> "") and ($form['txtFecIni'] > $form['txtFecFin']))
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000025')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();
		
		$divCpo = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		
		$respuesta->Assign("divCpo","innerHTML",$divCpo);
		return $respuesta;
	}
	if (($form['txtFecIni'] <> "" and $form['txtFecFin'] == "") or ($form['txtFecIni'] == "" and $form['txtFecFin'] <> ""))
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000031')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();
		
		$divCpo = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		
		$respuesta->Assign("divCpo","innerHTML",$divCpo);
		return $respuesta;
	}
	$divCpo = f_ListaReclamosCpo($form['txtFecIni'], $form['txtFecFin'],  trim($form['slcTipRegistro']),  $form['slcEstado']);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	return $respuesta;
}
function f_ListaReclamosCpo($fec_ini, $fec_fin, $tip_registro,  $cod_estado)
{
	$link = conectar_db();
	$c_cabmsj = "call sp_con_cab_msj_reclamo('".$fec_ini."', '".$fec_fin."', '".$tip_registro."', '".$cod_estado."') ";
	$r_cabmsj = mysqli_query($link, $c_cabmsj);
	$n_cabmsj = mysqli_num_rows($r_cabmsj);
	
	if($n_cabmsj == 0)
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
					<form name = 'frmModBanner' action='' method='post'>
						<table class='table table-responsive table-hover table-sm'>
							<thead class='table-primary textThTabla01'>
								<th width='16%' class='text-center'>Fecha Reg.</th>
								<th width='20%' class='text-center'>Tipo Reg.</th>
								<th width='20%' class='text-center'>Tipo y Nro de Documento</th>
								<th width='10%' class='text-center'>Días Reg</th>
								<th width='17%' class='text-center'>Estado</th>
								<th width='17%'  class='text-center'>Acciones</th>
							</thead>";
		$cont = 1;
		while($d_cabmsj = mysqli_fetch_array($r_cabmsj))
		{
			$cpo.= "		<tr class='table-sm'>
								<td class='text-center textContenido01'>".modifica_formato_fecha03($d_cabmsj[3])."</td>
								<td class='text-center textContenido01'>".$d_cabmsj[6]."</td>
								<td class='textContenido01'>".$d_cabmsj[1]." - ".$d_cabmsj[2]."</td>
								<td class='text-center textContenido01'>".$d_cabmsj[4]."</td>
								<td class='text-center textContenido01'>".$d_cabmsj[5]."</td>
								<td class='text-center textContenido01'>
									<input name='cmdEdita".$cont."' type='button' class='btn btn-info btn-sm textBotonMin' value='CONSULTAR' onClick='xajax_f_ConReclamo(\"".$d_cabmsj[0]."\");'  /></td>
							</tr>";		
			$cont++;
		}
		
		$cpo.= "
						</table>
					</form>
				</div>
			</div>";
	}
	return $cpo;
}
function f_ConReclamo($codMensaje)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCab = "";
	$divCpo = f_ConReclamocpo($codMensaje, 0);
	
	$respuesta->Assign("divCab", "innerHTML", $divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	return $respuesta;
}
function f_ConReclamocpo($codMensaje, $ind)
{
	$link = conectar_db();
	$c_detmsj = "call sp_con_det_msj_contacto('".$codMensaje."')";
	$r_detmsj = mysqli_query($link, $c_detmsj);
	$d_detmsj = mysqli_fetch_array($r_detmsj);
	desconectar_db();
	
	$Cpo = "
		<div class='row mt-3 justify-content-center'>
			<div class='col-10'>
				<div class='card'>
					<div class='card-header'>
						<h5 class='card-title'>Comentario</h5>
						<form name = 'frmConMensaje' action='' method=''>
							<div class='row justify-content-between'>
								<div class='col-3 col-lg-3 mt-0'>
									<h6 class='textDescripcion01'>Fecha: <small class='textContenido01'>".modifica_formato_fecha03($d_detmsj[5])."</small></h6>
								</div>
								<div class='col-3 col-lg-3 mt-0'>
									<h6 class='textDescripcion01'>Estado: <small class='textContenido01'>".$d_detmsj[7]."</small></h6>
								</div>
							</div>
							<div class='row'>
								<div class='col-12 col-lg-8 mt-0'>
									<label for='txtNombre' class='textDescripcion01'>Nombre / Raz&oacute;n Social</label>
									<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' value='".$d_detmsj[1]."' readonly>
								</div>
								<div class='col-12 col-lg-4 mt-0'>
									<label for='txtCorreo' class='textDescripcion01'>Correo Electr&oacute;nico</label>
									<input type='email' name='txtCorreo' id='txtCorreo' class='form-control form-control-sm textContenido01min' value='".$d_detmsj[2]."' readonly>
								</div>
							</div>
							<div class='row'>
								<div class='col-12 col-lg-12 mb-0'>
									<label for='txtAsunto' class='textDescripcion01'>Asunto</label>
									<input type='text' name='txtAsunto' id='txtAsunto' class='form-control form-control-sm textContenido01' value='".$d_detmsj[3]."' readonly>
								</div>
							</div>
							<div class='row'>
								<div class='col-12 col-lg-12 mb-0'>
									<label for='txtMensaje' class='textDescripcion01'>Mensaje</label>
									<textarea name='txtMensaje' id='txtMensaje' cols='90' rows='6' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' class='form-control form-control-sm textContenido01' readonly>".$d_detmsj[4]."</textarea>
								</div>
							</div>
						</form>
					</div>
					<div class='card-body'>
						<h5 class='card-title'>Respuesta al Comentario</h5>
						<form name = 'frmRptaMensaje' action='' method=''>
							<input type='hidden' name='hddCodMensaje' value='".$codMensaje."' >
							<input type='hidden' name='hddCorreo' value='".$d_detmsj[2]."' >
							<input type='hidden' name='hddAsunto' value='".$d_detmsj[3]."' >
							<input type='hidden' name='hddMensaje' value='".$d_detmsj[4]."' >";
						
					if ($d_detmsj[6] == 'N')
						$Cpo.= "
							<div class='form-group row'>
								<div class='col-12 col-lg-12 mb-0'>
									<label for='txtRespuesta' class='textDescripcion01'>Respuesta</label>
									<textarea name='txtRespuesta' id='txtRespuesta' cols='90' rows='6' onChange='aMayusculas(this);'' onBlur='aMayusculas(this);'' class='form-control form-control-sm textContenido01'></textarea>
								</div>
							</div>
							<div id='divMsj'></div>
							<div class='form-group row'>
								<div class='col-12 col-sl-12 mt-1 justify-content-center text-center'>
									<button name='cmdGrabar' type='button' class='btn btn-success textBotonMin' title='Enviar' onClick='xajax_f_regRptaContacto(xajax.getFormValues(frmRptaMensaje));' >ENVIAR</button>
									<button name='cmdLimpiar' type='reset' class='btn btn-primary textBotonMin' title='Limpiar'>LIMPIAR</button>
									<button name='cmdRetornar' type='reset' class='btn btn-info textBotonMin' title='Retornar' onClick='xajax_f_FrmBuscaReclamos();' >RETORNAR</button>
								</div>
							</div>";
					else
					{
						$Cpo.= "
							<div class='row justify-content-between'>
								<div class='col-3 col-lg-3 mt-0'>
									<h6 class='textDescripcion01'>Fecha Respuesta: <small class='textContenido01'>".modifica_formato_fecha03($d_detmsj[8])."</small></h6>
								</div>
								<div class='col-3 col-lg-3 mt-0'>
									<h6 class='textDescripcion01'>Usuario Respuesta: <small class='textContenido01'>".$d_detmsj[9]."</small></h6>
								</div>
							</div>
							<div class='form-group row'>
								<div class='col-12 col-lg-12 mb-0'>
									<label for='txtRespuesta' class='textDescripcion01'>Respuesta</label>
									<textarea name='txtRespuesta' id='txtRespuesta' cols='90' rows='6' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' class='form-control form-control-sm textContenido01' readonly>".$d_detmsj[10]."</textarea>
								</div>
							</div>
							<div id='divMsj'>";
						if ($ind == 1)
						{
							$link = conectar_db();
							$c_msj = "CALL sp_con_det_mensajes ('M000000066')";
							$r_msj = mysqli_query($link, $c_msj);
							$d_msj = mysqli_fetch_array($r_msj);
							desconectar_db();
							
							$Cpo.= "
								<div class='alert alert-info mt-1 textComunica' id='alerta'>".$d_msj[0]."
									<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
										<span aria-hidden='true'>&times;</span>
									</button>
								</div>";
						}
						$Cpo.= "
							</div>
							<div class='form-group row'>
								<div class='col-12 col-sl-12 mt-2 justify-content-center text-center'>
									<button name='cmdRetornar' type='reset' class='btn btn-info textBotonMin' title='Retornar' onClick='xajax_f_FrmBuscaReclamos();' >RETORNAR</button>
								</div>
							</div>";
					}	
					$Cpo.= "
						</form>
					</div>
				</div>
			</div>
		</div>
		<br>";
	
	return $Cpo;
}
function f_regRptaContacto($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if (trim($form['txtRespuesta']) == "")
	{
		$link = conectar_db();
		$c_msj = "CALL sp_con_det_mensajes ('M000000065')";
		$r_msj = mysqli_query($link, $c_msj);
		$d_msj = mysqli_fetch_array($r_msj);
		desconectar_db();
		
		$divMsj = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$d_msj[0]."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		
		$respuesta->Assign("divMsj","innerHTML",$divMsj);
	}	
	else
	{	
		$link = conectar_db();
		$c_regrpta = "CALL sp_reg_rpta_msj_contacto ('".$form['hddCodMensaje']."', '".$form['txtRespuesta']."','".$_SESSION['cod_user']."')";
		$r_regrpta = mysqli_query($link, $c_regrpta);
		$d_regrpta = mysqli_fetch_array($r_regrpta);
		desconectar_db();
		
		$divCab = "";
		$divCpo = f_ConReclamocpo($form['hddCodMensaje'], 1);
		
		
		
		
		
		
		
		
		
		
		
		
		
		//ENVIOS DE CORREOS
		$destinatario = $form['hddCorreo'];		
		$asunto = "Respuesta: ".$form['hddAsunto']; 
		
		$cuerpo = "
			<html> 
				<head> 
				   <title>D&C Confecciones</title> 
				</head> 
				<body > 
					<h3>Asunto: ".$form['hddAsunto']."</h3>
					<br>
					".$form['hddMensaje']."
					<br><br>
					<h3>Respuesta: </h3>
					<br>
					".$form['txtRespuesta']."
					<br><br>
				</body> 
			</html>"; 
		

		//para el envío en formato HTML 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

		//dirección del remitente 
		$headers .= "From: Contacto D&C Confecciones <contacto@dycconfecciones.com>\r\n"; 

		//dirección de respuesta, si queremos que sea distinta que la del remitente 
		//$headers .= "Reply-To: msalazar@cajasullana.pe\r\n"; 

		//direcciones que recibián copia 
		$headers .= "Cc: martin-salazar@hotmail.com \r\n";
		
		mail($destinatario,$asunto,$cuerpo,$headers);
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$respuesta->Assign("divCab", "innerHTML", $divCab);
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	}
	return $respuesta;
}


$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_FrmBuscaReclamos");
$xajax->register(XAJAX_FUNCTION, "f_ListaReclamos");
$xajax->register(XAJAX_FUNCTION, "f_ConReclamo");
$xajax->register(XAJAX_FUNCTION, "f_ConReclamodb");
$xajax->register(XAJAX_FUNCTION, "f_regRptaContacto");

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
		<link rel="stylesheet" href="css/fileinput.css" media="all" type="text/css" />
        
		<link rel="stylesheet" type="text/css" href="dycCss/style03.css" >
        <script type='text/javascript' src='dycFunctions/f_javascript.js'></script>
        <script src="js/fileinput.min.js" type="text/javascript"></script>
		
        <?php
			$xajax->printJavascript('dycXajax/');  
		?>
	</head>
	<body onLoad='xajax_f_FrmBuscaReclamos();'>
		<?php  menu();  ?>
		<div class="container">
			<header class="row">
				<div class="col-12">
					<h5>WebSite / <small class="text-muted">Administración de los Reclamos/Sugerencias Registrados</small></h5>
					<hr>
				</div>
			</header>
            <div id="divCab"></div>
            <div id="divCpo"></div>
            <div id="divDet"></div>
		</div>
	</body>
</html>