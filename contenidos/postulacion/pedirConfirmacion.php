<?php

    /**
     * PIDE CONFIRMACION DE LOS CAMBIOS GENERADOS EN EL FORMULARIO
     * SI NO HAY CAMBIOS EN EL FORMULARIO SOLO GRABA EL SEGUIMIENTO
     */
    $txtPrefijoRuta = "../../";

    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

    // variables para control de flujo
    $bolConfirmacion = false;
    $arrErrores      = array();
    $arrMensajes     = array();
    $arrCamposLibres = array();

    // CAMPOS QUE PUEDEN SER MODIFICADOS SIN VALIDACIONES
    $arrCamposLibres["txtDireccion"] = "Dirección";
    $arrCamposLibres["numTelefono1"] = "Telefono fíjo 1";
    $arrCamposLibres["numTelefono2"] = "Telefono fíjo 2";
    $arrCamposLibres["numCelular"]   = "Celular";
    $arrCamposLibres["seqCiudad"]    = "Ciudad";
    $arrCamposLibres["seqLocalidad"] = "Localidad";
    $arrCamposLibres["seqBarrio"]    = "Barrio";
    $arrCamposLibres["txtCorreo"]    = "Correo";

    // No hacen parte del formulario las separo del post
    $seqGrupoGestion = $_POST['seqGrupoGestion'];
    $seqGestion      = $_POST['seqGestion'];
    $txtComentario   = $_POST['txtComentario'];
    $numDocumento    = $_POST['numDocumento']; // numero de documento atendido
    unset($_POST['seqGrupoGestion']);
    unset($_POST['seqGestion']);
    unset($_POST['txtComentario']);
    unset($_POST['numDocumento']);

    // CORRECCION DE CAMPOS MAL NOMBRADOS EN LA PLANTILLA
    //(aun no se puede corregir en la plantilla como tal porque debe cambiarse actualizacion.tpl y esta en desarrollo ocupada)
    foreach($_POST['hogar'] as $numDocumento => $arrCiudadano){
        $_POST['hogar'][$numDocumento]['numAnosAprobados'] = $_POST['hogar'][$numDocumento]['anosAprobados'];
        unset( $_POST['hogar'][$numDocumento]['anosAprobados'] );
    }

    // CARGA LOS DATOS DEL FORMULARIO COMO ESTA EN LA BASE DE DATOS
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($_POST['seqFormulario']);

    // Verifica cambios en los ciudadanos que estan en el post y en la clase
    // puede ver los ciudadanos adicionados
    foreach($_POST['hogar'] as $numDocumento => $arrCiudadano){
        $seqCiudadano = Ciudadano::ciudadanoExiste($arrCiudadano['seqTipoDocumento'],$numDocumento);
        if($seqCiudadano != 0){
            if( isset( $claFormulario->arrCiudadano[$seqCiudadano] ) ){
                foreach($arrCiudadano as $txtCampo => $txtValor){
                    if( $claFormulario->arrCiudadano[$seqCiudadano]->$txtCampo != $txtValor ){
                        //echo $numDocumento . "[$seqCiudadano]#==>#" . $txtCampo . "#==>#" . $claFormulario->arrCiudadano[$seqCiudadano]->$txtCampo . "#==>#" . $txtValor . "#<br>";
                        $bolConfirmacion = true; // Algun valor del post es diferente de la clase
                    }
                }
            }else{
                $bolConfirmacion = true; // Ciudadano adicionado - existente en la base de datos
            }
        }else{
            $bolConfirmacion = true; // Ciudadano adicionado - no esta en la base de datos
        }
    }

    // detecta ciudadanos eliminados
    foreach($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano){
        if(! isset($_POST['hogar'][$claCiudadano->numDocumento])){
            $bolConfirmacion = true; // Ciudadano eliminado --> estaba en la clase pero ya no viene en el post
        }
    }

    // detecta cambios en el formulario
    foreach( $_POST as $txtCampo => $txtValor ){
        if($txtCalve != 'hogar'){
            if( ! isset($arrCamposLibres[$txtCampo])){
                switch (mb_substr($txtCampo, 0, 3)) {
                    case "num":
                        $txtValor = doubleval(mb_ereg_replace("[^0-9]", "", $txtValor));
                        break;
                    case "val":
                        $txtValor = doubleval(mb_ereg_replace("[^0-9]", "", $txtValor));
                        break;
                    case "txt":
                        $txtValor = trim($txtValor);
                        break;
                    case "fch":
                        $txtValor = (esFechaValida($txtValor)) ? $txtValor : null;
                        break;
                    default:
                        $txtValor = trim($txtValor);
                        break;
                }
                if($claFormulario->$txtCampo != $txtValor){
                    //echo $txtCampo . "#==>#" . $claFormulario->$txtCampo . "#==>#" . $txtValor . "#<br>";
                    $bolConfirmacion = true;
                }
            }else{
                if( trim($txtValor) == ""){
                    $arrErrores[] = "El valor para el campo " . $arrCamposLibres[$txtCampo] . " no es válido, no lo puede dejar vacío";
                }
            }
        }
    }

    // Si no hay errores
    if(empty($arrErrores)){

        // Si hubo cambios en el formulario
        if($bolConfirmacion == true){

            $txtMensaje = "Es necesario que confirme la accion que esta apunto de realizar:";
            $txtMensaje .= "<div class='msgOk' style='font-size:12px;'>";
            $txtMensaje .= "¿Desea salvar los cambios realizados para el documento " . number_format($_POST['numDocumento']) . "?";
            $txtMensaje .= "</div>";

            // No hacen parte del formulario las separo del post
            $_POST['seqGrupoGestion'] = $seqGrupoGestion;
            $_POST['seqGestion']      = $seqGestion;
            $_POST['txtComentario']   = $txtComentario;
            $_POST['numDocumento']    = $numDocumento; // numero de documento atendido

            $claSmarty->assign("txtMensaje", $txtMensaje);
            $claSmarty->assign("bolConfirmacion", $bolConfirmacion);
            $claSmarty->assign("txtArchivo", "./contenidos/postulacion/salvarPostulacion.php");
            $claSmarty->assign("arrPost", $_POST);

            $claSmarty->display("subsidios/pedirConfirmacion.tpl");

        }else{

            if (trim($txtComentario) == "") {
                $arrErrores[] = "Debe digitar el campo de comentarios";
            }

            if (intval($seqGrupoGestion) == 0) {
                $arrErrores[] = "Seleccione el grupo de gestion";
            }

            if (intval($seqGestion) == 0) {
                $arrErrores[] = "Seleccione la gestion realizada";
            }

            // Si no hay errores modifica los datos libres de validaciones
            if(empty($arrErrores)){
                $sql = "UPDATE T_FRM_FORMULARIO SET ";
                foreach ($arrCamposLibres as $txtCampo => $txtValor) {
                    $sql .= $txtCampo . " = '" . $_POST[$txtCampo] . "',";
                }
                $sql = trim($sql, ",");
                $sql .= " WHERE seqFormulario = " . $_POST['seqFormulario'];
                $aptBd->execute($sql);
            }

        }

        // una vez hechos los cambios se carga el formulario para compararlo con el de antes
        $claFormularioNuevo = new FormularioSubsidios();
        $claFormularioNuevo->cargarFormulario($_POST['seqFormulario']);
        $txtNombre = Ciudadano::obtenerNombre($numDocumento); // Nombre del ciudadano atendido

        // obtiene los cambios para dejar el registro
        $claSeguimiento = new Seguimiento;
        $txtCambios = $claSeguimiento->cambiosPostulacion($_POST['seqFormulario'], $claFormulario, $claFormularioNuevo);

        $sql = "
                INSERT INTO T_SEG_SEGUIMIENTO (
                       seqFormulario,
                       fchMovimiento,
                       seqUsuario,
                       txtComentario,
                       txtCambios,
                       numDocumento,
                       txtNombre,
                       seqGestion
                ) VALUES (
                       " . $_POST['seqFormulario'] . ",
                       now(),
                       " . $_SESSION['seqUsuario'] . ",
                       \"" . mb_ereg_replace("\n", "", $_POST['txtComentario']) . "\",
                       \"$txtCambios\",
                       " . $numDocumento . ",
                       \"" . $txtNombre . "\",
                       " . $seqGestion . "
                )
         ";
        try {
            $aptBd->execute($sql);
            $seqSeguimiento = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido registrar la actividad del hogar, contacte al administrador";
        }

        if (empty($arrErrores)) {
            $arrMensajes[] = "Ha salvado un registro de actividad, el numero del registro es " .
                number_format($seqSeguimiento, 0, ".", ",") .
                ". Conserve este número para su referencia.";
        }

    }

    imprimirMensajes($arrErrores, $arrMensajes);

