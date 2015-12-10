<?php
namespace App\Ing;

session_start();
date_default_timezone_set("America/Bogota");

require 'App/General.php';
//require '../../recursos/mail/Mandrill_lib.php';
Use Model\Product_type as product_type_model;
Use App\General as Core;
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



function save_item( $data ) {

  if ( isset($data['from']) ){

        switch( $data['from'] ) {

          case 'admin-main-page':
            switch ( $data['action'] ) {
              case 'save_main_menu_item':
                $inserted = insert_product_type( $data['data'] );

                if( $inserted ) {
                  $info_to_return['menu_items'] = get_all_product_types();
                  $info_to_return['status'] = 'SUCCESS';  
                }else {
                  $info_to_return['status'] = 'ERROR';
                }
                
              break;
            }
          break;
        }

  }else{
    $info_to_return['status'] = 'NO_FROM';
  }
  return json_encode($info_to_return);
}    

function list_varios( $data ){
  if ( isset($data['from']) ){

        switch( $data['from'] ) {

          case 'admin-products':
            switch ( $data['action'] ) {
              case 'get_base_data':
                $info_to_return['product_types'] = get_all_product_types();
                $info_to_return['vehicles'] = get_all_vehicles();
                $info_to_return['status'] = 'LOADED';
              break;
              case 'get_models_by_brand':
                $info_to_return['models'] = get_models_by_brand( $data['brandId']);
                $info_to_return['status'] = 'LOADED';
              break;
            }
          break;
          case 'admin-main-page':
            case 'get_base_data':
              $info_to_return['menu_items'] = get_all_product_types();
              $info_to_return['status'] = 'LOADED';
            break;
          break;

        }

  }else{
    $info_to_return['status'] = 'NO_FROM';
  }
  return json_encode($info_to_return);
}

function get_all_product_types() {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "product_type ORDER BY type ASC";
  return Core\query($sql, array());
}

  function read_products() {
    
    //$handle = fopen("ftp://user:password@example.com/somefile.txt", "w");
    $handle = fopen(__ROOT__FILES__ . "csv/preciosmnd.csv", 'r');
    
    if( $handle !== FALSE ) {
      $products = array();
        
//      $category_id = 1;
        
      while ( ($data = fgetcsv($handle, 130, '|')) !== FALSE ){
        $current_row = new \stdClass();
    
        if( (count($data)) >= 6 ){
            
//          if ($category_id > 4 )
//            $category_id = 0;
            
          $current_row->PLU = utf8_encode(trim($data[0]));
          $current_row->barcode = utf8_encode(trim($data[1]));
          $current_row->name =  utf8_encode( ucfirst( strtolower( trim( str_replace('/', '-', $data[2]))) ));
        //  $current_row->category_id = utf8_encode($category_id); //WTF ?
          $current_row->presentation = utf8_encode(trim($data[3]));
          $current_row->description = utf8_encode(trim($data[3]));
          $current_row->stock = utf8_encode(trim($data[4]));
          $current_row->price = utf8_encode(trim($data[5]));
            
          $products[] = $current_row;
            
//          $category_id++;
        }
      }
      fclose( $handle );
      
      return $products;
        
    }
  }

  function read_vehicles() {
  
    //$CI->load->model('tym_vehicle_model');
    
    //$handle = fopen("ftp://user:password@example.com/somefile.txt", "w");
    $handle = fopen(__ROOT__FILES__ . "csv/Tablas_finalescsv.csv", 'r');
    
    if( $handle !== FALSE ) {
      $vehicles = array();
        
//      $category_id = 1;

      $count_aux = 0;
        
      while ( ($data = fgetcsv($handle, 150, ',')) !== FALSE  ){
        $current_row = new \stdClass();

        //var_dump($data);
        if ( ($count_aux >= 2) && (count($data) >= 5) ) {
          //die();
          $current_row->type = utf8_encode(trim($data[0]));
          $current_row->brand = utf8_encode(trim($data[1]));
          $current_row->model = utf8_encode(trim($data[2]));
          $current_row->pcd = utf8_encode(trim($data[3]));
          $current_row->year = utf8_encode(trim($data[4]));
        }
            
          $vehicles[] = $current_row;
            
//          $category_id++;
        
        $count_aux++;
      }
      fclose( $handle );
      
      return $vehicles;
        
    }
  }

  function save_vechicles( $to_save ) {

    //$CI =& get_instance();
    //$CI->load->model('tym_vehicle_model');

    $rin_types = $CI->tym_vehicle_model->get_rin_types();

    //var_dump($rin_types);

    //var_dump($to_save);

    //var_dump($this->_search_rin_types( $rin_types, $to_save ));
    $result = $CI->tym_vehicle_model->insert_vehicles( $this->_search_rin_types( $rin_types, $to_save ) );

      return $result;
  }
  
  function _search_rin_types( $rin_types, $types_and_inch ) {

    $rines = array();

    $data = $types_and_inch;

    $i =0;

    foreach ($rin_types as $key1 => $value1) {

      $current_rin = new \stdClass();

      foreach ($types_and_inch as $key2 => $value2) {
        
        if( $key2 == $value1->brand ) {
          
          $data[$value1->brand]['id'] = $value1->id;

        }
        //(var_dump($rines));
      }
    }

    return $data;
  }

function insert_product_type( $data ) {

  $product_type_to_save['table'] = "product_type";
  $product_type_to_save['column_id'] = "id";

  $product_type_to_save['type'] = $data['itemName'];

  $insert_id = Core\create($product_type_to_save, false, false);

  $completed = false;

  if( isset($insert_id) ) 
    $completed = true;

  return $completed;
  
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