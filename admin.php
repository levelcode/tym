<?php
require_once('recursos/php/config.php');


$opciones = array(
	'cabecero' => 'no-cabecero',
	'is_admin' => true,
	'responsivo' => true,
	'descripcion' => 'TYM Accesorios es una empresa de ',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => _TITULO.' CMS',
	'css' => array(
		'recursos/css/admin/index.css'
	),
	'js' => array()
);

$cabecero = new html\Cabecero($opciones);

/* --- menu --- */
//require_once(_INC.'menu-general.php');

?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65408004-2', 'auto');
  ga('send', 'pageview');

</script>

<!-- contenido -->
		<div id="contenido">
			<!-- ingreso -->
			<div id="ingreso" class="formulario">
				<div class="logo text-center">
					<div class="img text-center">
						<img src="recursos/img/logo.png" alt="">
					</div>
					<br>
					<span class="text-uppercase txt-11">INGRESA CON TU CUENTA</span>
				</div>
				<form id="form_login" name="form_login">
					<div class="usuario">
						<div class="form-group">
							<label for="id">C.C</i></label>
							<input class="form-control" type="text" name="id" id="id" placeholder="00000000-0">
						</div>
					</div>
					<div class="pass">
						<div class="form-group">
							<label for="pass">Contraseña</label>
							<input class="form-control" type="password" name="pass" id="pass" placeholder="******">
						</div>
					</div>
					<div class="boton bloque text-center">
						<button class="btn" type="submit"><i class="fa fa-sign-in"></i> &nbsp;Ingresar</button>
					</div>
					<div class="text-right txt-13">
						<!-- <a href="" class="c-uno pull-left" id="mostrar-registro"><i class="fa fa-user-plus"></i> &nbsp;Registrarme</a> --> <a href="" class="c-uno" id="mostrar-recuperar-contrasena"><i class="fa fa-lock"></i> &nbsp;Olvidé mi contraseña</a>
					</div>
				</form>
			</div>


			<!-- registro -->
			<div id="registro" class="formulario no-display">
				<div class="logo text-center">
					<span class="text-uppercase txt-11 c-gris">REGISTRARSE</span>
				</div>
				<form id="nueva_cuenta" name="nueva_cuenta">
					<div class="email">
						<div class="form-group">
							<label for="email">Usuario</i></label>
							<input class="form-control" type="text" name="email" id="email">
						</div>
					</div>
					<div class="pass">
						<div class="form-group">
							<label for="pass">Contraseña</label>
							<input class="form-control" type="password" name="pass" id="pass">
						</div>
					</div>
					<div class="pass2">
						<div class="form-group">
							<label for="pass2">Repetir Contraseña</label>
							<input class="form-control" type="password" name="pass2" id="pass2">
						</div>
					</div>
					<div class="boton bloque text-center">
						<button class="btn" type="submit"><i class="fa fa-user-plus"></i> &nbsp;Registrarme</button>
					</div>
					<div class="">
						<a href="" class="c-uno" id="regresar-registro"><i class="fa fa-arrow-left"></i> &nbsp;Regresar</a>
					</div>
				</form>
			</div>


			<!-- Recuperar contraseña -->
			<div id="olvide-contrasena" class="formulario no-display">
				<div class="logo text-center">
					<div class="img text-center"><img src="recursos/img/logo.png" alt=""></div>
					<br>
					<span class="text-uppercase txt-12">RECUPERAR CONTRASEÑA</span>
				</div>
				<form id="email_restablecer" name="email_restablecer">
					<div class="info text-center txt-16">
						<p class="txt-12">Para recuperar tu contraseña, ingresa la dirección de correo electrónico que usas para ingresar en esta aplicación</p>
					</div>
					<div class="pass">
						<div class="img text-center">
							<svg width="44" viewBox="0 0 32 32">
								<g>
									<path d="M28.3,5.4H3.7c-1.6,0-2.8,1.3-2.8,2.8v15.6c0,1.6,1.3,2.8,2.8,2.8h24.5c1.6,0,2.8-1.3,2.8-2.8V8.2 C31.1,6.6,29.8,5.4,28.3,5.4z M3.1,7.5l7.8,7.5l-8.1,5.4V8.2C2.8,7.9,2.9,7.7,3.1,7.5z M5.5,7.3h21l-9.3,9c-0.7,0.6-1.7,0.6-2.3,0 L5.5,7.3z M28.9,7.5c0.2,0.2,0.3,0.4,0.3,0.7v12.3l-8.1-5.4L28.9,7.5z M28.3,24.7H3.7c-0.5,0-0.9-0.4-0.9-0.9v-1.1l9.5-6.3l1.2,1.2 c0.7,0.7,1.6,1,2.5,1c0.9,0,1.8-0.3,2.5-1l1.2-1.2l9.5,6.3v1.1C29.2,24.3,28.8,24.7,28.3,24.7z"/>
								</g>
							</svg>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input class="form-control" type="email" name="" id="email" placeholder="usuario@orcopower.com">
						</div>
					</div>
					<div class="boton bloque text-center">
						<button class="btn" type="submit"><i class="fa fa-undo"></i> &nbsp;Recuperar</button>
					</div>
					<div class="txt-13">
						<a href="" class="c-uno" id="regresar-recuperar"><i class="fa fa-arrow-left"></i> &nbsp;Regresar</a>
					</div>
				</form>
			</div>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/admin/index.js',
		'server/js/admin/index.js'
	),
	'pie' => 'admin/pie-general',
	'user' => 'admin'
);

$pie = new html\Pie($opciones);

?>
