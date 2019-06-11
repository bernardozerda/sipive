<?php

function consultarCiudadano($documento, $tipoDocumento, $user, $pass) {

    $arrTipoDocumentos = array(1, 2, 3, 4, 5, 6, 7);
    $arrErrores = array();

    if (!is_numeric($documento)) {
        $arrErrores[] = 'el numero de documento no es un numero';
        return $arrErrores;
    }
    if (!in_array($tipoDocumento, $arrTipoDocumentos)) {
        $arrErrores[] = 'El tipo de documento ingresado no coincide con uno valido.';
        return $arrErrores;
    }
    if (empty($arrErrores)) {
        // se valida el usuario a conectar
        $usuariovalido = validarUsuario($user, $pass, $documento);

        if ($usuariovalido) {
            $link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
            mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

            $sql = "SELECT
                    t_frm_formulario.seqFormulario as idFamilia,
                    t_ciu_ciudadano.seqCiudadano as idCiudadano,
                    t_ciu_ciudadano.txtNombre1 as Nombre1,
                    t_ciu_ciudadano.txtNombre2 as Nombre2,
                    t_ciu_ciudadano.txtApellido1 as Apellido1,
                    t_ciu_ciudadano.txtApellido2 as Apellido2,
                    t_ciu_tipo_documento.txtTipoDocumento as TipoDocumento,
                    t_ciu_ciudadano.numDocumento as NumeroDocumento,
                    t_ciu_ciudadano.fchNacimiento as FechaNacimiento,
                    IF(t_frm_formulario.bolDesplazado ,'SI','NO') as Desplazado,
                    t_frm_formulario.fchUltimaActualizacion as UltimaActualizacion,
                    t_ciu_etnia.txtEtnia as Etnia,
                    t_ciu_estado_civil.txtEstadoCivil as EstadoCivil,
                    t_ciu_sexo.txtSexo as Sexo,
                    t_frm_tipovictima.txtTipoVictima as TipoVictima,
                    t_frm_modalidad.txtModalidad as Modalidad,
                    t_frm_etapa.txtEtapa as Etapa,
                    t_ciu_parentesco.txtParentesco as Parentesco
                    FROM ((((((((((sipive.t_frm_formulario t_frm_formulario
                    INNER JOIN sipive.t_frm_modalidad t_frm_modalidad
                    ON (t_frm_formulario.seqModalidad =
                    t_frm_modalidad.seqModalidad))
                    INNER JOIN sipive.t_frm_hogar t_frm_hogar
                    ON (t_frm_hogar.seqFormulario =
                    t_frm_formulario.seqFormulario))
                    INNER JOIN sipive.t_ciu_ciudadano t_ciu_ciudadano
                    ON (t_frm_hogar.seqCiudadano = t_ciu_ciudadano.seqCiudadano))
                    INNER JOIN
                    sipive.t_ciu_tipo_documento t_ciu_tipo_documento
                    ON (t_ciu_ciudadano.seqTipoDocumento =
                    t_ciu_tipo_documento.seqTipoDocumento))
                    INNER JOIN sipive.t_ciu_etnia t_ciu_etnia
                    ON (t_ciu_ciudadano.seqEtnia = t_ciu_etnia.seqEtnia))
                    INNER JOIN sipive.t_ciu_estado_civil t_ciu_estado_civil
                    ON (t_ciu_ciudadano.seqEstadoCivil =
                    t_ciu_estado_civil.seqEstadoCivil))
                    INNER JOIN sipive.t_ciu_sexo t_ciu_sexo
                    ON (t_ciu_ciudadano.seqSexo = t_ciu_sexo.seqSexo))
                    INNER JOIN sipive.t_frm_tipovictima t_frm_tipovictima
                    ON (t_ciu_ciudadano.seqTipoVictima =
                    t_frm_tipovictima.seqTipoVictima))
                    INNER JOIN sipive.t_ciu_parentesco t_ciu_parentesco
                    ON (t_frm_hogar.seqParentesco = t_ciu_parentesco.seqParentesco))
                    INNER JOIN sipive.t_frm_estado_proceso t_frm_estado_proceso
                    ON (t_frm_formulario.seqEstadoProceso =
                    t_frm_estado_proceso.seqEstadoProceso))
                    INNER JOIN sipive.t_frm_etapa t_frm_etapa
                    ON (t_frm_estado_proceso.seqEtapa = t_frm_etapa.seqEtapa)
                    WHERE t_ciu_ciudadano.numDocumento = $documento and t_ciu_ciudadano.seqTipoDocumento = $tipoDocumento;
                ";

            $result = mysql_query($sql) or die('Consulta fallida: ' . mysql_error());
            $numero_filas = mysql_num_rows($result);
            if ($numero_filas > 0) {
                $ciudadano = mysql_fetch_array($result, MYSQL_ASSOC);
                return $ciudadano;
            } else {
                $error = 'El ciudadano consultado no coincide con los criterios de busqueda.';
                return $error;
            }

            // Liberar resultados
            mysql_free_result($result);

// Cerrar la conexión
            mysql_close($link);
        } else {
            $arrErrores[] = 'Su nombre de usuario o contraseña no coinciden';
            return $arrErrores;
        }
    }
}

function validarUsuario($user, $pass, $docConsultado) {
    $link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
    mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

    $query = "select * from t_wse_cuentas where txtUsuario = '$user' and txtClave = '$pass';";


    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $numero_filas = mysql_num_rows($result);

    if ($numero_filas > 0) {
        while ($fila = mysql_fetch_assoc($result)) {
            $cuenta = $fila["seqCuenta"];
        }
        registrarIngreso($cuenta, $docConsultado);
        return true;
    } else {
        return false;
    }

    // Liberar resultados
    mysql_free_result($result);

// Cerrar la conexión
    mysql_close($link);
}

function registrarIngreso($cuenta, $docConsultado) {
    $seqCuenta = $cuenta;
    $fchConsulta = date("Y-m-d H:i:s");
    $txtConsulta = 'consultarCiudadano';
    $txtDatos = $docConsultado;

    $query = "INSERT INTO t_wse_registro(seqCuenta, fchConsulta, txtConsulta, txtDatos) 
        VALUES ($seqCuenta, '$fchConsulta', '$txtConsulta', '$txtDatos')
            ";
    $inserta = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    if ($inserta) {
        return true;
    } else {
        return false;
    }
}

//echo validarUsuario('sdhtusuario', 'Ochochar*1');
//$devuelto = consultarCiudadano('140532', 1, 'sdhtusuario', 'Ochochar*1');
//
//echo '<pre>';
//print_r($devuelto);
//echo '</pre>';

//echo validarUsuario('sdhtusuario', 'Ochochar*1', '140532');
?>