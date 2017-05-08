<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

//    pr( $_POST );
    
    include( "../desembolso/datosComunes.php" );
    
    // simula el flujo del hogar en desembolsos para efectos de la plantilla
    $arrFlujoHogar['flujo'] = "cem";
    $arrFlujoHogar['fase']  = "postulacion";
    
    // Los estados del proceso se cargan para las traducciones en las plantillas
    $arrEstados = estadosProceso();
    
    // obtieene los permisos para saber a donde puede entrar
    $claCasaMano = new CasaMano();
    
    $objCasaMano = null;
    if( intval( $_POST['seqFormulario'] ) != 0 and intval( $_POST['seqCasaMano'] ) != 0 ){
        $arrCasaMano = $claCasaMano->cargar( $_POST['seqFormulario'] , $_POST['seqCasaMano'] );
        $objCasaMano = array_shift( $arrCasaMano );
    }
    //pr($objCasaMano);
    // datos que vienen del registro de oferta y que no hay que pedir de nuevo en postulacion
    $objCasaMano->objPostulacion->txtBarrio = $arrBarrio[ $objCasaMano->objPostulacion->seqBarrio ];
    $objCasaMano->objPostulacion->txtDireccionSolucion = $objCasaMano->objRegistroOferta->txtDireccionInmueble;
    $objCasaMano->objPostulacion->txtMatriculaInmobiliaria = $objCasaMano->objRegistroOferta->txtMatriculaInmobiliaria;
    $objCasaMano->objPostulacion->txtChip = $objCasaMano->objRegistroOferta->txtChip;
    
    $bolPermiso = $claCasaMano->puedeIngresar( $arrFlujoHogar , $objCasaMano->objPostulacion );
    if( $bolPermiso == true ){
    
        // Obtienr los ultimos seguimientos
		$claSeguimiento = new Seguimiento;
		$claSeguimiento->seqFormulario = $_POST['seqFormulario'];
		$arrRegistros = $claSeguimiento->obtenerRegistros( 100 );
		
        // Carga el tutor que tiene asignado ese hogar
		$claCRM = new CRM;
		$txtTutor = $claCRM->obtenerTutorHogar( $_POST['seqFormulario'] );
        
        // Los estados de avance y retorno para esta fase
        $arrEstadosCEM['atras']    = $claCasaMano->arrFases[ $arrFlujoHogar['flujo'] ][ $arrFlujoHogar['fase'] ]['atras'];
        $arrEstadosCEM['adelante'] = $claCasaMano->arrFases[ $arrFlujoHogar['flujo'] ][ $arrFlujoHogar['fase'] ]['adelante'];
        
        /*
         * REQUISITOS DE LA PLANTILLA
         */
        
        // Modalidades de subsidio
        // viene declarada en datosComunes asi que la quito para decalrarla con el plan de gobierno que corresponde
        /*unset( $arrModalidad ); 
        $sql = "
            SELECT 
                seqModalidad,
                txtModalidad
            FROM 
                T_FRM_MODALIDAD
            WHERE 
                seqPlanGobierno = " . $objCasaMano->objPostulacion->seqPlanGobierno . "
            ORDER BY
                txtModalidad
        ";
        $objRes = $aptBd->execute( $sql );
        while( $objRes->fields ){
            $arrModalidad[ $objRes->fields['seqModalidad'] ] = $objRes->fields['txtModalidad'];
            $objRes->MoveNext();
        }	*/

         // Obtiene el postulante principal
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario( $_POST['seqFormulario'] );
         foreach( $claFormulario->arrCiudadano as $objCiudadano ){
             if( $objCiudadano->seqParentesco == 1 ){
                $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento );
                 break;
             }
         }
        
		$arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad", "seqPlanGobierno"), "seqModalidad", "", "seqPlanGobierno DESC, txtModalidad");
		$arrSolucion = obtenerDatosTabla("T_FRM_SOLUCION", array("seqSolucion", "txtSolucion", "seqModalidad"), "seqSolucion", "seqSolucion <> 1");
		$arrProyecto = obtenerDatosTabla("T_PRY_PROYECTO", array("seqProyecto", "txtNombreProyecto"), "seqProyecto", "", "txtNombreProyecto");
		$arrUnidadProyecto = obtenerDatosTabla("T_PRY_UNIDAD_PROYECTO", array("seqUnidadProyecto", "txtNombreUnidad", "seqProyecto", "seqFormulario"), "seqUnidadProyecto", "bolActivo = 1", "txtNombreUnidad");
		
		
        // obtiene la informacion de la pestana de actos administrativos
         $claActosAdministrativos = new ActoAdministrativo();
         $arrActos = $claActosAdministrativos->cronologia( $numDocumento );
        
        $arrEstadoCivil              = obtenerDatosTabla( "T_CIU_ESTADO_CIVIL" , array( "seqEstadoCivil" , "CONCAT( seqEstadoCivil , ' - ' , txtEstadoCivil ) as nombre" ) , "seqEstadoCivil" );
        $arrEstadoCivilNombres       = obtenerDatosTabla( "T_CIU_ESTADO_CIVIL" , array( "seqEstadoCivil" , "txtEstadoCivil" ) , "seqEstadoCivil" );
        $arrCondicionEspecial        = obtenerDatosTabla( "T_CIU_CONDICION_ESPECIAL" , array( "seqCondicionEspecial" , "CONCAT( seqCondicionEspecial , ' - ' , txtCondicionEspecial ) as nombre" ) , "seqCondicionEspecial" , "seqCondicionEspecial <> 6" );
        $arrCondicionEspecialNombres = obtenerDatosTabla( "T_CIU_CONDICION_ESPECIAL" , array( "seqCondicionEspecial" , "txtCondicionEspecial" ) , "seqCondicionEspecial" );
        $arrCondicionEtnica          = obtenerDatosTabla( "T_CIU_ETNIA" , array( "seqEtnia" , "txtEtnia" ) , "seqEtnia" , "txtEtnia <> 'ninguna'" );
        $arrCondicionEtnicaNombres   = obtenerDatosTabla( "T_CIU_ETNIA" , array( "seqEtnia" , "txtEtnia" ) , "seqEtnia" );
        $arrSexo                     = obtenerDatosTabla( "T_CIU_SEXO" , array( "seqSexo" , "txtSexo" ) , "seqSexo" );
        $arrCajaCompensacion         = obtenerDatosTabla( "T_CIU_CAJA_COMPENSACION" , array( "seqCajaCompensacion" , "txtCajaCompensacion" ) , "seqCajaCompensacion", "txtCajaCompensacion <> 'no afiliado'" );
        $arrCajaCompensacionNombres  = obtenerDatosTabla( "T_CIU_CAJA_COMPENSACION" , array( "seqCajaCompensacion" , "txtCajaCompensacion" ) , "seqCajaCompensacion" );
        $arrNivelEducativo           = obtenerDatosTabla( "T_CIU_NIVEL_EDUCATIVO" , array( "seqNivelEducativo" , "txtNivelEducativo" ) , "seqNivelEducativo" );
        $arrSalud                    = obtenerDatosTabla( "T_CIU_SALUD" , array( "seqSalud" , "txtSalud" ) , "seqSalud" );
        $arrOcupacion                = obtenerDatosTabla( "T_CIU_OCUPACION" , array( "seqOcupacion" , "CONCAT( seqOcupacion , ' - ' , txtOcupacion ) as nombre" ) , "seqOcupacion" , "seqOcupacion <> 20"  );
        $arrOcupacionNombres         = obtenerDatosTabla( "T_CIU_OCUPACION" , array( "seqOcupacion" , "txtOcupacion" ) , "seqOcupacion" );
        $arrVivienda                 = obtenerDatosTabla( "T_FRM_VIVIENDA" , array( "seqVivienda" , "txtVivienda" ) , "seqVivienda" );
        $arrCiudad                   = obtenerDatosTabla( "T_FRM_CIUDAD" , array( "seqCiudad" , "CONCAT( txtCiudad , ', ' , txtDepartamento ) txtCiudad" ), "seqCiudad" , "" , "txtCiudad" );
        $arrSisben                   = obtenerDatosTabla( "T_FRM_SISBEN" , array( "seqSisben" , "txtSisben" ) , "seqSisben" );
        $arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA", array("seqTipoVictima", "txtTipoVictima"), "seqTipoVictima", "seqTipoVictima <> 0", "txtTipoVictima");
        $arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi", "seqGrupoLgtbi <> 0", "txtGrupoLgtbi");
		$arrDonantes                 = obtenerDatosTabla("T_FRM_EMPRESA_DONANTE", array( "seqEmpresaDonante" , "txtEmpresaDonante" ) , "seqEmpresaDonante" , "seqEmpresaDonante <> 1" );
		$arrBarrio                 = obtenerDatosTabla("T_FRM_BARRIO", array( "seqBarrio" , "txtBarrio" ) , "seqBarrio" , "seqBarrio <> 1" );
		

        $claSmarty->assign( "arrModalidad" , $arrModalidad );
		$claSmarty->assign( "arrSolucion" , $arrSolucion );
		$claSmarty->assign( "arrProyecto", $arrProyecto);
		$claSmarty->assign( "arrUnidadProyecto", $arrUnidadProyecto);

        $claSmarty->assign( "arrDonantes" , $arrDonantes );
        $claSmarty->assign( "arrEstadoCivil" , $arrEstadoCivil );
        $claSmarty->assign( "arrEstadoCivilNombres" , $arrEstadoCivilNombres );
        $claSmarty->assign( "arrCondicionEspecial" , $arrCondicionEspecial );
        $claSmarty->assign( "arrCondicionEspecialNombres" , $arrCondicionEspecialNombres );
        $claSmarty->assign( "arrCondicionEtnica" , $arrCondicionEtnica );
        $claSmarty->assign( "arrCondicionEtnicaNombres" , $arrCondicionEtnicaNombres );
        $claSmarty->assign( "arrSexo" , $arrSexo );
        $claSmarty->assign( "arrCajaCompensacion" , $arrCajaCompensacion );
        $claSmarty->assign( "arrCajaCompensacionNombres" , $arrCajaCompensacionNombres );
        $claSmarty->assign( "arrNivelEducativo" , $arrNivelEducativo );
        $claSmarty->assign( "arrSalud" , $arrSalud );
        $claSmarty->assign( "arrOcupacion" , $arrOcupacion );
        $claSmarty->assign( "arrOcupacionNombres" , $arrOcupacionNombres );
        $claSmarty->assign( "arrParentescoNombres" , $arrParentesco ); // Definido en datosComunes.php
        $claSmarty->assign( "arrVivienda" , $arrVivienda );
        $claSmarty->assign( "arrCiudad" , $arrCiudad );        
        $claSmarty->assign( "arrSisben" , $arrSisben );
        $claSmarty->assign( "arrActos" , $arrActos );
        $claSmarty->assign( "txtTutorDesembolso" , $txtTutor );
        $claSmarty->assign( "arrFlujoHogar" , $arrFlujoHogar );
        $claSmarty->assign( "arrRegistros" , $arrRegistros );
		$claSmarty->assign("arrTipoVictima", $arrTipoVictima);
        $claSmarty->assign("arrGrupoLgtbi", $arrGrupoLgtbi);
        $claSmarty->assign( "arrEstados" , $arrEstados );
		$claSmarty->assign( "objFormulario" , $objCasaMano->objPostulacion );
		$claSmarty->assign( "objCiudadano", $objCiudadano);
        $claSmarty->assign( "seqFormulario" , $_POST['seqFormulario'] );
        $claSmarty->assign( "seqCasaMano" , intval( $_POST['seqCasaMano'] ) );
        $claSmarty->assign( "numDocumento" , $_POST['cedula'] );
        $claSmarty->assign( "arrEstadosCEM" , $arrEstadosCEM );
        $claSmarty->assign( "txtArchivoCEM" , $claCasaMano->arrFases[ $arrFlujoHogar['flujo'] ][ $arrFlujoHogar['fase'] ]['salvar'] );
		$claSmarty->assign("arrBarrio", $arrBarrio);
        $claSmarty->display( $claCasaMano->arrFases[ $arrFlujoHogar['flujo'] ][ $arrFlujoHogar['fase'] ]['plantilla'] );        
    } else {
        
        $arrMensaje = $claCasaMano->arrErrores;
        $claSmarty->assign( "estilo" , "msgError" );
        $claSmarty->assign( "arrImprimir" , $arrMensaje );
        $claSmarty->display( "mensajes.tpl" );   
        
    }
    
?>
