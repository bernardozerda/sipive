<?php

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );

   $txtCondicionResolucion = "";
   if( trim( $_POST['resolucion'] ) != "" ){
      $arrResolucion = mb_split( "#" , $_POST['resolucion'] );
      $txtCondicionResolucion  = "AND numActo = " . $arrResolucion[0] . " ";
      $txtCondicionResolucion .= "AND fchActo = '" . $arrResolucion[1] . "'";
   }
   
   $txtCondicionFormulario = "";
   if( ( ! empty( $_POST['formularios'] ) ) and intval( $_POST['formularios'][0] ) != 0 ){
      $txtCondicionFormulario = "AND fac.seqFormulario IN (" . implode(",", $_POST['formularios'] ) . ")";
   }
   
   /* 
    * ULTIMOS ACTOS ADMINISTRATIVOS DE ASIGNACION
    * PARA CADA HOGAR EN ETAPA DE DESEMBOLSO QUE 
    * NO HAYA FINALIZADO EL PROCESO Y ADMAS LOS
    * QUE ESTAN EN ESTADO ASIGNADO
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
      $txtCondicionFormulario
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
   
   $sql = "
      SELECT 
         fac.seqFormularioActo,
         hvi.numActo,
         hvi.fchActo,
         CONCAT( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) as txtEstadoProceso,
         UPPER(
           CONCAT(
             TRIM( ciu.txtNombre1 ), ' ',
             IF( TRIM( ciu.txtNombre2 ) <> '' , CONCAT(TRIM( ciu.txtNombre2 ) , ' ' ), '' ),
             TRIM( ciu.txtApellido1 ), ' ',
             IF( TRIM( ciu.txtApellido2 ) <> '' , TRIM( ciu.txtApellido2 ) , '' )
           ) 
         ) as txtNombre,
         ciu.numDocumento
      FROM T_AAD_HOGARES_VINCULADOS hvi
      INNER JOIN  T_AAD_FORMULARIO_ACTO fac on fac.seqFormularioActo = hvi.seqFormularioActo
      INNER JOIN  T_FRM_FORMULARIO frm on fac.seqFormulario = frm.seqFormulario
      INNER JOIN  T_FRM_ESTADO_PROCESO epr on frm.seqEstadoProceso = epr.seqEstadoProceso
      INNER JOIN  T_FRM_ETAPA eta on epr.seqEtapa = eta.seqEtapa
      INNER JOIN  T_FRM_HOGAR hog on frm.seqFormulario = hog.seqFormulario
      INNER JOIN  T_CIU_CIUDADANO ciu on ciu.seqCiudadano = hog.seqCiudadano
      WHERE hvi.seqFormularioActo in ( " . implode(",", $arrFormularioActo ) . " )
        AND hog.seqParentesco = 1           
        $txtCondicionResolucion
      ORDER BY hvi.fchActo, hvi.numActo
   ";
   $objRes = $aptBd->execute( $sql );
   $arrCiudadanos = array();
   while( $objRes->fields ){

      $numDocumento = $objRes->fields['numDocumento'];    
      $arrCiudadanos[$numDocumento][] = $_POST['bolEstado'];
      $arrCiudadanos[$numDocumento][] = $objRes->fields['seqFormularioActo'];
      $arrCiudadanos[$numDocumento][] = $objRes->fields['numActo'];
      $arrCiudadanos[$numDocumento][] = $objRes->fields['fchActo'];
      $arrCiudadanos[$numDocumento][] = $objRes->fields['numDocumento'];
      $arrCiudadanos[$numDocumento][] = $objRes->fields['txtNombre'];
      $arrCiudadanos[$numDocumento][] = $objRes->fields['txtEstadoProceso'];
      
      $objRes->MoveNext();
   }
   
   /**
    * imprimir los resultados
    */
   
   //echo "1|1|2009/06/12|2|" . mb_ereg_replace("\n", "#", $sql ) . "|estado\n";
   
//   foreach( $_POST as $clave => $valor ){
//      echo "1|1|2009/06/12|2|#$clave#|#$valor#\n";
//   }
   
   
   foreach( $arrCiudadanos as $numDocumento => $arrFila ){
      echo implode( $_POST['separador'] , $arrFila ) . $_POST['salto'];
   }
   
?>
