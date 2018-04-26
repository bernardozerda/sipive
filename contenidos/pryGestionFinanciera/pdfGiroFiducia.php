<?php

date_default_timezone_set("America/Bogota");
setlocale(LC_TIME , 'spanish' );

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );
include( $txtPrefijoRuta . "librerias/pdf/class.ezpdf.php" );

/**************************************************************************************************************
 * OBTENCION DE LOS DATOS DEL GIRO
 **************************************************************************************************************/

$claGestion = new GestionFinancieraProyectos();
$arrDatosFormato = $claGestion->pdfGiroFiducia($_GET['seqProyecto'], $_GET['seqGiroFiducia']);

/**************************************************************************************************************
 * CONFIGURACION INICIAL DEL ARCHIVO PDF
 **************************************************************************************************************/

$numFuenteTitulo = 11;
$numFuenteSubTitulo = $numFuenteTitulo - 2;
$numFuenteTexto = $numFuenteSubTitulo - 1;

$claPdf =& new Cezpdf( "LETTER" );
$claPdf->selectFont( $txtPrefijoRuta . "librerias/pdf/fonts/Times-Roman.afm");
$claPdf->ezSetCmMargins( 0.5 , 0.5 , 2 , 2 );

/**************************************************************************************************************
 * CABECERA DEL ARCHIVO
 **************************************************************************************************************/

// imagenes laterales de los escudos
$claPdf->addJpegFromFile($txtPrefijoRuta . "recursos/imagenes/escudo.jpg"      ,60 ,700,70);
$claPdf->addJpegFromFile($txtPrefijoRuta . "recursos/imagenes/bta_positiva.jpg",460,710,100);

$claPdf->ezText();

$claPdf->ezText(
    utf8_decode("Secretaría Distrital de Hábitat"),
    $numFuenteTitulo,
    array(
        "justification" => "center"
    )
);

$claPdf->ezText(
    utf8_decode("Solicitud de giro"),
    $numFuenteSubTitulo,
    array(
        "justification" => "center"
    )
);

$claPdf->ezText(
    utf8_decode(ucwords(strftime("%A %#d de %B del %Y"))) . " " . date("H:i:s"),
    $numFuenteSubTitulo,
    array(
        "justification" => "center"
    )
);

$claPdf->ezText(
    utf8_decode( $arrDatosFormato['secuencia'] ),
    $numFuenteSubTitulo,
    array(
        "justification" => "center"
    )
);

$claPdf->setLineStyle(1);
$claPdf->line(60 , 695 , 550, 695);

$claPdf->ezText();
$claPdf->ezText();

/**************************************************************************************************************
 * TABLAS DE INFORMACION
 **************************************************************************************************************/

foreach($arrDatosFormato['secciones'] as $txtTiutloTabla => $arrSeccion){

    foreach($arrSeccion as $numFila => $arrFila ){
        foreach($arrFila as $numColumna => $txtValor){
            $arrSeccion[$numFila][$numColumna] = utf8_decode($txtValor);
        }
    }

    $claPdf->ezTable(
        $arrSeccion,
        null,
        utf8_decode($txtTiutloTabla),
        array(
            'showHeadings' => 0,
            'showLines' => 1,
            'shaded' => 0,
            'fontSize' => $numFuenteTexto,
            'width' => 485,
            'cols' => array(
                0 => array(
                    'width' => 150
                )
            )
        )
    );

}

$arrTitulo[0][0] = utf8_decode(utf8_decode($arrDatosFormato['certificacion']));

$claPdf->ezTable(
    $arrTitulo,
    null,
    utf8_decode('Certificación'),
    array(
        'showHeadings' => 0,
        'showLines' => 1,
        'shaded' => 0,
        'fontSize' => $numFuenteTexto,
        'width' => 485
    )
);

//$claPdf->ezText();

foreach($arrDatosFormato['documentos'] as $txtTiutloTabla => $arrSeccion){

    foreach($arrSeccion as $numFila => $arrFila ){
        foreach($arrFila as $numColumna => $txtValor){
            $arrSeccion[$numFila][$numColumna] = utf8_decode($txtValor);
        }
    }

    $claPdf->ezTable(
        $arrSeccion,
        null,
        utf8_decode($txtTiutloTabla),
        array(
            'showHeadings' => 0,
            'showLines' => 1,
            'shaded' => 0,
            'fontSize' => $numFuenteTexto,
            'width' => 485,
            'cols' => array(
                0 => array(
                    'width' => 430
                )
            )
        )
    );

}

$claPdf->ezText();
$claPdf->ezText();
$claPdf->ezText();

$claPdf->ezTable(
    $arrDatosFormato['firmas'],
    null,
    null,
    array(
        'showHeadings' => 0,
        'showLines' => 0,
        'shaded' => 0,
        'fontSize' => $numFuenteSubTitulo,
        'width' => 485,
        'cols' => array(
            0 => array(
                'width' => 243
            )
        )
    )
);

$claPdf->ezText();
$claPdf->ezText();
$claPdf->ezText();

$claPdf->ezTable(
    $arrDatosFormato['subfirmas'],
    null,
    null,
    array(
        'showHeadings' => 0,
        'showLines' => 0,
        'shaded' => 0,
        'fontSize' => $numFuenteTexto,
        'width' => 485,
        'cols' => array(
            0 => array(
                'width' => 40
            )
        )
    )
);

//pr($arrDatosFormato['firmas']);

// Imprime por pantalla
$claPdf->ezStream();

?>