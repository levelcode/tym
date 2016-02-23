<?php
namespace App\DB;
function conectar() {
    try {
      $_SERVER["DB_DB"] = isset($_SERVER["DB_DB"]) ? $_SERVER["DB_DB"] : "bocetos_tym";
      $_SERVER["DB_USER"] = isset($_SERVER["DB_USER"]) ? $_SERVER["DB_USER"] : "root";
      $_SERVER["DB_PASS"] = isset($_SERVER["DB_PASS"]) ? $_SERVER["DB_PASS"] : "srg789sd";
      $_SERVER["DB_HOST"] = isset($_SERVER["DB_HOST"]) ? $_SERVER["DB_HOST"] : "190.146.2.30";
        $conn = new \PDO('mysql:host='.$_SERVER["DB_HOST"].';dbname='.$_SERVER["DB_DB"].';charset=utf8', $_SERVER["DB_USER"], $_SERVER["DB_PASS"]);
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $conn; ##Retornar la conexion si tiene exito
    } catch (\PDOException $e) {
        return false;
    }
}
function query($query, $parametros, $conexion) {
    $preparacion = $conexion->prepare($query);
    $preparacion->execute($parametros);
    $resultados = $preparacion->fetchAll(\PDO::FETCH_ASSOC);
    return $resultados;
}
