<?php

/**
 * MANEJO DE LAS ENCUESTAS DE CARACTERIZACION DE POBLACION SIPIVE
 * @author Bernardo Zerda
 * @version 1.0 Abril 2017
 */
class Encuestas {

    public $seqDiseno;
    public $txtDiseno;
    public $bolFormulario;
    public $bolCiudadano;
    public $arrPlantilla;
    public $arrAplicacion;
    private $arrSeqFormulario;
    private $arrPregunta;
    private $arrVariablesCalificacion;

    function __construct() {
        $this->seqDiseno = 0;
        $this->txtDiseno = 0;
        $this->bolFormulario = 0;
        $this->bolCiudadano = 0;
        $this->arrSeqFormulario = array();
        $this->arrPregunta = array();
        $this->arrAplicacion = Array();

        // Para el diseno de potenciales beneficiarios (seqDiseno 1)
        $this->arrVariablesCalificacion[1]['orden'] = 52;
        $this->arrVariablesCalificacion[1]['cedula'] = 61;
        $this->arrVariablesCalificacion[1]['edad'] = 81;
        $this->arrVariablesCalificacion[1]['primerNombre'] = 53;
        $this->arrVariablesCalificacion[1]['segundoNombre'] = 54;
        $this->arrVariablesCalificacion[1]['primerApellido'] = 55;
        $this->arrVariablesCalificacion[1]['segundoApellido'] = 56;
        $this->arrVariablesCalificacion[1]['aniosAprobados'] = 125;
        $this->arrVariablesCalificacion[1]['secundaria'] = 120;
        $this->arrVariablesCalificacion[1]['tecnico'] = 121;
        $this->arrVariablesCalificacion[1]['tecnologo'] = 122;
        $this->arrVariablesCalificacion[1]['universitario'] = 123;
        $this->arrVariablesCalificacion[1]['posgrado'] = 124;
        $this->arrVariablesCalificacion[1]['jefeHogar'] = 62;
        $this->arrVariablesCalificacion[1]['afiliadoSalud'] = 155;
        $this->arrVariablesCalificacion[1]['noAfiliado'] = 156;
        $this->arrVariablesCalificacion[1]['asalariado'] = 252;
        $this->arrVariablesCalificacion[1]['independiente'] = 253;
        $this->arrVariablesCalificacion[1]['pensiones'] = 254;
        $this->arrVariablesCalificacion[1]['hijo'] = 64;
        $this->arrVariablesCalificacion[1]['conyuge'] = 63;
        $this->arrVariablesCalificacion[1]['condiciones'] = 161;
        $this->arrVariablesCalificacion[1]['indigena'] = 82;
        $this->arrVariablesCalificacion[1]['gitano'] = 83;
        $this->arrVariablesCalificacion[1]['raizal'] = 84;
        $this->arrVariablesCalificacion[1]['palenquero'] = 85;
        $this->arrVariablesCalificacion[1]['negro'] = 86;
        $this->arrVariablesCalificacion[1]['intersexual'] = 74;
        $this->arrVariablesCalificacion[1]['homosexual'] = 75;
        $this->arrVariablesCalificacion[1]['bisexual'] = 76;
        $this->arrVariablesCalificacion[1]['transgenero'] = 80;
        $this->arrVariablesCalificacion[1]['hombre'] = 72;
        $this->arrVariablesCalificacion[1]['mujer'] = 73;
        $this->arrVariablesCalificacion[1]['cohabitacion'] = 35;
        $this->arrVariablesCalificacion[1]['dormitorios'] = 38;
        $this->arrVariablesCalificacion[1]['integracion'] = 0;
        $this->arrVariablesCalificacion[1]['educacion'] = 0;
        $this->arrVariablesCalificacion[1]['mujer'] = 0;
        $this->arrVariablesCalificacion[1]['salud'] = 0;
        $this->arrVariablesCalificacion[1]['altacon'] = 0;
        $this->arrVariablesCalificacion[1]['ipes'] = 0;

        // Para el diseno de caracterizacion socioeconomica (seqDiseno 3)
        $this->arrVariablesCalificacion[3]['orden'] = 524;
        $this->arrVariablesCalificacion[3]['cedula'] = 533;
        $this->arrVariablesCalificacion[3]['edad'] = 534;
        $this->arrVariablesCalificacion[3]['primerNombre'] = 525;
        $this->arrVariablesCalificacion[3]['segundoNombre'] = 526;
        $this->arrVariablesCalificacion[3]['primerApellido'] = 527;
        $this->arrVariablesCalificacion[3]['segundoApellido'] = 528;
        $this->arrVariablesCalificacion[3]['aniosAprobados'] = 598;
        $this->arrVariablesCalificacion[3]['secundaria'] = 593;
        $this->arrVariablesCalificacion[3]['tecnico'] = 594;
        $this->arrVariablesCalificacion[3]['tecnologo'] = 595;
        $this->arrVariablesCalificacion[3]['universitario'] = 596;
        $this->arrVariablesCalificacion[3]['posgrado'] = 597;
        $this->arrVariablesCalificacion[3]['jefeHogar'] = 535;
        $this->arrVariablesCalificacion[3]['afiliadoSalud'] = 626;
        $this->arrVariablesCalificacion[3]['noAfiliado'] = 627;
        $this->arrVariablesCalificacion[3]['asalariado'] = 723;
        $this->arrVariablesCalificacion[3]['independiente'] = 724;
        $this->arrVariablesCalificacion[3]['pensiones'] = 725;
        $this->arrVariablesCalificacion[3]['hijo'] = 537;
        $this->arrVariablesCalificacion[3]['conyuge'] = 536;
        $this->arrVariablesCalificacion[3]['condiciones'] = 632;
        $this->arrVariablesCalificacion[3]['indigena'] = 553;
        $this->arrVariablesCalificacion[3]['gitano'] = 554;
        $this->arrVariablesCalificacion[3]['raizal'] = 555;
        $this->arrVariablesCalificacion[3]['palenquero'] = 556;
        $this->arrVariablesCalificacion[3]['negro'] = 557;
        $this->arrVariablesCalificacion[3]['intersexual'] = 546;
        $this->arrVariablesCalificacion[3]['homosexual'] = 547;
        $this->arrVariablesCalificacion[3]['bisexual'] = 548;
        $this->arrVariablesCalificacion[3]['transgenero'] = 552;
        $this->arrVariablesCalificacion[3]['hombre'] = 544;
        $this->arrVariablesCalificacion[3]['mujer'] = 545;
        $this->arrVariablesCalificacion[3]['cohabitacion'] = 507;
        $this->arrVariablesCalificacion[3]['dormitorios'] = 510;
        $this->arrVariablesCalificacion[3]['integracion'] = 734;
        $this->arrVariablesCalificacion[3]['educacion'] = 0;
        $this->arrVariablesCalificacion[3]['mujer'] = 735;
        $this->arrVariablesCalificacion[3]['salud'] = 0;
        $this->arrVariablesCalificacion[3]['altacon'] = 0;
        $this->arrVariablesCalificacion[3]['ipes'] = 733;
    }

