<?php

   /**
    * CONTENIDO DEL POPUP DE AYUDA DE LA PLANTILLA DE ACTOS ADMINISTRATIVOS
    * @author Bernardo Zerda
    * @version 1.0 Enero de 2014
    **/

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );    
   
   $claTipoActo = new TipoActoAdministrativo();
   $arrTipoActo = $claTipoActo->cargarTipoActo( $_POST['seqTipoActo'] );
   $objTipoActo = array_shift( $arrTipoActo );
   
   $arrEstados = estadosProceso();
   // Estados a mostrar cuando es Recurso de Reposición (4)
   /*$sql = "SELECT seqEstadoProceso, CONCAT(txtEtapa,' - ',txtEstadoProceso) AS txtEstadoProceso
			FROM 
				T_FRM_ESTADO_PROCESO 
			INNER JOIN T_FRM_ETAPA ON (T_FRM_ESTADO_PROCESO.seqEtapa = T_FRM_ETAPA.seqEtapa)
			WHERE T_FRM_ESTADO_PROCESO.seqEtapa IN (4, 5) 
			OR seqEstadoProceso = 39
		";*/
	$sql = "SELECT seqEstadoProceso, CONCAT(txtEtapa,' - ',txtEstadoProceso) AS txtEstadoProceso
			FROM 
				T_FRM_ESTADO_PROCESO 
			INNER JOIN T_FRM_ETAPA ON (T_FRM_ESTADO_PROCESO.seqEtapa = T_FRM_ETAPA.seqEtapa)
			WHERE T_FRM_ESTADO_PROCESO.seqEstadoProceso IN (7, 41, 46, 54, 57, 8, 52, 21) 
			ORDER BY T_FRM_ESTADO_PROCESO.seqEtapa
		";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrEstadosReposicion[ $objRes->fields['seqEstadoProceso'] ] = $objRes->fields['txtEstadoProceso'];
		$objRes->MoveNext();
	}

   $claSmarty->assign( "objTipoActo" , $objTipoActo );
   $claSmarty->assign( "arrEstados" , $arrEstados );
   $claSmarty->assign( "arrEstadosReposicion" , $arrEstadosReposicion );
   $claSmarty->display( "actosAdministrativos/plantillaActoAdministrativo.tpl" );
   
   
   
?>
