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
        $result->accede = true;
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
                // $models = group_models(read_vehicles()); //read vehicles from .csv
                // var_dump($models);

                //read_tires_products();
                //
                // $rines_readed = read_rines();
                // $models = get_all_models();
                // model_in_index($models);
                //
                // associate_tires($rines_readed , $models );//associate products with models
                //var_dump($rines_readed);

                // save_rines($rines_readed);



                //var_dump($models);
                //(read_tires());
                // $tires_readed = read_tires();
                // $models = get_all_models();
                // model_in_index($models);
                // associate_tires($tires_readed , $models );//associate products with models
                // //var_dump($tires_readed);
                // save_tires( $tires_readed );

                //read_rin_products();



                //  var_dump($rines_readed);

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
                case 'get_years_by_model';
                $years = get_years_by_model_by_name( $data['modelName'] );
                $years_filtered = filter_years( $years );
                $info_to_return['years'] = $years_filtered;
                $info_to_return['status'] = "VEHICLE_MODEL_YEARS_LOADED";
                break;
                case 'get_products':
                //var_dump($data);
                $model_by_name = search_model_by_name( $data['modelName'], $data['vehicleId'] );
                //var_dump($model_by_name);
                $model_id = NULL;
                if ( count($model_by_name) > 1 ){
                    $model_id = select_model_id( $model_by_name, $data['year'] );
                }else{
                    $model_id = $model_by_name[0]['id'];
                }
                if( count($model_id) > 1 ){
                    foreach($model_id as $value){
                        $types = get_rines( $value );

                        if( !empty($types) ){
                            if(count($types) > 1 ){
                                foreach ($types as $key => $type) {
                                    $info_to_return['rin_types'][] = $type;
                                }
                            }else{
                                $info_to_return['rin_types'][] = $types[0];
                            }
                        }
                    }
                }else{
                    if(is_array($model_id)){
                        $info_to_return['rin_types'] = get_rines( $model_id[0] );
                    }else{
                        $info_to_return['rin_types'] = get_rines( $model_id );
                    }

                }
                //var_dump($model_by_name);

                // var_dump($info_to_return['rin_types']);

                if( !empty($info_to_return['rin_types']) ) {
                    $rin_products_result = get_rin_products( $info_to_return['rin_types'] );

                    //var_dump($rin_products_result);

                    switch ( $rin_products_result->status ) {
                        case 'FOUND':
                        //$rin_products_result->data = get_tire_by_diamater($rin_products_result->data);
                        $info_to_return['rin_products'] = _group_rines_by_diameter($rin_products_result->data);
                        $rines_ciegos = get_rines_ciegos();
                        $info_to_return['rin_products'] = $info_to_return['rin_products'] + _group_rines_by_diameter($rines_ciegos);
                        break;
                        case 'EMPTY':
                        $rines_ciegos = get_rines_ciegos();
                        $info_to_return['rin_products'] = _group_rines_by_diameter($rines_ciegos);
                        break;
                        default:
                        $rines_ciegos = get_rines_ciegos();
                        $info_to_return['rin_products'] = _group_rines_by_diameter($rines_ciegos);
                        break;
                    }
                }else{
                    $rines_ciegos = get_rines_ciegos();
                    $info_to_return['rin_products'] = _group_rines_by_diameter($rines_ciegos);
                }
                //echo $model_id;
                if( count($model_id) > 1 ){
                    foreach($model_id as $value){
                        $types = get_tires( $value );
                        if( !empty($types) ){
                            $info_to_return['tires'][] = $types[0];
                        }
                    }
                }else{
                    if(is_array($model_id)){
                        $info_to_return['tires'] = get_tires( $model_id[0] );
                    }else{
                        $info_to_return['tires'] = get_tires( $model_id );
                    }

                }
                //var_dump($info_to_return['tires']);
                $info_to_return['accesorios'] = _index_universals(get_universals());

                if( !empty($info_to_return['tires']) ) {
                    $tires_products_result = get_tire_products($info_to_return['tires']);

                    //var_dump($tires_products_result);

                    switch ( $tires_products_result->status ) {
                        case 'FOUND':
                        $info_to_return['tire_products'] = _group_tires_by_diameter($tires_products_result->data);
                        break;
                        case 'EMPTY':
                        $info_to_return['tire_products'] = array();
                        break;
                        default:
                        $info_to_return['tire_products'] = array();
                        break;
                    }
                }else {
                    $info_to_return['tire_products'] = array();
                }

                $info_to_return['bomberestribos_products']['delantero'] = array();
                $info_to_return['bomberestribos_products']['trasero'] = array();
                $info_to_return['bomberestribos_products']['estribo'] = array();
                $info_to_return['parrilas_techo'] = array();
                $info_to_return['barras_techo'] = array();

                if( count($model_id) > 1 ){
                    foreach( $model_id as $value ){
                        $vehicle = get_vehicle_model_by_id($value);

                        $delantero = get_bomber_delantero_products_by_model_id( $value );
                        $trasero = get_bomber_trasero_products_by_model_id( $value );
                        $estribo = get_estribo_products_by_model_id( $value );
                        $barra_antivolco = get_barra_antivolco_products_by_model_id( $value );
                        $tapetes = get_tapete_maletero_products( $value );
                        $tanks = get_tanks( $value );
                        $barra_de_exploradoras = get_barra_de_exploradoras($value);

                        $parrilas_techo_size = get_parrilla_techo_product_size_by_model_id( $value );
                        $barras_techo_type = get_barra_techo_product_size_by_model_id( $value );

                        $exploradoras = get_exploradora_product_by_model_id($value);

                        $cromados = _index_cromados(get_cromados_products($value));

                        if( !empty($cromados) ) {
                            _add_to_accesorios( $info_to_return , $cromados );
                        }

                        if( !empty($exploradoras) ) {
                            $info_to_return['accesorios']['exploradoras'] = $exploradoras;
                        }

                        if( $vehicle[0]['sin_barras'] == '1' ){
                            $type_info = get_product_barra_type_info( 7 );
                            $barras_techo = get_barras_transversales();
                            $info_to_return['barras_techo'][$type_info[0]['tipo']] = $barras_techo;
                        }

                        if( !empty($tanks) ) {
                            $tank_products = get_all_tank_products();
                            $info_to_return['accesorios']['tanques'] = $tank_products;
                        }

                        if( !empty($barra_de_exploradoras) ) {
                            $barra_de_exploradoras_products = get_all_barras_exploradoras_products();
                            $info_to_return['accesorios']['barra de exploradoras'] = $barra_de_exploradoras_products;
                        }

                        if( !empty($tapetes) ) {
                            $info_to_return['accesorios']['tapete maletero'] = $tapetes;
                        }

                        if( !empty($barras_techo_type) ) {
                            foreach ($barras_techo_type as $key => $type) {

                                if( $type['product_type_id'] == '4' || $type['product_type_id'] == '5'){
                                    $barras_techo = get_product_barra_type_info_by_model_and_product_type($value);
                                }else {
                                    $barras_techo = get_barra_techo_product_by_size($type['product_type_id']);
                                }
                                $type_info = get_product_barra_type_info($type['product_type_id']);
                                $info_to_return['barras_techo'][$type_info[0]['tipo']] = $barras_techo;
                            }
                        }

                        if( !empty($parrilas_techo_size) ) {

                            $sizes = explode('-', $parrilas_techo_size[0]['product_sizes']);
                            $info_to_return['parrilas_techo'] = get_parrilla_techo_product_by_sizes( $sizes );
                        }

                        if( !empty($delantero) ){
                            $info_to_return['bomberestribos_products']['delantero'] = $delantero;
                        }
                        if( !empty($trasero) ){
                            $info_to_return['bomberestribos_products']['trasero'] = $trasero;
                        }
                        if( !empty($estribo) ){
                            $info_to_return['bomberestribos_products']['estribo'] = $estribo;
                        }
                        if( !empty($barra_antivolco) ){
                            $info_to_return['accesorios']['barra antivolco'] = $barra_antivolco;
                        }
                    }
                }else{
                    $model_id = (is_array($model_id)) ? $model_id[0] : $model_id;

                    $vehicle = get_vehicle_model_by_id($model_id);
                    $delantero = get_bomber_delantero_products_by_model_id( $model_id );

                    $trasero = get_bomber_trasero_products_by_model_id( $model_id);

                    $estribo = get_estribo_products_by_model_id( $model_id );


                    $parrilas_techo_size = get_parrilla_techo_product_size_by_model_id( $model_id );

                    $barras_techo_type = get_barra_techo_product_size_by_model_id( $model_id );
                    $tapetes = get_tapete_maletero_products( $model_id );
                    $barra_antivolco = get_barra_antivolco_products_by_model_id( $model_id );

                    $tanks = get_tanks( $model_id );
                    $barra_de_exploradoras = get_barra_de_exploradoras($model_id);

                    $exploradoras = get_exploradora_product_by_model_id($model_id);

                    $cromados = _index_cromados(get_cromados_products($model_id));



                    if( !empty($cromados) ) {
                        _add_to_accesorios( $info_to_return , $cromados );
                    }

                    if( !empty($exploradoras) ) {
                        $info_to_return['accesorios']['exploradoras'] = $exploradoras;
                    }

                    if( $vehicle[0]['sin_barras'] == '1' ){
                        $type_info = get_product_barra_type_info( 7 );
                        $barras_techo = get_barras_transversales();
                        $info_to_return['barras_techo'][$type_info[0]['tipo']] = $barras_techo;
                    }

                    if( !empty($tanks) ) {
                        $tank_products = get_all_tank_products();
                        $info_to_return['accesorios']['tanques'] = $tank_products;
                    }

                    if( !empty($barra_de_exploradoras) ) {
                        $barra_de_exploradoras_products = get_all_barras_exploradoras_products();
                        $info_to_return['accesorios']['barra de exploradoras'] = $barra_de_exploradoras_products;
                    }

                    if( !empty($tapetes) ) {
                        $info_to_return['accesorios']['tapete maletero'] = $tapetes;
                    }

                    if( !empty($barras_techo_type) ) {
                        foreach ($barras_techo_type as $key => $type) {
                            if( $type['product_type_id'] == '4' || $type['product_type_id'] == '5'){
                                $barras_techo = get_product_barra_type_info_by_model_and_product_type($model_id);
                            }else {
                                $barras_techo = get_barra_techo_product_by_size($type['product_type_id']);
                            }
                            $type_info = get_product_barra_type_info($type['product_type_id']);
                            $info_to_return['barras_techo'][$type_info[0]['tipo']] = $barras_techo;
                        }
                    }

                    if( !empty($parrilas_techo_size) ) {
                        $sizes = explode("-", $parrilas_techo_size[0]['product_sizes']);

                        $info_to_return['parrilas_techo'] = get_parrilla_techo_product_by_sizes( $sizes );
                    }

                    if( !empty($delantero) ){
                        $info_to_return['parrilas_techo'][] = $parrillas;
                    }

                    if( !empty($delantero) ){
                        $info_to_return['bomberestribos_products']['delantero'][] = $delantero[0];
                    }
                    if( !empty($trasero) ){
                        $info_to_return['bomberestribos_products']['trasero'][] = $trasero[0];
                    }
                    if( !empty($estribo) ){
                        $info_to_return['bomberestribos_products']['estribo'][] = $estribo[0];
                    }

                    if( !empty($barra_antivolco) ){
                        $info_to_return['accesorios']['Barra antivolco'] = $barra_antivolco;
                    }

                }

                $model_id = (is_array($model_id)) ? $model_id[0] : $model_id;

                $info_to_return['portaequipajes_products'] = get_portaequipajes_all_products();

                $info_to_return['head_products'] = get_seat_all_products();
                $info_to_return['light_hid_products'] = get_lights_hd_all_products();

                $info_to_return['status'] = "PRODUCTS_LOADED";
                //var_dump(error_get_last());
                break;
                case 'get_compatible_tires_with_rin';
                $tire_products = get_compatible_tires_with_rin( $data['diameter'], $data['width'] );

                if ( count($tire_products) > 1 ){

                    $info_to_return['tires_compatibles'] = ( count($tire_products) > 5 ) ? array_slice($tire_products, 0,5) : $tire_products;
                    $info_to_return['status'] = 'PRODUCTS_LOADED';
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

function _add_to_accesorios( &$accesorios_data, $data_to_add ){

    foreach ($data_to_add as $key => $value) {
        $accesorios_data['accesorios'][$key] = $value;
    }
}

function filter_tires( $tires ){
    $tires_filtered = array();

    foreach ($tires as $key => $tire) {
        $tires_filtered[$tire['tire']] = $tire;
    }

    return _index($tires_filtered);
}

function _index_universals( $universal_products ){
    $new_array = array();
    foreach ($universal_products as $key => $value) {
        $new_array[$value['name']][] = $value;
    }

    return $new_array;
}

function _index_cromados( $cromado_products ){
    $new_array = array();
    foreach ($cromado_products as $key => $value) {
        $new_array[$value['name']][] = $value;
    }

    return $new_array;
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

function select_model_id( $models, $year ) {
    $model_id = array();
    foreach ( $models as $key => $model ) {
        $range = explode('-', $model['year']);
        if( count($range) > 1 ){
            $values = _generate_range($range[0], $range[1]);

            foreach ($values as $key => $value) {
                if ( $value == $year ) {
                    $model_id[] = $model['id'];
                    break;
                }
            }
        }else{
            if ( $range[0] == $year ) {
                $model_id[] = $model['id'];
            }
        }
    }

    return $model_id;
}

function search_model_by_name( $name, $vehicle_id ){
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model WHERE model LIKE ". '\''. $name. '\''. " AND tym_vehicle_id = ".$vehicle_id;
    return Core\query($sql, array());
}

function get_model_by_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model WHERE id = ".$model_id;
    return Core\query($sql, array());
}

function get_compatible_tires_with_rin( $diameter, $width ){
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tire_product WHERE diameter LIKE ". '\''. $diameter. '\'' . " AND inches LIKE " . '\'%'.$width.'%\'';
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
        if( $product['is_blind'] == '1' ){
            $new_array['ciegos '.$product['diameter']]['rines'][] = $product;
        }else{
            $new_array[$product['diameter']]['rines'][] = $product;
        }
    }

    return $new_array;
}

