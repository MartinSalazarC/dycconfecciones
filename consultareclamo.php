<?php
session_start();
session_destroy();

include_once('libs/f_mensajes.php');
include_once('libs/f_database.php');
include_once('libs/f_headfooter.php');
require_once("xajax/xajax_core/xajax.inc.php" );

function f_listareclamo($form)
{	
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if ( trim($form['slcTipDoc']) =="" or trim($form['txtNumDoc'])=="")
	{
		$divMsjNoDoc = "Por favor completar correctamente los campos";
		$divListTabla = ""; 
		$divDetTabla = "";
		$respuesta->Assign("divListTabla", "innerHTML", $divListTabla);
		$respuesta->Assign("divDetTabla", "innerHTML", $divDetTabla);
		$respuesta->Assign("divMsjNoDoc", "innerHTML", $divMsjNoDoc);
	}
	else
	{
		$link = conectar_db();
		$c_detTabla = "call sp_con_reclamo('".trim($form['slcTipDoc'])."', '".trim($form['txtNumDoc'])."')";
		$r_detTabla = mysqli_query($link, $c_detTabla);
		$n_detTabla = mysqli_num_rows($r_detTabla);
		
		if($n_detTabla == 0)
		{
			$divMsjNoDoc = "NO HAY REGISTROS DE RECLAMOS PARA EL TIPO Y N&Uacute;MERO DE DOCUMENTO INGRESADOS"; 
			$divListTabla = ""; 
			$divDetTabla = "";
			$respuesta->Assign("divMsjNoDoc", "innerHTML", $divMsjNoDoc);
			$respuesta->Assign("divListTabla", "innerHTML", $divListTabla);
			$respuesta->Assign("divDetTabla", "innerHTML", $divDetTabla);
		}
		else
		{
			$divListTabla = "
				<table width='100%' border='0'>
					<tr>
						<td colspan='6'> <hr></td>
					</tr>
					  <tr class='textCabTabla2'>
						<td align='center'>Fec.Registro</td>
						<td align='center''>Documento</td>
						<td align='center'>Apellidos y Nombres</td>
						<td align='center'>Tipo Reclamo</td>
						<td align='center'>Estado</td>
						<td></td>
					  </tr>";
			
			while($d_detTabla = mysqli_fetch_array($r_detTabla))
			{	 
				  $divListTabla.= "
					<form name = 'frmConTabla".$d_detTabla[0]."' action='' method='post'>
					<tr class='textDetalle'>
						<td align='center'>".$d_detTabla[1]."</td>
						<td align='center'>".$d_detTabla[6]." - ".$d_detTabla[4]."</td>
						<td align='center'>".$d_detTabla[5]."</td>
						<td align='center'>".$d_detTabla[2]."</td>
						<td align='center'>".$d_detTabla[7]."</td>
						<td align='center'><input name='cmdConsulta' type='button' class='textBoton2' value='Consultar' onClick='xajax_f_conreclamo(\"".$d_detTabla[0]."\");'  /></td>
					</tr>
					</form>";			
			}
			$divListTabla.= "
					<tr>
						<td colspan='6'> <hr></td>
					</tr>
				</table>";
			desconectar_db(); 
			
			$divMsjNoDoc = ""; 
			$divDetTabla = "";
			$respuesta->Assign("divMsjNoDoc", "innerHTML", $divMsjNoDoc);
			$respuesta->Assign("divListTabla", "innerHTML", $divListTabla);
			$respuesta->Assign("divDetTabla", "innerHTML", $divDetTabla);
		}  
	}
	return $respuesta;
}
function f_conreclamo($codigo)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
		
	$link = conectar_db();
	$c_detTabla = "call sp_con_reclamo_x_cod2('".$codigo."')";
	$r_detTabla = mysqli_query($link, $c_detTabla);
	$d_detTabla = mysqli_fetch_array($r_detTabla);
	
	$divDetTabla = "
			<table  width='800' border='0' align='center'>
				<tr>
					<td width='40%'></td>
					<td width='60%'></td>
				</tr>
				<tr>
					<td class='textCabTabla' colspan='2'>Datos de la persona que realiza el reclamo</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Fecha de registro del reclamo:</td>
					<td class='textDetalle'>".$d_detTabla[17]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Tipo de documento de identidad:</td>
					<td width='400' class='textDetalle'>".$d_detTabla[1]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>N&uacute;mero de documento:</td>
					<td class='textDetalle'>".$d_detTabla[2]."</td>
				</tr>
				<tr>
					<td align='right'  class='textDescripcion'>Nombres:</td>
					<td class='textDetalle'>".$d_detTabla[3]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Apellidos:</td>
					<td class='textDetalle'>".$d_detTabla[4]."</td>
				</tr>
				<tr>
				<td align='right'  class='textDescripcion'>Direcci&oacute;n:</td>
				<td class='textDetalle'>".$d_detTabla[5]."</td>
				</tr>
				<tr>
				<td align='right' class='textDescripcion'>Tel&eacute;fono:</td>
				<td class='textDetalle'>".$d_detTabla[6]."</td>
				</tr>
				<tr>
				<td align='right' class='textDescripcion'>E-Mail:</td>
				<td class='textDetalle'>".$d_detTabla[7]."</td>
				</tr>
				<tr>
				<td align='right' class='textDescripcion'>Menor de edad?</td>
				<td class='textDetalle'>";
				
			if ($d_detTabla[8] == "N")
				$divDetTabla.= "NO";
			else
				$divDetTabla.= "SI";
				
				$divDetTabla.= "</td>
				</tr>
				<tr>
				<td align='right' class='textDescripcion'>Nombre del padre o la madre en caso de menor de edad</td>
				<td class='textDetalle'>".$d_detTabla[9]."</td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td class='textCabTabla' colspan='2'>Datos del producto o servicio contratado</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Local:</td>
					<td class='textDetalle'>".$d_detTabla[10]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Tipo de bien contratado:</td>
					<td class='textDetalle'>".$d_detTabla[11]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Monto Reclamado:</td>
					<td class='textDetalle'>".$d_detTabla[12]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Descripci&oacute;n:</td>
					<td class='textDetalle'>".$d_detTabla[13]."</td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td class='textCabTabla' colspan='2'>Detalle de la reclamaci&oacute;n y pedido del consumidor</td>                        
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Tipo:</td>
					<td class='textDetalle'>".$d_detTabla[14]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Detalle del reclamo:</td>
					<td class='textDetalle'>".$d_detTabla[15]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Pedido:</td>
					<td class='textDetalle'>".$d_detTabla[16]."</td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td class='textCabTabla' colspan='2'>Respuesta</td>
				</tr> 
				<tr>
					<td align='right' class='textDescripcion'>Fecha de la respuesta:</td>
					<td class='textDetalle'>".$d_detTabla[17]."</td>
				</tr>
				<tr>
					<td align='right' class='textDescripcion'>Respuesta:</td>
					<td class='textDetalle'>".$d_detTabla[18]."</td>
				</tr>
				<tr>
					<td colspan='2'><hr></td>
				</tr>
			</table>";
		
		desconectar_db();
		
		$respuesta->Assign("divDetTabla", "innerHTML", $divDetTabla);
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
					
					
					
					
					
					
					<table width="800" border="0" align="center">
							<tr>
								<td width="50%">&nbsp;</td>
								<td width="50%">&nbsp;</td>
							</tr>
							<tr>
								<td align="right"  class="textDescripcion">Tipo de documento:</td>
								<td>
								<select name="slcTipDoc" id="slc_tip_doc" class="textDetalle">
											<option value="">[Seleccione el tipo de documento]</option>
											<?php
											$link = conectar_db();
											$c_doc = "call sp_con_mae_tabla_det_x_cod_tabla('P001')";
											$r_doc = mysqli_query($link, $c_doc);
											while($d_doc = mysqli_fetch_array($r_doc))
											{
												echo "<option value='".$d_doc[0]."'>".$d_doc[4]."</option>";
											}
											desconectar_db();
											?> 
											</select></td>
							</tr>
							<tr>
								<td align="right" class="textDescripcion">Número de documento:</td>
								<td><input name="txtNumDoc" type="text" maxlength="12" onKeyPress="return onlyNumeric(event);" class="textDetalle"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="textAlerta"><div id="divMsjNoDoc">&nbsp;</div></td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input name="btn_consultar" type="button" value="Consultar" class="textBoton" onClick="xajax_f_listareclamo(xajax.getFormValues(frmConReclamo));"></td>
							</tr>
						</table>
						<table border="0" width="800" align="center">
							<tr>
								<td ><div id="divListTabla"></div></td>
							</tr>
							<tr>
								<td ><div id="divDetTabla"></div></td>
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
