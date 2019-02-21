
<?php

ini_set("memory_limit", -1);

$txtPrefijoRuta = "../../";
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php");

reporteGralHogar();

function reporteGralHogar() {

    global $aptBd;
    $formularios = "";
    $sql = "SELECT 
                frm.seqFormulario AS 'Id Hogar',
                ppal.numDocumento AS 'Documento Ppal',
                seqCiudadano AS 'id Ciudadano',
                txtTipoDocumento AS 'Tipo Documento',
                ciud.numDocumento AS 'Documento Ciudadano',
                UPPER(txtNombre1) AS Nombre1,
                UPPER(txtNombre2) AS Nombre2,
                UPPER(txtApellido1) AS txtApellido1,
                UPPER(txtApellido2) AS txtApellido2,
                txtParentesco AS Parentesco,
                txtSexo AS Sexo,
                txtEstadoCivil AS 'Estado Civil',
                fchNacimiento AS 'Fecha de Nacimiento',
                TIMESTAMPDIFF(YEAR,
                    fchNacimiento,
                    CURDATE()) AS Edad,
                CASE
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) < 0
                    THEN
                        'Ninguno'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) >= 0
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 5
                    THEN
                        '0 a 5'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 5
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 13
                    THEN
                        '6 a 13'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 13
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 17
                    THEN
                        '14 a 17'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 17
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 26
                    THEN
                        '18 a 26'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 26
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 59
                    THEN
                        '27 a 59'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 59
                    THEN
                        'Mayor de 60'
                    ELSE 'Ninguno'
                END AS RangoEdad,
                txtNivelEducativo AS 'Nivel Educativo',
                numAnosAprobados AS 'Anos Aprobados',
                txtEtnia AS Etnia,
                valIngresos AS 'Ingresos del Ciudadano',
                txtOcupacion AS Ocupacion,
                IF(seqCondicionEspecial = 1
                        OR seqCondicionEspecial2 = 1
                        OR seqCondicionEspecial3 = 1,
                    'SI',
                    'NO') AS 'Cabeza de Familia',
                IF(seqCondicionEspecial = 2
                        OR seqCondicionEspecial2 = 2
                        OR seqCondicionEspecial3 = 2,
                    'SI',
                    'NO') AS 'Mayor 65 Anos',
                IF(seqCondicionEspecial = 3
                        OR seqCondicionEspecial2 = 3
                        OR seqCondicionEspecial3 = 3,
                    'SI',
                    'NO') AS Discapacitado,
                IF(seqCondicionEspecial = 6
                        AND seqCondicionEspecial2 = 6
                        AND seqCondicionEspecial3 = 6,
                    'SI',
                    'NO') AS 'Ninguna Condicion Especial',
                txtSalud AS Salud,
                UPPER(txtTipoVictima) AS 'Tipo Victima',
                IF(bolLgtb = 1, 'SI', 'NO') AS 'Lgtbi',
                UPPER(txtGrupoLgtbi) AS 'Grupo LGTBI',
                IF(bolDesplazado = 1,
                    'Víctimas',
                    'Vulnerables') AS Desplazado,
                txtCiudad AS 'Ciudad',
                txtLocalidad AS 'Localidad',
                upz.txtUpz,
                bar.txtBarrio AS Barrio,
                seqTipoDireccion,
                txtVivienda AS Vivienda,
                valArriendo AS 'Valor Arriendo',
                fchArriendoDesde AS 'Fecha Arriendo Desde',
                numHabitaciones AS 'Numero Habitaciones',
                numHacinamiento AS 'Hacinamiento',
                DATE_FORMAT(frm.fchInscripcion, '%Y-%m-%d') AS 'Fecha Inscripcion',
                DATE_FORMAT(frm.fchInscripcion, '%Y') AS 'Año Inscripcion',
                DATE_FORMAT(frm.fchPostulacion, '%Y-%m-%d') AS 'Fecha Postulacion',
                DATE_FORMAT(frm.fchPostulacion, '%Y') AS 'Año Postulacion',
                txtEstado AS 'Estado Proceso',
                SUBSTRING_INDEX(txtEstado, '-', 1) AS Etapa,
                IF(bolCerrado = 1, 'SI', 'NO') AS Cerrado,
                txtCajaCompensacion AS 'Caja de Compensacion',
                IF(bolIntegracionSocial = 1, 'SI', 'NO') AS IntegracionSocial,
                IF(bolSecSalud = 1, 'SI', 'NO') AS 'Sec. Salud',
                IF(bolSecEducacion = 1, 'SI', 'NO') AS 'Sec. Educacion',
                IF(bolSecMujer = 1, 'SI', 'NO') AS 'Sec. Mujer',
                IF(bolAltaCon = 1, 'SI', 'NO') AS 'Sec. Alta Consejeria',
                IF(bolIpes = 1, 'SI', 'NO') AS 'secbolIpes',
                txtOtro,
                txtSisben AS 'Sisben',
                valIngresoHogar AS 'Ingresos del Hogar',
                (valSaldoCuentaAhorro + valSaldoCuentaAhorro2) AS 'Suma Ahorro',
                valSaldoCuentaAhorro AS 'Saldo Cta de Ahorro 1',
                ban.txtBanco AS 'Banco Cta Ahorro 1',
                valSaldoCuentaAhorro2 AS 'Saldo Cta Ahorro 2',
                ban2.txtBanco AS 'Banco Cta Ahorro 2',
                valSubsidioNacional AS 'Subsidio Nacional',
                txtEntidadSubsidio AS 'Entidad Subsidio',
                txtSoporteSubsidioNacional AS 'Soporte Subsidio Nacional',
                valAporteLote AS 'Aporte Lote',
                valSaldoCesantias AS 'Valor Cesantias',
                txtCesantias AS Cesantias,
                valCredito AS 'Valor Credito',
                cred.txtBanco AS 'Banco Credito',
                valDonacion AS 'Valor Donacion',
                txtEmpresaDonante AS 'Empresa Donante',
                txtSoporteDonacion AS 'Soporte Donacion',
                valPresupuesto AS 'Valor Presupuesto',
                valAvaluo AS 'Valor Avaluo',
                valTotal AS 'Valor Total',
                txtModalidad AS 'Modalidad',
                txtSolucion AS Solucion,
                txtPlanGobierno AS 'Plan de Gobierno',
                txtTipoEsquema AS 'Tipo Esquema',
                valAspiraSubsidio AS 'Aspira Subsidio',
                txtSoporteSubsidio AS 'Soporte Subsidio',
                fchVigencia AS 'Fecha Vigencia',
                valCartaLeasing AS 'Carta Leasing',
                valComplementario AS 'Valor Complementario',
                txtNombreProyecto AS 'Nombre Proyecto',
                seqProyectoHijo,
                IF(afro.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar Afro ',
                IF(ind.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar Indigena',
                IF(pal.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar Palenquero',
                IF(raiz.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar Raizal',
                IF(cabF.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar Cabeza Fam',
                IF(disc.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar Discapacitado',
                IF(lgtbi.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar LGTBI ',
                IF(rom.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Hogar Rom ',
                IF(mayor.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Mayor 60 Años',
                    IF(edad0.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '0 - 17', 
                 IF(edad27.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '27 - 59',
                    IF(edad14.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '14 - 28',
                IF(edad13.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '0 - 13',
                IF(adol.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '14 - 17'

            FROM
                t_ciu_ciudadano ciud
                    INNER JOIN
                t_frm_hogar hog USING (seqCiudadano)
                    INNER JOIN
                t_frm_formulario frm USING (seqFormulario)
                    LEFT JOIN
                t_ciu_tipo_documento USING (seqTipoDocumento)
                    LEFT JOIN
                t_ciu_sexo USING (seqSexo)
                    LEFT JOIN
                t_ciu_parentesco USING (seqParentesco)
                    LEFT JOIN
                t_ciu_estado_civil USING (seqEstadoCivil)
                    LEFT JOIN
                t_frm_tipoVictima USING (seqTipoVictima)
                    LEFT JOIN
                t_frm_grupo_lgtbi USING (seqGrupoLgtbi)
                    LEFT JOIN
                t_ciu_nivel_educativo USING (seqNivelEducativo)
                    LEFT JOIN
                t_ciu_salud USING (seqSalud)
                    LEFT JOIN
                t_ciu_etnia USING (seqEtnia)
                    LEFT JOIN
                v_frm_estado USING (seqEstadoProceso)
                    LEFT JOIN
                t_ciu_caja_compensacion USING (seqCajaCompensacion)
                    LEFT JOIN
                t_ciu_ocupacion USING (seqOcupacion)
                    LEFT JOIN
                t_frm_solucion USING (seqSolucion)
                    LEFT JOIN
                t_frm_modalidad mo ON (mo.seqModalidad = frm.seqModalidad)
                    LEFT JOIN
                t_frm_banco ban ON (ban.seqBanco = frm.seqBancoCuentaAhorro)
                    LEFT JOIN
                t_frm_banco ban2 ON (ban2.seqBanco = frm.seqBancoCuentaAhorro2)
                    LEFT JOIN
                t_frm_banco cred ON (cred.seqBanco = frm.seqBancoCredito)
                    LEFT JOIN
                t_frm_localidad USING (seqLocalidad)
                    LEFT JOIN
                t_pry_proyecto USING (seqProyecto)
                    LEFT JOIN
                t_frm_ciudad USING (seqCiudad)
                    LEFT JOIN
                t_frm_plan_gobierno pg ON (frm.seqPlanGobierno = pg.seqPlanGobierno)
                    LEFT JOIN
                t_frm_barrio bar ON (frm.seqBarrio = bar.seqBarrio)
                    LEFT JOIN
                t_pry_tipo_esquema esq ON (frm.seqTipoEsquema = esq.seqTipoEsquema)
                    LEFT JOIN
                t_frm_empresa_donante USING (seqEmpresaDonante)
                    LEFT JOIN
                t_frm_entidad_subsidio USING (seqEntidadSubsidio)
                    LEFT JOIN
                t_frm_cesantia USING (seqCesantias)
                    LEFT JOIN
                t_frm_vivienda USING (seqVivienda)
                    LEFT JOIN
                t_frm_sisben USING (seqSisben)
                    LEFT JOIN
                t_frm_upz upz ON (upz.seqUpz = frm.seqUpz)
                    LEFT JOIN
                (SELECT DISTINCT
                    hoget.seqFormulario
                FROM
                    t_ciu_ciudadano ciuet
                INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                WHERE
                    ciuet.seqEtnia = 6) afro ON frm.seqFormulario = afro.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    hoget.seqFormulario
                FROM
                    t_ciu_ciudadano ciuet
                INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                WHERE
                    ciuet.seqEtnia = 2) ind ON frm.seqFormulario = ind.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    hoget.seqFormulario
                FROM
                    t_ciu_ciudadano ciuet
                INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                WHERE
                    ciuet.seqEtnia = 3) rom ON frm.seqFormulario = rom.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    hoget.seqFormulario
                FROM
                    t_ciu_ciudadano ciuet
                INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                WHERE
                    ciuet.seqEtnia = 4) raiz ON frm.seqFormulario = raiz.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    hoget.seqFormulario
                FROM
                    t_ciu_ciudadano ciuet
                INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                WHERE
                    ciuet.seqEtnia = 5) pal ON frm.seqFormulario = pal.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    ciuet.numDocumento, hoget.seqFormulario
                FROM
                    t_ciu_ciudadano ciuet
                INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                WHERE
                    seqParentesco = 1) ppal ON frm.seqFormulario = ppal.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    seqCondicionEspecial = 1
                        OR seqCondicionEspecial2 = 1
                        OR seqCondicionEspecial3 = 1) cabF ON frm.seqFormulario = cabF.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    seqCondicionEspecial = 3
                        OR seqCondicionEspecial2 = 3
                        OR seqCondicionEspecial3 = 3) disc ON frm.seqFormulario = disc.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) > 59) mayor ON frm.seqFormulario = mayor.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    seqGrupoLgtbi > 0) lgtbi ON frm.seqFormulario = lgtbi.seqFormulario
                     LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) < 18) edad0 ON frm.seqFormulario = edad0.seqFormulario
                    LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) > 26 && TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) < 60) edad27 ON frm.seqFormulario = edad27.seqFormulario       
                     LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) > 13 && TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) < 29) edad14 ON frm.seqFormulario = edad14.seqFormulario
                LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                     TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) < 14) edad13 ON frm.seqFormulario = edad13.seqFormulario
                LEFT JOIN
                (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
         TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) > 13 && TIMESTAMPDIFF(YEAR, fchNacimiento, CURDATE()) < 18) adol ON frm.seqFormulario = adol.seqFormulario ";

    $sql .= " ORDER BY frm.seqFormulario";
    //echo $sql;
    // die();
    $sql1 = "select * from t_frm_estado_proceso";
    try {
        echo "\n\n antes de";
        $objRes = $aptBd->execute($sql);
        echo "\n\n despues de";
    } catch (Exception $ex) {
        echo "\n" . $ex->getMessage() . "\n \n";
    }
    echo "\n\n antes de funcion ";
    generarArchivo($objRes, "reporteGralHogar_");
    echo "\n\n dspues de funcion ";
}

