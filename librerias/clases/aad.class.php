<?php

class aad
{

    public $seqTipoActo;
    public $numActo;
    public $fchActo;
    public $arrCaracteristicas;
    public $arrDetalles;
    public $arrExportable;
    public $arrHogares;
    public $arrErrores;
    public $arrMensajes;
    private $arrCambiosAplicados;
    private $arrEstadosPermitidos;
    private $arrExtensiones;
    private $txtCreador;
    private $minmDatesDiff;
    private $secInDay;

    public function __construct()
    {
        $this->seqTipoActo = 0;
        $this->numActo = 0;
        $this->fchActo = null;
        $this->arrCaracteristicas = array();
        $this->arrDetalles = array();
        $this->arrExportable = array();
        $this->arrHogares = array();
        $this->arrErrores = array();
        $this->arrMensajes = array();
        $this->arrEstadosPermitidos[1][] = 16;
        $this->arrEstadosPermitidos[3][] = 48;
        $this->arrEstadosPermitidos[3][] = 56;
        $this->arrEstadosPermitidos[5][] = 48;
        $this->arrEstadosPermitidos[5][] = 56;
        $this->arrCambiosAplicados = array();
        $this->arrExtensiones = array("txt");
        $this->txtCreador = "SiPIVE - SDHT";

        $this->minmDatesDiff = 25569;
        $this->secInDay = 86400;

    }

