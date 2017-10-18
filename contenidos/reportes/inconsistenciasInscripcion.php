<?php

$txtPrefijoRuta = "../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Usuario.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

/*********************************************************************************************************************
 * CONFIGURACION DE PARAMETROS Y VARIABLES DE INICIO
 *********************************************************************************************************************/

// los usuarios deben pertenecer al grupo de informadores (5)
// pero no cuentan para el reporte si pertenecen a estos grupos
$arrParametros['gruposExcluidos'][] = 23; // administradores del sistema
$arrParametros['gruposExcluidos'][] = 14; // Juridica
$arrParametros['gruposExcluidos'][] = 15; // Tecnica

// solo se incluyen ests modalidades
$arrParametros['modalidades'] = obtenerDatosTabla(
    "t_frm_modalidad",
    array("seqModalidad","txtModalidad"),
    "seqModalidad",
    "seqPlanGobierno = 3"
);

// rango de ingreso de ciudadano
$arrParametros['ingresosCiudadano']['< $100K']['minimo']        = 0;
$arrParametros['ingresosCiudadano']['< $100K']['maximo']        = 100000;
$arrParametros['ingresosCiudadano']['$100K - <$200K']['minimo'] = 100000;
$arrParametros['ingresosCiudadano']['$100K - <$200K']['maximo'] = 200000;
$arrParametros['ingresosCiudadano']['> 2 SMMLV']['minimo']      = ($arrConfiguracion['constantes']['salarioMinimo'] * 2);
$arrParametros['ingresosCiudadano']['> 2 SMMLV']['maximo']      = 6000000;
$arrParametros['ingresosCiudadano']['> $6M']['minimo']          = 6000000;
$arrParametros['ingresosCiudadano']['> $6M']['maximo']          = 0;

// rango de ingreso del hogar
$arrParametros['ingresosHogar']['0']['minimo']         = 0;
$arrParametros['ingresosHogar']['0']['maximo']         = 1;
$arrParametros['ingresosHogar']['< $100K']['minimo']   = 0;
$arrParametros['ingresosHogar']['< $100K']['maximo']   = 100000;
$arrParametros['ingresosHogar']['> 2 SMMLV']['minimo'] = ($arrConfiguracion['constantes']['salarioMinimo'] * 2);
$arrParametros['ingresosHogar']['> 2 SMMLV']['maximo'] = ($arrConfiguracion['constantes']['salarioMinimo'] * 5);
$arrParametros['ingresosHogar']['> 2 SMMLV']['minimo'] = ($arrConfiguracion['constantes']['salarioMinimo'] * 5);
$arrParametros['ingresosHogar']['> 2 SMMLV']['maximo'] = ($arrConfiguracion['constantes']['salarioMinimo'] * 8);
$arrParametros['ingresosHogar']['> $6M']['minimo']     = ($arrConfiguracion['constantes']['salarioMinimo'] * 8);
$arrParametros['ingresosHogar']['> $6M']['maximo']     = 0;

// afiliacion a salud (Ninguno o fuerzas especiales)
$arrParametros['salud'] = obtenerDatosTabla(
    "t_ciu_salud",
    array("seqSalud","txtSalud"),
    "seqSalud",
    "seqSalud in (0,4)"
);

// rangos de cohabitacion
$arrParametros['cohabitacion']['6 - 10']['minimo']    = 6;
$arrParametros['cohabitacion']['6 - 10']['maximo']    = 10;
$arrParametros['cohabitacion']['11 - 15']['minimo']   = 10;
$arrParametros['cohabitacion']['11 - 15']['maximo']   = 15;
$arrParametros['cohabitacion']['16 - 20']['minimo']   = 15;
$arrParametros['cohabitacion']['16 - 20']['maximo']   = 20;
$arrParametros['cohabitacion']['> 20']['minimo']      = 20;
$arrParametros['cohabitacion']['> 20']['maximo']      = 0;

