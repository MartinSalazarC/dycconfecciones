<?php
	include_once('dycFunctions/f_mensajes.php');
	
	session_start();
	session_destroy();
    session_unset();
    header("Location: ".$EnlaceAcceso);  
?>