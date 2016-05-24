<?php
session_start();
if (!isset($_SESSION['user_session'])) {
    header("Location: ../index.php");
}

require_once '../modelo/Bodegas.php';
include_once '../modelo/db_config.php';

$bodega = new Bodegas();

$llenarbodgas = $bodega->LlenaBdegasActivas();
$stmt = $db_con->prepare("SELECT * FROM usuario WHERE Usuario=:uid");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$perfil = $row['Tipo'];
$nombre = $row['Nombre'];
?>
<html lang="en">
    <head>
        <title>RENTABILIDAD</title>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="../img/icono.ico"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <script src="../js/jquery.js"></script>
        <script src="../js/funciones.js"></script>
        <link href="../css/bootstrap.css" rel="stylesheet">
    </head>
    <body>
        <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand" id="logo"></a>
            </div>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Bienvenido <?php echo $nombre ?> <b class="caret"></b></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="../controlador/CerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesion</a></li>
                        </ul>
                    </li>                                        
                </ul>               
                <?php
                $db = new Conexion();
                $menu = $db->query("SELECT menusuario.UsuarioTipo_id as perfil,menusuario.Menu_id as id,menu.Nombre as nombre, menu.Url as url FROM menusuario INNER JOIN menu ON menusuario.Menu_id = menu.id WHERE UsuarioTipo_id = '$perfil' and Padre >= '1'");
                foreach ($menu as $row) {
                    echo '<ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">' . $row['nombre'] . '<b class="caret"></b></a   >';
                    $submenu = $db->query("SELECT menusuario.UsuarioTipo_id as perfil,menu.Submenu as submenu,menusuario.Menu_id as id,menu.Nombre as nombre,menu.Url as url FROM menusuario INNER JOIN menu ON menusuario.Menu_id = menu.id WHERE UsuarioTipo_id = '$perfil' and Padre < '1' AND submenu = '" . $row['id'] . "'");
                    echo '<ul role="menu" class="dropdown-menu">';
                    foreach ($submenu as $row2) {
                        echo '<li><a href="' . $row2['url'] . '">' . $row2['nombre'] . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</li></ul>';
                }
                ?>                                                                                             
            </div>
        </nav>
        </br></br>
        </br></br>
        <form class="form-inline" role="form" method="GET" id="busqueda">
            <center>
                <div class="form-group">
                    <select required="required" id="cb-bodega" class="form-control">
                        <option value="TODOS">TODOS</option>
                        <?php
                        foreach ($llenarbodgas as $row) {
                            echo '<option value=' . $row['nombre'] . '>' . $row['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Desde</label>
                    <input type="date" class="form-control" id="bd-desde" name="desde" />
                </div>
                <div class="form-group">
                    <label>Hasta</label>
                    <input type="date" class="form-control" id="bd-hasta" name="hasta" />
                </div>
                <button id="bt-ventadiaria" class="btn btn-primary">Buscar</button>
                <a data-toggle="tooltip" title="Hooray!" target="_blank" href="javascript:reporteventasd();" class="btn btn-success">Excel</a>
            </center>
        </form>
        </br>
        <div class="table-responsive" id="agrega-registros"></div>
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
