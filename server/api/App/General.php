<?php
namespace App\General;

date_default_timezone_set("America/Bogota");
error_reporting(0);

require 'Db.php';
require 'email/Email.php';

use App\Db as Database;
use App\Email as Notificaciones;
$_SERVER["DB_PREX"] = isset($_SERVER["DB_PREX"]) ? $_SERVER["DB_PREX"]  : "tym";
$_SERVER["APP_NAME"] = isset($_SERVER["APP_NAME"]) ? $_SERVER["APP_NAME"] : "Syntex CMS";
$prefix = $_SERVER["DB_PREX"]."_";

/*
ERROR LIST
01 -> NO TABLA ESPECIFICADA
02 -> COLUM ID
03 -> ID FOR QUERY
04 -> NOT CREATE UPDATE
05 -> NOT UPDATE CREATE
06 -> EMAIL NOT enough DATA
ERR-MY-42S22 -> UNKON COLUM
ERR-MY-23000 -> DUPLICATE ENRY
ERR-MY-23000 -> ERROR KEY
*/

function dar_notificacion(){
  $sql = "SELECT * FROM sys_notificaciones WHERE id_user = :id AND `read` = 0";
  $row = query($sql, array("id" => $_SESSION["id_user"]));
  return json_encode($row);
}
function enviar_email_to($contenido = "", $para = array() , $from = array(),  $file = array(), $subject = "No Subject target", $json = true){
  //isset($form["email"]);
  if(count($para) > 0){
    if(!isset($from["email"]) or $from == "NA"){
      $from["email"] = $_SERVER["EMAIL_USER"];
      $from["nombre"] = "Plataforma - ".$_SERVER["APP_NAME"];
    }
    $result = Notificaciones\enviar_email_to($contenido, $para, $from, $file, $subject);
    if($result){
      $salida["response"] = true;
    } else {
      $salida["response"] = false;
      $salida["response_msj"] = $resul;
    }
    if($json) return json_encode($salida); else return $salida["response"];
  } else {
    $salida["error"] = "ERR-06";
    if($json) return json_encode($salida); else return $salida["error"];
  }
}

function test_email(){
  return Notificaciones\enviar_email_prueba();
}
function query($sql = "", $array){
  $con = Database\conectar();
  return Database\query($sql, $array, $con);
}
function conectar(){
  return Database\conectar();
}
//// CRUD FUNCTIONS
//LOG
function log_system($accion = "SIN ESPECIFICAR", $entidad = "SIN ESPECIFICAR", $id_result = 0){
  $con = Database\conectar();
  $accion = strtoupper($accion);
  $entidad = strtoupper($entidad);
  $date = date('Y-m-d H:i:s');
  $table_name = $GLOBALS["prefix"]."log";
  $sql = "INSERT INTO ".$table_name." (ID_USER,SERVER_ADDR,REMOTE_ADDR, REQUEST_TIME, DATE_ACTION, ACCTION, ENTITY, RESULT) VALUE (:ID_USER, :SERVER_ADDR, :REMOTE_ADDR, :REQUEST_TIME, :DATE_ACTION, :ACCTION, :ENTITY, :RESULT)";
  $query = $con->prepare($sql);
  $id_user = (isset($_SESSION["id"])) ? $_SESSION["id"] : $id_result ;
  $query->bindParam("ID_USER", $id_user, \PDO::PARAM_INT);
  $query->bindParam("SERVER_ADDR", $_SERVER["SERVER_ADDR"], \PDO::PARAM_INT);
  $query->bindParam("REMOTE_ADDR", $_SERVER["REMOTE_ADDR"], \PDO::PARAM_INT);
  $query->bindParam("REQUEST_TIME", date('Y-m-d H:i:s', $_SERVER["REQUEST_TIME"]), \PDO::PARAM_INT);
  $query->bindParam("DATE_ACTION", $date, \PDO::PARAM_INT);
  $query->bindParam("ACCTION", $accion, \PDO::PARAM_INT);
  $query->bindParam("ENTITY", $entidad, \PDO::PARAM_INT);
  $query->bindParam("RESULT", $id_result, \PDO::PARAM_INT);
  $query->execute();
}
// DELETE FUNTION
function delete_all($data = array(), $json = true){
  if(!isset($data["table"])) $salida["error"] = "ERR-01";
  if(!isset($data["colum_id"])) $salida["error"] = "ERR-02";
  if(!isset($data["id"])) $salida["error"] = "ERR-03";
  if(isset($salida)){
    if($json) return json_encode($salida); else return $salida["error"];
  } else {
    $con = Database\conectar();
    $table_name = $GLOBALS["prefix"].$data["table"];
    $sql = "UPDATE ".$table_name." SET estado = 0 WHERE ".$data["colum_id"]." = :id";
    $query = $con->prepare($sql);
		$query->bindParam("id", $data["id"], \PDO::PARAM_INT);
    $query->execute();
    $salida["response"] = $data["id"];
    log_system("Elimiando registro", $data["table"], $data["id"]);
    if($json) return json_encode($salida); else return $salida["response"];
  }
}

