<?php
include_once "../lib/mysqli/shared/ez_sql_core.php";
include_once "../lib/mysqli/ez_sql_mysqli.php";

$observacion1 = 'PROPIETARIOS SON BENEFICIARIOS DEL SDV';
$observacion2 = 'ESTADO CIVIL COINCIDENTE';
$observacion3 = 'CONSTITUCIÓN PATRIMONIO DE FAMILIA';
$observacion4 = 'RESTRICCIONES';
$observacion5 = 'PATRIMONIO DE FAMILIA REGISTRADO';
$observacion6 = 'NOMBRE Y CÉDULA DE LOS PROPIETARIOS';
$observacion7 = 'COMPRAVENTA REALIZADA CON SDV';
$documentos1 = 'ESCRITURA PÚBLICA';
$documentos2 = 'FOLIO DE MATRÍCULA INMOBILIARIA';
$documentos3 = 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD VIABILIZADO';

$campos = "INSERT INTO T_DES_ESTUDIO_TITULOS(seqDesembolso,
                                  numEscrituraIdentificacion,
                                  fchEscrituraIdentificacion,
                                  numNotariaIdentificacion,
                                  numEscrituraTitulo,
                                  fchEscrituraTitulo,
                                  numNotariaTitulo,
                                  numFolioMatricula,
                                  txtZonaMatricula,
                                  fchMatricula,
                                  bolSubsidioSDHT,
                                  bolSubsidioFonvivienda,
                                  numResolucionFonvivienda,
                                  numAnoResolucionFonvivienda,
                                  txtAprobo,
                                  fchCreacion,
                                  fchActualizacion,
                                  txtCiudadTitulo,
                                  txtCiudadIdentificacion,
                                  txtCiudadMatricula,
                                  txtElaboro) VALUES ";

