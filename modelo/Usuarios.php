<?php

/**
 * @author Edison
 * @copyright 2016
 */

require_once 'Conexion.php';

class Usuarios extends Conexion {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function GetUsuariLogin($nombre) {
        $db = new Conexion();
        $result = $db->query("Select * from usuario where Usuario = '$nombre'");
        $usuariologin = $result->fetch_all(MYSQLI_ASSOC);
        return $usuariologin;
        mysqli_close($db); 
    }
}


?>