function _group_tires_by_diameter( $data ) {
    $new_array = array();

    foreach ($data as $key => $product) {
        $new_array[$product['diameter']]['tires'][] = $product;
    }

    return $new_array;
}

function get_tire_products( $type_of_tires ) {

    $result = new \stdClass();

    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tire_product WHERE ";
    $tires_type_sql = "";

    foreach ($type_of_tires as $key_main => $group) {

        $tires = explode('/', $group['tires']);
        $inches = explode('/', $group['inches']);
        $tires_individual = array();
        $inches_individual = array();

        foreach ($tires as $key => $value) {
            $currents_parts = explode('-', $value);
            if ( count($currents_parts) > 3) {
                $array_chunked = array_chunk($currents_parts, 3);
                foreach ($array_chunked as $key => $part) {
                    if( count($part) > 1 ){
                        $tires_individual[] = $part[0].'-'.$part[1].'-'.$part[2];
                    }
                }
            }else{
                $tires_individual[] = $value;
            }
        }

        foreach ($inches as $key => $value) {
            $currents_parts = explode('-', $value);

            foreach ($currents_parts as $key => $part) {
                $inches_individual[] = $part;
            }
        }

        $to_search = array_combine($tires_individual, $inches_individual);
        //var_dump($to_search);
        $sql_aux = '';
        $index_aux = 0;
        foreach ($to_search as $key => $value) {
            if( $key == 0 ) {
                $sql_aux .= "(type LIKE ".'\''.strtoupper($key).'\''. " AND inches LIKE ".'\'%'.$value.'%\''.") OR ";
                $index_aux++;
                if ( count($to_search) == 1 ) {
                    $sql_aux .= ' ) OR ';
                }
            }else {
                if ( $index_aux  == (count($to_search) - 1) ){
                    if ( $key_main == (count($type_of_tires) - 1) ){
                        $sql_aux .= "(type LIKE ".'\''.strtoupper($key).'\''. " AND inches LIKE ".'\'%'.$value.'%\''.") ";
                    }else{
                        $sql_aux .= "(type LIKE ".'\''.strtoupper($key).'\''. " AND inches LIKE ".'\'%'.$value.'%\''.") OR";
                    }
                }else {
                    $sql_aux .= "(type LIKE ".'\''.strtoupper($key).'\''. " AND inches LIKE ".'\'%'.$value.'%\''.") OR ";
                    ;
                }
            }
            $index_aux++;
        }
    }
    //var_dump($sql_aux);
    $sql .= $sql_aux;

    $query_result =  Core\query($sql, array());

    if ( count($query_result) > 0 ) {
        $result->status = "FOUND";
        $result->data = $query_result;
    }else {
        $result->status = "EMPTY";
    }

    return $result;
}

