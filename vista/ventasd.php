<?php
require_once '../modelo/Bodegas.php';
include_once '../modelo/db_config.php';

$bodega = new Bodegas();
$llenarbodgas = $bodega->LlenaBdegasActivas();
?>  
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
    </br>
    <div class="table-responsive" id="agrega-registros"></div>        