die();

//**************************************************************************************************************//
//**************************************************************************************************************//
//**************************************************************************************************************//
//**************************************************************************************************************//
//**************************************************************************************************************//
//**************************************************************************************************************//
//**************************************************************************************************************//
//**************************************************************************************************************//
//**************************************************************************************************************//

if ($bolConfirmacion == true) {
    if ($_POST["bolSancion"] == 1) {
        $arrErrores[] = "No se puede modificar la postulacion del hogar debido a que esta Sancionado.";
        imprimirMensajes($arrErrores, array());
    } else {

        if ($claFormulario->seqEstadoProceso == 35 and $claFormulario->seqPlanGobierno == 3) {
            $_POST['seqEstadoProceso'] = 37;
        } else {
            // revisa si los cambios son en campos que afectan la calificacion
            // de ser asi, se altera el estado del proceso para que quede en
            // 37. Inscripcion - Hogar Actualizado
            if ($eliminados == true || $adicionados == true) {
                $_POST['seqEstadoProceso'] = 37;
            }
            if (count($arrCamposCambiados) > 0) {
                foreach ($arrCamposCambiados as $txtCampo) {
                    if (in_array($txtCampo, $arrCamposCalificacion)) {
                        $bolRetorno = true;
                        $_POST['seqEstadoProceso'] = 37;
                        break;
                    }
                }
            }
        }

        if ($_POST['seqEstadoProceso'] == 37) {
            $_POST['bolCerrado'] = 0;
            $_POST['fchPostulacion'] = "";
        }


    }
} else {


    if (empty($arrErrores)) {



        // obtiene los cambios para dejar el registro
        $claSeguimiento = new Seguimiento;
        $txtCambios = $claSeguimiento->cambiosPostulacion($_POST['seqFormulario'], $claFormulario, $claFormularioNuevo);



    }
    imprimirMensajes($arrErrores, $arrMensajes);
}
?>
