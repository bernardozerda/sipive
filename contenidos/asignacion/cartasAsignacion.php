<?php

   /*
    * FORMULARIO PARA OBTENER LAS CARTAS DE ASIGNACION
    * @author Bernardo Zerda
    * @version 1.0 Noviembre 2013
    */

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );
   
   /**
    * SECUENCIALES DE LOS ACTOS ADMINISTRATIVOS
    * MAS RECIENTES DE LOS HOGARES QUE ESTAN EN 
    * DESEMBOLSO O ASIGNACION Y QUE NO HAYAN
    * TERMINADO EL PROCESO DEL SUBSIDIO
    */
   
   $sql = "
      SELECT
        fac.seqFormulario,
        MAX(fac.seqFormularioActo) as seqFormularioActo
      FROM T_AAD_FORMULARIO_ACTO fac
      INNER JOIN T_AAD_HOGARES_VINCULADOS hvi on fac.seqFormularioActo = hvi.seqFormularioActo
      INNER JOIN T_FRM_FORMULARIO frm on fac.seqFormulario = frm.seqFormulario
      INNER JOIN T_FRM_ESTADO_PROCESO epr on frm.seqEstadoProceso = epr.seqEstadoProceso
      INNER JOIN T_FRM_ETAPA eta on epr.seqEtapa = eta.seqEtapa
      WHERE hvi.seqTipoActo = 1
      AND ( eta.seqEtapa = 5 
         OR epr.seqEstadoProceso = 15 )
      AND epr.seqEstadoProceso not in ( 40 , 33 )
      GROUP BY fac.seqFormulario
   "; 
   
   $objRes = $aptBd->execute( $sql );
   $arrFormularioActo = array();
   while( $objRes->fields ){
      $seqFormulario = $objRes->fields['seqFormulario'];
      $seqFormularioActo = $objRes->fields['seqFormularioActo'];
      $arrFormularioActo[$seqFormulario] = $seqFormularioActo;
      $objRes->MoveNext();
   }
   
   /**
    * OBTIENE LOS NUMEROS Y FECHAS 
    * DE LOS ACTOS ADMINISTRATIVOS DE LOS 
    * SECUENCIALES QUE SALIERON EN LA CONSULTA
    * ANTERIOR
    */
   $arrActos = array();
   if( ! empty( $arrFormularioActo ) ){
      $sql = "
         SELECT DISTINCT
         hvi.numActo,
         hvi.fchActo
         FROM T_AAD_HOGARES_VINCULADOS hvi
         WHERE hvi.seqFormularioActo in ( " . implode(",", $arrFormularioActo ) . " )     
         ORDER BY fchActo, numActo
      ";
      $objRes = $aptBd->execute( $sql );
      $arrActos = array();
      while( $objRes->fields ){
         $txtClave = $objRes->fields['numActo'] . "#" . $objRes->fields['fchActo'];
         $txtValor = $objRes->fields['numActo'] . " del " . $objRes->fields['fchActo'];
         $arrActos[ $txtClave ] = $txtValor;
         $objRes->MoveNext();
      }
   }
   
   $claSmarty->assign( "arrActos" , $arrActos );
   $claSmarty->display( "asignacion/cartasAsignacion.tpl" );

?>
