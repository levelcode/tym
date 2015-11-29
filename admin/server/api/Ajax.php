<?php 
/*BASE NAMESPACES */
require 'Ing.php';
//require 'Ing_Users.php';
use App\Ing as Ing;

//call_user_func($_POST['a']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
  if( empty($_POST) ) {
    $_POST = json_decode(file_get_contents('php://input'), true);
  }

  if (isset($_POST["a"])) {


    $a = $_POST["a"];
    switch ($a) {
      case 'login':
      echo Ing\login($_POST["id"],$_POST["pass"]);
      break;
      /* LISTAS */
      case 'list_all':
      echo Ing\list_all($_POST);
      break;
      case 'list_one_where':
      echo Ing\list_one_where($_POST);
      break;
      case 'list_varios':
      echo Ing\list_varios($_POST);
      break;
      default :
      return json_encode($salida["error"]= "ERR-00");
      break;
    }
  }
}

?>
