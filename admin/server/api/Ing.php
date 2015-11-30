<?php
namespace App\Ing;

session_start();
date_default_timezone_set("America/Bogota");

//require 'App/General.php';
require '../../../model/product_type.php';
//require '../../recursos/mail/Mandrill_lib.php';
Use Model\Product_type as product_type_model;
//Use App\General as Core;
//Use App\WS as Ws;
use \stdClass;

function notificaciones(){
  return Core\dar_notificacion();
}
function olvidar_pass($email){
  $sql = "SELECT * FROM car_usuarios WHERE email = :email";
  $user = Core\query($sql, array("email" => $email));
  if(count($user) > 0){
    $salida["msj"] = "Por favor verificar email de recuperacion";
  } else {
    $salida["msj"] = "Por favor verificar email de recuperacion [01]";
  }
  return json_encode($salida);
}
function init_session($data){
  /*$_SESSION["id_user"] = $data["id_user"];
  $_SESSION["nombre"] = $data["nombre"];
  $_SESSION["email"] = $data["email"];
  $_SESSION["apellido"] = $data["apellido"];
  $_SESSION["area_usuario"] = $data["area_usuario"];
  $_SESSION["cargo_usuario"] = $data["cargo_usuario"];
  $_SESSION["iniciales"] = $data["iniciales"];*/

  foreach($data as $nombre => $valor){
    if($nombre == 'password' || $nombre == 'confirmacion') continue;
    $_SESSION[$nombre] = $valor;
  }
  /*$_SESSION["perfil"] = $data["perfil"];

  if(isset($data["documento"])){
    $_SESSION["documento"] = $data["documento"];
  }

  if(isset($data["fecha_nacimiento"])){
    $_SESSION["fecha_nacimiento"] = $data["fecha_nacimiento"];
  }
  if(isset($data["cargo"])){
    $_SESSION["cargo"] = $data["cargo"];
  }
  $_SESSION["nickname"] = $data["nombre"];
  //FOTO FILE
  if($data["foto_file"] == "" or $data["foto_file"] == null){
    $_SESSION["foto_file"] = "NA";
  } else {
    $_SESSION["foto_file"] = $data["foto_file"];
  }
  //FIRMA
  if($data["firma_file"] == "" or $data["firma_file"] == null){
    $_SESSION["firma_file"] = "NA";
  } else {
    $_SESSION["firma_file"] = $data["firma_file"];
  }
  $_SESSION["celular"] = $data["celular"];
  $_SESSION["iniciales"] = $data["iniciales"];
  $_SESSION["firma_file"] = $data["firma_file"];*/
}


function login( $id, $pass ){

  $is_json = true;
  $resultado = Core\login( $id,$pass, $is_json, false, false );
  
  if( $is_json ){
    $resultado = json_decode($resultado);
    $resultado = (array)$resultado;
  }

  if($resultado["response"]){
    $salida["accede"] = true;
    
    init_session($resultado["info"]);  
    
  }else{
    $salida["accede"] = false;
  }
  return json_encode($salida);
}

function crear_usuario($data){
  unset($data["a"]);
    unset($data["pass2"]);

  return Core\new_account($data, true, true, false, true, true );
}
function confirmar($key){
  $resultado = Core\confirmar($key, false);
  if($resultado["response"]){
    //INCIAR SESSION
    init_session($resultado["info"]);
    return json_encode($resultado);
  } else {
    return json_encode($resultado);
  }
}

function update_client_address( $data ) {

  $result = new \stdClass();

  $address_to_update['table'] = $data['table'];
  $address_to_update['column_id'] = $data['column_id'];
  $address_to_update['id'] = $data['id'];
  $address_to_update['person_in_charge'] = $data['personInCharge'];

  $updated_id = (Core\update($address_to_update));

  if( isset($updated_id) ) {
    $result->status = "ADDRESS_UPDATED";
  }else {
    $result->status = "ADDRESS_NOT_UPDATED";
  }

  return json_encode( $result );
}
    
function editar_perfil($data){

  $data["table"] = "client";
  $data["column_id"] = $data['column_id'];
  $data["id"] = $_SESSION["id"];
  //$data["email"] = $_SESSION["email"];
  if($data["pass"] != ""){
    if($data["pass"] != $data["pass2"]){
      //echo 1;
      $salida["error"] = "Las contraseñas no coinciden";
      return json_encode($salida);
    } else {
      //echo 2;
      unset($data["pass2"]);
      init_session($data);
      $data["password"] = crypt($data["pass"], $data["pass"]);
      unset($data["pass"]);
      
      return Core\update($data, false);
    }
  } else {
    unset($data["pass"]);
    unset($data["pass2"]);
    init_session($data);
    //header("Location: /salir");
    return Core\update($data);
  }
}

function date_compare($a, $b){
    $t1 = strtotime($a['request_date']);
    $t2 = strtotime($b['request_date']);
    return $t1 - $t2;
}    