// rangos de hacinamiento
$arrParametros['hacinamiento']['6 - 10']['minimo']    = 6;
$arrParametros['hacinamiento']['6 - 10']['maximo']    = 10;
$arrParametros['hacinamiento']['11 - 15']['minimo']   = 10;
$arrParametros['hacinamiento']['11 - 15']['maximo']   = 15;
$arrParametros['hacinamiento']['16 - 20']['minimo']   = 15;
$arrParametros['hacinamiento']['16 - 20']['maximo']   = 20;
$arrParametros['hacinamiento']['> 20']['minimo']      = 20;
$arrParametros['hacinamiento']['> 20']['maximo']      = 0;

// rango de ahorro
$arrParametros['ahorro']['Ahorro > 16M']['minimo']       = 16000000;
$arrParametros['ahorro']['Ahorro > 16M']['maximo']       = 20000000;
$arrParametros['ahorro']['Ahorro $20M - $25M']['minimo'] = 20000000;
$arrParametros['ahorro']['Ahorro $20M - $25M']['maximo'] = 25000000;
$arrParametros['ahorro']['Ahorro $25M - $30M']['minimo'] = 25000000;
$arrParametros['ahorro']['Ahorro $25M - $30M']['maximo'] = 30000000;
$arrParametros['ahorro']['Ahorro > $30M']['minimo']      = 30000000;
$arrParametros['ahorro']['Ahorro > $30M']['maximo']      = 40000000;
$arrParametros['ahorro']['Ahorro > $40M']['minimo']      = 40000000;
$arrParametros['ahorro']['Ahorro > $40M']['maximo']      = 80000000;
$arrParametros['ahorro']['Ahorro > $80M']['minimo']      = 80000000;
$arrParametros['ahorro']['Ahorro > $80M']['maximo']      = 0;

// rango de cesantias
$arrParametros['cesantias']['> 30M']['minimo']       = 30000000;
$arrParametros['cesantias']['> 30M']['maximo']       = 0;

// rango de credito
$arrParametros['credito']['> 70M']['minimo']       = 70000000;
$arrParametros['credito']['> 70M']['maximo']       = 0;

// palabras clave
$arrParametros['seguimientos'][] = "elimina";
$arrParametros['seguimientos'][] = "quita";
$arrParametros['seguimientos'][] = "saca";
$arrParametros['seguimientos'][] = "exclu";
$arrParametros['seguimientos'][] = "radicado";
$arrParametros['seguimientos'][] = "defunc";
$arrParametros['seguimientos'][] = "desvincul";

// deduccion de entidades por el correo del usuario
$arrParametros['entidad']["habitatbogota.gov.co"]       = "SDHT";
$arrParametros['entidad']["sdis.gov.co"]                = "SDIS";
$arrParametros['entidad']["alcaldiabogota.gov.co"]      = "ACAV";
$arrParametros['entidad']["cajaviviendapopular.gov.co"] = "CVP";

// estados del proceso
$arrParametros['estados'] = estadosProceso();

$seqProyecto = $_SESSION['seqProyecto'];

/*********************************************************************************************************************
 * TRATAMIENTO DE FECHAS
 *********************************************************************************************************************/

$fchInicial = (esFechaValida($_GET['inicio']))? $_GET['inicio'] : null;
$fchFinal   = (esFechaValida($_GET['final']))?  $_GET['final']  : null;
switch(true){
    case $fchInicial == null and $fchFinal == null:
        $fchFinal   = date("Y-m-d");
        $fchInicial = date("Y-m-d", strtotime("-1 week" , strtotime($fchFinal)));
        break;
    case $fchInicial == null and $fchFinal:
        $fchInicial = date("Y-m-d", strtotime("-1 week" , strtotime($fchFinal)));
        break;
    case $fchInicial != null and $fchFinal == null:
        $fchFinal = date("Y-m-d", strtotime("+1 week" , strtotime($fchInicial)));
        break;
}

/*********************************************************************************************************************
 * OBTENCION DE LOS DATOS VALIDOS PARA EL REPORTE
 *********************************************************************************************************************/

$sql = "
    SELECT
      seg.seqSeguimiento,
      seg.seqFormulario,
      seg.seqUsuario,
      seg.txtComentario,
      seg.txtCambios
    FROM t_seg_seguimiento seg
    WHERE seg.fchMovimiento >= '" . $fchInicial . " 00:00:00'
    AND seg.fchMovimiento <= '" . $fchFinal . " 23:59:59'
    AND seg.bolMostrar = 1
    ORDER BY seg.fchMovimiento DESC
