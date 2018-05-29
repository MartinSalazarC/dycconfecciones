<?php
function f_sessionopen()
{ 
	//Reanudamos la sesión
	if (!isset($_SESSION))
	{
		session_start();
		if (PHP_VERSION >= 5.1) 
		{
			session_regenerate_id(true);
		}
		else 
		{
			session_regenerate_id();
		}
	}
	//Comprobamos si el usario está logueado si no lo está, se le redirecciona al index
	if(!isset($_SESSION['cod_user']) and $_SESSION['IndEstado'] != 'Autenticado')
	{
		header('Location: acceso.php');
	}
}
function f_sessionclose()
{
	session_unset();
	session_destroy();
	session_start();
	if (PHP_VERSION >= 5.1) 
	{
		session_regenerate_id(true);
	}
	else 
	{
		session_regenerate_id();
	}
}	

?>