<?php
include_once("dycFunctions/f_seguridad.php");

f_sessionopen();

include_once('dycFunctions/f_database.php');
include_once('dycFunctions/f_mensajes.php');
include_once('dycFunctions/f_generalphp.php');	
require_once("dycXajax/xajax_core/xajax.inc.php");
include_once('libs/menu.php');

function f_frmBusProductos()
{
		$respuesta = new xajaxResponse();
		$respuesta->setCharacterEncoding('ISO-8859-1');
		
		$divCab = f_frmBusProductosCpo();
		$divCpo = "";
	
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
		$respuesta->Assign("divCab", "innerHTML", $divCab);
		return $respuesta;
}
function f_frmBusProductosCpo()
{
	$cab = "
		<div class='row'>
			<div class='col'>
				<div class='card'>
					<div class='card-body'>
						<form name='frmBusProd' action='' method='post' class='justify-content-center'>
							<div class='form-group row justify-content-center'>
								<div class='col-12 col-lg-2 col-md-6 mt-2'>
									<label for='txtCodProd' class='textDescripcion01'>Código:</label>
									<input type='text' name='txtCodProd' id='txtCodProd' class='form-control mr-3 textContenido01 form-control-sm' maxlength='10' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='C&oacute;digo' >
								</div>
								<div class='col-12 col-lg-3 col-md-6 mt-2'>
									<label for='txtDesProd' class='textDescripcion01'>Descripción:</label>
									<input type='text' name='txtDesProd' id='txtDesProd' class='form-control mr-3 textContenido01 form-control-sm' maxlength='50' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Descripción' >
								</div>
								<div class='col-12 col-lg-2 col-md-6 mt-2'>
									<label for='slcCatProd' class='textDescripcion01'>Categor&iacute;a</label>
									<select name='slcCatProd' id='slcCatProd' class='form-control textContenido01 form-control-sm' onChange='xajax_f_BusSubCategoria(document.frmBusProd.slcCatProd.options[document.frmBusProd.slcCatProd.selectedIndex].value)'>
										<option value=''>[Seleccione]</option>";
					
					$link = conectar_db();
					$c_categ = "CALL sp_con_categoria('T')";
					$r_categ = mysqli_query($link, $c_categ);
					while ($d_categ = mysqli_fetch_array($r_categ))
					{
						$cab.= "		<option value='".$d_categ[0]."'>".$d_categ[1]."</option>";
					}
					desconectar_db();
					
	$cab.= "							<option value='%' >Todos los locales</option>
									</select>
								</div>
								<div class='col-12 col-lg-3 col-md-6 mt-2 mb-2'>
									<label for='slcSubCatProd' class='textDescripcion01'>Subcategor&iacute;a</label>
									<div id='divSubCat'>
										<select name='slcSubCatProd' id='slcSubCatProd' class='form-control textContenido01 form-control-sm' >
											<option value=''>[Seleccione]</option>
										</select>
									</div>
								</div>
								<div class='col-12 col-lg-2 col-md-6 justify-content-center mt-1'>
									<button name='cmdBusca' type='button' class='btn btn-primary btn-sm btn-block textBotonMin' title='Buscar Producto' onClick='xajax_f_busproducto(xajax.getFormValues(frmBusProd));'>Buscar Producto</button>
									<button name='cmdNuevo' type='button' class='btn btn-info btn-sm btn-block textBotonMin' title='Nuevo Producto' onClick='xajax_f_RegProducto();' >Nuevo Producto</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>";

    return $cab;
}
function f_BusSubCategoria($codcat)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if ($codcat == "")
	{
		$divSubCat = "
			<select name='slcSubCatProd' id='slcSubCatProd' class='form-control textContenido01 form-control-sm' >
				<option value=''>[Seleccione]</option>
			</select>";
	}
	else
	{
		$divSubCat = "
			<select name='slcSubCatProd' id='slcSubCatProd' class='form-control textContenido01 form-control-sm' >
				<option value=''>[Seleccione]</option>";
		
		$link = conectar_db();
		$c_subcateg = "CALL sp_con_subcat_x_cod_cat ('".$codcat."', 'T')";
		$r_subcateg = mysqli_query($link, $c_subcateg);
		while ($d_subcateg = mysqli_fetch_array($r_subcateg))
		{
			$divSubCat.= "<option value='".$d_subcateg[0]."'>".$d_subcateg[2]."</option>";
		}
		desconectar_db();
		$divSubCat.= "
			</select>";
	}
	
	$respuesta->Assign("divSubCat","innerHTML",$divSubCat);
	return $respuesta;
}
function f_BusEspAcad($codinst)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if ($codinst == "")
	{
		$divEspAcad = "
			<select name='slcEspInst' id='slcEspInst' class='form-control textContenido01 form-control-sm' >
				<option value=''>[Seleccione]</option>
			</select>";
	}
	else
	{
		$divEspAcad = "
			<select name='slcEspInst' id='slcEspInst' class='form-control textContenido01 form-control-sm' >
				<option value=''>[Seleccione]</option>";
		
		$link = conectar_db();
		$c_espinst = "CALL sp_con_esp_x_cod_inst ('".$codinst."', 'A')";
		$r_espinst = mysqli_query($link, $c_espinst);
		while ($d_espinst = mysqli_fetch_array($r_espinst))
		{
			$divEspAcad.= "<option value='".$d_espinst[0]."'>".$d_espinst[2]."</option>";
		}
		desconectar_db();
		$divEspAcad.= "
			</select>";
	}
	$respuesta->Assign("divEspAcad","innerHTML",$divEspAcad);
	return $respuesta;
}
function f_RegProducto()
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$repositorio = md5(uniqid(rand()).date("YmdHis"));
	
	$divCab = "
		<div class='row'>
			<div class='col'>
				<form name = 'frmRegProd' action='' method='post' class='justify-content-center'>
					<h6 class='textSubTitulo'>Registro de productos</h6>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 col-lg-3 mb-1'>
							<label for='slcCatProd' class='textDescripcion01'>Categor&iacute;a (*)</label>
							<select name='slcCatProd' id='slcCatProd' class='form-control textContenido01 form-control-sm' onChange='xajax_f_BusSubCategoria(document.frmRegProd.slcCatProd.options[document.frmRegProd.slcCatProd.selectedIndex].value)'>
								<option value=''>Seleccione</option>";
						$link = conectar_db();
						$c_categ = "CALL sp_con_categoria('T')";
						$r_categ = mysqli_query($link, $c_categ);
						while ($d_categ = mysqli_fetch_array($r_categ))
						{
							$divCab.= "
								<option value='".$d_categ[0]."'>".$d_categ[1]."</option>";
						}
						desconectar_db();
							
	$divCab.= "				</select>
						</div>
						<div class='col-12 col-md-7 col-lg-4 mb-1'>
							<label for='slcSubCatProd' class='textDescripcion01'>Categor&iacute;a (*)</label>
							<div id='divSubCat'>
								<select name='slcSubCatProd' id='slcSubCatProd' class='form-control textContenido01 form-control-sm' >
									<option value=''>[Seleccione]</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-7 col-lg-5 mb-1'>
							<label for='txtDesLargaProd' class='textDescripcion01'>Descripci&oacute;n (*)</label>
							<input type='text' name='txtDesLargaProd' id='txtDesLargaProd' class='form-control form-control-sm textContenido01' maxlength='100' onKeyPress='return onlyAlphaNumeric(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Descripci&oacute;n del Tipo de Producto'  >
						</div>
						<div class='col-12 col-md-5 col-lg-4 mb-1'>
							<label for='txtDesCortaProd' class='textDescripcion01'>Descripci&oacute;n Corta (*)</label>
							<input type='text' name='txtDesCortaProd' id='txtDesCortaProd' class='form-control form-control-sm textContenido01' maxlength='50' onKeyPress='return onlyAlphaNumeric(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Descripci&oacute;n Corta del Tipo de Producto'  >
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-4 col-lg-3 mb-1'>
							<label for='slcTela' class='textDescripcion01'>Tela:</label>
							<select name='slcTela' id='slcTela' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
						$link = conectar_db();
						$c_tela = "CALL sp_con_mae_tabla_det_x_cod_tabla('P016')";
						$r_tela = mysqli_query($link, $c_tela);
						while ($d_tela = mysqli_fetch_array($r_tela))
						{
							$divCab.= "<option value='".$d_tela[0]."'>".$d_tela[3]."</option>";
						}
						desconectar_db();
							
	$divCab.= "				</select>
						</div>
						
						<div class='col-12 col-md-4 col-lg-3 mb-1'>
							<label for='slcMarca' class='textDescripcion01'>Marca:</label>
							<select name='slcMarca' id='slcMarca' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
						$link = conectar_db();
						$c_marca = "CALL sp_con_mae_tabla_det_x_cod_tabla('P014')";
						$r_marca = mysqli_query($link, $c_marca);
						while ($d_marca = mysqli_fetch_array($r_marca))
						{
							$divCab.= "<option value='".$d_marca[0]."'>".$d_marca[3]."</option>";
						}
						desconectar_db();
							
	$divCab.= "				</select>
						</div>
						
						<div class='col-12 col-md-4 col-lg-3 mb-1'>
							<label for='slcGenero' class='textDescripcion01'>G&eacutenero:</label>
							<select name='slcGenero' id='slcGenero' class='form-control textContenido01 form-control-sm'>
								<option value=''>Seleccione</option>";
						$link = conectar_db();
				$c_gen = "CALL sp_con_mae_tabla_det_x_cod_tabla('P013')";
				$r_gen = mysqli_query($link, $c_gen);
				while ($d_gen = mysqli_fetch_array($r_gen))
				{
					$divCab.= "<option value='".$d_gen[0]."'>".$d_gen[3]."</option>";
				}
				desconectar_db();
							
	$divCab.= "				</select>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-5 col-lg-3 mb-1'>
							<label for='slcInst' class='textDescripcion01'>Instituci&oacute;n:</label>
							<select name='slcInst' id='slcInst' class='form-control textContenido01 form-control-sm' onChange='xajax_f_BusEspAcad(document.frmRegProd.slcInst.options[document.frmRegProd.slcInst.selectedIndex].value)'>
								<option value=''>Seleccione</option>";
						$link = conectar_db();
						$c_instacd = "CALL sp_con_inst_acad_prod('A')";
						$r_instacd = mysqli_query($link, $c_instacd);
						while ($d_instacd = mysqli_fetch_array($r_instacd))
						{
							$divCab.= "<option value='".$d_instacd[0]."'>".$d_instacd[1]."</option>";
						}
						desconectar_db();
						
	$divCab.= "				</select>
						</div>
						
						<div class='col-12 col-md-5 col-lg-4 mb-1'>
							<label for='slcEspInst' class='textDescripcion01'>Especialidad:</label>
							<div id='divEspAcad'>
								<select name='slcEspInst' class='form-control textContenido01 form-control-sm'>
									<option value=''>[Seleccione]</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-4 col-lg-2'>
							<label for='txtPorDcto' class='textDescripcion01'>% M&aacute;ximo Dscto</label>
							<input type='number' name='txtPorDcto' id='txtPorDcto' class='form-control form-control-sm textContenido01 ' maxlength='5' min='0' max='100' placeholder='Max. Dscto.'  >
						</div>
					</div>
				</form>
				
				<form name='frmUpload' method='post' enctype='multipart/form-data' action='dycUpload/CtrlUploadDeleteImg.php' target='iframeUpload' >
					<input type='hidden' name='hddRutaBase' value='../dycImgProd' >
					<input type='hidden' name='hddRepositorio' value='".$repositorio."' >
					<input type='hidden' name='hddCarpetaFile' value='prod'>
					<input type='hidden' name='hddCodFile' value='prod'>
					<iframe name='iframeUpload' style='display:none'></iframe>
					<div class='form-group row  align-items-center'>
						<div class='col-auto col-md-auto mb-1'>
							<label for='fileUpload' class='textDescripcion01'>Imagen Referencial:</label>
						</div>
						<div class='col-auto col-md-auto mb-1'>
							<div id='fil_prod'><input name='fileUpload' type='file' class='textBotonMin' onchange='submit()'></div>
						</div>
						<div class='col-auto col-md-auto mb-1'>
							<div id='opc_prod'><input type='hidden' name='hddAccion' value='upload' ></div>
						</div>
						
						<div class='col-12 col-md-5 mb-1 text-right align-self-center'>
							<div class='form-check'>
								<label class='form-check-label textDescripcion01'>
									<input type='checkbox' name='chkIndVistaWeb' id='chkIndVistaWeb' class='form-check-input mr-2 textDescripcion01'> Se visualiza en la web?
								</label>
							</div>
						</div>
					</div>
				</form>
				<div class='row justify-content-center'>
					<div class='col-12 text-right textComentario'>
						* Campos obligatorios
					</div>
				</div>
				<div class='row justify-content-center'>
					<div class='col-12 text-right textComentario'>
						<div id='divMsj'></div>
					</div>
				</div>
				<div class='row justify-content-center'>
					<div class='col-12 col-sl-4 mt-4 text-center'>
						<button name='cmdGrabar' type='button' class='btn btn-primary textBotonMin' title='Registrar Producto' onClick='xajax_f_RegProductodb(xajax.getFormValues(frmRegProd), xajax.getFormValues(frmUpload));' >Registrar Producto</button>
						<button name='cmdCancelar' type='button' class='btn btn-info textBotonMin' title='Salir' onClick='xajax_f_canregmodprod();' >Cancelar</button>
					</div>
				</div>
			</div>
		</div>";
			
	$divCpo = "";
	$respuesta->Assign("divCab","innerHTML",$divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	
	return $respuesta;
}
function f_RegProductodb($form, $formUp)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if (trim($form['slcCatProd']) == "" or trim($form['slcSubCatProd']) == "" or trim($form['txtDesLargaProd']) == ""  or trim($form['txtDesCortaProd']) == "")
	{
		$Msj = "Se deben completar todos los campos obligatorios.";
		$divMsj = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		$respuesta->Assign("divMsj","innerHTML",$divMsj);
	}
	elseif(trim($form['txtPorDcto']) >= 100)
	{
		$Msj = "El porcentaje no puede ser mayor o igual a 100%... verifique";
		$divMsj = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
		$respuesta->Assign("divMsj","innerHTML",$divMsj);
	}
	else
	{
		$indicador = "S";
		if(!isset($form['chkIndVistaWeb']) )
			$indicador= "N";
		
		if  ($indicador == "S"  and $formUp['hddAccion'] == "upload")
		{
			$Msj = "Si va a visualizar el producto en la Web debe adjuntar una imagen del producto";
			$divMsj = "
			<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
				<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>";
			$respuesta->Assign("divMsj","innerHTML",$divMsj);
		}
		else
		{
			$link = conectar_db();
			$c_regprod = "call sp_reg_producto( '".$form['slcCatProd']."', '".$form['slcSubCatProd']."', '".$form['txtDesCortaProd']."', '".$form['txtDesLargaProd']."', ".$form['txtPorDcto'].",  '".$form['slcMarca']."', '".$form['slcGenero']."', '".$form['slcTela']."', '".$form['slcInst']."', '".$_SESSION['cod_user']."', '".$formUp['hddRepositorio'] ."','".$indicador."', '".$form['slcEspInst']."')";
			$r_regprod = mysqli_query($link, $c_regprod);
			$d_regprod = mysqli_fetch_array($r_regprod);
			desconectar_db();
			
			if ($d_regprod[0] == 1)
			{
				$Msj = "Se ha presentado un error en el registro de su producto.  Utilice la opci&oacute;n de consulta y verifique si su producto se ha registrado.  Si no se ha registrado intente nuevamente.<br><br>  Si el error persiste comun&iacute;quese con mesa de servicio para su revisión";
				$divMsj = "
					<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
						<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
							<span aria-hidden='true'>&times;</span>
						</button>
					</div>";
				$respuesta->Assign("divMsj","innerHTML",$divMsj);
			}
			else
			{
				$divCab =  f_ConProductoCpo($d_regprod[1]);
				$respuesta->Assign("divCab","innerHTML",$divCab);
			}
		}
	}
	return $respuesta;
}	
function f_canregmodprod()
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCab = f_frmBusProductosCpo();	
	$divCpo = ""; 
	
	$respuesta->Assign("divCab","innerHTML",$divCab);
	$respuesta->Assign("divCpo","innerHTML",$divCpo);
	
	return $respuesta;
}	
function f_ConProducto($codprod)
{
		$respuesta = new xajaxResponse();
		$respuesta->setCharacterEncoding('ISO-8859-1');
		
		$divCab = f_ConProductoCpo($codprod);
		$divCpo = "";
	
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
		$respuesta->Assign("divCab", "innerHTML", $divCab);
		return $respuesta;
}
function f_ConProductoCpo($codprod)
{
	$link = conectar_db();
	$c_conprod = "call sp_con_prod_x_cod('".$codprod."')";
	$r_conprod = mysqli_query($link, $c_conprod);
	$d_conprod = mysqli_fetch_array($r_conprod);
	desconectar_db();
	
	$d_url = "www.dyc.com.pe/softwork/";
	$directorio =  "dycImgProd/".$d_conprod[8]."";	
	$direccion = $directorio."/prod/";
	$ruta = $direccion;	
	$flag = 'S';
	if (is_dir($ruta) == true)
	{	
		$ruta = dir($direccion);
		while ($archivo = $ruta->read())
		{	
			if($archivo <> '.' and $archivo <> '..'  and $archivo <> 'Thumbs.db')
			{
				$linea = "<a href='http://".$d_url.$direccion.$archivo."' target='_blank'><u>".$archivo."</u></a>";
				$flag = 'N';
				
				if ($d_conprod[9] == 'S')
					$publica = "<input type='checkbox' name='chkIndVistaWeb' id='chkIndVistaWeb' class='form-check-input mr-2 textDescripcion01' checked disabled> Se visualiza en la web?";
				else
					$publica = "<input type='checkbox' name='chkIndVistaWeb' id='chkIndVistaWeb' class='form-check-input mr-2 textDescripcion01' disabled> Se visualiza en la web?";
			}
		}
		$ruta->close();
	}
	if($flag == 'S')
	{
		$linea.= "No hay imagen adjunta del producto";
		$publica = "";
	}
	
	$cpo = "
		<div class='row'>
			<div class='col'>
				<form name = 'frmRegProd' action='' method='post' class='justify-content-center'>
					<h6 class='textSubTitulo'>Registro de productos</h6>
					
					<div class='form-group row'>
						<div class='col-12 col-md-5 col-lg-3 mb-1'>
							<label for='txtCodProd' class='textDescripcion01'>C&oacute;digo del Producto</label>
							<input type='text' name='txtCodProd' id='txtCodProd' class='form-control form-control-sm textContenido01' value='".$d_conprod[0]."'>
						</div>
						<div class='col-12 col-md-7 col-lg-4 mb-1'>
							<label for='txtEstProd' class='textDescripcion01'>Estado del Producto</label>
							<input type='text' name='txtEstProd' id='txtEstProd' class='form-control form-control-sm textContenido01' value='".$d_conprod[11]."'>
						</div>
					</div>

					<div class='form-group row'>
						<div class='col-12 col-md-5 col-lg-3 mb-1'>
							<label for='txtCatProd' class='textDescripcion01'>Categor&iacute;a</label>
							<input type='text' name='txtCatProd' id='txtCatProd' class='form-control form-control-sm textContenido01' value='".$d_conprod[4]."'>
						</div>
						<div class='col-12 col-md-7 col-lg-4 mb-1'>
							<label for='txtSubCatProd' class='textDescripcion01'>Categor&iacute;a</label>
							<input type='text' name='txtSubCatProd' id='txtSubCatProd' class='form-control form-control-sm textContenido01' value='".$d_conprod[6]."'>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-7 col-lg-5 mb-1'>
							<label for='txtDesLargaProd' class='textDescripcion01'>Descripci&oacute;n</label>
							<input type='text' name='txtDesLargaProd' id='txtDesLargaProd' class='form-control form-control-sm textContenido01' value='".$d_conprod[2]."'>
						</div>
						<div class='col-12 col-md-5 col-lg-4 mb-1'>
							<label for='txtDesCortaProd' class='textDescripcion01'>Descripci&oacute;n Corta</label>
							<input type='text' name='txtDesCortaProd' id='txtDesCortaProd' class='form-control form-control-sm textContenido01' value='".$d_conprod[1]."'>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-4 col-lg-3 mb-1'>
							<label for='txtTela' class='textDescripcion01'>Tela:</label>
							<input type='text' name='txtTela' id='txtTela' class='form-control form-control-sm textContenido01' value='".$d_conprod[17]."'>
						</div>
						<div class='col-12 col-md-4 col-lg-3 mb-1'>
							<label for='txtMarca' class='textDescripcion01'>Marca:</label>
							<input type='text' name='txtMarca' id='txtMarca' class='form-control form-control-sm textContenido01' value='".$d_conprod[13]."'>
						</div>
						<div class='col-12 col-md-4 col-lg-3 mb-1'>
							<label for='txtGenero' class='textDescripcion01'>G&eacutenero:</label>
							<input type='text' name='txtGenero' id='txtGenero' class='form-control form-control-sm textContenido01' value='".$d_conprod[15]."'>
						</div>
					</div>
					<div class='form-group row'>
						<div class='col-12 col-md-5 col-lg-3 mb-1'>
							<label for='txtInst' class='textDescripcion01'>Instituci&oacute;n:</label>
							<input type='text' name='txtInst' id='txtInst' class='form-control form-control-sm textContenido01' value='".$d_conprod[19]."'>
						</div>
						
						<div class='col-12 col-md-5 col-lg-4 mb-1'>
							<label for='txtEspInst' class='textDescripcion01'>Especialidad:</label>
							<input type='text' name='txtEspInst' id='txtEspInst' class='form-control form-control-sm textContenido01' value='".$d_conprod[21]."'>
						</div>
					</div>
					
					<div class='form-group row'>
						<div class='col-12 col-md-4 col-lg-2'>
							<label for='txtPorDcto' class='textDescripcion01'>% M&aacute;ximo Dscto</label>
							<input type='number' name='txtPorDcto' id='txtPorDcto' class='form-control form-control-sm textContenido01' value='".$d_conprod[7]."'>
						</div>
					</div>
					<div class='form-group row  align-items-center'>
						<div class='col-auto col-md-auto mb-1'>
							<label for='fileUpload' class='textDescripcion01'>Imagen Referencial:</label>
						</div>
						<div class='col-auto col-md-auto mb-1 textContenido01'>".$linea."</div>						
						<div class='col-12 col-md-5 mb-1 text-right align-self-center'>
							<div class='form-check'>
								<label class='form-check-label textDescripcion01'>".$publica."</label>
							</div>
						</div>
					</div>
				</form>
				<div class='row justify-content-center'>
					<div class='col-12 col-sl-4 mt-4 text-center'>
						<button name='cmdEdita' type='button' class='btn btn-primary textBotonMin' title='Editar Producto' onClick='xajax_f_modprod(\"".$d_conprod[0]."\");' >Editar Producto</button>
						<button name='cmdTallaColor' type='button' class='btn btn-primary textBotonMin' title='Detalles del Producto' onClick='xajax_f_regdetprod(\"".$d_conprod[0]."\");' >Detalles del Producto</button>						
						<button name='cmdCancelar' type='button' class='btn btn-info textBotonMin' title='Salir' onClick='xajax_f_canregmodprod();' >Cancelar</button>
					</div>
				</div>
			</div>
		</div>";
	
	return $cpo;
}
function f_busproducto($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_detProd = "call sp_con_productos('".$form['txtCodProd']."', '".$form['txtDesProd']."', '".$form['slcCatProd']."', '".$form['slcSubCatProd']."')";
	$r_detProd = mysqli_query($link, $c_detProd);
	$n_detProd = mysqli_num_rows($r_detProd);
	
	if($n_detProd == 0)
	{
		$divCpo = "
			<table width='100%' border='0'>
				<tr class='textCabTabla' height='20'>
					<td width='33%' align='left'>C&oacute;digo - Descripci&oacute;n</td>
					<td width='25%' align='left'>Categoría - Subcategoria</td>
					<td width='18%' align='left'>Instituci&oacute;n - Especialidad</td>						
					<td width='8%'>Estado</td>
					<td width='16%'></td>
				</tr>
				<tr>
					<td colspan='5'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='5' class='textAlerta'>NO HAY REGISTROS PARA MOSTRAR</td>
				</tr>
			</table>";
	}
	else
	{
		$divCpo = "
			<table width='100%' border='0'>
				<tr class='textCabTabla' height='20'>
					<td width = '33%' align='left'>C&oacute;digo - Descripci&oacute;n</td>
					<td width = '25%' align='left'>Categoría - Subcategoria</td>
					<td width = '18%' align='left'>Instituci&oacute;n - Especialidad</td>						
					<td width = '8%'>Estado</td>
					<td width = '16%'></td>
				</tr>";
		
		while($d_detProd = mysqli_fetch_array($r_detProd))
		{
			$divCpo.= "
				<form name = 'frmBusProd".$d_detProd[0]."' action='' method='post'>
				<tr class='textDetalle' onmouseover='this.style.backgroundColor=\"#C1DA83\"' onmouseout='this.style.backgroundColor=\"#FFFFFF\"'>
					<td>".$d_detProd[0]." - ".$d_detProd[1]."</td>
					<td>".$d_detProd[2]." - ".$d_detProd[3]."</td>
					<td>".$d_detProd[5]." - ".$d_detProd[6]."</td>
					<td align='center'>".$d_detProd[4]."</td>
					<td align='center'>
						<input name='cmdEdita' type='button' class='textBoton2' value='CONSULTAR' onClick='xajax_f_ConProducto(\"".$d_detProd[0]."\");'  />
						<input name='cmdTallaColor' type='button' class='textBoton2' value='DETALLES'  onClick='xajax_f_regdetprod(\"".$d_detProd[0]."\");'  /></td>
				</tr>
				</form>";
		}
		$divCpo.= "
			</table>";
	}
	desconectar_db();
	
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	return $respuesta;
}
function f_modprod($codprod)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_conprod = "call sp_con_prod_x_cod('".$codprod."')";
	$r_conprod = mysqli_query($link, $c_conprod);
	$d_conprod = mysqli_fetch_array($r_conprod);
	desconectar_db();
	
	$cpo = "
		<fieldset  style='background:#F7F7F7'><legend class='textLegend' >&nbsp;MODIFICA PRODUCTOS&nbsp;</legend>
			<form name='frmModProd' action='' method='post'>
				<table width='100%' border='0'>
					<tr height='25'>
						<td width='15%'></td>
						<td width='25%'></td>
						<td width='5%'  ></td>
						<td width='15%'></td>
						<td width='40%'></td>
					</tr>
					<tr height='25'>
						<td class='textDescripcionDer'>C&oacute;digo Producto:</td>
						<td class='textDetalle'>".$d_conprod[0]."</td>
						<td >&nbsp;</td>
						<td class='textDescripcionDer'>Estado:</td>
						<td class='textDetalle'>
							<select name='slcEstado' class='textDetalle' >";
	if($d_conprod[10] == 'A')
		$cpo.= "			<option value = 'A' selected>ACTIVO</option>
								<option value = 'I'>INACTIVO</option>";
	else
		$cpo.= "			<option value = 'A'>ACTIVO</option>
								<option value = 'I' selected>INACTIVO</option>";
	
	$cpo.= "			</select>&nbsp;*
						</td>
					</tr>
					<tr height='25'>
						<td class='textDescripcionDer'>Categor&iacute;a:</td>
						<td class='textDetalle'>
							<select name='slcCatProd' class='textDetalle' onChange='xajax_f_BusSubCategoria(document.frmModProd.slcCatProd.options[document.frmModProd.slcCatProd.selectedIndex].value)'>";
					
					$link = conectar_db();
					$c_categ = "CALL sp_con_categoria('A')";
					$r_categ = mysqli_query($link, $c_categ);
					while ($d_categ = mysqli_fetch_array($r_categ))
					{
						if ($d_conprod[3] == $d_categ[0])
							$cpo.= "<option value='".$d_categ[0]."' selected>".$d_categ[1]."</option>";
						else
							$cpo.= "<option value='".$d_categ[0]."' >".$d_categ[1]."</option>";
					}
					desconectar_db();
	
		$cpo.= "		</select>&nbsp;*
						</td>
						<td>&nbsp;</td>
						<td class='textDescripcionDer'>SubCategor&iacute;a:</td>
						<td class='textDetalle'><div id='divSubCat'>
							<select name='slcSubCatProd' class='textDetalle' >";
					$link = conectar_db();
					$c_subcateg = "CALL sp_con_subcat_x_cod_cat('".$d_conprod[3]."', 'A')";
					$r_subcateg = mysqli_query($link, $c_subcateg);
					while ($d_subcateg = mysqli_fetch_array($r_subcateg))
					{
						if ($d_conprod[5] == $d_subcateg[0])
							$cpo.= "<option value='".$d_subcateg[0]."' selected>".$d_subcateg[2]."</option>";
						else
							$cpo.= "<option value='".$d_subcateg[0]."' >".$d_subcateg[2]."</option>";
					}
					desconectar_db();
		$cpo.= "			
							</select>&nbsp;*</div>
						</td>
					</tr>
					<tr height='25'>
						<td class='textDescripcionDer'>Desc. Larga</td>
						<td colspan='4' class='textDetalle'><input name='txtDesLargaProd' type='text' class='textDetalle' size='40' maxlength='100' onKeyPress='return onlyAlphaNumeric(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' value='".$d_conprod[2]."'>&nbsp;*</td>	
					</tr>
					<tr height='25'>
						<td class='textDescripcionDer'>Desc. Corta:</td>
						<td colspan='2' class='textDetalle'><input name='txtDesCortaProd' type='text'  class='textDetalle' size='30' maxlength='50' onKeyPress='return onlyAlphaNumeric(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' value='".$d_conprod[1]."'>&nbsp;*</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr height='25'>
						<td class='textDescripcionDer'>Marca:</td>
						<td class='textDetalle'>
							<select name='slcMarca' class='textDetalle'>
								<option value=''>[Seleccione]</option>";
	$link = conectar_db();
	$c_marca = "CALL sp_con_mae_tabla_det_x_cod_tabla('P014')";
	$r_marca = mysqli_query($link, $c_marca);
	while ($d_marca = mysqli_fetch_array($r_marca))
	{
			if ($d_conprod[12] == $d_marca[0])
				$cpo.= "<option value='".$d_marca[0]."' selected>".$d_marca[3]."</option>";
			else
				$cpo.= "<option value='".$d_marca[0]."'>".$d_marca[3]."</option>";
	}
	desconectar_db();
	$cpo.= "	</select></td>
						<td>&nbsp;</td>
						<td class='textDescripcionDer'>Genero:</td>
						<td class='textDetalle'>
							<select name='slcGenero' class='textDetalle'>";
	$link = conectar_db();
	$c_gen = "CALL sp_con_mae_tabla_det_x_cod_tabla('P013')";
	$r_gen = mysqli_query($link, $c_gen);
	while ($d_gen = mysqli_fetch_array($r_gen))
	{
		if (trim($d_conprod[14]) == '')
		{
			$cpo.= "<option value=''>[Seleccione]</option>";
		}
		else
		{
			if ($d_conprod[14] == $d_gen[0])
				$cpo.= "<option value='".$d_gen[0]."' selected>".$d_gen[3]."</option>";
			else
				$cpo.= "<option value='".$d_gen[0]."'>".$d_gen[3]."</option>";
		}
	}
	desconectar_db();
	$cpo.= "	</select></td>
					</tr> 
					<tr height='25'>
						<td class='textDescripcionDer'>Instituci&oacute;n:</td>
						<td class='textDetalle'>
							<select name='slcInst' class='textDetalle' onChange='xajax_f_BusEspAcad(document.frmModProd.slcInst.options[document.frmModProd.slcInst.selectedIndex].value)'>
								<option value=''>[Seleccione]</option>";
	
	$link = conectar_db();
	$c_instacd = "CALL sp_con_inst_acad_prod('A')";
	$r_instacd = mysqli_query($link, $c_instacd);
	while ($d_instacd = mysqli_fetch_array($r_instacd))
	{
		if ($d_conprod[18] == $d_instacd[0])
			$cpo.= "<option value='".$d_instacd[0]."' selected>".$d_instacd[1]."</option>";
		else
			$cpo.= "<option value='".$d_instacd[0]."'>".$d_instacd[1]."</option>";
	}
	desconectar_db();
	$cpo.= "	</select></td>
						<td>&nbsp;</td>
						<td class='textDescripcionDer'>Especialidad:</td>
						<td class='textDetalle'><div id='divEspAcad'>
							<select name='slcEspInst' class='textDetalle' >
								<option value=''>[Seleccione]</option>";
						
						$link = conectar_db();
						$c_espinst = "CALL sp_con_esp_x_cod_inst ('".trim($d_conprod[18])."', 'A')";
						$r_espinst = mysqli_query($link, $c_espinst);
						while ($d_espinst = mysqli_fetch_array($r_espinst))
						{
							if ($d_conprod[20] == $d_espinst[0])
								$cpo.= "<option value='".$d_espinst[0]."' selected>".$d_espinst[2]."</option>";
							else
								$cpo.= "<option value='".$d_espinst[0]."'>".$d_espinst[2]."</option>";
						}
						desconectar_db();
						$cpo.= "
							</select></div>
						</td>
					</tr> 						
					<tr height='25'>
						<td class='textDescripcionDer'>Tipo Tela:</td>
						<td class='textDetalle'>
							<select name='slcTemp' class='textDetalle'>
								<option value=''>[Seleccione]</option>";
	$link = conectar_db();
	$c_temp = "CALL sp_con_mae_tabla_det_x_cod_tabla('P016')";
	$r_temp = mysqli_query($link, $c_temp);
	while ($d_temp = mysqli_fetch_array($r_temp))
	{
			if ($d_conprod[16] == $d_temp[0])
				$cpo.= "<option value='".$d_temp[0]."' selected>".$d_temp[3]."</option>";
			else
				$cpo.= "<option value='".$d_temp[0]."'>".$d_temp[3]."</option>";
	}
	desconectar_db();
	$cpo.= "	</select></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr> 						
					<tr height='25'>
						<td class='textDescripcionDer'>% M&aacute;ximo Dscto:</td>
						<td  class='textDetalle'><input name='txtPorDcto' type='text' class='textDetalle' size='5' maxlength='5'  onKeyPress='return onlyNumeric2(event);' value='".$d_conprod[7]."'>&nbsp;%</td>
						<td>&nbsp;</td>
						<td class='textDescripcionDer'>Se visualiza en la web?:</td>
						<td>";
						
	if ($d_conprod[9] == 'S')
		$cpo.= "<input name='chkIndVistaWeb' type='checkbox' value='S' checked ></td>";
	else
		$cpo.= "<input name='chkIndVistaWeb' type='checkbox' value='S'  ></td>";
	
	$cpo.= "
				</tr> 
			</table>
		</form>";
		
	$d_url = "www.dyc.com.pe/softwork/";
	$directorio =  "dycImgProd/".$d_conprod[8]."";
	$direccion = $directorio."/prod/";
	$ruta = $direccion;
	$flag = 'N';
	
	if (is_dir($ruta) == true)
	{
		$ruta = dir($direccion);
		while ($archivo = $ruta->read())
		{
			if($archivo <> '.' and $archivo <> '..'  and $archivo <> 'Thumbs.db')
			{
				$link = "http://".$d_url.$direccion.$archivo;
				$archivo2 = $archivo;
				
				$cpo.="
					<form method='post' enctype='multipart/form-data' action='dycUpload/CtrlUploadDeleteImg02.php' target='iframeUpload' name='frmUpload'>
						<table border='0' width='100%'>
							<tr height='25'>
								<input type='hidden' name='hddRutaBase' value='../dycImgProd' >
								<input type='hidden' name='hddRepositorio' value='".$d_conprod[8]."' >
								<input type='hidden' name='hddCarpetaFile' value='prod'>
								<input type='hidden' name='hddCodFile' value='prod'>
								<iframe name='iframeUpload' style='display:none'></iframe>
								<td class='textDescripcion' align='right' width='15%'>Imagen:</td>
								<td class='textArchivo' width='30%'><div id='fil_prod'><a href='".$link."' target='_blank'>".$archivo2."</a></div></td>
								<td class='textAlertaleft' width='30%'><div id='opc_prod'>
									<input type='hidden' name='hddFile' value='".$archivo2."' >
									<input type='hidden' name='hddAccion' value='delete'>
									&nbsp;&nbsp;
									<input type='submit' value='X' class='textBoton'></div></td>
								<td class='textDetalle'>*</td>
							</tr>
						</table>
					</form>";
				
				$flag = 'S';
			}
		}
		$ruta->close();
	}
	if ($flag == 'N')
	{
		$cpo.="
			<form method='post' enctype='multipart/form-data' action='dycUpload/CtrlUploadDeleteImg.php' target='iframeUpload' name='frmUpload'>
				<table border='0' width='100%'>
					<tr height='25'>
						<input type='hidden' name='hddRutaBase' value='../dycImgProd' >
						<input type='hidden' name='hddRepositorio' value='".$d_conprod[8]."' >
						<input type='hidden' name='hddCarpetaFile' value='prod'>
						<input type='hidden' name='hddCodFile' value='prod'>
						<iframe name='iframeUpload' style='display:none'></iframe>
						<td class='textDescripcionDer' width='15%'>Imagen Referencial:</td>
						<td class='textArchivo' width='30%'><div id='fil_prod'><input name='fileUpload' type='file' class='textBoton' onchange='submit()'></div></td>
						<td class='textAlertaleft' width='30%'><div id='opc_prod'><input type='hidden' name='hddAccion' value='upload' ></div></td>
						<td class='textDetalle'>*</td>
					</tr>
				</table>
			</form>";
	}
	$cpo.= "<table width='100%' border='0'>
			  <tr height='25'>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align='center' height='25'>
					<input name='cmdGrabar' type='button' class='textBoton' value='Grabar Modificación de Producto'  onClick='xajax_f_modproddb(xajax.getFormValues(frmModProd), xajax.getFormValues(frmUpload), \"".$d_conprod[0]."\", \"".$d_conprod[8]."\" );'  />
					<input name='cmdCancelar' type='button' class='textBoton' value='Cancelar Modificación de Producto'  onClick='xajax_f_canregmodprod();'  /></td>
			  </tr>
			  <tr>
				<td class='textLegend' align='left'>* Campos obligatorios</td>
			  </tr>
			  <tr height='25'>
				<td class='textAlerta' align='center'><div id='divMsjModProd'>&nbsp;</div></td>
			  </tr>
			</table>
		</fieldset >";
	
	$divCpo = "";
		
	$respuesta->Assign("divCab", "innerHTML", $cpo);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	return $respuesta;
}
function f_modproddb($form, $formUp, $codprod, $repositorio)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$indicador = "S";
	
	if (trim($form['slcCatProd']) == "" or trim($form['slcSubCatProd']) == "" or trim($form['txtDesCortaProd']) == "" or trim($form['txtDesLargaProd']) == "" or trim($form['txtPorDcto']) == "")
	{
		$divMsjModProd = "Se deben completar todos los campos obligatorios.";
		$respuesta->Assign("divMsjModProd","innerHTML",$divMsjModProd);
	}
	elseif(trim($form['txtPorDcto']) >= 100)
	{
		$divMsjModProd = "El porcentaje no puede ser mayor o igual a 100%... verifique";
		$respuesta->Assign("divMsjModProd","innerHTML",$divMsjModProd);
	}
	else
	{
		if(!isset($form['chkIndVistaWeb']))
			$indicador= "N";
		
		if  ($indicador == "S"  and $formUp['hddAccion'] == "upload")
		{
			$divMsjModProd = "Si va a visualizar el producto en la Web debe adjuntar una imagen del producto";
			$respuesta->Assign("divMsjModProd","innerHTML",$divMsjModProd);
		}
		else
		{	
			$link = conectar_db();
			$c_actprod = "call sp_act_producto( '".$codprod."',  '".$form['slcCatProd']."', '".$form['slcSubCatProd']."', '".$form['txtDesCortaProd']."', '".$form['txtDesLargaProd']."', ".$form['txtPorDcto'].", '".$form['slcMarca']."', '".$form['slcGenero']."', '".$form['slcTemp']."', '".$form['slcInst']."', '".$_SESSION['cod_user']."', '".$indicador."', '".$form['slcEstado']."', '".$form['slcEspInst']."')";
			$r_actprod = mysqli_query($link, $c_actprod);
			$d_actprod = mysqli_fetch_array($r_actprod);
			desconectar_db();
			
			if ($d_actprod[0] == 1)
			{
				$divMsjModProd = "Habido un error en la actualizacipon de los datos del producto.  Utilice la opci&oacute;n de consulta y verifique si su producto se ha actualizado.  Si no se ha actualizado intente nuevamente.<br><br>  Si el error persiste comun&iacute;quese con mesa de servicio para su revisión";
				$respuesta->Assign("divMsjModProd","innerHTML",$divMsjModProd);
			}
			else
			{
				$divCab =  f_ConProductoCpo($codprod);
				$respuesta->Assign("divCab","innerHTML",$divCab);
			}
		}
	}
	return $respuesta;
}	
function f_regdetprod($codprod)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');

	$divCab = f_regdetprod_cpo($codprod);		
	$divCpo = f_lisdetprod($codprod);
	
	$respuesta->Assign("divCab", "innerHTML", $divCab);	
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	
	return $respuesta;		
}
function f_regdetprod_cpo($codprod)
{
	$link = conectar_db();
	$c_prod = "call sp_con_prod_x_cod('".$codprod."')";
	$r_prod = mysqli_query($link, $c_prod);
	$d_prod = mysqli_fetch_array($r_prod);
	desconectar_db();
	
	$cpo = "
		<fieldset ><legend class='textLegend' >DETALLES DEL PRODUCTO</legend>
			<table width='100%' border='0'>
				<tr>
					<td width='15%'></td>
					<td width='20%'></td>
					<td width='15%'></td>
					<td width='20%'></td>
					<td width='10%'></td>
					<td width='20%'></td>
				</tr>
				<tr height='20'>
					<td class='textDescripcionDer'>categor&iacute;a:</td>
					<td class='textDetalle'>".$d_prod[4]."</td>
					<td class='textDescripcionDer'>Subcategor&iacute;a:</td>
					<td class='textDetalle' colspan='2'>".$d_prod[6]."</td>
					<td></td>
				</tr>
				<tr height='20'>
					<td class='textDescripcionDer'>Producto:</td>
					<td class='textDetalle' colspan='4'>".$d_prod[0]." - ".$d_prod[1]."</td>
					<td></td>
				</tr>
				<tr height='20'>
					<td class='textDescripcionDer'>Marca:</td>
					<td  class='textDetalle'>".$d_prod[13]."</td>
					<td class='textDescripcionDer'>G&eacute;nero:</td>
					<td  class='textDetalle'>".$d_prod[15]."</td>
					<td class='textDescripcionDer'>Tipo Tela:</td>
					<td  class='textDetalle'>".$d_prod[17]."</td>
				</tr>
				<tr height='20'>
					<td class='textDescripcionDer'>Institución:</td>
					<td  class='textDetalle'>".$d_prod[19]."</td>
					<td class='textDescripcionDer'>Especialidad:</td>
					<td  class='textDetalle'>".$d_prod[21]."</td>
					<td class='textDescripcionDer'>% M&aacute;ximo Dscto:</td>
					<td  class='textDetalle'>".$d_prod[7]."&nbsp;%</td>
				</tr>
				<tr>
					<td colspan='6'>
						<fieldset style='background-color:#F0F0F0'>
							<div id='divDetProd'>
								<form name='frmRegDetProd' action='' method='post'>
									<table border='0' width='95%' align='center'>
										<tr>
											<td width='10%'></td>
											<td width='13%'></td>
											<td width='10%'></td>
											<td width='17%'></td>
											<td width='15%'></td>
											<td width='10%'>
												<input type='hidden' name='hddPrd' value='".$d_prod[0]."' >
												<input type='hidden' name='hddCat' value='".$d_prod[3]."' >
												<input type='hidden' name='hddSubCat' value='".$d_prod[5]."' ></td>
											<td width='15%'></td>
											<td width='10%'></td>
										</tr>
										<tr>
											<td class='textDescripcionDer'>Talla</td>
											<td class='textDetalle'>
												<select name='slcTalla' class='textDetalle'>
												<option value=''>[Seleccione]</option>";
												$link = conectar_db();
												$c_talla = "CALL sp_con_mae_tabla_det_x_cod_tabla('P008')";
												$r_talla = mysqli_query($link, $c_talla);
												while ($d_talla = mysqli_fetch_array($r_talla))
												{
													$cpo.= "<option value='".$d_talla[0]."'>".$d_talla[3]."</option>";
												}
												desconectar_db();
												$cpo.= "
												</select>&nbsp;*</td>
											<td class='textDescripcionDer'>Color:</td>
											<td class='textDetalle' colspan='2'><select name='slcColor' class='textDetalle'>
													<option value=''>[Seleccione]</option>";
								$link = conectar_db();
								$c_color = "CALL sp_con_mae_tabla_det_x_cod_tabla('P017')";
								$r_color = mysqli_query($link, $c_color);
								while ($d_color = mysqli_fetch_array($r_color))
								{
									$cpo.= "<option value='".$d_color[0]."'>".$d_color[3]."</option>";
								}
								desconectar_db();
							$cpo.= "		</select>&nbsp;*</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td class='textDescripcionDer'>Precio Costo:</td>
											<td class='textDetalle'><input name='txtPreCosto' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='0'>&nbsp;*</td>
											<td class='textDescripcionDer'>Precio Venta:</td>
											<td class='textDetalle'><input name='txtPreVenta' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='0'>&nbsp;*</td>																											
											<td class='textDescripcionDer'>Precio Minimo Venta:</td>
											<td class='textDetalle'><input name='txtPreVentaMin' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='0'></td>
											<td class='textDescripcionDer'>% Descuento Venta:</td>
											<td class='textDetalle'><input name='txtPorDesc' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='0'>%</td>
										</tr>
										<tr>
											<td></td>
											<td class='textDescripcionDer'>Aplica Descuento:</td>
											<td class='textDetalle'><input name='chkIndApliDcto' type='checkbox' value='S'></td>																											
											<td class='textDescripcionDer'>Vista Descuento Web:</td>
											<td class='textDetalle'><input name='chkIndVistaDctoWeb' type='checkbox' value='S'></td>																											
											<td></td>
											<td align='right' class='textLegend' colspan='2'>* Datos obligatorios</td>
										</tr>
										<tr height='25'>	
											<td colspan='8' class='textAlerta'><div id='divMsjDetProd'></div></td>
										</tr>
										<tr height='25'>	
											<td align='center' colspan='8'>
												<input name='cmdGrabar' type='button' class='textBoton' value='AGREGA TALLA Y COLOR'  onClick='xajax_f_regdetproddb(xajax.getFormValues(frmRegDetProd));'  />
												<input name='cmdCancelar' type='button' class='textBoton' value='RETORNAR'  onClick='xajax_f_canregmodprod();'  /></td>
										</tr>
									</table>
								</form>
							</div>
						</fieldset>
					</td>
				</tr> 
			</table>
		</fieldset>";
		return $cpo;
}
function f_lisdetprod($codprod)
{
	
	$link = conectar_db();
	$c_detProd = "call sp_con_det_producto('".$codprod."')";
	$r_detProd = mysqli_query($link, $c_detProd);
	$n_detProd = mysqli_num_rows($r_detProd);
	
	$cpo = "
			<table width='95%' border='0' align='center'>
				<tr class='textCabTabla3' height='25px'>
					<td width = '12%' align='center'>Talla</td>
					<td width = '14%' align='center'>Color</td>
					<td width = '9%' align='center'>Precio Costo</td>
					<td width = '9%' align='center'>Precio Venta</td>
					<td width = '9%' align='center'>Precio Min Venta</td>
					<td width = '9%' align='center'>% Descuento</td>
					<td width = '9%' align='center'>Aplica Desc.</td>
					<td width = '9%' align='center'>Vista Web</td>
					<td width = '20%' align='center'></td>
				</tr>";
	
	
	if($n_detProd == 0)
	{
		$cpo.= "
				<tr height='25px'>
					<td colspan='9' class='textAlerta' > NO HAY REGISTROS DE TALLAS Y COLORES PARA MOSTRAR</td>
				</tr>
			</table>";
	}
	else
	{
		$cont = 1;
		while($d_detProd = mysqli_fetch_array($r_detProd))
		{
			$cpo.= "
					<tr class='textDetalle' onmouseover='this.style.backgroundColor=\"#C1DA83\"' onmouseout='this.style.backgroundColor=\"#FFFFFF\"' height='25px'>
						<td align='left'>".$d_detProd[2]."</td>
						<td align='left'>".$d_detProd[4]."</td>
						<td align='center'>".formato_num($d_detProd[5])."</td>
						<td align='center'>".formato_num($d_detProd[6])."</td>
						<td align='center'>".formato_num($d_detProd[12])."</td>
						<td align='center'>".formato_num($d_detProd[7])." %</td>
						<td align='center'>".$d_detProd[9]."</td>
						<td align='center'>".$d_detProd[11]."</td>
						<td align='center'>
							<form name='frmImpCobdBarra".$cont."' action='' method='post'>
								<input name='txtCanProd' type='text' class='textDetalle' maxlength='3' size='4' style='text-align:center'  value='8' readonly>								
								<input name='cmdCodigo' type='button' class='textBoton2' value='COD. BARRAS' onClick='f_concodbarrasubdetproducto(\"".$d_detProd[0]."\", document.frmImpCobdBarra".$cont.".txtCanProd.value);' />
								<input name='cmdEdita' type='button' class='textBoton2' value='EDITAR' onClick='xajax_f_modtallaproducto(\"".$d_detProd[0]."\", \"".$codprod."\");'  />
							</form>
							</td>
					</tr>";
			$cont ++;
		}
		$cpo.= "
			</table>";
	}
	desconectar_db();

	return $cpo;
}
function f_regdetproddb($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if (trim($form['slcTalla']) == "" or trim($form['slcColor']) == "" or trim($form['txtPreCosto'])=="" or trim($form['txtPreVenta'])=="" )
	{
		$divMsjDetProd = "Se deben completar todos los campos obligatorios.";
		$respuesta->Assign("divMsjDetProd","innerHTML",$divMsjDetProd);
	}
	else
	{
		$IndApliDcto= "S";
		if(!isset($form['chkIndApliDcto']) )
			$IndApliDcto= "N";

		$IndVistaDctoWeb= "S";
		if(!isset($form['chkIndVistaDctoWeb']) )
			$IndVistaDctoWeb= "N";
			
		if (trim($form['txtPreVenta']) < 0 or trim($form['txtPreVentaMin']) < 0 )
		{
			$divMsjDetProd = "No debe ingresar valores negativos al descuento o precio minimo de venta";
			$respuesta->Assign("divMsjDetProd","innerHTML",$divMsjDetProd);
			return $respuesta;
		}
		
		$link = conectar_db();
		$c_regdet = "call sp_reg_det_producto('".$form['hddPrd']."', '".$form['hddCat']."', '".$form['hddSubCat']."', '".$form['slcTalla']."', '".$form['slcColor']."', ".$form['txtPreCosto'].", ".$form['txtPreVenta'].", ".$form['txtPreVentaMin'].", ".$form['txtPorDesc'].", '".$IndApliDcto."', '".$IndVistaDctoWeb."', '".$_SESSION['cod_user']."')";
		$r_regdet = mysqli_query($link, $c_regdet);
		$d_regdet = mysqli_fetch_array($r_regdet);
		desconectar_db();
		
		$divCab = f_regdetprod_cpo($form['hddPrd']);
		$divCpo = f_lisdetprod($form['hddPrd']);
		
		$respuesta->Assign("divCab", "innerHTML", $divCab);
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	}
	return $respuesta;
}
function f_modtallaproducto($coddetprod, $codprod)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$link = conectar_db();
	$c_conprod = "call sp_con_tallas_prod_x_coddetprod('".$coddetprod."')";
	$r_conprod = mysqli_query($link, $c_conprod);
	$d_conprod = mysqli_fetch_array($r_conprod);
	desconectar_db();
	
	$divDetProd = "
		<form name='frmActDetProd' action='' method='post'>
			<table border='0' width='95%' align='center'>
				<tr>
					<td width='10%'></td>
					<td width='13%'></td>
					<td width='10%'></td>
					<td width='17%'></td>
					<td width='15%'></td>
					<td width='10%'></td>
					<td width='15%'></td>
					<td width='10%'><input type='hidden' name='hddPrd' value='".$codprod."' ><input type='hidden' name='hddDetPrd' value='".$coddetprod."' ></td>
				</tr>
				<tr>
					<td class='textDescripcionDer'>Talla</td>
					<td class='textDetalle'>
						<select name='slcTalla' class='textDetalle'>
						<option value=''>[Seleccione]</option>";
	$link = conectar_db();
	$c_talla = "CALL sp_con_mae_tabla_det_x_cod_tabla('P008')";
	$r_talla = mysqli_query($link, $c_talla);
	while ($d_talla = mysqli_fetch_array($r_talla))
	{
		if ($d_talla[0] == $d_conprod[1])
			$divDetProd.= "<option value='".$d_talla[0]."' selected>".$d_talla[3]."</option>";
		else
			$divDetProd.= "<option value='".$d_talla[0]."'>".$d_talla[3]."</option>";
	}
	desconectar_db();
	$divDetProd.= "
						</select>&nbsp;*</td>
					<td class='textDescripcionDer'>Color:</td>
					<td class='textDetalle' colspan='2'><select name='slcColor' class='textDetalle'>
							<option value=''>[Seleccione]</option>";
	$link = conectar_db();
	$c_color = "CALL sp_con_mae_tabla_det_x_cod_tabla('P017')";
	$r_color = mysqli_query($link, $c_color);
	while ($d_color = mysqli_fetch_array($r_color))
	{
		if ($d_color[0] == $d_conprod[3])
			$divDetProd.= "<option value='".$d_color[0]."' selected>".$d_color[3]."</option>";
		else
			$divDetProd.= "<option value='".$d_color[0]."'>".$d_color[3]."</option>";
	}
	desconectar_db();
	$divDetProd.= "		</select>&nbsp;*</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td class='textDescripcionDer'>Precio Costo:</td>
					<td class='textDetalle'><input name='txtPreCosto' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='".$d_conprod[5]."'>&nbsp;*</td>
					<td class='textDescripcionDer'>Precio Venta:</td>
					<td class='textDetalle'><input name='txtPreVenta' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='".$d_conprod[6]."'>&nbsp;*</td>																											
					<td class='textDescripcionDer'>Precio Minimo Venta:</td>
					<td class='textDetalle'><input name='txtPreVentaMin' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='".$d_conprod[10]."'></td>
					<td class='textDescripcionDer'>% descuento:</td>
					<td class='textDetalle'><input name='txtPorDesc' type='text' class='textDetalle' maxlength='7' size='7 onKeyPress='return onlyNumeric2(event);' value='".$d_conprod[7]."'>%</td>
				</tr>
				<tr>
					<td></td>
					<td class='textDescripcionDer'>Aplica Descuento:</td>
					<td class='textDetalle'>";
					
	if ($d_conprod[8] == 'S')
		$divDetProd.= "<input name='chkIndApliDcto' type='checkbox' value='S' checked>";
	else
		$divDetProd.= "<input name='chkIndApliDcto' type='checkbox' value='S'>";
	
	$divDetProd.= "	</td>																											
					<td class='textDescripcionDer'>Vista Descuento Web:</td>
					<td class='textDetalle'>";
					
	if ($d_conprod[9] == 'S')
		$divDetProd.= "<input name='chkIndVistaDctoWeb' type='checkbox' value='S' checked>";
	else
		$divDetProd.= "<input name='chkIndVistaDctoWeb' type='checkbox' value='S'>";
	
	$divDetProd.= "</td>
					<td></td>
					<td align='right' class='textLegend' colspan='2'>* Datos obligatorios</td>
				</tr>
				<tr height='25'>	
					<td colspan='8' class='textAlerta'><div id='divMsjDetProd'></div></td>
				</tr>
				<tr height='25'>	
					<td align='center' colspan='8'>
						<input name='cmdGrabar' type='button' class='textBoton' value='GRABAR MODIFICACI&Oacute;N'  onClick='xajax_f_modtallaproductodb(xajax.getFormValues(frmActDetProd));'  />
						<input name='cmdCancelar' type='button' class='textBoton' value='CANCELAR MODIFICACI&Oacute;N'  onClick='xajax_f_canregmoddetprod(\"".$codprod."\");'  /></td>
				</tr>
			</table>
		</form>";

	$respuesta->Assign("divDetProd","innerHTML",$divDetProd);
	return $respuesta;
}
function f_canregmoddetprod($codprod)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCab = f_regdetprod_cpo($codprod);
	$divCpo = f_lisdetprod($codprod);
		
	$respuesta->Assign("divCab", "innerHTML", $divCab);
	$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	
	return $respuesta;
}
function f_modtallaproductodb($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	if (trim($form['slcTalla']) == "" or trim($form['slcColor']) == "" or trim($form['txtPreCosto'])=="" or trim($form['txtPreVenta'])=="" )
	{
		$divMsjDetProd = "Se deben completar todos los campos obligatorios.";
		$respuesta->Assign("divMsjDetProd","innerHTML",$divMsjDetProd);
	}
	else
	{
		$IndApliDcto= "S";
		if(!isset($form['chkIndApliDcto']) )
			$IndApliDcto= "N";

		$IndVistaDctoWeb= "S";
		if(!isset($form['chkIndVistaDctoWeb']) )
			$IndVistaDctoWeb= "N";
			
		if (trim($form['txtPreVenta']) < 0 or trim($form['txtPreVentaMin']) < 0 )
		{
			$divMsjDetProd = "No debe ingresar valores negativos al descuento o precio minimo de venta";
			$respuesta->Assign("divMsjDetProd","innerHTML",$divMsjDetProd);
			return $respuesta;
		}
		/*
		if (trim($form['txtPreVenta']) > 0 and trim($form['txtPreVentaMin']) > 0 )
		{
			$divMsjDetProd = "Debe ingresar o % de descuento o precio mínimo de venta";
			$respuesta->Assign("divMsjDetProd","innerHTML",$divMsjDetProd);
			return $respuesta;
		}	
		*/

		$link = conectar_db();
		$c_regprod = "call sp_act_det_producto('".$form['hddDetPrd']."', '".$form['hddPrd']."', '".$form['slcTalla']."', '".$form['slcColor']."', ".$form['txtPreCosto'].", ".$form['txtPreVenta'].", ".$form['txtPreVentaMin'].", ".$form['txtPorDesc'].", '".$IndApliDcto."', '".$IndVistaDctoWeb."', '".$_SESSION['cod_user']."')";
		$r_regprod = mysqli_query($link, $c_regprod);
		$d_regprod = mysqli_fetch_array($r_regprod);
		desconectar_db();
		
		$divCab = f_regdetprod_cpo($form['hddPrd']);
		$divCpo = f_lisdetprod($form['hddPrd']);
		
		$respuesta->Assign("divCab", "innerHTML", $divCab);
		$respuesta->Assign("divCpo", "innerHTML", $divCpo);
	}
	return $respuesta;
}