function list_one_where($data = array(), $json = true){
  if(!isset($data["table"])) $salida["error"] = "ERR-01";
  if(!isset($data["column_id"])) $salida["error"] = "ERR-02";
  if(!isset($data["id"])) $salida["error"] = "ERR-03";
  if(isset($salida)){
    if($json) return json_encode($salida); else return $salida["error"];
  } else {
    $con = Database\conectar();
    $table_name = $GLOBALS["prefix"].$data["table"];
    $sql = "SELECT * FROM ".$table_name." WHERE ".$data["column_id"]." = :id AND status = 1";
    $row = Database\query($sql, array("id" => $data["id"]), $con);
    log_system("listando todos los registros", $data["table"], $data["id"]);
    if($json) return json_encode($row); else return $row;
  }
}

function list_all($data = array(), $json = true){
  if(!isset($data["table"])) $salida["error"] = "ERR-01";
  if(isset($salida)){
    if($json) return json_encode($salida); else return $salida["error"];
  } else {
    $con = Database\conectar();
    $table_name = $GLOBALS["prefix"].$data["table"];
    $sql = "SELECT * FROM ".$table_name." WHERE status = 1";
    $row = Database\query($sql, array(), $con);
    log_system("listando todos los registros", $data["table"], 0);
    if($json) return json_encode($row); else return $row;
  }
}



function create($data,  $uppercase = true , $json = true, $debug = false){
  //echo print_r($data);
  if(!isset($data["table"])) $salida["error"] = "ERR-01";
  if(!isset($data["column_id"])) $salida["error"] = "ERR-02";
  $table_name = $GLOBALS["prefix"].$data["table"];
  unset($data["table"]);
  $id_table = $data["column_id"];
  unset($data["column_id"]);
  if(isset($data[$id_table]) and ($data[$id_table] != "0" and $data[$id_table] != "" )){
    $salida["error"] = "ERR-04";
    if($json) return json_encode($salida); else return $salida["error"];
  } else {
    //PREPARAR PARA INSERTAR
    $insert = array();
    foreach($data as $key => $value){
      if($key == "a") continue; //ACTION
      if($key == $id_table) continue; //ID NOT IN INSERT
      if (( strpos($key, "ig_") ) !== false) continue; // IGNORED ITEMS
      if($uppercase){
        //NO EMAIL NI FILES
        if($key == "email" or $key == "mail" or $key == "file" or (( strpos($key, "file") ) !== false)){
          $insert[$key] = strtolower($value);
        } else {
          $insert[$key] = strtoupper($value);
        }
      } else {
        $insert[$key] = $value;
      } // FIN PARSEO FOREACH
      $str_keys[] = $key;
      $str_values[] = ":".$key;
    }
    //SEGUIMIENTO

    // CREAR SQL FOR SAVE
    $sql = "INSERT INTO ".$table_name." (".implode(',',$str_keys).") VALUES (". implode(',', $str_values) .")";
    //EJECUTAR QUERY
    //echo $sql;

    $con = Database\conectar();
    $query = $con->prepare($sql);
    foreach($insert as $k => $v){
      //echo $k." =>". $v."<br>";
      $query->bindParam($k, $insert[$k], \PDO::PARAM_STR);
    }
    try{
      $query->execute();
      $salida[$id_table] = $con->lastInsertId();
      log_system("Registro Creado con exito", $table_name, $salida[$id_table] );
      if($json) return json_encode($salida); else return $salida[$id_table];
    } catch(\PDOException $e){
      $query->errorInfo();
      $salida["error"] = "ERR-MY-".$e->getCode();
      $salida["error-mysql"] = $e->getMessage();
      
      if($debug){
        $salida["SQL"] = $sql;
        $salida["insert"] = $insert;
      }
      if($json) return json_encode($salida); else return $salida["error"];
    }
  }
}

