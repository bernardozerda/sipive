<?php

/**
 * ARCHIVO DE FUNCIONES GENERALES DEL APLICATIVO
 * @author Bernardo Zerda
 * @version 1,0 Marzo 2009
 */
/**
 * PARA EVIAR QUE LA FUNCION strtoupper QUEDEN LOS 
 * ACENTOS EN MINUSCULAS ej: CÃ©DULA, DEBE QUEDAR CÃ‰DULA
 * CON ESTAS CONSTANTES SE SOLUCIONA
 */
define("LATIN1_UC_CHARS", "Ã€Ã�Ã‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã�Ã‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃ�");
define("LATIN1_LC_CHARS", "Ã Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã¼Ã½");

/**
 * ESTA FUNCION ES SOLO PARA IMPRIMIR EN 
 * PANTALLA DE UNA MANERA CLARA LAS VARIABLES 
 * QUE SE NECESITAN EN DEPURACION
 * @author Bernardo Zerda
 * @param Object objVar
 * @version 1.0 
 */
function pr($objVar) {
    echo "<div align='left'>";
    if (is_array($objVar) or is_object($objVar)) {
        echo "<pre>";
        print_r($objVar);
        echo "</pre>";
    } else {
        echo ereg_replace("\n", "<br>", $objVar);
    }
    echo "</div><hr>";
}

/**
 * VERIFICAR SI LA CADENA CONTIENE SOLO NUMEROS
 * @author Diego Gaitan
 * @param int valNumero
 * @return bool true si solo hay digitos, false de lo contrario
 */
function esNumero($valNumero) {
    return ( preg_match("/^\d+$/", $valNumero) );
}

/**
 * VERIFICAR SI LA CADENA CONTIENE SOLO LETRAS
 * @author Diego Gaitan
 * @param int txtCadena
 * @return bool true si la cadena contiene solo letras, false de lo contrario
 */
function esSoloLetras($txtCadena) {
    return( preg_match("/^[a-z ]+$/i", $txtCadena) );
}

/**
 * VERIFICAR SI LA CADENA CONTIENE ES ALFANUMERICA
 * @author Diego Gaitan
 * @param int txtCadena
 * @return bool true si la cadena contiene solo letras, false de lo contrario
 */
function esSoloLetrasNumeros($txtCadena) {
    return( preg_match("/^[a-z0-9 ]+$/i", $txtCadena) );
}

/**
 * LLAMAR ESTA FUNCION PARA MOSTRAR LOS MENSAJES EN PANTALLA
 * @author Bernardo Zerda
 * @param array arrErrores
 * @param array arrMensajes
 * @param string idDivOculto ==> Se puede usar para disparar un listener de YUI este es opcional (ver listeners.js)
 */
function imprimirMensajes($arrErrores, $arrMensajes = array(), $idDivOculto = "") {
    global $claSmarty;

    if (empty($arrErrores)) {
        $claSmarty->assign("arrImprimir", $arrMensajes);
        $claSmarty->assign("estilo", "msgOk");
    } else {
        $claSmarty->assign("arrImprimir", $arrErrores);
        $claSmarty->assign("estilo", "msgError");
    }
    if ($idDivOculto != "") {
        $claSmarty->assign("idDivOculto", $idDivOculto);
    }
    $claSmarty->display("mensajes.tpl");
}

/**
 * A PARTIR DE HOY SE DA UN NUMERO DE DIAS Y RETORNA
 * LA PROXIMA FECHA, ES DECIR HOY + EL NUMERO DE DIAS
 * @author Bernardo Zerda
 * @param integer numDias
 * @return String txtAviso
 * @version 1,0 Abril 2009
 */
function proximoVencimiento($numDias) {
    $txtAviso = "";
    $txtAviso = date("Y-m-d", strtotime($numDias . " days"));
    return $txtAviso;
}

/**
 * FUNCION PARA VERIFICAR FECHAS
 * @author Bernardo Zerda
 * @param Date fchFecha
 * @version 1.0 Junio 2009
 */
function esFechaValida($fchFecha) {
    if (trim($fchFecha) != "") {
        list( $ano, $mes, $dia ) = mb_split("[\/-]", $fchFecha);
        if (!@checkdate($mes, $dia, $ano)) {
            return false;
        }
        return true;
    } else {
        return false;
    }
}

/**
 * FUNCION PARA TRADUCIR NOMBRES DE LAS TABLAS
 * @author Diego Gaitan
 * @param String txtTabla
 * @param String | Integer numSeq
 * @param String txtSeq
 * @param String txtCampo
 * @version 1.0 Octubre de 2009
 */
function obtenerCampo($txtTabla, $numSeq, $txtCampo, $txtSeq) {
    global $aptBd;

    $sql = "SELECT $txtCampo FROM $txtTabla WHERE $txtSeq = $numSeq";
    try {
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $txtValor = $objRes->fields[$txtCampo];
        }
    } catch (Exception $objError) {
        $txtValor = "No Encotnrado";
    }
    return $txtValor;
}

