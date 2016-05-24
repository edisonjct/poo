<?php
session_start();

require_once '../modelo/Conexion.php';

if (isset($_POST['btn-login'])) {
    //$user_name = $_POST['user_name'];
    $user = trim($_POST['user']);
    $user_password = trim($_POST['password']);
    $password = md5($user_password);
    try {
        $db = new Conexion();
        $result = $db->query("SELECT * FROM usuario WHERE Usuario='$user'");        
        $row = mysqli_fetch_array($result);         
        if($row['Contrasena'] == $password) {
            echo "ok";
            $_SESSION['user_session'] = $row['Usuario'];
        } else {
            echo "Usuario o Contraseña Incorectas";
        }     
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }      
}




