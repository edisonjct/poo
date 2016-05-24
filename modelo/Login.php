<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conexion.php';

class Login extends Conexion {
     public function __construct() { 
        parent::__construct(); 
    } 
    
    public function ValidarUsuario($nombre) {
        $db = new Conexion();
        $result = $db->query("SELECT * FROM usuario WHERE Usuario='$nombre'");        
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        return $usuarios;
        mysqli_close($db);       
    }
    
    
}

