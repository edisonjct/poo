<?php

require_once 'Conexion.php';

/**
 * Description of Bodegas
 *
 * @author EChulde
 */
class Bodegas extends Conexion{
    
    public function __construct() { 
        parent::__construct(); 
    } 
    
    public function ObtenerBodegas($nombre) {        
        $db = new Conexion();
        $re = $db->query("SELECT * FROM bodegas where nombre = '$nombre'");
        $bodegas = $re->fetch_all(MYSQLI_ASSOC);
        return $bodegas;
        mysqli_close($db);        
    }
    
    public function LlenaBdegasActivas() {
        $db = new Conexion();
        $result = $db->query("SELECT * FROM bodegas where estado = '1' ORDER BY orden");        
        $bodegas = $result->fetch_all(MYSQLI_ASSOC);
        return $bodegas;
        mysqli_close($db);        
    }
}