/**
 * FUNCION PARA TRADUCIR NOMBRES DE LAS TABLAS
 * @author Bernardo Zerda
 * @param String txtTabla
 * @param String txtCampo
 * @param String | Integer txtValor
 * @return String txtValor
 * @version 1.0 Octubre de 2009
 */
function obtenerNombres($txtTabla, $txtCampo, $txtValor) {

    global $aptBd;

    $arrBoleano[1] = "Si";
    $arrBoleano[0] = "No";
    $arrBoleano["Si"] = "Si";
    $arrBoleano["No"] = "No";
    $arrBoleano["Ninguno"] = "";

    $arrConversiones["txtBancoCredito"] = "txtBanco";
    $arrConversiones["seqBancoCredito"] = "seqBanco";
    $arrConversiones["txtBancoCuentaAhorro"] = "txtBanco";
    $arrConversiones["seqBancoCuentaAhorro"] = "seqBanco";
    $arrConversiones["txtProyecto"] = "txtNombreProyecto";
    $arrConversiones["txtUnidadProyecto"] = "txtNombreUnidad";
    $arrConversiones["seqProyectoHijo"] = "seqProyecto";
    $arrConversiones["txtProyectoHijo"] = "txtNombreProyecto";

    switch (true) {
        case $txtTabla == "":
            if ($txtValor != "Ninguno" and trim($txtValor) != "" and trim($txtValor) != "null") {
                $txtValor = utf8_encode(ucwords($txtValor));
            } else {
                $txtValor = "";
            }
            break;
        case strtolower($txtTabla) == "booleano":
            $txtValor = $arrBoleano[$txtValor];
            break;
        case $txtTabla != "":
            if ($txtValor != "Ninguno" and trim($txtValor) != "" and trim($txtValor) != "null") {
                $txtSelect = "txt" . substr($txtCampo, 3);
                $txtSelect = mb_ereg_replace("[0-9]", "", $txtSelect);
                $txtCampo = mb_ereg_replace("[0-9]", "", $txtCampo);
                if (isset($arrConversiones[$txtCampo])) {
                    $txtCampo = $arrConversiones[$txtCampo];
                }
                if (isset($arrConversiones[$txtSelect])) {
                    $txtSelect = $arrConversiones[$txtSelect];
                }
                $sql = "SELECT $txtSelect FROM $txtTabla WHERE $txtCampo = $txtValor";
                try {
                    $objRes = $aptBd->execute($sql);
                    if ($objRes->fields) {
                        $txtValor = $objRes->fields[$txtSelect];
                    }
                } catch (Exception $objError) {
                    $txtValor = "No Encontrado";
                }
            } else {
                $txtValor = "";
            }
            break;
    }

    return $txtValor;
}

function strcount($txtCaracter, $txtCadena) {
    $numOcurrencias = 0;
    for ($i = 0; $i < strlen($txtCadena); $i++) {
        if ($txtCadena[$i] === $txtCaracter) {
            $numOcurrencias++;
        }
    }
    return $numOcurrencias;
}

/**
 * OBTIENE LOS ESTADOS DEL PROCESO QUE 
 * CORRESPONDEN A UNA ETAPA O PUEDE CONSULTAR TODOS LOS ESTADOS 
 */
function estadosProceso($seqEstadoProceso = 0, $seqEtapa = 0) {
    global $aptBd;
    $arrEstados = array();
    $txtCondicion = ( $seqEstadoProceso != 0 ) ? "AND epr.seqEstadoProceso = $seqEstadoProceso " : "";
    $txtCondicion.= ( $seqEtapa != 0 ) ? "AND eta.seqEtapa = $seqEtapa " : "";
    $sql = "
			SELECT 
			  epr.seqEstadoProceso, 
			  concat( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) as txtEstadoProceso
			FROM
			  T_FRM_ETAPA eta,
			  T_FRM_ESTADO_PROCESO epr
			WHERE eta.seqEtapa = epr.seqEtapa
			$txtCondicion	    	
    	";
    $objRes = $aptBd->execute($sql);
    while ($objRes->fields) {
        $arrEstados[$objRes->fields['seqEstadoProceso']] = $objRes->fields['txtEstadoProceso'];
        $objRes->MoveNext();
    }
    return $arrEstados;
}

function esquemaProyecto() {
    global $aptBd;
    $arrEsquema = array();
    $sql = "
                SELECT 
                  tpe.seqTipoEsquema,
                  tpe.txtTipoEsquema
                FROM
                 t_pry_tipo_esquema tpe
                 WHERE TPE.estado = 1
                
    	";
    $objRes = $aptBd->execute($sql);
    while ($objRes->fields) {
        $arrEsquema[$objRes->fields['seqTipoEsquema']] = $objRes->fields['txtTipoEsquema'];
        $objRes->MoveNext();
    }
    return $arrEsquema;
}

