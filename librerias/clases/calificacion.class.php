<?php

require_once 'Ciudadano.class.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calificacion
 *
 * @author lbastoz
 */
class calificacion {

    public $BLE;
    public $RSA;
    public $COH;
    public $HACN;
    public $IPC;
    public $TDE;
    public $HN12;
    public $MCF;
    public $HAMY;
    public $CDISC;
    public $HPGE;
    public $HN18;
    public $HCF;
    public $PLGTBI;
    public $PPGD;

//put your code here
    public function calificacion() {
        $this->BLE = 0;
        $this->RSA = 0;
        $this->COH = 0;
        $this->HACN = 0;
        $this->IPC = 0;
        $this->TDE = 0;
        $this->HN12 = 0;
        $this->MCF = 0;
        $this->HAMY = 0;
        $this->CDISC = 0;
        $this->HPGE = 0;
        $this->HN18 = 0;
        $this->HCF = 0;
        $this->PLGTBI = 0;
        $this->PPGD = 0;
    }

    public function obtenerValorIndicadores() {

        global $aptBd;

        $sql = "SELECT * FROM T_FRM_CALIFICACION_INDICADOR";
        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $prueba = trim($objRes->fields['sigIndicador']);
                $prueba = str_replace(" ", "", $prueba);
                // echo   $this->$objRes->fields['sigIndicador']."<br>";
                $this->$prueba = $objRes->fields['prcIndicador'];
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            return $objError->msg;
        }
    }

    public function validarFormularios($separado_por_comas) {

        global $aptBd;
        $NoEstado = 0;
        $NoEstado1 = 0;
        $error = "";
        //$separado_por_comas = substr_replace($separado_por_comas, ' ', -1, 1);
        //echo $separado_por_comas; exit();
        if ($separado_por_comas != "") {
            $documents = explode(",", $separado_por_comas);
            $salt = 0;
            foreach ($documents as $key => $value) {

                if (trim($value) == "") {
                    $salt++;
                    $error = "<p class='alert alert-danger'>Error! Existe " . $salt . " salto(s) de linea invalido en el documento</b>";
                } else {

                    if (is_numeric($value)) {
                        $seqFormulario = Ciudadano::formularioVinculado($value);
                        if ($seqFormulario) {
                            $arrSeqFormularios[] = $seqFormulario;
                        } else {
                            $error .= "<p class='alert alert-danger'>Error! El documento $value no tiene asignado un formulario";
                        }
                    }
                }
            }
            if ($error != "") {
                return $error . "</p>";
            } else {
                $sql = "SELECT DISTINCT(seqFormulario), numDocumento from T_FRM_FORMULARIO"
                        . " LEFT JOIN T_FRM_HOGAR USING(seqFormulario)"
                        . " LEFT JOIN T_CIU_CIUDADANO USING(seqCiudadano)"
                        . " WHERE numDocumento IN(" . $separado_por_comas . ") AND seqEstadoProceso NOT IN (6, 37) and seqParentesco = 1  and seqPlanGobierno NOT IN(3) "
                        . "GROUP BY seqFormulario";
                $objRes = $aptBd->execute($sql);
                $NoEstado = $aptBd->Affected_Rows();
                if ($NoEstado == 0) {
                    $sql = "SELECT DISTINCT(seqFormulario), numDocumento from T_FRM_FORMULARIO"
                            . " LEFT JOIN T_FRM_HOGAR USING(seqFormulario)"
                            . " LEFT JOIN T_CIU_CIUDADANO USING(seqCiudadano)"
                            . " WHERE numDocumento IN(" . $separado_por_comas . ") AND seqPlanGobierno NOT IN(3)"
                            . "GROUP BY seqFormulario";
                    $objRes = $aptBd->execute($sql);
                    $NoEstado = $aptBd->Affected_Rows();
                }
                if ($NoEstado == 0) {
                    $sql = "SELECT DISTINCT(seqFormulario), numDocumento
                            FROM t_frm_formulario    frm
                                 LEFT JOIN t_frm_hogar hog USING (seqFormulario)
                                 LEFT JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            WHERE  numDocumento IN(" . $separado_por_comas . ") AND   seqEstadoProceso IN (37)
                                  AND (   numHabitaciones IS NULL
                                       OR numHacinamiento IS NULL
                                       OR bolSecMujer IS NULL
                                       OR bolSecSalud IS NULL
                                       OR bolAltaCon IS NULL
                                       OR bolIpes IS NULL)
                            GROUP BY frm.seqFormulario";
                    $objRes = $aptBd->execute($sql);
                    $NoEstado1 = $aptBd->Affected_Rows();
                }
            }
        }
        ///echo ($NoEstado); echo $error;
        if ($NoEstado > 0 || $NoEstado1 > 0) {
            if ($NoEstado > 0){
                $error = "<p class='alert alert-danger'>Error! Los siguientes Documentos no tienen el <b>Estado: Hogar Actualizado o no se encuentran en el plan de gobierno Bogotá Mejor para Todos!</b>";
            }else{
                $error = "<p class='alert alert-danger'>Error! Los siguientes Documentos no tienen el <b>la informacion de la inscripción completa!</b>";
            }
            $error .= "<br><br>";
            while ($objRes->fields) {
                $error .= $objRes->fields['numDocumento'] . "<br>";
                $objRes->MoveNext();
            }
            return $error . "</p>";
        } else if (!isset($error) || $error == 0) {
            $sql = "SELECT DISTINCT(seqFormulario) from T_FRM_FORMULARIO"
                    . " INNER JOIN T_FRM_HOGAR USING(seqFormulario)"
                    . " INNER JOIN T_CIU_CIUDADANO USING(seqCiudadano)"
                    . " WHERE seqEstadoProceso IN (37) ";
            if ($separado_por_comas != "") {
                $sql .= "  and numDocumento IN(" . $separado_por_comas . ")";
            }
            $sql .= "GROUP BY seqFormulario";
            $objRes = $aptBd->execute($sql);
            $estado = $aptBd->Affected_Rows();
            // echo ($NoEstado);
            if ($estado > 0) {
                $datosFormularios = "";
                while ($objRes->fields) {
                    $datosFormularios .= $objRes->fields['seqFormulario'] . ",";
                    $objRes->MoveNext();
                }
                $datosFormularios = substr_replace($datosFormularios, ' ', -1, 1);
                return $datosFormularios;
            }
        }
    }

    public function obtenerDatosCalificacion($ejecutaConsultaPersonalizada, $formularios) {

        global $aptBd;
        //$formularios = substr_replace($formularios, ' ', -1, 1);
         $sql = "SELECT frm.seqFormulario,
                ciu.numDocumento,
                frm.fchUltimaActualizacion,
                count(seqCiudadano) AS cant,
                concat(txtNombre1,
                       ' ',
                       txtNombre2,
                       ' ',
                       txtApellido1,
                       ' ',
                       txtApellido2)
                   AS nombre,
                group_concat(
                   concat(
                      '',
                      ucwords(txtNombre1),
                      ' ',
                      txtNombre2,
                      ' ',
                      txtApellido1,
                      ' ',
                      txtApellido2,
                      ' ',
                        YEAR(CURDATE())
                      - YEAR(fchNacimiento)
                      + IF(
                           DATE_FORMAT(CURDATE(), '%m-%d') >
                              DATE_FORMAT(fchNacimiento, '%m-%d'),
                           0,
                           -1)),
                   '')
                   AS edades,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE       YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) >= 15
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS cantMayor,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE       YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) >= 15
                       AND   YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) < 60
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS adultos,
                (SELECT sum(numAnosAprobados)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE     hog1.seqParentesco = 1
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS aprobadosJefe,
                (SELECT sum(numAnosAprobados)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE       YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) >= 15
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS aprobados,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE hog1.seqFormulario = hog.seqFormulario AND seqSalud IN (1, 2))
                   AS afiliacion,
                numHabitaciones     AS cohabitacion,
                numHacinamiento     AS dormitorios,
                sum(valIngresos)    AS ingresos,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE       YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) <= 12
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS cantMenores,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE seqParentesco = 3 AND hog1.seqFormulario = hog.seqFormulario)
                   AS cantHijos,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE     seqSexo = 2
                       AND hog1.seqFormulario = hog.seqFormulario
                       AND (   seqCondicionEspecial IN (1)
                            OR seqCondicionEspecial2 IN (1)
                            OR seqCondicionEspecial3 IN (1)))
                   AS mujerCabHogar,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE seqParentesco = 2 AND hog1.seqFormulario = hog.seqFormulario)
                   AS conyugueHogar,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE       YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) > 59
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS cantadultoMayor,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE     hog1.seqFormulario = hog.seqFormulario
                       AND (   seqCondicionEspecial IN (3)
                            OR seqCondicionEspecial2 IN (3)
                            OR seqCondicionEspecial3 IN (3)))
                   AS cantCondEspecial,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE seqEtnia > 1 AND hog1.seqFormulario = hog.seqFormulario)
                   AS condicionEtnica,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE       YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) > 12
                       AND   YEAR(CURDATE())
                           - YEAR(ciu1.fchNacimiento)
                           + IF(
                                DATE_FORMAT(CURDATE(), '%m-%d') >
                                   DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                                0,
                                -1) < 19
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS adolecentes,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE     seqSexo = 1
                       AND (   seqCondicionEspecial IN (1)
                            OR seqCondicionEspecial2 IN (1)
                            OR seqCondicionEspecial3 IN (1))
                       AND hog1.seqFormulario = hog.seqFormulario)
                   AS hombreCabHogar,
                (SELECT count(*)
                 FROM t_ciu_ciudadano    ciu1
                      LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                 WHERE seqGrupoLgtbi > 0 AND hog1.seqFormulario = hog.seqFormulario)
                   AS grupoLgtbi,
                bolIntegracionSocial,
                bolSecEducacion,
                bolSecMujer,
                bolSecSalud,
                bolAltaCon,
                bolIpes
         FROM t_frm_formulario    frm
              LEFT JOIN t_frm_hogar hog USING (seqFormulario)
              LEFT JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
         WHERE seqEstadoProceso IN (37) AND seqPlanGobierno = 3";
        if ($ejecutaConsultaPersonalizada) {
            $sql .= " and frm.seqFormulario in (" . $formularios . ") ";
        }
        $sql .= " GROUP BY frm.seqFormulario
         ORDER BY frm.seqFormulario";
