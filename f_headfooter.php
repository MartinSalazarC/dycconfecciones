
<?php
function f_headermenu()
{
	$EnlaceHome = "http://localhost/dyccompefinal";
	$EnlaceNuestraEmpresa = "http://localhost/dyccompefinal/empresa.php";
	$EnlaceTiendas = "http://localhost/dyccompefinal/tiendas.php";
	$EnlaceContacto = "http://localhost/dyccompefinal/contacto.php";
	$EnlaceMiCuenta = "http://localhost/dyccompefinal/softwork/index.php";

	echo "
			<!-- Logo + Menu -->
			<div class='nav row rounded-top align-items-strech justify-content-between'>
				<!-- Logotipo -->
				<div class='col-md-12 col-lg logo d-flex align-items-center justify-content-center justify-content-lg-start'>
					<a href='".$EnlaceHome."'><img src='img/dyclogo.png' width='70px'></a>
                    &nbsp;&nbsp;&nbsp;
					<p>D&C Confecciones</p>
				</div>

				<!-- Menu -->
				<nav class='col-md-12 col-lg-auto menu d-flex align-items-stretch flex-wrap flex-sm-nowrap'>
					<a href='".$EnlaceNuestraEmpresa."' class='c-1 d-flex align-items-center'>
						<div class='d-flex flex-column text-center'>
							<span>Acerca de</span>
							<i class='icono icon-user'></i>
						</div>
					</a>
					<a href='".$EnlaceTiendas."' class='c-2 d-flex align-items-center'>
						<div class='d-flex flex-column text-center'>
							<span>Tiendas</span>
							<i class='icono icon-home'></i>
						</div>
					</a>
					<a href='".$EnlaceContacto."' class='c-3 d-flex align-items-center'>
						<div class='d-flex flex-column text-center'>
							<span>Contacto</span>
							<i class='icono icon-mail'></i>
						</div>
					</a>
          <a href='".$EnlaceMiCuenta."' class='c-4 d-flex align-items-center'>
						<div class='d-flex flex-column text-center'>
							<span>Acceso</span>
							<i class='icono icon-login'></i>
						</div>
					</a>
				</nav>
			</div>";
}
function f_headerslider()
{
	echo "
			<!-- Slider -->
			<div class='row slider'>
				<div class='col'>
					<div class='carousel slide' id='slider' data-ride='carousel'>
						<ol class='carousel-indicators'>
							<li data-target='#slider' data-slide-to='0' class='active'></li>
							<li data-target='#slider' data-slide-to='1'></li>
							<li data-target='#slider' data-slide-to='2'></li>
						</ol>
						<div class='carousel-inner'>
							<div class='carousel-item active'>
								<img src='img/slide1.jpg' alt='Slide #1' class='d-block img-fluid'>
							</div>
							<div class='carousel-item'>
								<img src='img/slide2.jpg' alt='Slide #2' class='d-block img-fluid'>
							</div>
							<div class='carousel-item'>
								<img src='img/slide3.jpg' alt='Slide #3' class='d-block img-fluid'>
							</div>
						</div>

						<a href='#slider' class='carousel-control-prev' data-slide='prev'>
							<span class='carousel-control-prev-icon' aria-hidden='true'></span>
							<span class='sr-only'>Anterior</span>
						</a>
						<a href='#slider' class='carousel-control-next' data-slide='next'>
							<span class='carousel-control-next-icon' aria-hidden='true'></span>
							<span class='sr-only'>Siguiente</span>
						</a>
					</div>
				</div>
			</div>";
}
function f_footer()
{
	$EnlaceSomeServices = "http://someperu.wixsite.com/someperu";
	$EnlaceFacebook = "https://www.facebook.com/unifomes/?fref=ts";
	$EnlaceInstagram = "https://www.facebook.com/unifomes/?fref=ts";
	$EnlaceYoutube = "https://www.youtube.com/watch?v=fGbx8eGk0A0";
	$EnlaceLibroReclamo = "http://localhost/dyccompefinal/libroreclamo.php";
	$EnlaceConsultaReclamo = "http://localhost/dyccompefinal/consultareclamo.php";
	$EnlaceContacto = "http://localhost/dyccompefinal/contacto.php";

	echo "
		<div class='container'>
			<hr>
			<div class='row redes-sociales justify-content-center''>
				<div class='col-md-4 text-center p-3 order-1 order-md-1'>
					<table border='0' align='center'>
						<tr>
							<td rowspan='2' align='right' width='50px'><img src='img/contacto02.png' width='50px' alt='Contacto'></td>
							<td width='200px' align='left'>Cont&aacute;ctanos</td>
						</tr>
						<tr>
              <td align='left'><a href='".$EnlaceContacto."'>www.dyc.com.pe/contacto</a></td>
						</tr>
					</table>
				</div>
				<div class='col-md-4 text-center p-3 order-3 order-md-2'>
          Tambi&eacute;n nos puedes ver en<br>
					<a href='".$EnlaceFacebook."' class='icono icon-facebook facebook'></a>
					<a href='".$EnlaceInstagram."' class='icono icon-instagram instagram'></a>
					<a href='".$EnlaceYoutube."' class='icono icon-youtube youtube'></a>
				</div>
				<div class='col-md-4 text-center p-3 order-2 order-md-3'>
					<table border='0' align='center'>
						<tr>
							<td rowspan='2' align='right' width='70px'><img src='img/libroreclamacion.png' width='70px' alt='Contacto'></td>
							<td width='180px' align='left'><a href='".$EnlaceLibroReclamo."'>Libro de Reclamaciones</a></td>
						</tr>
						<tr>
							<td align='left'><a href='".$EnlaceConsultaReclamo."'>Consulta de Reclamaciones</a></td>
						</tr>
					</table>
				</div>
			</div>
      <div class='row redes-sociales justify-content-center'>
				<div class='col-auto textpiepagina'>
        	<a href='".$EnlaceSomeServices."'><img src='img/someperuservices.png' width='30' alt='SomeServices' target='new'></a>
            2018 - Creado por SomeServices
        </div>
			</div>
		</div>";
}
?>
