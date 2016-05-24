<?php
require_once '../modelo/Bodegas.php';
$bodega = new Bodegas();
$llenarbodgas = $bodega->LlenaBdegasActivas();
foreach ($llenarbodgas as $row) {
echo '<option value='.$row['nombre'].'>'.$row['nombre'].'</option>';
}