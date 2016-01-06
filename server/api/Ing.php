<?php
namespace App\Ing;

session_start();
date_default_timezone_set("America/Bogota");

require 'App/General.php';
//require '../../recursos/mail/Mandrill_lib.php';

Use App\General as Core;

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

  foreach($data as $nombre => $valor){
    if($nombre == 'password' || $nombre == 'confirmacion') continue;
    $_SESSION[$nombre] = $valor;
  }

}


function login( $id, $pass, $is_admin ){

  $is_json = true;
  $resultado = Core\login( $id,$pass, $is_json, false, false, $is_admin  );
  
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

          case 'home':
            switch ( $data['action'] ) {
              case 'load_vehicles':
                  $info_to_return['vehicles'] = get_all_vehicles();
                  $info_to_return['status'] = "VEHICLES_LOADED";
                break;
              case 'get_models_by_brand':

                  $info_to_return['models'] = get_models_by_brand( $data['brandId']);
                  $info_to_return['status'] = "VEHICLE_MODELS_LOADED";
                break;
              case 'get_products':
                  $info_to_return['rin_types'] = get_rines( $data['vehicleId'], $data['modelId'] );
                  $info_to_return['tires'] = get_tires( $data['vehicleId'], $data['modelId'] );
                  $info_to_return['status'] = "PRODUCTS_LOADED";
                break;
              default:
                # code...
                break;
            }
            break;
        }

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

function get_rines( $vehicle_id, $model_id ) {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model_has_tym_rin vhr"
  ." LEFT JOIN ".$GLOBALS["prefix"]. "rin r ON r.id = vhr.tym_rin_id "
  ." WHERE vhr.tym_vehicle_model_id = ".$model_id." AND vhr.tym_vehicle_model_tym_vehicle_id = ".$vehicle_id;
  return Core\query($sql, array());
}

function get_tires( $vehicle_id, $model_id ) {
  $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model_has_tym_tire vht"
  ." LEFT JOIN ".$GLOBALS["prefix"]. "tire t ON t.id = vht.tym_tire_id "
  ." WHERE vht.tym_vehicle_model_id = ".$model_id." AND vht.tym_vehicle_model_tym_vehicle_id = ".$vehicle_id;
  return Core\query($sql, array());
}

