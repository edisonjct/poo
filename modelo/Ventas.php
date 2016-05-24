<?php

/**
 * Description of Ventas
 *
 * @author EChulde
 */
require_once 'Conexion.php';

class Ventas extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function BuscaVentasCantidad($bodega, $desde, $hasta) {
        $db = new Conexion();
        $result = $db->query("");
        $ventascantidad = $result->fetch_all(MYSQLI_ASSOC);
        return $ventascantidad;
    }

    public function VaciarTmpVentas() {
        $db = new Conexion();
        $result = $db->query("TRUNCATE tmpventas");
        $vaciatmpventa = $result;
        return $vaciatmpventa;
    }

    public function LlenarVentas($desde, $hasta) {
        $db = new Conexion();
        $result = $db->query("INSERT INTO  tmpventas(tipo,bodega,documento,numdoc,numlibros,venta,costo,fecha,grupo) SELECT
            d.TIPOTRA03 AS tipo,
            d.bodega AS bodega,
            d.NOCOMP03 AS docuemnto,
            count(distinct d.NOCOMP03) AS FACTURAS,
            Sum(d.CANTID03) AS LIBROS,
            round(sum(((d.PRECVTA03 - d.DESCVTA03) - d.desctotvta03)),2) AS VENTA,
            Sum(d.VALOR03) AS COSTO,
            d.FECMOV03 AS fecha,
            bodegas.orden as grupo
            FROM
            factura_detalle AS d
            INNER JOIN factura_cabecera ON d.NOCOMP03 = factura_cabecera.nofact31
            INNER JOIN bodegas ON d.bodega = bodegas.nombre
            where ((d.TIPOTRA03 = '80') and (factura_cabecera.cvanulado31 <> '9')) AND 
            d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
            group by d.NOCOMP03,d.bodega");
        $llenaventas = $result;
        return $llenaventas;
    }
    
    public function LlenarVentasBodega($bodega,$desde, $hasta) {
        $db = new Conexion();
        $result = $db->query("INSERT INTO  tmpventas(tipo,bodega,documento,numdoc,numlibros,venta,costo,fecha,grupo) SELECT
            d.TIPOTRA03 AS tipo,
            d.bodega AS bodega,
            d.NOCOMP03 AS docuemnto,
            count(distinct d.NOCOMP03) AS FACTURAS,
            Sum(d.CANTID03) AS LIBROS,
            round(sum(((d.PRECVTA03 - d.DESCVTA03) - d.desctotvta03)),2) AS VENTA,
            Sum(d.VALOR03) AS COSTO,
            d.FECMOV03 AS fecha,
            bodegas.orden as grupo
                FROM
            factura_detalle AS d
            INNER JOIN factura_cabecera ON d.NOCOMP03 = factura_cabecera.nofact31
            INNER JOIN bodegas ON d.bodega = bodegas.nombre
            where ((d.TIPOTRA03 = '80') and (factura_cabecera.cvanulado31 <> '9')) AND 
            d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND d.bodega = '$bodega'
            group by d.NOCOMP03,d.bodega");
        $llenaventas = $result;
        return $llenaventas;
    }
    

    public function LlenarDevoluciones($desde, $hasta) {
        $db = new Conexion();
        $result = $db->query("INSERT INTO  tmpventas(tipo,bodega,documento,numdoc,numlibros,venta,costo,fecha,grupo) SELECT
            d.TIPOTRA03 AS tipo,
            d.bodega AS bodega,
            d.NOCOMP03 AS docuemnto,
            COUNT(DISTINCT d.NOCOMP03) AS NOTAS,
            Sum(d.CANTID03) AS LIBROS,
            ROUND((SUM(PRECVTA03-DESCVTA03-desctotvta03)),2) AS VENTA,
            Sum(d.VALOR03) AS COSTO,
            d.FECMOV03 AS fecha,
            bodegas.orden as grupo
            FROM
            factura_detalle AS d
            INNER JOIN bodegas ON d.bodega = bodegas.nombre
            WHERE
            d.TIPOTRA03 = '22' AND d.cvanulado03 = 'N' AND
            d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
            group by d.NOCOMP03,d.bodega");
        $llenaventas = $result;
        return $llenaventas;
    }
    
    public function LlenarDevolucionesBodega($bodega,$desde, $hasta) {
        $db = new Conexion();
        $result = $db->query("INSERT INTO  tmpventas(tipo,bodega,documento,numdoc,numlibros,venta,costo,fecha,grupo) SELECT
            d.TIPOTRA03 AS tipo,
            d.bodega AS bodega,
            d.NOCOMP03 AS docuemnto,
            COUNT(DISTINCT d.NOCOMP03) AS NOTAS,
            Sum(d.CANTID03) AS LIBROS,
            ROUND((SUM(PRECVTA03-DESCVTA03-desctotvta03)),2) AS VENTA,
            Sum(d.VALOR03) AS COSTO,
            d.FECMOV03 AS fecha,
            bodegas.orden as grupo
                FROM
            factura_detalle AS d
            INNER JOIN bodegas ON d.bodega = bodegas.nombre
            WHERE
            d.TIPOTRA03 = '22' AND d.cvanulado03 = 'N' AND
            d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND d.bodega = '$bodega'
            group by d.NOCOMP03,d.bodega");
        $llenaventas = $result;
        return $llenaventas;
    }

    public function BuscaVentasDiariaBodegas($bodega, $desde, $hasta) {
        $db = new Conexion();
        $result = $db->query("SELECT
        CASE WHEN t.tipo = '80' THEN 'FACTURAS' ELSE 'DEVOLUCION' END AS tipo,
        t.bodega as bodega,
        sum(t.numdoc) as documentos,
        sum(t.numlibros) as libros,
        sum(t.venta) as ventas,
        sum(t.costo) as costos,
        sum(t.venta) - sum(t.costo) as margen,
        t.grupo as grupo
            FROM
        tmpventas t
        WHERE t.fecha BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND t.bodega = '$bodega'
        GROUP BY t.bodega,t.tipo ORDER BY t.grupo,t.tipo DESC");
        $ventasdiaria = $result->fetch_all(MYSQLI_ASSOC);
        return $ventasdiaria;
    }

    public function BuscaVentasDiaria($desde, $hasta) {
        $db = new Conexion();
        $result = $db->query("SELECT
        CASE WHEN t.tipo = '80' THEN 'FACTURAS' ELSE 'DEVOLUCION' END AS tipo,
        t.bodega as bodega,
        sum(t.numdoc) as documentos,
        sum(t.numlibros) as libros,
        sum(t.venta) as ventas,
        sum(t.costo) as costos,
        sum(t.venta) - sum(t.costo) as margen,
        t.grupo as grupo
            FROM
        tmpventas t
        WHERE t.fecha BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
        GROUP BY t.bodega,t.tipo ORDER BY t.grupo,t.tipo DESC");
        $ventasdiaria = $result->fetch_all(MYSQLI_ASSOC);
        return $ventasdiaria;
    }

}
