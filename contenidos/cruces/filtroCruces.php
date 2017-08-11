<?php

	/**
	 * RECIBE PARTE DE UN NOMBRE DE UN CRUCE Y CONSULTA LA BASE DE DATOS
	 * LOS CRUCES QUE CONTENGAN DICHA PALABRA
	 * @author Bernardo Zerda
	 * @version 1.1 Mar 2017
	 */

	$txtPrefijoRuta = "../../";
	include ($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
	include ($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['funciones'] . "funciones.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/inclusionSmarty.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/coneccionBaseDatos.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['clases'] . "Cruces.class.php");

	// campo del ordenamiento
    $txtCampoOrden = ( $_POST['txtCampoOrden'] == "" )? "nombre" : $_POST['txtCampoOrden'];
    $txtDireccionOrden = ( $_POST['txtDireccionOrden'] == "" )? "asc" : $_POST['txtDireccionOrden'];
    $txtCruce = ( $_POST['txtCruce'] == "" )? "" : $_POST['txtCruce'];

	// consulta
    $arrCruces = array();
    $claCruces = new Cruces();
    $arrCruces = $claCruces->listarCruces( $txtCruce, $txtCampoOrden, $txtDireccionOrden );

    // calculo de pagina inicial y pagina final
    $numTotalPaginas = ceil( count($arrCruces) / $claCruces->numPaginador );
    if( $_POST['numPaginaActiva'] <= $numTotalPaginas ) {
        $numPaginaActiva = $_POST['numPaginaActiva'];
    }else{
        $numPaginaActiva = $numTotalPaginas;
    }

    $numPaginaInicial = ( ( ceil( $numPaginaActiva / $claCruces->numPaginas ) * $claCruces->numPaginas ) - $claCruces->numPaginas ) + 1;

    if( $numTotalPaginas > $claCruces->numPaginas ) {
        $numPaginaFinal = $numPaginaInicial + ( $claCruces->numPaginas - 1 );
        if( $numPaginaFinal > $numTotalPaginas ){
            $numPaginaFinal = $numTotalPaginas;
        }
    }else{
        $numPaginaFinal = $numTotalPaginas;
    }
    $numOffSet = ( $numPaginaActiva - 1 ) * $claCruces->numPaginador;
    if( $numOffSet + ( $claCruces->numPaginador - 1 ) <= count( $arrCruces ) ){
        $numRegistros = $numOffSet + ( $claCruces->numPaginador - 1 );
    }else{
        $numRegistros = ( count( $arrCruces ) - 1);
    }

    $claSmarty->assign( "arrCruces"        , $arrCruces );
    $claSmarty->assign( "numPaginaInicial" , $numPaginaInicial );
    $claSmarty->assign( "numPaginaFinal"   , $numPaginaFinal );
    $claSmarty->assign( "numTotalPaginas"  , $numTotalPaginas );
    $claSmarty->assign( "numPaginador"     , $claCruces->numPaginas );
    $claSmarty->assign( "numPaginaActiva"  , $numPaginaActiva );
    $claSmarty->assign( "numOffSet"        , $numOffSet );
    $claSmarty->assign( "numRegistros"     , $numRegistros );
    $claSmarty->assign( "txtCampoOrden"    , $txtCampoOrden );
    $claSmarty->assign( "txtDireccionOrden", $txtDireccionOrden );

	$claSmarty->display ( "cruces/filtroCruces.tpl" );

?>