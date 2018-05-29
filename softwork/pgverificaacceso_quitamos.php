<?php

session_start();

include_once('dycFunctions/f_database.php');
include_once("dycFunctions/f_seguridad.php");

if(!empty($_REQUEST['txtUsuario']) and (!empty($_REQUEST['txtClave'])))
{
		$txtUsuario 	= htmlspecialchars(trim($_REQUEST['txtUsuario']));
		$txtClave 		= htmlspecialchars(trim($_REQUEST['txtClave']));
		
		$link = conectar_db();
		$c_acceso = "CALL sp_con_acceso_sistema('".$txtUsuario."', '".$txtClave."')";
		$r_acceso = mysqli_query($link, $c_acceso);
		$d_acceso = mysqli_fetch_array($r_acceso);
		desconectar_db();
		
		if ($d_acceso[0] == 'S')
		{
			$link = conectar_db();
			$c_datusu = "CALL sp_con_dat_usu_acceso('".$txtUsuario."')";
			$r_datusu = mysqli_query($link, $c_datusu);
			$d_datusu = mysqli_fetch_array($r_datusu);
			desconectar_db();
			
			session_start();
			$_SESSION['cod_user']   = $d_datusu[0];
			$_SESSION['nom_user'] = $d_datusu[1];
			$_SESSION['ape_user']  = $d_datusu[2];
			$_SESSION['loc_user']  = $d_datusu[4];
			$_SESSION['nom_loc_user']  = $d_datusu[6];
			$_SESSION['IndEstado'] =  'Autenticado';
			$_SESSION['IndClave']    = $d_datusu[5];
			
			header("location:pghome.php");	
			/*
			if($_SESSION['IndClave'] == 'S')
			{
				header("location:pgcambioclave.php");
			}
			else
			{
				header("location:pghome.php");	
			}
			*/
		}
		elseif ($d_acceso[0] == 'E')
		{
			f_sessionclose();
			header("location:index.php?inderror=2");
			exit;
		}	
		elseif ($d_acceso[0] == 'N')
		{
			f_sessionclose();
			header("location:index.php?inderror=3");
			exit;
		}	
		elseif ($d_acceso[0] == 'B')
		{
			f_sessionclose();
			header("location:index.php?inderror=4");
			exit;
		}	
}
else
{	
	f_sessionclose();
	header("location:index.php?inderror=1");
	exit;
}
	
?>