";
$objRes = $aptBd->execute($sql);
while($objRes->fields){

    $claFormulario = null;
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($objRes->fields['seqFormulario']);

    $claUsuario = null;
    $claUsuario = array_shift(Usuario::cargarUsuario($objRes->fields['seqUsuario']));
    $claUsuario->seqUsuario = $objRes->fields['seqUsuario'];

    // verifica que el registro sea valido
    if(
            isset( $arrParametros['modalidades'][$claFormulario->seqModalidad] )
        and isset( $claUsuario->arrGrupos[$seqProyecto][5] )
        and empty( array_intersect( $claUsuario->arrGrupos[$seqProyecto] , $arrParametros['gruposExcluidos'] ) )
    ){
        $seqFormulario = $objRes->fields['seqFormulario'];
        $seqUsuario    = $objRes->fields['seqUsuario'];

        $arrRegistros[] = $objRes->fields;
        $arrFormularios[$seqFormulario] = $claFormulario;
        $arrUsuarios[$seqFormulario][$seqUsuario] = $claUsuario;

    }

    $objRes->MoveNext();
}

/***********************************************************************************************************************
 * PROCESAMIENTO DEL REPORTE
 **********************************************************************************************************************/

if( ! empty( $arrFormularios ) ) {
    foreach ($arrFormularios as $seqFormulario => $claFormulario) {

        /***************************************************************************************************************
         * VALIDACIONES DE CIUDADANO
         ***************************************************************************************************************/

        foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {

            // ingresos de ciudadanos
            foreach ($arrParametros['ingresosCiudadano'] as $txtRango => $arrRango) {
                if( $arrRango['maximo'] != 0 ){
                    if ($claCiudadano->valIngresos > $arrRango['minimo'] and $claCiudadano->valIngresos <= $arrRango['maximo']) {
                        $arrReporte[$seqFormulario]['ingresosCiudadano'][$seqCiudadano]['causa'] = "Ingresos ciudadano";
                        $arrReporte[$seqFormulario]['ingresosCiudadano'][$seqCiudadano]['detalle'] = $txtRango;
                        $arrReporte[$seqFormulario]['ingresosCiudadano'][$seqCiudadano]['valor'] = $claCiudadano->valIngresos;
                    }
                }else{
                    if ($claCiudadano->valIngresos > $arrRango['minimo']) {
                        $arrReporte[$seqFormulario]['ingresosCiudadano'][$seqCiudadano]['causa'] = "Ingresos ciudadano";
                        $arrReporte[$seqFormulario]['ingresosCiudadano'][$seqCiudadano]['detalle'] = $txtRango;
                        $arrReporte[$seqFormulario]['ingresosCiudadano'][$seqCiudadano]['valor'] = $claCiudadano->valIngresos;
                    }
                }
            }

            // afiliacion a salud
            if( isset( $arrParametros['salud'][$claCiudadano->seqSalud] ) ){
                $arrReporte[$seqFormulario]['salud'][$seqCiudadano]['causa'] = "Afiliación a salud";
                $arrReporte[$seqFormulario]['salud'][$seqCiudadano]['detalle'] = null;
                $arrReporte[$seqFormulario]['salud'][$seqCiudadano]['valor'] = $arrParametros['salud'][$claCiudadano->seqSalud];
            }
        }

        // cohabitacion
        if( $claFormulario->numHabitaciones != 0 ) {
            foreach ($arrParametros['cohabitacion'] as $txtRango => $arrRango) {
                if ($arrRango['maximo'] != 0) {
                    if ($claFormulario->numHabitaciones > $arrRango['minimo'] and $claFormulario->numHabitaciones <= $arrRango['maximo']) {
                        $arrReporte[$seqFormulario]['cohabitacion']['causa'] = "Cohabitación";
                        $arrReporte[$seqFormulario]['cohabitacion']['detalle'] = $txtRango;
                        $arrReporte[$seqFormulario]['cohabitacion']['valor'] = $claFormulario->numHabitaciones;
                    }
                } else {
                    if ($claFormulario->numHabitaciones > $arrRango['minimo']) {
                        $arrReporte[$seqFormulario]['cohabitacion']['causa'] = "Cohabitación";
                        $arrReporte[$seqFormulario]['cohabitacion']['detalle'] = $txtRango;
                        $arrReporte[$seqFormulario]['cohabitacion']['valor'] = $claFormulario->numHabitaciones;
                    }
                }
            }
        }else{
            $arrReporte[$seqFormulario]['cohabitacion']['causa'] = "Cohabitación";
            $arrReporte[$seqFormulario]['cohabitacion']['detalle'] = "Verificar";
            $arrReporte[$seqFormulario]['cohabitacion']['valor'] = $claFormulario->numHabitaciones;
        }

        // hacinamiento
        if( $claFormulario->numHacinamiento != 0 ) {
            foreach ($arrParametros['hacinamiento'] as $txtRango => $arrRango) {
                if ($arrRango['maximo'] != 0) {
                    if ($claFormulario->numHacinamiento > $arrRango['minimo'] and $claFormulario->numHacinamiento <= $arrRango['maximo']) {
                        $arrReporte[$seqFormulario]['hacinamiento']['causa'] = "Hacinamiento";
                        $arrReporte[$seqFormulario]['hacinamiento']['detalle'] = $txtRango;
                        $arrReporte[$seqFormulario]['hacinamiento']['valor'] = $claFormulario->numHacinamiento;
                    }
                } else {
                    if ($claFormulario->numHacinamiento > $arrRango['minimo']) {
                        $arrReporte[$seqFormulario]['hacinamiento']['causa'] = "Hacinamiento";
                        $arrReporte[$seqFormulario]['hacinamiento']['detalle'] = $txtRango;
                        $arrReporte[$seqFormulario]['hacinamiento']['valor'] = $claFormulario->numHacinamiento;
                    }
                }
            }
        }else{
            $arrReporte[$seqFormulario]['hacinamiento']['causa'] = "Hacinamiento";
            $arrReporte[$seqFormulario]['hacinamiento']['detalle'] = "Verificar";
            $arrReporte[$seqFormulario]['hacinamiento']['valor'] = $claFormulario->numHacinamiento;
        }

        // ingresos del hogar
        foreach ($arrParametros['ingresosHogar'] as $txtRango => $arrRango) {
            if( $arrRango['maximo'] != 0 ){
                if ($claFormulario->valIngresoHogar > $arrRango['minimo'] and $claFormulario->valIngresoHogar <= $arrRango['maximo']) {
                    $arrReporte[$seqFormulario]['ingresosHogar']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['ingresosHogar']['valor'] = $claFormulario->valIngresoHogar;
                    $arrReporte[$seqFormulario]['ingresosHogar']['causa'] = "Ingresos hogar";
                }
            }else{
                if ($claFormulario->valIngresoHogar > $arrRango['minimo']) {
                    $arrReporte[$seqFormulario]['ingresosHogar']['causa'] = "Ingresos hogar";
                    $arrReporte[$seqFormulario]['ingresosHogar']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['ingresosHogar']['valor'] = $claFormulario->valIngresoHogar;
                }
            }
        }

        // ahorros
        $valAhorro = $claFormulario->valSaldoCuentaAhorro + $claFormulario->valSaldoCuentaAhorro2;
        foreach ($arrParametros['ahorro'] as $txtRango => $arrRango) {
            if( $arrRango['maximo'] != 0 ){
                if ($valAhorro > $arrRango['minimo'] and $valAhorro <= $arrRango['maximo']) {
                    $arrReporte[$seqFormulario]['ahorro']['causa'] = "Recursos propios (Ahorro)";
                    $arrReporte[$seqFormulario]['ahorro']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['ahorro']['valor'] = $claFormulario->valSaldoCuentaAhorro ." + " . $claFormulario->valSaldoCuentaAhorro2 . " = " . $valAhorro;
                }
            }else{
                if ($valAhorro > $arrRango['minimo']) {
                    $arrReporte[$seqFormulario]['ahorro']['causa'] = "Recursos propios (Ahorro)";
                    $arrReporte[$seqFormulario]['ahorro']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['ahorro']['valor'] = $claFormulario->valSaldoCuentaAhorro ." + " . $claFormulario->valSaldoCuentaAhorro2 . " = " . $valAhorro;
                }
            }
        }

        // cesantias
        foreach ($arrParametros['cesantias'] as $txtRango => $arrRango) {
            if( $arrRango['maximo'] != 0 ){
                if ($claFormulario->valSaldoCesantias > $arrRango['minimo'] and $claFormulario->valSaldoCesantias <= $arrRango['maximo']) {
                    $arrReporte[$seqFormulario]['cesantias']['causa'] = "Recursos propios (Cesantias)";
                    $arrReporte[$seqFormulario]['cesantias']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['cesantias']['valor'] = $claFormulario->valSaldoCesantias;
                }
            }else{
                if ($claFormulario->valSaldoCesantias > $arrRango['minimo']) {
                    $arrReporte[$seqFormulario]['cesantias']['causa'] = "Recursos propios (Cesantias)";
                    $arrReporte[$seqFormulario]['cesantias']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['cesantias']['valor'] = $claFormulario->valSaldoCesantias;
                }
            }
        }

        // credito
        foreach ($arrParametros['credito'] as $txtRango => $arrRango) {
            if( $arrRango['maximo'] != 0 ){
                if ($claFormulario->valCredito > $arrRango['minimo'] and $claFormulario->valCredito <= $arrRango['maximo']) {
                    $arrReporte[$seqFormulario]['credito']['causa'] = "Recursos propios (Credito)";
                    $arrReporte[$seqFormulario]['credito']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['credito']['valor'] = $claFormulario->valCredito;
                }
            }else{
                if ($claFormulario->valCredito > $arrRango['minimo']) {
                    $arrReporte[$seqFormulario]['credito']['causa'] = "Recursos propios (Credito)";
                    $arrReporte[$seqFormulario]['credito']['detalle'] = $txtRango;
                    $arrReporte[$seqFormulario]['credito']['valor'] = $claFormulario->valCredito;
                }
            }
        }

        // actualizacion
        if( $claFormulario->numHacinamiento == 0 and $claFormulario->numHabitaciones == 0 ){
            $arrReporte[$seqFormulario]['actualizacion']['causa'] = "Actualización de datos";
            $arrReporte[$seqFormulario]['actualizacion']['detalle'] = null;
            $arrReporte[$seqFormulario]['actualizacion']['valor'] = "Cohabitación: " . $claFormulario->numHabitaciones . ", Hacinamiento: " . $claFormulario->numHacinamiento;
        }

        // Suma de recursos propios
        $valRecursosPropios =
            $claFormulario->valSaldoCuentaAhorro +
            $claFormulario->valSaldoCuentaAhorro2 +
            $claFormulario->valSaldoCesantias +
            $claFormulario->valCredito +
            $claFormulario->valAporteLote;

        // subsidios
        $valSubsidios =
            $claFormulario->valSubsidioNacional +
            $claFormulario->valDonacion;

        // total recursos
        $valTotalRecursos = $valRecursosPropios + $valSubsidios;

        // valor calculado del aporte, obliga la modalidad a 12 (CF), despues la pone como estaba
        $seqModalidad = $claFormulario->seqModalidad;
        $claFormulario->seqModalidad = 12;
        $valAspiraSubsidio = valorSubsidio($claFormulario);
        $claFormulario->seqModalidad = $seqModalidad;

        $txtVictima = ( $claFormulario->bolDesplazado == 1 )? "Víctima" : "Vulnerable";

        // nombre de modalidad
        $txtModalidad = $arrParametros['modalidades'][ $claFormulario->seqModalidad ];

        if( $claFormulario->seqModalidad == 12 ){
            if( ( $valTotalRecursos + $valAspiraSubsidio ) < ($arrConfiguracion['constantes']['salarioMinimo'] * 70) ){
                $arrReporte[$seqFormulario]['modalidad'][$txtModalidad]['causa'] = "Modalidad de postulación";
                $arrReporte[$seqFormulario]['modalidad'][$txtModalidad]['detalle'] = "$txtVictima Verificar Modalidad CF < 35 SMMLV";
                $arrReporte[$seqFormulario]['modalidad'][$txtModalidad]['valor'] = "(Rec) " . $valTotalRecursos . " + (Apo) " . $valAspiraSubsidio . " = (Tot) " . ( $valTotalRecursos + $valAspiraSubsidio );
            }
        }elseif( $claFormulario->seqModalidad == 13 ){
            if( ( $valTotalRecursos + $valAspiraSubsidio) > ($arrConfiguracion['constantes']['salarioMinimo'] * 70) ){
                $arrReporte[$seqFormulario]['modalidad'][$txtModalidad]['causa'] = "Modalidad de postulación";
                $arrReporte[$seqFormulario]['modalidad'][$txtModalidad]['detalle'] = "$txtVictima Verificar Modalidad CF > 70 SMMLV";
                $arrReporte[$seqFormulario]['modalidad'][$txtModalidad]['valor'] = "(Rec) " . $valTotalRecursos . " + (Apo) " . $valAspiraSubsidio . " = (Tot) " . ( $valTotalRecursos + $valAspiraSubsidio );
            }
        }

    }
}

