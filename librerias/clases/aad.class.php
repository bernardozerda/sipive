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
        $this->arrCambiosAplicados = array();
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
    public function listarActos($seqTipoActo = 0, $numActo = 0, $fchActo = null, $arrDocumentos = array())
    {
        global $aptBd;
        $arrListado = array();
        $txtCondicion = ($seqTipoActo == 0) ? "" : " AND hvi.seqTipoActo = " . $seqTipoActo;
        $txtCondicion .= ($numActo == 0) ? "" : " AND hvi.numActo = " . $numActo;
        $txtCondicion .= ($fchActo == null) ? "" : " AND hvi.fchActo = '" . $fchActo . "'";
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
               hvi.seqTipoActo, 
               hvi.fchActo
            ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $seqTipoActo = $objRes->fields['seqTipoActo'];
                $numActo = $objRes->fields['numActo'];
                $fchActo = $objRes->fields['fchActo'];

                $txtClave = $objRes->fields['numActo'] . strtotime($objRes->fields['fchActo']);

                $arrListado[$seqTipoActo]['listado'][$txtClave]['numero'] = $numActo;
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
     * @param $numActo
     * @param $fchActo
     * @param $txtMotivo
     */
    public function eliminar($numActo, $fchActo, $txtMotivo)
    {
        global $aptBd;

        // determina si el acto administrativo tiene giros
        $sql = "
            select
                hvi.numActo,
                hvi.fchActo,
                sum(gir.valSolicitado) as valGiros
            from t_aad_hogares_vinculados hvi
            left join t_aad_giro gir on hvi.seqFormularioActo = gir.seqFormularioActo
            where hvi.numActo = " . $numActo . "
            and hvi.fchActo = '" . $fchActo . "'
            group by
                hvi.numActo,
                hvi.fchActo
        ";
        $arrGiros = $aptBd->GetAll($sql);
        if (doubleval($arrGiros[0]['valGiros']) == 0) {

            $aptBd->BeginTrans();

            try {

                // consulta la informacion relacionada con el acto
                $sql = "
                    select
                    hac.seqFormularioActo,
                    hac.seqCiudadanoActo
                    from t_aad_hogares_vinculados hvi
                    inner join t_aad_hogar_acto hac on hvi.seqFormularioActo = hac.seqFormularioActo
                    where hvi.numActo = " . $numActo . "
                    and hvi.fchActo = '" . $fchActo . "'
                ";
                $objRes = $aptBd->execute($sql);
                while ($objRes->fields) {
                    $arrFormularioActo[] = $objRes->fields['seqFormularioActo'];
                    $arrCiudadanoActo[] = $objRes->fields['seqCiudadanoActo'];
                    $objRes->MoveNext();
                }

                // elimina los hogares
                if (!empty($arrFormularioActo)) {
                    $sql = "
                    delete 
                    from t_aad_hogar_acto 
                    where seqFormularioActo in (" . implode(",", $arrFormularioActo) . ")
                ";
                    $aptBd->execute($sql);
                }

                // elimina los vinculados
                if (!empty($arrFormularioActo)) {
                    $sql = "
                    delete 
                    from t_aad_hogares_vinculados 
                    where seqFormularioActo in (" . implode(",", $arrFormularioActo) . ")
                ";
                    $aptBd->execute($sql);
                }

                // elimina los ciudadnos vinculados
                if (!empty($arrCiudadanoActo)) {
                    $sql = "
                    delete 
                    from t_aad_ciudadano_acto 
                    where seqCiudadanoActo in (" . implode(",", $arrCiudadanoActo) . ")
                ";
                    $aptBd->execute($sql);
                }

                // elimina los formularios
                if (!empty($arrFormularioActo)) {
                    $sql = "
                    delete 
                    from t_aad_formulario_acto 
                    where seqFormularioActo in (" . implode(",", $arrFormularioActo) . ")
                ";
                    $aptBd->execute($sql);
                }

                // elimina el acto administrativo
                $sql = "
                    delete 
                    from t_aad_acto_administrativo
                    where numActo = " . $numActo . "
                    and fchActo = '" . $fchActo . "'
                ";
                $aptBd->execute($sql);

                // Registro de las actividades
                $claRegistroActividades = new RegistroActividades();
                $claRegistroActividades->registrarActividad(
                    "Borrado",
                    145,
                    $_SESSION['seqUsuario'],
                    "AAD " . $numActo . " del " . $fchActo . ": " . $txtMotivo
                );

                $aptBd->CommitTrans();

            } catch (Exception $objError) {
                $this->arrErrores[] = "Problemas al eliminar el acto adminsitrativo, no se borró ningpun registro";
                //$this->arrErrores[] = $objError->getMessage();
                $aptBd->RollbackTrans();
            }
        } else {
            $this->arrErrores[] = "No puede eliminar el Acto Administrativo " . $numActo . " del " . $fchActo . " porque tiene giros asociados";
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
            $this->numActo = $objRes->fields['numActo'];
            $this->fchActo = $objRes->fields['fchActo'];
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
                $this->arrCaracteristicas['numActoRelacionado'] = intval($arrCaracteristicas[4]);
                $this->arrCaracteristicas['fchActoRelacionado'] = $arrCaracteristicas[7];
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
                $this->arrCaracteristicas['numActoRelacionado'] = intval($arrCaracteristicas[148]);
                $this->arrCaracteristicas['fchActoRelacionado'] = $arrCaracteristicas[149];
                break;
            case 8: // indexaciones
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[31];
                $this->arrCaracteristicas['numCdp'][1] = intval($arrCaracteristicas[32]);
                $this->arrCaracteristicas['valCdp'][1] = doubleval($arrCaracteristicas[33]);
                $this->arrCaracteristicas['fchCdp'][1] = $arrCaracteristicas[34];
                $this->arrCaracteristicas['numVigCdp'][1] = $arrCaracteristicas[164];
                $this->arrCaracteristicas['numRp'][1] = intval($arrCaracteristicas[35]);
                $this->arrCaracteristicas['valRp'][1] = doubleval($arrCaracteristicas[36]);
                $this->arrCaracteristicas['fchRp'][1] = $arrCaracteristicas[37];
                $this->arrCaracteristicas['numVigRp'][1] = $arrCaracteristicas[165];
                $this->arrCaracteristicas['numPry'][1] = intval($arrCaracteristicas[38]);
                $this->arrCaracteristicas['numCdp'][2] = intval($arrCaracteristicas[93]);
                $this->arrCaracteristicas['valCdp'][2] = doubleval($arrCaracteristicas[94]);
                $this->arrCaracteristicas['fchCdp'][2] = $arrCaracteristicas[95];
                $this->arrCaracteristicas['numVigCdp'][2] = $arrCaracteristicas[166];
                $this->arrCaracteristicas['numRp'][2] = intval($arrCaracteristicas[96]);
                $this->arrCaracteristicas['valRp'][2] = doubleval($arrCaracteristicas[97]);
                $this->arrCaracteristicas['fchRp'][2] = $arrCaracteristicas[98];
                $this->arrCaracteristicas['numVigRp'][2] = $arrCaracteristicas[167];
                $this->arrCaracteristicas['numPry'][2] = intval($arrCaracteristicas[163]);
                $this->arrCaracteristicas['numActoRelacionado'] = intval($arrCaracteristicas[144]);
                $this->arrCaracteristicas['fchActoRelacionado'] = $arrCaracteristicas[145];
                break;
            case 9: // perdida
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[99];
                $this->arrCaracteristicas['numActoRelacionado'] = intval($arrCaracteristicas[49]);
                $this->arrCaracteristicas['fchActoRelacionado'] = $arrCaracteristicas[50];
                break;
            case 10: // revocatoria
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[146];
                $this->arrCaracteristicas['numActoRelacionado'] = intval($arrCaracteristicas[91]);
                $this->arrCaracteristicas['fchActoRelacionado'] = $arrCaracteristicas[92];
                break;
            case 11: // exclusion
                $this->arrCaracteristicas['txtResolucion'] = $arrCaracteristicas[147];
                $this->arrCaracteristicas['numActoRelacionado'] = intval($arrCaracteristicas[140]);
                $this->arrCaracteristicas['fchActoRelacionado'] = $arrCaracteristicas[141];
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
                      UCWORDS( CONCAT(
                         TRIM( cac.txtNombre1 ),
                         ' ',
                         IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                         TRIM( cac.txtApellido1 ),
                         ' ',
                         TRIM( cac.txtApellido2 )
                      ) ) AS 'Nombre',
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
                     AND hvi.fchActo = '" . $this->fchActo . "'
                   ORDER BY cac.numDocumento
                ";
                break;
            case 2: // modificatorias
                $sql = "
                    SELECT
                        hac.seqHogarActo as 'Hogar Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        UPPER( 
                        CONCAT(
                        TRIM( cac.txtNombre1 ),
                        ' ',
                        IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                        TRIM( cac.txtApellido1 ),
                        ' ',
                        TRIM( cac.txtApellido2 )
                        ) 
                        ) AS 'Nombre',
                        hac.txtCampo as 'Campo',
                        hac.txtIncorrecto as 'Incorrecto',
                        hac.txtCorrecto as 'Correcto',
                        hvi.numActoReferencia as 'Acto Referencia',
                        hvi.fchActoReferencia as 'Fecha Referencia'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    WHERE hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo . "'
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
                  UPPER( 
                  CONCAT(
                     TRIM( cac.txtNombre1 ),
                     ' ',
                     IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                     TRIM( cac.txtApellido1 ),
                     ' ',
                     TRIM( cac.txtApellido2 )
                  ) 
                  ) AS 'Nombre',
                  hac.txtFuente as 'Fuente',
                  hac.txtInhabilidad as 'Inhabilidad',
                  hac.txtCausa as 'Causa'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN t_ciu_parentesco par on hac.seqParentesco = par.seqParentesco
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
               ORDER BY cac.numDocumento
            ";
                break;
            case 4: // reposicion
                $sql = "
               SELECT
                  hac.seqFormularioActo as 'Formulario ACto',
                  tdo.txtTipoDocumento as 'Tipo Documento',
                  cac.numDocumento as 'Documento',
                  UPPER( 
                    CONCAT(
                      TRIM( cac.txtNombre1 ),
                      ' ',
                      IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                      TRIM( cac.txtApellido1 ),
                      ' ',
                      TRIM( cac.txtApellido2 )
                    ) 
                  ) AS 'Nombre',
                  hac.txtEstadoReposicion as 'Resultado'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hac.seqParentesco = 1
               AND hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
               ORDER BY cac.numDocumento
            ";
                break;
            case 5: // no asignado
                $sql = "
               SELECT
                  hac.seqFormularioActo as 'Formulario Acto',
                  tdo.txtTipoDocumento as 'Tipo Documento',
                  cac.numDocumento as 'Documento',
                  UPPER( 
                    CONCAT(
                      TRIM( cac.txtNombre1 ),
                      ' ',
                      IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                      TRIM( cac.txtApellido1 ),
                      ' ',
                      TRIM( cac.txtApellido2 )
                    ) 
                  ) AS 'Nombre'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hac.seqParentesco = 1
               AND hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
               ORDER BY cac.numDocumento
            ";
                break;
            case 6: // renuncia
                $sql = "
                    SELECT
                        hac.seqFormularioActo as 'Formulario Acto',
                        tdo.txtTipoDocumento as 'Tipo Documento',
                        cac.numDocumento as 'Documento',
                        UPPER( 
                        CONCAT(
                        TRIM( cac.txtNombre1 ),
                        ' ',
                        IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                        TRIM( cac.txtApellido1 ),
                        ' ',
                        TRIM( cac.txtApellido2 )
                        ) 
                        ) AS 'Nombre',
                        hvi.numActoReferencia as 'Resolución',
                        hvi.fchActoReferencia as 'Fecha'
                    FROM T_AAD_HOGAR_ACTO hac
                    INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                    INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
                    INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
                    WHERE hac.seqParentesco = 1
                    AND hvi.numActo = " . $this->numActo . "
                    AND hvi.fchActo = '" . $this->fchActo . "'
                    ORDER BY cac.numDocumento
                ";
                break;
            case 7: // notificaciones
                $sql = "
               SELECT
                  hac.seqFormularioActo as 'Formulario Acto',
                  tdo.txtTipoDocumento as 'Tipo Documento',
                  cac.numDocumento as 'Documento',
                  UPPER( 
                    CONCAT(
                      TRIM( cac.txtNombre1 ),
                      ' ',
                      IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                      TRIM( cac.txtApellido1 ),
                      ' ',
                      TRIM( cac.txtApellido2 )
                    ) 
                  ) AS 'Nombre'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hac.seqParentesco = 1
               AND hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
               ORDER BY cac.numDocumento
            ";
                break;
            case 8: // indexaciones
                $sql = "
               SELECT
                  hac.seqFormularioActo as 'Formulario Acto', 
                  tdo.txtTipoDocumento as 'Tipo Documento',
                  cac.numDocumento as 'Documento',
                  UPPER( 
                     CONCAT(
                     TRIM( cac.txtNombre1 ),
                     ' ',
                     IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                     TRIM( cac.txtApellido1 ),
                     ' ',
                     TRIM( cac.txtApellido2 )
                     ) 
                  ) AS 'Nombre',
                  hvi.numActoReferencia as 'Acto Referencia',
                  hvi.fchActoReferencia as 'Fecha Acto Referencia',
                  hac.valIndexacion as 'Indexacion',
                  fac.valAspiraSubsidio as 'Aspira Subsidio'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hac.seqParentesco = 1
               AND hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
               ORDER BY cac.numDocumento
            ";
                break;
            case 9: // perdida
                $sql = "
               SELECT
                  hac.seqFormularioActo as 'Formulario Acto',
                  tdo.txtTipoDocumento as 'Tipo Documento',
                  cac.numDocumento as 'Documento',
                  UPPER( 
                    CONCAT(
                      TRIM( cac.txtNombre1 ),
                      ' ',
                      IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                      TRIM( cac.txtApellido1 ),
                      ' ',
                      TRIM( cac.txtApellido2 )
                    ) 
                  ) AS 'Nombre'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hac.seqParentesco = 1
               AND hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
               ORDER BY cac.numDocumento
            ";
                break;
            case 10: // revocatoria
                $sql = "
               SELECT
                  hac.seqFormularioActo as 'Formulario Acto',
                  tdo.txtTipoDocumento as 'Tipo Documento', 
                  cac.numDocumento as 'Documento',
                  UPPER( 
                    CONCAT(
                      TRIM( cac.txtNombre1 ),
                      ' ',
                      IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                      TRIM( cac.txtApellido1 ),
                      ' ',
                      TRIM( cac.txtApellido2 )
                    ) 
                  ) AS 'Nombre'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hac.seqParentesco = 1
               AND hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
               ORDER BY cac.numDocumento
            ";
                break;
            case 11: // exclusion
                $sql = "
               SELECT
                  hac.seqFormularioActo as 'Formulario Acto',
                  tdo.txtTipoDocumento as 'Tipo Documento',
                  cac.numDocumento as 'Documento',
                  UPPER( 
                    CONCAT(
                      TRIM( cac.txtNombre1 ),
                      ' ',
                      IF( TRIM( cac.txtNombre2 ) = '' , '' , CONCAT( cac.txtNombre2 , ' ' ) ),
                      TRIM( cac.txtApellido1 ),
                      ' ',
                      TRIM( cac.txtApellido2 )
                    ) 
                  ) AS 'Nombre'
               FROM T_AAD_HOGAR_ACTO hac
               INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hac.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON hvi.seqFormularioActo = fac.seqFormularioActo
               INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON cac.seqTipoDocumento = tdo.seqTipoDocumento
               WHERE hac.seqParentesco = 1
               AND hvi.numActo = " . $this->numActo . "
               AND hvi.fchActo = '" . $this->fchActo . "'
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
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    $this->arrDetalles['titulos'][] = "Desplazado";
                    $this->arrDetalles['titulos'][] = "Estado";
                    $this->arrDetalles['titulos'][] = "Valor Aporte / Subsidio";
                    $this->arrDetalles['titulos'][] = "Valor Solicitudes";
                    $this->arrDetalles['titulos'][] = "Valor Ordenes";
                    $this->arrDetalles['titulos'][] = "Resolución";
                    $this->arrDetalles['titulos'][] = "Fecha";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre '] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtDesplazado'] = $arrLinea['Desplazado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoProceso'] = $arrLinea['Estado'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSubsidio'] = $arrLinea['Aspira Subsidio'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valSolicitudes'] += doubleval($arrLinea['Valor Solicitado']);
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valOrdenes'] += doubleval($arrLinea['Valor Orden']);
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                        if (doubleval($arrLinea['Valor Solicitado']) != 0) {
                            $this->arrDetalles['resumen']['Cantidad Solicitudes']++;
                        }
                        $this->arrDetalles['resumen']['Valor Solicitudes'] += doubleval($arrLinea['Valor Solicitado']);
                        if (doubleval($arrLinea['Valor Orden']) != 0) {
                            $this->arrDetalles['resumen']['Cantidad Ordenes']++;
                        }
                        $this->arrDetalles['resumen']['Valor Ordenes'] += doubleval($arrLinea['Valor Orden']);
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucionReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucionReferencia'] = $arrLinea['Fecha Referencia'];
                    }
                    break;
                case 2: // modificatorias
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    $this->arrDetalles['titulos'][] = "Campo";
                    $this->arrDetalles['titulos'][] = "Incorrecto";
                    $this->arrDetalles['titulos'][] = "Correcto";
                    $this->arrDetalles['titulos'][] = "Acto Referencia";
                    $this->arrDetalles['titulos'][] = "Fecha Referencia";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqHogarActo = $arrLinea['Hogar Acto'];
                        $this->arrDetalles['detalle'][$seqHogarActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqHogarActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqHogarActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqHogarActo]['txtCampo'] = $arrLinea['Campo'];
                        $this->arrDetalles['detalle'][$seqHogarActo]['txtIncorrecto'] = $arrLinea['Incorrecto'];
                        $this->arrDetalles['detalle'][$seqHogarActo]['txtCorrecto'] = $arrLinea['Correcto'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                        $this->arrDetalles['detalle'][$seqHogarActo]['numActoReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqHogarActo]['fchActoReferencia'] = $arrLinea['Fecha Referencia'];
                    }
                    break;
                case 3: // inhabilitados
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    $this->arrDetalles['titulos'][] = "Parentesco";
                    $this->arrDetalles['titulos'][] = "Fuente";
                    $this->arrDetalles['titulos'][] = "Causa";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtParentesco'] = $arrLinea['Parentesco'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtFuente'] = $arrLinea['Fuente'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtCausa'] = $arrLinea['Causa'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 4: // reposicion
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    $this->arrDetalles['titulos'][] = "Resultado";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtEstadoReposicion'] = $arrLinea['Resultado'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 5: // no asignado
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 6: // renuncia
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    $this->arrDetalles['titulos'][] = "Resolución";
                    $this->arrDetalles['titulos'][] = "Fecha";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numResolucion'] = $arrLinea['Resolución'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchResolucion'] = $arrLinea['Fecha'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 7: // notificaciones
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 8: // indexaciones
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    $this->arrDetalles['titulos'][] = "Acto Indexado";
                    $this->arrDetalles['titulos'][] = "Fecha Acto Indexado";
                    $this->arrDetalles['titulos'][] = "Indexación";
                    $this->arrDetalles['titulos'][] = "Subsidio";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numActoReferencia'] = $arrLinea['Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['fchActoReferencia'] = $arrLinea['Fecha Acto Referencia'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valIndexacion'] = $arrLinea['Indexacion'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['valAspiraSubsidio'] = $arrLinea['Aspira Subsidio'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 9: // perdida
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 10: // revocatoria
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
                        $this->arrDetalles['resumen']['Total Hogares'] = count($this->arrDetalles['detalle']);
                    }
                    break;
                case 11: // exclusion
                    $this->arrDetalles['titulos'][] = "Tipo de Documento";
                    $this->arrDetalles['titulos'][] = "Documento";
                    $this->arrDetalles['titulos'][] = "Nombre";
                    foreach ($this->arrExportable as $numLinea => $arrLinea) {
                        $seqFormularioActo = $arrLinea['Formulario Acto'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtTipoDocumento'] = $arrLinea['Tipo Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['numDocumento'] = $arrLinea['Documento'];
                        $this->arrDetalles['detalle'][$seqFormularioActo]['txtNombre'] = $arrLinea['Nombre'];
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
                $seqFormularioActo = $this->obtenerSecuencial($this->numActo, $this->fchActo, $numDocumento);
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
                AND hvi.fchActo = '" . $this->fchActo . "'
                $txtCondicion
                ORDER BY fac.seqFormularioActo
            ";
            $this->arrHogares = $aptBd->GetAll($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo obtener el listado de hogares asociados a la resolucion " . $this->numActo . " del " . $this->fchActo;
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

        // valida los datos del formulario
        $this->validarFormulario($arrPost);

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
                $this->aplicarEfectos($arrPost['seqTipoActo'], $arrArchivo);

                // copiar el hogar
                $this->vincularHogres($arrPost, $arrArchivo);

                // Inserta el seguimiento
                $claSeguimiento = new Seguimiento();
                $claSeguimiento->actosAdministrativos($arrPost['seqTipoActo'], $arrPost['numActo'], $arrPost['fchActo'], $this->arrCambiosAplicados);

                // Inserta el registro de actividades
                $arrTipoActo = aadTipo::cargarTipoActo($arrPost['seqTipoActo']);
                $seqTipoActo = $arrPost['seqTipoActo'];
                $this->arrMensajes[] =
                    "Salvada la " . $arrTipoActo[$seqTipoActo]->txtTipoActo .
                    " número " . $arrPost['numActo'] .
                    " del " . $arrPost['fchActo'];
                $claRegistroActividades = new RegistroActividades();
                $this->arrErrores = $claRegistroActividades->registrarActividad(
                    "Creacion",
                    145,
                    $_SESSION['seqUsuario'],
                    "AAD " . $arrPost['numActo'] . " del " . $arrPost['fchActo']
                );

                if (!empty($this->arrErrores)) {
                    throw new Exception($this->arrErrores[0]);
                }

                $aptBd->CommitTrans();

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
                break;
            case 3: // inhabilitados
                break;
            case 4: // reposicion
                break;
            case 5: // no asignado
                break;
            case 6: // renuncia
                $this->validarReglasRenuncia($arrPost,$arrArchivo);
                break;
            case 7: // notificaciones
                break;
            case 8: // indexaciones
                break;
            case 9: // perdida
                break;
            case 10: // revocatoria
                break;
            case 11: // exclusion
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

            // si el estado del proceso corresponde
            $seqEstadoProceso = array_shift(
                obtenerDatosTabla(
                    "T_FRM_FORMULARIO",
                    array("seqFormulario", "seqEstadoProceso"),
                    "seqFormulario",
                    "seqFormulario = " . $seqFormulario
                )
            );
            if ($seqEstadoProceso != 0 and (!in_array($seqEstadoProceso, $this->arrEstadosPermitidos[$seqTipoActo]))) {
                $this->arrErrores[] =
                    "Error linea " . ($numLinea + 1) . ": El hogar del ciudadano " . $arrRegistro[0] . " esta en estado " .
                    $arrEstados[$seqEstadoProceso] . " y no es permitido para asociar a una resolución de asignación";
            }

            // Si tiene fecha de resolucion y numero mira si existe
            // y si el hogar esta vinculado a esa resoliución
            switch (true) {
                case $arrRegistro[1] != "" and $arrRegistro[2] != "":
                    $arrListado = $this->listarActos(1, $arrRegistro[1], $arrRegistro[2], array($arrRegistro[0]));
                    if (empty($arrListado)) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El documento " . $arrRegistro[0] . " no pertenece a la resolución " . $arrRegistro[1] . " del " . $arrRegistro[2] . " o dicha resolución no es de asignación";
                    }
                    break;
                case $arrRegistro[1] == "" and $arrRegistro[2] != "":
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro tiene fecha pero no numero de resolución";
                    break;
                case $arrRegistro[1] != "" and $arrRegistro[2] == "":
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El registro tiene número pero no fecha de resolución";
                    break;
            }

        }

    }

    /**
     * APLICA TODAS LAS VALIDACIONES DE REGLAS
     * DE NEGOCIO PARA LOS RADICADOS DE RENUNCIA
     * @param $arrPost
     * @param $arrArchivo
     */
    private function validarReglasRenuncia($arrPost,$arrArchivo)
    {

        $arrEstados = estadosProceso();
        $claCiudadano = new Ciudadano();

        foreach ($arrArchivo as $numLinea => $arrLinea){

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

            if($seqEtapa != 4 and $seqEtapa != 5){
                $this->arrErrores[] =
                    "Error linea " . ($numLinea + 1) . ": El hogar del ciudadano " . $arrLinea[0] . " esta en estado \"" .
                    $arrEstados[$seqEstadoProceso] . "\" y no es permitido para asociar a una resolución de asignación";

            }

            // Si tiene fecha de resolucion y numero mira si existe
            // y si el hogar esta vinculado a esa resoliución
            switch (true) {
                case $arrLinea[1] != "" and $arrLinea[2] != "":
                    $arrListado = $this->listarActos(1, $arrLinea[1], $arrLinea[2], array($arrLinea[0]));
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
     * ENRUTADOR PARA LAS VALIDACIONES DE
     * LOS FORMULARIOS DE CARACTERISTICAS
     * @param $arrPost
     */
    private function validarFormulario($arrPost)
    {

        switch ($arrPost['seqTipoActo']) {
            case 1: // asignacion
                $this->validarFormularioAsignacion($arrPost);
                break;
            case 2: // modificatorias
                break;
            case 3: // inhabilitados
                break;
            case 4: // reposicion
                break;
            case 5: // no asignado
                break;
            case 6: // renuncia
                $this->validarFormularioRenuncia($arrPost);
                break;
            case 7: // notificaciones
                break;
            case 8: // indexaciones
                break;
            case 9: // perdida
                break;
            case 10: // revocatoria
                break;
            case 11: // exclusion
                break;
            default:
                $this->arrErrores[] = "No se conoce el tipo de acto administrativo " . $this->seqTipoActo;
                break;
        }

    }

    /**
     * VALIDACIONES DEL FORMULARIO PARA
     * LAS RESOLUCIONES DE ASIGNACION
     * @param $arrPost
     */
    private function validarFormularioAsignacion($arrPost)
    {

        // texto de la resolucion
        if (trim($arrPost['txtResolucion']) == "") {
            $this->arrErrores[] = "El texto de la resolución no puede estar vacío";
        }

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
     * LOS RADICADOS DE RENUNCIA
     * @param $arrPost
     */
    private function validarFormularioRenuncia($arrPost)
    {
        // numero de formulario - expresion regular para el numero
        // 1-2017-99999
        // "/(\d{1})(\d{4})(\d{1,})/"
        preg_match("/(\d{1})(\d{4})(\d{1,})/",$arrPost['numActo'],$arrMatch);
        if(empty($arrMatch)){
            $this->arrErrores[] = "Revise el formato del radicado, debe ser el radicado de Forest";
        }

        // texto de la resolucion
        if (trim($arrPost['txtResolucion']) == "") {
            $this->arrErrores[] = "El texto de la resolución no puede estar vacío";
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
                break;
            case 3: // inhabilitados
                break;
            case 4: // reposicion
                break;
            case 5: // no asignado
                break;
            case 6: // renuncia
                $this->arrCaracteristicas['txtResolucion'] = 153;
                break;
            case 7: // notificaciones
                break;
            case 8: // indexaciones
                break;
            case 9: // perdida
                break;
            case 10: // revocatoria
                break;
            case 11: // exclusion
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
     * @param $seqTipoActo
     * @param $arrArchivo
     */
    private function aplicarEfectos($seqTipoActo, $arrArchivo)
    {
        switch ($seqTipoActo) {
            case 1: // asignacion
                $this->aplicarEfectosAsignacion($arrArchivo);
                break;
            case 2: // modificatorias
                break;
            case 3: // inhabilitados
                break;
            case 4: // reposicion
                break;
            case 5: // no asignado
                break;
            case 6: // renuncia
                $this->aplicarEfectosRenuncia($arrArchivo);
                break;
            case 7: // notificaciones
                break;
            case 8: // indexaciones
                break;
            case 9: // perdida
                break;
            case 10: // revocatoria
                break;
            case 11: // exclusion
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

            // obtiene el formulario que corresponde a la cedula
            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            // obtiene el estado del proceso que corresponde al hogar (actual)
            $seqEstadoProceso = array_shift(
                obtenerDatosTabla(
                    "T_FRM_FORMULARIO",
                    array("seqFormulario", "seqEstadoProceso"),
                    "seqFormulario",
                    "seqFormulario = " . $seqFormulario
                )
            );

            // realiza la modificacion del estado (nuevo)
            $sql = "
                update t_frm_formulario set
                    seqEstadoProceso = 15,
                    fchUltimaActualizacion = NOW()
                where seqFormulario = " . $seqFormulario . "
            ";
            $aptBd->execute($sql);

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $seqEstadoProceso;
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 15;

        }
    }

    /**
     * APLICANDO LOS EFECTOS DE LAS RESOLUCIONES DE ASIGNACION
     * @param $arrArchivo
     */
    private function aplicarEfectosRenuncia($arrArchivo){
        global $aptBd;
        foreach ($arrArchivo as $arrRegistro) {

            // obtiene el formulario que corresponde a la cedula
            $seqFormulario = Ciudadano::formularioVinculado($arrRegistro[0]);

            // obtiene el estado del proceso que corresponde al hogar (actual)
            $arrEstadoProceso = obtenerDatosTabla(
                "T_FRM_FORMULARIO",
                array("seqFormulario", "seqEstadoProceso", "bolSancion", "fchVigencia" ),
                "seqFormulario",
                "seqFormulario = " . $seqFormulario
            );

            // realiza la modificacion del estado (nuevo)
            $sql = "
                update t_frm_formulario set
                    seqEstadoProceso = 5
                    ,fchUltimaActualizacion = NOW()
                    ,bolSancion = 1
                    ,fchVigencia = DATE_ADD(now(), INTERVAL 1 YEAR)
                where seqFormulario = " . $seqFormulario . "
            ";
            $aptBd->execute($sql);

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "seqEstadoProceso";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso[$seqFormulario]['seqEstadoProceso'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 5;

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "bolSancion";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso[$seqFormulario]['bolSancion'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = 1;

            // adiciona el cambio al arreglo para el seguimiento
            $numPosicion = count($this->arrCambiosAplicados[$seqFormulario]['cambios']);
            $this->arrCambiosAplicados[$seqFormulario]['documento'] = $arrRegistro[0];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['campo'] = "fchVigencia";
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['anterior'] = $arrEstadoProceso[$seqFormulario]['fchVigencia'];
            $this->arrCambiosAplicados[$seqFormulario]['cambios'][$numPosicion]['nuevo'] = date("Y-m-d H:i:s" , strtotime("+ 1 year"));

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
                break;
            case 3: // inhabilitados
                break;
            case 4: // reposicion
                break;
            case 5: // no asignado
                break;
            case 6: // renuncia
                $this->vincularHogresAsignacion($arrPost,$arrArchivo); // usa la misma que asignacion
                break;
            case 7: // notificaciones
                break;
            case 8: // indexaciones
                break;
            case 9: // perdida
                break;
            case 10: // revocatoria
                break;
            case 11: // exclusion
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

            $arrRegistro[1] = (intval($arrRegistro[1]) != 0) ? intval($arrRegistro[1]) : "NULL";
            $arrRegistro[2] = (esFechaValida($arrRegistro[2])) ? "'" . $arrRegistro[2] . "'" : "NULL";

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
                    " . $arrRegistro[1] . ", 
                    " . $arrRegistro[2] . "
                )
            ";
            $aptBd->execute($sql);

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

        }

    }

}


?>