function get_rines_ciegos() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "rin_product".
    " WHERE is_blind LIKE '1'";
    return Core\query($sql, array());
}

function get_rin_products( $rin_group_types ) {

    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "rin_product WHERE ";
    $result = new \stdClass();
    $sql_aux = '';

    foreach ($rin_group_types as $key_main => $group) {
        if( $group['pcd'] == '4x100' || $group['pcd'] == '4x114,3'){
            $new_group = array('pcd'=>'8x100-8x114,3', 'rin_diameter'=>$group['rin_diameter'], 'inches'=>$group['inches']);
            $rin_group_types[] = $new_group;
        }
    }

    //var_dump($rin_group_types);

    foreach ($rin_group_types as $key_main => $group) {

        $inches = explode('-', $group['inches']);
        $sql_inch = '';

        foreach ($inches as $key => $value) {
            if( $key == 0 ) {
                $sql_aux .= "(pcd LIKE ".'\''.$group['pcd'].'\' AND diameter LIKE '.$group['rin_diameter'] ." AND width LIKE ".'\''.$value.'\' AND status LIKE \'active\') OR ';

                if ( count($inches) == 1 ) {
                    $sql_aux .= ' ) OR ';
                }
            }else {
                if ( $key == (count($inches) - 1) ){
                    if ( $key_main == (count($rin_group_types) - 1) ){
                        $sql_aux .= "(pcd LIKE ".'\''.$group['pcd'].'\' AND diameter LIKE '.$group['rin_diameter'] ." AND width LIKE ".'\''.$value.'\' AND status LIKE \'active\')';
                    }else{
                        $sql_aux .= "(pcd LIKE ".'\''.$group['pcd'].'\' AND diameter LIKE '.$group['rin_diameter'] ." AND width LIKE ".'\''.$value.'\' AND status LIKE \'active\') OR ';
                    }
                }else {
                    $sql_aux .= "(pcd LIKE ".'\''.$group['pcd'].'\' AND diameter LIKE '.$group['rin_diameter'] ." AND width LIKE ".'\''.$value.'\' AND status LIKE \'active\') OR ';
                }
            }
        }
    }

    $sql .= $sql_aux;

    //<var_dump($sql);

    $query_result =  Core\query($sql, array());

    if ( count($query_result) > 0 ) {
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
    //var_dump($models);
    foreach ($tires_data as $key => $value) {
        if( isset($models[$value->model.$value->year]) ){
            //echo $models[$value->model]['model'] . '=' . $value->model. '<br>' . '-----' .$models[$value->year]['year']. ' == ' .$value->year.'end--->';
            $current_model = $models[$value->model.$value->year];
            $tires_data[$key]->model_id = $current_model['id'];
        }
    }

}

function save_rines( $rines_to_save ) {

    foreach ($rines_to_save as $key => $value) {

        $vehicle_has_rin['table'] = "rin";
        $vehicle_has_rin['column_id'] = "id";

        $vehicle_has_rin['vehicle_model_id'] = $value->model_id;
        $vehicle_has_rin['pcd'] = $value->pcd;
        $vehicle_has_rin['rin_diameter'] = $value->diameter;
        $vehicle_has_rin['inches'] = $value->inch;

        $rin_insert_id = Core\create($vehicle_has_rin, false, false);

        echo $rin_insert_id;
    }
}

function save_tires( $tires_to_save ) {

    foreach ($tires_to_save as $key1 => $tire) {

        $vehicle['table'] = "tire";
        $vehicle['column_id'] = "id";

        $vehicle['vehicle_model_id'] = $tire->model_id;
        $vehicle['tires'] = $tire->tires;
        $vehicle['inches'] = $tire->inches;

        $vehicle_insert_id = Core\create($vehicle, false, false);
        echo $vehicle_insert_id;

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
                $current_row->brand = strtolower(utf8_encode(trim($data[0])));
                $current_row->model = strtolower(utf8_encode(trim($data[1])));
                $current_row->year = strtolower(utf8_encode(trim($data[2])));
                $current_row->pcd = strtolower(utf8_encode(trim($data[3])));
                $current_row->diameter = strtolower(utf8_encode(trim($data[4])));
                $current_row->inch = strtolower(utf8_encode(trim($data[5])));
            }

            $vehicles[] = $current_row;


            $count_aux++;
        }
        fclose( $handle );
        unset($vehicles[0]);
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
                $current_row->diameter = trim($data[2]);
                $current_row->inches = trim($data[3]);
                $current_row->referencie = trim($data[4]);
                $current_row->formal_number = trim($data[5]);

                $current_row->brand = trim($data[6]);
                $current_row->model = trim($data[7]);
                $current_row->speed_rate  = trim($data[8]);
                $current_row->weigth_rate = trim($data[9]);
                $current_row->stock_u = trim($data[10]);
                $current_row->stock_g = trim($data[11]);
                $current_row->price_u = trim($data[12]);
                // $current_row->price_g = trim($data[10]);
                $current_row->size = trim($data[13]);
                $current_row->instalation_price = trim($data[14]);
                $current_row->has_instructivo = trim($data[15]);
                $current_row->img = trim($data[0]);
            }

            $vehicles[] = $current_row;

            $count_aux++;
        }
        fclose( $handle );


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
                $current_row->img = strtolower(utf8_encode(trim($data[0])));
                $current_row->ref = strtolower(utf8_encode(trim($data[1])));
                $current_row->brand = strtolower(utf8_encode(trim($data[2])));
                $current_row->diameter = strtolower(utf8_encode(trim($data[3])));
                $current_row->width = strtolower(utf8_encode(trim($data[4])));
                $current_row->holes = strtolower(utf8_encode(trim($data[5])));
                $current_row->pcd = strtolower(utf8_encode(trim($data[6])));
                $current_row->color = strtolower(utf8_encode(trim($data[7])));
                $current_row->material = strtolower(utf8_encode(trim($data[8])));
                $current_row->type = strtolower(utf8_encode(trim($data[9])));
                $current_row->details = trim($data[10]);
                $current_row->stock_u = strtolower(utf8_encode(trim($data[11])));
                $current_row->stock_g = strtolower(utf8_encode(trim($data[12])));
                $current_row->price_u = strtolower(utf8_encode(trim($data[13])));
                $current_row->size = strtolower(utf8_encode(trim($data[14])));
                $current_row->instalation_price = strtolower(utf8_encode(trim($data[15])));
                $current_row->has_instructivo = strtolower(utf8_encode(trim($data[16])));

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
        $rin['size'] = $value->size;
        $rin['instalation_price'] = $value->instalation_price;
        $rin['has_instructivo'] = $value->has_instructivo;

        $rin_insert_id = Core\create($rin, false, false);

        echo $rin_insert_id;
    }
}

