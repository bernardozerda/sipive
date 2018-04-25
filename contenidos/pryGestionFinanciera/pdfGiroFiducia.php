<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "GestionFinancieraProyectos.class.php" );
include( $txtPrefijoRuta . "librerias/pdf/class.ezpdf.php" );

$numFuenteTitulo = 14;
$numFuenteSubTitulo = $numFuenteTitulo - 2;
$numFuenteTexto = $numFuenteSubTitulo - 2;

$claPdf =& new Cezpdf( "LETTER" );
$claPdf->selectFont( $txtPrefijoRuta . "librerias/pdf/fonts/Helvetica.afm");
$claPdf->ezSetCmMargins( 2 , 1 , 2 , 2 );

$claPdf->addJpegFromFile($txtPrefijoRuta . "recursos/imagenes/bta_positiva.jpg",50,675,100);
$claPdf->addJpegFromFile($txtPrefijoRuta . "recursos/imagenes/bta_positiva.jpg",460,675,100);

$arrTabla[0][0] = "";
$arrTabla[0][1] = "Texto\n\n\n";
$arrTabla[0][2] = "";

$claPdf->ezTable(
    $arrTabla,
    '',
    '',
    array(
        'showHeadings' => 0,
        'showLines' => 0,
        'fontSize' => $numFuenteTitulo,
        'width' => 485,
        'cols' => array(
            0 => array(
                'width' => 100
            ),
            1 => array(
                'justification' => 'center'
            ),
            2 => array(
                'width' => 100
            )
        )
    )
);

$claPdf->setLineStyle(1);
$claPdf->line(60 , 665 , 550, 665);

$claPdf->ezText("");
$claPdf->ezText("");
$claPdf->ezText( "Titulo" , $numFuenteTitulo );
$claPdf->ezText(  "SubTitulo" , $numFuenteSubTitulo );

$txtTexto  = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras velit mauris, vulputate in risus et, malesuada dignissim augue. ";
$txtTexto .= "Morbi sed maximus nisi. Duis elementum suscipit urna, ut congue nisi feugiat eu. Sed ligula lectus, convallis interdum purus et, dictum ";
$txtTexto .= "dignissim elit. Aliquam gravida orci ex, vel mollis turpis egestas eget. Nunc quis nisi quis ante cursus ornare. Aliquam mattis interdum urna, ";
$txtTexto .= "non placerat enim convallis vel. Nunc hendrerit eros id turpis venenatis, eu pulvinar leo blandit. Fusce sed eros non quam rhoncus cursus. Donec ";
$txtTexto .= "facilisis purus velit. Duis quis nulla vitae ipsum eleifend tincidunt. Vestibulum eros nulla, interdum in libero at, ullamcorper consequat turpis.";

$claPdf->ezText(
    $txtTexto ,
    $numFuenteTexto ,
    array(
        'justification' => 'full'
    )
);

// Imprime por pantalla
$claPdf->ezStream();

?>