/**
 * TOMA UNA FECHA CON EL FORMATO 
 * 		dd De mmmm Del yyyy
 * Y LA CONVIERTE EN FORMATO
 * 		yyyy-mm-dd
 * @author Bernardo Zerda Rodriguez
 * @param String txtFecha ==> Formato dd De mmmm Del yyyy
 * @return Date fchDato ==> Formato yyyy-mm-dd
 */
function textoFecha2Fecha($txtFecha) {

    $txtFecha = strtolower($txtFecha);

    $numDia = substr($txtFecha, 0, 2);

    $numInicio = strpos($txtFecha, "de") + 3;
    $numFinal = strpos($txtFecha, "del");
    $txtMes = trim(substr($txtFecha, $numInicio, $numFinal - $numInicio));

    switch ($txtMes) {
        case "enero" : $numMes = 1;
            break;
        case "febrero" : $numMes = 2;
            break;
        case "marzo" : $numMes = 3;
            break;
        case "abril" : $numMes = 4;
            break;
        case "mayo" : $numMes = 5;
            break;
        case "junio" : $numMes = 6;
            break;
        case "julio" : $numMes = 7;
            break;
        case "agosto" : $numMes = 8;
            break;
        case "septiembre": $numMes = 9;
            break;
        case "octubre" : $numMes = 10;
            break;
        case "noviembre" : $numMes = 11;
            break;
        case "diciembre" : $numMes = 12;
            break;
    }

    $numAno = substr($txtFecha, -4);

    $fchDato = $numAno . "-" . $numMes . "-" . $numDia;
    if (@checkdate($numMes, $numDia, $numAno) === false) {
        $fchDato = "";
    }

    return $fchDato;
}

function formatoFechaGeneral($fecha) {

    $arrFecha = explode("De", $fecha);
    $txtMes = trim(strtolower($arrFecha[1]));
    
    switch ($txtMes) {
        case "enero" : $numMes = "01";
            break;
        case "febrero" : $numMes = "02";
            break;
        case "marzo" : $numMes = "03";
            break;
        case "abril" : $numMes = "04";
            break;
        case "mayo" : $numMes = "05";
            break;
        case "junio" : $numMes = "06";
            break;
        case "julio" : $numMes = "07";
            break;
        case "agosto" : $numMes = "08";
            break;
        case "septiembre": $numMes = "09";
            break;
        case "octubre" : $numMes = "10";
            break;
        case "noviembre" : $numMes = "11";
            break;
        case "diciembre" : $numMes = "12";
            break;
    }
    $fecha = $arrFecha[2] . "-" . $numMes . "-" . $arrFecha[0];
    return strtotime($fecha);
}

/**
 * Cambia la fecha de formato yyyy-mm-dd
 * a dd De mmmm Del yyyy
 */
function formatoFechaTextoFecha($txtFecha) {

    $arrMeses = array();
    $arrMeses[1] = "Enero";
    $arrMeses[2] = "Febrero";
    $arrMeses[3] = "Marzo";
    $arrMeses[4] = "Abril";
    $arrMeses[5] = "Mayo";
    $arrMeses[6] = "Junio";
    $arrMeses[7] = "Julio";
    $arrMeses[8] = "Agosto";
    $arrMeses[9] = "Septiembre";
    $arrMeses[10] = "Octubre";
    $arrMeses[11] = "Noviembre";
    $arrMeses[12] = "Diciembre";

    $txtFechaFinal = "";
    list( $ano, $mes, $dia ) = split("-", $txtFecha);
    if (@checkdate($mes, $dia, $ano) === false) {
        $txtFechaFinal = $txtFecha;
    } else {
        $txtFechaFinal = $dia . " de " . $arrMeses[intval($mes)] . " del  $ano";
    }

    return $txtFechaFinal;
}

/**
 * OBTIENE EL VALOR DEL CIERRE FINANCIERO
 * SEGUN LA MODALIDAD Y EL TIPO DE SOLUCION
 * ( SMMLV * VALOR_MAXIMO_VIVIENDA )
 * @author bzerdar
 * @param Integer seqModalidad
 * @param Integer seqSolucion
 * @return Integer valCierreFinanciero
 */
function valorCierreFinanciero($seqModalidad, $seqSolucion) {
    global $aptBd;
    $valCierre = 0;
    $sql = "
			SELECT 
				valCierreFinanciero
			FROM 
				T_FRM_VALOR_SUBSIDIO
			WHERE seqModalidad = $seqModalidad
			  AND seqSolucion = $seqSolucion
		";
    $objRes = $aptBd->execute($sql);
    if ($objRes->fields) {
        $valCierre = $objRes->fields['valCierreFinanciero'];
    }
    return $valCierre;
}