function get_all_collect_request_by_client_id( $client_id, $ids_data = NULL, $associate = false, $driver_id = NULL ) {

  $data['implodedTables'] = array(  'waste',//0 
                                    'waste_type', //1
                                    'unit_of_measure', //2
                                    'packaging_type', //3
                                    'client_address', //4
                                    'client', //5
                                    'scheduled_collect_request', //6
                                    'vehicle', //7
                                    'remission' //8
                                  );
  $data['table'] = $GLOBALS["prefix"]."collect_request";
  $data['client_id'] = $client_id;
  $data['explodedTables'] = $data['implodedTables'];
  $where_statement = " WHERE ";

  $join_plus = "LEFT JOIN ".$GLOBALS["prefix"].$data['explodedTables'][6]. " sch ON sch.id = ".$GLOBALS["prefix"].$data['explodedTables'][0].".schedule_id"
    ." LEFT JOIN ".$GLOBALS["prefix"].$data['explodedTables'][7]. " ve ON ve.id = sch.vehicle_id ";

  if ( $data['client_id'] == "full" ) {

    $where = '';

    $where = _add_where_by_collect_request_ids( $data['table'], $where , $ids_data->collect_request_status_ids );
    $where = _add_where_by_waste_ids( $GLOBALS["prefix"].$data['explodedTables'][0], $where , $ids_data->waste_collect_status_ids );

    if ( isset($driver_id) && is_numeric($driver_id) ){
      $where .= " AND ve.driver_id = ". $driver_id;
    }else {
       if( $driver_id == "all" )
         $where .= " AND ve.driver_id > 0 ";
    }

    $where = $join_plus.$where_statement.$where;
    // $where = $where_statement.$where;
    
  }else {
    $where = $where_statement.$data['table'].".client_id = ".$data['client_id'] . " AND ";

    $where = _add_where_by_collect_request_ids( $data['table'], $where , $ids_data->collect_request_status_ids );

    $where = _add_where_by_waste_ids( $GLOBALS["prefix"].$data['explodedTables'][0], $where , $ids_data->waste_collect_status_ids );

    $where = $join_plus.$where;

  }

  $select = "SELECT " . $data['table'] . ".* ,"
      .$GLOBALS["prefix"].$data['explodedTables'][0].".id AS ". $data['explodedTables'][0]."_id, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".collect_request_id, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".waste_type_id, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".unit_of_measure_id, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".quantity, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".packaging_type_id, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".collect_status_id, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".collect_date, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".schedule_id, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".API, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".conversion_factor, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".sediment, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".humidity, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".verified_quantity, "
      .$GLOBALS["prefix"].$data['explodedTables'][0].".remission_id, "
      ."p.type, um.unit, e.packing, a.address_line1, a.person_in_charge, c.name as client_name, c.identification, c.transport_company, c.main_address, c.email ";
  //echo $where;
  // if ( $data['client_id'] == "full" ) {
    $select .= ", sch.id AS sch_id, sch.vehicle_id, sch.date AS sch_date, sch.assigned_number, ve.plate, ve.driver_id";
  // }

  $sql = $select
      ." FROM ". $data['table']
      ." LEFT JOIN ". $GLOBALS["prefix"].$data['explodedTables'][0]." ON ".$GLOBALS["prefix"].$data['explodedTables'][0].".collect_request_id = ".$data['table'] .".id "
      ." LEFT JOIN ". $GLOBALS["prefix"].$data['explodedTables'][1]." p ON p.id = " .$GLOBALS["prefix"].$data['explodedTables'][0].".waste_type_id "
      ." LEFT JOIN ". $GLOBALS["prefix"].$data['explodedTables'][2]." um ON um.id = " .$GLOBALS["prefix"].$data['explodedTables'][0].".unit_of_measure_id "
      ." LEFT JOIN ". $GLOBALS["prefix"].$data['explodedTables'][3]." e ON e.id = " .$GLOBALS["prefix"].$data['explodedTables'][0].".packaging_type_id "
      ." JOIN ". $GLOBALS["prefix"].$data['explodedTables'][4]." a ON a.id = " . $data['table'].".pickup_client_address_id "
      ." LEFT JOIN ".$GLOBALS["prefix"].$data['explodedTables'][5]. " c ON c.id = ". $data['table'].".client_id "
      . $where . " AND ".$GLOBALS["prefix"].$data['explodedTables'][0].".status = 1"." ORDER BY ".$data['table'].".request_date DESC";

      $result = Core\query($sql, array());

      $collect_requests = $result;

      if ( $associate ) {
        $collect_requests = associate_wastes( $result );
      }

      //die(print_r($collect_requests));

      return $collect_requests;

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

/* CARTECRUDO */

function create_remission( $data ) {

  $result = new \stdClass();

  $remission_to_save = array();

  $remission_to_save['table'] = "remission";
  $remission_to_save['column_id'] = "id";
  $remission_to_save['collect_request_id'] = $data['collectRequestId'];

  $insert_id = (Core\create($remission_to_save, false, false));

  if( isset($insert_id) && is_numeric($insert_id) ){
    //add transaction
    foreach ($data['wastes'] as $key => $waste) {
      $waste_to_update['table'] = "waste";
      $waste_to_update['column_id'] = "id";
      $waste_to_update['id'] = $waste['id'];
      $waste_to_update['remission_id'] = $insert_id;

      $updated_id = Core\update($waste_to_update, false, false);
    }

    $result->status = 'REMISSION_CREATED';
    $result->remission_id = $insert_id;
  }else
    $result->status = 'RETRY';

  return json_encode($result);

}


function create_schedule_collect_request ( $data ) {
  //var_dump($data);
  $result = new \stdClass();
  $ids_data = new \stdClass();

  if( $data['type'] == "new_schedule_collect_request" ) {

    $schedule_collect_request_to_save['table'] = "scheduled_collect_request";
    $schedule_collect_request_to_save['column_id'] = "id";
    $schedule_collect_request_to_save['date'] = date('Y-m-d', strtotime($data['scheduleToSend']['date']));
    $schedule_collect_request_to_save['vehicle_id'] = $data['scheduleToSend']['vehicle']['vehicle_id'];


    $wastes = $data['scheduleToSend']['wastesData'];

    foreach ( $wastes as $key => $waste ) {
      $schedule_collect_request_to_save['waste_id'] = $waste['waste_id'];
      $schedule_collect_request_to_save['assigned_number'] = $waste['assigned_number']['value'];


      $schedule_insert_id = (Core\create($schedule_collect_request_to_save, false, false));

      $waste_to_update['table'] = "waste";
      $waste_to_update['column_id'] = "id";
      $waste_to_update['id'] = $waste['waste_id'];
      $waste_to_update['collect_status_id'] = 2;
      $waste_to_update['schedule_id'] = $schedule_insert_id;

      $insert_id = Core\update($waste_to_update, false, false);

      $collect_request_to_update['table'] = "collect_request";
      $collect_request_to_update['column_id'] = "id";
      $collect_request_to_update['id'] = $waste['collect_request_id'];
      $collect_request_to_update['status_id'] = 2;

      $insert_id = Core\update($collect_request_to_update, false, false);


    }
    if( isset($insert_id) && is_numeric($insert_id) ) {
       $result->status = "CREATED";
    }
  }

  if( $data['type'] == "update_schedule_collect_request" ) {

    $schedule_collect_request_to_update['table'] = "scheduled_collect_request";
    $schedule_collect_request_to_update['column_id'] = "id";
    $schedule_collect_request_to_update['date'] = date('Y-m-d', strtotime($data['scheduleToSend']['date']));
    $schedule_collect_request_to_update['vehicle_id'] = $data['scheduleToSend']['vehicle']['vehicle_id'];

    $insert_id = NULL;
    $wastes = $data['scheduleToSend']['wastesData'];

    foreach ( $wastes as $key => $waste ) {
      $schedule_collect_request_to_update['id'] = $waste['sch_id'];
      $schedule_collect_request_to_update['waste_id'] = $waste['waste_id'];
      $schedule_collect_request_to_update['assigned_number'] = $waste['assigned_number']['value'];

      (Core\update($schedule_collect_request_to_update));

    }
    
     $result->status = "SCHEDULE_UPDATED";

  }

  if( $data['type'] == "unassigning_schedule_collect_request" ) {

    $schedule_collect_request_to_update['table'] = "scheduled_collect_request";
    $schedule_collect_request_to_update['column_id'] = "id";

    $waste = $data['scheduleToSend']['wastesData'];

    $schedule_collect_request_to_update['id'] = $waste['sch_id'];
    $schedule_collect_request_to_update['status'] = 0;

    (Core\update($schedule_collect_request_to_update));

    $waste_to_update['table'] = "waste";
    $waste_to_update['column_id'] = "id";
    $waste_to_update['id'] = $waste['waste_id'];
    $waste_to_update['collect_status_id'] = 1;
    $waste_to_update['schedule_id'] = NULL;

    (Core\update($waste_to_update));

    $result->status = "SCHEDULED_WASTE_COLLECT_REQUEST_DELETED";

  }

  $ids_data->collect_request_status_ids = array('1', '2', '3', '4');
  $ids_data->waste_collect_status_ids = array('1', '2');

  $result->updated_collect_request = get_all_collect_request_by_client_id( 'full', $ids_data );

  return json_encode($result);
  

}

function create_collect_request( $data ) {
   // echo 'Hi!!!';
    
    if ( $data['type'] == 'new_collect_request' ) {
      $collect_request_to_save['table'] = "collect_request";
      $collect_request_to_save['column_id'] = "id";

      $collect_request_to_save['request_date'] = date('Y-m-d H:i:s', $_SERVER["REQUEST_TIME"]);
      $collect_request_to_save['pickup_client_address_id'] = $data['addressLine1']['id'];
      //$collect_request_to_save['user_id'] = $data['userId'];
      $collect_request_to_save['client_id'] = $data['clientId'];
      $collect_request_to_save['status_id'] = 1;

      $last_collect_request = get_last_collect_request_record( $collect_request_to_save );

      if ( isset($last_collect_request) ) {
        $new_pickup_number = str_replace('REC', '', $last_collect_request['pickup_number']);
        $collect_request_to_save['pickup_number'] = 'REC000' . ($new_pickup_number + 1);
      }else {
        $collect_request_to_save['pickup_number'] = 'REC0001';
      }

      //print_r($collect_request_to_save);
      $collect_request_created = false;
      $insert_id = (Core\create($collect_request_to_save, false, false));

      if( isset($insert_id) && is_numeric($insert_id) )
        $collect_request_created = true;
    }
    //var_dump($insert_id);

    $result = new \stdClass();
    $ids_data = new \stdClass();

    if ( $data['type'] == 'new_waste' ){
      $insert_id = $data['collectRequestId'];
      $result->status = 'WASTE_CREATED';
      $is_new_waste = true;
    }

    if ( $collect_request_created || $is_new_waste ) {

      if ( $data['multipleWastes'] ){

        //var_dump($data['waste']);
        $wastes = $data['waste'];
        
        foreach ( $wastes as $key => $waste ) {
          
          $waste_to_save['table'] = "waste";
          $waste_to_save['column_id'] = "id";

          $waste_to_save['collect_request_id'] = $insert_id;
          $waste_to_save['waste_type_id'] = $waste['wasteType']['id'];
          $waste_to_save['unit_of_measure_id'] = $waste['unit']['id'];
          $waste_to_save['quantity'] = $waste['quantity'];
          $waste_to_save['packaging_type_id'] = $waste['packing']['id'];
          $waste_to_save['collect_status_id'] = '1';

          (Core\create($waste_to_save, false, false));
          //usleep(250000);
        }
        
      }else {
        $waste_to_save['table'] = "waste";
        $waste_to_save['column_id'] = "id";

        $waste_to_save['collect_request_id'] = $insert_id;
        $waste_to_save['waste_type_id'] = $data['waste']['wasteType']['id'];
        $waste_to_save['unit_of_measure_id'] = $data['waste']['unit']['id'];
        $waste_to_save['quantity'] = $data['waste']['quantity'];
        $waste_to_save['packaging_type_id'] = $data['waste']['packing']['id'];
        $waste_to_save['collect_status_id'] = '1';

        if( $data['isAssigned'] ){

          $waste_to_save['collect_request_id'] = $data['collectRequestId'];
          $waste_to_save['collect_status_id'] = '2';

        }

        $waste_created = false;
        $waste_insert_id = (Core\create($waste_to_save, false, false));

        if ( isset($waste_insert_id) && is_numeric($waste_insert_id) )
          $waste_created = true;


        if( $data['isAssigned'] && $waste_created ){

          //create a waste scheduled
          $waste_scheduled['table'] =  'scheduled_collect_request';
          $waste_scheduled['column_id'] = "id";
          $waste_scheduled['waste_id'] = $waste_insert_id;
          $waste_scheduled['vehicle_id'] = $data['vehicleId'];
          $waste_scheduled['date'] = $data['schDate'];

          $sch_insert_id = (Core\create($waste_scheduled, false, false));

          $waste_to_update['table'] = "waste";
          $waste_to_update['column_id'] = "id";
          $waste_to_update['id'] = $waste_insert_id;

          $waste_to_update['schedule_id'] = $sch_insert_id;

          $insert_id = (Core\update($waste_to_update, false, false));
          
        }

      }

      if ( $data['type'] == 'new_collect_request' ){
        $result->status = 'CREATED';
      }

      // if ( $data['profile'] == "weighing_machine" ){
      //   $collect_status_ids = array('1', '2');
      //   get_all_collect_request_by_client_id( "full", $collect_request_status_ids, true, "all" );
      //   search_drivers_info( $result->updated_collect_request );
        
      // }

      if ( $data['profile'] == "collector" ){
        $ids_data->collect_request_status_ids = array('2', '3', '4');
        $ids_data->waste_collect_status_ids = array('2');

        $result->updated_collect_request = get_all_collect_request_by_client_id( 'full', $ids_data, true, $data['driver_id'] );
      }else{
        $ids_data->collect_request_status_ids = array('1', '2', '3', '4');
        $ids_data->waste_collect_status_ids = array('1', '2', '3');
        $result->updated_collect_request = get_all_collect_request_by_client_id( $data['clientId'], $ids_data, true );
      }
        
      return json_encode($result);

    }else {
       if ( $data['type'] == 'edit_waste' ){
          $waste_to_save['table'] = "waste";
          $waste_to_save['column_id'] = "id";

          $waste_to_save['id'] = $data['waste']['id'];
          $waste_to_save['waste_type_id'] = $data['waste']['wasteType']['id'];
          $waste_to_save['unit_of_measure_id'] = $data['waste']['unit']['id'];
          $waste_to_save['quantity'] = $data['waste']['quantity'];
          $waste_to_save['packaging_type_id'] = $data['waste']['packing']['id'];


          if( $data['waste']['conversionFactor'] )
              $waste_to_save['conversion_factor'] = $data['waste']['conversionFactor'];

          if( $data['waste']['sediment'] )
              $waste_to_save['sediment'] = $data['waste']['sediment'];

          if( $data['waste']['api'] )
              $waste_to_save['API'] = $data['waste']['api'];

          if( $data['waste']['humidity'] )
              $waste_to_save['humidity'] = $data['waste']['humidity'];

          if( $data['waste']['verifiedQuantity'] )
              $waste_to_save['verified_quantity'] = $data['waste']['verifiedQuantity'];

          $insert_id = Core\update($waste_to_save, false, false);

          if ( is_numeric($insert_id) ){
            $result->status = 'WASTE_UPDATED';

              if ( $data['profile'] == "collector" ){
                $ids_data->collect_request_status_ids = array('2', '3', '4');
                $ids_data->waste_collect_status_ids = array('2', '3');
                $result->updated_collect_request = get_all_collect_request_by_client_id( 'full', $ids_data, true, $data['driver_id'] );
              }else{
                if ( $data['profile'] == "weighing_machine" ){
                    $ids_data->collect_request_status_ids = array('2','3','4');
                    $ids_data->waste_collect_status_ids = array('3');
                    
                    $updated_requests['response'] = get_all_collect_request_by_client_id( "full", $ids_data, true, "all" );
                    search_drivers_info( $updated_requests['response'] );
                    $result->updated_collect_request  = $updated_requests['response'];
                    
                  }else{
                    $ids_data->collect_request_status_ids = array('1', '2', '3', '4');
                    $ids_data->waste_collect_status_ids = array('1', '2', '3');

                    $result->updated_collect_request = get_all_collect_request_by_client_id( $data['clientId'], $ids_data, true );    
                  }
                
              }

          }else {
            $result->status = 'RETRY';
          }

          return json_encode($result);
       }

       if ( $data['type'] == 'confirm_waste' ) {
          $waste_to_update['table'] = "waste";
          $waste_to_update['column_id'] = "id";

          $waste_to_update['id'] = $data['id'];


          if( $data['profile'] == "collector" ) {
            $waste_to_update['collect_status_id'] = 3; //collected
            $waste_to_update['collect_date'] = date('Y-m-d H:i:s', $_SERVER["REQUEST_TIME"]); //collected
          }

          if( $data['profile'] == "weighing_machine" )
            $waste_to_update['collect_status_id'] = 4; //confirmed

          $insert_id = Core\update($waste_to_update, false, false);

          if ( is_numeric($insert_id) ){
            $result->status = 'WASTE_CONFIRMED';

            if ( $data['profile'] == "collector" ){
                $ids_data->collect_request_status_ids = array('2', '3', '4');
                $ids_data->waste_collect_status_ids = array('2','3');
                $result->updated_collect_request = get_all_collect_request_by_client_id( 'full', $ids_data, true, $data['driver_id'] );
            }else{
              if ( $data['profile'] == "weighing_machine" ){
                
                  $ids_data->collect_request_status_ids = array('3');
                  $ids_data->waste_collect_status_ids = array('3');
                  
                  $updated_requests['response'] = get_all_collect_request_by_client_id( "full", $ids_data, true, "all" );
                  search_drivers_info( $updated_requests['response'] );
                  $result->updated_collect_request  = $updated_requests['response'];
                  
                }
              
            }
           
          }else {
            $result->status = 'RETRY';
          }
          return json_encode($result);
       }

    }

    if ( $data['type'] == 'delete_collect_request' ) {

        $callect_request_to_update['table'] = "collect_request";
        $callect_request_to_update['column_id'] = "id";

        $callect_request_to_update['id'] = $data['id'];
        $callect_request_to_update['status_id'] = 6;// deleted status = 6

        $insert_id = Core\update($callect_request_to_update, false, false);

        if ( is_numeric($insert_id) ){
          $result->status = 'COLLECT_REQUEST_DELETED';
          $ids_data->collect_request_status_ids = array('1', '2', '3', '4');
          $ids_data->waste_collect_status_ids = array('1', '2', '3');
          $result->updated_collect_request = get_all_collect_request_by_client_id( $data['clientId'], $ids_data, true );          
        }else {
          $result->status = 'RETRY';
        }

        return json_encode($result);
    }
    
    if ( $data['type'] == 'delete_waste' ) {

        $callect_request_to_update['table'] = "waste";
        $callect_request_to_update['column_id'] = "id";

        $callect_request_to_update['id'] = $data['id'];
        $callect_request_to_update['status'] = 0;// deleted status = 0

        $insert_id = Core\update($callect_request_to_update, false, false);
        

        if ( is_numeric($insert_id) ){
          $result->status = 'WASTE_DELETED';
          $ids_data->collect_request_status_ids = array('1', '2', '3', '4');
          $ids_data->waste_collect_status_ids = array('1', '2', '3');
          $result->updated_collect_request = get_all_collect_request_by_client_id( $data['clientId'], $ids_data, true );          
        }else{
          $result->status = 'RETRY';
        }

        return json_encode($result);
    }
    
}



function get_last_collect_request_record( $data ) {
  $sql = "SELECT cr.request_date, cr.pickup_number FROM ".$GLOBALS["prefix"].$data['table']." cr WHERE cr.client_id = " .$data['client_id'] . " ORDER BY cr.request_date DESC";
  $result = Core\query($sql, array());

  if ( count($result) > 0 )
    return $result[0];

  else return NULL;
}

function add_vehicle_extra_info( $data ) {

  $result = new \stdClass();
  $insert_ids = array();

  foreach ( $data['wastes'] as $key => $waste ) {

    $vehicle_extra_info['table'] =  'vehicle_weight';
    $vehicle_extra_info['column_id'] = "id";
    $vehicle_extra_info['vehicle_id'] = $data['vehicleId'];
    $vehicle_extra_info['weighing_machine_person_id'] = $data['userId'];
    $vehicle_extra_info['collect_request_id'] = $data['collectRequestId'];
    $vehicle_extra_info['waste_id'] = $waste['id'];
    $vehicle_extra_info['empty'] = $data['vehicleExtraInfo']['empty'];
    $vehicle_extra_info['full'] = $data['vehicleExtraInfo']['full'];
    $vehicle_extra_info['vehicle_weight_unit_id'] = $data['vehicleExtraInfo']['unitId'];
    $vehicle_extra_info['date'] = date('Y-m-d H:i:s', $_SERVER["REQUEST_TIME"]);

    $current_insert_id = (Core\create($vehicle_extra_info, false, false));

    $insert_ids[] = $current_insert_id;
  }

  if( count($data['wastes']) == count($insert_ids) ){
    $result->status = "SUCCESS";
  }else {
    $result->status = "NO_COMPLETED";
  }

  return json_encode($result);

}

function cliente($data){
  $data["table"] = "cliente";
  $data["colum_id"] = "id_cliente";
  if($data[$data["colum_id"]] == ""){
    return Core\create($data);
  } else {
    return Core\update($data);
  }
}

function cliente_contacto($data){
  $data["table"] = "cliente_contacto";
  $data["colum_id"] = "id_contacto";
  if($data[$data["colum_id"]] == ""){
    return Core\create($data);
  } else {
    return Core\update($data);
  }
}

function usuarios_new($data){
  $data["table"] = "usuarios";
  $data["colum_id"] = "id_user";
  if($data["pass"] != ""){
    $data["pass"] = crypt($data["pass"]);
  } else {
    unset($data["pass"]);
  }
  if($data[$data["colum_id"]] == ""){
    return Core\create($data, false,false);
  } else {
    return Core\update($data, false,false);
  }

}
function send_informe_accidentalidad(){
  $contenido = "<h1>Informe de accidentalidad</h1><br><br><p><img src='http://eventos.center/media/graficas/meta.png'  style='width:100%'></p><br><p><img style='width:100%' src='http://eventos.center/media/graficas/anios.png'></p>";
  $contenido .= "<table cellspacing='0' cellpadding='0' border='1'  style='width:100%'><tr><td>#Accidente</td><td>Nombre</td><td>Evento</td></tr> <br> <a href=''>Descargar Excel</a>";
  $sql = "SELECT id_notificacion, descripcion_hecho, incapacidad, dias_incapacidad, car_empleado.nombre_empleado FROM car_acc_notificacion, car_empleado WHERE car_empleado.cedula = car_acc_notificacion.documento AND anio = 2015";
  $row = Core\query($sql, array());
  foreach ($row as $key => $value) {
    $contenido .= "<tr><td>".$value["id_notificacion"]."</td><td>".$value["nombre_empleado"]."</td><td>".$value["descripcion_hecho"]."</td><tr>";
    # code...
  }
  $contenido .= "<table>";
  $para[0]["nombre"] = "michael Rojas";
  $para[0]["email"] = "michaelrojas@progracol.com";
  $para[1]["nombre"] = "Ingrid Martin";
  $para[1]["email"] = "imartin@varacolenergy.com";
  $from["nombre"] = "Ingrid Martin";
  $from["email"] = "imartin@varacolenergy.com";
  $subject = "Informe accidentalidad ".date("Y-m-d");
  return Core\enviar_email_to($contenido, $para , $from , array(), $subject, $json = true);
}

  function send_remission( $post ) {
    //var_dump($post);
    // $contenido= "Hi!!";
    // $to[0]["nombre"] = "Adrian Romero";
    // $to[0]["email"] = $post['email'];
    // $from["nombre"] = "Tester";
    // $from["email"] = "testr234123@gmail.com";
    // $subject = "Test Email ".date("Y-m-d");
    // return Core\enviar_email_to($contenido, $to , $from , array(), $subject, $json = true);
    $remission_data = $_SESSION['file_to_send_data'];
    $result = new \stdClass();

    if ( isset($remission_data) ) {

      $attach = new \stdClass();
      
      $fichero = file_get_contents('../../media/pdf/remision_' . $remission_data['remission_number'] . $remission_data['timestamp'] . '.pdf', FILE_USE_INCLUDE_PATH);
      //$fichero = file_get_contents('../../recursos/pdf/documentos/data/remision_' . $remission_data['remission_number'] . $remission_data['timestamp'] . '.pdf', FILE_USE_INCLUDE_PATH);

      if ( $fichero !== false ) {
        $attach->fichero_in_base64 = base64_encode( $fichero );

        if ( $attach->fichero_in_base64 !== false ) {
          $template_name = "remission";
          $attach->name = 'remision_' . $remission_data['remission_number'] . $remission_data['timestamp'] . '.pdf';
          
          $post['data']['customEmail']['notes'] = ( isset($post['data']['customEmail']['notes']) && ( $post['data']['customEmail']['notes'] != '' ) ) ? $post['data']['customEmail']['notes'] : "Sin observaciones";
          //$post['data']['customEmail']['email'] = ( isset($post['data']['customEmail']['email']) && ( $post['data']['customEmail']['email'] == '' ) ) ? $post['data']['customEmail']['notes'] : "Sin observaciones";

          $mandrill = new \Mandrill_lib();
          $result_mail = $mandrill->send_remission_email( $post, $template_name, $remission_data['timestamp'], $attach);        
          
          if ( is_array($result_mail) && $result_mail[0]['status'] == "queued" ) {
            $result->status = "REMISSION_SENDED";
            $result->info = $result_mail;      
          }else{
            $result->status = "REMISSION_NOT_SENDED";
            $result->info = $result_mail;       
          }

        }else{
          $result->status = "REMISSION_NOT_ENCODED";    
        }
        
      }else{
        $result->status = "REMISSION_NOT_FOUNDED";  
      }
    }else {
      $result->status = "REMISSION_NOT_GENERATED";
    }
    
    return json_encode($result);

  }



function consultarCotizacion($id){
  $salida["info"] = Core\query("SELECT * FROM car_cotizacion, car_cliente WHERE car_cotizacion.id_cliente = car_cliente.id_cliente AND car_cotizacion.estado = 1 AND car_cotizacion.id_cotizacion = :id", array("id" => $id));
  $salida["contacto"] = Core\query("SELECT *, @id_con := id_contacto, (SELECT count(id_cotizacion_contacto) FROM car_cotizacion_contacto WHERE id_cotizacion = :id_cotizacion AND id_contacto = @id_con) as contactoCotizacion FROM car_cliente_contacto WHERE id_cliente = :id_cliente AND estado = 1", array("id_cotizacion" => $id, "id_cliente" => $salida["info"][0]["id_cliente"]));
  $salida["productos"] = Core\query("SELECT * FROM car_cotizacion_producto, car_producto WHERE car_cotizacion_producto.id_producto =  car_producto.id_producto AND id_cotizacion = :id AND car_cotizacion_producto.estado = 1", array("id" => $id));
  return json_encode($salida);
}

function productoCotizacion($id){
  $row = Core\query("SELECT * FROM car_cotizacion_producto, car_producto WHERE car_cotizacion_producto.id_producto =  car_producto.id_producto AND id_cotizacion_producto = :id AND car_cotizacion_producto.estado = 1", array("id" => $id));
  return json_encode($row);
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