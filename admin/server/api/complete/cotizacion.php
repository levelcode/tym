<?php
require '../App/Db.php';
use App\DB as Database;
$letter = isset($_GET["term"]) ? strtoupper($_GET["term"]) : null ;
//$letter=strtoupper("p");
if (!$letter) return;
$queEmp="
    SELECT
    sys_cotizacion.id_cotizacion,
	CONCAT(sys_cotizacion.id_cotizacion, ' - ', sys_cliente.nombre_cliente ) as value,
	@id := sys_cotizacion.id_cotizacion,
	( SELECT GROUP_CONCAT(
		DISTINCT nombre_producto
		ORDER BY nombre_producto ASC
		SEPARATOR ' - '
	) FROM sys_cotizacion_producto, sys_producto
	WHERE
	sys_cotizacion_producto.id_producto = sys_producto.id_producto AND
	sys_cotizacion_producto.id_cotizacion = @id ) as productos

	FROM sys_cotizacion, sys_cliente
	WHERE
	sys_cotizacion.id_cliente = sys_cliente.id_cliente AND
	(sys_cotizacion.id_cotizacion LIKE :letter OR sys_cliente.nombre_cliente LIKE :letter  OR

     ( SELECT GROUP_CONCAT(
		DISTINCT nombre_producto
		ORDER BY nombre_producto ASC
		SEPARATOR ' - '
	) FROM sys_cotizacion_producto, sys_producto
	WHERE
	sys_cotizacion_producto.id_producto = sys_producto.id_producto AND
	sys_cotizacion_producto.id_cotizacion = sys_cotizacion.id_cotizacion ) LIKE :letter

	)
";

$conexion = Database\conectar();

$stm = Database\query($queEmp, array(
  'letter' => '%'.$letter.'%'
), $conexion);
  /*foreach($stm as $key => $value){
    $sql = "SELECT * FROM sys_producto_lista WHERE id_producto = :id_producto";
    $row = Database\query($sql,array("id_producto" => $value["id_producto"]), $conexion);
    $stm[$key]["val_unitarios"] = $row;
}*/
  echo json_encode($stm);
?>