function save_tire_products( $tires_to_save ) {


    foreach ($tires_to_save as $key => $value) {

        $rin['table'] = "tire_product";
        $rin['column_id'] = "id";

        $rin['type'] = $value->name;
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
        $rin['size'] = $value->size;
        $rin['instalation_price'] = $value->instalation_price;
        $rin['diameter'] = $value->diameter;

        $rin['inches'] = $value->inches;
        $rin['formal_number'] = $value->formal_number;




        $rin['has_instructivo'] = $value->has_instructivo;



        //var_dump($rin);
        $rin_insert_id = Core\create($rin, false, false);

        echo $rin_insert_id;
    }

}

function group_models( $readed ) {
    $vehicles = array();
    //var_dump($readed);
    foreach ($readed as $key => $value) {
        $model = new \stdClass();

        $model->model = $value->model;
        $model->year = $value->year;

        $vehicles[$value->brand][$model->model.$model->year] = $model;
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
function get_portaequipajes_all_products() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "portaequipaje";
    return Core\query($sql, array());
}

function get_tapete_maletero_products( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tapete_maletero tm"
    ." LEFT JOIN ".$GLOBALS["prefix"]. "tapete_maletero_product t ON t.id = tm.product_id "
    ." WHERE tm.model_id = ".$model_id;

    return Core\query($sql, array());
}

function get_lights_hd_all_products() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "light_hd_product";
    return Core\query($sql, array());
}