if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $nombreArchivo = $_FILES['archivo']['tmp_name'];
    $lineas = file($nombreArchivo);
    $registros = 0;
    //$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive', 'localhost');
	$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive_feb10', 'localhost');
    foreach ($lineas as $linea_num => $linea) {
        $datos = explode("\t", $linea);

        $seqDesembolso = obtenerDesembolso(trim($datos [0]));
        $numEscrituraIdentificacion = trim($datos [10]);
        $fchEscrituraIdentificacion = trim($datos [11]);
        $numNotariaIdentificacion = trim($datos [12]);
        $numEscrituraTitulo = trim($datos [10]);
        $fchEscrituraTitulo = trim($datos [11]);
        $numNotariaTitulo = trim($datos [12]);
        $numFolioMatricula = trim($datos [34]);
        $txtZonaMatricula = trim($datos [23]);
        $fchMatricula = trim($datos [25]);
        $bolSubsidioSDHT = 1;
        $bolSubsidioFonvivienda = 0;
        $numResolucionFonvivienda = 'null';
        $numAnoResolucionFonvivienda = 'null';
        $txtAprobo = trim($datos [40]);
        $fchCreacion = 'now()';
        $fchActualizacion = 'null';
        $txtCiudadTitulo = 'Bogota';
        $txtCiudadIdentificacion = 'Bogota';
        $txtCiudadMatricula = 'Bogota';
        $txtElaboro = trim($datos [39]);

        $txtConcepto = trim(str_replace('"', '', $datos [42]));
        $viavilizado = (trim($datos [41]) == 'SI') ? true : false;


        $txtObservacion1 = (trim($datos [27]) == 'SI') ? true : false;
        $txtObservacion2 = (trim($datos [32]) == 'SI') ? true : false;
        $txtObservacion3 = (trim($datos [29]) == 'SI') ? true : false;
        $txtObservacion4 = (trim($datos [31]) == 'SI') ? true : false;
        $txtObservacion5 = (trim($datos [36]) == 'SI') ? true : false;
        $txtObservacion6 = (trim($datos [28]) == 'SI') ? true : false;
        $txtDocumentos1 = (trim($datos [18]) == 'SI') ? true : false;
        $txtDocumentos2 = (trim($datos [22]) == 'SI') ? true : false;
        $txtDocumentos3 = (trim($datos [9]) == 'SI') ? true : false;

        $valores = "(
                       '$seqDesembolso',
                       '$numEscrituraIdentificacion',
                        '$fchEscrituraIdentificacion',
                        '$numNotariaIdentificacion',
                        '$numEscrituraTitulo',
                        '$fchEscrituraTitulo',
                        '$numNotariaTitulo',
                        '$numFolioMatricula',
                        '$txtZonaMatricula',
                        '$fchMatricula',
                        '$bolSubsidioSDHT',
                        '$bolSubsidioFonvivienda',
                        '$numResolucionFonvivienda',
                        '$numAnoResolucionFonvivienda',
                        '$txtAprobo',
                        '$fchCreacion',
                        '$fchActualizacion',
                        '$txtCiudadTitulo',
                        '$txtCiudadIdentificacion',
                        '$txtCiudadMatricula',
                        '$txtElaboro');";
        $query = $campos . $valores;
        echo "<br>/" . $query;
        if ($db->query($query)) {
            $seqEstudioTitulos = $db->insert_id;
            if ($viavilizado == true) {
                $queryAdjuntos = "INSERT INTO t_des_adjuntos_titulos (seqTipoAdjunto ,seqEstudioTitulos ,txtAdjunto) VALUES "
                        . "(4,'$seqEstudioTitulos','$observacion1'),"
                        . "(4,'$seqEstudioTitulos','$observacion2'),"
                        . "(4,'$seqEstudioTitulos','$observacion3'),"
                        . "(4,'$seqEstudioTitulos','$observacion4'),"
                        . "(4,'$seqEstudioTitulos','$observacion5'),"
                        . "(4,'$seqEstudioTitulos','$observacion6'),"
                        . "(4,'$seqEstudioTitulos','$observacion7'),"
                        . "(1,'$seqEstudioTitulos','$documentos1'),"
                        . "(1,'$seqEstudioTitulos','$documentos2'),"
                        . "(1,'$seqEstudioTitulos','$documentos3'),"
                        . "(2,'$seqEstudioTitulos','$txtConcepto');";
            } else {
                $txtqueryAdjuntos = "INSERT INTO t_des_adjuntos_titulos (seqTipoAdjunto ,seqEstudioTitulos ,txtAdjunto) VALUES";
                $valqueryAdjuntos;

                ($txtObservacion1) == true ? $valqueryAdjuntos.= "(4,$seqEstudioTitulos,'$observacion1')," : "";
                ($txtObservacion2) == true ? $valqueryAdjuntos.="(4,$seqEstudioTitulos,'$observacion2')," : "";
                ($txtObservacion3) == true ? $valqueryAdjuntos.="(4,$seqEstudioTitulos,'$observacion3')," : "";
                ($txtObservacion4) == true ? $valqueryAdjuntos.="(4,$seqEstudioTitulos,'$observacion4')," : "";
                ($txtObservacion5) == true ? $valqueryAdjuntos.="(4,$seqEstudioTitulos,'$observacion5')," : "";
                ($txtObservacion6) == true ? $valqueryAdjuntos.="(4,$seqEstudioTitulos,'$observacion6')," : "";
                ($txtObservacion7) == true ? $valqueryAdjuntos.="(4,$seqEstudioTitulos,'$observacion7')," : "";
                ($txtDocumentos1) == true ? $valqueryAdjuntos.="(1,$seqEstudioTitulos,'$documentos1')," : "";
                ($txtDocumentos2) == true ? $valqueryAdjuntos.="(1,$seqEstudioTitulos,'$documentos2')," : "";
                ($txtDocumentos3) == true ? $valqueryAdjuntos.="(1,$seqEstudioTitulos,'$documentos3')," : "";
                $valqueryAdjuntos.="(2,$seqEstudioTitulos,'$txtConcepto');";

                $queryAdjuntos = $txtqueryAdjuntos . $valqueryAdjuntos;
            }
        }
        //$db->query($query);
        $registros++;
    }
    Echo "La importaci&oacute;n se ejecut&oacute; exitosamente, se ejecutaron $registros consultas.";
} else {
    echo "Error de subida";
}

function obtenerDesembolso($numFormulario) {
    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive', 'localhost');
    $consulta = "
        SELECT seqDesembolso
            FROM t_des_desembolso
        WHERE seqFormulario = $numFormulario";
    $resultado = $db->get_row($consulta);
    if ($resultado > 0) {
        return $resultado->seqDesembolso;
    }
}
?>