<?php

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );
   
   $claTipoActo = new TipoActoAdministrativo();
   $arrTipoActo = $claTipoActo->cargarTipoActo();
   
   $arrActos    = array();
   $claActo     = new ActoAdministrativo();
   $objActo     = new ActoAdministrativo();
   
   if( intval( $_POST['numActo'] ) != 0 and trim( $_POST['fchActo'] ) != "" ){
      
      $arrActos    = $claActo->cargarActoAdministrativo( $_POST['numActo'] , $_POST['fchActo'] );
      $objActo     = $arrActos[ $_POST['numActo'] . strtotime( $_POST['fchActo'] ) ];

      switch( $_POST['seqTipoActo'] ){
         case 1: // asignados
            $objActo->obtenerGiros();
            break;
         case 2: // modificatoria
            $objActo->obtenerModificaciones();      
            break;
         case 3: // inhabilitados
            $objActo->obtenerInhabilidades();
            break;
         case 4: // recursos de reposicion
            $objActo->obtenerResultado();
            break;
         case 5: // no asignado
            $objActo->obtenerNoAsignados();
            break;
         case 6: // renuncia
            $objActo->obtenerRenuncias();
            break;
         case 7: // notificaciones
            $objActo->obtenerNotificaciones();
            break;
         case 8: // indexacion
            $objActo->obtenerIndexacion();
            break;
		 case 9: // perdida
            $objActo->obtenerPerdidas();
            break;
		 case 10: // revocatoria
            $objActo->obtenerRevocatorias();
            break;
         default: // asignados
            $objActo->obtenerGiros();
            break;
      }
      
   }elseif( intval( $_POST['seqTipoActo'] ) == 7 ){
      
      // si es una notificacion obtiene el numero del acto ( secuencial )
      $sql = "
         SELECT 
            COUNT( numActo ) as cuenta
         FROM T_AAD_ACTO_ADMINISTRATIVO
         WHERE seqTipoActo = " . $_POST['seqTipoActo'] . "
      ";
      $objRes = $aptBd->execute( $sql );
      $_POST['numActo'] = ( $objRes->fields['cuenta']  + 1 );
      
   }
   
   $claSmarty->assign( "arrTipoActo" , $arrTipoActo );
   $claSmarty->assign( "arrActos" , $arrActos );
   $claSmarty->assign( "arrPost" , $_POST );
   $claSmarty->assign( "objActo" , $objActo );
   $claSmarty->display( "actosAdministrativos/informacionActo.tpl" );
   
?>
