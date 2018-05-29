<?php 
session_unset();

include_once('dycFunctions/f_database.php');
include_once('dycFunctions/f_mensajes.php');
include_once('dycFunctions/f_generalajax.php');
include_once('dycFunctions/f_generalphp.php');
include_once('libs/headlogin.php');

$msjerror = "";

if(isset($_GET['inderror'])==1)
{
	if($_GET['inderror']==1)
	{ 
		$msjerror = "Faltan datos por ingresar.";
	} 
	elseif($_GET['inderror']==2)
	{ 
		$msjerror = "Error en los datos de acceso";
	} 
	elseif($_GET['inderror']==3)
	{ 
		$msjerror = "usuario inactivo";
	} 
	elseif($_GET['inderror']==4)
	{ 
		$msjerror = "usuario bloqueado";
	} 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
	<body onLoad="document.getElementById('txtUsuario').focus()">
		<?PHP head(); ?>
		<div class="container">
			<div class="row mt-3 justify-content-center">
				<div class="col col-md-4">
					<div class="card border-secondary">
						<div class="card-header">
								Acceso al Sistema<br>
						</div>
						<div align='center'><img src="img/login.jpg" class="card-image-top img-fluid" alt="" width="30%"></div>						
						<div class="card-body">
							<form name="frmLogin" action="pgverificaacceso.php" method="post">
								<div class="form-group">
									<label for="txtUsuario">Usuario</label>
									<input type="text" class="form-control textContenido01" placeholder="Usuario" name="txtUsuario" id="txtUsuario" maxlength='20' onKeyPress="aMayusculas(this); return onlyAlpha(event);" onChange="aMayusculas(this);">
								</div>

								<div class="form-group">
									<label for="txtClave">Contraseña</label>
									<input type="password" class="form-control textContenido01" placeholder="Contraseña" name="txtClave" id="txtClave" maxlength='20' onKeyPress="aMayusculas(this); return onlyAlphaNumeric(event);" onChange="aMayusculas(this);">
								</div>
								
								<div class="form-group row">
									<div class="col-12 text-center">
										<div class="row justify-content-center">
											<div class="col-12 col-sm-9 col-md-4">
												<button class="btn btn-success btn-block textBotonMin" type="submit">Ingresar</button>
											</div>
										</div>
									</div>
								</div>
								
								<?php
								
								if(trim($msjerror) <> "")
								{
									echo "
									<div class='alert alert-danger mt-5 textAlerta' id='alerta'>".$msjerror."
										<button type='button' class='close' data-dismiss='alert' aria-label='Cerrar'>
											<span aria-hidden='true'>&times;</span>
										</button>
									</div>";
								}
								?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<footer class="row mt-5 justify-content-center">
			<div class="col col-md-6">
				<div class="row justify-content-center">
					<div class="col col-xl-auto">
						<table>
							<tr>
							  <td rowspan="2" align="right" valign="middle"><img src="dycImages/whatsapp.png" width="40" height="40" alt="whatapp"></td>
							  <td class="textpiepagina2">Ll&aacute;manos</td>
							</tr>
							<tr>
								<td class="textpiepagina2" valign="top">944-494242</td>
							</tr>
						</table>
					</div>
					<div class="col col-xl-auto">
						<table>
							<tr>
							  <td rowspan="2" align="right"><img src="dycImages/contacto.png" width="40" height="40" alt="Contacto"></td>
							  <td class="textpiepagina2">Cont&aacute;ctanos</td>
							</tr>
							<tr>
								<td class="textpiepagina2" valign="top"><a href="<?php  echo $EnlaceContacto; ?>">www.dyc.com.pe/contacto</a></td>
							</tr>
						</table>
					</div>
					<div class="col col-xl-auto">
						<table>
							<tr>
							  <td rowspan="2" align="right"><img src="dycImages/siguenos.png" width="40" height="40" alt="S&iacute;guenos"></td>
							  <td class="textpiepagina2">S&iacute;guenos en</td>
							</tr>
							<tr>
								<td class="textpiepagina2" valign="top" align="center"><a href="<?php  echo $EnlaceFacebook; ?>" target="new"><img src="dycImages/facebook.png" width="20" height="20" alt="Facebook" ></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php  echo $EnlaceYoutube; ?>" target="new"><img src="dycImages/youtube.png" width="20" height="20" alt="Youtube" ></a></td>
							</tr>
						</table>
					</div>
					<div class="col col-xl-auto">
						<table>
							<tr>
							  <td rowspan="2" align="right"><a href="<?php  echo $EnlaceSomeServices; ?>"><img src="dycImages/someperuservices.png" width="43" height="40" alt="SomeServices" target="new"></a></td>
							  <td class="textpiepagina2">2017</td>
							</tr>
							<tr>
								<td class="textpiepagina2" valign="top">Creado por <span class="textpiepagina3">Some</span><span class="textpiepagina4">Services</span></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</footer>
	</body>
</html>