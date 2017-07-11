<?php

/**
 * RETORNA EL CONTENIDO DE LOS COMBOS DE
 * TIPO DE SOLUCION
 * PROYECTOS
 * CONJUNTOS RESIDENCIALES
 * UNIDAD RESIDENCIAL
 * DIRECCION DE SOLUCION
 * MATRICULA INMOBILIARIA
 * CHIP
 * @author Bernardo Zerda
 * @version 1.0 Mayo de 2017
 */

$txtPrefijoRuta = "../../";

include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

//pr($_POST);

switch( $_POST['modo'] ){
    case "modalidad":

        // solucion
        $arrSolucion = obtenerSolucion($_POST['seqModalidad']);
        $arrDatosPostulacion['solucion'][0]['valor'] = 1;
        $arrDatosPostulacion['solucion'][0]['texto'] = "NINGUNA";
        $i = 1;
        foreach($arrSolucion as $seqSolucion => $txtSolucion){
            $arrDatosPostulacion['solucion'][$i]['valor'] = $seqSolucion;
            $arrDatosPostulacion['solucion'][$i]['texto'] = $txtSolucion;
            $i++;
        }

        // esquema
        $arrTipoEsquemas = obtenerTipoEsquema($_POST['seqModalidad'], $_POST['seqPlanGobierno']);
        $arrDatosPostulacion['esquema'][0]['valor'] = 0;
        $arrDatosPostulacion['esquema'][0]['texto'] = "NINGUNO";
        $i = 1;
        foreach($arrTipoEsquemas as $seqTipoEsquema => $txtTipoEsquema){
            $arrDatosPostulacion['esquema'][$i]['valor'] = $seqTipoEsquema;
            $arrDatosPostulacion['esquema'][$i]['texto'] = $txtTipoEsquema;
            $i++;
        }

        // proyectos
        $arrProyectos = obtenerProyectosPostulacion($_POST['seqFormulario'],$_POST['seqModalidad'],$_POST['seqTipoEsquema'],$_POST['seqPlanGobierno']);
        $arrDatosPostulacion['proyecto'][0]['valor'] = 37;
        $arrDatosPostulacion['proyecto'][0]['texto'] = "NINGUNO";
        $i = 1;
        foreach($arrProyectos as $seqProyecto => $txtProyecto){
            $arrDatosPostulacion['proyecto'][$i]['valor'] = $seqProyecto;
            $arrDatosPostulacion['proyecto'][$i]['texto'] = $txtProyecto;
            $i++;
        }

        // conjuntos
        $arrDatosPostulacion['conjuntos'][0]['valor'] = 0;
        $arrDatosPostulacion['conjuntos'][0]['texto'] = "NINGUNO";

        // unidades
        $arrDatosPostulacion['unidades'][0]['valor'] = 1;
        $arrDatosPostulacion['unidades'][0]['texto'] = "NINGUNA";

        // direccion
        $arrDatosPostulacion['direccion'] = "";

        // matricula
        $arrDatosPostulacion['matricula'] = "";

        // chip
        $arrDatosPostulacion['chip']      = "";

        break;
    case "esquema";

        // proyectos
        $arrProyectos = obtenerProyectosPostulacion($_POST['seqFormulario'],$_POST['seqModalidad'],$_POST['seqTipoEsquema'],$_POST['seqPlanGobierno']);
        $arrDatosPostulacion['proyecto'][0]['valor'] = 37;
        $arrDatosPostulacion['proyecto'][0]['texto'] = "NINGUNO";
        $i = 1;
        foreach($arrProyectos as $seqProyecto => $txtProyecto){
            $arrDatosPostulacion['proyecto'][$i]['valor'] = $seqProyecto;
            $arrDatosPostulacion['proyecto'][$i]['texto'] = $txtProyecto;
            $i++;
        }

        // conjuntos
        $arrDatosPostulacion['conjuntos'][0]['valor'] = 0;
        $arrDatosPostulacion['conjuntos'][0]['texto'] = "NINGUNO";

        // unidades
        $arrDatosPostulacion['unidades'][0]['valor'] = 1;
        $arrDatosPostulacion['unidades'][0]['texto'] = "NINGUNA";

        // direccion
        $arrDatosPostulacion['direccion'] = "";

        // matricula
        $arrDatosPostulacion['matricula'] = "";

        // chip
        $arrDatosPostulacion['chip']      = "";

        break;
    case "proyecto":

        // conjuntos
        $arrProyectosHijos = obtenerProyectosHijosPostulacion($_POST['seqFormulario'],$_POST['seqModalidad'],$_POST['seqPlanGobierno'],$_POST['seqProyecto']);
        $arrDatosPostulacion['conjuntos'][0]['valor'] = 0;
        $arrDatosPostulacion['conjuntos'][0]['texto'] = "NINGUNO";
        $i = 1;
        foreach($arrProyectosHijos as $seqProyecto => $txtProyecto){
            $arrDatosPostulacion['conjuntos'][$i]['valor'] = $seqProyecto;
            $arrDatosPostulacion['conjuntos'][$i]['texto'] = $txtProyecto;
            $i++;
        }

        // unidades
        $arrDatosPostulacion['unidades'][0]['valor'] = 1;
        $arrDatosPostulacion['unidades'][0]['texto'] = "NINGUNA";
        $arrUnidadProyecto = obtenerUnidadesPostulacion($_POST['seqFormulario'],$_POST['seqModalidad'],$_POST['seqPlanGobierno'],$_POST['seqProyecto']);
        $i = 1;
        foreach($arrUnidadProyecto as $seqUnidad => $txtUnidad){
            $arrDatosPostulacion['unidades'][$i]['valor'] = $seqUnidad;
            $arrDatosPostulacion['unidades'][$i]['texto'] = $txtUnidad;
            $i++;
        }

        $arrDatosProyecto = obtenerDatosTabla(
            "t_pry_proyecto",
            array("seqProyecto","txtDireccion","txtChipLote","txtMatriculaInmobiliariaLote"),
            "seqProyecto",
            "seqProyecto = " . $_POST['seqProyecto']
        );

        // direccion
        $arrDatosPostulacion['direccion'] = $arrDatosProyecto[$_POST['seqProyecto']]['txtDireccion'];

        // matricula
        $arrDatosPostulacion['matricula'] = $arrDatosProyecto[$_POST['seqProyecto']]['txtMatriculaInmobiliariaLote'];

        // chip
        $arrDatosPostulacion['chip']      = $arrDatosProyecto[$_POST['seqProyecto']]['txtChipLote'];

        break;
    case "conjuntos":

        // unidades
        $arrDatosPostulacion['unidades'][0]['valor'] = 1;
        $arrDatosPostulacion['unidades'][0]['texto'] = "NINGUNA";
        $arrUnidadProyecto = obtenerUnidadesPostulacion($_POST['seqFormulario'],$_POST['seqModalidad'],$_POST['seqPlanGobierno'],$_POST['seqProyectoHijo']);
        $i = 1;
        foreach($arrUnidadProyecto as $seqUnidad => $txtUnidad){
            $arrDatosPostulacion['unidades'][$i]['valor'] = $seqUnidad;
            $arrDatosPostulacion['unidades'][$i]['texto'] = $txtUnidad;
            $i++;
        }

        break;
    case "inscripcion":

        // solucion
        $arrSolucion = obtenerSolucion($_POST['seqModalidad']);
        $arrDatosPostulacion['solucion'][0]['valor'] = 1;
        $arrDatosPostulacion['solucion'][0]['texto'] = "NINGUNA";
        $i = 1;
        foreach($arrSolucion as $seqSolucion => $txtSolucion){
            $arrDatosPostulacion['solucion'][$i]['valor'] = $seqSolucion;
            $arrDatosPostulacion['solucion'][$i]['texto'] = $txtSolucion;
            $i++;
        }

        break;
    case "actualizacion":

        // solucion
        $arrSolucion = obtenerSolucion($_POST['seqModalidad']);
        $arrDatosPostulacion['solucion'][0]['valor'] = 1;
        $arrDatosPostulacion['solucion'][0]['texto'] = "NINGUNA";
        $i = 1;
        foreach($arrSolucion as $seqSolucion => $txtSolucion){
            $arrDatosPostulacion['solucion'][$i]['valor'] = $seqSolucion;
            $arrDatosPostulacion['solucion'][$i]['texto'] = $txtSolucion;
            $i++;
        }

        // esquema
        $arrTipoEsquemas = obtenerTipoEsquema($_POST['seqModalidad'], $_POST['seqPlanGobierno']);
        $arrDatosPostulacion['esquema'][0]['valor'] = 0;
        $arrDatosPostulacion['esquema'][0]['texto'] = "NINGUNO";
        $i = 1;
        foreach($arrTipoEsquemas as $seqTipoEsquema => $txtTipoEsquema){
            $arrDatosPostulacion['esquema'][$i]['valor'] = $seqTipoEsquema;
            $arrDatosPostulacion['esquema'][$i]['texto'] = $txtTipoEsquema;
            $i++;
        }

        break;
}

$txtJson = json_encode($arrDatosPostulacion);
echo $txtJson;

?>