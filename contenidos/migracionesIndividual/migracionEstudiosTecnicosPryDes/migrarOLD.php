<?php

include '../conecta.php';
include "generarConsolidado.php";
include "generarLinksImpresion.php";

date_default_timezone_set('America/Bogota');
$arrDocumentosArchivo = array();

//$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidios', 'localhost');

$camposTecnico = "numLargoMultiple, numAnchoMultiple, numAreaMultiple, txtMultiple, numLargoAlcoba1, numAnchoAlcoba1, numAreaAlcoba1, txtAlcoba1, numLargoAlcoba2, numAnchoAlcoba2, numAreaAlcoba2, txtAlcoba2, numLargoAlcoba3, numAnchoAlcoba3, numAreaAlcoba3, txtAlcoba3, numLargoCocina, numAnchoCocina, numAreaCocina, txtCocina, numLargoBano1, numAnchoBano1, numAreaBano1, txtBano1, numLargoBano2, numAnchoBano2, numAreaBano2, txtBano2, numLargoLavanderia, numAnchoLavanderia, numAreaLavanderia, txtLavanderia, numLargoCirculaciones, numAnchoCirculaciones, numAreaCirculaciones, txtCirculaciones, numLargoPatio, numAnchoPatio, numAreaPatio, txtPatio, numAreaTotal, txtEstadoCimentacion, txtCimentacion, txtEstadoPlacaEntrepiso, txtPlacaEntrepiso, txtEstadoMamposteria, txtMamposteria, txtEstadoCubierta, txtCubierta, txtEstadoVigas, txtVigas, txtEstadoColumnas, txtColumnas, txtEstadoPanetes, txtPanetes, txtEstadoEnchapes, txtEnchapes, txtEstadoAcabados, txtAcabados, txtEstadoHidraulicas, txtHidraulicas, txtEstadoElectricas, txtElectricas, txtEstadoSanitarias, txtSanitarias, txtEstadoGas, txtGas, txtEstadoMadera, txtMadera, txtEstadoMetalica, txtMetalica, numLavadero, txtLavadero, numLavaplatos, txtLavaplatos, numLavamanos, txtLavamanos, numSanitario, txtSanitario, numDucha, txtDucha, txtEstadoVidrios, txtVidrios, txtEstadoPintura, txtPintura, txtOtros, txtObservacionOtros, numContadorAgua, txtEstadoConexionAgua, txtDescripcionAgua, numContadorEnergia, txtEstadoConexionEnergia, txtDescripcionEnergia, numContadorAlcantarillado, txtEstadoConexionAlcantarillado, txtDescripcionAlcantarillado, numContadorGas, txtEstadoConexionGas, txtDescripcionGas, numContadorTelefono, txtEstadoConexionTelefono, txtDescripcionTelefono, txtEstadoAndenes, txtDescripcionAndenes, txtEstadoVias, txtDescripcionVias, txtEstadoServiciosComunales, txtDescripcionServiciosComunales, txtDescripcionVivienda, txtNormaNSR98, txtRequisitos, txtExistencia, txtDescipcionNormaNSR98, txtDescripcionRequisitos, txtDescripcionExistencia, fchVisita, txtAprobo, fchCreacion, fchActualizacion";
$camposAdjuntosTecnicos = "seqTipoAdjunto, txtNombreAdjunto, txtNombreArchivo";

