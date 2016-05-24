<?php
require_once '../modelo/Ventas.php';
$bodega = $_GET['bodega'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$funciones = new Ventas();
$grupo = '';


if($bodega == 'TODOS'){
    $vaciartabla = $funciones->VaciarTmpVentas();
    $recuperarventas = $funciones->LlenarVentas($desde, $hasta);
    $recuperardevoluciones = $funciones->LlenarDevoluciones($desde, $hasta);
    $ventasdiaria = $funciones->BuscaVentasDiaria($desde, $hasta);
    echo '<table class="table table-striped table-condensed table-hover">         
        <tr><th>BODEGA</th><th>TIPO</th><th># DOCUEMENTOS</th><th>LIBROS</th> 
          <th>VENTA</th><th>COSTO</th><th>MARGEN</th></tr>';   
    foreach ($ventasdiaria as $row) {
    $grupoant = $grupo;
    $grupo = $row['bodega'];
    if ($grupoant != $grupo) {
        echo '<tr><th colspan="7">' . $row["bodega"] . '</th></tr>';
    }
    echo '<tr>
                    <td></td>
                    <td>' . $row["tipo"] . '</td>
                    <td>' . number_format($row["documentos"]) . '</td>
                    <td>' . number_format($row["libros"]) . '</td>
                    <td>' . number_format($row["ventas"], 2, '.', ',') . '</td>
                    <td>' . number_format($row["costos"], 2, '.', ',') . '</td>
                    <td>' . number_format($row["margen"], 2, '.', ',') . '</td>
                </tr>';    
}                      
echo '</table>';
} else {
    $vaciartabla = $funciones->VaciarTmpVentas();
    $recuperarventas = $funciones->LlenarVentasBodega($bodega, $desde, $hasta);
    $recuperardevoluciones = $funciones->LlenarDevolucionesBodega($bodega, $desde, $hasta);
    $ventasdiariabodega = $funciones->BuscaVentasDiariaBodegas($bodega, $desde, $hasta);
    echo '<table class="table table-striped table-condensed table-hover">         
        <tr><th>BODEGA</th><th>TIPO</th><th># DOCUEMENTOS</th><th>LIBROS</th> 
          <th>VENTA</th><th>COSTO</th><th>MARGEN</th></tr>';   
    foreach ($ventasdiariabodega as $row) {
    $grupoant = $grupo;
    $grupo = $row['bodega'];
    if ($grupoant != $grupo) {
        echo '<tr><th colspan="7">' . $row["bodega"] . '</th></tr>';
    }
    echo '<tr>
                    <td></td>
                    <td>' . $row["tipo"] . '</td>
                    <td>' . number_format($row["documentos"]) . '</td>
                    <td>' . number_format($row["libros"]) . '</td>
                    <td>' . number_format($row["ventas"], 2, '.', ',') . '</td>
                    <td>' . number_format($row["costos"], 2, '.', ',') . '</td>
                    <td>' . number_format($row["margen"], 2, '.', ',') . '</td>
                </tr>';    
}                      
echo '</table>';;
}