function update($data,  $uppercase = false , $json = true, $debug = false){
  //echo print_r($data);
  if(!isset($data["table"])) $salida["error"] = "ERR-01";
  if(!isset($data["column_id"])) $salida["error"] = "ERR-02";
  $table_name = $GLOBALS["prefix"].$data["table"];
  unset($data["table"]);
  $id_table = $data["column_id"];
  unset($data["column_id"]);
  if(isset($data[$id_table]) and ($data[$id_table] == "0" and $data[$id_table] == "" )){
    $salida["error"] = "ERR-05";
    if($json) return json_encode($salida); else return $salida["error"];
  } else {
    //PREPARAR PARA INSERTAR
    $update = array();
    foreach($data as $key => $value){
      if($key == "a") continue; //ACTION
      if($key == $id_table) {
        $update[$key] = $value;
        continue;
      } //ID NOT IN INSERT
      if (( strpos($key, "ig_") ) !== false) continue; // IGNORED ITEMS
      if($uppercase){
        //NO EMAIL NI FILES
        if($key == "email" or $key == "mail" or $key == "file" or (( strpos($key, "file") ) !== false)){
          $update[$key] = strtolower($value);
        } else {
          $update[$key] = strtoupper($value);
        }
      } else {
        $update[$key] = $value;
      } // FIN PARSEO FOREACH
      $str_update[] = $key . " = :" . $key;
    }
    //SEGUIMIENTO

    // CREAR SQL FOR SAVE
    $sql = "UPDATE " . $table_name . " SET " . @implode(", ", $str_update) . "  WHERE " . $id_table . " = :" . $id_table;

    //EJECUTAR QUERY
    $con = Database\conectar();
    $query = $con->prepare($sql);
    foreach($update as $k => $v){
      //echo $k." =>". $v."<br>";
      $query->bindParam($k, $update[$k], \PDO::PARAM_STR);
    }
    try{
      $query->execute();
      $salida[$id_table] = $data[$id_table];
      log_system("Registro Actualizado con exito", $table_name, $salida[$id_table] );
      if($json) return json_encode($salida); else return $salida[$id_table];
    } catch(\PDOException $e){
      $query->errorInfo();
      $salida["error"] = "ERR-MY-".$e->getCode();
      $salida["error-mysql"] = $e->getMessage();
      if($debug){
        $salida["SQL"] = $sql;
        $salida["insert"] = $insert;
      }
      if($json) return json_encode($salida); else return $salida["error"];
    }
  }
}

function login( $id = "", $pass = "", $json = false, $debug = false, $email = false, $is_admin = false ){
  $con = conectar();

  if($id == "" || $pass == ""){
    $salida["error"] = "ERR-USER-01"; //NO DATA
    if($json) return json_encode($salida); else return $salida["error"];
  } else {

    if( $is_admin ) {
      $table_name = $GLOBALS["prefix"]."user_admin";
      $user_colum = "identification";
    }else {
      $table_name = $GLOBALS["prefix"]."user";
      $user_colum = "email";
    }

    $sql = "SELECT " . $table_name .".*".
      " FROM ".$table_name.
      " WHERE ". $table_name. "." .$user_colum." = :id AND status = 1";

    $user = query($sql, array("id" => $id), $con);
    
    if( count($user) == 1 ){
      $salida["user"] = true;
      $user[0]["pass"] = $user[0]["password"];
      $pass_hash = $user[0]["pass"];
      // VALIDAR HASHED PASS
      //echo $pass;
      //echo "<br>";
      //echo $user[0]["pass"];

      if ( $pass_hash === crypt( $pass , $pass_hash ) ){
        $salida["pass"] = true;
        $salida["response"] = true;
        unset($user[0]["password"]);
        unset($user[0]["pass"]);

        $salida["info"] = $user[0];
        
        //SESSION START
        $last_login = date("Y/m/d H:i:s", $_SERVER["REQUEST_TIME"]);

        $update_data["table"] = $table_name;
        $update_data["column_id"] = "id";
        $update_data["id"] = $user[0]["id"];
        $update_data["last_login"] = $last_login;

        update($update_data);

        log_system("Inicio de sesion con exito", $table_name, $user[0]["id"]);
      } else {
        $salida["pass"] = false;
        $salida["response"] = false;
      }
    } else {
      $salida["user"] = false;
      $salida["response"] = false;
    }

    if($json) return json_encode($salida); else return $salida;
  }
}

function logout(){
  log_system("Salida de sesion correcta", "USUARIOS", 0);
  session_start();
  unset($_SESSION);
  session_destroy();
}