function get_all_product_types() {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "product_type WHERE status = 'active' ORDER BY type ASC";
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
            // var_dump($data);
            if ( ($count_aux >= 1) && (count($data) >= 3) ) {
                //die();
                $current_row->brand = strtolower(utf8_encode(trim($data[0])));
                $current_row->model = strtolower(utf8_encode(trim($data[1])));
                $current_row->year = strtolower(utf8_encode(trim($data[2])));
            }

            $vehicles[] = $current_row;

            $count_aux++;
        }
        fclose( $handle );

        unset($vehicles[0]);
        // var_dump($vehicles);
        // die();
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
                $current_row->brand = strtolower(utf8_encode(trim($data[0])));
                $current_row->model = strtolower(utf8_encode(trim($data[1])));
                $current_row->year = strtolower(utf8_encode(trim($data[2])));
                $current_row->tires = strtolower(utf8_encode(trim($data[3])));
                $current_row->inches = strtolower(utf8_encode(trim($data[4])));
            }

            $vehicles[] = $current_row;


            $count_aux++;
        }
        fclose( $handle );
        unset($vehicles[0]);
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

function _generate_range( $begin, $end ){
    $range = array();
    for ($i=$begin; $i <= $end ; $i++) {
        $range[] = (string)$i;
    }
    return $range;
}

