<?php

    /**
     * SALVA O EDITA LOS PROYECTOS DE LA BASE DE DATOS
     * @author JAISON OSPINA
     * @version 0.1 enero 2014
     */
    
    // Posicion relativa de los archivos a incluir
    $txtPrefijoRuta = "../../";

    // Autenticacion (si esta logueado o no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "ProyectoVivienda.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "SeguimientoProyectos.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );

    /**
     * Validacion del formulario de proyectos
    **/
    
    $arrErrores = array();
    
// Grupo de Gestion 
if ($_POST['seqGrupoGestion'] == 0) {
	$arrErrores[] = "Seleccione el grupo de la gestión realizada";
}

// Gestion
if ($_POST['seqGestion'] == 0) {
	$arrErrores[] = "Seleccione la gestión realizada";
}

// Comentarios
if ($_POST['txtComentario'] == "") {
	$arrErrores[] = "Por favor diligencie el campo de comentarios";
}
// ======================================================= DATOS DEL PROYECTO ==============================================================
// Validar Nombre de Proyecto
if( ( ! isset( $_POST['txtNombreProyecto'] ) ) or trim( $_POST['txtNombreProyecto'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el campo Nombre del Proyecto";
}

// Validar Tipo de Esquema
if( ( ! isset( $_POST['seqTipoEsquema'] ) ) or trim( $_POST['seqTipoEsquema'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar el Tipo de Esquema";
}

// Validar Tipo de Modalidad
if( ( ! isset( $_POST['seqPryTipoModalidad'] ) ) or trim( $_POST['seqPryTipoModalidad'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar el Tipo de Modalidad";
}

//////////////////////////////////////////////// VALIDACION SI EL TIPO DE ESQUEMA ES COLECTIVO OPV //////////////////////////////////////////
if( $_POST['seqTipoEsquema'] == 2 ){

	// OPV
	if( ( ! isset( $_POST['seqOpv'] ) ) or trim( $_POST['seqOpv'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar la OPV";
	}

}

///////////////////////////////////////////// VALIDACION SI EL TIPO DE ESQUEMA ES TERRITORIAL DIRIGIDO /////////////////////////////////////
if( $_POST['seqTipoEsquema'] == 4 ){

	// Nombre de Operador
	if( ( ! isset( $_POST['txtNombreOperador'] ) ) or trim( $_POST['txtNombreOperador'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el campo Nombre del Operador";
	}

	// Objeto del Proyecto
	if( ( ! isset( $_POST['txtObjetoProyecto'] ) ) or trim( $_POST['txtObjetoProyecto'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el Objeto del proyecto";
	}

}

// Localidad
if( ( ! isset( $_POST['seqLocalidad'] ) ) or trim( $_POST['seqLocalidad'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar la Localidad";
}

// Barrio
	if( ( ! isset( $_POST['seqBarrio'] ) ) or trim( $_POST['seqBarrio'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Barrio";
}

// Número de Soluciones
if( ( ! isset( $_POST['valNumeroSoluciones'] ) ) or trim( $_POST['valNumeroSoluciones'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el número de soluciones";
}

/////////////////////////////////////// VALIDACION SI EL TIPO DE ESQUEMA ES DIFERENTE A MEJORAMIENTO ////////////////////////////////////////
if( $_POST['seqTipoEsquema'] != 4 ){

	// Tipo de Proyecto
	if( ( ! isset( $_POST['seqTipoProyecto'] ) ) or trim( $_POST['seqTipoProyecto'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Tipo de Proyecto";
	}

	// Tipo de Urbanización
	if( ( ! isset( $_POST['seqTipoUrbanizacion'] ) ) or trim( $_POST['seqTipoUrbanizacion'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Tipo de Urbanizaci&oacute;n";
	}

	// Tipo de Solución
	if( ( ! isset( $_POST['seqTipoSolucion'] ) ) or trim( $_POST['seqTipoSolucion'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Tipo de Soluci&oacute;n";
	}

	// Dirección
	if( $_POST['bolDireccion'] == 1 ){
		if( ( ! isset( $_POST['txtDireccion'] ) ) or trim( $_POST['txtDireccion'] ) == "" ){
			$arrErrores[] = "Debe diligenciar el campo Direcci&oacute;n";
		}
	}

	// Area Lote
	if( ( ! isset( $_POST['valAreaLote'] ) ) or trim( $_POST['valAreaLote'] ) == "" ){
		$arrErrores[] = "Debe diligenciar el Area del Lote";
	}
	
	// Si tiene Equipamiento Comunal valida el campo
	if( $_POST['bolEquipamientoComunal']  == 1 ){
		if( ( ! isset( $_POST['txtDescEquipamientoComunal'] ) ) or trim( $_POST['txtDescEquipamientoComunal'] ) == "" ){
			$arrErrores[] = "Debe diligenciar la descripci&oacute;n del Equipamiento Comunal";
		}
	}

}

// =================================================== DATOS DEL OFERENTE =================================================================

// Nombre Oferente
if( ( ! isset( $_POST['txtNombreOferente'] ) ) or trim( $_POST['txtNombreOferente'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nombre del Oferente";
}

// NIT Oferente
if( ( ! isset( $_POST['numNitOferente'] ) ) or trim( $_POST['numNitOferente'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nit del Oferente";
}

// NIT Contacto Oferente
if( ( ! isset( $_POST['txtNombreContactoOferente'] ) ) or trim( $_POST['txtNombreContactoOferente'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nombre de contacto del Oferente";
}

$exregfijo = "/^[0-9]{7}$/";
$exregcel = "/^[3]{1}[0-9]{9}$/";
if ($_POST['numTelefonoOferente'] == "" and $_POST['numCelularOferente'] == "") {
	$arrErrores[] = "Debe diligenciar el numero de contacto del Oferente";
} else {
	if ($_POST['numTelefonoOferente'] != "" && $_POST['numTelefonoOferente'] != 0) {
		if (!preg_match($exregfijo, $_POST['numTelefonoOferente'])) {
			$arrErrores[] = "El Numero Telefonico no puede ser menor ni mayor a 7 digitos";
		}
	}
	if ($_POST['numCelularOferente'] != "" && $_POST['numCelularOferente'] != 0) {
		if (!preg_match($exregcel, $_POST['numCelularOferente'])) {
			$arrErrores[] = "El Numero celular no puede ser menor ni mayor a 10 digitos y debe empezar por 3";
		}
	}
}

// Correo Electronico Oferente
if( trim( $_POST['txtCorreoOferente'] ) != "" ){
	if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreoOferente'] ) ) ){
		$arrErrores[] = "El correo electr&oacute;nico del oferente no es v&aacute;lido";
	}
}

// =========================================== DATOS DEL REPRESENTANTE LEGAL DEL OFERENTE =====================================================

// Correo Electronico Representante Legal Oferente
if( trim( $_POST['txtCorreoRepresentanteLegalOferente'] ) != "" ){
	if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreoRepresentanteLegalOferente'] ) ) ){
		$arrErrores[] = "El correo electr&oacute;nico del Representante Legal del oferente no es v&aacute;lido";
	}
}

// Constructor
if( $_POST['bolConstructor']  == 1 ){
	if( ( ! isset( $_POST['seqConstructor'] ) ) or trim( $_POST['seqConstructor'] ) == 0 ){
		$arrErrores[] = "Debe seleccionar el Constructor";
	}
}

	// Fecha de aprobacion de la poliza
    /*list( $numAno , $numMes , $numDia ) = split( "-" , $_POST['fchAprobacionPoliza'] );
    if( ! @checkdate( $numMes , $numDia , $numAno ) ){
    	$arrErrores[] = "Debe colocar una fecha de Aprobación de la Póliza";
    }

    // Estado
    if( ! isset( $_POST['bolActivo'] ) ){
    	$arrErrores[] = "Seleccione un estado para el proyecto";
    }  */  
       
    /**
     * Salvar o editar proyectos si no hay errores
     */
    //pr ($arrErrores);
    if( empty( $arrErrores ) ){
        
        $claProyectoVivienda = new ProyectoVivienda;
        $claRegistro = new RegistroActividades;
        
        // Verifica si es para crear o editar el proyecto
        if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
            $arrErrores = $claProyectoVivienda->editarProyectoVivienda( 
			$_POST['seqEditar'] , $_POST['numNitProyecto'], trim( $_POST['txtNombreProyecto'] ), $_POST['txtNombrePlanParcial'], $_POST['seqTipoEsquema'], $_POST['seqPryTipoModalidad'], $_POST['txtNombreOperador'], $_POST['txtObjetoProyecto'], $_POST['txtOtrosBarrios'], $_POST['seqOpv'], $_POST['seqTipoProyecto'], $_POST['seqTipoUrbanizacion'], $_POST['seqTipoSolucion'], $_POST['txtDescripcionProyecto'], $_POST['bolDireccion'], $_POST['txtDireccion'], $_POST['seqLocalidad'], $_POST['seqBarrio'], $_POST['valNumeroSoluciones'], $_POST['valAreaConstruida'], $_POST['valAreaLote'], $_POST['txtChipLote'], $_POST['txtMatriculaInmobiliariaLote'], $_POST['txtRegistroEnajenacion'], $_POST['bolEquipamientoComunal'], $_POST['txtDescEquipamientoComunal'], $_POST['bolConstructor'], $_POST['seqConstructor'], $_POST['txtLicenciaUrbanismo'], $_POST['fchLicenciaUrbanismo1'], $_POST['fchLicenciaUrbanismo2'], $_POST['fchLicenciaUrbanismo3'], $_POST['fchVigenciaLicenciaUrbanismo'], $_POST['txtLicenciaConstruccion'], $_POST['fchLicenciaConstruccion1'], $_POST['fchLicenciaConstruccion2'], $_POST['fchLicenciaConstruccion3'], $_POST['valVigenciaLicenciaConstruccion'], $_POST['txtNombreInterventor'], $_POST['bolTipoPersonaInterventor'], $_POST['numCedulaInterventor'], $_POST['numTProfesionalInterventor'], $_POST['numNitInterventor'], $_POST['seqPryEstadoProceso'], $_POST['bolActivo'] );
           	$claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion de Proyecto de Vivienda: [" . $_POST['seqEditar'] . "] " . trim( $_POST['txtNombreProyecto'] ) . " Mensaje: " . implode( "," , $arrErrores ) );
        } else {
            $arrErrores = $claProyectoVivienda->guardarProyectoVivienda(
			$_POST['seqProyecto'], $_POST['numNitProyecto'], trim( $_POST['txtNombreProyecto'] ), $_POST['txtNombrePlanParcial'], $_POST['seqTipoEsquema'], $_POST['seqPryTipoModalidad'], $_POST['txtNombreOperador'], $_POST['txtObjetoProyecto'], $_POST['txtOtrosBarrios'], $_POST['seqOpv'], $_POST['seqTipoProyecto'], $_POST['seqTipoUrbanizacion'], $_POST['seqTipoSolucion'], $_POST['txtDescripcionProyecto'], $_POST['bolDireccion'], $_POST['txtDireccion'], $_POST['seqLocalidad'], $_POST['seqBarrio'], $_POST['valNumeroSoluciones'], $_POST['valAreaConstruida'], $_POST['valAreaLote'], $_POST['txtChipLote'], $_POST['txtMatriculaInmobiliariaLote'], $_POST['txtRegistroEnajenacion'], $_POST['fchRegistroEnajenacion'], $_POST['bolEquipamientoComunal'], $_POST['txtDescEquipamientoComunal'], $_POST['txtNombreOferente'], $_POST['numNitOferente'], $_POST['txtNombreContactoOferente'], $_POST['numTelefonoOferente'], $_POST['numExtensionOferente'], $_POST['numCelularOferente'], $_POST['txtCorreoOferente'], $_POST['txtNombreOferente2'], $_POST['numNitOferente2'], $_POST['txtNombreContactoOferente2'], $_POST['numTelefonoOferente2'], $_POST['numExtensionOferente2'], $_POST['numCelularOferente2'], $_POST['txtCorreoOferente2'], $_POST['txtNombreOferente3'], $_POST['numNitOferente3'], $_POST['txtNombreContactoOferente3'], $_POST['numTelefonoOferente3'], $_POST['numExtensionOferente3'], $_POST['numCelularOferente3'], $_POST['txtCorreoOferente3'], $_POST['txtRepresentanteLegalOferente'], $_POST['numNitRepresentanteLegalOferente'], $_POST['numTelefonoRepresentanteLegalOferente'], $_POST['numExtensionRepresentanteLegalOferente'], $_POST['numCelularRepresentanteLegalOferente'], $_POST['txtDireccionRepresentanteLegalOferente'], $_POST['txtCorreoRepresentanteLegalOferente'], $_POST['bolConstructor'], $_POST['seqConstructor'], $_POST['seqTutorProyecto'], $_POST['seqPryEstadoProceso'], $_POST['bolActivo'], $_POST['seqUsuario'] );
            $claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion de Proyecto de Vivienda: " . trim( $_POST['txtNombreProyecto'] ) . " Mensaje: " . implode( "," , $arrErrores ) );
		}
    }

	$sql = "SELECT seqProyecto FROM T_PRY_PROYECTO WHERE txtNombreProyecto = '$_POST[txtNombreProyecto]'";
	$objRes = $aptBd->execute( $sql );
	$seqProyecto = $objRes->fields['seqProyecto'];	
    /**
     * Impresion de resultados
     */

    /*if( empty( $arrErrores ) ){
        $arrMensajes[] = "El Proyecto <b>" . $_POST['txtNombreProyecto'] . "</b> se ha guardado";
        imprimirMensajes( array() , $arrMensajes , "salvarProyectoVivienda" );
    } else {
        imprimirMensajes( $arrErrores , array() );
    }*/

	/* * *********************************************************************************************************************
 * IMPRESION DE LOS MENSAJES
 * ******************************************************************************************************************** */

 ////////////////////////////// DESDE AQUI /////////////////////////
 //pr ($claProyectoVivienda->arrErrores);
 if( empty( $claProyectoVivienda->arrErrores ) ){

				try {
					$aptBd->execute( $sql );

					$sql = "
						INSERT INTO T_SEG_SEGUIMIENTO_PROYECTOS (
							seqProyecto, 
							fchMovimiento, 
							seqUsuario, 
							txtComentario, 
							txtCambios, 
							seqGestion,
							bolMostrar
						) VALUES (
							$seqProyecto,
							now(),
							". $_SESSION['seqUsuario'] .",
							\"" . ereg_replace( "\n", "" , $_POST[txtComentario] ) . "\",
							\"" . ereg_replace( "\"" , "" , $txtCambios ) . "\",
							" . $_POST['seqGestion'] . ",
							1
						)
					";

					try { 
						$aptBd->execute( $sql );
					} catch ( Exception $objError ){
						//$arrErrores[] = "El formulario se ha salvado pero no ha quedado registro de la actividad";
//						pr( $sql );
					}
				} catch ( Exception $objError ){
					$arrErrores[] = $objError."No se ha podido salvar los datos del hogar";
//					pr( $objError->msg );
				}
			}
 ////////////////////////////// HASTA AQUI /////////////////////////

if (empty($arrErrores)) {
	$arrMensajes[] = "El Proyecto se ha salvado, Proyecto [ " . $_POST['txtNombreProyecto'] . " ].<br>" . "El numero de registro es " . number_format($seqSeguimiento, 0, ".", ",") . ". Conserve este numero para referencia futura";

	$txtEstilo = "msgOk";
} else {
	$arrMensajes = $arrErrores;
	$txtEstilo = "msgError";
}

echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px'>";

if (!empty($arrNotificaciones)) {
	foreach ($arrNotificaciones as $txtMensaje) {
		echo "<tr><td class='msgAlerta'><li>$txtMensaje</li></td></tr>";
	}
}

foreach ($arrMensajes as $txtMensaje) {
	echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
}
echo "</table>";

    // Desconecta la base de datos
    $aptBd->close();

?>