if( ! empty( $arrRegistros ) ) {
    foreach ($arrRegistros as $arrSeguimiento) {

        $arrCambios = mb_split("<br>", mb_strtolower($arrSeguimiento['txtCambios']));
        foreach ($arrCambios as $numLinea => $txtLinea) {
            if (strpos($txtLinea, "adicionado") === false and strpos($txtLinea, "eliminado") === false) {
                unset($arrCambios[$numLinea]);
            } else {
                $arrCambios[$numLinea] = mb_ereg_replace("&nbsp;", "", trim($txtLinea));
            }
        }

        if (!empty($arrCambios)) {

            $arrNombres = array();
            foreach ($arrCambios as $numCambio => $txtLinea) {
                $txtNombre = trim(array_shift(mb_split("\[", $txtLinea)));
                if( strpos( $txtLinea , "adicionado" ) !== false ){
                    $arrNombres[$txtNombre] = $arrNombres[$txtNombre] + 1;
                }else{
                    $arrNombres[$txtNombre] = $arrNombres[$txtNombre] - 1;
                }
            }

            foreach( $arrNombres as $txtNombre => $numBandera ){

                if( $numBandera < 0 ){

                    $bolHayJustificacion = false;
                    foreach( $arrParametros['seguimientos'] as $txtPalabra ){
                        if( strpos( mb_strtolower($arrSeguimiento['txtComentario']) , $txtPalabra ) ){
                            $bolHayJustificacion = true;
                        }
                    }

                    $seqSeguimiento = $arrSeguimiento['seqSeguimiento'];
                    $seqFormulario = $arrSeguimiento['seqFormulario'];
                    if( $bolHayJustificacion == false ){
                        $arrReporte[$seqFormulario]['seguimiento'][$seqSeguimiento]['detalle'] = "Sin justificación";
                    }else{
                        $arrReporte[$seqFormulario]['seguimiento'][$seqSeguimiento]['detalle'] = "Por Verificar";
                    }
                    $arrReporte[$seqFormulario]['seguimiento'][$seqSeguimiento]['causa'] = "Eliminacion de ciudadano";
                    $arrReporte[$seqFormulario]['seguimiento'][$seqSeguimiento]['valor'] = "[$seqSeguimiento] " . mb_strtolower($arrSeguimiento['txtComentario']) . "";
                    $arrReporte[$seqFormulario]['seguimiento'][$seqSeguimiento]['nombre'] = mb_strtoupper($txtNombre);

                }

            }


        }

    }
}

