<?php
require '../App/Db.php';
use App\DB as Database;
$letter = isset($_POST["term"]) ? strtoupper($_POST["term"]) : null ;
//$letter=strtoupper("p");
if (!$letter) return;
$queEmp="SELECT *, referencia as value FROM car_producto WHERE estado = 1 AND   ( referencia LIKE :letter OR descrip_productos LIKE :letter ) LIMIT 0,10";

$conexion = Database\conectar();

$stm = Database\query($queEmp, array(
  'letter' => '%'.$letter.'%'
), $conexion);

  echo json_encode($stm);
?>