function obtenerSecuencial($txtValor, $txtTabla, $txtCondicion, $txtCampo, $txtExtras = "") {
    global $aptBd;
    $seqRetorno = 0;
    $sql = "
			SELECT $txtCampo as retorno
			FROM $txtTabla
			WHERE $txtCondicion LIKE \"$txtValor\"
			$txtExtras
		";

    try {
        $objRes = $aptBd->execute($sql);
        $seqRetorno = $objRes->fields["retorno"];
    } catch (Exception $objError) {
        $seqRetorno = 0;
    }
    return $seqRetorno;
}

function imprimirErrores($arrErrores) {

    $txtMostrar = '<table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px" class="msgError">';
    foreach ($arrErrores as $txtError) {
        $txtMostrar .= "<tr><td class='msgError'><li>$txtError</li></td></tr>";
    }
    $txtMostrar .= "</table>";
    echo $txtMostrar;
}

function textoMayusculas($txtTexto) {
    $txtTexto = mb_strtoupper(strtr($txtTexto, LATIN1_LC_CHARS, LATIN1_UC_CHARS));
    return strtr($txtTexto, array("ÃŸ" => "SS"));
}

function esBisiesto($numAnno) {
    $valDevolver = 0;
    // Es Bisiesto
    if (checkdate(2, 29, $numAnno)) {
        $valDevolver = 1;
    }
    return $valDevolver;
}

function diferenciaFechas($fchInicio, $fchFin) {

    $numDiferencia = strtotime($fchFin) - strtotime($fchInicio);
    $numDiferencia = floor($numDiferencia / ( 60 * 60 * 24 ));
    return $numDiferencia;
}

/**
 * Completa los meses de un arreglo (por el indice)
 * @param array arrCompletar
 * @return void
 * @version 1.0
 * @author Diego Gaitan
 */
function completarMesesArreglo(&$arrCompletar) {

    for ($i = 1; $i <= 12; $i++) {
        if (!isset($arrCompletar[$i])) {
            $arrCompletar[$i] = 0;
        }
    }
    ksort($arrCompletar);
}

/**
 * FUNCION PARA OBTENER VARIOS REGISTROS DE UNA TABLA MAESTRA
 * @author Bernardo Zerda
 * @param String txtTabla
 * @param String txtCampos
 * @param Array  arrCampos    // los campos que van en el select
 * @param String txtLLave     // Campo por el cual se agrupan los regstros
 * @param String txtCondicion // clausula where del select
 * @param String txtOrden     // ORDER BY del select
 * @version 1.0 Agosto de 2013
 */

function obtenerDatosTabla($txtTabla, $arrCampos, $txtLLave = "", $txtCondicion = "", $txtOrden = "") {
    
    global $aptBd;
    $arrDatos = array();
    $txtCondicion = ( trim($txtCondicion) != "" ) ? "WHERE $txtCondicion" : "";
    $txtOrden = ( trim($txtOrden) != "" ) ? "ORDER BY $txtOrden" : "";
    if (in_array($txtLLave, $arrCampos)) {
        $sql = "
                SELECT " . implode(",", $arrCampos) . "
                FROM $txtTabla 
                $txtCondicion
                $txtOrden
            ";
        try {
          // echo $sql;
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                if (trim($txtLLave) != "") {
                    $numIndice = $objRes->fields[$txtLLave];
                    unset($objRes->fields[$txtLLave]);
                } else {
                    $numIndice = count($arrDatos);
                }
                foreach ($objRes->fields as $txtCampo => $txtValor) {
                    if (count($objRes->fields) < 2) {
                        $arrDatos[$numIndice] = $txtValor;
                    } else {
                        $arrDatos[$numIndice][$txtCampo] = $txtValor;
                    }
                }
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $arrDatos = array();
        }
    } else {
        echo "La llave debe estar incluida dentro de los campos a retornar";
    }
    return $arrDatos;
}

/**
 * FUNCION QUE RETORNA LOS PROYECTOS DISPONIBLES PARA
 * MOSTRAR EN UNA POSTULACION DE HOGARES PLAN 2 O PLAN 3
 * @author Bernardo Zerda
 * @param String txtTabla
 * @version 1.0 Mayo de 2017
 */
