<?php

	/**
	 * ARCHIVO PRINCIPAL DE ADMINISTRACION DE PROYECTOS (panel de control)
	 * DESDE AQUI SE ADMINISTRAN LAS OPVS Y OFERENTES
	 * @author Jaison Ospina
	 * @version 0.1 Noviembre de 2013
	 */
    
  // posicion relativa de los archivos a incluir
	$txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" ); 	
    
 	// Inclusiones necesarias
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Opv.class.php" );
	
	// Funciones
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	 
	// Por defecto se muestran las plantillas de Opv
	$txtListado    = "./administracionProyectos/listado.tpl";
	$txtFormulario = "./administracionProyectos/formularioOpv.tpl";
	$txtMenu       = "./administracionProyectos/menuLateral.tpl";
	
	// Listado de Opvs (que se muestra por defecto)
	$claOpv = new Opv;
	$arrOpv = $claOpv->cargarOpv($seqOpv);
	
  // Adecuacion del arreglo para el formato de listado estandar
  $arrListado = array();
  foreach( $arrOpv as $seqOpv => $objOpv ){
  	$arrListado[ $seqOpv ][ 'nombre' ] = $objOpv->txtNombreOpv;
    $arrListado[ $seqOpv ][ 'estado' ] = ( $objOpv->bolActivo == 1 )? "Activo" : "Inactivo";
  }
  
      // Obtiene los Tipos de Documento para el Representante Legal
	$arrTipoDocumento = array();
	// Tipos de documento
	$sql = "
			SELECT
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
	$claSmarty->assign( "txtListado"       , $txtListado       );
	$claSmarty->assign( "txtFormulario"    , $txtFormulario    );
	$claSmarty->assign( "txtMenu"          , $txtMenu          );
	$claSmarty->assign( "arrListado"       , $arrListado       );
	$claSmarty->assign( "arrConfiguracion" , $arrConfiguracion );
	$claSmarty->assign( "txtEditar"        , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/formularioOpv.php" ); // Archivo para editar las Opvs
	$claSmarty->assign( "txtBorrar"        , "./" . $arrConfiguracion['carpetas']['contenidos'] . "administracionProyectos/borrarOpv.php" ); // archivo para borrar las Opvs
	$claSmarty->assign( "txtPregunta"      , "Esta a punto de eliminar una Opv, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?" );
	$claSmarty->assign( "txtTitulo"        , "Lista de OPVs" );
	$claSmarty->assign( "txtRutaImagenes"  , $arrConfiguracion['carpetas']['imagenes'] );
	$claSmarty->assign( "arrTipoDocumento" , $arrTipoDocumento );

	// Despliegue de la plantilla
	$claSmarty->display( "administracionProyectos/administracionInicial.tpl" );

	// Desconecta la base de datos
	$aptBd->close();
?>
