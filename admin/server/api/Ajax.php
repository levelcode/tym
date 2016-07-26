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
            case 'unique_element':
                echo Ing\get_product($_POST);
            break;
            case 'login':
            echo Ing\login( $_POST["id"], $_POST["pass"], $_POST["userType"] );
            break;
            case 'read':
                echo Ing\read_tires_products();
            break;
            case 'save_item':
            echo Ing\save_item($_POST);
            break;
            case 'update_item':
            echo Ing\update_item($_POST);
            break;
            case 'create_item':
            echo Ing\create_item($_POST);
            break;
            /* LISTAS */
            case 'list_all':
            echo Ing\list_all($_POST);
            break;
            case 'list_one_where':
            echo Ing\list_one_where($_POST);
            break;
            case 'list_varios':
            $data = Ing\list_varios($_POST);
            $dataPage = json_decode($data);
            echo $data;
            break;
            //create products
            case 'create_product':
            echo Ing\create_product($_POST);
            break;
            default :
            return json_encode($salida["error"]= "ERR-00");
            break;
        }
    }
}

?>
