<?php
    /**
	 * INICIO DE LA PANTALLA DE UNIDADES DE PROYECTO
	 * @author Jaison Ospina
	 * @version 1.0 Jul 2015
	 */

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );

    $arrProyectos = array();

    $sql = "
        SELECT 
            seqProyecto,
            txtNombreProyecto
        FROM T_PRY_PROYECTO
		WHERE seqTipoEsquema = 1
        ORDER BY txtNombreProyecto
    ";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
        $arrProyectos[ $objRes->fields['seqProyecto'] ]['nombre']  = $objRes->fields['txtNombreProyecto'];
        $objRes->MoveNext();
    }

    $claSmarty->assign( "arrProyectos"      , $arrProyectos );
    $claSmarty->assign( "txtUsuario"     , $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] );
    $claSmarty->display( "unidadProyecto/unidades.tpl" );
    
?>