//pr($arrReporte);

/***********************************************************************************************************************
 * IMPRIMIENDO DEL REPORTE
 **********************************************************************************************************************/

// fuentes para el archivo
$arrFuentes['default']['font']['name'] = "Calibri";
$arrFuentes['default']['font']['size'] = 10;
$arrFuentes['titulo']['fill']['type']  = PHPExcel_Style_Fill::FILL_SOLID;
$arrFuentes['titulo']['fill']['color'] = array('rgb' => 'E4E4E4');
$arrFuentes['titulo']['font']['bold']  = true;
$arrFuentes['titulo']['font']['color'] = array('rgb' => '000000');

$arrTitulos[0] = "Formulario";
$arrTitulos[1] = "Estado";
$arrTitulos[2] = "Modalidad";
$arrTitulos[3] = "Victima";
$arrTitulos[4] = "Documento PPAL";
$arrTitulos[5] = "Nombre PPAL PPAL";
$arrTitulos[6] = "Documento";
$arrTitulos[7] = "Nombre";
$arrTitulos[8] = "Reporte";
$arrTitulos[9] = "Causa";
$arrTitulos[10] = "Detalle";
$arrTitulos[11] = "Valor";
$arrTitulos[12] = "Ultimo Usuario";
$arrTitulos[13] = "Usuarios";

