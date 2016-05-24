<?php
require_once '../modelo/Bodegas.php';
$bodega = $_GET['bodega'];
$funciones = new Bodegas();
$usuarios = $funciones->ObtenerBodegas();
echo '<table class="table table-striped table-condensed table-hover">
        <tr><th>NOMBRE</th><th>USUARIO</th></tr>';
foreach ($usuarios as $row) {
    echo '<tr><td>' . $row['numdoc'] . '</td><td>' . $row['documento'] . '</td>
         </tr>';
}
echo '</table>';

