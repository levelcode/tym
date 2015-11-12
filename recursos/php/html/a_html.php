<?php 

namespace html;

abstract class a_Html
{
	protected $html = '';
	protected $js = '';

	public function __construct($opciones){
		if(isset($opciones['js']) && gettype($opciones['js']) == 'array') $this->ConstruirJs($opciones['js']);
		$this->construirHtml();
		$this->imprimirHtml();
	}

	public function imprimirHtml(){
		echo $this->html;
	}

	protected function obtener($var){
		echo $this->{$var};
	}

	protected function construirJs(array $opcion){
		$html = '';
		foreach($opcion as $script){
			$html .= "\t\t<script src=\"{$script}\"></script>\n";
		}
		$this->js = $html;
	}
}

?>