function new_account($data = array() , $json = true, $email = true, $debug = true, $confirma = false, $auto_confirma = false ){
  if(count($data) > 0){
    //SI NO HAY PASS ERROR
    if(isset($data["pass"])){
      //HASH PASS
      $pass = $data["pass"];
      $data["pass"] = crypt($data["pass"]);
      $data["table"] = "usuarios";
      $data["colum_id"] = "id_user";
      if($confirma){
        $data["ingresa"] = "NO";
        $data["confirmacion"] = md5($data["email"]);
      }
      $id_user = create($data, false,false,false);
      if (  $id_user > 0 ){
        if($email){
          $from["email"] = $_SERVER["EMAIL_USER"];
          $from["nombre"] = "Plataforma - ".$_SERVER["APP_NAME"];
          //ENVIAR INFORMACION DE EMAIL
          if($confirma){
              if($auto_confirma){
                //ENVIAR UN SOLO EMAIL
                $contenido = '<div style="font-size:16px;">
                  <span>Hola '.$data["nombre"].' '.$data["apellido"].'</span><br><br>
                  <span>Ya tienes una cuenta en <strong>'.$_SERVER["APP_NAME"].'</strong> para continuar con tu proceso de registro debes confirmar este email.</span><br>
                  <span>Da click y podras empezar a utilizar nuestra plataforma <a href="http://'.$_SERVER["HTTP_HOST"].'/confirma?key='.$data["confirmacion"].'">Confirmar</a><br>
                </div>';
                //INFOR CORREO
                $para[0]["email"] = $data["email"];
                $para[0]["nombre"] = $data["nombre"]." ".$data["apellido"];
                $file = array();
                $from = "";
                $sujeto = "Nueva cuenta plataforma ".$_SERVER["APP_NAME"]." para ".$data["email"]. " - ".date("Y-m-d");
                return enviar_email_to($contenido, $para, $from , $file, $sujeto);
              } else{
                //ENVIAR DOS EMAIL
                $contenido1 = '<div style="font-size:16px;">
                  <span>Hola '.$data["nombre"].' '.$data["apellido"].'</span><br><br>
                  <span>Ya tienes una cuenta en <strong>'.$_SERVER["APP_NAME"].'</strong> debes esperar que el Administrador confirme tu correo para continuar.</span><br><br>
                </div>';
                //INFOR CORREO
                $para[0]["email"] = $data["email"];
                $para[0]["nombre"] = $data["nombre"]." ".$data["apellido"];
                $file = array();
                $sujeto = "Nueva cuenta plataforma ".$_SERVER["APP_NAME"]." para ".$data["email"]. " - ".date("Y-m-d");
                $a = enviar_email_to($contenido1, $para, $from , $file, $sujeto);


                $contenido2 = '<div style="font-size:16px;">
                  <span>Hola Administrador</span><br><br>
                  <span>Tenemos una cuenta registrada en nuestra plataforma  <strong>'.$_SERVER["APP_NAME"].'</strong> </span><br>
                  <h2 style="color:#666;font-size:20px;">Informacion Usuario</h2>
                  <table style="border-collapse:collapse;border-left: 8px solid #46a;font-size:13px;color:#888">
                    <tr style="border-bottom:1px solid #eee;padding:8px 12px;">
                      <td style="padding:8px 16px;">Nombre : </td>
                      <td style="padding:8px 16px;color:#333;">'.$data["nombre"].' '.$data["apellido"].'</td>
                    </tr>
                    <tr style="border-bottom:1px solid #eee;padding:8px 12px;">
                      <td style="padding:8px 16px;">Email : </td>
                      <td style="padding:8px 16px;color:#333;">'.$data["email"].'</td>
                    </tr>

                  </table><br>
                  <span>Da click para confirmar este usuario <a href="http://'.$_SERVER["HTTP_HOST"].'/confirma?key='.$data["confirmacion"].'">Confirmar</a><br><br>
                </div>';
                //INFOR CORREO
                $para[0]["email"] = $_SERVER["APP_ADMIN_EMAIL"];
                $para[0]["nombre"] = $_SERVER["APP_ADMIN_NAME"];
                $file = array();
                $sujeto = "Nueva cuenta plataforma ".$_SERVER["APP_NAME"]." para ".$data["email"]. " - ".date("Y-m-d");
                return enviar_email_to($contenido2, $para, $from , $file, $sujeto);
              }
          } else {
              $contenido = '<div style="font-size:16px;">
                <span>Hola '.$data["nombre"].' '.$data["apellido"].'</span><br><br>
                <span>Cuenta creada con exito en la plataforma <strong>'.$_SERVER["APP_NAME"].'</strong> ya puedes iniciar sesion tu usuario es tu <b>email</b> y la contraseña es <b>'.$pass.'</b>, recuerda cambiar tu contraseña editando el perfil. <br> el link para iniciar es <a href="http://'.$_SERVER["HTTP_HOST"].'">http://'.$_SERVER["HTTP_HOST"].'</a></span><br><br>
              </div>';
              //INFOR CORREO
              $para[0]["email"] = $data["email"];
              $para[0]["nombre"] =  $data["nombre"]." ".$data["apellido"];
              $file = array();
              $sujeto = "Nueva cuenta plataforma ".$_SERVER["APP_NAME"]." para ".$data["email"]. " - ".date("Y-m-d");

              enviar_email_to($contenido, $para, $from , $file, $sujeto);
              $salida["id_user"] = $id_user;
              if($json) return json_encode($salida); else return $salida["id_user"];
          }
        } else {
          $salida["id_user"] = $id_user;
          if($json) return json_encode($salida); else return $salida["id_user"];
        }
      } else {
        if($debug){
          $salida["error-debug"] = $id_user;
        }
        $salida["error"] = "ERR-USER-03"; //CAN NOT CREATE USER
        if($json) return json_encode($salida); else return $salida["error"];
      }
    } else {
      $salida["error"] = "ERR-USER-02"; //NO DATA PASS
      if($json) return json_encode($salida); else return $salida["error"];
    }
  } else {
    $salida["error"] = "ERR-USER-01"; //NO DATA
    if($json) return json_encode($salida); else return $salida["error"];
  }
}





