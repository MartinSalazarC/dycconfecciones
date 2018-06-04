<?php


	$varCaracteres = array ("/á/", "/é/", "/í/", "/ó/", "/ú/", "/ñ/", "/Ñ/"); 
	$varCaracteresHTML = array ("a", "e", "i", "o", "u", "n", "N"); 
	
	//CODIGO DEL ARCHIVO ADJUNTO
	$accion = $_POST['hddAccion'];
	$dir_basic = $_POST['hddRutaBase'];
	$carp_req = $_POST['hddRepositorio'];
	$cod_file = $_POST['hddCodFile'];
	$cod_usuario = $_POST['hddUsuario'];
	
	


	
	
	// Especificar el Nombre del Archivo
	$nombre_archivo = $_FILES['fileUpload']['name'];
	/* Especificar el Archivo Temporal junto con su Nombre Temporal antes de ser almacenado */
	$archivo_temporal = $_FILES['fileUpload']['tmp_name'];
	// Especificar los Errores de Carga o de la Subida del Archivo 
	$errores_subida = $_FILES['fileUpload']['error'];
	// Especificar el Tamaño del Archivo
	$formato_archivo = $_FILES['fileUpload']['size'];
	// Detallar los formatos o las extensiones del Archivo
	$formatos_validos = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
	



	if($accion == "upload")
	{
		//EXISTE DIRECTORIO BASE  SDC_ArchsNotr/CARP_AAMM
		if(is_dir($dir_basic))
		{	// EXISTE
			$ind_dir_princ = 1;
		}
		else
		{	// NO EXISTE
			$ind_dir_princ = 0;
		}
		if ($ind_dir_princ == 0)
		{	//SI NO EXISTE CREO EL DIRECTORIO
			
			if(!mkdir($dir_basic, 0777))
			{	// NO SE CREO
				echo '<script>parent.resultadoUpload(4, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$dir_basic.'");</script> ';
			}
			else
			{	//SI SE CREO
				// SDC_ArchsNotr/CARP_AAMM/CARP_RANDO
				chmod(substr($carp_req, 13)."/", 0777);
				$directorio = $dir_basic."/".$carp_req."/";
				//CREO EL DIRECTORIO
				if(!mkdir($directorio, 0777))
				{	//SI NO SE CREO
					echo '<script>parent.resultadoUpload(5, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
				}
				else
				{	
					chmod($carp_req."/", 0777);
					$tipo01 = $_FILES['fileUpload']['type'];
					// INTENTAMOS SUBIR EL ARCHIVO
					// (1) COMPROBAMOS SI EXISTE EL NOMBRE TEMPORAL DEL ARCHIVO
					if (isset($_FILES['fileUpload']['tmp_name'])) 
					{
						// (2) - COMPROBAMOS SI SE TRATA DEL FORMATO ESTABLECIDO
						if ($tipo01 == 'image/jpeg' or $tipo01 == 'image/JPEG' or $tipo01 == 'image/jpg' or $tipo01 == 'image/JPG' or $tipo01 == 'image/png' or $tipo01 == 'image/jpe')
						//if (in_array($formato_archivo,$formatos_validos))
						{
							// (3)SE INTENTA COPIAR EL ARCHIVO AL SERVIDOR
							if (!move_uploaded_file($_FILES['fileUpload']['tmp_name'], $directorio.basename(strtolower($_FILES['fileUpload']['name']))))
							{
								echo '<script>parent.resultadoUpload(1, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
							}
							else
							{
								echo '<script>parent.resultadoUpload(0, "'.preg_replace($GLOBALS["varCaracteres"], $GLOBALS["varCaracteresHTML"], strtolower($_FILES['fileUpload']['name'])).'", "'.$cod_file.'", "'.substr($directorio, 3).'");</script> ';
							}
						}
						else 
						{
							echo '<script>parent.resultadoUpload(2, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
						}
					}
					else
					{
						echo '<script>parent.resultadoUpload(3, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
					}
				}
			}
		}
		else
		{
			$directorio = $dir_basic."/".$carp_req."/";
			
			if(is_dir($directorio))
				$ind_dir_secun = 1;  //EXISTE
			else
				$ind_dir_secun = 0;	//NO EXISTE
			
			if ($ind_dir_secun == 0)
			{
				if(!mkdir($directorio, 0777))
				{
					echo '<script>parent.resultadoUpload(5, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
				}
				else
				{	
					chmod($carp_req."/", 0777);
					$tipo01 = $_FILES['fileUpload']['type'];
					// INTENTAMOS SUBIR EL ARCHIVO
					// (1) COMPROBAMOS SI EXISTE EL NOMBRE TEMPORAL DEL ARCHIVO
					if (isset($_FILES['fileUpload']['tmp_name'])) 
					{
						if ($tipo01 == 'image/jpeg' or $tipo01 == 'image/JPEG' or $tipo01 == 'image/jpg' or $tipo01 == 'image/JPG' or $tipo01 == 'image/png' or $tipo01 == 'image/jpe')
						//if (in_array($formato_archivo,$formatos_validos))
						{
							// (3)SE INTENTA COPIAR EL ARCHIVO AL SERVIDOR
							if (!move_uploaded_file($_FILES['fileUpload']['tmp_name'], $directorio.basename(strtolower($_FILES['fileUpload']['name']))))
							{
								echo '<script>parent.resultadoUpload(1, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
							}
							else
							{
								echo '<script>parent.resultadoUpload(0, "'.preg_replace($GLOBALS["varCaracteres"], $GLOBALS["varCaracteresHTML"], strtolower($_FILES['fileUpload']['name'])).'", "'.$cod_file.'", "'.substr($directorio, 3).'");</script> ';
							}
						}
						else 
						{
							echo '<script>parent.resultadoUpload(2, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
						}
					}
					else
					{
						echo '<script>parent.resultadoUpload(3, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
					}
				}
			}
			else
			{
				$tipo01 = $_FILES['fileUpload']['type'];
				// INTENTAMOS SUBIR EL ARCHIVO
				// (1) COMPROBAMOS SI EXISTE EL NOMBRE TEMPORAL DEL ARCHIVO
				if (isset($_FILES['fileUpload']['tmp_name'])) 
				{
					// (2) - COMPROBAMOS SI SE TRATA DEL FORMATO ESTABLECIDO
					if ($tipo01 == 'image/jpeg' or $tipo01 == 'image/JPEG' or $tipo01 == 'image/jpg' or $tipo01 == 'image/JPG' or $tipo01 == 'image/png' or $tipo01 == 'image/jpe') 
					//if (in_array($formato_archivo,$formatos_validos))
					{
						// (3)SE INTENTA COPIAR EL ARCHIVO AL SERVIDOR
						if (!move_uploaded_file($_FILES['fileUpload']['tmp_name'], $directorio.basename(strtolower($_FILES['fileUpload']['name']))))
						{
							echo '<script>parent.resultadoUpload(1, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
						}
						else
						{
							echo '<script>parent.resultadoUpload(0, "'.preg_replace($GLOBALS["varCaracteres"], $GLOBALS["varCaracteresHTML"], strtolower($_FILES['fileUpload']['name'])).'", "'.$cod_file.'", "'.substr($directorio, 3).'");</script> ';
						}
					}
					else 
					{
						echo '<script>parent.resultadoUpload(2, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
					}
				}
				else
				{
					echo '<script>parent.resultadoUpload(3, "'.$_FILES['fileUpload']['name'].'", "'.$cod_file.'", "'.$directorio.'");</script> ';
				}
			}
		}
	}
	elseif ($accion == "delete")
	{
		$archivo = preg_replace($GLOBALS["varCaracteres"], $GLOBALS["varCaracteresHTML"], strtolower($_POST["hddFile"]));
		$directorio = trim($dir_basic."/".$carp_req."/");
		$resp='';
	 
		if ((!empty($archivo)) && (file_exists(trim($directorio.$archivo)) == true))
		{
			unlink($directorio.$archivo); 
			rmdir($directorio);
			rmdir(trim($dir_basic."/".$carp_req."/"));
			$resp= 'S';
			echo '<script>parent.elimino("S", "'.$cod_file.'", "");</script>';
		}
		else
		{
			$resp= 'N';
			echo '<script>parent.elimino("N", "'.$cod_file.'", "'.$archivo.'");</script>';
		}
	}
 ?>