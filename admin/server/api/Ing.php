<?php
namespace App\Ing;

error_reporting(0);
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
        if($nombre == 'password' || $nombre == 'pass') continue;
            $_SESSION[$nombre] = $valor;
    }

}

function login( $id, $pass, $type_of_user ){

    $result = new \stdclass();
    $is_json = true;

    $resultado = Core\login( $id, $pass, $is_json, false, false, $type_of_user );

    if( $is_json ){
        $resultado = json_decode($resultado);
        $resultado = (array)$resultado;
    }

    if($resultado["response"]){
        $salida["accede"] = true;
        $result->status = "LOGGED";
        $result->userData = $resultado["info"];

        init_session($resultado["info"]);

    }else{
        $salida["accede"] = false;
        $result->status = "NO_ACCESS";
    }
    return json_encode($result);
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

function update_item( $data ) {

    if ( isset($data['from']) ){
        switch( $data['from'] ) {
            case 'admin-main-page':
            switch ( $data['action'] ) {
                case 'update_main_page_promotion':
                $updated = update_month_promotion_in_main_page( $data['data'] );

                if( $updated ) {
                    //$to_get_base_data = array('from' => $data['from'], 'action' => 'get_base_data' );
                    //$info_to_return = list_varios( $to_get_base_data );
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

function create_item( $data ) {

    if ( isset($data['from']) ){
        switch( $data['from'] ) {
            case 'home':
                switch ( $data['action'] ) {
                    case 'create_user':
                        $insert_result = insert_user( $data['data'] );

                        $info_to_return['data'] = ( isset($insert_result) ) ? $insert_result : 'no-data';

                        switch( $insert_result->status ){
                            case 'INSERTED':
                                $info_to_return['status'] = 'SUCCESS';
                                break;
                            case 'USER_EXIST':
                                $info_to_return['status'] = 'EXIST';
                                break;
                            default:
                                $info_to_return['status'] = 'ERROR';
                                $info_to_return['data'] = error_get_last();
                                break;
                        }
                        break;
                }
                break;
            case 'admin-main-page':
                switch ( $data['action'] ) {
                    case 'update_main_page_promotion':
                    $updated = update_month_promotion_in_main_page( $data['data'] );

                    if( $updated ) {
                        //$to_get_base_data = array('from' => $data['from'], 'action' => 'get_base_data' );
                        //$info_to_return = list_varios( $to_get_base_data );
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

function list_varios( $data, $local = false ){
    if ( isset($data['from']) ){

        switch( $data['from'] ) {

            case 'home':
            switch ( $data['action'] ) {
                case 'get_main_page_promotion':
                $promotion = get_month_promotion();

                if( isset($promotion) && (count($promotion) == 0) ){
                    $promotion[0]['base_img'] = "recursos/img/img-promociones.png";
                    $promotion[0]['detail'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
                }

                $info_to_return['promotion'] = $promotion;
                $info_to_return['status'] = "PROMOTION_LOADED";
                break;
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
                $rin_products_result = get_rin_products( $info_to_return['rin_types'] );


                switch ( $rin_products_result->status ) {
                    case 'FOUND':
                        //$rin_products_result->data = get_tire_by_diamater($rin_products_result->data);
                        $info_to_return['rin_products'] = _group_rines_by_diameter($rin_products_result->data);
                        break;
                    case 'EMPTY':
                        $info_to_return['rin_products'] = array();
                        break;
                    default:
                        $info_to_return['rin_products'] = array();
                        break;
                }
                $info_to_return['tires'] = get_tires( $data['vehicleId'], $data['modelId'] );
                $tires_products_result = get_tire_products($info_to_return['tires']);

                switch ( $tires_products_result->status ) {
                    case 'FOUND':
                        $info_to_return['tire_products'] = $tires_products_result->data;
                        break;
                    case 'EMPTY':
                        $info_to_return['tire_products'] = array();
                        break;
                    default:
                        $info_to_return['tire_products'] = array();
                        break;
                }
                $info_to_return['seat_products'] = get_seat_all_products();
                $info_to_return['light_hid_products'] = get_lights_hd_all_products();
                $info_to_return['tank_products'] = get_tanks( $data['vehicleId'], $data['modelId'] );
                //$info_to_return['universals'] = get_universals( $data['vehicleId'], $data['modelId'] );

                $info_to_return['status'] = "PRODUCTS_LOADED";
                break;
                case 'get_compatible_tires_with_rin';
                    $tires_types = get_compatible_tires_with_rin( $data['diameter'], $data['width'] );

                    if ( count($tires_types) > 1 ){
                        $filtered = filter_tires( $tires_types );

                        $tire_products = get_tire_by_tire( $filtered );

                        if ( $tire_products->status == "FOUND" ) {
                            $info_to_return['tires_compatibles'] = $tire_products;
                            $info_to_return['status'] = 'PRODUCTS_LOADED';
                        }else {
                            $info_to_return['tires_compatibles'] = array();
                            $info_to_return['status'] = 'EMPTY';
                        }
                    }else{
                        $info_to_return['tires_compatibles'] = array();
                        $info_to_return['status'] = 'EMPTY';
                    }

                    break;
                default:
                # code...
                break;
            }
            break;
            case 'admin-products':
            switch ( $data['action'] ) {
                case 'get_base_data':

                //group_models(read_vehicles()); read vehicles from .csv
                //(read_tires());


                //$models = get_all_models();
                //model_in_index($models);
                //var_dump($models);

                //$tires_readed = read_tires();


                //var_dump($tires_readed);
                //save_tires( $tires_readed );

                //$rines_readed = read_rines();

                //associate_tires($rines_readed , $models );//associate products with models

                //  var_dump($rines_readed);
                //save_rines($rines_readed);

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
            switch ( $data['action'] ) {
                case 'get_base_data':
                $info_to_return['menu_items'] = get_all_product_types();
                $info_to_return['universals'] = get_universals();
                $info_to_return['status'] = 'LOADED';
                break;
            }
            break;

        }

    }else{
        $info_to_return['status'] = 'NO_FROM';
    }

    if( $local ){
        $result = $info_to_return;
        unset($info_to_return['status']);
    }else{
        $result = json_encode($info_to_return);
    }

    return $result;
}

function filter_tires( $tires ){
    $tires_filtered = array();

    foreach ($tires as $key => $tire) {
        $tires_filtered[$tire['tire']] = $tire;
    }

    return _index($tires_filtered);
}

function _index( $hash_map ) {
    $cont = 0;
    $indexed = array();
    foreach ($hash_map as $key => $item) {
        $indexed[$cont] = $item;
        $cont++;
    }

    return $indexed;
}

function get_compatible_tires_with_rin( $diameter, $width ){
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tire WHERE tire LIKE ". '\'%R'. $diameter. '%\'' . "AND inches LIKE " . '\'%'.$width.'\'';
    return Core\query($sql, array());
}

function get_tire_by_tire( $tires_types ){
    $result = new \stdClass();

    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tire_product WHERE ";
    $tires_type_sql = "";

    foreach ( $tires_types as $key => $tire ) {

        if( $key == 0 ){
            $tires_type_sql .= " (type LIKE ".'\''.$tire['tire'].'\'';
            if ( count($tires_types) == 1 ) {
                $tires_type_sql.= ')';
            }
        }else{
            if ( $key == (count($tires_types) - 1) )
                $tires_type_sql .= " OR type LIKE ".'\''.$tire['tire'].'\')';
            else {
                $tires_type_sql .= " OR type LIKE ".'\''.$tire['tire'].'\'';
            }
        }

    }

    $sql .= $tires_type_sql;

    $query_result =  Core\query($sql, array());

    if ( count($query_result) > 0 ) {
        $result->status = "FOUND";
        $result->data = $query_result;
    }else {
        $result->status = "EMPTY";
    }

    return $result;
}

function get_tire_by_diamater( $rines ) {
    $result = new \stdClass();

    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tire_product WHERE ";
    $tires_type_sql = "";

    foreach ( $rines as $key => $rin ) {

        $tires_type_sql .= " type = ".'\''.$rin['diameter'].'\'';

    }

    $sql .= $tires_type_sql;

    $query_result =  Core\query($sql, array());

    if ( count($query_result) > 0 ) {
        $result->status = "FOUND";
        $result->data = $query_result;
    }else {
        $result->status = "EMPTY";
    }

    return $result;
}

function _group_rines_by_diameter( $data ) {
    $new_array = array();

    foreach ($data as $key => $product) {
        $new_array[$product['diameter']]['rines'][] = $product;
    }

    return $new_array;
}

function get_tire_products( $type_of_tires ) {

    $result = new \stdClass();

    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tire_product WHERE ";
    $tires_type_sql = "";

    foreach ( $type_of_tires as $key => $type ) {
        if( $key == 0 ){
            $tires_type_sql .= " (type = ".'\''.$type['tire'].'\'';
            if ( count($type_of_tires) == 1 ) {
                $tires_type_sql.= ')';
            }
        }else{
            if ( $key == (count($type_of_tires) - 1) )
                $tires_type_sql .= " OR type = ".'\''.$type['tire'].'\')';
            else {
                $tires_type_sql .= " OR type = ".'\''.$type['tire'].'\'';
            }
        }
    }

    $sql .= $tires_type_sql;

    $query_result =  Core\query($sql, array());

    if ( count($query_result) > 0 ) {
        $result->status = "FOUND";
        $result->data = $query_result;
    }else {
        $result->status = "EMPTY";
    }

    return $result;
}

function get_rin_products( $rin_group_types ) {

    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "rin_product WHERE ";
    $pcds_array = array();
    $inches_array = array();
    $diameters_array = array();
    $k = 0;
    $i = 0;
    $result = new \stdClass();

    foreach ($rin_group_types as $key => $group) {

        $pcds = explode('-', $group['pcd']);
        $inches = explode('-', $group['inches']);
        $number_of_pcds = count($pcds) - 1 ;

        foreach ($pcds as $key => $value) {
            $pcds_array[$value] = $k;
            $k++;
        }

        foreach ($inches as $key => $value) {
            $inches_array[$value] = $i;
            $i++;
        }

        $diameters_array[$group['rin_diameter']] = $group['rin_diameter'];
    }

    $pcds_array = _array_index( $pcds_array );

    foreach ($pcds_array as $key => $value) {
        if( $key == 0 ){
            $pcds_sql .= " (pcd = ".'\''.$value.'\'';
            if ( count($pcds_array) == 1 ) {
                $pcds_sql.= ')';
            }
        }else{
            if ( $key == (count($pcds_array) - 1) )
                $pcds_sql .= " OR pcd = ".'\''.$value.'\')';
            else {
                $pcds_sql .= " OR pcd = ".'\''.$value.'\'';
            }
        }
    }

    $inches_array = _array_index( $inches_array );

    foreach ($inches_array as $key => $value) {
        if( $key == 0 ) {
            $inches_sql .= " (width = ".'\''.$value.'\'';

            if ( count($inches_array) == 1 ) {
                $inches_sql.= ')';
            }
        }else{
            if ( $key == (count($inches_array) - 1) )
                $inches_sql .= " OR width = ".'\''.$value.'\')';
            else
                $inches_sql .= " OR width = ".'\''.$value.'\'';
        }
    }

    $diameters_array = _array_index( $diameters_array );

    foreach ($diameters_array as $key => $value) {
        if( $key == 0 ) {
            $diameter_sql .= " (diameter = ".'\''.$value.'\'';
            if ( count($diameters_array) == 1 ) {
                $diameter_sql.= ')';
            }
        }else {
            if ( $key == (count($diameters_array) - 1) )
                $diameter_sql .= " OR diameter = ".'\''.$value.'\')';
            else {
                $diameter_sql .= " OR diameter = ".'\''.$value.'\'';
            }
        }
    }

    //pcd . inch . diameter

    $sql .= $pcds_sql." AND".$inches_sql." AND".$diameter_sql;

    $query_result =  Core\query($sql, array());

    if ( count($result) > 0 ) {
        $result->status = "FOUND";
        $result->data = $query_result;
    }else {
        $result->status = "EMPTY";
    }

    return $result;
}

function _array_index( $array_to_index ) {
    $array_indexed = array();
    $i = 0;
    foreach ($array_to_index as $key => $value) {
        $array_indexed[$i] = $key;
        $i++;
    }

    return $array_indexed;
}

function associate_tires( &$tires_data, $models ) {
    //var_dump($tires_data);
    foreach ($tires_data as $key => $value) {
        if( isset($models[$value->model]) ){

            $current_model = $models[$value->model];
            $tires_data[$key]->model = $current_model['id'];
            $tires_data[$key]->vehicle_id = $current_model['tym_vehicle_id'];

        }
    }

}

function save_rines( $rines_to_save ) {

    foreach ($rines_to_save as $key => $value) {

        $rin['table'] = "rin";
        $rin['column_id'] = "id";

        $rin['inches'] = $value->inch;
        $rin['pcd'] = $value->pcd;
        $rin['rin_diameter'] = $value->diameter;

        $rin_insert_id = Core\create($rin, false, false);

        $vehicle_has_rin['table'] = "vehicle_model_has_tym_rin";
        $vehicle_has_rin['column_id'] = "id";

        $vehicle_has_rin['tym_vehicle_model_id'] = $value->model;
        $vehicle_has_rin['tym_vehicle_model_tym_vehicle_id'] = $value->vehicle_id;
        $vehicle_has_rin['tym_rin_id'] = $rin_insert_id;

        $vehicle_has_insert_id = Core\create($vehicle_has_rin, false, false);
        echo $vehicle_has_insert_id;
    }
}

function save_tires( $tires_to_save ) {


    foreach ($tires_to_save as $key1 => $tire) {

        foreach ($tire->tires as $key2 => $options) {

            $tire_string = $options[0].'-'.$options[1].'-'.$options[2];

            $vehicle['table'] = "tire";
            $vehicle['column_id'] = "id";

            $vehicle['name'] = ( isset($tire->name) ) ? $tire->name : 'No definido';

            $vehicle['tire'] = $tire_string;
            $vehicle['inches'] = $tire->inches;
            $vehicle['referencie'] = ( isset($tire->ref) ) ? $tire->ref : 'No definido';
            $vehicle['description'] = ( isset($tire->description) ) ? $tire->description : 'No definido';
            $vehicle['stock'] = ( isset($tire->stock) ) ? $tire->stock : 0;
            $vehicle['price_unit'] = ( isset($tire->price) ) ? $tire->price : 0;
            $vehicle['img_base'] = NULL;

            $vehicle_insert_id = Core\create($vehicle, false, false);

            $vehicle_has_tire['table'] = "vehicle_model_has_tym_tire";
            $vehicle_has_tire['column_id'] = "id";

            $vehicle_has_tire['tym_vehicle_model_id'] = $tire->model;
            $vehicle_has_tire['tym_vehicle_model_tym_vehicle_id'] = $tire->vehicle_id;
            $vehicle_has_tire['tym_tire_id'] = $vehicle_insert_id;

            $vehicle__has_insert_id = Core\create($vehicle_has_tire, false, false);
        }
    }

}

function read_rines(){
    $handle = fopen("../../recursos/csv/rin.csv", 'r');

    if( $handle !== FALSE ) {
        $vehicles = array();

        $count_aux = 0;

        while ( ($data = fgetcsv($handle, 350, ',')) !== FALSE  ){
            $current_row = new \stdClass();

            if ( ($count_aux >= 1) && (count($data) >= 4) ) {
                //die();
                $current_row->brand = utf8_encode(trim($data[0]));
                $current_row->model = utf8_encode(trim($data[1]));
                $current_row->year = utf8_encode(trim($data[2]));
                $current_row->pcd = utf8_encode(trim($data[3]));
                $current_row->diameter = utf8_encode(trim($data[4]));
                $current_row->inch = utf8_encode(trim($data[5]));
            }

            $vehicles[] = $current_row;


            $count_aux++;
        }
        fclose( $handle );

        return $vehicles;
    }
}

function read_tires_products() {

    $handle = fopen("../../recursos/csv/tire-products.csv", 'r');

    if( $handle !== FALSE ) {
        $vehicles = array();

        $count_aux = 0;

        while ( ($data = fgetcsv($handle, 350, ',')) !== FALSE  ){
            $current_row = new \stdClass();

            if ( ($count_aux >= 1) && (count($data) >= 4) ) {
                //die();
                $current_row->name = trim($data[1]);
                $current_row->referencie = trim($data[2]);
                $current_row->brand = trim($data[3]);
                $current_row->model = trim($data[4]);
                $current_row->speed_rate  = trim($data[5]);
                $current_row->weigth_rate = trim($data[6]);
                $current_row->stock_u = trim($data[7]);
                $current_row->stock_g = trim($data[8]);
                $current_row->price_u = trim($data[9]);
                $current_row->price_g = trim($data[10]);
                $current_row->img = trim($data[0]);
            }

            $vehicles[] = $current_row;

            $count_aux++;
        }
        fclose( $handle );

        //var_dump($vehicles);
        save_tire_products($vehicles);
        //return $vehicles;
    }

}

function read_rin_products(){
    $handle = fopen("../../recursos/csv/rin-products.csv", 'r');

    if( $handle !== FALSE ) {
        $vehicles = array();

        $count_aux = 0;

        while ( ($data = fgetcsv($handle, 350, ',')) !== FALSE  ){
            $current_row = new \stdClass();

            if ( ($count_aux >= 1) && (count($data) >= 4) ) {
                //die();
                $current_row->img = utf8_encode(trim($data[0]));
                $current_row->ref = utf8_encode(trim($data[1]));
                $current_row->brand = utf8_encode(trim($data[2]));
                $current_row->diameter = utf8_encode(trim($data[3]));
                $current_row->width = utf8_encode(trim($data[4]));
                $current_row->holes = utf8_encode(trim($data[5]));
                $current_row->pcd = utf8_encode(trim($data[6]));
                $current_row->color = utf8_encode(trim($data[7]));
                $current_row->material = utf8_encode(trim($data[8]));
                $current_row->details = trim($data[9]);
                $current_row->stock_u = utf8_encode(trim($data[10]));
                $current_row->stock_g = utf8_encode(trim($data[11]));
                $current_row->price_u = utf8_encode(trim($data[12]));
            }

            $vehicles[] = $current_row;


            $count_aux++;
        }
        fclose( $handle );

        save_rin_products($vehicles);
        //return $vehicles;
    }
}

function save_rin_products( $rines_to_save ) {

    foreach ($rines_to_save as $key => $value) {

        $rin['table'] = "rin_product";
        $rin['column_id'] = "id";

        $rin['referencie'] = $value->ref;
        $rin['brand'] = $value->brand;
        $rin['diameter'] = $value->diameter;
        $rin['width'] = $value->width;
        $rin['holes'] = $value->holes;
        $rin['pcd'] = $value->pcd;
        $rin['color'] = $value->color;
        $rin['material'] = $value->material;
        $rin['details'] = $value->details;
        $rin['stock_unit'] = $value->stock_u;
        $rin['stock_group'] = $value->stock_g;
        $rin['price_client'] = $value->price_u;
        $rin['img'] = $value->img;

        $rin_insert_id = Core\create($rin, false, false);

        echo $rin_insert_id;
    }
}

function save_tire_products( $tires_to_save ) {

    unset($tires_to_save[0]);

    foreach ($tires_to_save as $key => $value) {

        $rin['table'] = "tire_product";
        $rin['column_id'] = "id";

        $rin['name'] = $value->name;
        $rin['referencie'] = $value->referencie;
        $rin['brand'] = $value->brand;
        $rin['model'] = $value->model;
        $rin['speed_rate'] = $value->speed_rate;
        $rin['weigth_rate'] = $value->weigth_rate;
        $rin['stock_unit'] = $value->stock_u;
        $rin['stock_group'] = $value->stock_g;
        $rin['price'] = ($value->price_u == 'sin determinar') ? 0 : $value->price_u;
        $rin['price_group'] = ($value->price_g == 'sin determinar') ? 0 : $value->price_g;
        $rin['img'] = $value->img;

        $rin_insert_id = Core\create($rin, false, false);

        echo $rin_insert_id;
    }

}

function group_models( $readed ) {
    $vehicles = array();

    foreach ($readed as $key => $value) {
        $model = new \stdClass();

        $model->model = $value->model;
        $model->year = $value->year;

        $vehicles[$value->brand][$value->model] = $model;
    }

    save_vehicles_and_models($vehicles);

}

function save_vehicles_and_models( $grouped_vehicles ){
    $insert_id = null;
    foreach ($grouped_vehicles as $brand => $models) {
        if( !empty($brand) ){

            $vehicle['table'] = "vehicle";
            $vehicle['column_id'] = "id";

            $vehicle['brand'] = $brand;
            $vehicle['status'] = 1;

            $vehicle_insert_id = Core\create($vehicle, false, false);

            foreach ($models as $key => $value) {
                $model['table'] = "vehicle_model";
                $model['column_id'] = "id";

                $model['model'] = $value->model;
                $model['year'] = $value->year;
                $model['status'] = 1;
                $model['tym_vehicle_id'] = $vehicle_insert_id;

                $insert_id = Core\create($model, false, false);
            }
        }
    }
    return $insert_id;
}

function get_seat_all_products() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "seat_product";
    return Core\query($sql, array());
}

function get_lights_hd_all_products() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "light_hd_product";
    return Core\query($sql, array());
}

function get_all_product_types() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "product_type ORDER BY type ASC";
    return Core\query($sql, array());
}

function create_product( $post ) {

    $result = new \stdClass();

    switch( $post['data']['productType']['id'] ) {
        case 1://rines
        break;
        case 2://tires
        $insert_ids = insert_product_type_tire( $post['data'] );
        $result->status = 'INSERTED';
        $result->data = $insert_ids;
        break;
        case 3://sillas
        break;
        case 4://luces hd
        break;
        case 5://racks
        break;

    }

    return json_encode($result);

}

function insert_product_type_tire( $product_info ){

    $product_to_save['table'] = "tire";
    $product_to_save['column_id'] = "id";

    $product_to_save['name'] = $product_info['productName'];
    $product_to_save['tire'] = $product_info['tireDetail'];
    $product_to_save['referencie'] = $product_info['productReference'];
    $product_to_save['description'] = $product_info['productDescription'];
    $product_to_save['stock'] = $product_info['productStock'];
    $product_to_save['price_unit'] = $product_info['productPrice'];
    $product_to_save['img_base'] = $product_info['picFile']['$ngfDataUrl'];

    $insert_id = Core\create($product_to_save, false, false);

    //associate_vehicle( $product_info['model'], $insert_id, 'tire' )

    return $insert_id;
}

function associate_vehicle( $vehicle_data, $inserted_tire_id, $type_of_product ){
    //check if exist a equal

    switch( $type_of_product ){
        case 'tire':
        $table = 'vehicle_model_has_tym_tire';
        $column_id = 'tym_tire_id';
        break;
    }

    $association_to_save['table'] = $table;
    $association_to_save['column_id'] = "id";

    $association_to_save['tym_vehicle_model_id'] = $vehicle_data['id'];
    $association_to_save['tym_vehicle_model_tym_vehicle_id'] = $vehicle_data['tym_vehicle_id'];
    $association_to_save[$column_id] = $inserted_tire_id;

    $insert_id = Core\create($association_to_save, false, false);

    if( isset($insert_id) && is_numeric($insert_id) )
    return false;

    return true;

}


function read_vehicles() {

    //$handle = fopen("ftp://user:password@example.com/somefile.txt", "w");
    $handle = fopen("../../recursos/csv/vehicles.csv", 'r');

    if( $handle !== FALSE ) {
        $vehicles = array();

        $count_aux = 0;

        while ( ($data = fgetcsv($handle, 150, ',')) !== FALSE  ){
            $current_row = new \stdClass();

            if ( ($count_aux >= 1) && (count($data) >= 4) ) {
                //die();
                $current_row->brand = utf8_encode(trim($data[1]));
                $current_row->model = utf8_encode(trim($data[2]));
                $current_row->year = utf8_encode(trim($data[3]));
            }

            $vehicles[] = $current_row;

            $count_aux++;
        }
        fclose( $handle );

        return $vehicles;

    }
}

function read_tires(){
    $handle = fopen("../../recursos/csv/tires.csv", 'r');

    if( $handle !== FALSE ) {
        $vehicles = array();

        $count_aux = 0;

        while ( ($data = fgetcsv($handle, 350, ',')) !== FALSE  ){
            $current_row = new \stdClass();

            if ( ($count_aux >= 1) && (count($data) >= 4) ) {
                //die();
                $current_row->brand = utf8_encode(trim($data[0]));
                $current_row->model = utf8_encode(trim($data[1]));
                $current_row->year = utf8_encode(trim($data[2]));
                $current_row->tires = format_tires_info(utf8_encode(trim($data[3])));
                $current_row->inches = utf8_encode(trim($data[4]));
            }

            $vehicles[] = $current_row;


            $count_aux++;
        }
        fclose( $handle );

        return $vehicles;

    }
}

function format_tires_inches( $inches_info ) {
    /*$by_rin_type = explode('/', $inches);
    $individual = explode('-', $by);*/
}

function format_tires_info( $tire_info ) {
    $by_rin = explode('/', $tire_info);

    if( count($by_rin) > 1 ){
        $tires_types = array();
        foreach ($by_rin as $key => $value) {
            $individual = explode('-', $value);

            if( count($individual) > 3 )
            $result = array_chunk($individual, 3);
            else{
                $aux[] = $individual;
                $result = $aux;
            }

            $tires_types = array_merge( $tires_types, $result );
        }

    }

    return $tires_types;
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

//pages
//main page
function update_month_promotion_in_main_page( $data ) {

    $old_promotion = get_month_promotion();

    $item_to_update['table'] = "month_promotion";
    $item_to_update['column_id'] = "id";

    if( isset($old_promotion) ) {

        $item_to_update['id'] = $old_promotion[0]['id'];
        $item_to_update['base_img'] = $data['picFile']['$ngfDataUrl'];
        $item_to_update['detail'] = $data['promotionDetail'];

        $insert_id = Core\update($item_to_update);

    }else {
        $item_to_update['base_img'] = $data['picFile']['$ngfDataUrl'];
        $item_to_update['detail'] = $data['promotionDetail'];

        $insert_id = Core\create($item_to_update, false, false);
    }

    $completed = false;

    if( isset($insert_id) )
    $completed = true;

    return $completed;

}

function insert_user( $data ) {

    $result = new \stdClass();

    $user_registered = get_user_by_email( $data['emailConfirmation'] );


    if( count($user_registered) == 0 ){
        $user_to_save['table'] = "user";
        $user_to_save['column_id'] = "id";

        $user_to_save['user_name'] = $data['username'];
        $user_to_save['email'] = $data['emailConfirmation'];
        $user_to_save['password'] = crypt($data['passwordConfirmation']);
        $user_to_save['birth_day'] = _format_birth_date( $data['birth'] );
        $user_to_save['gender'] = $data['gender'];
        $user_to_save['term_and_cond_accepted'] = ($data['termAndCond']) ? '1':'0';
        $user_to_save['tym_user_type_id'] = 1;
        $user_to_save['tym_user_status_id'] = 1;

        $insert_id = Core\create($user_to_save, false, false);

        if( $insert_id > 0 ){
            $result->status = 'INSERTED';
            $result->data = $insert_id;

            $user = get_user_by_id($insert_id);
            init_session($user[0]);
            // do login
        }else {
            $result->status = 'ERROR';
            $result->data = $insert_id;
        }
    }else {
        $result->status = 'USER_EXIST';
    }

    return $result;
}

function _format_birth_date( $data ){
    $date_string = strval($data['year']['value']) . '-' . $data['month']['id'] . '-' . strval($data['day']['value']);
    $date_formated = date('Y-m-d', strtotime($date_string));

    return $date_formated;
}

function model_in_index( &$models ){
    foreach ($models as $key => $value) {
        $models[$value['model']] = $value;
    }
}

function get_user_by_email( $email ){
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "user WHERE email = ". '\''. $email. '\'';
    return Core\query($sql, array());
}

function get_user_by_id( $id ){
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "user WHERE id = :id";
    return Core\query($sql, array('id'=>$id));
}

function get_month_promotion(){
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "month_promotion WHERE id = 1";
    return Core\query($sql, array());
}

function get_universals( $vehicle_id = NULL, $model_id = NULL ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "product_type pt WHERE pt.universal = '1' ORDER BY type ASC";
    return Core\query($sql, array());
}

function get_all_vehicles() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle WHERE status = 1 ORDER BY brand ASC";
    return Core\query($sql, array());
}

function get_all_models() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model WHERE status = 1 ORDER BY model ASC";
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

function get_tanks( $vehicle_id, $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tanks_has_tym_vehicle_model vht"
    ." LEFT JOIN ".$GLOBALS["prefix"]. "tank t ON t.id = vht.tym_tanks_id "
    ." WHERE vht.tym_vehicle_model_id = ".$model_id." AND vht.tym_vehicle_model_tym_vehicle_id = ".$vehicle_id;
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
