<?php 

namespace html;

class Pie extends a_Html
{
	protected $js;
	protected $pie = '';
	protected $user = '';

	public function __construct(array $opciones){
		$this->pie = isset($opciones['pie']) && gettype($opciones['pie']) == 'string' ? $opciones['pie'] : 'pie-general';
		$this->user = isset($opciones['user']) && gettype($opciones['user']) == 'string' ? $opciones['user'] : 'client';
		parent::__construct($opciones);
	}

	protected function construirHtml(){
		ob_start();
?>
		<?php require_once(_INC.$this->pie.'.php') ?>
		<!-- boton de subir -->
		<div id="boton-arriba">
			<i class="fa fa-angle-up"></i>
		</div>  
        
		<script src="recursos/js/jquery-ui.js"></script>
		<script src="recursos/js/bootstrap.js"></script>
		<?php if( $this->user == 'admin' ):?>
			<script src="recursos/js/admin/general.js"></script>
		<?php else: ?>
			<script src="recursos/js/general.js"></script>
		<?php endif ?>			
<?php $this->obtener('js') ?>
	</body>
</html>
<?php
		$this->html = ob_get_contents();
		ob_clean();
	}
}

?>