//echo $sql; exit();
        try {
            $objRes = $aptBd->execute($sql);
            $datos = array();
            while ($objRes->fields) {
                $datos[] = $objRes->fields;
                $objRes->MoveNext();
            }
            return $datos;
        } catch (Exception $objError) {
            return $objError->msg;
        }
    }

    public function insertarCalificacion($seqFormulario, $fchUltimaActualizacion, $cant, $edades, $ingresos, $fecha) {
        global $aptBd;

        $sql = "INSERT INTO t_frm_calificacion_plan3 ( seqFormulario,fchCalificacion, fchActualizacionFormulario, cantMiembrosHogar, infHogar, totalIngresos) VALUES";
        $sql .= "(" . $seqFormulario . ", '" . $fecha . "', '" . $fchUltimaActualizacion . "'," . $cant . ", '" . $edades . "', " . $ingresos . ");";
        try {
            //echo "*****<br>".$sql;
            $aptBd->execute($sql);
            $datoID = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $datoID = $objError->msg;
        }
        return $datoID;
    }

    public function cambiarEstado($formularios) {
        global $aptBd;
        $band = false;
        $sql = "UPDATE T_FRM_FORMULARIO SET seqEstadoProceso = 53 where seqFormulario in (" . $formularios . ")";
        try {
            $objRes = $aptBd->execute($sql);
            $band = true;
        } catch (Exception $objError) {
            $band = false;
        }
        return $band;
    }

    public function insertarIndicadores($indicadores) {
        global $aptBd;

        $sql = "INSERT INTO t_frm_calificacion_operaciones(cantidadMiembros,cantJefeHogar,tipo, cantConyugue,cantAnos,calculo,resultado,total, seqCalificacion,seqIndicador) VALUES";
        $sql .= $indicadores;

        try {
            $aptBd->execute($sql);
            return true;
        } catch (Exception $objError) {
            return $objError->msg;
        }
    }

    public function insertarSeguimiento($seguimientos) {
        //echo "<br>".$seguimientos."<br>";
        global $aptBd;

        $sql = "INSERT INTO T_SEG_SEGUIMIENTO (
         seqFormulario, 
         fchMovimiento, 
         seqUsuario, 
         txtComentario, 
         txtCambios, 
         numDocumento, 
         txtNombre, 
         seqGestion, 
         bolMostrar
      ) VALUES ";
        $seguimientos = substr_replace($seguimientos, ';', -1, 1);
        $sql .= $seguimientos;

        try {
            $aptBd->execute($sql);
            return true;
        } catch (Exception $objError) {
            return $objError->msg;
        }
    }

    public function listarCalificacion($fecha) {

        global $aptBd;

        $sql = "SELECT  t_frm_calificacion_plan3.*, sum(total) as total FROM t_frm_calificacion_plan3
left join t_frm_calificacion_operaciones using(seqCalificacion)
where fchCalificacion = '" . trim($fecha) . "'
group by seqCalificacion;";

        try {
            $objRes = $aptBd->execute($sql);
            $datos = array();
            while ($objRes->fields) {
                $datos[] = $objRes->fields;
                $objRes->MoveNext();
            }
            return $datos;
        } catch (Exception $objError) {
            return $objError->msg;
        }
        return $datos;
    }

    public function obtenerResumenCalificacion($fecha) {

        $sql = "SELECT seqFormulario,
       numDocumento,
       concat(txtNombre1,
              ' ',
              txtNombre2,
              ' ',
              txtApellido1,
              ' ',
              txtApellido2)
          AS postulante, 
          frm.numTelefono1,
          frm.numTelefono2,
          frm.numCelular,
          CASE  bolDesplazado WHEN 1 THEN 'Victima' 
       WHEN 0 THEN 'Vulnerable' END 
          AS victima,
          #txtTipoVictima,
          mo.txtModalidad,
          #cal.infHogar,
       cal.cantMiembrosHogar,
       CASE WHEN op.seqIndicador = 1 THEN op.cantidadMiembros END
          AS miembros15,
       CASE WHEN op.seqIndicador = 1 THEN op.cantAnos END AS anosAprobados,
       CASE WHEN op.seqIndicador = 1 THEN op.calculo END  AS calculoEducacion,
       CASE WHEN op.seqIndicador = 1 THEN op.resultado END
          AS dicotomiaEducacion,
       CASE WHEN op.seqIndicador = 1 THEN op.total END    AS totalEducacion,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 2)
          AS miembroSubsidiados,
       (SELECT calculo
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 2)
          AS calculoSubsidiados,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 2)
          AS totalSubsidiados,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 3)
          AS cohabitacion,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 3)
          AS dicotomiaCohabitacion,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 3)
          AS totalCohabitacion,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 4)
          AS dormitorios,
       (SELECT calculo
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 4)
          AS calculoHacinamiento,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 4)
          AS totalHacinamiento,
       cal.totalIngresos  AS ingresosHogar,
       (SELECT calculo
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 5)
          AS calculoIngresos,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 5)
          AS totalIngresos,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 6)
          AS miembroOcupados,
       (SELECT calculo
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 6)
          AS calculosDependencia,
       (SELECT cantAnos
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 6)
          AS aprobadosPostulante,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 6)
          AS dicotomiaDependencia,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 6)
          AS totalDependencia,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 7)
          AS cantMenores,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 7)
          AS calculosMenores,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 7)
          AS totalMenores,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 8)
          AS cantHijos,
       (SELECT cantJefeHogar
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 8
              AND op2.tipo = 1)
          AS mujerCabezaHogar,
       (SELECT cantConyugue
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 8)
          AS PersonaConyugue,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 8)
          AS dicotomiaMujeCab,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 8)
          AS totalMujerCabHogar,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 9)
          AS cantAdultoMayor,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 9)
          AS calculoAdultoMayor,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 9)
          AS totalAdultoMayor,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 10)
          AS cantCondEspecial,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 10)
          AS calculoCondEspecial,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 10)
          AS totalCondEspecial,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 11)
          AS cantGrupoEtnico,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 11)
          AS calculoGrupoEtnico,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 11)
          AS totalGrupoEtnico,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 12)
          AS cantAdolencentes,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 12)
          AS calculoAdolencentes,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 12)
          AS totalAdolencentes,
       (SELECT cantJefeHogar
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 13
              AND op2.tipo = 2)
          AS hombreCabezaHogar,
       (SELECT cantConyugue
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 13)
          AS PersonaConyugue,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 13)
          AS dicotomiaHombreCab,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 13)
          AS totalHombeCabHogar,
       (SELECT cantidadMiembros
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 14)
          AS cantLGTBI,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 14)
          AS calculoLGTBI,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 14)
          AS totalLGTBI,
       (SELECT resultado
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 15)
          AS dicotomiaPrograma,
       (SELECT total
        FROM t_frm_calificacion_operaciones op2
        WHERE     op2.seqCalificacion = cal.seqCalificacion
              AND op2.seqIndicador = 15)
          AS totalPrograma,
       sum(op.total)
FROM t_frm_calificacion_plan3    cal
     LEFT JOIN t_frm_calificacion_operaciones op USING (seqCalificacion)
     LEFT JOIN t_frm_formulario frm USING (seqFormulario)
     LEFT JOIN t_frm_hogar hog USING (seqFormulario)
     LEFT JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
     LEFT JOIN t_frm_tipovictima vic USING(seqTipoVictima)
     LEFT JOIN t_frm_modalidad mo USING(seqModalidad)
where fchCalificacion like '" . $fecha . "'
and seqParentesco = 1
group by seqFormulario";
        //echo $sql; die();
        return $sql;
    }

}
