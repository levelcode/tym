<?php

class DB implements DBBase
{
	/* props */
	private $conexion;

	/* metds */
	public function __construct(){ // Método constructor
		$this->conectar();
	}

	public function __destruct(){ // Cerrar la conexión al no ser necesitada
		if(is_a($this->conexion, 'PDO')){
			$this->conexion = null;
		}
	}

	private function conectar(){ // intentar la conexión con la base de datos
		try{
			$this->conexion = new PDO(self::HOST, self::USER, self::PASS);
		}catch(PDOException $e){
			echo $e->getMessage();
			$this->conexion = null;
		}
	}

	public function obtenerConexion(){
		return $this->conexion;
	}
}
