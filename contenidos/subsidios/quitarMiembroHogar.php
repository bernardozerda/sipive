<?php

$txtPrefijoRuta = "../../";

include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "aad.class.php");

$claSeguimiento = new Seguimiento();

$claFormulario = new FormularioSubsidios();
$claFormulario->cargarFormulario($_POST['seqFormulario']);

try {
    $aptBd->BeginTrans();

    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
        if($objCiudadano->seqParentesco == 1){
            $numDocumento = $objCiudadano->numDocumento;
            $txtNombre = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
            if($numDocumento == $_POST['numDocumento']){
                throw new Exception("No puede eliminar el postulante principal del formulario");
            }
        }
        if ($objCiudadano->numDocumento == $_POST['numDocumento']) {
            $seqCiudadanoEliminar = $seqCiudadano;
            unset($claFormulario->arrCiudadano[$seqCiudadano]);
        }
    }

    $arrPost = array();
    $arrPost['seqGrupoGestion'] = $_POST['seqGrupoGestion1'];
    $arrPost['seqGestion'] = $_POST['seqGestion1'];
    $arrPost['txtComentario'] = $_POST['txtComentario1'];
    $arrPost['nombre'] = $txtNombre;
    $arrPost['cedula'] = $numDocumento;
    foreach($claFormulario as $txtClave => $txtValor){
        if($txtClave != "arrCiudadano"){
            $arrPost[$txtClave] = $txtValor;
        }else{
            foreach($claFormulario->$txtClave as $txtTitulo => $objCiudadano){
                $numIdentificacion = $objCiudadano->numDocumento;
                foreach($objCiudadano as $txtTitulo2 => $txtValor ) {
                    if($txtTitulo2 != "arrErrores") {
                        $arrPost['hogar'][$numIdentificacion][$txtTitulo2] = $txtValor;
                    }
                }
            }
        }
    }

    $claSeguimiento->salvarSeguimiento($arrPost,"cambiosPostulacion");

    $sql = "delete from t_frm_hogar where seqCiudadano = $seqCiudadanoEliminar";
    $aptBd->execute($sql);
    $sql = "delete from t_ciu_ciudadano where seqCiudadano = $seqCiudadanoEliminar";
    $aptBd->execute($sql);
    $sql = "update t_frm_formulario set fchUltimaActualizacion = now() where seqFormulario = " . $_POST['seqFormulario'];
    $aptBd->execute($sql);

    /**********************************************************************************************************************
     * SINCRONIZANDO FORMULARIO Y ACTO ADMINISTRATIVO
     **********************************************************************************************************************/

    $seqEstadoProceso = $claFormulario->seqEstadoProceso;
    $arrEtapa = obtenerDatosTabla("T_FRM_ESTADO_PROCESO",array("seqEstadoProceso","seqEtapa"),"seqEstadoProceso","seqEstadoProceso = " . $seqEstadoProceso);
    $seqEtapa = $arrEtapa[$seqEstadoProceso];

    if ($seqEtapa == 4 or $seqEtapa == 5) {

        $claActoAdministrativo = new aad();

        $arrProcesos = $claActoAdministrativo->obtenerProcesos($_POST['seqFormulario']);

        if(! empty($arrProcesos)){

            $seqFormularioActo = null;
            foreach($arrProcesos as $txtResolucion => $arrProceso){
                $seqFormularioActo = $arrProceso['cabeza'];
            }

            $sql = "
                select cac.seqCiudadanoActo
                from t_aad_ciudadano_acto cac
                inner join t_aad_hogar_acto hac on cac.seqCiudadanoActo = hac.seqCiudadanoActo
                where hac.seqFormularioActo = $seqFormularioActo
                  and cac.seqCiudadano = $seqCiudadanoEliminar
            ";
            $objRes = $aptBd->execute($sql);
            $seqCiudadanoActo = $objRes->fields['seqCiudadanoActo'];

            $sql = "delete from t_aad_detalles where seqFormularioActo = $seqFormularioActo and seqCiudadanoActo = $seqCiudadanoActo";
            $aptBd->execute($sql);

            $sql = "delete from t_aad_hogar_acto where seqFormularioActo = $seqFormularioActo and seqCiudadanoActo = $seqCiudadanoActo";
            $aptBd->execute($sql);

            $sql = "delete from t_aad_ciudadano_acto where seqCiudadanoActo = $seqCiudadanoActo";
            $aptBd->execute($sql);

        }

    }





    if(empty($claSeguimiento->arrErrores)) {
        $arrMensajes = $claSeguimiento->arrMensajes;
    }else{
        $arrErrores = $claSeguimiento->arrErrores;
    }

    $aptBd->CommitTrans();

}catch(Exception $objError){
    $aptBd->RollbackTrans();
    $arrErrores[] = $objError->getMessage();
}

imprimirMensajes($arrErrores,$arrMensajes);

?>