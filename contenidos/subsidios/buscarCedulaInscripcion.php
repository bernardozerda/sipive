<?php

/**
 * AQUI SE REALIZA LA BUSQUEDA DE LA CEDULA
 * PARA SABER SI SE MUESTRA EL FORMULARIO DE INSCRIPCION
 * O SI SE MUESTRA EL FORMULARIO DEPOSTULACION
 * @author Bernardo Zerda
 * @version 1.0 Mayo de 2009
 * @version 2.0 Enero 2014
 */
$txtPrefijoRuta = "../../";

include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php");

if (!isset($_POST['cedula'])) {
   $claSmarty->assign("txtFuncion", "buscarCedula('subsidios/buscarCedulaInscripcion');");
   $claSmarty->display("subsidios/buscarCedula.tpl");
} else {

   /********************************************************************************************************
    * OBTENCION DE DATOS PARA EL FORMULARIO
    ********************************************************************************************************/

   // Quita los puntos del documento
   $_POST['cedula'] = mb_ereg_replace("[^0-9]", "", $_POST['cedula']);

   $claFormulario = new FormularioSubsidios();
   $claCiudadano = new Ciudadano();
   $seqFormulario = $claCiudadano->formularioVinculado($_POST['cedula']);
   $claFormulario->cargarFormulario($seqFormulario);
   $seqEtapa = obtenerCampo("T_FRM_ESTADO_PROCESO", $claFormulario->seqEstadoProceso, "seqEtapa", "seqEstadoProceso");
   $seqPlanGobierno = ($seqFormulario == 0) ? 3 : $claFormulario->seqPlanGobierno;

   // Informacion de los select que hay en el formulario
   $arrTipoDocumento = obtenerDatosTabla("T_CIU_TIPO_DOCUMENTO", array("seqTipoDocumento", "txtTipoDocumento"), "seqTipoDocumento", "seqTipoDocumento not in (6,8)", "txtTipoDocumento");
   $arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA", array("seqTipoVictima", "txtTipoVictima"), "seqTipoVictima", "seqTipoVictima <> 0", "txtTipoVictima");
   $arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi", "seqGrupoLgtbi <> 0", "txtGrupoLgtbi");
   $arrSexo = obtenerDatosTabla("T_CIU_SEXO", array("seqSexo", "txtSexo"), "seqSexo", "", "txtSexo");
   $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil", "bolActivo"), "seqEstadoCivil", "bolActivo = 1", "txtEstadoCivil");
   $arrVivienda = obtenerDatosTabla("T_FRM_VIVIENDA", array("seqVivienda", "txtVivienda"), "seqVivienda", "", "txtVivienda");
   $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad", "seqPlanGobierno = " . $seqPlanGobierno, "seqPlanGobierno DESC, txtModalidad");
   $bolCondicionSisben = ($claFormulario->seqPlanGobierno == 3)? 1 : 0;
   $arrSisben[1]['txtSisben'] = "Ninguno";
   $arrSisben[1]['bolActivo'] = $bolCondicionSisben;
   $arrSisben += obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben", "txtSisben", "bolActivo"), "seqSisben", "bolActivo = $bolCondicionSisben and seqSisben <> 1");
   $arrBanco = obtenerDatosTabla("T_FRM_BANCO", array("seqBanco", "txtBanco"), "seqBanco", "seqBanco > 1", "txtBanco");
   $arrEstados = estadosProceso();
   $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco", "bolActivo"), "seqParentesco", "bolActivo = 1", "txtParentesco");
   $arrCondicionEspecial = obtenerDatosTabla("T_CIU_CONDICION_ESPECIAL", array("seqCondicionEspecial", "txtCondicionEspecial"), "seqCondicionEspecial", "seqCondicionEspecial <> 6", "txtCondicionEspecial");
   $arrCondicionEtnica = obtenerDatosTabla("T_CIU_ETNIA", array("seqEtnia", "txtEtnia"), "seqEtnia", "seqEtnia > 1", "txtEtnia");
   $arrOcupacion = obtenerDatosTabla("T_CIU_OCUPACION", array("seqOcupacion", "txtOcupacion"), "seqOcupacion", "seqOcupacion <> 20", "txtOcupacion");
   $arrCiudad = obtenerDatosTabla("V_FRM_CIUDAD", array("seqCiudad", "txtCiudad"), "seqCiudad", "seqCiudad = 149", "txtCiudad");
   $arrCiudad += obtenerDatosTabla("V_FRM_CIUDAD", array("seqCiudad", "txtCiudad"), "seqCiudad", "seqCiudad <> 149", "txtCiudad");
   $arrLocalidad = obtenerDatosTabla("T_FRM_LOCALIDAD", array("seqLocalidad", "txtLocalidad"), "seqLocalidad", "seqLocalidad <> 1");
   natsort($arrLocalidad);
   $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "", "txtBarrio");
   $arrNivelEducativo = obtenerDatosTabla("T_CIU_NIVEL_EDUCATIVO", array("seqNivelEducativo", "txtNivelEducativo"), "seqNivelEducativo", "seqNivelEducativo > 1", "txtNivelEducativo");
   $arrSalud = obtenerDatosTabla("T_CIU_SALUD", array("seqSalud", "txtSalud"), "seqSalud", "seqSalud <> 0", "txtSalud", "", "txtSalud");
   $arrDonantes = obtenerDatosTabla("T_FRM_EMPRESA_DONANTE", array("seqEmpresaDonante", "txtEmpresaDonante"), "seqEmpresaDonante", "seqEmpresaDonante > 1", "txtEmpresaDonante");
   $arrEntidadSubsidio = obtenerDatosTabla("T_FRM_ENTIDAD_SUBSIDIO", array("seqEntidadSubsidio", "txtEntidadSubsidio"), "seqEntidadSubsidio", "", "seqEntidadSubsidio");
   $arrGrupoGestion = obtenerDatosTabla("T_SEG_GRUPO_GESTION", array("seqGrupoGestion", "txtGrupoGestion"), "seqGrupoGestion", "seqGrupoGestion NOT IN ( 15,5,10,12,17,20 )", "txtGrupoGestion");
   $arrPlanGobierno = obtenerDatosTabla("T_FRM_PLAN_GOBIERNO", array("seqPlanGobierno", "txtPlanGobierno"), "seqPlanGobierno", "", "txtPlanGobierno");

   /*******************************************************************************************************
    * VERIFICACION DE LA EXISTENCIA DEL CIUDADANO
    ******************************************************************************************************/

   if ($seqFormulario == 0) {
      $txtPlantilla = "subsidios/inscripcion.tpl";
   } else {

      if ($seqEtapa == 1) {

         // datos del formulario que dependen de los datos de la base de datos
         $arrTipoEsquemas = obtenerTipoEsquema($claFormulario->seqModalidad, $claFormulario->seqPlanGobierno, $claFormulario->bolDesplazado);
         $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claFormulario->seqLocalidad, "txtBarrio");
         $arrSolucion = obtenerDatosTabla("T_FRM_SOLUCION", array("seqSolucion", "txtSolucion", "txtDescripcion", "seqModalidad"), "seqSolucion", "seqSolucion <> 1 and seqModalidad = " . $claFormulario->seqModalidad);

         // obtiene los ultimos 100 seguimientos
         $claSeguimiento = new Seguimiento;
         $claSeguimiento->seqFormulario = $seqFormulario;
         $arrSeguimiento = $claSeguimiento->obtenerRegistros(100);

         // obtiene la informacion de la pestana de actos administrativos
         $arrActos = array();
         if (is_object($claFormulario)) {

            foreach ($claFormulario->arrCiudadano as $objCiudadano) {
               if ($objCiudadano->seqParentesco == 1) {
                  $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
                  break;
               }
            }

            $claActosAdministrativos = new ActoAdministrativo();
            $arrActos = $claActosAdministrativos->cronologia($numDocumento);
         }

         // Obtiene los actos de Indexación de la unidad actual que tiene el formulario
         $sqlActoUnidad = "SELECT T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo, numActo, fchActo, txtDescripcion, valIndexado
                                 FROM T_PRY_AAD_UNIDAD_ACTO
                                 INNER JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON (T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo)
                                 WHERE seqTipoActoUnidad = 2
                                 AND T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = (SELECT seqUnidadProyecto 
                                                                               FROM T_FRM_FORMULARIO 
                                                                               WHERE seqFormulario = $seqFormulario)";
         $objRes = $aptBd->execute($sqlActoUnidad);
         while ($objRes->fields) {
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['seqUnidadActo'] = $objRes->fields['seqUnidadActo'];
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['numActo'] = $objRes->fields['numActo'];
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['fchActo'] = formatoFechaTextoFecha($objRes->fields['fchActo']);
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['txtDescripcion'] = $objRes->fields['txtDescripcion'];
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['valIndexado'] = $objRes->fields['valIndexado'];
            $objRes->MoveNext();
         }

         // Suma de recursos propios
         $valSumaRecursosPropios =
            $claFormulario->valSaldoCuentaAhorro +
            $claFormulario->valSaldoCuentaAhorro2 +
            $claFormulario->valSaldoCesantias +
            $claFormulario->valCredito +
            $claFormulario->valAporteLote;

         // Suma de subsidios
         $valSumaSubsidios =
            $claFormulario->valSubsidioNacional +
            $claFormulario->valDonacion;

         // Total recursos
         $claFormulario->valTotalRecursos = $valSumaRecursosPropios + $valSumaSubsidios;

         $txtPlantilla = "subsidios/actualizacion.tpl";

      } else {
         $arrErrores[] = "El hogar esta en el estado " . $arrEstados[$claFormulario->seqEstadoProceso] . " ingrese por el manú Proceso -> Postulación";
      }
   }


   /**************************************************************************************************************
    * ASIGNACION DE VARIABLES A LA PLANTILLA
    **************************************************************************************************************/

   if (empty($arrErrores)) {

      $claSmarty->assign("valSumaRecursosPropios", $valSumaRecursosPropios);
      $claSmarty->assign("valSumaSubsidios", $valSumaSubsidios);
      $claSmarty->assign("arrActosAsociados", $arrActosAsociados);
      $claSmarty->assign("arrRegistros", $arrSeguimiento);
      $claSmarty->assign("arrPost", $_POST);
      $claSmarty->assign("arrTipoDocumento", $arrTipoDocumento);
      $claSmarty->assign("arrTipoVictima", $arrTipoVictima);
      $claSmarty->assign("arrGrupoLgtbi", $arrGrupoLgtbi);
      $claSmarty->assign("arrSexo", $arrSexo);
      $claSmarty->assign("arrEstadoCivil", $arrEstadoCivil);
      $claSmarty->assign("arrVivienda", $arrVivienda);
      $claSmarty->assign("arrModalidad", $arrModalidad);
      $claSmarty->assign("arrTipoEsquemas", $arrTipoEsquemas);
      $claSmarty->assign("arrSisben", $arrSisben);
      $claSmarty->assign("arrBanco", $arrBanco);
      $claSmarty->assign("arrEntidadSubsidio", $arrEntidadSubsidio);
      $claSmarty->assign("arrEstado", $arrEstados);
      $claSmarty->assign("arrParentesco", $arrParentesco);
      $claSmarty->assign("arrCondicionEspecial", $arrCondicionEspecial);
      $claSmarty->assign("arrCondicionEtnica", $arrCondicionEtnica);
      $claSmarty->assign("arrOcupacion", $arrOcupacion);
      $claSmarty->assign("arrLocalidad", $arrLocalidad);
      $claSmarty->assign("arrSolucion", $arrSolucion);
      $claSmarty->assign("arrNivelEducativo", $arrNivelEducativo);
      $claSmarty->assign("arrSalud", $arrSalud);
      $claSmarty->assign("arrDonantes", $arrDonantes);
      $claSmarty->assign("arrPlanGobierno", $arrPlanGobierno);
      $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
      $claSmarty->assign("arrCiudad", $arrCiudad);
      $claSmarty->assign("arrBarrio", $arrBarrio);
      $claSmarty->assign("seqFormulario", $seqFormulario);
      $claSmarty->assign("objFormulario", $claFormulario);
      $claSmarty->assign("arrActos", $arrActos);
      $claSmarty->assign("valSMMLV", $arrConfiguracion['constantes']['salarioMinimo']);

      $claSmarty->display($txtPlantilla);

   } else {
      imprimirMensajes($arrErrores, array());
   }

} // FIN POST CEDULA
?>