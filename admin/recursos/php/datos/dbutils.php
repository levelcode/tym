<?php

class DBUtils
{
	/* props */
	private $conexion = null;
	public $sentencia = null;
	private $errores;

	/* metds */

	public function __construct(){
		$this->conexion = new DB();

		$this->errores = fopen('../../../../errores/errores.txt', 'a');

		if($this->conexion === false){
			throw new Exception("No se pudo conectar con la base de datos");
		}

		$this->conexion = $this->conexion->obtenerConexion();
	}

	public function __destruct(){
		fclose($this->errores);
	}

	public function consultar($sql){
		$sentencia = $this->conexion->query($sql);
		if($sentencia === false){
			echo $this->conexion->errorInfo()[2];
			fwrite($this->errores, $sentencia->errorInfo()[0].' -> '.$sentencia->errorInfo()[2]."\n");
			return 0;
		}else{
			$this->sentencia = $sentencia;
		}
		return 1;
	}


	# preparar cualquier tipo de consulta
	public function ejecutarConParametros($sql, $parametros){
		$sentencia = $this->conexion->prepare($sql);
		if($sentencia === false){
			fwrite($this->errores, $sentencia->errorInfo()[0].' -> '.$sentencia->errorInfo()[2]."\n");
			return 0;
		}else{
			if($sentencia->execute($parametros)){
				$this->sentencia = $sentencia;
			}else{
				fwrite($this->errores, $sentencia->errorInfo()[0].' -> '.$sentencia->errorInfo()[2]."\n");
				return 0;	
			}
		}

		return 1;
			
	}

	public function ejecutar($sql){
		$resultado = $this->conexion->exec($sql);
		if($resultado === false){
			fwrite($this->errores, $this->conexion->errorInfo()[2]."\n");
			return 0;
		}else{
			return $resultado;
		}
	}

	public function traerTodo($tipo = 1){
		if($this->sentencia === null){
			
			fwrite($this->errores, "La sentencia está vacia\n");
			return 0;
		}else{
			switch($tipo){
				case 1:
					$forma = PDO::FETCH_ASSOC;
					break;
				case 2:
					$forma = PDO::FETCH_NUM;
					break;
				case 3:
					$forma = PDO::FETCH_BOTH;
					break;
			}
			$resultado = $this->sentencia->fetchAll($forma);
			$this->sentencia = null;
			return $resultado;
		}
	}

	# prepara y ejecutar una transaccion
	public function transaccion($opciones){

		$this->conexion->beginTransaction();

		$errores = array();

		foreach($opciones as $opcion){

			if(!isset($opcion['parametros'])){
				if(!$this->conexion->exec($opcion['sql'])){
					print_r($this->conexion->errorInfo());
					$errores[] = $this->conexion->errorInfo()[0].' -> '.$this->conexion->errorInfo()[2]."\n";
				}
			}else{
				$sentencia = $this->conexion->prepare($opcion['sql']);
				if(!$sentencia->execute($opcion['parametros'])){
					$errores[] = $sentencia->errorInfo()[0].' -> '.$sentencia->errorInfo()[2]."\n";
				}
			}

		}

		if(count($errores) === 0){
			if($this->conexion->commit()){
				return 1;
			}else{
				$this->conexion->rollBack();
				foreach($errores as $error){
					fwrite($this->errores, $error."\n");
				}
				return 0;
			}
		}else{
			$this->conexion->rollBack();
			foreach($errores as $error){
				fwrite($this->errores, $error."\n");
			}
			return 0;
		}

		if($this->conexion->commit()){
			return 1;
		}else{
			$this->conexion->rollBack();
			fwrite($this->errores, $this->conexion->errorInfo()[2]."\n");
			return 0;
		}
			
	}

	public function ultimoID(){
		return $this->conexion->lastInsertId();
	}

}