$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_frmBusProductos");
$xajax->register(XAJAX_FUNCTION, "f_BusSubCategoria");
$xajax->register(XAJAX_FUNCTION, "f_BusEspAcad");
$xajax->register(XAJAX_FUNCTION, "f_busproducto");
$xajax->register(XAJAX_FUNCTION, "f_RegProducto");
$xajax->register(XAJAX_FUNCTION, "f_RegProductodb");
$xajax->register(XAJAX_FUNCTION, "f_ConProducto");
$xajax->register(XAJAX_FUNCTION, "f_canregmodprod");
$xajax->register(XAJAX_FUNCTION, "f_modprod");
$xajax->register(XAJAX_FUNCTION, "f_modproddb");
$xajax->register(XAJAX_FUNCTION, "f_regdetprod");
$xajax->register(XAJAX_FUNCTION, "f_regdetproddb");
$xajax->register(XAJAX_FUNCTION, "f_canregmoddetprod");
$xajax->register(XAJAX_FUNCTION, "f_modtallaproducto");
$xajax->register(XAJAX_FUNCTION, "f_modtallaproductodb");

$xajax->processRequest();
$xajax->configure('javascript URI','dycXajax/');
?>
<!DOCTYPE html">
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
		<script type='text/javascript' src='dycFunctions/f_upload.js'></script>
		
		<?php
			$xajax->printJavascript('dycXajax/');  
		?>
	</head>
	<body onLoad='xajax_f_frmBusProductos();'>
		<?php  menu();  ?>
		<div class="container">
			<header class="row">
				<div class="col-12">
					<h5>Gesti&oacute;n de Productos > <small class="text-muted">Maestro de Productos</small></h5>
					<hr>
				</div>
			</header>
			<div id="divCab"></div>
			<div id="divCpo"></div>
		</div>
	</body>
</html>