function obtenerProyectosPostulacion($seqFormulario, $seqModalidad, $seqTipoEsquema, $seqPlanGobierno){
    global $aptBd;

    $arrReglas = array();
    $arrProyectos = array();

    // Para estas modalidades se buscan los proyectos con unidades disponibles para mostrar
    $arrReglas['unidad'][6]  = 6;
    $arrReglas['unidad'][12] = 12;
    $arrReglas['unidad'][13] = 13;

    // Para estas modalidades se buscan los proyectos con un tipo de esquema y modalidad de proyecto particular
    $arrReglas['proyecto'][7] = 7;
    $arrReglas['proyecto'][8] = 8;
    $arrReglas['proyecto'][9] = 9;

    /*********************************************************************************************/

    // Plan Gobierno 2 - Adquisicion - Individual
    $arrPryModalidad[2][6][1][] = 1; // adquisicion individual

    // Plan Gobierno 2 - construccion en sitio propio - colectivo opv
    $arrPryModalidad[2][7][2][] = 2; // Adquisición Colectivo OPV

    // Plan Gobierno 2 - mejoramiento estructural - territorial dirigido
    $arrPryModalidad[2][8][4][] = 5; // Mejoramiento Estructural

    // Plan Gobierno 2 - mejoramiento habitacional - territorial dirigido
    $arrPryModalidad[2][9][4][] = 4; // Habitacional

    // Plan Gobierno 3 - Adquisicion cierre financiero - proyectos sdht
    $arrPryModalidad[3][12][9][] = 11;  // proyectos sdht

    // Plan Gobierno 3 - Adquisicion cierre financiero - proyecto no sdht
    $arrPryModalidad[3][12][10][] = 12; // proyecto no sdht

    // Plan Gobierno 3 - Adquisicion cierre financiero - retorno reubicacion
    $arrPryModalidad[3][12][11][] = 13; //  retorno reubicacion

    // Plan Gobierno 3 - Adquisicion Leasing - proyectos no sdht
    $arrPryModalidad[3][13][10][] = 12;  // proyecto no sdht

    // Segun la modalidad buscamos los proyectos que
    // tengan cargados unidades y que esten disponibles
    if( isset($arrReglas['unidad'][$seqModalidad]) ){

        // buscando los proyectos que no tienen hijos
        $sql = "
            SELECT
              pro.seqProyecto,
              pro.txtNombreProyecto
            FROM t_pry_proyecto pro
            WHERE pro.seqProyecto <> 37
              AND pro.seqProyectoPadre IS NULL
              AND bolActivo = 1
            ORDER BY pro.txtNombreProyecto
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $seqProyecto = $objRes->fields['seqProyecto'];
            $txtProyecto = $objRes->fields['txtNombreProyecto'];

            // tiene unidades habitacionales asociadas y disponibles
            $sql = "
                select count(seqProyecto) as cuenta
                from t_pry_unidad_proyecto
                where bolActivo = 1
                  and seqPlanGobierno = " . $seqPlanGobierno . "
                  and seqModalidad = " . $seqModalidad . "
                  and seqProyecto = " . $seqProyecto . "
                  and seqTipoEsquema = " . $seqTipoEsquema . "
                  and (seqFormulario = 0
                    or seqFormulario = ''
                    or seqFormulario is NULL
                    or seqFormulario = " . $seqFormulario . "
                  )
            ";
            $objRes1 = $aptBd->execute($sql);

            if($objRes1->fields['cuenta'] > 0){
                $arrProyectos[$seqProyecto] = $txtProyecto;
            }else{

                // los proyectos hijos tienen unidades habitacionales asociadas y disponibles
                $sql = "
                    SELECT COUNT(seqProyecto) as cuenta
                    FROM t_pry_unidad_proyecto
                    WHERE bolActivo = 1
                      and seqPlanGobierno = " . $seqPlanGobierno . "
                      and seqModalidad = " . $seqModalidad . "
                      and seqTipoEsquema = " . $seqTipoEsquema . "
                      and (seqFormulario = 0
                        or seqFormulario = ''
                        or seqFormulario is NULL
                        or seqFormulario = ".$seqFormulario."
                    ) AND seqProyecto IN (
                      SELECT seqProyecto
                      FROM t_pry_proyecto
                      WHERE seqProyectoPadre = " . $seqProyecto . "
                    )
                ";
                $objRes1 = $aptBd->execute($sql);
                if($objRes1->fields['cuenta'] > 0){
                    $arrProyectos[$seqProyecto] = $txtProyecto;
                }
            }
            $objRes->MoveNext();
        }


    // Para las modalidades de mejoramientos se tiene en cuenta el esquema
    // la modalidad del proyecto porque estos no tienen unidades habitacionales
    // es decir, registros en t_pry_unidad_proyecto
    }elseif (isset($arrReglas['proyecto'][$seqModalidad])){
        if( isset($arrPryModalidad[$seqPlanGobierno][$seqModalidad][$seqTipoEsquema])){
            $sql = "
                SELECT
                  pro.seqProyecto,
                  pro.txtNombreProyecto
                FROM t_pry_proyecto pro
                WHERE pro.bolActivo = 1
                  AND pro.seqProyecto <> 37
                  AND pro.seqPlanGobierno = ".$seqPlanGobierno."
                  AND pro.seqProyectoPadre IS NULL
                  AND pro.seqTipoEsquema = ".$seqTipoEsquema."
                  AND pro.seqPryTipoModalidad IN (".implode(",",$arrPryModalidad[$seqPlanGobierno][$seqModalidad][$seqTipoEsquema]).")
                ORDER BY pro.txtNombreProyecto
            ";
            $objRes = $aptBd->execute($sql);
            while($objRes->fields){
                $seqProyecto = $objRes->fields['seqProyecto'];
                $txtProyecto = $objRes->fields['txtNombreProyecto'];
                $arrProyectos[$seqProyecto] = $txtProyecto;
                $objRes->MoveNext();
            }
        }
    }

    return $arrProyectos;
}

