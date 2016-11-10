<?php
require '../App/Db.php';
use App\DB as Database;
$letter = isset($_GET["term"]) ? strtoupper($_GET["term"]) : null ;
//$letter=strtoupper("p");
if (!$letter) return;
$queEmp="SELECT *, nombre_cliente as value FROM sys_cliente WHERE estado = 1 AND  nombre_cliente LIKE :letter ORDER BY nombre_cliente ASC LIMIT 0,10";

$conexion = Database\conectar();

$stm = Database\query($queEmp, array(
	'letter' => '%'.$letter.'%'
), $conexion);
	foreach($stm as $key => $value){
		$sql = "SELECT * FROM sys_cliente_contacto WHERE id_cliente = :id_cliente";
		$row = Database\query($sql,array("id_cliente" => $value["id_cliente"]), $conexion);
		$stm[$key]["contactos"] = $row;
	}
	echo json_encode($stm);
?>
