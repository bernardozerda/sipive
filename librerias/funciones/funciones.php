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
        list( $ano, $mes, $dia ) = split("[\/-]", $fchFecha);
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

?>