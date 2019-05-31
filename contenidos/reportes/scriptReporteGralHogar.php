
<?php

ini_set("memory_limit", -1);
chdir(dirname(__DIR__) . "/reportes/");
$txtPrefijoRuta = "../../";
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php");

reporteGralHogar();

function reporteGralHogar() {

    global $aptBd;
    $name = 'reporteGralHogar_' . date("Ymd_His");
    $formularios = "";
    //$sql = "CREATE TABLE T_FRM_REPORTE_GRAL";
    $sql = "INSERT INTO T_FRM_REPORTE_GRAL ";
    $sql .= "(SELECT 
                '', frm.seqFormulario AS 'Id Hogar',
                ppal.numDocumento AS 'DocumentoPpal',
                seqCiudadano AS 'idCiudadano',
                txtTipoDocumento AS 'TipoDocumento',
                ciud.numDocumento AS 'DocumentoCiudadano',
                UPPER(txtNombre1) AS Nombre1,
                UPPER(txtNombre2) AS Nombre2,
                UPPER(txtApellido1) AS txtApellido1,
                UPPER(txtApellido2) AS txtApellido2,
                txtParentesco AS Parentesco,
                txtSexo AS Sexo,
                txtEstadoCivil AS 'Estado Civil',
                fchNacimiento AS 'FechadeNacimiento',
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
                        '0a5'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 5
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 13
                    THEN
                        '6a13'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 13
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 17
                    THEN
                        '14a17'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 17
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 26
                    THEN
                        '18a26'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 26
                            AND TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) <= 59
                    THEN
                        '27a59'
                    WHEN
                        TIMESTAMPDIFF(YEAR,
                            fchNacimiento,
                            CURDATE()) > 59
                    THEN
                        'Mayorde60'
                    ELSE 'Ninguno'
                END AS RangoEdad,
                txtNivelEducativo AS 'NivelEducativo',
                numAnosAprobados AS 'AnosAprobados',
                txtEtnia AS Etnia,
                valIngresos AS 'IngresosdelCiudadano',
                txtOcupacion AS Ocupacion,
                IF(seqCondicionEspecial = 1
                        OR seqCondicionEspecial2 = 1
                        OR seqCondicionEspecial3 = 1,
                    'SI',
                    'NO') AS 'CabezadeFamilia',
                IF(seqCondicionEspecial = 2
                        OR seqCondicionEspecial2 = 2
                        OR seqCondicionEspecial3 = 2,
                    'SI',
                    'NO') AS 'Mayor65Anos',
                IF(seqCondicionEspecial = 3
                        OR seqCondicionEspecial2 = 3
                        OR seqCondicionEspecial3 = 3,
                    'SI',
                    'NO') AS Discapacitado,
                IF(seqCondicionEspecial = 6
                        AND seqCondicionEspecial2 = 6
                        AND seqCondicionEspecial3 = 6,
                    'SI',
                    'NO') AS 'NingunaCondicionEspecial',
                txtSalud AS Salud,
                UPPER(txtTipoVictima) AS 'TipoVictima',
                IF(bolLgtb = 1, 'SI', 'NO') AS 'Lgtbi',
                UPPER(txtGrupoLgtbi) AS 'GrupoLGTBI',
                IF(bolDesplazado = 1,
                    'Víctimas',
                    'Vulnerables') AS Desplazado,
                txtCiudad AS 'Ciudad',
                txtLocalidad AS 'Localidad',
                upz.txtUpz,
                bar.txtBarrio AS Barrio,
                seqTipoDireccion,
                txtVivienda AS Vivienda,
                valArriendo AS 'ValorArriendo',
                fchArriendoDesde AS 'FechaArriendoDesde',
                numHabitaciones AS 'NumeroHabitaciones',
                numHacinamiento AS 'Hacinamiento',
                DATE_FORMAT(frm.fchInscripcion, '%Y-%m-%d') AS 'FechaInscripcion',
                DATE_FORMAT(frm.fchInscripcion, '%Y') AS 'AñoInscripcion',
                DATE_FORMAT(frm.fchPostulacion, '%Y-%m-%d') AS 'FechaPostulacion',
                DATE_FORMAT(frm.fchPostulacion, '%Y') AS 'AñoPostulacion',
                txtEstado AS 'EstadoProceso',
                SUBSTRING_INDEX(txtEstado, '-', 1) AS Etapa,
                IF(bolCerrado = 1, 'SI', 'NO') AS Cerrado,
                txtCajaCompensacion AS 'Caja de Compensacion',
                IF(bolIntegracionSocial = 1, 'SI', 'NO') AS IntegracionSocial,
                IF(bolSecSalud = 1, 'SI', 'NO') AS 'Sec. Salud',
                IF(bolSecEducacion = 1, 'SI', 'NO') AS 'Sec.Educacion',
                IF(bolSecMujer = 1, 'SI', 'NO') AS 'Sec.Mujer',
                IF(bolAltaCon = 1, 'SI', 'NO') AS 'Sec.AltaConsejeria',
                IF(bolIpes = 1, 'SI', 'NO') AS 'secbolIpes',
                IF(bolReconocimientoFP = 1, 'SI', 'NO') AS 'bolReconocimientoFP',
                txtOtro,
                txtSisben AS 'Sisben',
                valIngresoHogar AS 'IngresosdelHogar',
                (valSaldoCuentaAhorro + valSaldoCuentaAhorro2) AS 'SumaAhorro',
                valSaldoCuentaAhorro AS 'SaldoCtadeAhorro1',
                ban.txtBanco AS 'Banco Cta Ahorro 1',
                valSaldoCuentaAhorro2 AS 'SaldoCtaAhorro2',
                ban2.txtBanco AS 'BancoCtaAhorro2',
                valSubsidioNacional AS 'SubsidioNacional',
                txtEntidadSubsidio AS 'EntidadSubsidio',
                txtSoporteSubsidioNacional AS 'SoporteSubsidioNacional',
                valAporteLote AS 'AporteLote',
                valSaldoCesantias AS 'ValorCesantias',
                txtCesantias AS Cesantias,
                valCredito AS 'ValorCredito',
                cred.txtBanco AS 'BancoCredito',
                valDonacion AS 'ValorDonacion',
                txtEmpresaDonante AS 'EmpresaDonante',
                txtSoporteDonacion AS 'SoporteDonacion',
                valPresupuesto AS 'ValorPresupuesto',
                valAvaluo AS 'ValorAvaluo',
                valTotal AS 'ValorTotal',
                txtModalidad AS 'Modalidad',
                txtSolucion AS Solucion,
                txtPlanGobierno AS 'PlandeGobierno',
                txtTipoEsquema AS 'TipoEsquema',
                valAspiraSubsidio AS 'AspiraSubsidio',
                txtSoporteSubsidio AS 'SoporteSubsidio',
                fchVigencia AS 'FechaVigencia',
                valCartaLeasing AS 'CartaLeasing',
                valComplementario AS 'ValorComplementario',
                txtNombreProyecto AS 'NombreProyecto',
                seqProyectoHijo,
                IF(afro.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarAfro ',
                IF(ind.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarIndigena',
                IF(pal.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarPalenquero',
                IF(raiz.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarRaizal',
                IF(cabF.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarCabezaFam',
                IF(disc.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarDiscapacitado',
                IF(lgtbi.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarLGTBI ',
                IF(rom.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'HogarRom ',
                IF(mayor.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS 'Mayor60Años',
                    IF(edad0.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '0-17', 
                 IF(edad27.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '27-59',
                    IF(edad14.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '14-28',
                IF(edad13.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '0-13',
                IF(adol.seqFormulario IS NOT NULL,
                    'SI',
                    'NO') AS '14-17', 
                    now() As 'fechaejecucion',
                    '$name'
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

    $sql .= " ORDER BY frm.seqFormulario)";
//    echo $sql;
//     die();

    try {
        $aptBd->execute($sql);
        echo "\n\n antes de select";
        $sql1 = "select * from T_FRM_REPORTE_GRAL where txtNombreReporte = '$name'";
        try {
            $objRes = $aptBd->execute($sql1);
        } catch (Exception $ex1) {
            echo "\n" . $ex1->getMessage() . "\n \n";
        }
        echo "\n\n despues de select";
    } catch (Exception $ex) {
        echo "\n" . $ex->getMessage() . "\n \n";
    }

    echo "\n\n antes de funcion ";
    generarArchivo($objRes, $name);
    echo "\n\n despues de funcion ";
}

function generarArchivo($objRes, $name) {

    $rutaDestino = "../../recursos/reportes/ciudadano";

    if (!file_exists($rutaDestino)) {
        mkdir($rutaDestino, 0777, true);
    }
    $archivo = fopen($rutaDestino . "/" . $name . ".xls", "w");
    echo "\n prueba";
    $txtSeparador = "\t";
    $arrTitulosCampos = array_keys($objRes->fields);
    fwrite($archivo, utf8_decode(implode($txtSeparador, $arrTitulosCampos)) . "\r\n");
     utf8_decode(implode($txtSeparador, $arrTitulosCampos)) . "\r\n";
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
    echo " \n fin";
    fclose($archivo);
    //copy($rutaDestino . "/" . $name . ".xls", "//SDHT-0596-P9/Users/liliana.basto/Documents/compartida");
    //copy($rutaDestino."/".$archivo,"http://192.168.3.16/d:");
    // var_dump($objRes);
}