    /**
     * LISTA LOS ACTOS ADMINISTRATIVOS
     * CON ALGUNOS FILTROS OPCIONALES
     * @param int $seqTipoActo
     * @param int $numActo
     * @param null $fchActo
     * @param array $arrDocumentos
     * @return array
     */
    public function listarActos($seqTipoActo = 0, $numActo = 0, $fchInicial = null, $fchFinal = null, $arrDocumentos = array())
    {
        global $aptBd;
        $arrListado = array();
        $txtCondicion = ($seqTipoActo == 0) ? "" : " AND hvi.seqTipoActo = " . $seqTipoActo;
        $txtCondicion .= ($numActo == 0) ? "" : " AND hvi.numActo = " . $numActo;
        $txtCondicion .= ($fchInicial == null) ? "" : " AND hvi.fchActo >= '" . $fchInicial . "'";
        $txtCondicion .= ($fchFinal == null) ? "" : " AND hvi.fchActo <= '" . $fchFinal . "'";
        $txtCondicion .= (empty($arrDocumentos)) ? "" : " AND cac.numDocumento IN (" . implode(",", $arrDocumentos) . ")";
        try {
            $sql = "
             select distinct
                hvi.seqTipoActo, 
                hvi.numActo, 
                hvi.fchActo
             from t_aad_ciudadano_acto cac
             inner join t_aad_hogar_acto hac on cac.seqCiudadanoActo = hac.seqCiudadanoActo
             inner join t_aad_formulario_acto fac on hac.seqFormularioActo = fac.seqFormularioActo
             inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
             WHERE 1 = 1 
             $txtCondicion
             ORDER BY 
               hvi.fchActo desc
            ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $seqTipoActo = $objRes->fields['seqTipoActo'];
                $numActo = $objRes->fields['numActo'];
                $fchActo = $objRes->fields['fchActo'];

                $txtClave = $objRes->fields['numActo'] . strtotime($objRes->fields['fchActo']);

                preg_match("/(\d{1})(\d{4})(\d{1,})/", $numActo, $arrMatch);
                if (empty($arrMatch)) {
                    $arrListado[$seqTipoActo]['listado'][$txtClave]['numero'] = $numActo;
                } else {
                    unset($arrMatch[0]);
                    $arrListado[$seqTipoActo]['listado'][$txtClave]['numero'] = implode("-", $arrMatch);
                }

                $arrListado[$seqTipoActo]['listado'][$txtClave]['fecha'] = $fchActo;
                $arrListado[$seqTipoActo]['conteo']++;

                $objRes->MoveNext();
            }
        } catch (Exception  $objError) {
            $this->arrErrores[] = "No se pudo consultar el acto administrativo";
        }
        return $arrListado;
    }

    /**
     * ELIMINA UN ACTO ADMINISTRATIVO
     * SIEMPRE QUE NO TENGA GIROS REALIZADOS
     * @param $seqTipoActo
     * @param $numActo
     * @param $fchActo
     */
    public function eliminar($seqTipoActo, $numActo, $fchActo)
    {
        global $aptBd;

        // determina si el acto administrativo esta siendo
        // referenciado por algun otro acto administrativo
        // ej: un aad de asigancion que tiene modificatorias
        $sql = "
            select count(seqHogarvinculado) as cuenta
            from t_aad_hogares_vinculados
            where numActoReferencia = $numActo
            and fchActoReferencia = '$fchActo'
        ";
        $objRes = $aptBd->execute($sql);
        if (intval($objRes->fields['cuenta']) != 0) {
            $this->arrErrores[] = "No puede eliminar el Acto Administrativo " . $numActo . " del " . $fchActo . " porque existen actos administrativos relacionados";
        }

        // determina si el acto administrativo tiene giros
        // caso en el cual no se podria borrar
        $sql = "
            select sum(gir.valSolicitado) as giros
            from t_aad_hogares_vinculados hvi
            left join t_aad_giro gir on hvi.seqFormularioActo = gir.seqFormularioActo
            where hvi.seqTipoActo = $seqTipoActo
            and hvi.numActo = $numActo
            and hvi.fchActo = '$fchActo'
            group by hvi.numActo, hvi.fchActo
        ";
        $objRes = $aptBd->execute($sql);
        if (doubleval($objRes->fields['giros']) != 0) {
            $this->arrErrores[] = "No puede eliminar el Acto Administrativo " . $numActo . " del " . $fchActo . " porque tiene giros asociados";
        }

        if (empty($this->arrErrores)) {

            // obtiene la informacion de los hogares vinculados
            $sql = "
                select
                    hac.seqFormularioActo,
                    hac.seqCiudadanoActo,
                    hvi.numActoReferencia, 
                    hvi.fchActoReferencia
                from t_aad_hogares_vinculados hvi
                inner join t_aad_hogar_acto hac on hvi.seqFormularioActo = hac.seqFormularioActo
                where hvi.seqTipoActo = $seqTipoActo
                and hvi.numActo = $numActo
                and hvi.fchActo = '$fchActo'            
            ";
            $objRes = $aptBd->execute($sql);
            $arrHogares = array();
            while ($objRes->fields) {

                $seqFormularioActo = $objRes->fields['seqFormularioActo'];
                $seqCiudadanoActo = $objRes->fields['seqCiudadanoActo'];
                $numActoReferencia = $objRes->fields['numActoReferencia'];
                $fchActoReferencia = $objRes->fields['fchActoReferencia'];

                $arrHogares[$seqFormularioActo]['referencia']['numero'] = $numActoReferencia;
                $arrHogares[$seqFormularioActo]['referencia']['fecha'] = $fchActoReferencia;
                $arrHogares[$seqFormularioActo]['ciudadanos'][] = $seqCiudadanoActo;

                $objRes->MoveNext();
            }

            try {

                $aptBd->BeginTrans();

                foreach ($arrHogares as $seqFormularioActo => $arrRegistro) {

                    // elimina la vinculacion al acto administrativo
                    $sql = "
                        delete
                        from t_aad_hogares_vinculados
                        where seqFormularioActo = $seqFormularioActo
                          and numActo = $numActo
                          and fchActo = '$fchActo'
                    ";
                    $aptBd->execute($sql);

                    // si tiene referencia no se borra el formulario
                    if (intval($arrRegistro['referencia']['numero']) == 0) {

                        // elimina los hogares
                        $sql = "
                            delete
                            from t_aad_hogar_acto
                            where seqFormularioActo = $seqFormularioActo
                        ";
                        $aptBd->execute($sql);

                        // elimina los ciudadnos vinculados
                        $sql = "
                            delete
                            from t_aad_ciudadano_acto
                            where seqCiudadanoActo in (" . implode(",", $arrRegistro['ciudadanos']) . ")
                        ";
                        $aptBd->execute($sql);

                        // elimina los formularios
                        $sql = "
                            delete
                            from t_aad_formulario_acto
                            where seqFormularioActo  = $seqFormularioActo
                        ";
                        $aptBd->execute($sql);

                    }

                    // elimina los detalles
                    $sql = "
                        delete 
                        from t_aad_detalles 
                        where seqFormularioActo = $seqFormularioActo
                    ";
                    $aptBd->execute($sql);

                }

                // elimina el acto administrativo
                $sql = "
                    delete
                    from t_aad_acto_administrativo
                    where seqTipoActo =  $seqTipoActo
                      and numActo = $numActo
                      and fchActo = '$fchActo'
                ";
                $aptBd->execute($sql);

                // Registro de las actividades
                $claRegistroActividades = new RegistroActividades();
                $claRegistroActividades->registrarActividad(
                    "Borrado",
                    145,
                    $_SESSION['seqUsuario'],
                    "AAD " . $numActo . " del " . $fchActo
                );

                $aptBd->CommitTrans();

            } catch (Exception $objError) {
                $this->arrErrores[] = "Problemas al eliminar el acto adminsitrativo, no se borró ningpun registro";
                $this->arrErrores[] = $objError->getMessage();
                $aptBd->RollbackTrans();
            }

        }

    }

    /**
     * OBTIENE LA INFORMACION DEL ACTO ADMINISTRATIVO
     * @param $seqTipoActo
     * @param $numActo
     * @param $fchActo
     */
    public function cargarActo($seqTipoActo, $numActo, $fchActo)
    {
        global $aptBd;
        $sql = "
            SELECT 
                aad.seqTipoActo,
                aad.numActo,
                aad.fchActo,
                aad.seqCaracteristica,
                aad.txtValorCaracteristica
            FROM t_aad_acto_administrativo aad
            WHERE aad.seqTipoActo = $seqTipoActo
            AND aad.numActo = $numActo
            AND aad.fchActo = '$fchActo'
        ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $this->seqTipoActo = $objRes->fields['seqTipoActo'];
            preg_match("/(\d{1})(\d{4})(\d{1,})/", $objRes->fields['numActo'], $arrMatch);
            if (!empty($arrMatch)) {
                unset($arrMatch[0]);
                $this->numActo = implode("-", $arrMatch);
            } else {
                $this->numActo = $objRes->fields['numActo'];
            }
            $this->fchActo = new DateTime(trim($objRes->fields['fchActo']));
            $seqCaracteristicas = $objRes->fields['seqCaracteristica'];
            $arrCaracteristicas[$seqCaracteristicas] = trim($objRes->fields['txtValorCaracteristica']);
            $objRes->MoveNext();
        }
        $this->mapeoCaracteristicas($arrCaracteristicas);
        $this->cargarExportable();
        $this->cargarDetalles();
    }

    /**
     * DESDE LAS CARACTERISTICAS DEL AAD EN LA BASE DE DATOS
     * SE MAPEAN CON VARIABLES MAS ENTENDIBLES PARA LA CARGA
     * HACIA LA PLANTILLA HTML
     * @param $arrCaracteristicas
     */
    private function mapeoCaracteristicas($arrCaracteristicas)
    {
        switch ($this->seqTipoActo) {
            case 1: // asignacion
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[1];
                $this->arrCaracteristicas['numCdp'][1] = intval($arrCaracteristicas[9]);
                $this->arrCaracteristicas['valCdp'][1] = doubleval($arrCaracteristicas[10]);
                $this->arrCaracteristicas['fchCdp'][1] = $arrCaracteristicas[11];
                $this->arrCaracteristicas['numVigCdp'][1] = $arrCaracteristicas[12];
                $this->arrCaracteristicas['numRp'][1] = intval($arrCaracteristicas[13]);
                $this->arrCaracteristicas['valRp'][1] = doubleval($arrCaracteristicas[14]);
                $this->arrCaracteristicas['fchRp'][1] = $arrCaracteristicas[15];
                $this->arrCaracteristicas['numVigRp'][1] = $arrCaracteristicas[16];
                $this->arrCaracteristicas['numPry'][1] = intval($arrCaracteristicas[17]);
                $this->arrCaracteristicas['numCdp'][2] = intval($arrCaracteristicas[23]);
                $this->arrCaracteristicas['valCdp'][2] = doubleval($arrCaracteristicas[24]);
                $this->arrCaracteristicas['fchCdp'][2] = $arrCaracteristicas[25];
                $this->arrCaracteristicas['numVigCdp'][2] = $arrCaracteristicas[26];
                $this->arrCaracteristicas['numRp'][2] = intval($arrCaracteristicas[27]);
                $this->arrCaracteristicas['valRp'][2] = doubleval($arrCaracteristicas[28]);
                $this->arrCaracteristicas['fchRp'][2] = $arrCaracteristicas[29];
                $this->arrCaracteristicas['numVigRp'][2] = $arrCaracteristicas[30];
                $this->arrCaracteristicas['numPry'][2] = intval($arrCaracteristicas[142]);
                $this->arrCaracteristicas['numCdp'][3] = intval($arrCaracteristicas[40]);
                $this->arrCaracteristicas['valCdp'][3] = doubleval($arrCaracteristicas[41]);
                $this->arrCaracteristicas['fchCdp'][3] = $arrCaracteristicas[42];
                $this->arrCaracteristicas['numVigCdp'][3] = $arrCaracteristicas[43];
                $this->arrCaracteristicas['numRp'][3] = intval($arrCaracteristicas[44]);
                $this->arrCaracteristicas['valRp'][3] = doubleval($arrCaracteristicas[45]);
                $this->arrCaracteristicas['fchRp'][3] = $arrCaracteristicas[46];
                $this->arrCaracteristicas['numVigRp'][3] = $arrCaracteristicas[47];
                $this->arrCaracteristicas['numPry'][3] = intval($arrCaracteristicas[48]);
                $this->arrCaracteristicas['numCdp'][4] = intval($arrCaracteristicas[51]);
                $this->arrCaracteristicas['valCdp'][4] = doubleval($arrCaracteristicas[52]);
                $this->arrCaracteristicas['fchCdp'][4] = $arrCaracteristicas[53];
                $this->arrCaracteristicas['numVigCdp'][4] = $arrCaracteristicas[54];
                $this->arrCaracteristicas['numRp'][4] = intval($arrCaracteristicas[55]);
                $this->arrCaracteristicas['valRp'][4] = doubleval($arrCaracteristicas[56]);
                $this->arrCaracteristicas['fchRp'][4] = $arrCaracteristicas[57];
                $this->arrCaracteristicas['numVigRp'][4] = $arrCaracteristicas[58];
                $this->arrCaracteristicas['numPry'][4] = intval($arrCaracteristicas[143]);
                $this->arrCaracteristicas['numCdp'][5] = intval($arrCaracteristicas[59]);
                $this->arrCaracteristicas['valCdp'][5] = doubleval($arrCaracteristicas[60]);
                $this->arrCaracteristicas['fchCdp'][5] = $arrCaracteristicas[61];
                $this->arrCaracteristicas['numVigCdp'][5] = $arrCaracteristicas[62];
                $this->arrCaracteristicas['numRp'][5] = intval($arrCaracteristicas[63]);
                $this->arrCaracteristicas['valRp'][5] = doubleval($arrCaracteristicas[64]);
                $this->arrCaracteristicas['fchRp'][5] = $arrCaracteristicas[65];
                $this->arrCaracteristicas['numVigRp'][5] = $arrCaracteristicas[66];
                $this->arrCaracteristicas['numPry'][5] = intval($arrCaracteristicas[144]);
                $this->arrCaracteristicas['numCdp'][6] = intval($arrCaracteristicas[67]);
                $this->arrCaracteristicas['valCdp'][6] = doubleval($arrCaracteristicas[68]);
                $this->arrCaracteristicas['fchCdp'][6] = $arrCaracteristicas[69];
                $this->arrCaracteristicas['numVigCdp'][6] = $arrCaracteristicas[70];
                $this->arrCaracteristicas['numRp'][6] = intval($arrCaracteristicas[71]);
                $this->arrCaracteristicas['valRp'][6] = doubleval($arrCaracteristicas[72]);
                $this->arrCaracteristicas['fchRp'][6] = $arrCaracteristicas[73];
                $this->arrCaracteristicas['numVigRp'][6] = $arrCaracteristicas[74];
                $this->arrCaracteristicas['numPry'][6] = intval($arrCaracteristicas[145]);
                $this->arrCaracteristicas['numCdp'][7] = intval($arrCaracteristicas[75]);
                $this->arrCaracteristicas['valCdp'][7] = doubleval($arrCaracteristicas[76]);
                $this->arrCaracteristicas['fchCdp'][7] = $arrCaracteristicas[77];
                $this->arrCaracteristicas['numVigCdp'][7] = $arrCaracteristicas[78];
                $this->arrCaracteristicas['numRp'][7] = intval($arrCaracteristicas[79]);
                $this->arrCaracteristicas['valRp'][7] = doubleval($arrCaracteristicas[80]);
                $this->arrCaracteristicas['fchRp'][7] = $arrCaracteristicas[81];
                $this->arrCaracteristicas['numVigRp'][7] = $arrCaracteristicas[82];
                $this->arrCaracteristicas['numPry'][7] = intval($arrCaracteristicas[146]);
                $this->arrCaracteristicas['numCdp'][8] = intval($arrCaracteristicas[83]);
                $this->arrCaracteristicas['valCdp'][8] = doubleval($arrCaracteristicas[84]);
                $this->arrCaracteristicas['fchCdp'][8] = $arrCaracteristicas[85];
                $this->arrCaracteristicas['numVigCdp'][8] = $arrCaracteristicas[86];
                $this->arrCaracteristicas['numRp'][8] = intval($arrCaracteristicas[87]);
                $this->arrCaracteristicas['valRp'][8] = doubleval($arrCaracteristicas[88]);
                $this->arrCaracteristicas['fchRp'][8] = $arrCaracteristicas[89];
                $this->arrCaracteristicas['numVigRp'][8] = $arrCaracteristicas[90];
                $this->arrCaracteristicas['numPry'][8] = intval($arrCaracteristicas[147]);
                $this->arrCaracteristicas['numCdp'][9] = intval($arrCaracteristicas[100]);
                $this->arrCaracteristicas['valCdp'][9] = doubleval($arrCaracteristicas[101]);
                $this->arrCaracteristicas['fchCdp'][9] = $arrCaracteristicas[102];
                $this->arrCaracteristicas['numVigCdp'][9] = $arrCaracteristicas[103];
                $this->arrCaracteristicas['numRp'][9] = intval($arrCaracteristicas[104]);
                $this->arrCaracteristicas['valRp'][9] = doubleval($arrCaracteristicas[105]);
                $this->arrCaracteristicas['fchRp'][9] = $arrCaracteristicas[106];
                $this->arrCaracteristicas['numVigRp'][9] = $arrCaracteristicas[107];
                $this->arrCaracteristicas['numPry'][9] = intval($arrCaracteristicas[148]);
                $this->arrCaracteristicas['numCdp'][10] = intval($arrCaracteristicas[108]);
                $this->arrCaracteristicas['valCdp'][10] = doubleval($arrCaracteristicas[109]);
                $this->arrCaracteristicas['fchCdp'][10] = $arrCaracteristicas[110];
                $this->arrCaracteristicas['numVigCdp'][10] = $arrCaracteristicas[111];
                $this->arrCaracteristicas['numRp'][10] = intval($arrCaracteristicas[112]);
                $this->arrCaracteristicas['valRp'][10] = doubleval($arrCaracteristicas[113]);
                $this->arrCaracteristicas['fchRp'][10] = $arrCaracteristicas[114];
                $this->arrCaracteristicas['numVigRp'][10] = $arrCaracteristicas[115];
                $this->arrCaracteristicas['numPry'][10] = intval($arrCaracteristicas[149]);
                $this->arrCaracteristicas['numCdp'][11] = intval($arrCaracteristicas[116]);
                $this->arrCaracteristicas['valCdp'][11] = doubleval($arrCaracteristicas[117]);
                $this->arrCaracteristicas['fchCdp'][11] = $arrCaracteristicas[118];
                $this->arrCaracteristicas['numVigCdp'][11] = $arrCaracteristicas[119];
                $this->arrCaracteristicas['numRp'][11] = intval($arrCaracteristicas[120]);
                $this->arrCaracteristicas['valRp'][11] = doubleval($arrCaracteristicas[121]);
                $this->arrCaracteristicas['fchRp'][11] = $arrCaracteristicas[122];
                $this->arrCaracteristicas['numVigRp'][11] = $arrCaracteristicas[123];
                $this->arrCaracteristicas['numPry'][11] = intval($arrCaracteristicas[150]);
                $this->arrCaracteristicas['numCdp'][12] = intval($arrCaracteristicas[124]);
                $this->arrCaracteristicas['valCdp'][12] = doubleval($arrCaracteristicas[125]);
                $this->arrCaracteristicas['fchCdp'][12] = $arrCaracteristicas[126];
                $this->arrCaracteristicas['numVigCdp'][12] = $arrCaracteristicas[127];
                $this->arrCaracteristicas['numRp'][12] = intval($arrCaracteristicas[128]);
                $this->arrCaracteristicas['valRp'][12] = doubleval($arrCaracteristicas[129]);
                $this->arrCaracteristicas['fchRp'][12] = $arrCaracteristicas[130];
                $this->arrCaracteristicas['numVigRp'][12] = $arrCaracteristicas[131];
                $this->arrCaracteristicas['numPry'][12] = intval($arrCaracteristicas[151]);
                $this->arrCaracteristicas['numCdp'][13] = intval($arrCaracteristicas[132]);
                $this->arrCaracteristicas['valCdp'][13] = doubleval($arrCaracteristicas[133]);
                $this->arrCaracteristicas['fchCdp'][13] = $arrCaracteristicas[134];
                $this->arrCaracteristicas['numVigCdp'][13] = $arrCaracteristicas[135];
                $this->arrCaracteristicas['numRp'][13] = intval($arrCaracteristicas[136]);
                $this->arrCaracteristicas['valRp'][13] = doubleval($arrCaracteristicas[137]);
                $this->arrCaracteristicas['fchRp'][13] = $arrCaracteristicas[138];
                $this->arrCaracteristicas['numVigRp'][13] = $arrCaracteristicas[139];
                $this->arrCaracteristicas['numPry'][13] = intval($arrCaracteristicas[152]);
                break;
            case 2: // modificatorias
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[2];
                break;
            case 3: // inhabilitados
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[3];
                break;
            case 4: // reposicion
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[161];
                $this->arrCaracteristicas['numActoRelacionado'] = intval($arrCaracteristicas[5]);
                $this->arrCaracteristicas['fchActoRelacionado'] = $arrCaracteristicas[6];
                break;
            case 5: // no asignado
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[8];
                break;
            case 6: // renuncia
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[153];
                break;
            case 7: // notificaciones
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[39];
                break;
            case 8: // indexaciones
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[31];
                $this->arrCaracteristicas['numCdp'][1] = intval($arrCaracteristicas[32]);
                $this->arrCaracteristicas['valCdp'][1] = doubleval($arrCaracteristicas[33]);
                $this->arrCaracteristicas['fchCdp'][1] = $arrCaracteristicas[34];
                $this->arrCaracteristicas['numVigCdp'][1] = $arrCaracteristicas[155];
                $this->arrCaracteristicas['numRp'][1] = intval($arrCaracteristicas[35]);
                $this->arrCaracteristicas['valRp'][1] = doubleval($arrCaracteristicas[36]);
                $this->arrCaracteristicas['fchRp'][1] = $arrCaracteristicas[37];
                $this->arrCaracteristicas['numVigRp'][1] = $arrCaracteristicas[156];
                $this->arrCaracteristicas['numPry'][1] = intval($arrCaracteristicas[38]);
                $this->arrCaracteristicas['numCdp'][2] = intval($arrCaracteristicas[93]);
                $this->arrCaracteristicas['valCdp'][2] = doubleval($arrCaracteristicas[94]);
                $this->arrCaracteristicas['fchCdp'][2] = $arrCaracteristicas[95];
                $this->arrCaracteristicas['numVigCdp'][2] = $arrCaracteristicas[157];
                $this->arrCaracteristicas['numRp'][2] = intval($arrCaracteristicas[96]);
                $this->arrCaracteristicas['valRp'][2] = doubleval($arrCaracteristicas[97]);
                $this->arrCaracteristicas['fchRp'][2] = $arrCaracteristicas[98];
                $this->arrCaracteristicas['numVigRp'][2] = $arrCaracteristicas[158];
                $this->arrCaracteristicas['numPry'][2] = intval($arrCaracteristicas[159]);
                break;
            case 9: // perdida
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[99];
                break;
            case 10: // revocatoria
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[160];
                break;
            case 11: // exclusion
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[161];
                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                break;
        }
    }

    /**
     * OBTIENE LA INFORMACION DEL EXPORTABLE
     * DEL ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     */
    private function cargarExportable()
    {
        global $aptBd;
        $sql = "";
        switch ($this->seqTipoActo) {
            case 1: // asignacion
                $sql = "
                   SELECT 
                        fac.seqFormularioActo as 'Formulario Acto',
                        hvi.numActoReferencia as 'Acto Referencia', 
                        hvi.fchActoReferencia as 'Fecha Referencia',
                        gir.seqGiro as 'Giro',
                        CONCAT( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) AS 'Estado',
                        IF(fac.bolDesplazado = 0,'NO','SI') as 'Desplazado',
                        fac.valAspiraSubsidio as 'Aspira Subsidio',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        gir.numProyectoInversion as 'Proyecto Inversion',
                        gir.fchCreacion as 'Fecha Creacion',
                        gir.fchActualizacion as 'Fecha Actualizacion',
                        gir.numRegistroPresupuestal1 as 'RP 1',
                        gir.fchRegistroPresupuestal1 as 'Fecha RP 1',
                        gir.numRegistroPresupuestal2 as 'RP 2',
                        gir.fchRegistroPresupuestal2 as 'Fecha RP 2',
                        gir.numRadiacion as 'Radicado',
                        gir.fchRadicacion as 'Fecha Radicado',
                        gir.valSolicitado as 'Valor Solicitado',
                        gir.numOrden as 'Orden',
                        gir.fchOrden as 'Fecha Orden',
                        gir.valOrden as 'Valor Orden',
                        gir.txtNombreBeneficiarioGiro as 'Beneficiario',
                        gir.numDocumentoBeneficiarioGiro as 'Documento Beneficiario',
                        gir.txtDireccionBeneficiarioGiro as 'Direccion Beneficiario',
                        gir.numTelefonoGiro as 'Telefono Beneficiario',
                        gir.numCuentaGiro as 'Cuenta Beneficiario',
                        UCWORDS( gir.txtTipoCuentaGiro ) AS 'Tipo Cuenta Beneficiario',
                        UCWORDS( ban.txtBanco ) AS 'Banco Beneficiario',
                        IF(gir.bolGiroTercero=0,'NO','SI') as 'Giro Terceros',
                        gir.txtGiroTercero as 'Tercero',
                        gir.txtCorreoGiro as 'Correo Tercero'
                   FROM T_AAD_HOGARES_VINCULADOS hvi
                   INNER JOIN T_AAD_FORMULARIO_ACTO fac ON fac.seqFormularioActo = hvi.seqFormularioActo
                   INNER JOIN T_AAD_HOGAR_ACTO hac ON fac.seqFormularioActo = hac.seqFormularioActo
                   INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                   LEFT JOIN T_FRM_FORMULARIO frm ON fac.seqFormulario = frm.seqFormulario
                   LEFT JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
                   LEFT JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
                   LEFT JOIN T_AAD_GIRO gir ON gir.seqFormularioActo = fac.seqFormularioActo
                   LEFT JOIN T_FRM_BANCO ban ON gir.seqBancoGiro = ban.seqBanco
                   WHERE hac.seqParentesco = 1
                     AND hvi.numActo = " . $this->numActo . "
                     AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                   ORDER BY cac.numDocumento
                ";
                break;
            case 2: // modificatorias
                $sql = "
                    SELECT
                        hac.seqHogarActo as 'Hogar Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        par.txtParentesco as 'Parentesco',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        fac.valAspiraSubsidio as 'Valor Subsidio',
                        det.txtCampo as 'Campo',
                        det.txtIncorrecto as 'Incorrecto',
                        det.txtCorrecto as 'Correcto',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    LEFT JOIN T_AAD_DETALLES det ON hac.seqFormularioActo = det.seqFormularioActo 
                                                AND hac.seqCiudadanoActo = det.seqCiudadanoActo 
                                                AND hvi.numActo = det.numActo 
                                                AND hvi.fchActo = det.fchActo
                    INNER JOIN v_frm_estado EST ON fac.seqEstadoProceso = est.seqEstadoProceso
                    INNER JOIN t_ciu_parentesco par ON hac.seqParentesco = par.seqParentesco
                    WHERE hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 3: // inhabilitados
                $sql = "
                    SELECT
                        fac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        par.txtParentesco as 'Parentesco',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        det.txtFuente as 'Fuente',
                        det.txtCausa as 'Causa',
                        det.txtInhabilidad as 'Inhabilidad'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN t_ciu_parentesco par on hac.seqParentesco = par.seqParentesco
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    LEFT JOIN T_AAD_DETALLES det ON hac.seqFormularioActo = det.seqFormularioActo 
                                                AND hac.seqCiudadanoActo = det.seqCiudadanoActo
                                                AND hvi.numActo = det.numActo 
                                                AND hvi.fchActo = det.fchActo
                    INNER JOIN V_FRM_ESTADO est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hvi.numActo = " . $this->numActo . "
                      AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 4: // reposicion
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario ACto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia',
                        det.txtEstadoReposicion as 'Resultado'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    LEFT JOIN T_AAD_DETALLES det ON hac.seqFormularioActo = det.seqFormularioActo 
                                                AND hac.seqCiudadanoActo = det.seqCiudadanoActo
                                                AND hvi.numActo = det.numActo 
                                                AND hvi.fchActo = det.fchActo
                    INNER JOIN V_FRM_ESTADO est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 5: // no asignado
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    INNER JOIN v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 6: // renuncia
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    INNER JOIN v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 7: // notificaciones
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    INNER JOIN v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 8: // indexaciones
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto', 
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia',
                        det.valIndexacion as 'Indexacion',
                        fac.valAspiraSubsidio as 'Aspira Subsidio'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    INNER JOIN v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
                    LEFT JOIN T_AAD_DETALLES det ON hac.seqFormularioActo = det.seqFormularioActo 
                                                AND hac.seqCiudadanoActo = det.seqCiudadanoActo 
                                                AND hvi.numActo = det.numActo 
                                                AND hvi.fchActo = det.fchActo 
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 9: // perdida
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia',
                        fac.valAspiraSubsidio as 'Aspira Subsidio'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    INNER JOIN v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 10: // revocatoria
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento', 
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia',
                        fac.valAspiraSubsidio as 'Aspira Subsidio'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    INNER JOIN v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 11: // exclusion
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        upper(concat(
                        if(cac.txtNombre1 is null or rtrim(ltrim(cac.txtNombre1)) = '','',rtrim(ltrim(cac.txtNombre1))),
                        ' ',
                        if(cac.txtNombre2 is null or rtrim(ltrim(cac.txtNombre2)) = '','',rtrim(ltrim(cac.txtNombre2))),
                        ' ',
                        if(cac.txtApellido1 is null or rtrim(ltrim(cac.txtApellido1)) = '','',rtrim(ltrim(cac.txtApellido1))),
                        ' ',
                        if(cac.txtApellido2 is null or rtrim(ltrim(cac.txtApellido2)) = '','',rtrim(ltrim(cac.txtApellido2)))
                        )) as 'Nombre',
                        if(fac.bolDesplazado = 1,'SI','NO') as 'Desplazado',
                        est.txtEstado as 'Estado',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia',
                        fac.valAspiraSubsidio as 'Aspira Subsidio'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    INNER JOIN v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo->format("Y-m-d") . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                break;
        }
        if ($sql != "") {
            try {
                $this->arrExportable = $aptBd->GetAll($sql);
            } catch (Exception $objError) {
                $this->arrErrores[] = "No se pudo consultar los datos para el exportable";
            }
        }
    }

    /**
     * TOMA LA INFORMACION DEL EXPORTABLE
     * Y LA RESUME PARA MOSTRARLA EN LA
     * PESTAÑA DE DETALLES DE LA PANTALLA
     * SE DEBE CARGAR EL ACTO ADMINISTRATIVO
     * PREVIAMENTE
     */
    private function cargarDetalles()
    {
        if (!empty($this->arrExportable)) {
            switch ($this->seqTipoActo) {
                case 1: // asignacion
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSubsidio'] = $arrLinea['Aspira Subsidio'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSolicitudes'] += doubleval($arrLinea['Valor Solicitado']);
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valOrdenes'] += doubleval($arrLinea['Valor Orden']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                        $this->arrDetalles['resumen']['Cantidad Solicitudes'] = (isset($this->arrDetalles['resumen']['Cantidad Solicitudes'])) ? $this->arrDetalles['resumen']['Cantidad Solicitudes'] : 0;
                        if (doubleval($arrLinea['Valor Solicitado']) != 0) {
                            $this->arrDetalles['resumen']['Cantidad Solicitudes']++;
                        }
                        $this->arrDetalles['resumen']['Valor Solicitudes'] += doubleval($arrLinea['Valor Solicitado']);
                        $this->arrDetalles['resumen']['Cantidad Ordenes'] = (isset($this->arrDetalles['resumen']['Cantidad Ordenes'])) ? $this->arrDetalles['resumen']['Cantidad Ordenes'] : 0;
                        if (doubleval($arrLinea['Valor Orden']) != 0) {
                            $this->arrDetalles['resumen']['Cantidad Ordenes']++;
                        }
                        $this->arrDetalles['resumen']['Valor Ordenes'] += doubleval($arrLinea['Valor Orden']);
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                    }
                    break;
                case 2: // modificatorias
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        if (strpos(mb_strtolower($arrLinea['Parentesco']), "principal") !== false) {
                            $seqHogarActo = $arrLinea['Hogar Acto'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['numDocumento'] = $arrLinea['Documento'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['txtNombre'] = $arrLinea['Nombre'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['valSubsidio'] = $arrLinea['Valor Subsidio'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                            $this->arrDetalles['detalle'][$seqHogarActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                            $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                        }
                    }
                    break;
                case 3: // inhabilitados
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        if (strpos(mb_strtolower($arrLinea['Parentesco']), "principal") !== false) {
                            $seqFormularioActo = $arrLinea['Formulario Acto'];
                            $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                            $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                            $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                            $this->arrDetalles['detalle'][$seqFormularioActo]['txtParentesco'] = $arrLinea['Parentesco'];
                            $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                            $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                            $this->arrDetalles['detalle'][$seqFormularioActo]['valSubsidio'] = 0;
                            $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = null;
                            $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = null;
                            $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                        }
                    }
                    break;
                case 4: // reposicion
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 5: // no asignado
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 6: // renuncia
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 7: // notificaciones
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 8: // indexaciones
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valIndexacion'] = $arrLinea['Indexacion'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSubsidio'] = $arrLinea['Aspira Subsidio'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 9: // perdida
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSubsidio'] = $arrLinea['Aspira Subsidio'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 10: // revocatoria
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSubsidio'] = $arrLinea['Aspira Subsidio'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 11: // exclusion
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSubsidio'] = $arrLinea['Aspira Subsidio'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = new DateTime($arrLinea['Fecha Referencia']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                default:
                    $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                    break;
            }


        } else {
            $this->arrErrores[] = "No se puede procesar la tabla de detalles";
        }
    }

    /**
     * OBTIENE LA CONFIRMACION DE UN HOGAR
     * O DE LOS HOGARES RELACIONADOS EN EL
     * ACTO ADMINISTRATIVO CARGADO PREVIAMENTE
     * @param int $numDocumento
     */
    public function obtenerHogares($numDocumento = 0)
    {
        global $aptBd;
        try {
            if (intval($numDocumento) != 0) {
                $seqFormularioActo = $this->obtenerSecuencial($this->numActo, $this->fchActo->format('Y-m-d'), $numDocumento);
                $txtCondicion = "AND fac.seqFormularioActo = " . $seqFormularioActo;
            }
            $sql = "
                SELECT 
                   fac.seqFormularioActo as 'Formulario Acto',
                   moa.txtModalidad as 'Modalidad',
                   sol.txtSolucion as 'Solucion',
                   IF(fac.bolDesplazado <> 0, 'Si', 'No') as 'Desplazado',
                   fac.valAspiraSubsidio as 'Aspira Subsidio',
                   fac.txtMatriculaInmobiliaria as 'Matricula Inmobiliaria',
                   tdo.txtTipoDocumento as 'Tipo Documento',
                   cac.numDocumento as 'Documento',
                   UPPER(CONCAT(TRIM(cac.txtNombre1), ' ', IF(TRIM(cac.txtNombre2) = '', '', CONCAT(cac.txtNombre2, ' ')),TRIM(cac.txtApellido1), ' ', TRIM(cac.txtApellido2))) AS 'Nombre',
                   par.txtParentesco as 'Parenesco',
                   etn.txtEtnia as 'Etnia',
                   ces1.txtCondicionEspecial AS 'Condicion Especial 1',
                   ces2.txtCondicionEspecial AS 'Condicion Especial 2',
                   ces3.txtCondicionEspecial AS 'Condicion Especial 3',
                   sex.txtSexo as 'Sexo',
                   eci.txtEstadoCivil as 'Estado Civil',
                   cac.valIngresos as 'Ingresos Hogar',
                   cac.fchNacimiento as 'Fecha Nacimiento',
                   glg.txtGrupoLgtbi as 'Grupo LGTBI',
                   tvi.txtTipoVictima as 'Tipo Victima'
                FROM T_AAD_HOGARES_VINCULADOS hvi
                INNER JOIN T_AAD_FORMULARIO_ACTO fac ON fac.seqFormularioActo = hvi.seqFormularioActo
                INNER JOIN T_AAD_HOGAR_ACTO hac ON fac.seqFormularioActo = hac.seqFormularioActo
                INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                INNER JOIN T_FRM_MODALIDAD moa ON fac.seqModalidad = moa.seqModalidad
                INNER JOIN T_FRM_SOLUCION sol ON fac.seqSolucion = sol.seqSolucion AND fac.seqModalidad = moa.seqModalidad
                INNER JOIN T_CIU_PARENTESCO par ON hac.seqParentesco = par.seqParentesco
                INNER JOIN T_CIU_ETNIA etn ON cac.seqEtnia = etn.seqEtnia
                INNER JOIN T_CIU_CONDICION_ESPECIAL ces1 ON cac.seqCondicionEspecial  = ces1.seqCondicionEspecial
                INNER JOIN T_CIU_CONDICION_ESPECIAL ces2 ON cac.seqCondicionEspecial2 = ces2.seqCondicionEspecial
                INNER JOIN T_CIU_CONDICION_ESPECIAL ces3 ON cac.seqCondicionEspecial3 = ces3.seqCondicionEspecial
                INNER JOIN T_CIU_SEXO sex ON cac.seqSexo = sex.seqSexo
                INNER JOIN T_CIU_ESTADO_CIVIL eci ON cac.seqEstadoCivil = eci.seqEstadoCivil
                LEFT JOIN T_FRM_GRUPO_LGTBI glg ON cac.seqGrupoLgtbi = glg.seqGrupoLgtbi
                LEFT JOIN T_FRM_TIPOVICTIMA tvi ON cac.seqTipoVictima = tvi.seqTipoVictima
                WHERE hvi.numActo = " . $this->numActo . "
                AND hvi.fchActo = '" . $this->fchActo->format('Y-m-d') . "'
                $txtCondicion
                ORDER BY fac.seqFormularioActo
            ";
            $this->arrHogares = $aptBd->GetAll($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo obtener el listado de hogares asociados a la resolucion " . $this->numActo . " del " . $this->fchActo->format('Y-m-d');
        }
    }

    /**
     * OBTIENE EL SECUENCIAL DEL FORMULARIO
     * EN EL MODULO DE ACTOS ADMINISTRATIVOS
     * QUE CORRESPONDE A UN ACTO ADMINISTRATIVO
     * @param $numActo
     * @param $fchActo
     * @param $seqFormulario
     * @return int
     */
    private function obtenerSecuencial($numActo, $fchActo, $seqFormulario)
    {
        global $aptBd;
        try {
            $sql = "
                   SELECT 
                      hvi.seqFormularioActo
                   FROM T_AAD_HOGARES_VINCULADOS hvi
                   INNER JOIN T_AAD_FORMULARIO_ACTO FAC ON hvi.seqFormularioActo = fac.seqFormularioActo
                   INNER JOIN T_AAD_HOGAR_ACTO HAC ON fac.seqFormularioActo = hac.seqFormularioActo
                   INNER JOIN T_AAD_CIUDADANO_ACTO CAC ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                   WHERE fac.seqFormulario = $seqFormulario
                   AND hvi.numActo = $numActo
                   AND hvi.fchActo = '$fchActo'
                ";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqFormularioActo = $objRes->fields['seqFormularioActo'];
            } else {
                $seqFormularioActo = 0;
            }
        } catch (Exception $objError) {
            $seqFormularioActo = 0;
        }
        return $seqFormularioActo;
    }

    /**
     * SALVAR LOS ACTOS ADMINISTRATIVOS
     * @param $arrPost
     * @param $arrArchivo
     */
    public function salvar($arrPost, $arrArchivo)
    {
        global $aptBd;

        // quita la fila de titulos
        unset($arrArchivo[0]);

        // validacion de reglas de negocio
        $this->validarReglas($arrPost, $arrArchivo);

        // si no hay errores
        if (empty($this->arrErrores)) {

            // traduccion de las variables post a identificadores de base de datos
            $this->mapeoInversoCaracteristicas($arrPost['seqTipoActo']);

            try {

                $aptBd->BeginTrans();

                // salva el acto administrativo
                $this->salvarActoAdministrativo($arrPost);

                // aplica los efectos del acto adminsitrativo
                // como cambios de estado, indexacion de subsidios, etc
                $this->aplicarEfectos($arrPost, $arrArchivo);

                // copiar el hogar
                $this->vincularHogres($arrPost, $arrArchivo);

                // Inserta el seguimiento
                $claSeguimiento = new Seguimiento();
                $claSeguimiento->actosAdministrativos($arrPost['seqTipoActo'], $arrPost['numActo'], $arrPost['fchActo'], $this->arrCambiosAplicados);

                // Inserta el registro de actividades
                $claRegistroActividades = new RegistroActividades();
                $this->arrErrores = $claRegistroActividades->registrarActividad(
                    "Creacion",
                    145,
                    $_SESSION['seqUsuario'],
                    "AAD " . $arrPost['numActo'] . " del " . $arrPost['fchActo']
                );

                // mensaje de satisfaccion
                $arrTipoActo = aadTipo::cargarTipoActo($arrPost['seqTipoActo']);
                $seqTipoActo = $arrPost['seqTipoActo'];
                $this->arrMensajes[] =
                    "Salvado el acto administrativo de " . $arrTipoActo[$seqTipoActo]->txtTipoActo .
                    " número " . $arrPost['numActo'] .
                    " del " . $arrPost['fchActo'];

                if (!empty($this->arrErrores)) {
                    throw new Exception($this->arrErrores[0]);
                }

                $aptBd->CommitTrans();
//                $aptBd->RollbackTrans();

            } catch (Exception $objError) {
                $aptBd->RollbackTrans();
                $this->arrErrores[] = "No se han podido salvar los datos del acto administrativo";
                $this->arrErrores[] = $objError->getMessage();
            }

        }

    }

    /**
     * ENRUTADOR PARA LAS VALIDACIONES DE LAS
     * REGLAS DE NEGOCIO, UNA VEZ VALIDADOS
     * LOS TITULOS Y LOS DATOS DEL ARCHIVO
     * @param $seqTipoActo
     * @param $arrArchivo
     */
    private function validarReglas($arrPost, $arrArchivo)
    {

        switch ($arrPost['seqTipoActo']) {
            case 1: // asignacion
                $this->validarReglasAsignacion($arrPost, $arrArchivo);
                break;
            case 2: // modificatorias
                $this->validarReglasModificatoria($arrPost, $arrArchivo);
                break;
            case 3: // inhabilitados
                $this->validarReglasInhabilitados($arrPost, $arrArchivo);
                break;
            case 4: // reposicion
                $this->validarReglasReposicion($arrPost, $arrArchivo);
                break;
            case 5: // no asignado
                $this->validarReglasNoAsignados($arrPost, $arrArchivo);
                break;
            case 6: // renuncia
                $this->validarReglasRenuncia($arrArchivo);
                break;
            case 7: // notificaciones
                $this->validarReglasNotificacion($arrPost, $arrArchivo);
                break;
            case 8: // indexaciones
                $this->validarReglasIndexacion($arrPost, $arrArchivo);
                break;
            case 9: // perdida
                $this->validarReglasPerdida($arrPost, $arrArchivo);
                break;
            case 10: // revocatoria
                $this->validarReglasPerdida($arrPost, $arrArchivo);
                break;
            case 11: // exclusion
                $this->validarReglasExclusion($arrPost, $arrArchivo);
                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                break;
        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS DE
     * NEGOCIO PARA LAS RESOLUCIONES DE TIPO ASIGNACION
     * @param $seqTipoActo
     * @param $arrArchivo
     */
    private function validarReglasAsignacion($arrPost, $arrArchivo)
    {

        $seqTipoActo = $arrPost['seqTipoActo'];
        $arrEstados = estadosProceso();
        $claCiudadano = new Ciudadano(); // se usa para la validacion de la existencia del documento

        foreach ($arrArchivo as $numLinea => $arrRegistro) {

            // si existe el documento
            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

            // si el estado del proceso corresponde
            $seqEstadoProceso = array_shift(
                obtenerDatosTabla(
                    "T_FRM_FORMULARIO",
                    array("seqFormulario", "seqEstadoProceso"),
                    "seqFormulario",
                    "seqFormulario = " . $seqFormulario
                )
            );
            if (!in_array($seqEstadoProceso, $this->arrEstadosPermitidos[$seqTipoActo])) {
                $this->arrErrores[] =
                    "Error linea " . ($numLinea + 1) . ": El hogar del ciudadano " . $arrRegistro[0] . " esta en estado " .
                    $arrEstados[$seqEstadoProceso] . " y no es permitido para asociar a una resolución de asignación";
            }

            // fecha de vigencia del subsidio
            // el formato esta peviamente validado en $claTipoActo->validarDatos
            if ($arrRegistro[2] == "" and $arrRegistro[3] == "") {
                if ($arrRegistro[1] == "") {
//                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": Debe indicar la fecha de vigencia del subsidio";
                }
            } else {
                if ($arrRegistro[1] != "") {
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": No debe indicar la fecha de vigencia cuando hay una resolución de referrencia";
                }
            }

            // Si tiene resolucion asociada
            // se revisa que el hogar este relacionado
            // con esta resolucion
            switch (true) {
                case $arrRegistro[2] != "" and $arrRegistro[3] != "":
                    $arrListado = $this->listarActos(1, $arrRegistro[2], $arrRegistro[3], $arrRegistro[3], array($arrRegistro[0]));
                    if (empty($arrListado)) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El documento " . $arrRegistro[0] . " no pertenece a la resolución " . $arrRegistro[2] . " del " . $arrRegistro[3] . " o dicha resolución no es de asignación";
                    }
                    break;
                case $arrRegistro[2] == "" and $arrRegistro[3] != "":
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro tiene fecha pero no numero de resolución";
                    break;
                case $arrRegistro[2] != "" and $arrRegistro[3] == "":
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro tiene número pero no fecha de resolución";
                    break;
            }

        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS DE
     * NEGOCIO PARA LAS RESOLUCIONES DE TIPO MODIFICATORIA
     * @param $seqTipoActo
     * @param $arrArchivo
     */

    private function validarReglasModificatoria($arrPost, $arrArchivo)
    {
        global $arrConfiguracion;

        $claCiudadano = new Ciudadano(); // se usa para la validacion de la existencia del documento

        $arrValidacionCombinada = array();

        foreach ($arrArchivo as $numLinea => $arrRegistro) {

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[4],$arrRegistro[5]);

            if($seqFormularioActo == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No está relacionado con el acto administrativo " . $arrRegistro[4] . " de " . $arrRegistro[5];
            }

            // si existe el documento
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                    break;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

            // para hacer validaciones combinadas despues de recorrer todas las modificaciones
            if (!isset($arrValidacionCombinada[$seqFormulario])) {
                $arrValidacionCombinada[$seqFormulario] = $claFormulario;
                $arrValidacionCombinada[$seqFormulario]->numDocumentoPrincipal = $objCiudadano->numDocumento;
            }

            // depende del campo a modificar aplican las reglas de negocio
            // valida que el campo incorrecto coincida con la base de datos
            $bolError = false;
            switch ($arrRegistro[1]) {
                case "Primer Nombre":
                    if (mb_strtolower($arrRegistro[2]) != mb_strtolower($objCiudadano->txtNombre1)) {
                        $bolError = true;
                    }
                    break;
                case "Segundo Nombre":
                    if (mb_strtolower($arrRegistro[2]) != mb_strtolower($objCiudadano->txtNombre2)) {
                        $bolError = true;
                    }
                    break;
                case "Primer Apellido":
                    if (mb_strtolower($arrRegistro[2]) != mb_strtolower($objCiudadano->txtApellido1)) {
                        $bolError = true;
                    }
                    break;
                case "Segundo Apellido":
                    if (mb_strtolower($arrRegistro[2]) != mb_strtolower($objCiudadano->txtApellido2)) {
                        $bolError = true;
                    }
                    break;
                case "Documento":
                    if (mb_strtolower($arrRegistro[2]) != mb_strtolower($objCiudadano->numDocumento)) {
                        $bolError = true;
                    }
                    break;
                case "Tipo de Solucion":
                    $arrSolucion = obtenerDatosTabla(
                        "t_frm_solucion",
                        array("seqSolucion", "txtSolucion"),
                        "seqSolucion",
                        "seqModalidad = " . $claFormulario->seqModalidad . " and lower(ltrim(rtrim(txtSolucion))) like '" . $arrRegistro[2] . "'"
                    );
                    if (empty($arrSolucion)) {
                        $bolError = true;
                    }
                    break;
                case "Valor del Subsidio":
                    if (doubleval($arrRegistro[2]) != doubleval($claFormulario->valAspiraSubsidio)) {
                        $bolError = true;
                    }
                    // si esta relacionado con una unidad no se puede modificar el valor del subsidio
                    if (intval($claFormulario->seqUnidadProyecto) > 1) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no puede cambiar el valor del subsidio si el hogar esta relacionado con unidades";
                    }
                    break;
                case "Valor Complementario":
                    if (
                        ($claFormulario->seqModalidad == 6 && $claFormulario->seqTipoEsquema == 7) ||
                        ($claFormulario->seqModalidad == 6 && $claFormulario->seqTipoEsquema == 13) ||
                        ($claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 14) ||
                        ($claFormulario->seqModalidad == 12 && $claFormulario->seqTipoEsquema == 15)
                    ) {
                        if (doubleval($arrRegistro[2]) != doubleval($claFormulario->valComplementario)) {
                            $bolError = true;
                        }
                    } else {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " el campo '" . $arrRegistro[1] . "' no se puede modificar porque el hogar no pertenece a la modalidad y esquema correspondiente";
                    }
                    break;
                case "Matricula Inmobiliaria":
                    if (intval($claFormulario->seqModalidad) == 12 or intval($claFormulario->seqModalidad) == 13 or intval($claFormulario->seqModalidad) == 6) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " el campo '" . $arrRegistro[1] . "' no se puede modificar si el hogar pertenece a un proyecto";
                    } else {
                        if (trim($arrRegistro[2]) != trim($claFormulario->txtMatriculaInmobiliaria)) {
                            $bolError = true;
                        }
                    }
                    break;
                case "CHIP":
                    if (intval($claFormulario->seqModalidad) == 12 or intval($claFormulario->seqModalidad) == 13 or intval($claFormulario->seqModalidad) == 6) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " el campo '" . $arrRegistro[1] . "' no se puede modificar si el hogar pertenece a un proyecto";
                    } else {
                        if (trim($arrRegistro[2]) != trim($claFormulario->txtChip)) {
                            $bolError = true;
                        }
                    }
                    break;
                case "Proyecto":
                    if (intval($claFormulario->seqProyecto) != 0 and (intval($claFormulario->seqUnidadProyecto) == 0 or intval($claFormulario->seqUnidadProyecto) == 1)) {
                        $seqProyecto = array_shift(obtenerDatosTabla(
                            "t_pry_proyecto",
                            array("seqProyecto", "txtNombreProyecto"),
                            "txtNombreProyecto",
                            "lower(rtrim(ltrim(txtNombreProyecto))) like '" . mb_strtolower(trim($arrRegistro[2])) . "'"
                        ));
                        if (intval($seqProyecto) != intval($claFormulario->seqProyecto)) {
                            $bolError = true;
                        }
                    } else {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " el campo '" . $arrRegistro[1] . "' no se puede modificar si el hogar esta asociado a una unidad";
                    }
                    break;
                case "Unidad Habitacional":
                    if (intval($claFormulario->seqModalidad) == 12 or intval($claFormulario->seqModalidad) == 13 or intval($claFormulario->seqModalidad) == 6) {
                        list($txtNombreProyecto, $txtNombreUnidad) = mb_split("/", $arrRegistro[2]);
                        $seqProyecto = array_shift(obtenerDatosTabla(
                            "t_pry_proyecto",
                            array("seqProyecto", "txtNombreProyecto"),
                            "txtNombreProyecto",
                            "lower(rtrim(ltrim(txtNombreProyecto))) like '" . mb_strtolower(trim($txtNombreProyecto)) . "'"
                        ));
                        $seqUnidad = array_shift(obtenerDatosTabla(
                            "t_pry_unidad_proyecto",
                            array("seqUnidadProyecto", "txtNombreUnidad"),
                            "txtNombreUnidad",
                            "lower(rtrim(ltrim(txtNombreUnidad))) like '" . mb_strtolower(trim($txtNombreUnidad)) . "' and seqProyecto = " . intval($seqProyecto)
                        ));
                        if (intval($seqUnidad) != intval($claFormulario->seqUnidadProyecto)) {
                            $bolError = true;
                        }
                    } else {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " el campo '" . $arrRegistro[1] . "' no se puede modificar si el hogar no pertenece a un proyecto con unidades";
                    }
                    break;
                case "Valor Donacion":
                    if (doubleval($arrRegistro[2]) != doubleval($claFormulario->valDonacion)) {
                        $bolError = true;
                    }
                    break;
                case "Soporte Donacion":
                    if (trim($arrRegistro[2]) != trim($claFormulario->txtSoporteDonacion)) {
                        $bolError = true;
                    }
                    break;
                case "Entidad Donacion":
                    $seqEmpresaDonante = array_shift(obtenerDatosTabla(
                        "t_frm_empresa_donante",
                        array("seqEmpresaDonante", "txtEmpresaDonante"),
                        "txtEmpresaDonante",
                        "lower(ltrim(rtrim(txtEmpresaDonante))) like '" . mb_strtolower(trim($arrRegistro[2])) . "'"
                    ));
                    if (intval($seqEmpresaDonante) != intval($claFormulario->seqEmpresaDonante)) {
                        $bolError = true;
                    }
                    break;
                case "Fecha de Vigencia":

                    if(! esFechaValida($arrRegistro[2])) {
                        $fchCorrecta = null;
                        $numTimeStamp = (($arrRegistro[2] - $this->minmDatesDiff) * $this->secInDay) + $this->secInDay;
                        if ($numTimeStamp > 0 and $arrRegistro[2] != "") {
                            $fchCorrecta = date("Y-m-d", $numTimeStamp);
                        }
                        $arrRegistro[2] = $fchCorrecta;
                    }

                    $claFormulario->fchVigencia = (esFechaValida($claFormulario->fchVigencia))? $claFormulario->fchVigencia : null;
                    if($arrRegistro[2] != $claFormulario->fchVigencia){
                        $bolError = true;
                    }

                    $seqEtapa = array_shift(obtenerDatosTabla(
                        "t_frm_estado_proceso",
                        array("seqEstadoProceso","seqEtapa"),
                        "seqEstadoProceso",
                        "seqEstadoProceso = " . $claFormulario->seqEstadoProceso
                    ));
                    if($seqEtapa != 4 and $seqEtapa != 5){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor incorrecto '" . $arrRegistro[1] . "' el hogar no se encuentra en la etapa de asignación o desembolso";
                    }

                    break;
                default:
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[1] . " No es un valor válido para el Campo";
                    break;
            }
            if ($bolError == true) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor incorrecto '" . $arrRegistro[1] . "' no coincide con el de la base de datos";
            }

            // depende del campo a modificar aplican las reglas de negocio
            // valida que el campo correcto tenga coherencia
            switch ($arrRegistro[1]) {
                case "Primer Nombre":
                    if (trim($arrRegistro[3]) == "") {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no puede ser vacío";
                    }
                    break;
                case "Segundo Nombre":
                    // no hay validaciones para el campo correcto
                    break;
                case "Primer Apellido":
                    if (trim($arrRegistro[3]) == "") {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no puede ser vacío";
                    }
                    break;
                case "Segundo Apellido":
                    if (trim($arrRegistro[3]) == "") {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no puede ser vacío";
                    }
                    break;
                case "Documento":
                    if (doubleval($arrRegistro[3]) == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no puede ser vacio o cero";
                    } else {
                        $numDocumento = $arrRegistro[3];
                        $arrCiudadano = obtenerDatosTabla(
                            "t_ciu_ciudadano",
                            array("numDocumento", "upper(concat(t_ciu_ciudadano.txtNombre1,' ',t_ciu_ciudadano.txtNombre2,' ',t_ciu_ciudadano.txtApellido1,' ',t_ciu_ciudadano.txtApellido2)) as txtNombre"),
                            "numDocumento",
                            "numDocumento = " . $arrRegistro[3] . " and seqTipoDocumento = " . $objCiudadano->seqTipoDocumento
                        );
                        if (isset($arrCiudadano[$numDocumento])) {
                            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' el documento " . $arrRegistro[3] . " pertenece a " . $arrCiudadano[$numDocumento] . " asociado a otro hogar";
                        }
                    }
                    break;
                case "Tipo de Solucion":
                    $arrSolucion = obtenerDatosTabla(
                        "t_frm_solucion",
                        array("seqSolucion", "txtSolucion"),
                        "txtSolucion",
                        "seqModalidad = " . $claFormulario->seqModalidad
                    );
                    $txtSolucion = trim($arrRegistro[3]);
                    if (!isset($arrSolucion[$txtSolucion])) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no es válido";
                    }
                    break;
                case "Valor del Subsidio":
                    // no puede ser menor aun salario minimo ni mayor a 44 salarios minimos que es el maximo subsidio ahora
                    if (doubleval($arrRegistro[3]) < $arrConfiguracion['constantes']['salarioMinimo']) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' es muy bajo, verifique el valor";
                    }
                    if (doubleval($arrRegistro[3]) > ($arrConfiguracion['constantes']['salarioMinimo'] * 44)) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' es muy alto, verifique el valor";
                    }
                    break;
                case "Valor Complementario":
                    if (doubleval($arrRegistro[3]) < $arrConfiguracion['constantes']['salarioMinimo']) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' es muy bajo, verifique el valor";
                    }
                    if (doubleval($arrRegistro[3]) > ($arrConfiguracion['constantes']['salarioMinimo'] * 44)) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' es muy alto, verifique el valor";
                    }
                    break;
                case "Matricula Inmobiliaria":
                    if (trim($arrRegistro[3]) == "") {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no puede ser vacío";
                    }
                    break;
                case "CHIP":
                    if (trim($arrRegistro[3]) == "") {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no puede ser vacío";
                    }
                    break;
                case "Proyecto":
                    $txtNombreProyecto = $arrRegistro[3];
                    $arrProyecto = obtenerDatosTabla(
                        "t_pry_proyecto",
                        array("seqProyecto", "txtNombreProyecto"),
                        "txtNombreProyecto",
                        "lower(ltrim(rtrim(txtNombreProyecto))) like '" . mb_strtolower(trim($arrRegistro[3])) . "'"
                    );
                    if (!empty($arrProyecto)) {
                        $arrUnidades = obtenerDatosTabla(
                            "t_pry_unidad_proyecto",
                            array("seqUnidadProyecto", "txtNombreUnidad"),
                            "txtNombreUnidad",
                            "seqProyecto = " . $arrProyecto[$txtNombreProyecto]
                        );

                        if (!empty($arrUnidades)) {
                            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[1] . " valor correcto, no puede cambiar el proyecto a un proyecto con unidades";
                        }
                    } else {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' valor inválido";
                    }
                    break;
                case "Unidad Habitacional":
                    list($txtNombreProyecto, $txtNombreUnidad) = mb_split("/", $arrRegistro[3]);
                    $seqProyecto = array_shift(obtenerDatosTabla(
                        "t_pry_proyecto",
                        array("seqProyecto", "txtNombreProyecto"),
                        "txtNombreProyecto",
                        "lower(rtrim(ltrim(txtNombreProyecto))) like '" . mb_strtolower(trim($txtNombreProyecto)) . "'"
                    ));
                    $arrUnidad = array_shift(obtenerDatosTabla(
                        "t_pry_unidad_proyecto",
                        array("seqUnidadProyecto", "txtNombreUnidad", "seqFormulario", "seqModalidad", "seqTipoEsquema"),
                        "txtNombreUnidad",
                        "lower(rtrim(ltrim(txtNombreUnidad))) like '" . mb_strtolower(trim($txtNombreUnidad)) . "' and seqProyecto = " . intval($seqProyecto)
                    ));

                    if (empty($arrUnidad)) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' la unidad no existe";
                    } else {
                        if (intval($arrUnidad['seqFormulario']) != 0) {
                            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' la unidad está tomada por otro hogar";
                        }
                        if (intval($arrUnidad['seqModalidad']) != $claFormulario->seqModalidad or intval($arrUnidad['seqTipoEsquema']) != $claFormulario->seqTipoEsquema) {
                            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' la modadlidad o esquema del hogar no coinciden con los de la unidad seleccionada";
                        }
                    }
                    break;
                case "Valor Donacion":
                    // la validacion para este campo se hace combinada con el valor, la entidad y el soporte mas adelante
                    $arrValidacionCombinada[$seqFormulario]->valDonacion = doubleval($arrRegistro[3]);
                    break;
                case "Soporte Donacion":
                    // la validacion para este campo se hace combinada con el valor, la entidad y el soporte mas adelante
                    $arrValidacionCombinada[$seqFormulario]->txtSoporteDonacion = trim($arrRegistro[3]);
                    break;
                case "Entidad Donacion":
                    $seqEmpresaDonante = array_shift(obtenerDatosTabla(
                        "t_frm_empresa_donante",
                        array("seqEmpresaDonante", "txtEmpresaDonante"),
                        "txtEmpresaDonante",
                        "lower(ltrim(rtrim(txtEmpresaDonante))) like '" . mb_strtolower(trim($arrRegistro[3])) . "'"
                    ));
                    if (intval($seqEmpresaDonante) == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' la empresa donante no es un valor válido";
                    } else {
                        // la validacion para este campo se hace combinada con el valor, la entidad y el soporte mas adelante
                        $arrValidacionCombinada[$seqFormulario]->seqEmpresaDonante = intval($seqEmpresaDonante);
                    }
                    break;
                case "Fecha de Vigencia":
                    if(! esFechaValida($arrRegistro[2])) {
                        $fchCorrecta = null;
                        $numTimeStamp = (($arrRegistro[3] - $this->minmDatesDiff) * $this->secInDay) + $this->secInDay;
                        if ($numTimeStamp > 0) {
                            $fchCorrecta = date("Y-m-d", $numTimeStamp);
                        }
                        $arrRegistro[3] = $fchCorrecta;
                    }

                    if($arrRegistro[3] == null){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " valor correcto '" . $arrRegistro[1] . "' no es válido use el formato aaaa-mm-dd";
                    }

                    break;
            }

        }

        // validaciones combinadas, valdonacion !0 con entidad, despues de todas las modificaciones
        foreach ($arrValidacionCombinada as $seqFormulario => $claFormulario) {
            if ($claFormulario->valDonacion != 0) {
                if ($claFormulario->txtSoporteDonacion == "" or $claFormulario->seqEmpresaDonante <= 1) {
                    $this->arrErrores[] = "Error documento " . $arrRegistro[0] . ": El valor, empresa y soporte de la donación deben ser coherentes en la base de datos";
                }
            }
            if ($claFormulario->valDonacion == 0) {
                if ($claFormulario->txtSoporteDonacion != "" or $claFormulario->seqEmpresaDonante > 1) {
                    $this->arrErrores[] = "Error documento " . $arrRegistro[0] . ": El valor de la donación no puede ser cero";
                }
            }
        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS DE
     * NEGOCIO PARA LAS RESOLUCIONES DE TIPO INHABILITADOS
     * @param $seqTipoActo
     * @param $arrArchivo
     */

    private function validarReglasInhabilitados($arrPost, $arrArchivo)
    {

        $seqTipoActo = $arrPost['seqTipoActo'];

        // recolecta los hogares
        $arrHogares = array();
        foreach ($arrArchivo as $numLinea => $arrRegistro) {
            $seqFormulario = $arrRegistro[0];
            $numDocumento = $arrRegistro[1];
            $arrHogares[$seqFormulario][$numDocumento] = $numDocumento;
        }

        // compara los miembros de hogar para saber que son completos
        $arrFormularios = array();
        foreach ($arrHogares as $seqFormulario => $arrCiudadanos) {
            $arrFormularios[$seqFormulario] = new FormularioSubsidios();
            $arrFormularios[$seqFormulario]->cargarFormulario($seqFormulario);

            if (!in_array($arrFormularios[$seqFormulario]->seqEstadoProceso, $this->arrEstadosPermitidos[$seqTipoActo])) {
                $this->arrErrores[] = "Error formulario $seqFormulario: No tiene el estado permitido";
            }

            foreach ($arrCiudadanos as $numDocumento) {
                foreach ($arrFormularios[$seqFormulario]->arrCiudadano as $seqCiudadano => $claCiudadano) {
                    if ($numDocumento == $claCiudadano->numDocumento) {
                        unset($arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]);
                    }
                }
            }

        }

        // mira los errores
        foreach ($arrFormularios as $seqFormulario => $claFormulario) {
            if (!empty($claFormulario->arrCiudadano)) {
                $this->arrErrores[] = "Error formularo $seqFormulario: Faltan miembros de hogar dentro del archivo, sin importar que tengan o no inhabilidades, deben estar incluidos";
            }
        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS DE
     * NEGOCIO PARA LAS RESOLUCIONES DE RFECURSOSO DE REPOSICION
     * @param $seqTipoActo
     * @param $arrArchivo
     */

    private function validarReglasReposicion($arrPost, $arrArchivo){

        $claCiudadano = new Ciudadano();
        foreach($arrArchivo as $numLinea => $arrRegistro){

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[1],$arrRegistro[2]);

            if($seqFormularioActo == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No esta relacionado con el acto administrativo " . $arrRegistro[1] . " de " . $arrRegistro[2];
            }

            // si existe el documento
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS DE
     * NEGOCIO PARA LAS RESOLUCIONES DE NO ASIGNADOS
     * @param $seqTipoActo
     * @param $arrArchivo
     */

    private function validarReglasNoAsignados($arrPost, $arrArchivo){

        $claCiudadano = new Ciudadano();
        $seqTipoActo = $arrPost['seqTipoActo'];

        foreach ($arrArchivo as $numLinea => $arrRegistro) {

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);

            // si existe el documento
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                    break;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

            if(! in_array($claFormulario->seqEstadoProceso,$this->arrEstadosPermitidos[$seqTipoActo])){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " El hogar no esta en el estado del proceso permitido";
            }

        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS
     * DE NEGOCIO PARA LOS RADICADOS DE RENUNCIA
     * @param $arrPost
     * @param $arrArchivo
     */
    private function validarReglasRenuncia($arrArchivo)
    {

        $arrEstados = estadosProceso();
        $claCiudadano = new Ciudadano();

        foreach ($arrArchivo as $numLinea => $arrLinea) {

            $seqFormulario = $claCiudadano->formularioVinculado($arrLinea[0]);
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            $seqEstadoProceso = array_shift(
                obtenerDatosTabla(
                    "T_FRM_FORMULARIO",
                    array("seqFormulario", "seqEstadoProceso"),
                    "seqFormulario",
                    "seqFormulario = " . $seqFormulario
                )
            );

            $seqEtapa = array_shift(
                obtenerDatosTabla(
                    "T_FRM_ESTADO_PROCESO",
                    array("seqEstadoProceso", "seqEtapa"),
                    "seqEstadoProceso",
                    "seqEstadoProceso = " . $seqEstadoProceso
                )
            );

            if ($seqEtapa != 4 and $seqEtapa != 5) {
                $this->arrErrores[] =
                    "Error linea " . ($numLinea + 1) . ": El hogar del ciudadano " . $arrLinea[0] . " esta en estado \"" .
                    $arrEstados[$seqEstadoProceso] . "\" y no es permitido para asociar a una renuncia";

            }

            // Si tiene fecha de resolucion y numero mira si existe
            // y si el hogar esta vinculado a esa resoliución
            switch (true) {
                case $arrLinea[1] != "" and $arrLinea[2] != "":
                    $arrListado = $this->listarActos(1, $arrLinea[1], $arrLinea[2], $arrLinea[2], array($arrLinea[0]));
                    if (empty($arrListado)) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El documento " . $arrLinea[0] . " no pertenece a la resolución " . $arrLinea[1] . " del " . $arrLinea[2] . " o dicha resolución no es de asignación";
                    }
                    break;
                case $arrLinea[1] == "" and $arrLinea[2] != "":
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro tiene fecha pero no numero de resolución";
                    break;
                case $arrLinea[1] != "" and $arrLinea[2] == "":
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro tiene número pero no fecha de resolución";
                    break;
                case $arrLinea[1] == "" and $arrLinea[2] == "":
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro debe tener número de resolución";
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro debe tener fecha de resolución";
                    break;
            }

        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS
     * DE NEGOCIO PARA LAS NOTIFICACIONES
     * @param $arrPost
     * @param $arrArchivo
     */
    private function validarReglasNotificacion($arrPost, $arrArchivo){

        $claCiudadano = new Ciudadano();
        foreach($arrArchivo as $numLinea => $arrRegistro){

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[2],$arrRegistro[3]);

            if(! esFechaValida($arrRegistro[1])){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " Indique una fecha de notificación válida";
            }

            if($seqFormularioActo == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No esta relacionado con el acto administrativo " . $arrRegistro[1] . " de " . $arrRegistro[2];
            }

            // si existe el documento
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

        }



    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS
     * DE NEGOCIO PARA LAS INDEXACIONES
     * @param $arrPost
     * @param $arrArchivo
     */
    private function validarReglasIndexacion($arrPost, $arrArchivo){

        $claCiudadano = new Ciudadano();

        foreach ($arrArchivo as $numLinea => $arrRegistro) {

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[1],$arrRegistro[2]);

            if($seqFormularioActo == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No está relacionado con el acto administrativo " . $arrRegistro[1] . " de " . $arrRegistro[2];
            }

            // si existe el documento
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                    break;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

            if($claFormulario->seqUnidadProyecto > 1){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No se puede indexar hogares vinculados a unidades, debe indexar la unidad";
            }

            if(strpos($arrRegistro[3],".")){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No use valores decimales para la indexación";
            }

            if(strpos($arrRegistro[3],",")){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No use valores decimales para la indexación";
            }

        }


    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS
     * DE NEGOCIO PARA LAS PERDIDAS
     * @param $arrPost
     * @param $arrArchivo
     */
    private function validarReglasPerdida($arrPost, $arrArchivo){

        $arrEstados = estadosProceso();
        $claCiudadano = new Ciudadano();

        foreach ($arrArchivo as $numLinea => $arrRegistro) {

            pr($arrRegistro);

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[1],$arrRegistro[2]);

            if($seqFormularioActo == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No está relacionado con el acto administrativo " . $arrRegistro[1] . " de " . $arrRegistro[2];
            }

            // si existe el documento
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                    break;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

            $seqEstadoProceso = $claFormulario->seqEstadoProceso;

            $seqEtapa = array_shift(
                obtenerDatosTabla(
                    "T_FRM_ESTADO_PROCESO",
                    array("seqEstadoProceso", "seqEtapa"),
                    "seqEstadoProceso",
                    "seqEstadoProceso = " . $seqEstadoProceso
                )
            );

            if ($seqEtapa != 4 and $seqEtapa != 5) {
                $this->arrErrores[] =
                    "Error linea " . ($numLinea + 1) . ": El hogar del ciudadano " . $arrRegistro[0] . " esta en estado \"" .
                    $arrEstados[$seqEstadoProceso] . "\" y no es permitido para asociar a una perdida";

            }

        }

    }

    private function validarReglasExclusion($arrPost, $arrArchivo){

        $arrEstados = estadosProceso();
        $claCiudadano = new Ciudadano();
        $claTipoActo = new aadTipo();
        $claTipoActo = array_shift($claTipoActo->cargarTipoActo($arrPost['seqTipoActo']));

        foreach ($arrArchivo as $numLinea => $arrRegistro) {

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[1],$arrRegistro[2]);

            if($seqFormularioActo == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No está relacionado con el acto administrativo " . $arrRegistro[1] . " de " . $arrRegistro[2];
            }

            // si existe el documento
            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $claCiudadano->arrErrores[0];
            }

            // DEBE SER EL POSTULANTE PRINCIPAL
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $bolPrincipal = 0;
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                if ($objCiudadano->numDocumento == $arrRegistro[0] and $objCiudadano->seqParentesco == 1) {
                    $bolPrincipal = 1;
                    break;
                }
            }
            if ($bolPrincipal == 0) {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " No es el postulante principal del hogar";
            }

            if($claFormulario->seqTipoEsquema != 8){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " El hogar no pertenece al esquema de vivienda gratuita";
            }

            if($claFormulario->bolCerrado != 1){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " El formulario no está cerrado";
            }


            $seqEstadoProceso = $claFormulario->seqEstadoProceso;

            $seqEtapa = array_shift(
                obtenerDatosTabla(
                    "T_FRM_ESTADO_PROCESO",
                    array("seqEstadoProceso", "seqEtapa"),
                    "seqEstadoProceso",
                    "seqEstadoProceso = " . $seqEstadoProceso
                )
            );

            if ($seqEtapa != 4 and $seqEtapa != 5) {
                $this->arrErrores[] =
                    "Error linea " . ($numLinea + 1) . ": El hogar del ciudadano " . $arrRegistro[0] . " esta en estado \"" .
                    $arrEstados[$seqEstadoProceso] . "\" y no es permitido para asociar a una perdida";

            }

            if(! in_array($arrRegistro[3],$claTipoActo->arrFormatoArchivo[3]['rango'])){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " Columna estado tiene un valor no válido";
            }

            if(trim($arrRegistro[4]) == ""){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": " . $arrRegistro[0] . " Columna comentario no puede estar vacia";
            }

        }

    }

    /**
     * ENRUTADOR PARA LAS VALIDACIONES DE
     * LOS FORMULARIOS DE CARACTERISTICAS
     * @param $arrPost
     */
    public function validarFormulario($arrPost)
    {

        switch ($arrPost['seqTipoActo']) {
            case 1: // asignacion
                $this->validarFormularioAsignacion($arrPost);
                break;
            case 2: // modificatorias
                $this->validarFormularioBasico($arrPost);
                break;
            case 3: // inhabilitados
                $this->validarFormularioBasico($arrPost);
                break;
            case 4: // reposicion
                $this->validarFormularioBasico($arrPost);
                break;
            case 5: // no asignado
                $this->validarFormularioBasico($arrPost);
                break;
            case 6: // renuncia
                $this->validarFormularioBasico($arrPost);
                break;
            case 7: // notificaciones
                $this->validarFormularioBasico($arrPost);
                break;
            case 8: // indexaciones
                $this->validarFormularioIndexacion($arrPost);
                break;
            case 9: // perdida
                $this->validarFormularioBasico($arrPost);
                break;
            case 10: // revocatoria
                $this->validarFormularioBasico($arrPost);
                break;
            case 11: // exclusion
                $this->validarFormularioBasico($arrPost);
                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                break;
        }

    }

    /**
     * VALIDACIONES DEL FORMULARIO BASICO
     * @param arrPost
     */
    private function validarFormularioBasico($arrPost)
    {

        // numero - expresion regular para el forest
        if (isset($arrPost['bolRadicado']) and intval($arrPost['bolRadicado']) == 1) {
            preg_match("/(\d{1})(\d{4})(\d{1,})/", $arrPost['numActo'], $arrMatch);
            if (empty($arrMatch)) {
                $this->arrErrores[] = "Revise el formato del radicado, debe ser el radicado de Forest";
            }
        } else {
            if (intval($_POST['numActo']) == 0 or strlen($_POST['numActo']) > 4) {
                $this->arrErrores[] = "Debe dar un número para el acto administrativo";
            }
        }

        // fecha del acto
        if (!esFechaValida($_POST['fchActo'])) {
            $arrErrores[] = "Debe dar una fecha para el acto administrativo";
        }

        // texto de la resolucion
        if (trim($arrPost['txtResolucion']) == "") {
            $this->arrErrores[] = "El texto de la resolución no puede estar vacío";
        }

    }


    /**
     * VALIDACIONES DEL FORMULARIO PARA
     * LAS RESOLUCIONES DE ASIGNACION
     * @param $arrPost
     */
    private function validarFormularioAsignacion($arrPost)
    {

        $this->validarFormularioBasico($arrPost);

        // validacion de los cdp y rp
        for ($i = 1; $i < 13; $i++) {

            // Si al menos un dato esta digitado
            if (
                intval($arrPost['numPry' . $i]) != 0 or // proyecto de inversion
                intval($arrPost['numCdp' . $i]) != 0 or // numero del cdp
                doubleval($arrPost['valCdp' . $i]) != 0 or // valor del cdp
                esFechaValida($arrPost['fchCdp' . $i]) != null or // fecha del cdp
                intval($arrPost['numVigCdp' . $i]) != 0 or // vigencia del cdp
                intval($arrPost['numRp' . $i]) != 0 or // numero del rp
                doubleval($arrPost['valRp' . $i]) != 0 or // valor del rp
                esFechaValida($arrPost['fchRp' . $i]) != null or // fecha del rp
                intval($arrPost['numVigRp' . $i]) != 0       // vigencia del rp
            ) {

                // CDP -------------------------------------------------------------------

                if (intval($arrPost['numPry' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el proyecto de inversión " . $i;
                }

                if (intval($arrPost['numCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el número del CDP " . $i;
                }

                if (doubleval($arrPost['valCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el valor del CDP " . $i;
                }

                if (esFechaValida($arrPost['fchCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la fecha del CDP " . $i;
                } elseif (strtotime($arrPost['fchCdp' . $i]) > strtotime($arrPost['fchActo'])) {
                    $this->arrErrores[] = "La fecha del CDP " . $i . " no puede ser posterior a la fecha del acto administrativo";
                }

                if (intval($arrPost['numVigCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la vigencia del CDP " . $i;
                } elseif (intval($arrPost['numVigCdp' . $i]) < 2009 or intval($arrPost['numVigCdp' . $i]) > date("Y")) {
                    $this->arrErrores[] = "La vigencia del CDP " . $i . " debe ser posterior al 2009 y anterior o igual a " . date("Y");
                }

                // RP -------------------------------------------------------------------

                if (intval($arrPost['numRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el número del RP " . $i;
                }

                if (doubleval($arrPost['valRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el valor del RP " . $i;
                }

                if (esFechaValida($arrPost['fchRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la fecha del RP " . $i;
                } elseif (strtotime($arrPost['fchRp' . $i]) > strtotime($arrPost['fchActo'])) {
                    $this->arrErrores[] = "La fecha del RP " . $i . " no puede ser posterior a la fecha del acto administrativo";
                }

                if (intval($arrPost['numVigRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la vigencia del CDP " . $i;
                } elseif (intval($arrPost['numVigRp' . $i]) < 2009 or intval($arrPost['numVigRp' . $i]) > date("Y")) {
                    $this->arrErrores[] = "La vigencia del RP " . $i . " debe ser posterior al 2009 y anterior o igual a " . date("Y");
                }

            }

        }

    }

    /**
     * VALIDACIONES DEL FORMULARIO PARA
     * LAS RESOLUCIONES DE INDEXACION
     * @param $arrPost
     */
    private function validarFormularioIndexacion($arrPost){

        $this->validarFormularioBasico($arrPost);

        // validacion de los cdp y rp
        for ($i = 1; $i < 3; $i++) {

            // Si al menos un dato esta digitado
            if (
                intval($arrPost['numPry' . $i]) != 0 or // proyecto de inversion
                intval($arrPost['numCdp' . $i]) != 0 or // numero del cdp
                doubleval($arrPost['valCdp' . $i]) != 0 or // valor del cdp
                esFechaValida($arrPost['fchCdp' . $i]) != null or // fecha del cdp
                intval($arrPost['numVigCdp' . $i]) != 0 or // vigencia del cdp
                intval($arrPost['numRp' . $i]) != 0 or // numero del rp
                doubleval($arrPost['valRp' . $i]) != 0 or // valor del rp
                esFechaValida($arrPost['fchRp' . $i]) != null or // fecha del rp
                intval($arrPost['numVigRp' . $i]) != 0       // vigencia del rp
            ) {

                // CDP -------------------------------------------------------------------

                if (intval($arrPost['numPry' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el proyecto de inversión " . $i;
                }

                if (intval($arrPost['numCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el número del CDP " . $i;
                }

                if (doubleval($arrPost['valCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el valor del CDP " . $i;
                }

                if (esFechaValida($arrPost['fchCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la fecha del CDP " . $i;
                } elseif (strtotime($arrPost['fchCdp' . $i]) > strtotime($arrPost['fchActo'])) {
                    $this->arrErrores[] = "La fecha del CDP " . $i . " no puede ser posterior a la fecha del acto administrativo";
                }

                if (intval($arrPost['numVigCdp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la vigencia del CDP " . $i;
                } elseif (intval($arrPost['numVigCdp' . $i]) < 2009 or intval($arrPost['numVigCdp' . $i]) > date("Y")) {
                    $this->arrErrores[] = "La vigencia del CDP " . $i . " debe ser posterior al 2009 y anterior o igual a " . date("Y");
                }

                // RP -------------------------------------------------------------------

                if (intval($arrPost['numRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el número del RP " . $i;
                }

                if (doubleval($arrPost['valRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite el valor del RP " . $i;
                }

                if (esFechaValida($arrPost['fchRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la fecha del RP " . $i;
                } elseif (strtotime($arrPost['fchRp' . $i]) > strtotime($arrPost['fchActo'])) {
                    $this->arrErrores[] = "La fecha del RP " . $i . " no puede ser posterior a la fecha del acto administrativo";
                }

                if (intval($arrPost['numVigRp' . $i]) == 0) {
                    $this->arrErrores[] = "Digite la vigencia del CDP " . $i;
                } elseif (intval($arrPost['numVigRp' . $i]) < 2009 or intval($arrPost['numVigRp' . $i]) > date("Y")) {
                    $this->arrErrores[] = "La vigencia del RP " . $i . " debe ser posterior al 2009 y anterior o igual a " . date("Y");
                }

            }

        }
    }

    /**
     * DESDE LAS CARACTERISTICAS DEL AAD EN EL HTML
     * SE MAPEAN CON LOS IDENTIFICADORES DE BASE DE DATOS
     * @param $arrCaracteristicas
     */
    private function mapeoInversoCaracteristicas($seqTipoActo)
    {
        switch ($seqTipoActo) {
            case 1: // asignacion
                $this->arrCaracteristicas['txtResolucion'] = 1;
                $this->arrCaracteristicas['numCdp1'] = 9;
                $this->arrCaracteristicas['valCdp1'] = 10;
                $this->arrCaracteristicas['fchCdp1'] = 11;
                $this->arrCaracteristicas['numVigCdp1'] = 12;
                $this->arrCaracteristicas['numRp1'] = 13;
                $this->arrCaracteristicas['valRp1'] = 14;
                $this->arrCaracteristicas['fchRp1'] = 15;
                $this->arrCaracteristicas['numVigRp1'] = 16;
                $this->arrCaracteristicas['numPry1'] = 17;
                $this->arrCaracteristicas['numCdp2'] = 23;
                $this->arrCaracteristicas['valCdp2'] = 24;
                $this->arrCaracteristicas['fchCdp2'] = 25;
                $this->arrCaracteristicas['numVigCdp2'] = 26;
                $this->arrCaracteristicas['numRp2'] = 27;
                $this->arrCaracteristicas['valRp2'] = 28;
                $this->arrCaracteristicas['fchRp2'] = 29;
                $this->arrCaracteristicas['numVigRp2'] = 30;
                $this->arrCaracteristicas['numPry2'] = 142;
                $this->arrCaracteristicas['numCdp3'] = 40;
                $this->arrCaracteristicas['valCdp3'] = 41;
                $this->arrCaracteristicas['fchCdp3'] = 42;
                $this->arrCaracteristicas['numVigCdp3'] = 43;
                $this->arrCaracteristicas['numRp3'] = 44;
                $this->arrCaracteristicas['valRp3'] = 45;
                $this->arrCaracteristicas['fchRp3'] = 46;
                $this->arrCaracteristicas['numVigRp3'] = 47;
                $this->arrCaracteristicas['numPry3'] = 48;
                $this->arrCaracteristicas['numCdp4'] = 51;
                $this->arrCaracteristicas['valCdp4'] = 52;
                $this->arrCaracteristicas['fchCdp4'] = 53;
                $this->arrCaracteristicas['numVigCdp4'] = 54;
                $this->arrCaracteristicas['numRp4'] = 55;
                $this->arrCaracteristicas['valRp4'] = 56;
                $this->arrCaracteristicas['fchRp4'] = 57;
                $this->arrCaracteristicas['numVigRp4'] = 58;
                $this->arrCaracteristicas['numPry4'] = 143;
                $this->arrCaracteristicas['numCdp5'] = 59;
                $this->arrCaracteristicas['valCdp5'] = 60;
                $this->arrCaracteristicas['fchCdp5'] = 61;
                $this->arrCaracteristicas['numVigCdp5'] = 62;
                $this->arrCaracteristicas['numRp5'] = 63;
                $this->arrCaracteristicas['valRp5'] = 64;
                $this->arrCaracteristicas['fchRp5'] = 65;
                $this->arrCaracteristicas['numVigRp5'] = 66;
                $this->arrCaracteristicas['numPry5'] = 144;
                $this->arrCaracteristicas['numCdp6'] = 67;
                $this->arrCaracteristicas['valCdp6'] = 68;
                $this->arrCaracteristicas['fchCdp6'] = 69;
                $this->arrCaracteristicas['numVigCdp6'] = 70;
                $this->arrCaracteristicas['numRp6'] = 71;
                $this->arrCaracteristicas['valRp6'] = 72;
                $this->arrCaracteristicas['fchRp6'] = 73;
                $this->arrCaracteristicas['numVigRp6'] = 74;
                $this->arrCaracteristicas['numPry6'] = 145;
                $this->arrCaracteristicas['numCdp7'] = 75;
                $this->arrCaracteristicas['valCdp7'] = 76;
                $this->arrCaracteristicas['fchCdp7'] = 77;
                $this->arrCaracteristicas['numVigCdp7'] = 78;
                $this->arrCaracteristicas['numRp7'] = 79;
                $this->arrCaracteristicas['valRp7'] = 80;
                $this->arrCaracteristicas['fchRp7'] = 81;
                $this->arrCaracteristicas['numVigRp7'] = 82;
                $this->arrCaracteristicas['numPry7'] = 146;
                $this->arrCaracteristicas['numCdp8'] = 83;
                $this->arrCaracteristicas['valCdp8'] = 84;
                $this->arrCaracteristicas['fchCdp8'] = 85;
                $this->arrCaracteristicas['numVigCdp8'] = 86;
                $this->arrCaracteristicas['numRp8'] = 87;
                $this->arrCaracteristicas['valRp8'] = 88;
                $this->arrCaracteristicas['fchRp8'] = 89;
                $this->arrCaracteristicas['numVigRp8'] = 90;
                $this->arrCaracteristicas['numPry8'] = 147;
                $this->arrCaracteristicas['numCdp9'] = 100;
                $this->arrCaracteristicas['valCdp9'] = 101;
                $this->arrCaracteristicas['fchCdp9'] = 102;
                $this->arrCaracteristicas['numVigCdp9'] = 103;
                $this->arrCaracteristicas['numRp9'] = 104;
                $this->arrCaracteristicas['valRp9'] = 105;
                $this->arrCaracteristicas['fchRp9'] = 106;
                $this->arrCaracteristicas['numVigRp9'] = 107;
                $this->arrCaracteristicas['numPry9'] = 148;
                $this->arrCaracteristicas['numCdp10'] = 108;
                $this->arrCaracteristicas['valCdp10'] = 109;
                $this->arrCaracteristicas['fchCdp10'] = 110;
                $this->arrCaracteristicas['numVigCdp10'] = 111;
                $this->arrCaracteristicas['numRp10'] = 112;
                $this->arrCaracteristicas['valRp10'] = 113;
                $this->arrCaracteristicas['fchRp10'] = 114;
                $this->arrCaracteristicas['numVigRp10'] = 115;
                $this->arrCaracteristicas['numPry10'] = 149;
                $this->arrCaracteristicas['numCdp11'] = 116;
                $this->arrCaracteristicas['valCdp11'] = 117;
                $this->arrCaracteristicas['fchCdp11'] = 118;
                $this->arrCaracteristicas['numVigCdp11'] = 119;
                $this->arrCaracteristicas['numRp11'] = 120;
                $this->arrCaracteristicas['valRp11'] = 121;
                $this->arrCaracteristicas['fchRp11'] = 122;
                $this->arrCaracteristicas['numVigRp11'] = 123;
                $this->arrCaracteristicas['numPry11'] = 150;
                $this->arrCaracteristicas['numCdp12'] = 124;
                $this->arrCaracteristicas['valCdp12'] = 125;
                $this->arrCaracteristicas['fchCdp12'] = 126;
                $this->arrCaracteristicas['numVigCdp12'] = 127;
                $this->arrCaracteristicas['numRp12'] = 128;
                $this->arrCaracteristicas['valRp12'] = 129;
                $this->arrCaracteristicas['fchRp12'] = 130;
                $this->arrCaracteristicas['numVigRp12'] = 131;
                $this->arrCaracteristicas['numPry12'] = 151;
                $this->arrCaracteristicas['numCdp13'] = 132;
                $this->arrCaracteristicas['valCdp13'] = 133;
                $this->arrCaracteristicas['fchCdp13'] = 134;
                $this->arrCaracteristicas['numVigCdp13'] = 135;
                $this->arrCaracteristicas['numRp13'] = 136;
                $this->arrCaracteristicas['valRp13'] = 137;
                $this->arrCaracteristicas['fchRp13'] = 138;
                $this->arrCaracteristicas['numVigRp13'] = 139;
                $this->arrCaracteristicas['numPry13'] = 152;
                break;
            case 2: // modificatorias
                $this->arrCaracteristicas['txtResolucion'] = 2;
                break;
            case 3: // inhabilitados
                $this->arrCaracteristicas['txtResolucion'] = 3;
                break;
            case 4: // reposicion
                $this->arrCaracteristicas['txtResolucion'] = 153;
                break;
            case 5: // no asignado
                $this->arrCaracteristicas['txtResolucion'] = 8;
                break;
            case 6: // renuncia
                $this->arrCaracteristicas['txtResolucion'] = 154;
                break;
            case 7: // notificaciones
                $this->arrCaracteristicas['txtResolucion'] = 39;
                break;
            case 8: // indexaciones
                $this->arrCaracteristicas['txtResolucion'] = 31;
                $this->arrCaracteristicas['numCdp1'] = 32;
                $this->arrCaracteristicas['valCdp1'] = 33;
                $this->arrCaracteristicas['fchCdp1'] = 34;
                $this->arrCaracteristicas['numVigCdp1'] = 155;
                $this->arrCaracteristicas['numRp1'] = 35;
                $this->arrCaracteristicas['valRp1'] = 36;
                $this->arrCaracteristicas['fchRp1'] = 37;
                $this->arrCaracteristicas['numVigRp1'] = 156;
                $this->arrCaracteristicas['numPry1'] = 38;
                $this->arrCaracteristicas['numCdp2'] = 93;
                $this->arrCaracteristicas['valCdp2'] = 94;
                $this->arrCaracteristicas['fchCdp2'] = 95;
                $this->arrCaracteristicas['numVigCdp2'] = 157;
                $this->arrCaracteristicas['numRp2'] = 96;
                $this->arrCaracteristicas['valRp2'] = 97;
                $this->arrCaracteristicas['fchRp2'] = 98;
                $this->arrCaracteristicas['numVigRp2'] = 158;
                $this->arrCaracteristicas['numPry2'] = 159;
                break;
            case 9: // perdida
                $this->arrCaracteristicas['txtResolucion'] = 99;
                break;
            case 10: // revocatoria
                $this->arrCaracteristicas['txtResolucion'] = 160;
                break;
            case 11: // exclusion
                $this->arrCaracteristicas['txtResolucion'] = 161;
                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $seqTipoActo;
                break;
        }
    }

    /**
     * SALVA EL ACTO ADMINISTRATIVO
     * NO COPIA LOS DATOS DE HOGARES
     * NO APLICA EFECTOS COLATERALES DEL ACTO
     * @param $arrPost
     */
    private function salvarActoAdministrativo($arrPost)
    {
        global $aptBd;

        foreach ($this->arrCaracteristicas as $txtClave => $seqCaracteristica) {
            $txtValorCaracteristica = (isset($arrPost[$txtClave]) and $arrPost[$txtClave] != "") ? "'" . $arrPost[$txtClave] . "'" : "NULL";
            $sql = "
                insert into t_aad_acto_administrativo (
                    seqTipoActo, 
                    numActo, 
                    fchActo, 
                    seqCaracteristica, 
                    txtValorCaracteristica
                ) values (
                    " . $arrPost['seqTipoActo'] . ",
                    " . $arrPost['numActo'] . ",
                    '" . $arrPost['fchActo'] . "',
                    " . $seqCaracteristica . ",
                    " . $txtValorCaracteristica . "
                )
            ";
            $aptBd->execute($sql);
        }
    }

    /**
     * ENRUTADOR DE LOS EFECTOS COLATERALES DE LOS EFECTOS
     * @param $arrPost
     * @param $arrArchivo
     */
    private function aplicarEfectos($arrPost, $arrArchivo)
    {
        switch ($arrPost['seqTipoActo']) {
            case 1: // asignacion
                $this->aplicarEfectosAsignacion($arrArchivo);
                break;
            case 2: // modificatorias
                $this->aplicarEfectosModificatorias($arrArchivo);
                break;
            case 3: // inhabilitados
                $this->aplicarEfectosInhabilitados($arrArchivo);
                break;
            case 4: // reposicion
                $this->aplicarEfectosReposicion($arrArchivo);
                break;
            case 5: // no asignado
                $this->aplicarEfectosNoAsignados($arrArchivo);
                break;
            case 6: // renuncia
                $this->aplicarEfectosRenuncia($arrArchivo);
                break;
            case 7: // notificaciones
                $this->aplicarEfectosNotificacion($arrArchivo);
                break;
            case 8: // indexaciones
                $this->aplicarEfectosIndexacion($arrArchivo);
                break;
            case 9: // perdida
                $this->aplicarEfectosPerdida($arrArchivo);
                break;
            case 10: // revocatoria
                $this->aplicarEfectosRevocatoria($arrArchivo);
                break;
            case 11: // exclusion
                $this->aplicarEfectosExclusion($arrArchivo);

                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                break;
        }
    }

    /**
     * APLICANDO LOS EFECTOS DE LAS RESOLUCIONES DE ASIGNACION
     * @param $arrArchivo
     */
    private function aplicarEfectosAsignacion($arrArchivo)
    {
        global $aptBd;
        foreach ($arrArchivo as $arrRegistro) {

            // si es resolucion de vinculacion no aplica cambios
            if ($arrRegistro[2] == "" and $arrRegistro[3] == "") {

                // obtiene el formulario que corresponde a la cedula
                $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

                // obtiene el estado del proceso que corresponde al hogar (actual)
                $arrDatosFormulario = array_shift(obtenerDatosTabla(
                    "T_FRM_FORMULARIO",
                    array("seqFormulario", "seqEstadoProceso", "fchVigencia"),
                    "seqFormulario",
                    "seqFormulario = " . $seqFormulario
                ));

                $arrRegistro[1] = ($arrRegistro[1] != "")? "'" . $arrRegistro[1] . "'" : "NULL";

                // realiza la modificacion del estado (nuevo)
                $sql = "
                    update t_frm_formulario set
                        seqEstadoProceso = 15,
                        fchVigencia = " . $arrRegistro[1] . ",
                        fchUltimaActualizacion = NOW()
                    where seqFormulario = " . $seqFormulario . "
                ";
                $aptBd->execute($sql);

                // adiciona el cambio al arreglo para el seguimiento
                $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
                $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrDatosFormulario['seqEstadoProceso'];
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 15;

                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchVigencia";
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrDatosFormulario['fchVigencia'];
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = $arrRegistro[1];

            }

        }
    }

    /**
     * APLICANDO LOS EFECTOS DE LAS RESOLUCIONES MODIFICATORIA
     * @param $arrArchivo
     */
    private function aplicarEfectosModificatorias($arrArchivo)
    {
        global $aptBd;
        $arrFormularios = array();
        $claCiudadano = new Ciudadano();
        foreach ($arrArchivo as $arrRegistro) {

            // obtiene el formulario que corresponde a la cedula
            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);
            if (!isset($arrFormularios[$seqFormulario])) {
                $claFormulario = new FormularioSubsidios();
                $claFormulario->cargarFormulario($seqFormulario);
                $arrFormularios[$seqFormulario] = $claFormulario;
                foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {
                    if ($claCiudadano->seqParentesco == 1) {
                        break;
                    }
                }
            }

            switch ($arrRegistro[1]) {
                case "Primer Nombre":
                    $txtCampo = "txtNombre1";
                    $claCiudadano->txtNombre1 = mb_strtoupper(trim($arrRegistro[3]));
                    break;
                case "Segundo Nombre":
                    $txtCampo = "txtNombre2";
                    $claCiudadano->txtNombre2 = mb_strtoupper(trim($arrRegistro[3]));
                    break;
                case "Primer Apellido":
                    $txtCampo = "txtApellido1";
                    $claCiudadano->txtApellido1 = mb_strtoupper(trim($arrRegistro[3]));
                    break;
                case "Segundo Apellido":
                    $txtCampo = "txtApellido2";
                    $claCiudadano->txtApellido2 = mb_strtoupper(trim($arrRegistro[3]));
                    break;
                case "Documento":
                    $txtCampo = "numDocumento";
                    $claCiudadano->numDocumento = doubleval($arrRegistro[3]);
                    break;
                case "Tipo de Solucion":
                    $seqSolucion = array_shift(obtenerDatosTabla(
                        "t_frm_solucion",
                        array("seqSolucion", "txtSolucion"),
                        "txtSolucion",
                        "seqModalidad = " . $claFormulario->seqModalidad . " and lower(ltrim(rtrim(txtSolucion))) like '" . mb_strtoupper(trim($arrRegistro[3])) . "'"
                    ));
                    $txtCampo = "seqSolucion";
                    $claFormulario->seqSolucion = $seqSolucion;
                    break;
                case "Valor del Subsidio":
                    $txtCampo = "valAspiraSubsidio";
                    $claFormulario->valAspiraSubsidio = doubleval($arrRegistro[3]);
                    break;
                case "Valor Complementario":
                    $txtCampo = "valComplementario";
                    $claFormulario->valComplementario = doubleval($arrRegistro[3]);
                    break;
                case "Matricula Inmobiliaria":
                    $txtCampo = "txtMatriculaInmobiliaria";
                    $claFormulario->txtMatriculaInmobiliaria = trim($arrRegistro[3]);
                    break;
                case "CHIP":
                    $txtCampo = "txtChip";
                    $claFormulario->txtChip = trim($arrRegistro[3]);
                    break;
                case "Proyecto":
                    $arrProyecto = array_shift(obtenerDatosTabla(
                        "t_pry_proyecto",
                        array("seqProyecto", "txtNombreProyecto", "txtMatriculaInmobiliariaLote", "txtChipLote", "txtDireccion"),
                        "txtNombreProyecto",
                        "lower(ltrim(rtrim(txtNombreProyecto))) like '" . mb_strtolower(trim($arrRegistro[3])) . "'"
                    ));
                    $txtCampo = "seqProyecto";
                    $claFormulario->seqProyecto = $arrProyecto['seqProyecto'];
                    $claFormulario->seqProyectoHijo = null;
                    $claFormulario->seqUnidadProyecto = 1;
                    $claFormulario->txtMatriculaInmobiliaria = $arrProyecto['txtMatriculaInmobiliariaLote'];
                    $claFormulario->txtChip = $arrProyecto['txtChipLote'];
                    $claFormulario->txtDireccionSolucion = $arrProyecto['txtDireccion'];
                    break;
                case "Unidad Habitacional":
                    list($txtNombreProyecto, $txtNombreUnidad) = mb_split("/", $arrRegistro[3]);
                    $arrProyecto = array_shift(obtenerDatosTabla(
                        "t_pry_proyecto",
                        array("seqProyecto", "seqProyectoPadre", "txtNombreProyecto", "txtMatriculaInmobiliariaLote", "txtChipLote", "txtDireccion"),
                        "txtNombreProyecto",
                        "lower(rtrim(ltrim(txtNombreProyecto))) like '" . mb_strtolower(trim($txtNombreProyecto)) . "'"
                    ));
                    if (intval($arrProyecto['seqProyectoPadre']) != 0 and intval($arrProyecto['seqProyectoPadre']) != 37) {
                        $claFormulario->seqProyecto = intval($arrProyecto['seqProyectoPadre']);
                        $claFormulario->seqProyectoHijo = intval($arrProyecto['seqProyecto']);
                    } else {
                        $claFormulario->seqProyecto = intval($arrProyecto['seqProyecto']);
                        $claFormulario->seqProyectoHijo = null;
                    }
                    $arrUnidad = array_shift(obtenerDatosTabla(
                        "t_pry_unidad_proyecto",
                        array("seqUnidadProyecto", "txtNombreUnidad", "valSDVEActual"),
                        "txtNombreUnidad",
                        "lower(rtrim(ltrim(txtNombreUnidad))) like '" . mb_strtolower(trim($txtNombreUnidad)) . "' and seqProyecto = " . intval(intval($arrProyecto['seqProyecto']))
                    ));
                    $claFormulario->seqUnidadProyecto = $arrUnidad['seqUnidadProyecto'];
                    $claFormulario->txtMatriculaInmobiliaria = $arrProyecto['txtMatriculaInmobiliariaLote'];
                    $claFormulario->txtChip = $arrProyecto['txtChipLote'];
                    $claFormulario->txtDireccionSolucion = $arrProyecto['txtDireccion'];
                    $claFormulario->valAspiraSubsidio = $arrUnidad['valSDVEActual'];
                    $txtCampo = "seqUnidadProyecto";
                    $sql = "update t_pry_unidad_proyecto set seqFormulario = null where seqFormulario = " . $seqFormulario;
                    $aptBd->execute($sql);
                    break;
                case "Valor Donacion":
                    $txtCampo = "valDonacion";
                    $claFormulario->valDonacion = doubleval($arrRegistro[3]);
                    break;
                case "Soporte Donacion":
                    $txtCampo = "txtSoporteDonacion";
                    $claFormulario->txtSoporteDonacion = trim($arrRegistro[3]);
                    break;
                case "Entidad Donacion":
                    $seqEmpresaDonante = array_shift(obtenerDatosTabla(
                        "t_frm_empresa_donante",
                        array("seqEmpresaDonante", "txtEmpresaDonante"),
                        "txtEmpresaDonante",
                        "lower(ltrim(rtrim(txtEmpresaDonante))) like '" . mb_strtolower(trim($arrRegistro[3])) . "'"
                    ));
                    $txtCampo = "seqEmpresaDonante";
                    $claFormulario->seqEmpresaDonante = $seqEmpresaDonante;
                    break;
                case "Fecha de Vigencia":
                    $txtCampo = "fchVigencia";
                    $fchCorrecta = null;
                    $numTimeStamp = (($arrRegistro[3] - $this->minmDatesDiff) * $this->secInDay) + $this->secInDay;
                    if($numTimeStamp > 0){
                        $fchCorrecta = date("Y-m-d",$numTimeStamp);
                    }
                    $claFormulario->fchVigencia = $fchCorrecta;
                    break;
            }

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = $txtCampo;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = mb_strtoupper(trim($arrRegistro[2]));
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = mb_strtoupper(trim($arrRegistro[3]));

            // asignando cambios del ciudadano
            $arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano] = $claCiudadano;

        }

        foreach ($arrFormularios as $seqFormulario => $claFormulario) {
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {
                $claCiudadano->editarCiudadano($seqCiudadano);
            }
            $claFormulario->editarFormulario($seqFormulario);
        }

    }

    /**
     * APLICANDO LOS EFECTOS DE LAS RESOLUCIONES DE INHABILTIADOS
     * @param $arrArchivo
     */
    private function aplicarEfectosInhabilitados($arrArchivo)
    {
        global $aptBd;
        $arrHogares = array();
        foreach ($arrArchivo as $arrRegistro) {
            $seqFormulario = $arrRegistro[0];
            if (!isset($arrHogares[$seqFormulario])) {
                $arrHogares[$seqFormulario] = new FormularioSubsidios();
                $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);
                if (intval($arrHogares[$seqFormulario]->seqProyecto) != 0 and $arrHogares[$seqFormulario]->seqProyecto != 37) {
                    $sql = "
                        update t_frm_formulario set
                          seqProyecto = null,
                          seqProyectoHijo = null,
                          seqUnidadProyecto = null
                        where seqFormulario = $seqFormulario
                    ";
                    $aptBd->execute($sql);

                    $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
                    $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyecto";
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyecto;
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;

                    $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
                    $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyectoHijo";
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyectoHijo;
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;

                    $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
                    $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqUnidadProyecto";
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqUnidadProyecto;
                    $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;

                }
                if (intval($arrHogares[$seqFormulario]->seqUnidadProyecto) > 1) {
                    $sql = "
                        update t_pry_unidad_proyecto set 
                          seqFormulario = null 
                        where seqFormulario = $seqFormulario
                    ";
                    $aptBd->execute($sql);
                }
                $sql = "
                    update t_frm_formulario set
                        seqEstadoProceso = 8,
                        bolSancion = 1,
                        fchVigencia = null,
                        fchUltimaActualizacion = now()
                    where seqFormulario = $seqFormulario
                ";
                $aptBd->execute($sql);

                $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
                $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqEstadoProceso;
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 8;

                $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
                $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "bolSancion";
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->bolSancion;
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;

                $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
                $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchVigencia";
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->fchVigencia;
                $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;

            }
        }
    }

    /**
     * APLICANDO LOS EFECTOS DE LOS RECURSOS DE REPOSICION
     * @param $arrArchivo
     */
    private function aplicarEfectosReposicion($arrArchivo){

        $arrHogares = array();
        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            $arrHogares[$seqFormulario] = new FormularioSubsidios();
            $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);

            $seqEstadoProceso = array_shift(
                obtenerDatosTabla(
                    "v_frm_estado",
                    array("seqEstadoProceso","txtEstado"),
                    "txtEstado",
                    "ltrim(rtrim(txtEstado)) like '" . mb_strtolower(trim($arrRegistro[3])) . "'"
                )
            );

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqEstadoProceso;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = $seqEstadoProceso;

            $arrHogares[$seqFormulario]->seqEstadoProceso = $seqEstadoProceso;

        }

        foreach ($arrHogares as $seqFormulario => $claFormulario) {
            $claFormulario->editarFormulario($seqFormulario);
        }

    }

    /**
     * APLICANDO LOS EFECTOS DE LOS RECURSOS DE REPOSICION
     * @param $arrArchivo
     */
    private function aplicarEfectosNoAsignados($arrArchivo){
        global $aptBd;

        foreach ($arrArchivo as $arrRegistro) {

            // obtiene el formulario que corresponde a la cedula
            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            if(! isset($arrHogares[$seqFormulario])){
                $arrHogares[$seqFormulario] = new FormularioSubsidios();
                $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);
            }

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqEstadoProceso;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 20;
            $arrHogares[$seqFormulario]->seqEstadoProceso = 20;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchVigencia";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->fchVigencia;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->fchVigencia = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyecto;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 37;
            $arrHogares[$seqFormulario]->seqProyecto = 37;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyectoHijo";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyectoHijo;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->seqProyectoHijo = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqUnidadProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqUnidadProyecto;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;
            $arrHogares[$seqFormulario]->seqUnidadProyecto = 1;

            if (intval($arrHogares[$seqFormulario]->seqUnidadProyecto) > 1) {
                $sql = "
                    update t_pry_unidad_proyecto set 
                      seqFormulario = null 
                    where seqFormulario = $seqFormulario
                ";
                $aptBd->execute($sql);
            }


        }

        foreach ($arrHogares as $seqFormulario => $claFormulario) {
            $claFormulario->editarFormulario($seqFormulario);
        }

    }

    /**
     * APLICANDO LOS EFECTOS DE LAS RADICADOS / RESOLUCIONES DE RENUNCIA
     * @param $arrArchivo
     */
    private function aplicarEfectosRenuncia($arrArchivo)
    {
        global $aptBd;
        foreach ($arrArchivo as $arrRegistro) {

            // obtiene el formulario que corresponde a la cedula
            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            // obtiene el estado del proceso que corresponde al hogar (actual)
            $arrEstadoProceso = array_shift(obtenerDatosTabla(
                "T_FRM_FORMULARIO",
                array("seqFormulario", "seqEstadoProceso", "bolSancion", "fchVigencia", "seqProyecto", "seqProyectoHijo", "seqUnidadProyecto"),
                "seqFormulario",
                "seqFormulario = " . $seqFormulario
            ));

            // realiza la modificacion del estado (nuevo) y libera la unidad
            $sql = "
                update t_frm_formulario set
                    seqEstadoProceso = 18
                    ,fchUltimaActualizacion = NOW()
                    ,bolSancion = 1
                    ,fchVigencia = DATE_ADD(now(), INTERVAL 1 YEAR)
                    ,seqProyecto = 37
                    ,seqProyectoHijo = null
                    ,seqUnidadProyecto = 1
                where seqFormulario = " . $seqFormulario . "
            ";
            $aptBd->execute($sql);

            // libera la unidad
            if (intval($arrEstadoProceso['seqUnidadProyecto']) != 0) {
                $sql = "
                    update t_pry_unidad_proyecto set
                    seqFormulario = null
                    where seqUnidadProyecto = " . intval($arrEstadoProceso['seqUnidadProyecto']) . "
                ";
                $aptBd->execute($sql);
            }

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso['seqEstadoProceso'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 18;

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "bolSancion";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso['bolSancion'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchVigencia";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso['fchVigencia'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = date("Y-m-d H:i:s", strtotime("+ 1 year"));

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso['seqProyecto'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 37;

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyectoHijo";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso['seqProyectoHijo'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqUnidadProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso['seqUnidadProyecto'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;

        }
    }

    /**
     * APLICANDO LOS EFECTOS DE LAS NOTIFICACIONES
     * @param $arrArchivo
     */
    private function aplicarEfectosNotificacion($arrArchivo){
        $arrHogares = array();
        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            $arrHogares[$seqFormulario] = new FormularioSubsidios();
            $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->fchNotificacion;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;

            $arrHogares[$seqFormulario]->fchNotificacion = $arrRegistro[1];

        }

        foreach ($arrHogares as $seqFormulario => $claFormulario) {
            $claFormulario->editarFormulario($seqFormulario);
        }
    }

    /**
     * APLICANDO LOS EFECTOS DE LAS INDEXACIONES
     * @param $arrArchivo
     */
    private function aplicarEfectosIndexacion($arrArchivo){
        $arrHogares = array();
        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            $arrHogares[$seqFormulario] = new FormularioSubsidios();
            $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);

            $valAspiraSubsidio = $arrHogares[$seqFormulario]->valAspiraSubsidio + $arrRegistro[3];

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->valAspiraSubsidio;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = $valAspiraSubsidio;

            $arrHogares[$seqFormulario]->valAspiraSubsidio = $valAspiraSubsidio;
            $arrHogares[$seqFormulario]->fchUltimaActualizacion = date("Y-m-d H:i:s");

        }

        foreach ($arrHogares as $seqFormulario => $claFormulario) {
            $claFormulario->editarFormulario($seqFormulario);
        }
    }

    /**
     * APLICANDO LOS EFECTOS DE LAS PERDIDAS
     * @param $arrArchivo
     */
    private function aplicarEfectosPerdida($arrArchivo){
        global $aptBd;

        $arrHogares = array();
        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            $arrHogares[$seqFormulario] = new FormularioSubsidios();
            $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqEstadoProceso;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 21;
            $arrHogares[$seqFormulario]->seqEstadoProceso = 21;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "txtDireccionSolucion";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->txtDireccionSolucion;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->txtDireccionSolucion = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyecto;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 37;
            $arrHogares[$seqFormulario]->seqProyecto = 37;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyectoHijo";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyectoHijo;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->seqProyectoHijo = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqUnidadProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqUnidadProyecto;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;
            $arrHogares[$seqFormulario]->seqUnidadProyecto = 1;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchVigencia";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->fchVigencia;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->fchVigencia = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "txtMatriculaInmobiliaria";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->txtMatriculaInmobiliaria;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->txtMatriculaInmobiliaria = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "txtChip";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->txtChip;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->txtChip = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "valAvaluo";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->valAvaluo;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->valAvaluo = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "valTotal";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->valTotal;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->valTotal = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "bolSancion";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->bolSancion;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;
            $arrHogares[$seqFormulario]->bolSancion = 1;

            $arrHogares[$seqFormulario]->fchUltimaActualizacion = date("Y-m-d H:i:s");

            $sql = "update t_pry_unidad_proyecto set seqFormulario = null where seqFormulario = " . $seqFormulario;
            $aptBd->execute($sql);

        }

        foreach ($arrHogares as $seqFormulario => $claFormulario) {
            $claFormulario->editarFormulario($seqFormulario);
        }

    }

    /**
     * APLICANDO LOS EFECTOS DE LAS REVOCATORIAS
     * @param $arrArchivo
     */
    private function aplicarEfectosRevocatoria($arrArchivo){
        global $aptBd;

        $arrHogares = array();
        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            $arrHogares[$seqFormulario] = new FormularioSubsidios();
            $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqEstadoProceso;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 37;
            $arrHogares[$seqFormulario]->seqEstadoProceso = 37;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "txtDireccionSolucion";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->txtDireccionSolucion;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->txtDireccionSolucion = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyecto;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 37;
            $arrHogares[$seqFormulario]->seqProyecto = 37;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqProyectoHijo";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqProyectoHijo;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->seqProyectoHijo = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqUnidadProyecto";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqUnidadProyecto;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;
            $arrHogares[$seqFormulario]->seqUnidadProyecto = 1;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchVigencia";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->fchVigencia;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->fchVigencia = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "txtMatriculaInmobiliaria";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->txtMatriculaInmobiliaria;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->txtMatriculaInmobiliaria = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "txtChip";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->txtChip;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->txtChip = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "valAvaluo";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->valAvaluo;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->valAvaluo = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "valTotal";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->valTotal;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->valTotal = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "bolSancion";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->bolSancion;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 0;
            $arrHogares[$seqFormulario]->bolSancion = 0;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "bolCerrado";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->bolCerrado;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 0;
            $arrHogares[$seqFormulario]->bolCerrado = 0;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "txtFormulario";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->txtFormulario;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->txtFormulario = null;

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchPostulacion";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->fchPostulacion;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = null;
            $arrHogares[$seqFormulario]->fchPostulacion = null;

            $arrHogares[$seqFormulario]->fchUltimaActualizacion = date("Y-m-d H:i:s");

            $sql = "update t_pry_unidad_proyecto set seqFormulario = null where seqFormulario = " . $seqFormulario;
            $aptBd->execute($sql);

        }

        foreach ($arrHogares as $seqFormulario => $claFormulario) {
            $claFormulario->editarFormulario($seqFormulario);
        }

    }


    /**
     * APLICANDO LOS EFECTOS DE LOS RECURSOS DE EXCLUSION
     * @param $arrArchivo
     */
    private function aplicarEfectosExclusion($arrArchivo){

        $arrHogares = array();
        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            $arrHogares[$seqFormulario] = new FormularioSubsidios();
            $arrHogares[$seqFormulario]->cargarFormulario($seqFormulario);

            $seqEstadoProceso = array_shift(
                obtenerDatosTabla(
                    "v_frm_estado",
                    array("seqEstadoProceso","txtEstado"),
                    "txtEstado",
                    "ltrim(rtrim(txtEstado)) like '" . mb_strtolower(trim($arrRegistro[3])) . "'"
                )
            );

            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['comentario'] = $arrRegistro[4];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrHogares[$seqFormulario]->seqEstadoProceso;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = $seqEstadoProceso;

            $arrHogares[$seqFormulario]->seqEstadoProceso = $seqEstadoProceso;

        }

        foreach ($arrHogares as $seqFormulario => $claFormulario) {
            $claFormulario->editarFormulario($seqFormulario);
        }

    }

    /**
     * ENRUTADOR PARA LA VINVULACION DE HOGARES SEGUN EL ACTO ADMINISTRATIVO
     * @param $seqTipoActo
     * @param $arrArchivo
     */
    private function vincularHogres($arrPost, $arrArchivo)
    {
        switch ($arrPost['seqTipoActo']) {
            case 1: // asignacion
                $this->vincularHogresAsignacion($arrPost, $arrArchivo);
                break;
            case 2: // modificatorias
                $this->vincularHogresModificatoria($arrPost, $arrArchivo);
                break;
            case 3: // inhabilitados
                $this->vincularHogresInhabilitados($arrPost, $arrArchivo);
                break;
            case 4: // reposicion
                $this->vincularHogresReposicion($arrPost, $arrArchivo);
                break;
            case 5: // no asignado
                $this->vincularHogresAsignacion($arrPost, $arrArchivo); // usa la misma que asignacion
                break;
            case 6: // renuncia
                $this->vincularHogaresRenuncia($arrPost,$arrArchivo);
                break;
            case 7: // notificaciones
                $this->vincularHogaresNotificacion($arrPost,$arrArchivo);
                break;
            case 8: // indexaciones
                $this->vincularHogresIndexacion($arrPost, $arrArchivo);
                break;
            case 9: // perdida
                $this->vincularHogaresRenuncia($arrPost, $arrArchivo);
                break;
            case 10: // revocatoria
                $this->vincularHogaresRenuncia($arrPost, $arrArchivo);
                break;
            case 11: // exclusion
                $this->vincularHogaresRenuncia($arrPost, $arrArchivo);
                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                break;
        }
    }

    /**
     * VINCULACION DE HOGARES PARA ACTOS ADMINISTRATIVOS DE ASIGNACION
     * @param $arrPost
     * @param $arrArchivo
     */
    private function vincularHogresAsignacion($arrPost, $arrArchivo)
    {
        global $aptBd;

        foreach ($arrArchivo as $arrRegistro) {

            $arrHogar = array();

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);

            // cuando hay resolucion relacionada no se copia el hogar
            if ($arrRegistro[2] == "" and $arrRegistro[3] == "") {

                $arrCiudadanos = $claFormulario->arrCiudadano;
                unset($claFormulario->arrCiudadano);
                unset($claFormulario->arrErrores);

                $txtCampos = "";
                $txtValores = "";
                foreach ($claFormulario as $txtCampo => $txtValor) {
                    $txtCampos .= $txtCampo . ",";
                    $txtValores .= "'" . $txtValor . "',";
                }
                $txtCampos = rtrim($txtCampos, ",");
                $txtValores = rtrim($txtValores, ",");

                $sql = "insert into t_aad_formulario_acto (fchIngresoRegistro,valAcumuladoSubsidio,$txtCampos)values(now(),0,$txtValores)";
                $aptBd->execute($sql);
                $seqFormularioActo = $aptBd->Insert_ID();

                foreach ($arrCiudadanos as $claCiudadano) {

                    $seqParentesco = $claCiudadano->seqParentesco;
                    unset($claCiudadano->seqParentesco);
                    unset($claCiudadano->arrErrores);
                    $txtCampos = "";
                    $txtValores = "";
                    foreach ($claCiudadano as $txtCampo => $txtValor) {
                        $txtCampos .= $txtCampo . ",";
                        $txtValores .= "'" . $txtValor . "',";
                    }
                    $txtCampos = rtrim($txtCampos, ",");
                    $txtValores = rtrim($txtValores, ",");

                    $sql = "insert into t_aad_ciudadano_acto (fchIngresoRegistro,$txtCampos)values(now(),$txtValores)";
                    $aptBd->execute($sql);
                    $seqCiudadanoActo = $aptBd->Insert_ID();

                    $arrHogar[$seqFormularioActo][$seqCiudadanoActo] = $seqParentesco;

                }

                foreach ($arrHogar as $seqFormularioActo => $arrCiudadanos) {
                    foreach ($arrCiudadanos as $seqCiudadanoActo => $seqParentesco) {
                        $sql = "
                        insert into t_aad_hogar_acto (
                            seqFormularioActo, 
                            seqCiudadanoActo, 
                            seqParentesco
                        ) values(
                            " . $seqFormularioActo . ",
                            " . $seqCiudadanoActo . ",
                            " . $seqParentesco . "
                        )
                    ";
                        $aptBd->execute($sql);
                    }
                }

            } else {

                $seqFormularioActo = $this->obtenerFac($seqFormulario, $arrRegistro[2], $arrRegistro[3]);

            }

            $arrRegistro[2] = (intval($arrRegistro[2]) != 0) ? intval($arrRegistro[2]) : "NULL";
            $arrRegistro[3] = (esFechaValida($arrRegistro[3])) ? "'" . $arrRegistro[3] . "'" : "NULL";

            $sql = "
                insert into t_aad_hogares_vinculados(
                    seqFormularioActo, 
                    numActo, 
                    fchActo, 
                    seqTipoActo, 
                    numActoReferencia, 
                    fchActoReferencia
                ) VALUES (
                    " . $seqFormularioActo . ", 
                    " . $arrPost['numActo'] . ", 
                    '" . $arrPost['fchActo'] . "', 
                    " . $arrPost['seqTipoActo'] . ", 
                    " . $arrRegistro[2] . ", 
                    " . $arrRegistro[3] . "
                )
            ";
            $aptBd->execute($sql);

        }

    }

    /**
     * VINCULACION DE HOGARES PARA ACTOS ADMINISTRATIVOS MODIFICATORIAS
     * @param $arrPost
     * @param $arrArchivo
     */
    private function vincularHogresModificatoria($arrPost, $arrArchivo)
    {

        global $aptBd;

        $claCiudadano = new Ciudadano();
        $arrHogares = array();
        foreach ($arrArchivo as $numLinea => $arrRegistro) {

            $arrRegistro[0] = (mb_strtolower(trim($arrRegistro[1])) == "documento") ? $arrRegistro[3] : $arrRegistro[0];

            $seqFormulario = $claCiudadano->formularioVinculado($arrRegistro[0]);

            if (!isset($arrHogares[$seqFormulario])) {
                $arrHogares[$seqFormulario]['seqFormularioActo'] = $this->obtenerFac($seqFormulario, $arrRegistro[4], $arrRegistro[5]);
                $sql = "
                  select seqCiudadanoActo 
                  from t_aad_hogar_acto 
                  where seqParentesco = 1 
                    and seqFormularioActo = " . $arrHogares[$seqFormulario]['seqFormularioActo'];
                $objRes = $aptBd->execute($sql);
                $arrHogares[$seqFormulario]['seqCiudadanoActo'] = $objRes->fields['seqCiudadanoActo'];
            }

            $sql = "
                insert into t_aad_detalles (
                  numActo,
                  fchActo,
                  seqFormularioActo, 
                  seqCiudadanoActo, 
                  txtInhabilidad, 
                  txtCausa, 
                  txtFuente, 
                  txtCampo, 
                  txtIncorrecto, 
                  txtCorrecto, 
                  txtEstadoReposicion, 
                  valIndexacion
                ) values (
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $arrHogares[$seqFormulario]['seqFormularioActo'] . ",
                  " . $arrHogares[$seqFormulario]['seqCiudadanoActo'] . ",
                  NULL,
                  NULL,
                  NULL,
                  '" . trim($arrRegistro[1]) . "',
                  '" . trim($arrRegistro[2]) . "',
                  '" . trim($arrRegistro[3]) . "',
                  NULL,
                  NULL
                ) 
            ";
            $aptBd->execute($sql);

        }

        foreach ($arrHogares as $seqFormulario => $arrDato) {

            $sql = "
                insert into t_aad_hogares_vinculados (
                  seqFormularioActo, 
                  numActo, 
                  fchActo, 
                  seqTipoActo, 
                  numActoReferencia, 
                  fchActoReferencia
                )values(
                  " . $arrDato['seqFormularioActo'] . ",
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $arrPost['seqTipoActo'] . ",
                  " . $arrRegistro[4] . ",
                  '" . $arrRegistro[5] . "'
                ) 
            ";
            $aptBd->execute($sql);

            // actualizando formulario acto
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $sql = "update t_aad_formulario_acto set ";
            foreach ($claFormulario as $txtCampo => $txtValor) {
                if ($txtCampo != "arrCiudadano" and $txtCampo != "arrErrores") {
                    $txtValor = (trim($txtValor) != "") ? "'" . $txtValor . "'" : "NULL";
                    $sql .= "$txtCampo = $txtValor,";
                }
            }
            $sql = rtrim($sql, ",");
            $sql .= " where seqFormularioActo = " . $arrDato['seqFormularioActo'];
            $aptBd->execute($sql);

            // actualizando ciudadano acto
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {
                if ($claCiudadano->seqParentesco == 1) {
                    $sql = "update t_aad_ciudadano_acto set ";
                    foreach ($claCiudadano as $txtCampo => $txtValor) {
                        if ($txtCampo != "arrErrores") {
                            $txtValor = (trim($txtValor) != "") ? "'" . $txtValor . "'" : "NULL";
                            $sql .= "$txtCampo = $txtValor,";
                        }
                    }
                    $sql = rtrim($sql, ",");
                    $sql .= " where seqCiudadanoActo = " . $arrDato['seqCiudadanoActo'];
                    $aptBd->execute($sql);
                }
            }


        }

    }

    /**
     * VINCULACION DE HOGARES PARA ACTOS ADMINISTRATIVOS MODIFICATORIAS
     * @param $arrPost
     * @param $arrArchivo
     */
    private function vincularHogresInhabilitados($arrPost, $arrArchivo)
    {
        global $aptBd;

        $arrHogares = array();
        foreach ($arrArchivo as $arrRegistro) {
            $seqFormulario = $arrRegistro[0];
            if (!isset($arrHogares[$seqFormulario])) {
                $arrHogares[$seqFormulario] = new FormularioSubsidios();
                $arrHogares[$seqFormulario]->cargarformulario($seqFormulario);
            }
        }

        $arrHogaresAAD = array();
        $arrEquivalente = array();
        foreach ($arrHogares as $seqFormulario => $claFormulario) {

            $arrCiudadanos = $claFormulario->arrCiudadano;
            unset($claFormulario->arrCiudadano);
            unset($claFormulario->arrErrores);

            $txtCampos = "";
            $txtValores = "";
            foreach ($claFormulario as $txtCampo => $txtValor) {
                $txtCampos .= $txtCampo . ",";
                $txtValores .= "'" . $txtValor . "',";
            }
            $txtCampos = rtrim($txtCampos, ",");
            $txtValores = rtrim($txtValores, ",");

            $sql = "insert into t_aad_formulario_acto (fchIngresoRegistro,valAcumuladoSubsidio,$txtCampos)values(now(),0,$txtValores)";
            $aptBd->execute($sql);
            $seqFormularioActo = $aptBd->Insert_ID();

            $arrEquivalente[$seqFormulario]['fac'] = $seqFormularioActo;

            foreach ($arrCiudadanos as $claCiudadano) {

                $seqParentesco = $claCiudadano->seqParentesco;
                unset($claCiudadano->seqParentesco);
                unset($claCiudadano->arrErrores);
                $txtCampos = "";
                $txtValores = "";
                foreach ($claCiudadano as $txtCampo => $txtValor) {
                    $txtCampos .= $txtCampo . ",";
                    $txtValores .= "'" . $txtValor . "',";
                }
                $txtCampos = rtrim($txtCampos, ",");
                $txtValores = rtrim($txtValores, ",");

                $sql = "insert into t_aad_ciudadano_acto (fchIngresoRegistro,$txtCampos)values(now(),$txtValores)";
                $aptBd->execute($sql);
                $seqCiudadanoActo = $aptBd->Insert_ID();

                $arrHogaresAAD[$seqFormularioActo][$seqCiudadanoActo] = $seqParentesco;

                $numDocumento = $claCiudadano->numDocumento;
                $arrEquivalente[$seqFormulario]['cac'][$numDocumento] = $seqCiudadanoActo;

            }

            foreach ($arrHogaresAAD[$seqFormularioActo] as $seqCiudadanoActo => $seqParentesco) {
                $sql = "
                    insert into t_aad_hogar_acto (
                        seqFormularioActo, 
                        seqCiudadanoActo, 
                        seqParentesco
                    ) values(
                        " . $seqFormularioActo . ",
                        " . $seqCiudadanoActo . ",
                        " . $seqParentesco . "
                    )
                ";
                $aptBd->execute($sql);
            }

            $sql = "
                insert into t_aad_hogares_vinculados (
                  seqFormularioActo, 
                  numActo, 
                  fchActo, 
                  seqTipoActo, 
                  numActoReferencia, 
                  fchActoReferencia
                ) values (
                  $seqFormularioActo,
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  '" . $arrPost['seqTipoActo'] . "',
                  NULL,
                  NULL
                ) 
            ";
            $aptBd->execute($sql);

        }

        foreach ($arrArchivo as $arrRegistro) {
            $seqFormulario = $arrRegistro[0];
            $numDocumento = $arrRegistro[1];
            $sql = "
                insert into t_aad_detalles(
                  numActo,
                  fchActo,
                  seqFormularioActo, 
                  seqCiudadanoActo, 
                  txtInhabilidad, 
                  txtCausa, 
                  txtFuente, 
                  txtCampo, 
                  txtIncorrecto, 
                  txtCorrecto, 
                  txtEstadoReposicion, 
                  valIndexacion
                ) values (
                  " . $arrPost['numActo'] . "        
                  '" . $arrPost['fchActo'] . "',        
                  " . $arrEquivalente[$seqFormulario]['fac'] . ",
                  " . $arrEquivalente[$seqFormulario]['cac'][$numDocumento] . ",
                  '" . mb_strtoupper($arrRegistro[5]) . "',
                  '" . mb_strtoupper($arrRegistro[4]) . "',
                  '" . mb_strtoupper($arrRegistro[3]) . "',
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  NULL
                )
            ";
            $aptBd->execute($sql);
        }


    }

    /**
     * VINCULACION DE HOGARES PARA RECURSOS DE REPOSICION
     * @param $arrPost
     * @param $arrArchivo
     */
    private function vincularHogresReposicion($arrPost, $arrArchivo){
        global $aptBd;

        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[1],$arrRegistro[2]);

            $sql = "
                  select seqCiudadanoActo 
                  from t_aad_hogar_acto 
                  where seqParentesco = 1 
                    and seqFormularioActo = " . $seqFormularioActo;
            $objRes = $aptBd->execute($sql);
            $seqCiudadanoActo = $objRes->fields['seqCiudadanoActo'];

            $sql = "
                insert into t_aad_detalles (
                  numActo,
                  fchActo,
                  seqFormularioActo, 
                  seqCiudadanoActo, 
                  txtInhabilidad, 
                  txtCausa, 
                  txtFuente, 
                  txtCampo, 
                  txtIncorrecto, 
                  txtCorrecto, 
                  txtEstadoReposicion, 
                  valIndexacion
                ) values (
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $seqFormularioActo . ",
                  " . $seqCiudadanoActo . ",
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  '" . $arrRegistro[3] . "',
                  NULL
                ) 
            ";
            $aptBd->execute($sql);

            $sql = "
                insert into t_aad_hogares_vinculados (
                  seqFormularioActo, 
                  numActo, 
                  fchActo, 
                  seqTipoActo, 
                  numActoReferencia, 
                  fchActoReferencia
                )values(
                  " . $seqFormularioActo . ",
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $arrPost['seqTipoActo'] . ",
                  " . $arrRegistro[1] . ",
                  '" . $arrRegistro[2] . "'
                ) 
            ";
            $aptBd->execute($sql);

            // actualizando formulario acto
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $sql = "update t_aad_formulario_acto set ";
            foreach ($claFormulario as $txtCampo => $txtValor) {
                if ($txtCampo != "arrCiudadano" and $txtCampo != "arrErrores") {
                    $txtValor = (trim($txtValor) != "") ? "'" . $txtValor . "'" : "NULL";
                    $sql .= "$txtCampo = $txtValor,";
                }
            }
            $sql = rtrim($sql, ",");
            $sql .= " where seqFormularioActo = " . $seqFormularioActo;
            $aptBd->execute($sql);

            // actualizando ciudadano acto
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {
                if ($claCiudadano->seqParentesco == 1) {
                    $sql = "update t_aad_ciudadano_acto set ";
                    foreach ($claCiudadano as $txtCampo => $txtValor) {
                        if ($txtCampo != "arrErrores") {
                            $txtValor = (trim($txtValor) != "") ? "'" . $txtValor . "'" : "NULL";
                            $sql .= "$txtCampo = $txtValor,";
                        }
                    }
                    $sql = rtrim($sql, ",");
                    $sql .= " where seqCiudadanoActo = " . $seqCiudadanoActo;
                    $aptBd->execute($sql);
                }
            }

        }

    }

    /**
     * VINCULACION DE HOGARES PARA NO ASIGNADOS
     * @param $arrPost
     * @param $arrArchivo
     */
    private function vincularHogaresRenuncia($arrPost, $arrArchivo){
        global $aptBd;

        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[1],$arrRegistro[2]);

            $sql = "
                insert into t_aad_hogares_vinculados (
                  seqFormularioActo, 
                  numActo, 
                  fchActo, 
                  seqTipoActo, 
                  numActoReferencia, 
                  fchActoReferencia
                )values(
                  " . $seqFormularioActo . ",
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $arrPost['seqTipoActo'] . ",
                  " . $arrRegistro[1] . ",
                  '" . $arrRegistro[2] . "'
                ) 
            ";
            $aptBd->execute($sql);

            // actualizando formulario acto
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $sql = "update t_aad_formulario_acto set ";
            foreach ($claFormulario as $txtCampo => $txtValor) {
                if ($txtCampo != "arrCiudadano" and $txtCampo != "arrErrores") {
                    $txtValor = (trim($txtValor) != "") ? "'" . $txtValor . "'" : "NULL";
                    $sql .= "$txtCampo = $txtValor,";
                }
            }
            $sql = rtrim($sql, ",");
            $sql .= " where seqFormularioActo = " . $seqFormularioActo;
            $aptBd->execute($sql);

        }

    }

    /**
     * VINCULACION DE HOGARES PARA NOTIFICACIONES
     * @param $arrPost
     * @param $arrArchivo
     */
    private function vincularHogaresNotificacion($arrPost, $arrArchivo){
        global $aptBd;

        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[2],$arrRegistro[3]);

            $sql = "
                insert into t_aad_hogares_vinculados (
                  seqFormularioActo, 
                  numActo, 
                  fchActo, 
                  seqTipoActo, 
                  numActoReferencia, 
                  fchActoReferencia
                )values(
                  " . $seqFormularioActo . ",
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $arrPost['seqTipoActo'] . ",
                  " . $arrRegistro[2] . ",
                  '" . $arrRegistro[3] . "'
                ) 
            ";
            $aptBd->execute($sql);

            // actualizando formulario acto
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $sql = "update t_aad_formulario_acto set ";
            foreach ($claFormulario as $txtCampo => $txtValor) {
                if ($txtCampo != "arrCiudadano" and $txtCampo != "arrErrores") {
                    $txtValor = (trim($txtValor) != "") ? "'" . $txtValor . "'" : "NULL";
                    $sql .= "$txtCampo = $txtValor,";
                }
            }
            $sql = rtrim($sql, ",");
            $sql .= " where seqFormularioActo = " . $seqFormularioActo;
            $aptBd->execute($sql);

        }

    }

    /**
     * VINCULACION DE HOGARES PARA INDEXACION
     * @param $arrPost
     * @param $arrArchivo
     */
    private function vincularHogresIndexacion($arrPost, $arrArchivo){
        global $aptBd;

        foreach($arrArchivo as $arrRegistro){

            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);
            $seqFormularioActo = $this->obtenerFac($seqFormulario,$arrRegistro[1],$arrRegistro[2]);

            $sql = "
                  select seqCiudadanoActo 
                  from t_aad_hogar_acto 
                  where seqParentesco = 1 
                    and seqFormularioActo = " . $seqFormularioActo;
            $objRes = $aptBd->execute($sql);
            $seqCiudadanoActo = $objRes->fields['seqCiudadanoActo'];

            $sql = "
                insert into t_aad_detalles (
                  numActo,
                  fchActo,
                  seqFormularioActo, 
                  seqCiudadanoActo, 
                  txtInhabilidad, 
                  txtCausa, 
                  txtFuente, 
                  txtCampo, 
                  txtIncorrecto, 
                  txtCorrecto, 
                  txtEstadoReposicion, 
                  valIndexacion
                ) values (
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $seqFormularioActo . ",
                  " . $seqCiudadanoActo . ",
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  NULL,
                  " . $arrRegistro[3] . "
                ) 
            ";
            $aptBd->execute($sql);

            $sql = "
                insert into t_aad_hogares_vinculados (
                  seqFormularioActo, 
                  numActo, 
                  fchActo, 
                  seqTipoActo, 
                  numActoReferencia, 
                  fchActoReferencia
                )values(
                  " . $seqFormularioActo . ",
                  " . $arrPost['numActo'] . ",
                  '" . $arrPost['fchActo'] . "',
                  " . $arrPost['seqTipoActo'] . ",
                  " . $arrRegistro[1] . ",
                  '" . $arrRegistro[2] . "'
                ) 
            ";
            $aptBd->execute($sql);

            // actualizando formulario acto
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);
            $sql = "update t_aad_formulario_acto set ";
            foreach ($claFormulario as $txtCampo => $txtValor) {
                if ($txtCampo != "arrCiudadano" and $txtCampo != "arrErrores") {
                    $txtValor = (trim($txtValor) != "") ? "'" . $txtValor . "'" : "NULL";
                    $sql .= "$txtCampo = $txtValor,";
                }
            }
            $sql = rtrim($sql, ",");
            $sql .= " where seqFormularioActo = " . $seqFormularioActo;
            $aptBd->execute($sql);

        }

    }

    /**
     * OBTIENE LA INFORMACION DEL ARCHIVO CARGADO EN FORMATO EXCEL O TXT
     * @param $arrPost
     * @return array
     */
    public function cargarArchivo($bolVerificarCreador = false)
    {
        $arrArchivo = array();

        // valida si el archivo fue cargado y si corresponde a las extensiones válidas
        switch ($_FILES['archivo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->arrErrores[] = "Debe especificar un archivo para cargar";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo cargar por falta de carpeta temporal, contacte al administrador";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor, contacte al administrador";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor por un problema de extensiones, contacte al administrador";
                break;
            default:
                $numPunto = strpos($_FILES['archivo']['name'], ".") + 1;
                $numRestar = (strlen($_FILES['archivo']['name']) - $numPunto) * -1;
                $txtExtension = substr($_FILES['archivo']['name'], $numRestar);
                if (!in_array(strtolower($txtExtension), $this->arrExtensiones)) {
                    $this->arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
                }
                break;
        }

        if (empty($this->arrErrores)) {

            // si es un archivo de texto obtiene los datos
            if ($_FILES['archivo']['type'] == "text/plain") {
                foreach (file($_FILES['archivo']['tmp_name']) as $numLinea => $txtLinea) {
                    if (trim($txtLinea) != "") {
                        $arrArchivo[$numLinea] = explode("\t", trim(utf8_encode($txtLinea)));
                    }
                }
            } else {

                try {

                    // crea las clases para la obtencion de los datos
                    $txtTipoArchivo = PHPExcel_IOFactory::identify($_FILES['archivo']['tmp_name']);
                    $objReader = PHPExcel_IOFactory::createReader($txtTipoArchivo);
                    $objPHPExcel = $objReader->load($_FILES['archivo']['tmp_name']);
                    $objHoja = $objPHPExcel->getSheet(0);

                    // obtiene las dimensiones del archivo para la obtencion del contenido por rangos
                    $numFilas = $objHoja->getHighestRow();
                    $numColumnas = PHPExcel_Cell::columnIndexFromString($objHoja->getHighestColumn()) - 1;

                    // obtiene los datos del rango obtenido
                    for ($numFila = 1; $numFila <= $numFilas; $numFila++) {
                        for ($numColumna = 0; $numColumna <= $numColumnas; $numColumna++) {
                            $numFilaArreglo = $numFila - 1;
                            $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                        }
                    }

                    // si no tiene la celda de clave llena no carga
                    if ($bolVerificarCreador == true) {
                        if ($objPHPExcel->getProperties()->getCreator() != $this->txtCreador) {
                            $this->arrErrores[] = "No se va a cargar el archivo porque no corresponde a la plantilla que se obtiene de la aplicación";
                        }
                    }

                    if (empty($this->arrErrores)) {

                        // limpia las lineas vacias
                        foreach ($arrArchivo as $numLinea => $arrLinea) {
                            $bolLineaVacia = true;
                            foreach ($arrLinea as $numColumna => $txtCelda) {
                                if ($txtCelda != "") {
                                    $bolLineaVacia = false;
                                    $arrArchivo[$numLinea][$numColumna] = trim($txtCelda);
                                }
                            }
                            if ($bolLineaVacia == true) {
                                unset($arrArchivo[$numLinea]);
                            }
                        }
                    }

                } catch (Exception $objError) {
                    $this->arrErrores[] = $objError->getMessage();
                }

            }
        }

        return $arrArchivo;
    }

    /**
     * Obtiene los proyectos que tengan unidades habitacionales
     */
    public function proyectos()
    {
        global $aptBd;

        // Obtiene los proyectos que tengan unidades habitacionales
        try {
            $sql = "
                select
                    pry.seqProyecto,
                    pry.txtNombreProyecto
                from t_pry_proyecto pry
                inner join t_pry_unidad_proyecto upr on pry.seqProyecto = upr.seqProyecto
                where (pry.seqProyectoPadre is null or pry.seqProyectoPadre = 0)
                  and upr.seqUnidadProyecto is not null
                union
                select distinct
                    (select seqProyecto from t_pry_proyecto where seqProyecto = pry1.seqProyectoPadre) as seqProyecto,
                    (select txtNombreProyecto from t_pry_proyecto where seqProyecto = pry1.seqProyectoPadre) as txtNombreProyecto
                from t_pry_proyecto pry1
                inner join t_pry_unidad_proyecto upr1 on pry1.seqProyecto = upr1.seqProyecto
                where pry1.seqProyectoPadre is not null
                order by txtNombreProyecto
            ";
            return $aptBd->GetAll($sql);
        } catch (Exception $objError) {
            return array();
        }

    }

    /**
     * obtiene el identificador del formulario-acto
     * @param $seqFormulario
     * @param $numResolucion
     * @param $fchResolucion
     */
    private function obtenerFac($seqFormulario, $numResolucion, $fchResolucion)
    {
        global $aptBd;
        $seqFormularioActo = 0;
        $sql = "
            select hvi.seqFormularioActo
            from t_aad_hogares_vinculados hvi
            inner join t_aad_formulario_acto fac on hvi.seqFormularioActo = fac.seqFormularioActo
            where hvi.numActo = $numResolucion
              and hvi.fchActo = '$fchResolucion'
              and fac.seqFormulario = $seqFormulario
        ";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $seqFormularioActo = $objRes->fields['seqFormularioActo'];
        }
        return $seqFormularioActo;
    }

    public function obtenerProcesos($seqFormulario){
        global $aptBd;
        $sql = "
            select
                fac.seqFormulario,
                hvi.seqTipoActo,
                hvi.numActo,
                hvi.fchActo,
                hvi.seqFormularioActo,
                hvi.numActoReferencia,
                hvi.fchActoReferencia
            from t_aad_hogares_vinculados hvi
            inner join t_aad_formulario_acto fac on hvi.seqFormularioActo = fac.seqFormularioActo
            where fac.seqFormulario in ($seqFormulario)
            order by fac.seqFormulario, hvi.fchActo
        ";
        $objRes = $aptBd->execute($sql);
        $arrProcesos = array();
        $seqFormularioAnterior = 0;
        while($objRes->fields){

            $seqFormulario     = $objRes->fields['seqFormulario'];
            $seqFormularioActo = $objRes->fields['seqFormularioActo'];

            if( in_array( $objRes->fields['seqTipoActo'] , array(1,3,5) ) or $seqFormularioAnterior != $seqFormulario ){
                $seqFormularioAnterior = $seqFormulario;
                $txtActoProceso = $objRes->fields['numActo'] . "/" . $objRes->fields['fchActo'];
                $arrProcesos[$txtActoProceso]['cabeza'] = $seqFormularioActo;
            }else{
                $txtActoRelacionado = $objRes->fields['numActo'] . "/" . $objRes->fields['fchActo'];
                $arrProcesos[$txtActoProceso]['relacionado'][$txtActoRelacionado]['seqFormularioActo'] = $seqFormularioActo;
                $arrProcesos[$txtActoProceso]['relacionado'][$txtActoRelacionado]['seqTipoActo'] = $objRes->fields['seqTipoActo'];
            }

            $objRes->MoveNext();
        }


        return $arrProcesos;
    }

    /**
     * ACTUALIZACION DESDE EL FORMULARIO DE POSTULACION
     * @param $seqFormularioActo
     * @param $arrPost
     */
    public function actualizarFac($seqFormularioActo, $arrPost){
        global $aptBd;

        $arrErrores = array();
        $arrHogarPost = $arrPost['hogar'];

        // variables del formulario que no aplican para actualizacion
        unset($arrPost['hogar']);
        unset($arrPost['arrErrores']);
        unset($arrPost['seqGrupoGestion']);
        unset($arrPost['seqGestion']);
        unset($arrPost['txtComentario']);
        unset($arrPost['bolInformal']);
        unset($arrPost['seqCasaMano']);
        unset($arrPost['cedula']);
        unset($arrPost['txtFase']);
        unset($arrPost['txtFlujo']);
        unset($arrPost['txtArchivo']);
        unset($arrPost['nombre']);
        unset($arrPost['bolBorrar']);

        try{

            $aptBd->BeginTrans();

            $sql = "update t_aad_formulario_acto set ";
            foreach($arrPost as $txtCampo => $txtValor){
                $txtValor = regularizarCampo($txtCampo,$txtValor);
                if($txtValor === null){
                    $txtValor = "null";
                }else{
                    $txtValor = "'$txtValor'";
                }
                $sql .= "$txtCampo = $txtValor,";
            }
            $sql = rtrim($sql,",");
            $sql .= " where seqFormularioActo = $seqFormularioActo";
            $aptBd->execute($sql);

            $sql = "
                select cac.seqCiudadanoActo, cac.numDocumento
                from t_aad_ciudadano_acto cac
                inner join t_aad_hogar_acto hac on cac.seqCiudadanoActo = hac.seqCiudadanoActo
                where hac.seqFormularioActo = $seqFormularioActo
            ";
            $arrHogarActo = $aptBd->GetAll($sql);
            foreach($arrHogarActo as $i => $arrCiudadanoActo){
                $numDocumentoActo = $arrCiudadanoActo['numDocumento'];
                if(isset($arrHogarPost[$numDocumentoActo])){
                    $seqParentesco = $arrHogarPost[$numDocumentoActo]['seqParentesco'];
                    unset($arrHogarPost[$numDocumentoActo]['seqParentesco']);
                    $sql = "update t_aad_ciudadano_acto set ";
                    foreach($arrHogarPost[$numDocumentoActo] as $txtCampo => $txtValor){
                        $txtValor = regularizarCampo($txtCampo,$txtValor);
                        if($txtValor === null){
                            $txtValor = "null";
                        }else{
                            $txtValor = "'$txtValor'";
                        }
                        $sql .= "$txtCampo = $txtValor,";
                    }
                    $sql = rtrim($sql,",");
                    $sql .= " where seqCiudadanoActo = " . $arrCiudadanoActo['seqCiudadanoActo'];
                    $aptBd->execute($sql);

                    $sql = "update t_aad_hogar_acto set ";
                    $sql.= "seqParentesco = $seqParentesco ";
                    $sql.= "where seqFormularioActo = $seqFormularioActo and seqCiudadanoActo = " . $arrCiudadanoActo['seqCiudadanoActo'];
                    $aptBd->execute($sql);

                    unset($arrHogarPost[$numDocumentoActo]);
                    unset($arrHogarActo[$i]);
                }
            }

            // ciudadanos adicionados
            foreach($arrHogarPost as $arrCiudadanoAdicion){

                $seqParentesco = $arrCiudadanoAdicion['seqParentesco'];
                unset($arrCiudadanoAdicion['seqParentesco']);

                $seqCiudadano = Ciudadano::ciudadanoExiste($arrCiudadanoAdicion['seqTipoDocumento'], $arrCiudadanoAdicion['numDocumento']);

                $txtCampos = "";
                foreach($arrCiudadanoAdicion as $txtCampo => $txtValor){
                    $txtValor = regularizarCampo($txtCampo,$txtValor);
                    if($txtValor === null){
                        $txtValor = "null";
                    }else{
                        $txtValor = "'$txtValor'";
                    }
                    $txtValores .= "$txtValor,";
                    $txtCampos .= "$txtCampo,";
                }
                $txtCampos = rtrim($txtCampos,",");
                $txtValores = rtrim($txtValores,",");

                $sql = "insert into t_aad_ciudadano_acto (seqCiudadano, $txtCampos) values ($seqCiudadano, $txtValores)";
                $aptBd->execute($sql);

                $seqCiudadanoActo = $aptBd->Insert_ID();

                $sql = "insert into t_aad_hogar_acto (seqFormularioActo, seqCiudadanoActo, seqParentesco) values ($seqFormularioActo,$seqCiudadanoActo,$seqParentesco)";
                $aptBd->execute($sql);

            }

            // ciudadanos eliminados
            foreach($arrHogarActo as $arrCiudadanoActo){
                $sql = "delete from t_aad_detalles where seqCiudadanoActo = " . $arrCiudadanoActo['seqCiudadanoActo'];
                $aptBd->execute($sql);
                $sql = "delete from t_aad_hogar_acto where seqCiudadanoActo = " . $arrCiudadanoActo['seqCiudadanoActo'];
                $aptBd->execute($sql);
                $sql = "delete from t_aad_ciudadano_acto where seqCiudadanoActo = " . $arrCiudadanoActo['seqCiudadanoActo'];
                $aptBd->execute($sql);
            }


            $aptBd->CommitTrans();

        } catch (Exception $objError){

            $aptBd->Rollbacktrans();

            $arrErrores[] = "Hubo problemas al sincronizar el acto administrativo";
            $arrErrores[] = $objError->getMessage();

        }

        return $arrErrores;
    }



}


?>
