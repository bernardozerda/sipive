<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

foreach($_POST as $txtClave => $txtValor){
    $_POST[$txtClave] = regularizarCampo($txtClave,$txtValor);
}

$claCruces = new Cruces();
$claCruces->cargar($_POST['seqCruce']);

// carga el archivo txt, xls o xlsx
$arrArchivo = $claCruces->cargarArchivo();

// valida que los datos sean coherentes con el formato del archivo
// ver la clase $claCruces->arrFormatoArchivo
$claCruces->validarArchivo($arrArchivo);

// si no hay errores procede a validar reglas de negocio y salvar
if(empty($claCruces->arrErrores)){
    $claCruces->editar($_POST,$arrArchivo);
}

// si no hay errores imprime los mensajes
if(! empty($claCruces->arrErrores)) {

    imprimirMensajes($claCruces->arrErrores);

    $claSmarty->assign( "claCruces", $claCruces );
    $claSmarty->display("cruces2/ver.tpl");

}else{

    if(! empty($claCruces->arrIgnorados)){
        $numPosicion = count($claCruces->arrMensajes) + 1;
        $claCruces->arrMensajes[$numPosicion] = "<span class='msgAlerta'>Los siguientes hogares fueron ignorados debido al estado del proceso en el que se encuentran en este momento: <ul>";
        foreach($claCruces->arrIgnorados as $numDocumento){
            $claCruces->arrMensajes[$numPosicion] .= "<li>" . number_format($numDocumento ). "</li>";
        }
        $claCruces->arrMensajes[$numPosicion] .= "</ul></span>";
    }

    imprimirMensajes($claCruces->arrErrores, $claCruces->arrMensajes);

    $arrCruces = $claCruces->listado();
    $claSmarty->assign( "arrCruces", $arrCruces );
    $claSmarty->display( "cruces2/cruces.tpl" );

}