function filter_years( $to_filter ) {
    $hashed = array();
    $years = array();
    $result = array();
    $to_send = NULL;
    if ( count($to_filter) > 1 ){
        foreach ($to_filter as $key => $value) {
            $hashed[$value['year']] = $value;
        }
        foreach ($hashed as $key => $value) {
            $current = explode('-', $value['year']);
            if( count($current) > 1 ){
                $range = _generate_range($current[0], $current[1]);
                $current = $range;
                $years[] = $current;
            }else {
                $years[] = $current[0];
            }
        }
    }else {
        $current = explode('-', $to_filter[0]['year']);
        if( count($current) > 1 ){
            $range = _generate_range($current[0], $current[1]);
            $current = $range;
            $years[] = $current;
        }else {
            $years[] = $current[0];
        }
    }
    if ( count($years) > 1 ) {
        foreach ($years as $key => $list) {
            foreach ($list as $key => $value) {
                $result[$value] = $value;
            }
        }
        $sorted = array();
        foreach ($result as $key => $value) {
            $sorted[] = (string)$key;
        }
        sort($sorted);
        $to_send = $sorted;
    }else {
        $to_send = $years[0];
    }
    // echo "---------------";
    // var_dump($to_send);

    return $to_send;
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
        $models[$value['model'].$value['year']] = $value;
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
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "universal ORDER BY name ASC";
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
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model WHERE ".$GLOBALS["prefix"]. "vehicle_id = ". $brand_id ." AND status = 1 GROUP BY model ORDER BY model ASC";
    return Core\query($sql, array());
}

