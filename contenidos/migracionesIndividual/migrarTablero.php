<?php

/*
 * Clase que permite validar los documento o formularios en  un estado 
 */

function obternerDocumentos($lineas, $db, $code, $estadoV, $estadoT) {
    $arrDocumentosArchivo = Array();
    $nombreArchivo = $_FILES['archivo']['tmp_name'];
    foreach ($lineas as $linea_num => $linea) {
        array_push($arrDocumentosArchivo, trim($linea));
    }
    $separado_por_comas = implode(",", $arrDocumentosArchivo);
    $val = validarDocumentos2($separado_por_comas, $db, $code, $estadoV, $estadoT);
    return $val;
}

function validarDocumentos($separado_por_comas, $db, $code, $estadoV, $estadoT) {
    global $db;
    $band = true;
    $msg = "";
    // Está consulta válida que los números de los documentos pertenezcan al postulante principal
    //Está consulta válida que los números no tengán un estado diferente al estado proceso
    $sql = "SELECT seqFormulario FROM t_frm_formulario frm                            
                            WHERE seqEstadoProceso NOT IN(" . $estadoV . ")
                            and frm.seqFormulario IN(" . $separado_por_comas . ")";
    $resultados = $db->get_results($sql);
    $rows = count($resultados);
    if ($rows > 0) {
        $val = "<b>Los siguientes formulario no tienen el estado de " . $estadoT . "</b><br>";
        foreach ($resultados as $value) {
            $val .= "<br>" . $value->seqFormulario . ".";
        }
        $val .= " <br><br> Por favor verifique los datos del hogar ";
        $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
        $band = false;
        if (!$band) {
            echo $msg;
            die();
        }
    }

    return $band;
}

function validarDocumentos2($separado_por_comas, $db, $code, $estadoV, $estadoT) {
    global $db;
    $band = true;
    $msg = "";
    // Está consulta válida que los números de los documentos pertenezcan al postulante principal
    $sql = "SELECT numdocumento, seqProyecto FROM t_frm_formulario
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            WHERE seqParentesco NOT IN(1) 
                            and numDocumento IN(" . $separado_por_comas . ")";
    $resultados = $db->get_results($sql);
    $rows = count($resultados);
    if ($rows > 0) {
        $val = "<b>Los siguientes documentos no se encuentran registrados como postulante principal</b><br>";
        foreach ($resultados as $value) {
            $val .= "<br>" . $value->numdocumento . ".";
        }
        $val .= " <br><br> Por favor verifique los datos del hogar ";
        $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
        $band = false;
        if (!$band) {
            echo $msg;
            die();
        }
    } else if ($band) {
        global $db;
        //Está consulta válida que los números no tengán un estado diferente al estado proceso
        $sql = "SELECT numdocumento, seqProyecto FROM t_frm_formulario
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            WHERE seqEstadoProceso NOT IN(" . $estadoV . ")
                            and numDocumento IN(" . $separado_por_comas . ")";
        $resultados = $db->get_results($sql);
        $rows = count($resultados);
        if ($rows > 0) {
            $val = "<b>Los siguientes documentos no tienen el estado de " . $estadoT . "</b><br>";
            foreach ($resultados as $value) {
                $val .= "<br>" . $value->numdocumento . ".";
            }
            $val .= " <br><br> Por favor verifique los datos del hogar ";
            $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
            $band = false;
            if (!$band) {
                echo $msg;
                die();
            }
        }
    }
    return $band;
}

function migrarInformacion($separado_por_comas, $db, $code, $estadoV) {
    global $db;
    if (empty($_SESSION['seqUsuario'])) {
        session_start();
    }

    $datos = datosEstado($separado_por_comas, $db, $code, $estadoV);
    $sql = $datos[0];

    $resultados = $db->get_results($sql);
    $rows = count($resultados);
    $documentos = "";
    $cont = 0;
    if ($rows > 0) {
        $update = "UPDATE t_frm_formulario SET seqEstadoProceso = CASE seqFormulario";
        $updateProy = $datos[1];
        $seguimiento = "INSERT INTO T_SEG_SEGUIMIENTO ( 
				seqFormulario, 
				fchMovimiento, 
				seqUsuario, 
				txtComentario,				
				numDocumento,
                                txtNombre,
				seqGestion,
                                bolMostrar
			 ) VALUES";
        $seqFormularios = "";

        foreach ($resultados as $value) {
            $update .= " WHEN " . $value->dato . " THEN " . $code . "";
            $updateProy .= " WHEN " . $value->dato . " THEN NOW()";
            $seguimiento .= "(
				" . $value->dato . ",
				now(),
				" . $_SESSION['seqUsuario'] . ",
				\"" . $datos[3] . "\",
				" . $value->numDocumento . ",
                                    '" . $value->nombre . "',
				" . $datos[2] . ",
                                 1
			 ),";
            $seqFormularios .= $value->dato . ", ";
            $documentos .= $value->numDocumento . ",";
            $cont++;
        }
        $seqFormularios = substr_replace($seqFormularios, '', -2, 1);
        $documentos = substr_replace($documentos, '', -1, 1);
        if (!empty($seguimiento)) {
            $seguimiento = substr_replace($seguimiento, ';', -1, 1);
        }
        $update .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";
        $updateProy .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";

        if ($db->query($update)) {
            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de estado de los siguientes documentos"
            . $documentos . "</p>";
        }
        if ($db->query($updateProy)) {
            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de la fecha  de radicaci&oacute;n de los siguientes documentos"
            . $documentos . "</p>";
        }
        if ($db->query($seguimiento)) {
            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la inserci&oacute;n de seguimiento de los siguientes documentos";
        }
    }
}

