<?php

    /**
     * ESTE ARCHIVO SALVA O EDITA EL FORMULARIO DE INSCRIPCION
     * @author Bernardo Zerda
     * @version 1.0 Mayo 2009
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

    $arrErrores = array();
    $numFechaHoy = time();
    $numMayorEdad = strtotime("-18 year", $numFechaHoy); // Timestamp de nacimiento de mayor de edad
    $numTerceraEdad = strtotime("-65 year", $numFechaHoy); // Timestamp de nacimiento de terera edad

    // tipos de documento validos para un menor de edad
    $arrDocumentosMenorEdad[] = 4; // Tarjeta de Identidad
    $arrDocumentosMenorEdad[] = 3; // Registro Civil

    // tipos de documento validos para un menor de edad
    $arrDocumentosMayorEdad[] = 1; // Cedula Ciudadania
    $arrDocumentosMayorEdad[] = 2; // Cedula extranjeria

    // Identificador de la condicion especial
    $numCondicionEspecialMayor65 = 2;

    // Regularizar los campos del post
    foreach ( $_POST as $txtCampo => $txtValor ){
        $_POST[ $txtCampo ] = regularizarCampo( $txtCampo , $txtValor );
    }

    /**************************************************************************************************************
     * VALIDACION DE LOS CAMPOS OBLIGATORIOS Y REGLAS DE NEGOCIO
     * ************************************************************************************************************ */

    if($_SESSION['privilegios']['crear'] != 1) {
        $arrErrores[] = "No tiene permisos para crear registros";
    }

    // Grupo de Gestion 
    if (intval($_POST['seqGrupoGestion']) == 0) {
        $arrErrores[] = "Seleccione el grupo de la gestión realizada";
    }

    // Gestion
    if (intval($_POST['seqGestion']) == 0) {
        $arrErrores[] = "Seleccione la gestión realizada";
    }

    // Comentarios
    if (trim($_POST['txtComentario']) == "") {
        $arrErrores[] = "Por favor diligencie el campo de comentarios";
    }

    // Documento
    if (doubleval($_POST['numDocumento']) == 0) {
        $arrErrores[] = "El Documento no puede estar vacio";
    }

    // Tipo de documento
    if (in_array(intval($_POST['seqTipoDocumento']), array(0, 6, 4, 3))) {
        $arrErrores[] = "El tipo de documento seleccionado no es válido";
    }elseif( intval($_POST['seqTipoDocumento']) == 1 ){

        // validacion del soporte de documento
        if(! esFechaValida($_POST['fchExpedicion'])){
            $arrErrores[] = "Indique la fecha de expedición del documento";
        }

    }

    // tipo de soporte del documento