function recordar_pass(){

}

function confirmar_pass(){

}

function confirmar($key = "", $json = true){
  if($key == ""){
    $salida["response"] = false; //NO KEY
    if($json) return json_encode($salida); else return $salida;
  } else {
    //CONSULTAR ID
    $row = query("SELECT * FROM ing_usuarios WHERE confirmacion = :key", array("key" => $key));
    if(count($row) > 0){
      if($row[0]["ingresa"] == "SI"){
          $salida["response"] = false; //NO USER
          if($json) return json_encode($salida); else return $salida;
      } else {
        //UPDATE USER AND RETURN DATA;
        $salida["response"] = true;
        $salida["info"] = $row[0];
        $user["table"] = "usuarios";
        $user["colum_id"] = "id_user";
        $user["id_user"] = $row[0]["id_user"];
        $user["ingresa"] = "SI";
        update($user); //UPDATE USER
        //EMAIL TO USER
        $contenido = '<div style="font-size:16px;">
          <span>Hola '.$row[0]["nombre"].' '.$row[0]["apellido"].'</span><br><br>
          <span>Cuenta confirmada con exito ya puedes ingresar a la plataforma </span><br><br>
        </div>';
        //INFOR CORREO
        $para[0]["email"] = $row[0]["email"];
        $para[0]["nombre"] =  $row[0]["nombre"]." ".$row[0]["apellido"];
        $file = array();
        $sujeto = "Cuenta confirmada - ".$_SERVER["APP_NAME"]." para ".$row[0]["email"]. " - ".date("Y-m-d H:i:s");
        return enviar_email_to($contenido, $para, $from , $file, $sujeto);

        if($json) return json_encode($salida); else return $salida;
      }
    } else {
      $salida["response"] = false; //NO USER
      if($json) return json_encode($salida); else return $salida;
    }
  }
}

function update_parametros($tipo = "sexo", $otro = false ){
  $tipo = strtolower($tipo);
  $table_name = $GLOBALS["prefix"]."parametros";
  $file = '../../media/parametros/'.$tipo.".txt";
    //CREAR ARCHIVO
    // SOLO CREAR
    $sql = "SELECT * FROM ".$table_name." WHERE tipo_parametro = :tipo AND estado = 1";
    $row = query($sql, array("tipo" => strtoupper($tipo)));
    if(count($row) > 0){
      //FILE CON TODOS
      $content[] = '<option value="">--SELECCIONE--</option>';
      foreach($row as $key => $value){
        $content[] = '<option value="'.$value["id_parametro"].'">'.ucfirst(strtolower($value["nombre_parametro"])).'</option>';
      }
    } else {
      //FILE SOLO SELECCIONE o OTROS DEPENDE DE ARGUMNESTOS
      $content[] = '<option value="">--SELECCIONE--</option>';
    }
    if($otro){
      $content[] = '<option value="0">OTRO</option>';
    }
    //echo print_r($content);
    file_put_contents($file, @implode("", $content));
}
?>