function get_vehicle_model_by_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model WHERE id = ".$model_id;
    return Core\query($sql, array());
}

function get_years_by_model_by_name( $model_name ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "vehicle_model WHERE model LIKE ".'\''.$model_name.'\''." AND status = 1";
    return Core\query($sql, array());
}

function get_rines( $vehicle_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "rin r"
    ." WHERE vehicle_model_id = ".$vehicle_id;
    return Core\query($sql, array());
}

function get_all_tank_products( ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tank_product tp";
    return Core\query($sql, array());
}

function get_all_barras_exploradoras_products( ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "barras_exploradoras_product bep";
    return Core\query($sql, array());
}

function get_tanks( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tank t"
    ." WHERE t.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_barra_de_exploradoras( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "barras_exploradoras be"
    ." WHERE be.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_tires( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "tire t"
    ." WHERE vehicle_model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_bomber_delantero( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "bomper_delantero"
    ." WHERE model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_bomber_delantero_products_by_model_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "bomper_delantero bd".
    " LEFT JOIN ".$GLOBALS["prefix"]."bomper_delantero_product bdp ON bdp.id = bd.product_id ".
    " WHERE bd.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_bomber_trasero_products_by_model_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "bomper_trasero bt".
    " LEFT JOIN ".$GLOBALS["prefix"]."bomper_trasero_product btp ON btp.id = bt.product_id ".
    " WHERE bt.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_estribo_products_by_model_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."estribo e ".
    " LEFT JOIN ".$GLOBALS["prefix"]."estribo_product ep ON ep.id = e.product_id ".
    " WHERE e.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_exploradora_product_by_model_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."exploradora e ".
    " LEFT JOIN ".$GLOBALS["prefix"]."exploradora_product ep ON ep.id = e.product_id ".
    " WHERE e.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_cromados_products( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."cromado c ".
    " LEFT JOIN ".$GLOBALS["prefix"]."cromado_product cp ON cp.id = c.product_id ".
    " WHERE c.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_parrilla_techo_product_size_by_model_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."parrilla_techo pt".
    " WHERE pt.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_barra_techo_product_size_by_model_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."barra_techo bt".
    " WHERE bt.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_barra_techo_product_by_size( $type ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."barra_techo_product btp".
    " WHERE btp.tipo_barra_id = ".$type;
    return Core\query($sql, array());
}

