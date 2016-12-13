<?php
namespace App\FnGenerales;

if( !isset($_SESSION) )
	session_start();

//use \; 
/* comprobar si el usuario actual es administrador */
function esAdmin(){
    $cargos_admin = ['Cordinador comercial'];
    //var_dump($_SESSION);
    return in_array($_SESSION['user_type_id'], $cargos_admin);
}

/* mostrar el código argumentado si el usuario actual es administrador */
function mostrarSiAdmin($codigo){
    if(esAdmin()){
      echo $codigo;
    }else{
      return '';
    }
}