if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $nombreArchivo = $_FILES['archivo']['tmp_name'];
    $lineas = file($nombreArchivo);
    foreach ($lineas as $linea_num => $linea) {
        array_push($arrDocumentosArchivo, trim($linea));
    }
} else {
    exit('debe seleccionar un archivo. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
}


$separado_por_comas = implode(",", $arrDocumentosArchivo);

//valida si el documento ya tiene un estudio tecnico 
//devuelve true si es posible migrar, false si hay algun con estudio.

function validarEstudioTecnico() {
    global $separado_por_comas;
    global $db;

    $sql = "SELECT t_des_tecnico.seqTecnico
  FROM (((sdht_subsidios.t_des_tecnico t_des_tecnico
          INNER JOIN sdht_subsidios.t_des_desembolso t_des_desembolso
             ON (t_des_tecnico.seqDesembolso = t_des_desembolso.seqDesembolso))
         INNER JOIN sdht_subsidios.t_frm_formulario t_frm_formulario
            ON (t_des_desembolso.seqFormulario =
                   t_frm_formulario.seqFormulario))
        INNER JOIN sdht_subsidios.t_frm_hogar t_frm_hogar
           ON (t_frm_hogar.seqFormulario = t_frm_formulario.seqFormulario))
       INNER JOIN sdht_subsidios.t_ciu_ciudadano t_ciu_ciudadano
          ON (t_frm_hogar.seqCiudadano = t_ciu_ciudadano.seqCiudadano)
 WHERE t_ciu_ciudadano.numDocumento IN ($separado_por_comas);";

    $db->get_results($sql);
    if ($db->num_rows > 0) {
        return false;
        //exit("Revise el contenido de las cedulas, una de estas ya tiene un estudio tecnico.");
    } else {
        //echo"listo para subida";
        return true;
    }
}

function obtenerValoresUtiles($documento, $campo) {
    $valor;
    $consulta_pre = "SELECT ciu.numDocumento AS numDocumento,
       des.seqDesembolso AS seqDesembolso,
       destec.seqTecnico AS seqTecnico,
       frm.txtFormulario AS txtFormulario,
       frm.seqFormulario AS seqFormulario,
       und.seqUnidadProyecto AS unidadseqUnidadProyecto,
       hog.seqParentesco AS seqParentesco,
       prytec.seqUnidadProyecto seqUnidadProyecto,
       und.txtNombreUnidad txtNombreUnidad,
       pry.txtNombreProyecto AS txtNombreProyecto
  FROM ((((((sdht_subsidios.t_pry_unidad_proyecto und
             INNER JOIN sdht_subsidios.t_frm_formulario frm
                ON (und.seqFormulario = frm.seqFormulario))
            INNER JOIN sdht_subsidios.t_frm_hogar hog
               ON (hog.seqFormulario = frm.seqFormulario))
           INNER JOIN sdht_subsidios.t_ciu_ciudadano ciu
              ON (hog.seqCiudadano = ciu.seqCiudadano))
          LEFT OUTER JOIN sdht_subsidios.t_des_desembolso des
             ON (des.seqFormulario = frm.seqFormulario))
         LEFT OUTER JOIN sdht_subsidios.t_des_tecnico destec
            ON (destec.seqDesembolso = des.seqDesembolso))
        INNER JOIN sdht_subsidios.t_pry_proyecto pry
           ON (und.seqProyecto = pry.seqProyecto))
       INNER JOIN sdht_subsidios.t_pry_tecnico prytec
          ON (prytec.seqUnidadProyecto = und.seqUnidadProyecto)
 WHERE (ciu.numDocumento IN ($documento));";
    global $db;

    $resultados = $db->get_results($consulta_pre);

    foreach ($resultados as $resultado) {
        $numDocumento = $resultado->numDocumento;
        $seqDesembolso = $resultado->seqDesembolso;
        $seqTecnico = $resultado->seqTecnico;
        $txtFormulario = $resultado->txtFormulario;
        $seqFormulario = $resultado->seqFormulario;
        $unidadseqUnidadProyecto = $resultado->unidadseqUnidadProyecto;
        $seqParentesco = $resultado->seqParentesco;
        $seqUnidadProyecto = $resultado->seqUnidadProyecto;
        $txtNombreUnidad = $resultado->txtNombreUnidad;
        $txtNombreProyecto = $resultado->txtNombreProyecto;
    }
    switch ($campo) {
        case "numDocumento":
            $valor = $numDocumento;
            break;
        case "seqDesembolso":
            $valor = $seqDesembolso;
            break;
        case 'seqTecnico':
            $valor = $seqTecnico;
            break;
        case 'txtFormulario':
            $valor = $txtFormulario;
            break;
        case 'seqFormulario':
            $valor = $seqFormulario;
            break;
        case 'unidadseqUnidadProyecto':
            $valor = $unidadseqUnidadProyecto;
            break;
        case 'seqParentesco':
            $valor = $seqParentesco;
            break;
        case 'seqUnidadProyecto':
            $valor = $seqUnidadProyecto;
            break;
        case 'txtNombreUnidad':
            $valor = $txtNombreUnidad;
            break;
        case 'txtNombreProyecto':
            $valor = $txtNombreProyecto;
            break;
    }
    return $valor;
}

if (validarEstudioTecnico()) {
    $registros = 0;
    $adjuntos = 0;
    foreach ($arrDocumentosArchivo as $linea_doc => $documento) {
        $seqDesembolso = obtenerValoresUtiles($documento, "seqDesembolso");
        $seqUnidadProyecto = obtenerValoresUtiles($documento, "seqUnidadProyecto");

        $sqlTecnico = "INSERT INTO T_DES_TECNICO (seqDesembolso, $camposTecnico)
						SELECT '$seqDesembolso', $camposTecnico
						FROM t_pry_tecnico
						WHERE  seqTecnicoUnidad = $seqUnidadProyecto;";
        if ($db->query($sqlTecnico)) {
            $seqTecnico = $db->insert_id;

            $sqlAdjuntosTecnicos = "INSERT INTO t_des_adjuntos_tecnicos (seqTecnico, $camposAdjuntosTecnicos)
						SELECT '$seqTecnico', $camposAdjuntosTecnicos
						FROM t_pry_adjuntos_tecnicos
						WHERE  seqTecnicoUnidad = $seqUnidadProyecto;";
            if (!$db->query($sqlAdjuntosTecnicos)) {
                echo "no se pudo insertar el registro por favor contacte al admn";
            }
        } else {
            echo "no se pudo insertar el registro por favor contacte al admn";
        }
        $registros++;
    }

    echo "se han migrado $registros estudios tecnicos";

    //generarLinksImpresion($separado_por_comas);
} else {
    echo "ya hay una cedula";
}