/**
 * FUNCION QUE RETORNA LOS PROYECTOS HIJOS DISPONIBLES PARA
 * MOSTRAR EN UNA POSTULACION DE HOGARES PLAN 2 O PLAN 3
 * @author Bernardo Zerda
 * @param String txtTabla
 * @version 1.0 Mayo de 2017
 */
function obtenerProyectosHijosPostulacion($seqFormulario, $seqModalidad, $seqTipoEsquema, $seqPlanGobierno, $seqProyecto){
    global $aptBd;
    $sql = "
        SELECT DISTINCT
          pro.seqProyecto,
          pro.txtNombreProyecto
        FROM T_PRY_PROYECTO pro
          INNER JOIN t_pry_unidad_proyecto upr on pro.seqProyecto = upr.seqProyecto
        WHERE pro.bolActivo = 1
        AND pro.seqProyectoPadre = ".$seqProyecto."
        AND upr.seqPlanGobierno = " . $seqPlanGobierno . "
        AND upr.seqModalidad = " . $seqModalidad . "
        AND upr.seqTipoEsquema = " . $seqTipoEsquema . "
        AND (upr.seqFormulario = 0
          OR upr.seqFormulario = ''
          OR upr.seqFormulario IS NULL
          OR upr.seqFormulario = ".$seqFormulario."
        )
    ";
    $objRes = $aptBd->execute($sql);
    $arrProyectosHijos = array();
    while ($objRes->fields) {
        $arrProyectosHijos[$objRes->fields['seqProyecto']] = $objRes->fields['txtNombreProyecto'];
        $objRes->MoveNext();
    }
    return $arrProyectosHijos;
}

/**
 * FUNCION QUE RETORNA LAS UNIDADES DISPONIBLES PARA
 * MOSTRAR EN UNA POSTULACION DE HOGARES PLAN 2 O PLAN 3
 * @author Bernardo Zerda
 * @param String txtTabla
 * @version 1.0 Mayo de 2017
 */
function obtenerUnidadesPostulacion($seqFormulario, $seqModalidad, $seqTipoEsquema, $seqPlanGobierno, $seqProyectoHijo){
    global $aptBd;
    $sql = "
        SELECT
          upr.seqUnidadProyecto,
          upr.txtNombreUnidad
        FROM t_pry_unidad_proyecto upr
        WHERE upr.bolActivo = 1
          AND upr.seqUnidadProyecto <> 1
          AND upr.seqProyecto = ".$seqProyectoHijo."
          AND upr.seqPlanGobierno = " . $seqPlanGobierno . "
          AND upr.seqModalidad = " . $seqModalidad . "
          AND upr.seqTipoEsquema = " . $seqTipoEsquema . "
          AND (upr.seqFormulario = 0
            OR upr.seqFormulario = ''
            OR upr.seqFormulario IS NULL
            OR upr.seqFormulario = ".$seqFormulario."
          )
    ";
    $objRes = $aptBd->execute($sql);
    $arrUnidades = array();
    while ($objRes->fields) {
        $arrUnidades[$objRes->fields['seqUnidadProyecto']] = $objRes->fields['txtNombreUnidad'];
        $objRes->MoveNext();
    }
    return $arrUnidades;
}


/**
 * OBTIENE LAS SOLUCIONES SEGUN LA MODALIDAD ESPECIFICADA
 * @author Bernardo Zerda
 * @param String txtTabla
 * @version 1.0 Mayo de 2017
 */
function obtenerSolucion($seqModalidad){
    global $aptBd;
    $arrSolucion = array();
    $txtValidacion = "";
    if( $seqModalidad == 1 ){
        $txtValidacion = " AND seqSolucion <> 1";
    }
    $sql = "
		SELECT 
			seqSolucion,
			txtSolucion
		FROM 
			T_FRM_SOLUCION
		WHERE 
			seqModalidad = " . $seqModalidad . "
			$txtValidacion
	";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
        $arrSolucion[ $objRes->fields['seqSolucion'] ] = $objRes->fields['txtSolucion'];
        $objRes->MoveNext();
    }
    return $arrSolucion;
}


/**
 * REALIZA EL CALCULO DE VALOR DEL SUBSIDIO QUE LE CORRESPONDE
 */
