<?php 
session_start();
session_destroy();

include_once('libs/f_database.php');
include_once('libs/f_mensajes.php');
include_once('libs/f_generalajax.php');
include_once('libs/f_generalphp.php');
include_once('libs/f_headfooter.php');

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
	
	<script type='text/javascript' src='libs/f_javascript.js'></script>
</head>
<body onLoad="document.getElementById('txtUsuario').focus()">
	<header>
		<div class='container'>
			<?php
                f_headermenuacceso();
            ?>
		</div>
	</header>

	<main>
		<div class="container">
			<!-- Seccion xxxxxxxx -->
			<div class="row mt-3 justify-content-center">
				<div class="col col-md-4">
					<div class="card border-secondary">
						<div class="card-header textTitulo">
								Acceso al Sistema<br>
						</div>
						<div align='center'><img src="img/login.jpg" class="card-image-top img-fluid" alt="" width="30%"></div>						
						<div class="card-body">
							<form name="frmLogin" action="verificaacceso.php" method="post">
								<div class="form-group">
									<label for="txtUsuario" class="textDescripcion01">Usuario</label>
									<input type="text" class="form-control textContenido01" placeholder="Usuario" name="txtUsuario" id="txtUsuario" maxlength='20' onKeyPress="aMayusculas(this); return onlyAlpha(event);" onChange="aMayusculas(this);">
								</div>

								<div class="form-group">
									<label for="txtClave" class="textDescripcion01">Contraseña</label>
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
