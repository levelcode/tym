<?php
namespace App\Usuario;

require 'General.php';

use App\General as Core;

function usuario(){

}
$data["nombre"] = "Michael";
$data["apellido"] = "Rojas";
$data["email"] = "michaelrojas@progracol.com";
$data["pass"] = "srg789sd";
//($data = array() , $json = true, $email = true, $debug = false, $confirma = true, $auto_confirma = true
echo new_account($data, true, true, false, true,true);
//echo $_ENV["PRODUCTION_SERVER"];
//phpinfo(32);
/*
$data_login = login("michaelrojas@progracol.com", "mypassword", false);
if($data_login["response"]){
  echo "1";
  echo "<pre>".print_r($data_login)."</pre>";
  echo $data_login["info"]["nombre"];
} else {
  echo "0";
}
*/
//$hashed_password = crypt('mypassword'); // dejar que el salt se genera automáticamente
//echo $hashed_password;