    public function obtenerDiseno($seqDiseno = 0) {
        global $aptBd;
        $arrDisenos = array();
        $sql = "
                select 
                        seqDiseno, 
                        txtDiseno, 
                        bolFormulario, 
                        bolCiudadano 
                from t_enc_diseno ";
        $sql .= ($seqDiseno == 0) ? "" : "where seqDiseno = " . $seqDiseno;
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $claEncuesta = null;
            $claEncuesta = new Encuestas();
            $claEncuesta->seqDiseno = $objRes->fields['seqDiseno'];
            $claEncuesta->txtDiseno = $objRes->fields['txtDiseno'];
            $claEncuesta->bolFormulario = $objRes->fields['bolFormulario'];
            $claEncuesta->bolCiudadano = $objRes->fields['bolCiudadano'];
            $arrDisenos[] = $claEncuesta;
            $objRes->MoveNext();
        }
        return $arrDisenos;
    }

    public function validarTitiulos($arrLinea, $txtDestino) {
        global $aptBd;
        $arrErrores = array();
        if ($txtDestino == "formulario" or $txtDestino == "ciudadano") {

            // verifica que la primera columna sea el identificador de formulario
            if (trim(mb_strtoupper($arrLinea[0])) != "FORMULARIO") {
                $arrErrores[] = "No se encuentra la columna FORMULARIO en el archivo de respuestas de " . strtoupper($txtDestino);
            }
            unset($arrLinea[0]); // formulario
            // Identifica la tabla destino de las preguntas donde se almacenará la respuesta
            if ($txtDestino == "formulario") {
                $txtTablaDestino = "T_ENC_APLICACION_FORMULARIO";
            } else {
                $txtTablaDestino = "T_ENC_APLICACION_CIUDADANO";
            }

            $sql = "
					select distinct
                    res.txtIdentificador
					from t_enc_diseno dis
					inner join t_enc_seccion sec on dis.seqDiseno = sec.seqDiseno
					inner join t_enc_subseccion sse on sec.seqSeccion = sse.seqSeccion
					inner join t_enc_pregunta pre on sse.seqSubseccion = pre.seqSubseccion
					inner join t_enc_respuesta res on pre.seqPregunta = res.seqPregunta
					where dis.bolActivo = 1
					and sec.bolActivo = 1
					and sse.bolActivo = 1
					and pre.bolActivo = 1
					and dis.seqDiseno = " . $this->seqDiseno . "
					and pre.txtTablaDestino = '" . $txtTablaDestino . "'
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                if (in_array($objRes->fields['txtIdentificador'], $arrLinea)) {
                    $i = array_shift(array_keys($arrLinea, $objRes->fields['txtIdentificador']));
                    unset($arrLinea[$i]);
                } else {
                    $arrErrores[] = "En el archivo $txtDestino, falta la pregunta con el identificador " . $objRes->fields['txtIdentificador'];
                }
                $objRes->MoveNext();
            }
            if (!empty($arrLinea)) {
                $arrErrores[] = "En el archivo $txtDestino, las preguntas " . implode(",", $arrLinea) . " son desconocidas";
            }
        } else {
            $arrErrores[] = "Valor del segundo parámetro no válido, use 'formulario' o 'ciudadano' como valores validos";
        }
        return $arrErrores;
    }

    /**
     * VALIDA LAS RESPUESTAS, EL TIP ODE RESPUESTA Y LOS DATOS QUE SE HAN CONTESTADO
     * @param array $arrArchivo
     * @param array $txtDestino
     * @return string
     */
    public function validarRespuestas($arrArchivo, $txtDestino) {

        if ($txtDestino != "formulario" and $txtDestino != "ciudadano") {
            $arrErrores[] = "Valor del segundo parámetro no válido, use 'formulario' o 'ciudadano' como valores validos";
        } else {
            $arrFormularios = array();
            $this->obtenerPregunta();

            foreach ($arrArchivo as $numLinea => $arrLinea) {

                if (!esNumero($arrLinea['FORMULARIO'])) {
                    $arrErrores[] = "Archivo " . $txtDestino . " - Error linea " . ($numLinea + 1) . ": Columna Formulario debe ser numérico";
                } else {
                    $numFormulario = intval($arrLinea['FORMULARIO']);
                }
                unset($arrLinea['FORMULARIO']); // formulario

                if ($txtDestino == "formulario") {
                    if (in_array($numFormulario, $arrFormularios)) {
                        $arrErrores[] = "Archivo " . $txtDestino . " - Error linea " . ($numLinea + 1) . ": No puede tener registrado el formulario [" . $numFormulario . "] en más de una ocasión";
                    } else {
                        $arrFormularios[] = $numFormulario;
                    }
                }

                foreach ($arrLinea as $txtIdentificador => $txtRespuesta) {

                    if (trim($txtRespuesta) != "") {
                        switch ($this->arrPregunta[$txtIdentificador]['tipo']) {
                            case 1: // NUMERO
                                if (!esNumero($txtRespuesta)) {
                                    $arrErrores[] = "Archivo " . $txtDestino . " - Formulario " . $numFormulario . ": Error en " . $txtIdentificador . ", respuesta debe ser un valor numérico";
                                }
                                break;
                            case 2: // TEXTO
                                // las preguntas tipo texto no tienen validacion
                                break;
                            case 3: // UNICA
                                $bolRespuestaValida = false;
                                foreach ($this->arrPregunta[$txtIdentificador]['respuesta'] as $seqRespuesta => $arrRespuesta) {
                                    if (trim($txtRespuesta) == $arrRespuesta['respuesta']) {
                                        $bolRespuestaValida = true;
                                    }
                                }
                                if ($bolRespuestaValida == false) {
                                    $arrErrores[] = "Archivo " . $txtDestino . " - Formulario " . $numFormulario . ": Error en " . $txtIdentificador . ", respuesta no válida";
                                }
                                break;
                            case 4: // FECHA
                                if (!esFechaValida($txtRespuesta)) {
                                    $arrErrores[] = "Archivo " . $txtDestino . " - Formulario " . $numFormulario . ": Error en " . $txtIdentificador . ", formato de fecha no válido (use el formato yyyy-mm-dd)";
                                }
                                break;
                            case 5: // MULTIPLE
                                // las preguntas tipo multiple no tienen validacion (las respuestas son preguntas separadas)
                                break;
                            default:
                                $arrErrores[] = "Archivo " . $txtDestino . " - Formulario " . $numFormulario . ": Error en " . $txtIdentificador . ", tipo de respuesta (" . $this->arrPregunta['tipo'] . ") desconocido";
                                break;
                        }
                    }
                }
            }
        }
        return $arrErrores;
    }

    private function obtenerPregunta($txtIdentificador = "", $txtDestino = "") {
        global $aptBd;
        $arrErrores = array();
        try {
            $txtCondicion = ( $txtIdentificador != "" ) ? "and res.txtIdentificador = '" . $txtIdentificador . "' " : "";

            if (strtolower($txtDestino) != "") {
                if (strtolower($txtDestino) == "formulario") {
                    $txtCondicion .= "and pre.txtTablaDestino = 'T_ENC_APLICACION_FORMULARIO' ";
                } else {
                    $txtCondicion .= "and pre.txtTablaDestino = 'T_ENC_APLICACION_CIUDADANO' ";
                }
            }

            $this->arrPregunta = array();

            $sql = "
					select
					  pre.seqPregunta,
					  pre.txtIdentificador as idPregunta, 
					  pre.txtPregunta, 
					  pre.seqTipoPregunta,
					  res.seqTipoRespuesta,
					  res.seqRespuesta,
					  res.txtIdentificador as idRespuesta,
					  res.txtRespuesta,
					  res.valRespuesta,
					  res.txtTablaEquivalente, 
					  res.txtCampoEquivalente, 
					  res.valEquivalente
					from t_enc_diseno dis
					inner join t_enc_seccion sec on dis.seqDiseno = sec.seqDiseno
					inner join t_enc_subseccion sse on sec.seqSeccion = sse.seqSeccion
					inner join t_enc_pregunta pre on sse.seqSubseccion = pre.seqSubseccion
					inner join t_enc_respuesta res on pre.seqPregunta = res.seqPregunta
					inner join t_enc_tipo_pregunta tpr on pre.seqTipoPregunta = tpr.seqTipoPregunta
					inner join t_enc_tipo_respuesta tre on res.seqTipoRespuesta = tre.seqTipoRespuesta
					where dis.bolActivo = 1
					and sec.bolActivo = 1
					and sse.bolActivo = 1
					and pre.bolActivo = 1
					and dis.seqDiseno = " . $this->seqDiseno . "
					$txtCondicion
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $idRespuesta = $objRes->fields['idRespuesta'];
                $seqRespuesta = $objRes->fields['seqRespuesta'];

                $this->arrPregunta[$idRespuesta]['seqPregunta'] = $objRes->fields['seqPregunta'];
                $this->arrPregunta[$idRespuesta]['identificador'] = $objRes->fields['idPregunta'];
                $this->arrPregunta[$idRespuesta]['texto'] = $objRes->fields['txtPregunta'];
                $this->arrPregunta[$idRespuesta]['tipo'] = $objRes->fields['seqTipoPregunta'];
                $this->arrPregunta[$idRespuesta]['respuesta'][$seqRespuesta]['identificador'] = $objRes->fields['idRespuesta'];
                $this->arrPregunta[$idRespuesta]['respuesta'][$seqRespuesta]['tipo'] = $objRes->fields['seqTipoRespuesta'];
                $this->arrPregunta[$idRespuesta]['respuesta'][$seqRespuesta]['texto'] = $objRes->fields['txtRespuesta'];
                $this->arrPregunta[$idRespuesta]['respuesta'][$seqRespuesta]['respuesta'] = $objRes->fields['valRespuesta'];
                $this->arrPregunta[$idRespuesta]['respuesta'][$seqRespuesta]['tabla'] = $objRes->fields['txtTablaEquivalente'];
                $this->arrPregunta[$idRespuesta]['respuesta'][$seqRespuesta]['campo'] = $objRes->fields['txtCampoEquivalente'];
                $this->arrPregunta[$idRespuesta]['respuesta'][$seqRespuesta]['valor'] = $objRes->fields['valEquivalente'];

                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            $arrErrores[] = "No se pudo obtener la informacion de la pregunta " . $txtIdentificador;
            $arrErrores[] = $objError->getMessage();
        }
        return $arrErrores;
    }

    public function salvar($txtNombre, $arrFormulario, $arrCiudadano) {
        global $aptBd;
        $arrErrores = array();
        $arrAplicaciones = array();
        try {

            $aptBd->BeginTrans();

            // obtiene los documentos de los ciudadanos vs formularios
            $this->obtenerFormulario();

            // al menos una persona debe estar en un formulario de SDV
            if ($this->bolCiudadano == 1) {
                $arrHogar = array();
                foreach ($arrCiudadano as $numLinea => $arrLinea) {
                    $txtFormulario = $arrLinea['FORMULARIO'];
                    $numDocumento = doubleval($arrLinea['NUM_DOCUM']);
                    $seqFormulario = (isset($this->arrSeqFormulario[$numDocumento])) ? intval($this->arrSeqFormulario[$numDocumento]) : 0;

                    if (!isset($arrHogar[$txtFormulario])) {
                        $arrHogar[$txtFormulario] = $seqFormulario;
                    } elseif ($arrHogar[$txtFormulario] == 0) {
                        $arrHogar[$txtFormulario] = $seqFormulario;
                    }
                }
                foreach ($arrHogar as $txtFormulario => $seqFormulario) {
                    if ($seqFormulario == 0) {
                        $arrErrores[] = "Error formulario " . $txtFormulario . ": Ninguno de los ciudadanos reportados por la encuesta está en SiPIVE";
                    }
                }
            } else {
                $arrHogar = array();
                $arrHogarError = array();
                foreach ($arrFormulario as $numLinea => $arrLinea) {
                    $txtFormulario = $arrLinea['FORMULARIO'];
                    $numDocumento = doubleval($arrLinea['NUMERO_DOC']);
                    $seqFormulario = (isset($this->arrSeqFormulario[$numDocumento])) ? intval($this->arrSeqFormulario[$numDocumento]) : 0;
                    if (!isset($arrHogar[$txtFormulario])) {
                        $arrHogar[$txtFormulario] = $seqFormulario;
                        $arrHogarError[$txtFormulario]['formulario'] = $seqFormulario;
                        $arrHogarError[$txtFormulario]['documento'] = $numDocumento;
                    }
                }
                foreach ($arrHogarError as $txtFormulario => $arrDatos) {
                    if ($arrDatos['formulario'] == 0) {
                        $arrErrores[] = "Error formulario " . $txtFormulario . ": El ciudadano reportado (" . $arrDatos['documento'] . ") por la encuesta no está en SiPIVE";
                    }
                }
            }

            if (empty($arrErrores)) {

                // Obtiene las preguntas del formulario
                $this->obtenerPregunta("", "formulario");

                // Inactiva las aplicaciones anteriores que haya tenido el mismo hogar
                // Se pueden tener varias aplicaciones para el mismo hogar pero solo una activa
                $sql = "
                    update t_enc_aplicacion set
                        bolActiva = 0
                    where seqDiseno = " . $this->seqDiseno . "
                    and seqFormulario in ( " . implode(",", $arrHogar) . " )
                ";
                $aptBd->execute($sql);

                foreach ($arrFormulario as $numLinea => $arrRegistro) {

                    $txtFormulario = $arrRegistro['FORMULARIO'];
                    $seqFormulario = $arrHogar[$txtFormulario];

                    $sql = "
                        INSERT INTO t_enc_aplicacion(
                            seqDiseno,
                            txtNombreCargue,
                            seqFormulario,
                            txtFormulario,
                            fchAplicacion,
                            fchCarga,
                            bolActiva,
                            seqUsuarioCarga
                        ) VALUES (
                            " . $this->seqDiseno . ",
                            '" . trim($txtNombre) . "',
                            " . $seqFormulario . ",
                            '" . $arrRegistro['FORMULARIO'] . "',
                            '" . $arrRegistro['FECHA'] . "',
                            NOW(),
                            1,
                            " . $_SESSION['seqUsuario'] . "
                         );
                    ";
                    $aptBd->execute($sql);
                    $seqAplicacion = $aptBd->Insert_ID();

                    $arrAplicaciones[$txtFormulario] = $seqAplicacion;
                    unset($arrRegistro['FORMULARIO']); // formulario

                    $sql = "
                        INSERT INTO t_enc_aplicacion_formulario (
                            seqAplicacion,
                            seqRespuesta,
                            valRespuesta
                        ) VALUES
                    ";

                    foreach ($arrRegistro as $txtIdentificador => $txtValor) {
                        $seqRespuesta = $this->obtenerSecuencialRespuesta($txtIdentificador, $txtValor);
                        if ($seqRespuesta != 0) {
                            $sql .= "(" . $seqAplicacion . "," . $seqRespuesta . ",'" . trim($txtValor) . "'),";
                        }
                    }
                    $sql = rtrim($sql, ",");
                    $aptBd->execute($sql);
                }

                if ($this->bolCiudadano == 1) {

                    // Obtiene las preguntas del formulario
                    $this->obtenerPregunta("", "ciudadano");

                    foreach ($arrCiudadano as $numLinea => $arrRegistro) {
                        $txtFormulario = $arrRegistro['FORMULARIO'];
                        unset($arrRegistro['FORMULARIO']); // formulario
                        $seqAplicacion = $arrAplicaciones[$txtFormulario];

                        $sql = "
                            INSERT INTO t_enc_aplicacion_ciudadano (
                                seqAplicacion,
                                seqRespuesta,
                                valRespuesta,
                                numOrden
                            ) VALUES
                        ";

                        foreach ($arrRegistro as $txtIdentificador => $txtValor) {
                            $seqRespuesta = $this->obtenerSecuencialRespuesta($txtIdentificador, $txtValor);
                            if ($seqRespuesta != 0) {
                                $sql .= "(" . $seqAplicacion . "," . $seqRespuesta . ",'" . $txtValor . "'," . $numLinea . "),";
                            }
                        }
                        $sql = rtrim($sql, ",");
                        $aptBd->execute($sql);
                    }
                }
            }

            $aptBd->CommitTrans();

        } catch (Exception $objError) {
            $arrErrores[] = $objError->getMessage();
            $aptBd->RollbackTrans();
        }
        return $arrErrores;
    }

    private function obtenerFormulario($numDocumento = 0) {
        global $aptBd;
        $arrErrores = array();
        $this->arrSeqFormulario = array();
        $txtCondicion = ( doubleval($numDocumento) != 0 ) ? "where ciu.numDocumento = '" . $numDocumento . "'" : "";
        $sql = "
				select 
				  frm.seqFormulario,
				  ciu.numDocumento
				from t_frm_formulario frm
				inner join t_frm_hogar hog on frm.seqFormulario = hog.seqFormulario
				inner join t_ciu_ciudadano ciu on ciu.seqCiudadano = hog.seqCiudadano
				$txtCondicion
			";
        $objRes = $aptBd->execute($sql);
        if (doubleval($numDocumento) != 0) {
            if ($objRes->RecordCount() > 0) {
                $this->arrSeqFormulario[$objRes->fields['numDocumento']] = $objRes->fields['seqFormulario'];
            } else {
                $arrErrores[] = "El numero de documento " . $numDocumento . " no está vinculado a nungún formulario";
            }
        } else {
            while ($objRes->fields) {
                $this->arrSeqFormulario[$objRes->fields['numDocumento']] = $objRes->fields['seqFormulario'];
                $objRes->MoveNext();
            }
        }
        return $arrErrores;
    }

    public function listarAplicaciones($numDocumento, $seqDiseno = 0) {
        global $aptBd;
        $arrAplicaciones = array();
        $this->obtenerFormulario($numDocumento);
        $txtCondicion = ( $seqDiseno == 0 ) ? "" : "AND dis.seqDiseno = " . $seqDiseno;
        if (intval($this->arrSeqFormulario[$numDocumento]) != 0) {
            $sql = "
                SELECT 
                    apl.seqAplicacion,
                    dis.seqDiseno,
                    dis.txtDiseno,
                    apl.txtNombreCargue,
                    apl.txtFormulario,
                    apl.fchAplicacion,
                    apl.fchCarga,
                    apl.bolActiva,
                    dis.bolCruces
                FROM t_enc_aplicacion apl
                INNER JOIN t_enc_diseno dis ON dis.seqDiseno = apl.seqDiseno
                WHERE dis.bolActivo = 1
                $txtCondicion
                AND apl.seqFormulario = " . $this->arrSeqFormulario[$numDocumento] . "
                ORDER BY 
                  apl.bolActiva DESC,
                  apl.fchAplicacion DESC,
                  apl.fchCarga DESC
            ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $arrAplicaciones[] = $objRes->fields;
                $objRes->MoveNext();
            }
        }

        return $arrAplicaciones;
    }

    public function eliminarEncuestas($seqAplicacion) {
        global $aptBd;
        $arrErrores = array();
        try {
            $sql = " 
					select max(seqAplicacion) as seqAplicacion
					from t_enc_aplicacion apl1
					inner join (
						select max(apl.fchAplicacion) as fchAplicacion
						from t_enc_aplicacion apl
						where seqFormulario = (
							select seqFormulario
							from t_enc_aplicacion
							where seqAplicacion = " . $seqAplicacion . "
							) and apl.seqAplicacion <> " . $seqAplicacion . "
						) apl on apl.fchAplicacion = apl1.fchAplicacion
				";
            $objRes = $aptBd->execute($sql);
            $aptBd->execute("UPDATE T_ENC_APLICACION SET bolActiva = 1 WHERE seqAplicacion = " . $objRes->fields['seqAplicacion']);
            $aptBd->execute("DELETE FROM T_ENC_APLICACION_CIUDADANO WHERE seqAplicacion = " . $seqAplicacion);
            $aptBd->execute("DELETE FROM T_ENC_APLICACION_FORMULARIO WHERE seqAplicacion = " . $seqAplicacion);
            $aptBd->execute("DELETE FROM T_ENC_APLICACION WHERE seqAplicacion = " . $seqAplicacion);
        } catch (Exception $objError) {
            $arrErrores[] = "No se pudo eliminar la aplicacion";
            $arrErrores[] = $objError->getMessage();
        }

        return $arrErrores;
    }

    public function obtenerCargue() {
        global $aptBd;
        $arrCargue = array();
        $sql = "select distinct txtNombreCargue from t_enc_aplicacion";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrCargue[] = $objRes->fields["txtNombreCargue"];
            $objRes->MoveNext();
        }
        return $arrCargue;
    }

    private function obtenerSecuencialRespuesta($txtIdentificador, $txtValor) {
        $seqRespuesta = 0;
        if ($this->arrPregunta[$txtIdentificador]['tipo'] == 3) {
            $bolRespuesta = false;
            foreach ($this->arrPregunta[$txtIdentificador]['respuesta'] as $seqRespuesta => $arrRespuesta) {
                if (trim($txtValor) == $arrRespuesta['respuesta']) {
                    $bolRespuesta = true;
                    break;
                }
            }
            $seqRespuesta = ($bolRespuesta == true) ? $seqRespuesta : 0;
        } else {
            if (!is_null($this->arrPregunta[$txtIdentificador]['respuesta'])) {
                $arrPrimeraRespuesta = array_keys($this->arrPregunta[$txtIdentificador]['respuesta']);
                $seqRespuesta = $arrPrimeraRespuesta[0];
            }
        }
        return $seqRespuesta;
    }

    public function obtenerEncuesta($seqAplicacion) {
        global $aptBd;

        $this->arrAplicacion = array();

        $sql = "
                select
                        apl.txtNombreCargue,
                        apl.txtFormulario,
                        apl.fchAplicacion,
                        apl.fchCarga,
                        apl.seqUsuarioCarga,
                        afo.seqRespuesta,
                        afo.valRespuesta
                from t_enc_aplicacion apl
                inner join t_enc_aplicacion_formulario afo on apl.seqAplicacion = afo.seqAplicacion
                where apl.seqAplicacion = " . $seqAplicacion . "
			";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            foreach ($objRes->fields as $txtCampo => $txtValor) {
                $$txtCampo = iconv("UTF-8", "Windows-1252", $txtValor);
            }
            $this->arrAplicacion['encabezado']['nombre'] = $txtNombreCargue;
            $this->arrAplicacion['encabezado']['formulario'] = $txtFormulario;
            $this->arrAplicacion['encabezado']['fchAplicacion'] = $fchAplicacion;
            $this->arrAplicacion['encabezado']['fchCarga'] = $fchCarga;
            $arrUsuario = obtenerDatosTabla("T_COR_USUARIO", array("seqUsuario", "txtNombre", "txtApellido"), "seqUsuario", "seqUsuario = " . $objRes->fields['seqUsuarioCarga']);
            $this->arrAplicacion['encabezado']['txtUsuario'] = $arrUsuario[$objRes->fields['seqUsuarioCarga']]['txtNombre'] . " " . $arrUsuario[$objRes->fields['seqUsuarioCarga']]['txtApellido'];
            $this->arrAplicacion['formulario'][$seqRespuesta] = $valRespuesta;
            $objRes->MoveNext();
        }

        $sql = "
				select
					aci.seqRespuesta,
					aci.numOrden,
					aci.valRespuesta
				from t_enc_aplicacion apl
				inner join t_enc_aplicacion_ciudadano aci on apl.seqAplicacion = aci.seqAplicacion
				where apl.seqAplicacion = " . $seqAplicacion . "
			";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            foreach ($objRes->fields as $txtCampo => $txtValor) {
                $$txtCampo = iconv("UTF-8", "Windows-1252", $txtValor);
            }
            $this->arrAplicacion['ciudadano'][$numOrden][$seqRespuesta] = $valRespuesta;
            $objRes->MoveNext();
        }

        // todas las preguntas y respuestas posibles del formulario
        $sql = "
				select
					dis.seqDiseno,
					dis.txtDiseno,
					dis.bolFormulario,
					dis.bolCiudadano,
					sec.txtSeccion,
					sse.txtSubseccion,
					pre.seqPregunta,
					pre.txtIdentificador as idPregunta,
					pre.txtPregunta,
					pre.txtTablaDestino,
					tpr.seqTipoPregunta,
					res.seqRespuesta,
					res.seqTipoRespuesta,
					res.txtIdentificador as idRespuesta,
					res.txtRespuesta,
					res.valRespuesta,
					res.txtTablaEquivalente,
					res.txtCampoEquivalente,
					res.valEquivalente,
					pre.txtIdentificadorPadre
				from t_enc_diseno dis
				inner join t_enc_aplicacion apl on apl.seqDiseno = dis.seqDiseno
				inner join t_enc_seccion sec on dis.seqDiseno = sec.seqDiseno
				inner join t_enc_subseccion sse on sec.seqSeccion = sse.seqSeccion
				inner join t_enc_pregunta pre on sse.seqSubseccion = pre.seqSubseccion
				left join t_enc_respuesta res on pre.seqPregunta = res.seqPregunta
				inner join t_enc_tipo_pregunta tpr on pre.seqTipoPregunta = tpr.seqTipoPregunta
				left join t_enc_tipo_respuesta tre on res.seqTipoRespuesta = tre.seqTipoRespuesta
				where dis.bolActivo = 1
				and sec.bolActivo = 1
				and sse.bolActivo = 1
				and pre.bolActivo = 1
				and apl.seqAplicacion = " . $seqAplicacion . "
			";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {

            foreach ($objRes->fields as $txtCampo => $txtValor) {
                $$txtCampo = iconv("UTF-8", "Windows-1252", $txtValor);
            }

            $this->txtDiseno = $txtDiseno;
            $this->seqDiseno = $seqDiseno;
            $this->bolFormulario = $bolFormulario;
            $this->bolCiudadano = $bolCiudadano;

            $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['pregunta'] = $txtPregunta;
            $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['tipo'] = $seqTipoPregunta;
            $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['destino'] = $txtTablaDestino;
            $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['padre'] = $txtIdentificadorPadre;
            if (intval($seqRespuesta) != 0) {
                $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['respuesta'][$seqRespuesta]['identificador'] = $idRespuesta;
                $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['respuesta'][$seqRespuesta]['tipo'] = $seqTipoRespuesta;
                $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['respuesta'][$seqRespuesta]['texto'] = $txtRespuesta;
                $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['respuesta'][$seqRespuesta]['tabla'] = $txtTablaEquivalente;
                $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['respuesta'][$seqRespuesta]['campo'] = $txtCampoEquivalente;
                $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['respuesta'][$seqRespuesta]['valor'] = $valEquivalente;
            } else {
                $this->arrPlantilla[$txtSeccion][$txtSubseccion][$idPregunta]['respuesta'] = array();
            }

            // TRANSFORMACION DE LAS EQUIVALENCIAS CONFIGURADAS
            if ($txtTablaEquivalente != "") {
                if ($txtTablaDestino == "T_ENC_APLICACION_FORMULARIO") {
                    if (isset($this->arrAplicacion['formulario'][$seqRespuesta])) {
                        if (intval($valEquivalente) != 0) {
                            $this->arrAplicacion['formulario'][$seqRespuesta] = $valEquivalente;
                        } else {
                            $this->arrAplicacion['formulario'][$seqRespuesta] = mb_strtoupper(obtenerCampo(
                                            $txtTablaEquivalente, $this->arrAplicacion['formulario'][$seqRespuesta], "txt" . ucwords(substr(strtolower($txtCampoEquivalente), 3)), $txtCampoEquivalente
                            ));
                        }
                    }
                } else {
                    foreach ($this->arrAplicacion['ciudadano'] as $numOrden => $arrCiudadano) {
                        if (isset($arrCiudadano[$seqRespuesta])) {
                            if (intval($valEquivalente) != 0) {
                                $this->arrAplicacion['ciudadano'][$numOrden][$seqRespuesta] = $valEquivalente;
                            } else {
                                $this->arrAplicacion['ciudadano'][$numOrden][$seqRespuesta] = mb_strtoupper(obtenerCampo(
                                                $txtTablaEquivalente, $this->arrAplicacion['formulario'][$seqRespuesta], "txt" . ucwords(substr(strtolower($txtCampoEquivalente), 3)), $txtCampoEquivalente
                                ));
                            }
                        }
                    }
                }
            }
            $objRes->MoveNext();
        }
    }

    function obtenerVariablesCalificacion($numDocumento) {

        // inicializa el arreglo
        $arrVariables['errores'] = array();
        $arrVariables = array();
        $arrVariables['variables']['cant'] = 0;
        $arrVariables['variables']['edades'] = array();
        $arrVariables['variables']['cantMayor'] = 0;
        $arrVariables['variables']['adultos'] = 0;
        $arrVariables['variables']['aprobadosJefe'] = 0;
        $arrVariables['variables']['aprobados'] = 0;
        $arrVariables['variables']['afiliacion'] = 0;
        $arrVariables['variables']['cohabitacion'] = 0;
        $arrVariables['variables']['dormitorios'] = 0;
        $arrVariables['variables']['ingresos'] = 0;
        $arrVariables['variables']['cantMenores'] = 0;
        $arrVariables['variables']['cantHijos'] = 0;
        $arrVariables['variables']['mujerCabHogar'] = 0;
        $arrVariables['variables']['conyugueHogar'] = 0;
        $arrVariables['variables']['cantadultoMayor'] = 0;
        $arrVariables['variables']['cantCondEspecial'] = 0;
        $arrVariables['variables']['condicionEtnica'] = 0;
        $arrVariables['variables']['adolecentes'] = 0;
        $arrVariables['variables']['hombreCabHogar'] = 0;
        $arrVariables['variables']['grupoLgtbi'] = 0;
        $arrVariables['variables']['bolIntegracionSocial'] = 0;
        $arrVariables['variables']['bolSecEducacion'] = 0;
        $arrVariables['variables']['bolSecMujer'] = 0;
        $arrVariables['variables']['bolSecSalud'] = 0;
        $arrVariables['variables']['bolAltaCon'] = 0;
        $arrVariables['variables']['bolIpes'] = 0;

        $bolJefeHogar = false; // detecta la existencia del jefe de hogar
        $numCabezaHogar = 0; // 1 = hombre 2 o 3 = mujer

        $arrAplicaciones = $this->listarAplicaciones($numDocumento);

        // seleccionar la aplicacion de aplicacion mas reciente donde bolCruces = 1
        $fchAplicacion = null;
        $seqAplicacion = 0;
        $seqDiseno = 0;
        foreach ($arrAplicaciones as $arrDatos) {
            if ($arrDatos['bolActiva'] == 1
                    and $arrDatos['bolCruces'] == 1
                    and strtotime($fchAplicacion) <= strtotime($arrDatos['fchAplicacion'])) {
                $fchAplicacion = $arrDatos['fchAplicacion'];
                $seqAplicacion = $arrDatos['seqAplicacion'];
                $seqDiseno = $arrDatos['seqDiseno'];
            }
        }

        if ($seqAplicacion != 0) {

            // obtiene las respuestas del hogar en la encuesta
            $this->arrAplicacion = Array();
            $this->obtenerEncuesta($seqAplicacion);

            // cantidad de miembros del hogar
            $arrVariables['variables']['cant'] = count($this->arrAplicacion['ciudadano']);

            // recorre los ciudadanos cargados en la encuesta
            foreach ($this->arrAplicacion['ciudadano'] as $arrCiudadano) {

                $numPosicionOrden = $this->arrVariablesCalificacion[$seqDiseno]['orden'];
                $numPosicionCedula = $this->arrVariablesCalificacion[$seqDiseno]['cedula'];
                $numPosicionEdad = $this->arrVariablesCalificacion[$seqDiseno]['edad'];
                $numPosicionPrimerNombre = $this->arrVariablesCalificacion[$seqDiseno]['primerNombre'];
                $numPosicionSegundoNombre = $this->arrVariablesCalificacion[$seqDiseno]['segundoNombre'];
                $numPosicionPrimerApellido = $this->arrVariablesCalificacion[$seqDiseno]['primerApellido'];
                $numPosicionSegundoApellido = $this->arrVariablesCalificacion[$seqDiseno]['segundoApellido'];

                $numOrden = intval($arrCiudadano[$numPosicionOrden]);  // Orden del ciudadano
                $numCedula = intval($arrCiudadano[$numPosicionCedula]); // Numero del documento del ciudadano
                $numEdad = intval($arrCiudadano[$numPosicionEdad]);   // Edad del ciudadano
                $nombres = $arrCiudadano[$numPosicionPrimerNombre] . " " . $arrCiudadano[$numPosicionSegundoNombre] . " " . $arrCiudadano[$numPosicionPrimerApellido] . " " . $arrCiudadano[$numPosicionSegundoApellido];
                // si no se contesta la cedula entonces toma el orden del miembro de hogar
                if (intval($numCedula) == 0) {
                    $numCedula = $numOrden;
                }

                // opercaiones con las edades
                if (doubleval($numCedula) != 0) {

                    // edades
                    $arrVariables['variables']['edades'][$numCedula] = $numEdad;
                    $arrVariables['variables']['nombres'][$numCedula] = $nombres;

                    // cantMayor
                    if ($numEdad >= 15) {
                        $arrVariables['variables']['cantMayor'] ++;
                    }

                    // adultos
                    if ($numEdad >= 15 and $numEdad <= 60) {
                        $arrVariables['variables']['adultos'] ++;
                    }

                    // adolecente
                    if ($numEdad >= 12 and $numEdad <= 19) {
                        $arrVariables['variables']['adolecentes'] ++;
                    }

                    // cantMenores
                    if ($numEdad <= 12) {
                        $arrVariables['variables']['cantMenores'] ++;
                    }

                    // cantadultoMayor
                    if ($numEdad > 59) {
                        $arrVariables['variables']['cantadultoMayor'] ++;
                    }
                } else {
                    $arrVariables['errores'][] = "No se ha contestado la pregunta NUMERO DE DOCUMENTO / ORDEN para el ciudadano $numOrden de la encuesta";
                }

                // años aprobados por el grupo familiar
                $numPosicionAnios = $this->arrVariablesCalificacion[$seqDiseno]['aniosAprobados'];
                if (isset($arrCiudadano[$numPosicionAnios])) {

                    $numPosicionSecundaria = $this->arrVariablesCalificacion[$seqDiseno]['secundaria'];
                    $numPosicionTecnico = $this->arrVariablesCalificacion[$seqDiseno]['tecnico'];
                    $numPosicionTecnologo = $this->arrVariablesCalificacion[$seqDiseno]['tecnologo'];
                    $numPosicionUniversitario = $this->arrVariablesCalificacion[$seqDiseno]['universitario'];
                    $numPosicionPosgrado = $this->arrVariablesCalificacion[$seqDiseno]['posgrado'];

                    // Los años aprobados de acuerdo al nivel educativo
                    switch (true) {
                        case isset($arrCiudadano[$numPosicionSecundaria]):  // basica secundaria
                            $arrCiudadano[$numPosicionAnios] += 5;
                            break;
                        case isset($arrCiudadano[$numPosicionTecnico]):  // tecnico
                            $arrCiudadano[$numPosicionAnios] += 11;
                            break;
                        case isset($arrCiudadano[$numPosicionTecnologo]):  // tecnologo
                            $arrCiudadano[$numPosicionAnios] += 11;
                            break;
                        case isset($arrCiudadano[$numPosicionUniversitario]):  // universitario
                            $arrCiudadano[$numPosicionAnios] += 11;
                            break;
                        case isset($arrCiudadano[$numPosicionPosgrado]):  // postgrado
                            $arrCiudadano[$numPosicionAnios] += 11;
                            break;
                    }

                    // acumula los años aprobados por los mayores de 15 del grupo familiar
                    if ($numEdad >= 15) {
                        $arrVariables['variables']['aprobados'] += intval($arrCiudadano[$numPosicionAnios]);
                    }

                    // es jefe de hogar cuenta los años aprobados aparte
                    $numPosicionJefe = $this->arrVariablesCalificacion[$seqDiseno]['jefeHogar'];
                    if (isset($arrCiudadano[$numPosicionJefe])) {
                        $arrVariables['variables']['aprobadosJefe'] = $arrCiudadano[$numPosicionAnios];
                    }

                    // afilacion salud o no afiliado
                    $numPosicionAfiliado = $this->arrVariablesCalificacion[$seqDiseno]['afiliadoSalud'];
                    $numPosicionNoAfiliado = $this->arrVariablesCalificacion[$seqDiseno]['noAfiliado'];
                    if (intval($arrCiudadano[$numPosicionAfiliado]) != 0 or intval($arrCiudadano[$numPosicionNoAfiliado]) != 0) {
                        $arrVariables['variables']['afiliacion'] ++;
                    }

                    // sumando ingresos del hogar
                    $numPosicionEmpleado = $this->arrVariablesCalificacion[$seqDiseno]['asalariado'];
                    $numPosicionIndependiente = $this->arrVariablesCalificacion[$seqDiseno]['independiente'];
                    $numPosicionPensionado = $this->arrVariablesCalificacion[$seqDiseno]['pensiones'];
                    $arrVariables['variables']['ingresos'] += doubleval($arrCiudadano[$numPosicionEmpleado]);
                    $arrVariables['variables']['ingresos'] += doubleval($arrCiudadano[$numPosicionIndependiente]);
                    $arrVariables['variables']['ingresos'] += doubleval($arrCiudadano[$numPosicionPensionado]);

                    // cantHijos
                    $numPosicionHijo = $this->arrVariablesCalificacion[$seqDiseno]['hijo'];
                    if (intval($arrCiudadano[$numPosicionHijo]) != 0) {
                        $arrVariables['variables']['cantHijos'] ++;
                    }

                    // conyugueHogar
                    $numPosicionConyuge = $this->arrVariablesCalificacion[$seqDiseno]['conyuge'];
                    if (intval($arrCiudadano[$numPosicionConyuge]) != 0) {
                        $arrVariables['variables']['conyugueHogar'] ++;
                    }

                    // condiciones especiales
                    $numPosicionCondicion = $this->arrVariablesCalificacion[$seqDiseno]['condiciones'];
                    if (intval($arrCiudadano[$numPosicionCondicion]) != 0) {
                        $arrVariables['variables']['cantCondEspecial'] ++;
                    }

                    // condicion etnica

                    $numPosicionIndigena = $this->arrVariablesCalificacion[$seqDiseno]['indigena'];
                    $numPosicionGitano = $this->arrVariablesCalificacion[$seqDiseno]['gitano'];
                    $numPosicionRaizal = $this->arrVariablesCalificacion[$seqDiseno]['raizal'];
                    $numPosicionPalenquero = $this->arrVariablesCalificacion[$seqDiseno]['palenquero'];
                    $numPosicionNegro = $this->arrVariablesCalificacion[$seqDiseno]['negro'];
                    if (
                            intval($arrCiudadano[$numPosicionIndigena]) != 0 or
                            intval($arrCiudadano[$numPosicionGitano]) != 0 or
                            intval($arrCiudadano[$numPosicionRaizal]) != 0 or
                            intval($arrCiudadano[$numPosicionPalenquero]) != 0 or
                            intval($arrCiudadano[$numPosicionNegro])
                    ) {
                        $arrVariables['variables']['condicionEtnica'] ++;
                    }

                    // grupo lgtbi
                    $numPosicionIntersexual = $this->arrVariablesCalificacion[$seqDiseno]['intersexual'];
                    $numPosicionHomosexual = $this->arrVariablesCalificacion[$seqDiseno]['homosexual'];
                    $numPosicionBisexual = $this->arrVariablesCalificacion[$seqDiseno]['bisexual'];
                    $numPosicionTransgenero = $this->arrVariablesCalificacion[$seqDiseno]['transgenero'];
                    if (
                            intval($arrCiudadano[$numPosicionIntersexual]) != 0 or
                            intval($arrCiudadano[$numPosicionHomosexual]) != 0 or
                            intval($arrCiudadano[$numPosicionBisexual]) != 0 or
                            intval($arrCiudadano[$numPosicionTransgenero]) != 0
                    ) {
                        $arrVariables['variables']['grupoLgtbi'] ++;
                    }
                } else {
                    $arrVariables['errores'][] = "No se ha encontrado respuesta para la pregunta de AÑOS APROBADOS para el ciudadano $numCedula";
                }

                // es jefe de hogar
                if (isset($arrCiudadano[$numPosicionJefe])) {

                    // marca la existencia del jefe de hogar
                    $bolJefeHogar = true;

                    // identificacion de sexo para detectar si es hombre o mujer cabeza de hogar
                    $numPosicionHombre = $this->arrVariablesCalificacion[$seqDiseno]['hombre'];
                    if (isset($arrCiudadano[$numPosicionHombre])) {
                        $numCabezaHogar = 1; // hombre
                    }

                    $numPosicionMujer = $this->arrVariablesCalificacion[$seqDiseno]['mujer'];
                    if (isset($arrCiudadano[$numPosicionMujer]) or isset($arrCiudadano[$numPosicionIntersexual])) {
                        $numCabezaHogar = 2; // mujer o intersexual
                    }
                }
            }

            // cohabitacion
            $numPosicionCohabitacion = $this->arrVariablesCalificacion[$seqDiseno]['cohabitacion'];
            if (intval($this->arrAplicacion['formulario'][$numPosicionCohabitacion]) != 0) {
                $arrVariables['variables']['cohabitacion'] = $this->arrAplicacion['formulario'][$numPosicionCohabitacion];
            } else {
                $arrVariables['errores'][] = "No se ha encontrado respuesta para la pregunta de ¿CUÁNTOS HOGARES CONVIVEN EN ESTA VIVIENDA?";
            }

            // dormitorios
            $numPosicionDormitorios = $this->arrVariablesCalificacion[$seqDiseno]['dormitorios'];
            if (intval($this->arrAplicacion['formulario'][$numPosicionDormitorios]) != 0) {
                $arrVariables['variables']['dormitorios'] = $this->arrAplicacion['formulario'][$numPosicionDormitorios];
            } else {
                $arrVariables['errores'][] = "No se ha encontrado respuesta para la pregunta de ¿EN CUÁNTOS DE ESTOS CUARTOS DUERMEN LAS PERSONAS DE ESTE HOGAR?";
            }

            // determina si no habia nadie como jefe de hogar
            if ($bolJefeHogar == false) {
                $arrVariables['errores'][] = "Ningún miembro de hogar esta marcado con el parentesco JEFE(A) DEL HOGAR";
            }

            // condicion de cabeza de hogar
            if ($bolJefeHogar == true and $arrVariables['variables']['cantHijos'] > 0 and $arrVariables['variables']['conyugueHogar'] == 0) {
                if ($numCabezaHogar == 1) {
                    $arrVariables['variables']['hombreCabHogar'] ++;
                } else {
                    $arrVariables['variables']['mujerCabHogar'] ++;
                }
            }
        } else {
            $arrVariables['errores'][] = "No hay aplicaciones activas para el numero de documento $numDocumento";
        }

        $seqFormulario = Ciudadano::formularioVinculado($numDocumento);
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario($seqFormulario);

        $numPosicionIntegracion = $this->arrVariablesCalificacion[$seqDiseno]['integracion'];
        $numPosicionEducacion = $this->arrVariablesCalificacion[$seqDiseno]['educacion'];
        $numPosicionMujer = $this->arrVariablesCalificacion[$seqDiseno]['mujer'];
        $numPosicionAltaCon = $this->arrVariablesCalificacion[$seqDiseno]['altacon'];
        $numPosicionSalud = $this->arrVariablesCalificacion[$seqDiseno]['salud'];
        $numPosicionIpes = $this->arrVariablesCalificacion[$seqDiseno]['ipes'];

        // integracion social
        if ($numPosicionIntegracion == 0) {
            $arrVariables['variables']['bolIntegracionSocial'] = $claFormulario->bolIntegracionSocial;
        } else {
            $arrVariables['variables']['bolIntegracionSocial'] = 0;
            foreach ($this->arrAplicacion['ciudadano'] as $numLinea => $arrCiudadano) {
                if (isset($arrCiudadano[$numPosicionIntegracion]) and $arrCiudadano[$numPosicionIntegracion] == 1) {
                    $arrVariables['variables']['bolIntegracionSocial'] = 1;
                }
            }
        }

        // secretaria de educacion
        if ($numPosicionEducacion == 0) {
            $arrVariables['variables']['bolSecEducacion'] = $claFormulario->bolSecEducacion;
        } else {
            $arrVariables['variables']['bolSecEducacion'] = 0;
            foreach ($this->arrAplicacion['ciudadano'] as $numLinea => $arrCiudadano) {
                if (isset($arrCiudadano[$numPosicionEducacion]) and $arrCiudadano[$numPosicionEducacion] == 1) {
                    $arrVariables['variables']['bolSecEducacion'] = 1;
                }
            }
        }

        // secretaria de la mujer
        if ($numPosicionMujer == 0) {
            $arrVariables['variables']['bolSecMujer'] = $claFormulario->bolSecMujer;
        } else {
            $arrVariables['variables']['bolSecMujer'] = 0;
            foreach ($this->arrAplicacion['ciudadano'] as $numLinea => $arrCiudadano) {
                if (isset($arrCiudadano[$numPosicionMujer]) and $arrCiudadano[$numPosicionMujer] == 1) {
                    $arrVariables['variables']['bolSecMujer'] = 1;
                }
            }
        }

        // alta consejeria
        if ($numPosicionAltaCon == 0) {
            $arrVariables['variables']['bolAltaCon'] = $claFormulario->bolAltaCon;
        } else {
            $arrVariables['variables']['bolAltaCon'] = 0;
            foreach ($this->arrAplicacion['ciudadano'] as $numLinea => $arrCiudadano) {
                if (isset($arrCiudadano[$numPosicionAltaCon]) and $arrCiudadano[$numPosicionAltaCon] == 1) {
                    $arrVariables['variables']['bolAltaCon'] = 1;
                }
            }
        }

        // salud
        if ($numPosicionSalud == 0) {
            $arrVariables['variables']['bolSecSalud'] = $claFormulario->bolSeqSalud;
        } else {
            $arrVariables['variables']['bolSecSalud'] = 0;
            foreach ($this->arrAplicacion['ciudadano'] as $numLinea => $arrCiudadano) {
                if (isset($arrCiudadano[$numPosicionSalud]) and $arrCiudadano[$numPosicionSalud] == 1) {
                    $arrVariables['variables']['bolSecSalud'] = 1;
                }
            }
        }

        // ipes
        if ($numPosicionIpes == 0) {
            $arrVariables['variables']['bolIpes'] = $claFormulario->bolIpes;
        } else {
            $arrVariables['variables']['bolIpes'] = 0;
            foreach ($this->arrAplicacion['ciudadano'] as $numLinea => $arrCiudadano) {
                if (isset($arrCiudadano[$numPosicionIpes]) and $arrCiudadano[$numPosicionIpes] == 1) {
                    $arrVariables['variables']['bolIpes'] = 1;
                }
            }
        }

        return $arrVariables;
    }

}

?>