function list_varios( $data ){
  if ( isset($data['from']) ){

        switch( $data['from'] ) {

          case 'admin-products':
            switch ( $data['action'] ) {
              case 'get_base_data':
                  $info_to_return['product_types'] = product_type_model\get_all_product_types();
                  $info_to_return['status'] = 'LOADED';
                break;
            }
            break;

        }

  }else{
    $info_to_return['status'] = 'NO_FROM';
  }
  return json_encode($info_to_return);
}

function get_all_vehicles() {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle WHERE status = 1 ORDER BY brand ASC";
  return Core\query($sql, array());
}

function get_models_by_brand( $brand_id ) {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model WHERE ".$GLOBALS["prefix"]. "vehicle_id = ". $brand_id ." AND status = 1 ORDER BY model ASC";
  return Core\query($sql, array());
}

function get_rin_types( $vehicle_id, $model_id ) {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model_has_tym_rin vhr"
  ." LEFT JOIN ".$GLOBALS["prefix"]. "rin r ON r.id = vhr.tym_rin_id "
  ." LEFT JOIN ".$GLOBALS["prefix"]. "rin_type rt ON rt.id = vhr.tym_rin_tym_rin_type_id "
  ." WHERE vhr.tym_vehicle_model_id = ".$model_id." AND vhr.tym_vehicle_model_tym_vehicle_id = ".$vehicle_id;
  return Core\query($sql, array());
}

function get_tires( $vehicle_id, $model_id ) {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model_has_tym_tire vht"
  ." LEFT JOIN ".$GLOBALS["prefix"]. "tire t ON t.id = vht.tym_tire_id "
  ." WHERE vht.tym_vehicle_model_id = ".$model_id." AND vht.tym_vehicle_model_tym_vehicle_id = ".$vehicle_id;
  return Core\query($sql, array());
}

function list_all($data){
  return Core\list_all($data, true);
}
function list_one_where($data){
  return Core\list_one_where($data, true);
}
function delete($data){
  return Core\delete_all($data, true);
}


function guardarImagen($img, $ruta, $nombre){
    if($img['error'] == 0){
        $ext = preg_match('/\.\w*?$/', $img['name'], $op);
        $ext = $op[0];
        $n = $ruta.$nombre.$ext;
        //echo $img['tmp_name'];
        if(move_uploaded_file($img['tmp_name'], $n)){
            return array(
                'nombre_completo' => $n, 
                'nombre' => $nombre.$ext
            );
        }
    }else{
        return false;
    }
}

function crearUsuario(){

    $f = $_FILES;

    if(isset($f['img_general'])){
        $img_general = guardarImagen($f['img_general'], '../../recursos/img/fotos/generales/', uniqid());
        $img_thumbnail = 'recursos/img/fotos/thumbnails/'.$img_general['nombre'];

        $copia = imagecreatetruecolor(100, 100);
        $original = imagecreatefrompng('../../recursos/img/fotos/generales/'.$img_general['nombre']);

        imagecopyresized($copia, $original, 0, 0, 0, 0, 100, 100, 240, 240);

        imagepng($copia, '../../recursos/img/fotos/thumbnails/'.$img_general['nombre']);

        imagedestroy($copia);
    }else{
        $img_general = array('nombre_completo' => '../recursos/img/no-user.png');
        $img_thumbnail = 'recursos/img/no-user-thumbnail.png';
    }

    if(isset($f['img_firma'])){
        $img_firma = guardarImagen($f['img_firma'], '../../recursos/img/fotos/firmas/', uniqid());
    }else{
        $img_firma = array('nombre_completo' => 'recursos/img/img-firma.png');
    }

    $sql = "INSERT INTO car_usuarios (nombre, apellido, area_usuario, cargo_usuario, pass, img_general, img_thumbnail, img_firma, confirmacion, email, iniciales, ingresa, acceso_remoto) VALUES (:nombre, :apellido, :area_usuario, :cargo_usuario, :pass, :img_general, :img_thumbnail, :img_firma, :confirmacion, :email, :iniciales, :ingresa, :acceso_remoto)";





    $data = array(
        'id_user' => $_POST['id_user'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'area_usuario' => $_POST['area_usuario'],
        'cargo_usuario' => $_POST['cargo_usuario'],
        'pass' => crypt($_POST['pass']),
        'img_general' => 'recursos/img/fotos/generales/'.$img_general['nombre'],
        'img_thumbnail' => $img_thumbnail,
        'img_firma' => 'recursos/img/fotos/firmas/'.$img_firma['nombre'],
        'confirmacion' => md5(uniqid()),
        'email' => $_POST['email'],
        'iniciales' => $_POST['iniciales'],
        'ingresa' => 'SI',
        'acceso_remoto' => $_POST['acceso_remoto']
    );

    $data["table"] = "usuarios";
    $data["colum_id"] = "id_user";
    
    if($data[$data["colum_id"]] == ""){
      return Core\create($data, false);
    } else {
      return Core\update($data, false);
    }

}

?>