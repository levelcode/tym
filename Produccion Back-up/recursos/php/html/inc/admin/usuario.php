<div id="alternador-usuario">
	<span><?php echo $_SESSION["first_names"]?></span>
</div>
<div id="usuario">
	<a href="#" class="cerrar">
		<i class="fa fa-remove"></i>
	</a>	
	<div class="contenido">
		<div class="nombre">
			<span><?php echo $_SESSION["first_names"]?><?= ( isset($_SESSION["last_names"]) ) ? ' '. $_SESSION["last_names"] : '';?></span>
		</div>
		<hr>
		<ul class="opciones text-left">
			<li>
				<a href="www.progracol.com"><i class="fa fa-question"></i> &nbsp;Ayuda</a>
			</li>
			<li>
				<a href="./salir"><i class="fa fa-sign-out"></i> &nbsp;Salir</a>
			</li>
		</ul>
	</div>
</div>