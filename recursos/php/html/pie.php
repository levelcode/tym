<?php
namespace html;

class Pie extends a_Html
{
	protected $js;
	protected $pie = '';

	public function __construct(array $opciones){
		$this->pie = isset($opciones['pie']) && gettype($opciones['pie']) == 'string' ? $opciones['pie'] : 'pie-general';
		parent::__construct($opciones);
	}

	protected function construirHtml(){
		ob_start();
?>
		<?php require_once(_INC."{$this->pie}.php") ?>
		<!-- boton de subir -->
		<div id="boton-arriba">
			<i class="fa fa-angle-double-up"></i>
		</div>

		<!-- modal
		<div id="modal">
            <div class="contenido">
				<span class="cerrar"><i class="fa fa-remove"></i></span>
            	<div class="datos"><div class="wrap">Hola mundo</div></div>
            </div>
        </div>-->

		<script src="/recursos/js/jquery-ui.js"></script>
		<script src="/recursos/js/bootstrap.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js"></script>
		<script src="/recursos/js/lightslider.js"></script>
		<script src="/recursos/js/general.js"></script>
		<?php $this->obtener('js') ?>
	</body>
</html>
<?php
		$this->html = ob_get_contents();
		ob_clean();
	}
}

?>