function get_product_barra_type_info( $type_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."tipo_barra tb".
    " WHERE tb.id = ".$type_id;
    return Core\query($sql, array());
}

function get_barras_transversales( ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."barra_techo_product btp".
    " WHERE btp.tipo_barra_id = 7";
    return Core\query($sql, array());
}

function get_product_barra_type_info_by_model_and_product_type( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."barra_techo bt".
    " LEFT JOIN ".$GLOBALS["prefix"]."barra_techo_product btp ON btp.id = bt.product_id".
    " WHERE bt.model_id = ".$model_id;
    return Core\query($sql, array());
}

function get_parrilla_techo_product_by_sizes( $sizes ) {

    $sql = "SELECT * FROM ".$GLOBALS["prefix"]."parrillas_techo_product ptp";

    foreach ($sizes as $key => $value) {
        if( $key == 0 ) {
            $sql_aux .= " WHERE (ptp.size_in LIKE ".'\''.$value.'\') ';

        }else {
            $sql_aux .= "OR (ptp.size_in LIKE ".'\''.$value.'\')';
        }
    }

    $sql .= $sql_aux;

    return Core\query($sql, array());
}

function get_barra_antivolco_products_by_model_id( $model_id ) {
    $sql = "SELECT * FROM ".$GLOBALS["prefix"]. "barra_antivolco bav ".
    " LEFT JOIN ".$GLOBALS["prefix"]. "barra_antivolco_product bavp ON bavp.id = bav.product_id ".
    " WHERE bav.model_id = ".$model_id;
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

function get_product($post){
    $result = new \stdClass();
    switch($post['data']['category']){
        case 'rin':
            $query_result = get_rin_by_id($post['data']['id'], $post['data']['ref']);
            if(isset($query_result[0])){
                $result->images = get_images($post['data']['category'], $post['data']['id']);
                $result->data = $query_result[0];
                $result->status = "SUCCESS";
            }else{
                $result->data = $query_result;
                $result->status = "ERROR";
            }
        break;
        default:
            $result->status = "ERROR";
        break;
    }
    return json_encode($result);
}
function get_images($category, $product_id){
    $dir = "../../../admin/recursos/img/".$category."-products/".$product_id;
    $files = scandir($dir);
    if(is_array($files)){
        $files = array_slice($files, 2);
    }
    return $files;
}

function get_rin_by_id( $rin_id, $reference = null ) {
    $sql  = "SELECT * FROM ".$GLOBALS['prefix']."rin_product WHERE id = ". $rin_id;
    if(isset($reference))
        $sql .= " AND referencie LIKE ".'\''.$reference.'\'';
    //var_dump($sql);
    return Core\query($sql, array());
}

?>