function valorSubsidio($claFormulario){
    global $arrConfiguracion;

    $valVivienda = 70; // SMMLV
    $valTope     = ($claFormulario->seqTipoEsquema == 11)? 26 : 35; // SMMLV 26 para retorno reubicacion y 35 para el resto
    $valSubsidio = 0;
    if($claFormulario->bolCerrado == 0) {
        if ($claFormulario->seqPlanGobierno == 2) {
            if ($claFormulario->seqModalidad == 6) {
                $arrValor = obtenerDatosTabla(
                    "T_PRY_UNIDAD_PROYECTO",
                    array("0", "valSDVEActual"),
                    "0",
                    "seqUnidadProyecto = " . $claFormulario->seqUnidadProyecto
                );
                $valSubsidio = $arrValor[0];
            } else {
                $arrValor = obtenerDatosTabla("T_PRY_PROYECTO", array("0", "valMaximoSubsidio", "valNumeroSoluciones"), "0", "seqProyecto = " . $claFormulario->seqProyecto);
                if (intval($arrValor[0]['valNumeroSoluciones']) != 0) {
                    $valSubsidio = intval(($arrValor[0]['valMaximoSubsidio'] / $arrValor[0]['valNumeroSoluciones']));
                }
            }

            if (doubleval($valSubsidio) == 0) {
                $valSubsidio = array_shift(
                    obtenerDatosTabla(
                        "T_FRM_FORMULARIO",
                        array("seqFormulario", "valAspiraSubsidio"),
                        "seqFormulario",
                        "seqFormulario = " . $claFormulario->seqFormulario
                    )
                );
            }

        } elseif ($claFormulario->seqPlanGobierno == 3) {
            $valSubsidioNAL = intval($claFormulario->valSubsidioNacional) / $arrConfiguracion['constantes']['salarioMinimo'];
            $valVUR = intval($claFormulario->valDonacion) / $arrConfiguracion['constantes']['salarioMinimo'];

            if ($claFormulario->seqModalidad == 12) {
                $valDiferenciaSubsidios = ($valTope - $valSubsidioNAL < 0) ? 0 : $valTope - $valSubsidioNAL;
                if ($claFormulario->bolDesplazado == 0 or $claFormulario->seqTipoEsquema == 12) {
                    if (($valSubsidioNAL + $valVUR + $valDiferenciaSubsidios) > $valVivienda) {
                        if ($valVivienda - ($valSubsidioNAL + $valVUR) < 0) {
                            $valSubsidio = 0;
                        } else {
                            $valSubsidio = $valVivienda - ($valSubsidioNAL + $valVUR);
                        }
                    } else {
                        $valSubsidio = $valDiferenciaSubsidios;
                    }
                } else {
                    if ($valVivienda - ($valSubsidioNAL + $valVUR) < 0) {
                        $valSubsidio = 0;
                    } else {
                        $valSubsidio = $valVivienda - ($valSubsidioNAL + $valVUR);
                    }
                }
                $valSubsidio = ($valSubsidio > $valTope) ? $valTope : $valSubsidio;
                $valSubsidio = ($valSubsidio * $arrConfiguracion['constantes']['salarioMinimo']);
            } elseif ($claFormulario->seqModalidad == 13) {

                $arrValor = obtenerDatosTabla(
                    "T_PRY_UNIDAD_PROYECTO",
                    array("0", "valSDVEActual"),
                    "0",
                    "seqUnidadProyecto = " . $claFormulario->seqUnidadProyecto
                );
                $valSubsidio = $arrValor[0];

            }

        } else {
            $valSubsidio = array_shift(
                obtenerDatosTabla(
                    "T_FRM_FORMULARIO",
                    array("seqFormulario", "valAspiraSubsidio"),
                    "seqFormulario",
                    "seqFormulario = " . $claFormulario->seqFormulario
                )
            );
        }
    }else{
        $valSubsidio = array_shift(
            obtenerDatosTabla(
                "T_FRM_FORMULARIO",
                array("seqFormulario", "valAspiraSubsidio"),
                "seqFormulario",
                "seqFormulario = " . $claFormulario->seqFormulario
            )
        );
    }
    return $valSubsidio;
}

function obtenerTipoEsquema($seqModalidad, $seqPlanGobierno, $bolDesplazado){
    global $aptBd;

    // plan de gobierno 1 [PG][MOD] = ESQUEMA
    $arrEsquema[1][1][]  = 6;
    $arrEsquema[1][2][]  = 6;
    $arrEsquema[1][3][]  = 6;
    $arrEsquema[1][5][]  = 6;
    $arrEsquema[1][6][]  = 6;
    $arrEsquema[1][11][] = 6;

    // plan de gobierno 2
    $arrEsquema[2][6][]  = 1;
    $arrEsquema[2][6][]  = 7;
    $arrEsquema[2][6][]  = 13;
    $arrEsquema[2][6][]  = 2;
    $arrEsquema[2][6][]  = 5;
    $arrEsquema[2][7][]  = 2;
    $arrEsquema[2][7][]  = 4;
    $arrEsquema[2][3][]  = 4;
    $arrEsquema[2][8][]  = 4;
    $arrEsquema[2][9][]  = 4;
    $arrEsquema[2][10][] = 4;
    $arrEsquema[2][11][] = 13;

    // plan de gobierno 3
    $arrEsquema[3][12][] = 9;
    $arrEsquema[3][12][] = 10;
    $arrEsquema[3][12][] = 12;
    $arrEsquema[3][12][] = 14;
    $arrEsquema[3][12][] = 15;
    $arrEsquema[3][13][] = 9;

    if( $bolDesplazado == 1 ) {
        $arrEsquema[3][12][] = 11;
    }

    // obtiene los esquemas segun modalidad y plan de gobierno
    $arrTipoEsquemas = array();
    if( isset( $arrEsquema[$seqPlanGobierno][$seqModalidad] ) ) {
        $arrTipoEsquemas = obtenerDatosTabla(
            "t_pry_tipo_esquema",
            array("seqTipoEsquema", "txtTipoEsquema"),
            "seqTipoEsquema",
            "estado = 1 and seqTipoEsquema IN (" . implode(",", $arrEsquema[$seqPlanGobierno][$seqModalidad]) . ")",
            "txtTipoEsquema"
        );
    }
    return $arrTipoEsquemas;
}

