<?php

/**
 * CUANDO SE EDITA UN OFERENTE ESTE ARCHIVO
 * RECOGE LA INFORMACION DE ESE OFERENTE Y LA
 * COLOCA EN EL FORMULARIO PARA QUE SEA MODIFICADO
 * @author Jaison Ospina
 * @version 0.1 Noviembre 2013
 */
// posicion relativa de los archivos a incluir
$txtPrefijoRuta = "../../";

// Autenticacion (si esta logueado no no)
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Oferente.class.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Menu.class.php" );

// Verifica que el valor sea numerico
if (!( is_numeric($_POST['seqEditar']) and isset($_POST['seqEditar']) )) {
    $_POST['seqEditar'] = 0;
}

// Identificador de la Oferente a editar
$seqOferente = $_POST['seqEditar'];

// Obtiene la informacion para la Oferente
$claOferente = new Oferente;
$arrOferente = $claOferente->cargarOferente($seqOferente);

// Obtiene los Tipos de Documento para el Representante Legal
$arrTipoDocumento = array();
// Tipos de documento
$sql = "SELECT
                seqTipoDocumento,
                txtTipoDocumento
        FROM
                T_CIU_TIPO_DOCUMENTO
        WHERE
                seqTipoDocumento IN (1, 6)
        ORDER BY
                txtTipoDocumento
		";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $arrTipoDocumento[$objRes->fields['seqTipoDocumento']] = $objRes->fields['txtTipoDocumento'];
    $objRes->MoveNext();
}

// Asignaciones a la plantilla
$claSmarty->assign("seqEditar", $seqOferente);
$claSmarty->assign("objOferente", $arrOferente[$seqOferente]);
$claSmarty->assign("arrConfiguracion", $arrConfiguracion);
$claSmarty->assign("arrTipoDocumento", $arrTipoDocumento);

// Muestra el formulario
$claSmarty->display("administracionProyectos/formularioOferente.tpl");

// Desconecta la base de datos
$aptBd->close();
?>