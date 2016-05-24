<?php
class Conexion extends mysqli {

    public function __construct() {
        parent::__construct('100.100.20.102', 'root', 'mrbooks', 'mrbookspac');
        $this->query("SET NAMES 'utf8';");
        $this->connect_errno ? die('Error con la conexion') : $x = 'Conecado';        
        
    }    
}