function obtenerTextoConvenio($seqConvenio){
    $arrConvenio = obtenerDatosTabla("V_FRM_CONVENIO", array("seqConvenio", "txtConvenio","txtBanco","numCupos","numOcupados","numDisponibles","valCupos"), "seqConvenio");
    $txtConvenio = "Sin Convenio Seleccionado";
    if( intval( $seqConvenio ) > 1 ){
        $txtConvenio =
            "<strong>Nombre:</strong> " . $arrConvenio[$seqConvenio]['txtConvenio'] . "<br>" .
            "<strong>Banco:</strong> " . $arrConvenio[$seqConvenio]['txtBanco'] . "<br>" .
            "<strong>Cupos:</strong> " . number_format($arrConvenio[$seqConvenio]['numCupos'],0,".",".") . "<br>" .
            "<strong>Ocupados:</strong> " . number_format($arrConvenio[$seqConvenio]['numOcupados'],0,".",".") . "<br>" .
            "<strong>Disponibles:</strong> " . number_format($arrConvenio[$seqConvenio]['numDisponibles'],0,".",".") . "<br>" .
            "<strong>Valor unitario:</strong> $ " . number_format($arrConvenio[$seqConvenio]['valCupos'],0,".",".") . "<br>";
    }
    return "{\"convenio\":\"" . $txtConvenio . "\",\"valor\":\"" . $arrConvenio[$seqConvenio]['valCupos'] . "\"}";
}

function regularizarCampo($txtClave, $txtValor){
    switch( substr($txtClave,0,3) ){
        case "num":
            $txtValor = doubleval(mb_ereg_replace("[^0-9]","", $txtValor));
            break;
        case "val":
            $txtValor = doubleval(mb_ereg_replace("[^0-9]","", $txtValor));
            break;
        case "seq":
            $txtValor = doubleval(mb_ereg_replace("[^0-9]","", $txtValor));
            break;
        case "bol":
            $txtValor = intval(mb_ereg_replace("[^0-9]","", $txtValor));
            break;
        case "fch":
            $txtValor = esFechaValida($txtValor)? $txtValor : null;
            break;
        case "txt":
            $txtValor = trim($txtValor);
            break;
    }
    return $txtValor;
}

function rangoEdad( $numEdad ){
    $txtRango = "";
    switch(true){
        case $numEdad >= 0 and $numEdad <= 5:
            $txtRango = "0 a 5";
            break;
        case $numEdad >= 6 and $numEdad <= 13:
            $txtRango = "6 a 13";
            break;
        case $numEdad >= 14 and $numEdad <= 17:
            $txtRango = "14 a 17";
            break;
        case $numEdad >= 18 and $numEdad <= 26:
            $txtRango = "18 a 16";
            break;
        case $numEdad >= 27 and $numEdad <= 59:
            $txtRango = "27 a 59";
            break;
        case $numEdad >= 60:
            $txtRango = "Mayor de 60";
            break;
    }
    return $txtRango;
}

function obtenerMatriculaProfesional(){

    $txtMatriculaProfesional = "";
    switch ($_SESSION['seqUsuario']) {
        case 68:
            $txtMatriculaProfesional = "2570050993 CND";
            break;
        case 105:
            $txtMatriculaProfesional = "A20992010-80070556";
            break;
        case 110:
            $txtMatriculaProfesional = "25202127963 CND";
            break;
        case 422:
            $txtMatriculaProfesional = "A13832010-1018407205";
            break;
        case 423:
            $txtMatriculaProfesional = "25202-227575 CND";
            break;
        case 508:
            $txtMatriculaProfesional = "25202-329840 CND";
            break;
        case 498:
            $txtMatriculaProfesional = "MP A25222002-79620368";
            break;
        case 499:
            $txtMatriculaProfesional = "A25682008-80926066";
            break;
        case 551:
            $txtMatriculaProfesional = "25202-340510 CND";
            break;
        case 283:
            $txtMatriculaProfesional = "25202-384331 CND";
            break;
        default :
            $txtMatriculaProfesional = "________________________________________";
            break;
    }
    return $txtMatriculaProfesional;
}


?>