function generarArchivo($objRes, $nombre) {
    
    $rutaDestino = "../../recursos/reportes/ciudadano" ;   

    if (!file_exists($rutaDestino)) {
        mkdir($rutaDestino, 0777, true);
    }
    $archivo = fopen($rutaDestino."/".$nombre . date("Ymd_His") . ".xls", "w");
    echo "\n prueba";
    $txtSeparador = "\t";
    $arrTitulosCampos = array_keys($objRes->fields);
    fwrite($archivo, utf8_decode(implode($txtSeparador, $arrTitulosCampos)) . "\r\n");
    echo utf8_decode(implode($txtSeparador, $arrTitulosCampos)) . "\r\n";
    while ($objRes->fields) {
        $dato = (utf8_decode(implode($txtSeparador, preg_replace("/\s+/", " ", $objRes->fields))));
        $dato = str_replace('&nbsp;', ' ', $dato); // Reemplaza caracter por espacios
        $dato = str_replace('<b>', '', $dato); // Reemplaza caracter por espacios
        $dato = str_replace('</b>', '', $dato); // Reemplaza caracter por espacios
        $dato = str_replace('<br>', ';', $dato); // Reemplaza caracter por espacios
        $dato = str_replace('<br />', ';', $dato); // Reemplaza caracter por espacios
        //echo $dato . "\r\n";
        fwrite($archivo, $dato . "\r\n");
        $objRes->MoveNext();
    }
    fclose($archivo);
    //copy($rutaDestino."/".$archivo,"http://192.168.3.16/d:");
    // var_dump($objRes);
}