function datosEstado($separado_por_comas, $db, $code, $estadoV) {
    global $db;
    $datos = Array();
    if ($code == 27) {
        $datos[0] = "SELECT seqFormulario as dato, numDocumento, 
                    CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                            FROM t_frm_formulario frm
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                    
                            WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                            AND frm.seqFormulario IN(" . $separado_por_comas . ")";

        $datos[1] = "UPDATE t_des_desembolso SET fchCreacionBusquedaOferta = CASE seqFormulario";
        $datos[2] = 63;
        $datos[3] = "CARGUE INFORMACION SOLUCION";
    }
    if ($code == 23) {
        $datos[0] = "SELECT seqFormulario as dato, numDocumento, 
                    CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                            FROM t_frm_formulario frm
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                    
                            WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                            AND frm.seqFormulario IN(" . $separado_por_comas . ")";

        $datos[1] = "UPDATE t_des_escrituracion SET fchCreacionEscrituracion = CASE seqFormulario";
        $datos[2] = 63;
        $datos[3] = "CARGUE DATOS ESCRITURACIÓN";
    }
    if ($code == 25) {
        $datos[0] = "SELECT seqFormulario as dato, numDocumento, 
                    CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                    FROM t_frm_formulario
                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                    
                    WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                    AND numDocumento IN(" . $separado_por_comas . ")";

        $datos[1] = "UPDATE t_des_tecnico tec LEFT JOIN t_des_desembolso des USING (seqDesembolso) SET tec.fchCreacion = CASE seqFormulario";
        $datos[2] = 63;
        $datos[3] = "ESTUDIO TECNICO DE UNIDAD PROYECTO";
    }
    if ($code == 28 || $code == 31) {
        $datos[0] = "SELECT seqFormulario as dato, numDocumento, 
                    CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                            FROM t_frm_formulario frm
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                    
                            WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                            AND frm.seqFormulario IN(" . $separado_por_comas . ")";

        $datos[1] = "UPDATE t_des_tecnico  tec INNER JOIN t_des_desembolso des USING (seqDesembolso)
                     inner join t_des_estudio_titulos tit using(seqDesembolso) SET tit.fchCreacion = CASE seqFormulario";
        $datos[2] = 16;
        $datos[3] = "CARGUE MASIVO ESTUDIO DE TITULOS";
    }

    if ($code == 40) {
        $datos[0] = "SELECT seqFormulario as dato, numDocumento, 
                    CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                    FROM t_frm_formulario
                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                    
                    WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                    AND numDocumento IN(" . $separado_por_comas . ")";

        $datos[1] = "UPDATE t_pry_unidad_proyecto SET fchLegalizacion  = CASE seqFormulario";
        $datos[2] = 45;
        $datos[3] = "SUBSIDIO LEGALIZADO. CUMPLE NUMERAL 4, ART. 5 DE RESOLUCION 575 DE 2015 (MODIFICA RES. 844 DE 2014)";
    }


    return $datos;
}

function migrarInformacion2($separado_por_comas, $db, $code, $estadoV) {

    global $db;
    $band = false;

    $datos = datosEstado($separado_por_comas, $db, $code, $estadoV);
    $sql = $datos[0];
    $resultados = $db->get_results($sql);
    $rows = count($resultados);
    $documentos = "";
    $cont = 0;
    if ($rows > 0) {
        $update = "UPDATE t_frm_formulario SET seqEstadoProceso = CASE seqFormulario";
        $updateProy = $datos[1];
        $seguimiento = "INSERT INTO T_SEG_SEGUIMIENTO ( 
				seqFormulario, 
				fchMovimiento, 
				seqUsuario, 
				txtComentario,				
				numDocumento,
                                txtNombre,
				seqGestion,
                                bolMostrar
			 ) VALUES";
        $seqFormularios = "";

        $seqFormularios = "";

        foreach ($resultados as $value) {
            $update .= " WHEN " . $value->dato . " THEN " . $code . "";
            $updateProy .= " WHEN " . $value->dato . " THEN NOW()";
            $seqFormularios .= $value->dato . ", ";
            $seguimiento .= "(
				" . $value->dato . ",
				now(),
				" . $_SESSION['seqUsuario'] . ",
				\"" . $datos[3] . "\",
				" . $value->numDocumento . ",
                                    '" . $value->nombre . "',
				" . $datos[2] . ",
                                 1
			 ),";
            $documentos .= $value->numDocumento . ",";
            $cont++;
        }
        $seqFormularios = substr_replace($seqFormularios, '', -2, 1);
        $documentos = substr_replace($documentos, '', -1, 1);

        if (!empty($seguimiento)) {
            $seguimiento = substr_replace($seguimiento, ';', -1, 1);
            $band = true;
        }

        $update .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";
        $updateProy .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";
        try {
            if ($db->query($update) !== false) {
                echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de estado de los siguientes documentos: "
                . $documentos . "</p>";
                $band = true;
            }
            if ($db->query($updateProy) !== false) {
                echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de la fecha  de radicaci&oacute;n de los siguientes documentos: "
                . $documentos . "</p>";
                $band = true;
            }
            if ($db->query($seguimiento) !== false) {
                $band = true;
                echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la inserci&oacute;n de seguimiento de los siguientes documentos: : "
                . $documentos . "</p>";
            }
        } catch (Exception $ex) {
            echo "<p>" . $ex->getMessage() . "<p>";
        }
    }

    return $band;
}