// Creacion del libro de excel
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("SiPIVE - SDHT");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Revision de datos"); // titulo de excel limitado a 30 caracteres
$objPHPExcel->getDefaultStyle()->applyFromArray($arrFuentes['default']);

// titulos
foreach($arrTitulos as $numColumna => $txtTiutlo){
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($numColumna, 1, $txtTiutlo, flase);
    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($numColumna)->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($numColumna, 1)->applyFromArray($arrFuentes['titulo']);
}

// contenido
if (!empty($arrReporte)) {
    $numFila = 2;
    foreach ($arrReporte as $seqFormulario => $arrInconsistencias) {

        $objCiudadanoPrincipal = null;
        foreach ($arrFormularios[$seqFormulario]->arrCiudadano as $seqCiudadano => $claCiudadano) {
            if ($claCiudadano->seqParentesco == 1) {
                $objCiudadanoPrincipal = $claCiudadano;
            }
        }

        $txtNombrePrincipal = $objCiudadanoPrincipal->txtNombre1 . " " .
            $objCiudadanoPrincipal->txtNombre2 . " " .
            $objCiudadanoPrincipal->txtApellido1 . " " .
            $objCiudadanoPrincipal->txtApellido2;

        $seqEstadoProceso = $arrFormularios[$seqFormulario]->seqEstadoProceso;

        $seqModalidad = $arrFormularios[$seqFormulario]->seqModalidad;
        $txtModalidad = $arrParametros['modalidades'][$seqModalidad];

        $txtDesplazado = ($arrFormularios[$seqFormulario]->bolDesplazado == 1)? "SI" : "NO";

        foreach ($arrInconsistencias as $txtReporte => $arrDatos) {

            switch ($txtReporte) {
                case "ingresosCiudadano":
                    foreach ($arrDatos as $seqCiudadano => $arrCausas) {

                        $txtNombre = $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtNombre1 . " " .
                            $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtNombre2 . " " .
                            $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtApellido1 . " " .
                            $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtApellido2;

                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->numDocumento, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, strtoupper($txtNombre), flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Ingresos del Ciudadano", flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrCausas["causa"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrCausas["detalle"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrCausas["valor"], flase);

                        $i = 0;
                        $txtUltimoUsuario = "";
                        $txtUsuarios      = "";
                        foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                            if( $i == 0 ){
                                $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                            }
                            $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                            $i++;

                        }
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                        $numFila++;

                    }
                    break;
                case "salud":
                    foreach ($arrDatos as $seqCiudadano => $arrCausas) {

                        $txtNombre = $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtNombre1 . " " .
                            $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtNombre2 . " " .
                            $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtApellido1 . " " .
                            $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->txtApellido2;

                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]->numDocumento, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, strtoupper($txtNombre), flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Afiliación a Salud", flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrCausas["causa"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrCausas["detalle"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrCausas["valor"], flase);

                        $i = 0;
                        $txtUltimoUsuario = "";
                        $txtUsuarios      = "";
                        foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                            if( $i == 0 ){
                                $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                            }
                            $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                            $i++;

                        }
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                        $numFila++;

                    }
                    break;
                case "cohabitacion":

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Cohabitación", flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrDatos["causa"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrDatos["detalle"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrDatos["valor"], flase);

                    $i = 0;
                    $txtUltimoUsuario = "";
                    $txtUsuarios      = "";
                    foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                        if( $i == 0 ){
                            $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                        }
                        $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                        $i++;

                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                    $numFila++;
                    break;
                case "hacinamiento":

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Hacinamiento", flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrDatos["causa"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrDatos["detalle"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrDatos["valor"], flase);

                    $i = 0;
                    $txtUltimoUsuario = "";
                    $txtUsuarios      = "";
                    foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                        if( $i == 0 ){
                            $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                        }
                        $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                        $i++;

                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                    $numFila++;
                    break;
                case "ingresosHogar":

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Ingresos del Hogar", flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrDatos["causa"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrDatos["detalle"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrDatos["valor"], flase);

                    $i = 0;
                    $txtUltimoUsuario = "";
                    $txtUsuarios      = "";
                    foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                        if( $i == 0 ){
                            $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                        }
                        $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                        $i++;

                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                    $numFila++;
                    break;
                case "ahorro":

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Ahorro", flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrDatos["causa"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrDatos["detalle"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrDatos["valor"], flase);

                    $i = 0;
                    $txtUltimoUsuario = "";
                    $txtUsuarios      = "";
                    foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                        if( $i == 0 ){
                            $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                        }
                        $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                        $i++;

                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                    $numFila++;
                    break;
                case "cesantias":

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Cesantias", flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrDatos["causa"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrDatos["detalle"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrDatos["valor"], flase);

                    $i = 0;
                    $txtUltimoUsuario = "";
                    $txtUsuarios      = "";
                    foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                        if( $i == 0 ){
                            $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                        }
                        $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                        $i++;

                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                    $numFila++;
                    break;
                case "credito":

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Credito", flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrDatos["causa"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrDatos["detalle"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrDatos["valor"], flase);

                    $i = 0;
                    $txtUltimoUsuario = "";
                    $txtUsuarios      = "";
                    foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                        if( $i == 0 ){
                            $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                        }
                        $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                        $i++;

                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                    $numFila++;
                    break;
                case "actualizacion":

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Actualización de datos", flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrDatos["causa"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrDatos["detalle"], flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrDatos["valor"], flase);

                    $i = 0;
                    $txtUltimoUsuario = "";
                    $txtUsuarios      = "";
                    foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                        if( $i == 0 ){
                            $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                        }
                        $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                        $i++;

                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                    $numFila++;
                    break;
                case "modalidad":
                    foreach ($arrDatos as $seqSeguimiento => $arrCausas) {

                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, null, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, $arrCausas["causa"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $txtModalidad, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrCausas["detalle"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrCausas["valor"], flase);

                        $i = 0;
                        $txtUltimoUsuario = "";
                        $txtUsuarios      = "";
                        foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                            if( $i == 0 ){
                                $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                            }
                            $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                            $i++;

                        }
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                        $numFila++;

                    }
                    break;
                case "seguimiento":
                    foreach ($arrDatos as $seqSeguimiento => $arrCausas) {

                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $numFila, $seqFormulario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $numFila, $arrParametros['estados'][$seqEstadoProceso], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $numFila, $txtModalidad, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $numFila, $txtDesplazado, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $numFila, $objCiudadanoPrincipal->numDocumento, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $numFila, strtoupper($txtNombrePrincipal), flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $numFila, null, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $numFila, $arrCausas["nombre"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $numFila, "Seguimientos", flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $numFila, $arrCausas["causa"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $numFila, $arrCausas["detalle"], flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $numFila, $arrCausas["valor"], flase);

                        $i = 0;
                        $txtUltimoUsuario = "";
                        $txtUsuarios      = "";
                        foreach( $arrUsuarios[$seqFormulario] as $seqUsuario => $objUsuario ){
                            if( $i == 0 ){
                                $txtUltimoUsuario = "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido;
                            }
                            $txtUsuarios .= "[" . $objUsuario->seqUsuario . "] " . $objUsuario->txtNombre . " " . $objUsuario->txtApellido . "\n";
                            $i++;

                        }
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $numFila, $txtUltimoUsuario, flase);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $numFila, $txtUsuarios, flase);

                        $numFila++;

                    }
                    break;
            }
        }

        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setAutoSize(true);

    }
}

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=InconsistenciasInscripcion".date("YmdHis").".xlsx");
header('Cache-Control: max-age=0');
ob_end_clean();
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>