//    if($_POST['txtTipoSoporte'] == "") {
//
//        $arrErrores[] = "Seleccione el tipo de soporte para el documento de identidad";
//
//    }elseif($_POST['txtTipoSoporte'] == "registroCivil"){
//
//        $_POST['numConsecutivoPartida'] = 0;
//        $_POST['txtParroquiaPartida'] = "";
//        $_POST['seqCiudadPartida'] = 0;
//
//        if(trim($_POST['txtEntidadDocumento']) == ""){
//            $arrErrores[] = "Indique la entidad que expide el documento";
//        }else{
//            if(trim($_POST['txtEntidadDocumento']) == "Notaria" and intval($_POST['numNotariaDocumento']) == 0){
//                $arrErrores[] = "Indique la notaría en donde se expidió el registro civil del ciudadano";
//            }
//        }
//
//        if(doubleval($_POST['numIndicativoSerial']) == 0){
//            $arrErrores[] = "Digite el indicativo serial del registro civil del ciudadano";
//        }else{
//            if(doubleval($_POST['numIndicativoSerial']) == doubleval($_POST['numDocumento'])) {
//                $arrErrores[] = "El indicativo serial no es el mismo numero de documento, por favor rectifique";
//            }
//        }
//
//        if(intval($_POST['seqCiudadDocumento']) == 0){
//            $arrErrores[] = "Indique la ciudad de expedicion del registro civil del ciudadano";
//        }
//
//    }elseif($_POST['txtTipoSoporte'] == "partidaBautismo"){
//
//        $_POST['txtEntidadDocumento'] = "";
//        $_POST['numNotariaDocumento'] = 0;
//        $_POST['numIndicativoSerial'] = 0;
//        $_POST['seqCiudadDocumento'] = 0;
//
//        if(doubleval($_POST['numConsecutivoPartida']) == 0){
//            $arrErrores[] = "Digite el consecutivo del soporte de documento de identidad";
//        }
//
//        if(trim($_POST['txtParroquiaPartida']) == ""){
//            $arrErrores[] = "Digite la parroquia del soporte de documento de identidad";
//        }
//
//        if(intval($_POST['seqCiudadPartida']) == 0){
//            $arrErrores[] = "Digite la ciudad del soporte de documento de identidad";
//        }
//
//    }

    // Primer nombre
    if (trim($_POST['txtNombre1']) == "") {
        $arrErrores[] = "El ciudadano debe tener primer nombre";
    }

    // Primer apellido
    if (trim($_POST['txtApellido1']) == "") {
        $arrErrores[] = "El ciudadano debe tener primer apellido";
    }

    // fecha de nacimiento
    if( ! esFechaValida( $_POST['fchNacimiento'] ) ){
        $arrErrores[] = "Seleccione una fecha de nacimiento válida";
    }else{

        // validacion del tipo de soporte
//        $fchNacimiento = new DateTime($_POST['fchNacimiento']);
//        if( $fchNacimiento->format("Y") < 1938 and $_POST['txtTipoSoporte'] == "registroCivil"){
//            $arrErrores[] = "Tipo de soporte inválido para personas nacidas antes de 1938";
//        }

        // validaciones relacionadas con la fecha de nacimiento
        $numEdad = strtotime($_POST['fchNacimiento']);

        // se compara si es mayor de edad al momento de la actualizacion
        if (($numEdad <= $numMayorEdad) and in_array($_POST['seqTipoDocumento'], $arrDocumentosMenorEdad)) {
            $arrErrores[] = "Tipo de documento errado para " .
                $_POST['txtNombre1'] . " " . $_POST['txtNombre2'] . " " .
                $_POST['txtApellido1'] . " " . $_POST['txtApellido2'] .
                " porque según su fecha de nacimiento es mayor de edad";
        }

        // se compara si es menor de edad al momento de la actualizacion
        if (($numEdad > $numMayorEdad) and in_array($_POST['seqTipoDocumento'], $arrDocumentosMayorEdad)) {
            $arrErrores[] = "Tipo de documento errado para " .
                $_POST['txtNombre1'] . " " . $_POST['txtNombre2'] . " " .
                $_POST['txtApellido1'] . " " . $_POST['txtApellido2'] .
                " porque segun su fecha de nacimiento es menor de edad";
        }

        // se compara si es menor de 65 años y tenga condicion especial mayor 65 anos
        if (($numEdad > $numTerceraEdad) and ($_POST["seqCondicionEspecial"] == $numCondicionEspecialMayor65 or
                $_POST["seqCondicionEspecial2"] == $numCondicionEspecialMayor65 or
                $_POST["seqCondicionEspecial3"] == $numCondicionEspecialMayor65)
        ) {
            $arrErrores[] = "Condicion especial errada para " .
                $_POST['txtNombre1'] . " " . $_POST['txtNombre2'] . " " .
                $_POST['txtApellido1'] . " " . $_POST['txtApellido2'] .
                " porque segun su fecha de nacimiento tiene menos de 65 años y se le esta asignando la condicion especial de Mayor de 65 Años";
        }

        // se compara si es tercera edad al momento de la actualizacion
        if (($numEdad <= $numTerceraEdad) and ($_POST['seqCondicionEspecial'] != $numCondicionEspecialMayor65 and
                $_POST['seqCondicionEspecial2'] != $numCondicionEspecialMayor65 and
                $_POST['seqCondicionEspecial3'] != $numCondicionEspecialMayor65)
        ) {
            $arrErrores[] = "Debe tener condicion especial de Mayor de 65 años para el ciudadano " .
                $_POST['txtNombre1'] . " " . $_POST['txtNombre2'] . " " .
                $_POST['txtApellido1'] . " " . $_POST['txtApellido2'];
        }

    }

    // Nivel Educativo y años aprobados
    if( intval( $_POST['seqNivelEducativo'] ) == 0 ){
        $arrErrores[] = "Seleccione un nivel educativo";
    }elseif( intval( $_POST['seqNivelEducativo'] ) != 1 and intval( $_POST['numAnosAprobados'] ) == 0 ){
        $arrErrores[] = "Seleccione los años aprobados según el nivel educativo seleccionado";
    }

    // Estado civil
    $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil"), "seqEstadoCivil", "bolActivo = 1");
    $seqEstadoCivil = $_POST['seqEstadoCivil'];
    if( ! isset( $arrEstadoCivil[ $seqEstadoCivil ] ) ){
        $arrErrores[] = "Seleccione un estado civil válido.";
    }

    // Estado civil
