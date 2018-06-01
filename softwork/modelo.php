<?php
include_once("dycFunctions/f_seguridad.php");

f_sessionopen();

include_once('dycFunctions/f_database.php');
include_once('dycFunctions/f_mensajes.php');
include_once('dycFunctions/f_generalphp.php');	
require_once("dycXajax/xajax_core/xajax.inc.php");
include_once('libs/menu.php');

function f_xxxxx($xxxx)
{
	$respuesta = new xajaxResponse();
	$respuesta->setCharacterEncoding('ISO-8859-1');
	
	$divCpo = f_yyyyy();
	
	$respuesta->Assign("divCpoNotCli", "innerHTML", $divCpoNotCli);
	return $respuesta;
}
function f_yyyyy()
{
	$cpo ="";	

	return $cpo;
}


$xajax=new xajax();
$xajax->register(XAJAX_FUNCTION, "f_xxxxx");
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
		
		<?php
			$xajax->printJavascript('dycXajax/');
		?>
	</head>
	<body>
		<?php  menu();  ?>
		<div class="container">
			<header class="row">
				<div class="col-12">
					<h5>Inicio > <small class="text-muted">Inicio</small></h5>
					<hr>
				</div>
			</header>
			
		</div>
	</body>
</html>