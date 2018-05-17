<?php
session_start();
session_destroy();

include_once('libs/f_mensajes.php');
include_once('libs/f_database.php');
include_once('libs/f_headfooter.php');
require_once("xajax/xajax_core/xajax.inc.php" );

function f_enviacontacto($form)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');

	if ( trim($form['txtNombre'])=='' or trim($form['txtCorreo'])=='' or trim($form['txtAsunto'])=='' or  trim($form['txtMensaje'])=='' )
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
		$link = conectar_db();
		$c_reclamo = "call sp_reg_msj_contacto( '".$form['txtNombre']."',  '".$form['txtCorreo']."', '".$form['txtAsunto']."', '".$form['txtMensaje']."')";
		$r_reclamo = mysqli_query($link, $c_reclamo);
		$d_reclamo = mysqli_fetch_array($r_reclamo);
		desconectar_db();

		$divgrabar = "
			<form name = 'frmRegMensaje' action='' method='post' class='justify-content-center'>
				<div class='form-group row'>
					<div class='col-12 col-md-12 mt-2'>
						<label for='txtNombre' class='textDescripcion01'>Nombre / Raz&oacute;n Social</label>
						<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' maxlength='100' onKeyPress='return onlyAlpha2(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Ingrese Nombre' required >
					</div>
				</div>
				<div class='form-group row'>
					<div class='col-12 col-md-12 mb-0'>
						<label for='txtCorreo' class='textDescripcion01'>Correo Electr&oacute;nico</label>
						<input type='email' name='txtCorreo' id='txtCorreo' class='form-control form-control-sm textContenido01min' maxlength='100' placeholder='INGRESE CORREO' required >
					</div>
				</div>
				<div class='form-group row'>
					<div class='col-12 col-md-12 mb-0'>
						<label for='txtAsunto' class='textDescripcion01'>Asunto</label>
						<input type='text' name='txtAsunto' id='txtAsunto' class='form-control form-control-sm textContenido01' maxlength='200' onKeyPress='return onlyAlpha2(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Ingrese Asunto' required >
					</div>
				</div>
				<div class='form-group row'>
					<div class='col-12 col-md-12 mb-0'>
						<label for='txtMensaje' class='textDescripcion01'>Mensaje</label>
						<textarea name='txtMensaje' id='txtMensaje' cols='90' rows='4' onChange='aMayusculas(this);'' onBlur='aMayusculas(this);'' class='form-control form-control-sm textContenido01' placeholder='Ingrese Mensaje' required></textarea>
					</div>
				</div>
				<div class='row'>
					<div class='col-12 col-md-12 mb-0 text-right textDescripcion01Der'>
						Todos los campos son obligatorios
					</div>
				</div>
				<div class='form-group row'>
					<div class='col-12 col-sl-12 mt-2 justify-content-center text-center'>
						<button name='cmdGrabar' type='button' class='btn btn-success textBotonMin' title='Enviar' onClick='xajax_f_enviacontacto(xajax.getFormValues(frmRegMensaje));' >ENVIAR</button>
						<button name='cmdLimpiar' type='reset' class='btn btn-info textBotonMin' title='Limpiar'>LIMPIAR</button>
					</div>
				</div>
			</form>";

		$Msj = "<span class='textComunica'>Su mensaje ha sido enviado. En breve le responderemos.</span>";
		$divMsj = "
	 		<div class='alert alert-danger mt-1 textAlerta' id='alerta'>".$Msj."
	 			<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
	 				<span aria-hidden='true'>&times;</span>
	 			</button>
	 		</div>";
			$respuesta->Assign("divMsj", "innerHTML", $divMsj);
			$respuesta->Assign("divgrabar", "innerHTML", $divgrabar);
	}

	return $respuesta;
}

$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_enviacontacto");
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
			<div class="row cuerpo">
				<div class="col">
					<div class='row mt-3'>
						<div class='col textSubTitulo'>
		        	Encr&iacute;benos y en breve te responderemos:
		        </div>
					</div>
		      <div class='row justify-content-center mt-2'>
						<div class='col-12 col-lg-3 justify-content-center mt-1 order-1 order-lg-1 text-center textContenido01min'>
							<img src="dycImages/contactenos3.png" width="198" height="180">
							<br><br><b>TEL&Eacute;FONOS:</b> 944494242 / 944414941<br><br><b>Email:</b> dycconfecciones@hotmail.com
		        </div>
						<div class='col-12 col-lg-7 justify-content-center mt-1 order-2 order-lg-2'>
            	<div id="divgrabar">
								<form name = 'frmRegMensaje' action='' method='post' class='justify-content-center'>
									<div class='form-group row'>
										<div class='col-12 col-md-12 mt-2'>
											<label for='txtNombre' class='textDescripcion01'>Nombre / Raz&oacute;n Social</label>
											<input type='text' name='txtNombre' id='txtNombre' class='form-control form-control-sm textContenido01' maxlength='100' onKeyPress='return onlyAlpha2(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Ingrese Nombre' required >
										</div>
									</div>
									<div class='form-group row'>
										<div class='col-12 col-md-12 mb-0'>
											<label for='txtCorreo' class='textDescripcion01'>Correo Electr&oacute;nico</label>
											<input type='email' name='txtCorreo' id='txtCorreo' class='form-control form-control-sm textContenido01min' maxlength='100' placeholder='INGRESE CORREO' required >
										</div>
									</div>
									<div class='form-group row'>
										<div class='col-12 col-md-12 mb-0'>
											<label for='txtAsunto' class='textDescripcion01'>Asunto</label>
											<input type='text' name='txtAsunto' id='txtAsunto' class='form-control form-control-sm textContenido01' maxlength='200' onKeyPress='return onlyAlpha2(event);' onChange='aMayusculas(this);' onBlur='aMayusculas(this);' placeholder='Ingrese Asunto' required >
										</div>
									</div>
									<div class='form-group row'>
										<div class='col-12 col-md-12 mb-0'>
											<label for='txtMensaje' class='textDescripcion01'>Mensaje</label>
											<textarea name="txtMensaje" id='txtMensaje' cols="90" rows="4" onChange="aMayusculas(this);" onBlur="aMayusculas(this);" class='form-control form-control-sm textContenido01' placeholder='Ingrese Mensaje' required></textarea>
										</div>
									</div>
									<div class=' row'>
										<div class='col-12 col-md-12 mb-0 text-right textDescripcion01Der'>
											Todos los campos son obligatorios
										</div>
									</div>
									<div class='form-group row'>
										<div class='col-12 col-sl-12 mt-2 justify-content-center text-center'>
											<button name='cmdGrabar' type='button' class='btn btn-success textBotonMin' title='Enviar' onClick='xajax_f_enviacontacto(xajax.getFormValues(frmRegMensaje));' >ENVIAR</button>
											<button name='cmdLimpiar' type='reset' class='btn btn-info textBotonMin' title='Limpiar'>LIMPIAR</button>
										</div>
									</div>
								</form>
              </div>
							<div id="divMsj"></div>
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