//    $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil"), "seqEstadoCivil", "bolActivo = 1");
//    $seqEstadoCivil = $_POST['seqEstadoCivil'];
//    if( ! isset( $arrEstadoCivil[ $seqEstadoCivil ] ) ){
//        $arrErrores[] = "Seleccione un estado civil válido.";
//    }elseif ( $seqEstadoCivil == 6 ){ // casado
//
//        $_POST['numConsecutivoCSCDL'] = 0;
//        $_POST['txtEntidadCSCDL'] = 0;
//        $_POST['seqEntidadCSCDL'] = "";
//        $_POST['txtCertificacionUnion'] = "";
//        $_POST['numConsecutivoUnion'] = 0;
//        $_POST['seqEntidadUnion'] = 0;
//        $_POST['seqCiudadUnion'] = 0;
//        $_POST['numNotariaSoltero'] = 0;
//        $_POST['seqCiudadSoltero'] = 0;
//
//        if(intval($_POST['numConsecutivoCasado']) == 0){
//            $arrErrores[] = "Digite el numero de consecutivo del soporte del estado civil";
//        }
//
//        if(intval($_POST['numNotariaCasado']) == 0){
//            $arrErrores[] = "Digite el numero de notaría del soporte del estado civil";
//        }
//
//        if(intval($_POST['seqCiudadCasado']) == 0){
//            $arrErrores[] = "Seleccione la ciudad para el soporte del estado civil";
//        }
//
//    }elseif( $seqEstadoCivil == 8){ // Casado(a) con Sociedad Conyugal Disuelta y Liquidada
//
//        $_POST['numConsecutivoCasado'] = 0;
//        $_POST['numNotariaCasado'] = 0;
//        $_POST['seqCiudadCasado'] = 0;
//        $_POST['txtCertificacionUnion'] = "";
//        $_POST['numConsecutivoUnion'] = 0;
//        $_POST['seqEntidadUnion'] = 0;
//        $_POST['seqCiudadUnion'] = 0;
//        $_POST['numNotariaSoltero'] = 0;
//        $_POST['seqCiudadSoltero'] = 0;
//
//        if(intval($_POST['numConsecutivoCSCDL']) == 0){
//            $arrErrores[] = "Digite el numero de consecutivo del soporte del estado civil";
//        }
//
//        if(trim($_POST['txtEntidadCSCDL']) == ""){
//            $arrErrores[] = "Seleccione la entidad del soporte del estado civil";
//        }elseif(trim($_POST['txtEntidadCSCDL']) == "Notaria" and intval($_POST['numNotariaCSCDL']) == 0){
//            $arrErrores[] = "Digite la notaria del soporte del estado civil";
//        }
//
//        if(intval($_POST['seqCiudadCSCDL']) == 0){
//            $arrErrores[] = "Seleccione la ciudad para el soporte del estado civil";
//        }
//
//    }elseif( $seqEstadoCivil == 2 ){ // soltero
//
//        $_POST['numConsecutivoCasado'] = 0;
//        $_POST['numNotariaCasado'] = 0;
//        $_POST['seqCiudadCasado'] = 0;
//        $_POST['numConsecutivoCSCDL'] = 0;
//        $_POST['seqEntidadCSCDL'] = "";
//        $_POST['seqCiudadCSCDL'] = 0;
//        $_POST['txtCertificacionUnion'] = "";
//        $_POST['numConsecutivoUnion'] = 0;
//        $_POST['seqEntidadUnion'] = 0;
//        $_POST['seqCiudadUnion'] = 0;
//
//        if(intval($_POST['numNotariaSoltero']) == 0){
//            $arrErrores[] = "Digite el numero de notaria del soporte del estado civil";
//        }
//
//        if(intval($_POST['seqCiudadSoltero']) == 0){
//            $arrErrores[] = "Seleccione la ciudad para el soporte del estado civil";
//        }
//
//    }elseif ($seqEstadoCivil == 7){ // soltero con union marital
//
//        $_POST['numConsecutivoCasado'] = 0;
//        $_POST['numNotariaCasado'] = 0;
//        $_POST['seqCiudadCasado'] = 0;
//        $_POST['numConsecutivoCSCDL'] = 0;
//        $_POST['txtEntidadCSCDL'] = "";
//        $_POST['seqCiudadCSCDL'] = 0;
//        $_POST['numNotariaSoltero'] = 0;
//        $_POST['seqCiudadSoltero'] = 0;
//
//        if(trim($_POST['txtCertificacionUnion']) == ""){
//            $arrErrores[] = "Seleccione el tipo de certificacion del estado civil";
//        }
//
//        if(doubleval($_POST['numConsecutivoUnion']) == ""){
//            $arrErrores[] = "Digite el numero de consecutivo de la certificación del estado civil";
//        }
//
//        if(trim($_POST['txtEntidadUnion']) == ""){
//            $arrErrores[] = "Seleccione la entidad de la certificacion del estado civil";
//        }elseif(trim($_POST['txtEntidadUnion']) == "Notaria" and intval($_POST['numNotariaUnion']) == 0){
//            $arrErrores[] = "Digite el numero de notaría de la certificación del estado civil";
//        }
//
//        if(intval($_POST['seqCiudadUnion']) == ""){
//            $arrErrores[] = "Seleccione la ciudad de la certificación del estado civil";
//        }
//
//    }

    // Si hay correo electronico debe ser valido
    if (trim($_POST['txtCorreo']) != "") {
        if (!mb_ereg("^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$", trim($_POST['txtCorreo']))) {
            $arrErrores[] = "No es un correo electrónico válido";
        }
    }

    // afiliacion a salud
    if( intval( $_POST['seqSalud'] ) == 0 ){
        $arrErrores[] = "Seleccione la afiliación a salud";
    }

    // Direccion
    if ($_POST['txtDireccion'] == "") {
        $arrErrores[] = "Debe dar una dirección para el hogar";
    }

    // ciudad y validaciones relacionadas
    if (intval($_POST['seqCiudad']) == 0) {
        $arrErrores[] = "Indique la ciudad de residencia";
    } elseif (intval($_POST['seqCiudad']) == 149) { // vive en bogota
        if (intval($_POST['seqLocalidad']) == 0) {
            $arrErrores[] = "Debe seleccionar una localidad";
        }
        if (intval($_POST['seqBarrio']) == 0) {
            $arrErrores[] = "Debe seleccionar un barrio perteneciente a la localidad";
        }
    } else { // fuera de bogota
        if (intval($_POST['seqLocalidad']) == 0) {
            $arrErrores[] = "Debe seleccionar la localidad 'Fuera de Bogota'";
        }
        if (intval($_POST['seqBarrio']) != 1142) {
            $arrErrores[] = "Debe seleccionar el barrio 'Fuera de Bogota'";
        }
    }
    $txtFormatoFijo    = "/^[0-9]{7}$/";
    $txtFormatoCelular = "/^[3]{1}[0-9]{9}$/";

    // Telefono Celular
    if ( ! preg_match( $txtFormatoCelular , trim( $_POST['numCelular'] ) ) ) {
    	$arrErrores[] = "El número telefonico celular debe tener 10 digitos y debe iniciar con el número 3";
    }

    // Telefono Fijo 1
    if( is_numeric( $_POST['numTelefono1'] ) == true and intval( $_POST['numTelefono1'] ) != 0 ){
    	if ( ! preg_match( $txtFormatoFijo , trim( $_POST['numTelefono1'] ) ) ) {
    		$arrErrores[] = "El número telefonico fijo 1 debe tener 7 digitos";
    	}
    }

    // Telefono Fijo 2
    if( is_numeric( $_POST['numTelefono2'] ) == true and intval( $_POST['numTelefono2'] ) != 0 ){
        if ( ! ( preg_match( $txtFormatoFijo , trim( $_POST['numTelefono2'] ) ) || preg_match( $txtFormatoCelular , trim( $_POST['numTelefono2'] ) ) ) ) {
            $arrErrores[] = "El número telefonico fijo 2 debe tener 7 o 10 digitos";
        }
    }

    // Modalidad
    $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad", "seqPlanGobierno"), "seqModalidad", "seqPlanGobierno = 3", "seqPlanGobierno DESC, txtModalidad");
    $seqModalidad = $_POST['seqModalidad'];
    if( ! isset( $arrModalidad[ $seqModalidad ] ) ){
        $arrErrores[] = "Debe seleccionar una modalidad válida";
    }

    // Solucion
    if (intval($_POST['seqSolucion']) == 1) {
        $arrErrores[] = "Debe seleccionar la solución que corresponda a la modalidad seleccionada";
    }

    /****************************************************************************************************************
     * INSERTANDO LA INFORMACION
     ***************************************************************************************************************/

    if (empty($arrErrores)) {

        $claCiudadano = new Ciudadano();
        $claFormulario = new FormularioSubsidios();

        // Verifica que no haya otra persona con el mismo nombre
        $sql = "
            SELECT
              seqCiudadano
            FROM T_CIU_CIUDADANO
            WHERE TRIM( txtNombre1 ) LIKE \"" . trim($_POST['txtNombre1']) . "\"
              AND TRIM( txtNombre2 ) LIKE \"" . trim($_POST['txtNombre2']) . "\"
              AND TRIM( txtApellido1 ) LIKE \"" . trim($_POST['txtApellido1']) . "\"
              AND TRIM( txtApellido2 ) LIKE \"" . trim($_POST['txtApellido2']) . "\"
        ";
        $objRes = $aptBd->execute($sql);
        if ($objRes->RecordCount() > 0) {
            $arrMensajes[] = "Existe otra persona con el mismo nombre pero con otro numero de documento";
        }

        // Colocando los datos del ciudadano
        $claCiudadano->bolLgtb = $_POST['bolLgtb'];
        $claCiudadano->fchNacimiento = $_POST['fchNacimiento'];
        $claCiudadano->numAnosAprobados = $_POST['numAnosAprobados'];
        $claCiudadano->numDocumento = $_POST['numDocumento'];
        $claCiudadano->seqCondicionEspecial = $_POST['seqCondicionEspecial'];
        $claCiudadano->seqCondicionEspecial2 = $_POST['seqCondicionEspecial2'];
        $claCiudadano->seqCondicionEspecial3 = $_POST['seqCondicionEspecial3'];
        $claCiudadano->seqEstadoCivil = $_POST['seqEstadoCivil'];
        $claCiudadano->seqEtnia = $_POST['seqEtnia'];
        $claCiudadano->seqGrupoLgtbi = $_POST['seqGrupoLgtbi'];
        $claCiudadano->seqNivelEducativo = $_POST['seqNivelEducativo'];
        $claCiudadano->seqOcupacion = $_POST['seqOcupacion'];
        $claCiudadano->seqSalud = $_POST['seqSalud'];
        $claCiudadano->seqSexo = $_POST['seqSexo'];
        $claCiudadano->seqTipoDocumento = $_POST['seqTipoDocumento'];
        $claCiudadano->seqTipoVictima = $_POST['seqTipoVictima'];
        $claCiudadano->txtApellido1 = $_POST['txtApellido1'];
        $claCiudadano->txtApellido2 = $_POST['txtApellido2'];
        $claCiudadano->txtNombre1 = $_POST['txtNombre1'];
        $claCiudadano->txtNombre2 = $_POST['txtNombre2'];
        $claCiudadano->valIngresos = $_POST['valIngresoHogar'];
        $claCiudadano->seqParentesco = 1; // Postulante principal

        // informacion del soporte de documento
//        $claCiudadano->fchExpedicion = $_POST['fchExpedicion'];
//        $claCiudadano->txtTipoSoporte = $_POST['txtTipoSoporte'];
//        $claCiudadano->txtEntidadDocumento = $_POST['txtEntidadDocumento'];
//        $claCiudadano->numIndicativoSerial = $_POST['numIndicativoSerial'];
//        $claCiudadano->numNotariaDocumento = $_POST['numNotariaDocumento'];
//        $claCiudadano->seqCiudadDocumento = $_POST['seqCiudadDocumento'];
//        $claCiudadano->numConsecutivoPartida = $_POST['numConsecutivoPartida'];
//        $claCiudadano->txtParroquiaPartida = $_POST['txtParroquiaPartida'];
//        $claCiudadano->seqCiudadPartida = $_POST['seqCiudadPartida'];

        // informacion del soporte de estado civil
//        $claCiudadano->numConsecutivoCasado = $_POST['numConsecutivoCasado'];
//        $claCiudadano->numNotariaCasado = $_POST['numNotariaCasado'];
//        $claCiudadano->seqCiudadCasado = $_POST['seqCiudadCasado'];
//        $claCiudadano->numConsecutivoCSCDL = $_POST['numConsecutivoCSCDL'];
//        $claCiudadano->txtEntidadCSCDL = $_POST['txtEntidadCSCDL'];
//        $claCiudadano->seqCiudadCSCDL = $_POST['seqCiudadCSCDL'];
//        $claCiudadano->numNotariaCSCDL = $_POST['numNotariaCSCDL'];
//        $claCiudadano->numNotariaSoltero = $_POST['numNotariaSoltero'];
//        $claCiudadano->seqCiudadSoltero = $_POST['seqCiudadSoltero'];
//        $claCiudadano->txtCertificacionUnion = $_POST['txtCertificacionUnion'];
//        $claCiudadano->numConsecutivoUnion = $_POST['numConsecutivoUnion'];
//        $claCiudadano->txtEntidadUnion = $_POST['txtEntidadUnion'];
//        $claCiudadano->numNotariaUnion = $_POST['numNotariaUnion'];
//        $claCiudadano->seqCiudadUnion = $_POST['seqCiudadUnion'];

        $seqCiudadano = $claCiudadano->ciudadanoExiste($_POST['seqTipoDocumento'], $_POST['numDocumento']);
        if ($seqCiudadano == 0) {
            $seqCiudadano = $claCiudadano->guardarCiudadano();
        } else {
            $claCiudadano->seqCiudadano = $seqCiudadano;
            $claCiudadano->editarCiudadano($seqCiudadano);
        }

        if( empty( $claCiudadano->arrErrores ) ){

            $claFormulario->arrCiudadano[$seqCiudadano] = $claCiudadano;
            $claFormulario->bolDesplazado = $_POST['bolDesplazado'];
            $claFormulario->fchInscripcion = date("Y-m-d H:i:s");
            $claFormulario->fchUltimaActualizacion = date("Y-m-d H:i:s");
            $claFormulario->numCelular = $_POST['numCelular'];
            $claFormulario->numTelefono1 = $_POST['numTelefono1'];
            $claFormulario->numTelefono2 = $_POST['numTelefono2'];
            $claFormulario->seqBarrio = $_POST['seqBarrio'];
            $claFormulario->seqCiudad = $_POST['seqCiudad'];
            $claFormulario->seqEstadoProceso = $_POST['seqEstadoProceso'];
            $claFormulario->seqLocalidad = $_POST['seqLocalidad'];
            $claFormulario->seqModalidad = $_POST['seqModalidad'];

            // para las modalidades de cierre financiero y leasing  el esquema
            // se obliga a que sea proyecto de la sdht
            // las otras modalidades quedan con valor neutro
            if( $claFormulario->seqModalidad == 12 or $claFormulario->seqModalidad == 13 ){
                $claFormulario->seqTipoEsquema = 9;
            }

            $claFormulario->seqPlanGobierno = $_POST['seqPlanGobierno'];
            $claFormulario->seqPuntoAtencion = $_SESSION['seqPuntoAtencion'];
            $claFormulario->seqSolucion = $_POST['seqSolucion'];
            $claFormulario->seqTipoDireccion = $_POST['seqTipoDireccion'];
            $claFormulario->seqUpz = $_POST['seqUpz'];
            $claFormulario->seqUsuario = $_SESSION['seqUsuario'];
            $claFormulario->txtBarrio = obtenerNombres("T_FRM_BARRIO", "seqBarrio", $_POST['seqBarrio']);
            $claFormulario->txtCorreo = $_POST['txtCorreo'];
            $claFormulario->txtDireccion = $_POST['txtDireccion'];
            $claFormulario->valIngresoHogar = $_POST['valIngresoHogar'];

            $seqFormulario = $claFormulario->guardarFormulario();
            if( empty( $claFormulario->arrErrores ) ){
                $claFormulario->relacionarCiudadanoFormulario();
                if( ! empty($claFormulario->arrErrores) ){
                    $claCiudadano->borrarCiudadano();
                    $claFormulario->borrarFormulario($seqFormulario);
                    $arrErrores = $claFormulario->arrErrores;
                }
            }else{
                $claCiudadano->borrarCiudadano();
                $arrErrores = $claFormulario->arrErrores;
            }

        }else{
            $claCiudadano->borrarCiudadano();
            $arrErrores = $claCiudadano->arrErrores;
        }

    }

    if( empty( $arrErrores ) ){
        $claSeguimiento = new Seguimiento();

        $_POST['seqFormulario'] = $claFormulario->seqFormulario;
        $_POST['cedula'] = $_POST['numDocumento'];
        $_POST['nombre'] = trim($_POST['txtNombre1']) . " ";
        $_POST['nombre'].= ( trim($_POST['txtNombre2']) == "")? "" : trim($_POST['txtNombre2']) . " ";
        $_POST['nombre'].= trim($_POST['txtApellido1']) . " ";
        $_POST['nombre'].= ( trim($_POST['txtApellido2']) == "")? "" : trim($_POST['txtApellido2']);

        $claSeguimiento->salvarSeguimiento($_POST,"cambiosInscripcion");
        if( ! empty( $claSeguimiento->arrErrores ) ){
            $arrErrores = $claSeguimiento->arrErrores;
        }else{
            foreach ($claSeguimiento->arrMensajes as $txtMensaje) {
                $arrMensajes[] = $txtMensaje;
            }
        }
    }

    imprimirMensajes($arrErrores,$arrMensajes);

?>