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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CiudadanoActo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidiosActos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$arrErrores = array();



/* * ************************************************************************************************************
 * VALIDACION DE LOS CAMPOS OBLIGATORIOS Y REGLAS DE NEGOCIO
 * ************************************************************************************************************ */

// Grupo de Gestion 
if (intval($_POST['seqGrupoGestion']) == 0) {
    $arrErrores[] = "Seleccione el grupo de la gestión realizada";
}

// Grstion
if (intval($_POST['seqGestion']) == 0) {
    $arrErrores[] = "Seleccione la gestión realizada";
}

// Comentarios
if (trim($_POST['txtComentario']) == "") {
    $arrErrores[] = "Por favor diligencie el campo de comentarios";
}

/*
// Documento
$_POST['numDocumento'] = mb_ereg_replace("[^0-9]", "", $_POST['numDocumento']);
if (intval($_POST['numDocumento']) == 0) {
    $arrErrores[] = "El Documento no puede estar vacio";
}

// Tipo de documento
echo "doc ->".($_POST['seqTipoDocumento']);
//var_dump($_POST);
if (in_array(intval($_POST['seqTipoDocumento']), array(0, 6, 4, 3))) {
    $arrErrores[] = "El tipo de documento seleccionado no es válido";
}

// Primer nombre
if (trim($_POST['txtNombre1']) == "") {
    $arrErrores[] = "El ciudadano debe tener primer nombre";
}

// Primer apellido
if (trim($_POST['txtApellido1']) == "") {
    $arrErrores[] = "El ciudadano debe tener primer apellido";
}

// Estado civil
if (in_array($_POST['seqEstadoCivil'], array(0, 1, 3, 4, 5))) {
    $arrErrores[] = "No puede utilizar este estado civil para el ciudadano.";
}

// Si hay correo electronico debe ser valido
if (trim($_POST['txtCorreo']) != "") {
    if (!ereg("^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$", trim($_POST['txtCorreo']))) {
        $arrErrores[] = "No es un correo electrónico válido";
    }
}

//localidad
if (intval($_POST['seqLocalidad']) == 0) {
    $arrErrores[] = "El Campo Localidad no puede estar vacio";
}

// Direccion
if ($_POST['txtDireccion'] == "") {
    $arrErrores[] = "Debe dar una dirección para el hogar";
}

// Ciudad
if (intval($_POST['seqCiudad']) == 0) {
    $arrErrores[] = "Debe seleccionar una ciudad";
}

// Localidad
if (intval($_POST['seqLocalidad']) == 1 or intval($_POST['seqLocalidad']) == 0) {
    $arrErrores[] = "Seleccione una localidad";
}

// Barrio
if (intval($_POST['seqBarrio']) == 0) {
    $arrErrores[] = "Seleccione el barrio";
}



$exregfijo = "/^[0-9]{7}$/";
$exregcel = "/^[3]{1}[0-9]{9}$/";
if ($_POST['numTelefono1'] == "" and $_POST['numCelular'] == "") {
    $arrErrores[] = "El ciudadano debe tener un telefono de contacto";
} else {
    if ($_POST['numTelefono1'] != "" && $_POST['numTelefono1'] != 0) {
        if (!preg_match($exregfijo, $_POST['numTelefono1'])) {
            $arrErrores[] = "El Numero Telefonico no puede ser menor ni mayor a 7 digitos";
        }
    }
    if ($_POST['numCelular'] != "" && $_POST['numCelular'] != 0) {
        if (!preg_match($exregcel, $_POST['numCelular'])) {
            $arrErrores[] = "El Numero celular no puede ser menor ni mayor a 10 digitos y debe empezar por 3";
        }
    }
}

// Valor del arriendo
$_POST['valArriendo'] = mb_ereg_replace("[^0-9]", "", $_POST['valArriendo']);
if (intval($_POST['seqVivienda']) == 1) {
    if (intval($_POST['valArriendo']) == 0) {
        $arrErrores[] = "De indicar el valor del arrendamiento para el hogar";
    }
}

// Modalidad (usar solo las de plan de gobierno bogota humana)
if (in_array(intval($_POST['seqModalidad']), array(0, 1, 5, 2, 3, 4))) {
    $arrErrores[] = "Debe seleccionar una modalidad de subsidio valida";
}

// Solucion
if (intval($_POST['seqSolucion']) == 1) {
    $arrErrores[] = "Debe seleccionar la solución que corresponda a la modalidad seleccionada";
}

// Ingresos del hogar
$_POST['valIngresoHogar'] = mb_ereg_replace("[^0-9]", "", $_POST['valIngresoHogar']);
//	if( intval( $_POST['valIngresoHogar'] ) == 0 ){
//		$arrErrores[] = "Debe digitar un valor en el campo de ingresos";
//	}
// Si tiene valor ahorrado debe seleccionar en cual banco 
$_POST['valSaldoCuentaAhorro'] = mb_ereg_replace("[^0-9]", "", $_POST['valSaldoCuentaAhorro']);
if (intval($_POST['valSaldoCuentaAhorro']) != 0 and intval($_POST['seqBancoCuentaAhorro']) == 1) {
    $arrErrores[] = "Debe indicar el banco en donde están los recursos del ahorro";
}

// Si tiene valor de credito debe seleccionar en que banco
$_POST['valCredito'] = mb_ereg_replace("[^0-9]", "", $_POST['valCredito']);
if (intval($_POST['valCredito']) != 0 and intval($_POST['seqBancoCredito']) == 1) {
    $arrErrores[] = "Debe indicar el banco en donde tiene el crédito";
}

// Si tiene valor Subsidio Nacional debe ingresar el No. Carta soporte del subsidio
$_POST['valSubsidioNacional'] = mb_ereg_replace("[^0-9]", "", $_POST['valSubsidioNacional']);
if (intval($_POST['valSubsidioNacional']) != 0 and trim($_POST['txtSoporteSubsidioNacional']) == "") {
    $arrErrores[] = "Debe indicar el soporte del subsidio nacional";
}

// Si tiene valor de donacion debe indicar la empresa
$_POST['valDonacion'] = mb_ereg_replace("[^0-9]", "", $_POST['valDonacion']);
if (intval($_POST['valDonacion']) != 0 and intval($_POST['seqEmpresaDonante']) == 1) {
    $arrErrores[] = "Debe indicar que empresa ha dado la donación o reconocimiento económico";
}

// Si tiene seleccionado un banco para el ahorro, el valor del ahorro debe ser mayor a 0
if (intval($_POST['seqBancoCuentaAhorro']) != 1 and intval($_POST['valSaldoCuentaAhorro']) == 0) {
    $arrErrores[] = "El valor del ahorro debe ser mayor a 0";
}

// Si tiene seleccionado un banco para el credito, el valor del credito debe ser mayor a 0
if (intval($_POST['seqBancoCredito']) != 1 and intval($_POST['valCredito']) == 0) {
    $arrErrores[] = "El valor del crédito debe ser mayor a 0";
}

// Si tiene algun soporte de subsidio nacional, el valor del subsidio nacional debe ser mayor a 0
if (intval($_POST['txtSoporteSubsidioNacional']) != "" and intval($_POST['valSubsidioNacional']) == 0) {
    $arrErrores[] = "El valor del subsidio nacional debe ser mayor a 0";
}

// Si tiene seleccionada una emtidad para la donación, el valor de la donación debe ser mayor a 0
if (intval($_POST['seqEmpresaDonante']) != 1 and intval($_POST['valDonacion']) == 0) {
    $arrErrores[] = "El valor de la Donación - Reconocimiento Económico debe ser mayor a 0";
}*/

// Verifica que no haya otra persona con el mismo nombre
if (intval($_POST['seqFormularioActo']) == 0) {
    $sql = "
                SELECT
                seqCiudadano
                FROM  t_aad_ciudadano_acto
                WHERE TRIM( txtNombre1 ) LIKE \"" . trim($_POST['txtNombre1']) . "\"
                  AND TRIM( txtNombre2 ) LIKE \"" . trim($_POST['txtNombre2']) . "\"
                  AND TRIM( txtApellido1 ) LIKE \"" . trim($_POST['txtApellido1']) . "\"
                  AND TRIM( txtApellido2 ) LIKE \"" . trim($_POST['txtApellido2']) . "\"
            ";
    $objRes = $aptBd->execute($sql);
    if ($objRes->RecordCount() > 0) {
        $arrMensajes[] = "Existe otra persona con el mismo nombre pero con otro numero de documento";
    }
}

// calcula el valor del subsidio
$_POST['valSubsidio'] = 0;
$sql = "
            SELECT valSubsidio
            FROM T_FRM_VALOR_SUBSIDIO
            WHERE seqSolucion = " . intval($_POST['seqSolucion']) . "
              AND seqModalidad = " . intval($_POST['seqModalidad']) . "
        ";
$objRes = $aptBd->execute($sql);
if ($objRes->fields) {
    $_POST['valSubsidio'] = $objRes->fields['valSubsidio'];
}

/* * **************************************************************************************************************
 * INSERTANDO LA INFORMACION
 * ************************************************************************************************************* */

$claCiudadano = new CiudadanoActo();
$claFormulario = new FormularioSubsidiosActos();
$claSeguimiento = new Seguimiento();

// Insertando el hogar
//print_r($arrErrores);
if (empty($arrErrores)) {
 
    if (intval($_POST['seqFormularioActo']) == 0) {
        // el usuario debe poder crear registros
        if ($_SESSION['privilegios']['crear'] == 1) {
            $claCiudadano->numDocumento = $_POST['numDocumento'];
            $claCiudadano->seqTipoDocumento = $_POST['seqTipoDocumento'];
            $claCiudadano->txtNombre1 = trim($_POST['txtNombre1']);
            $claCiudadano->txtNombre2 = trim($_POST['txtNombre2']);
            $claCiudadano->txtApellido1 = trim($_POST['txtApellido1']);
            $claCiudadano->txtApellido2 = trim($_POST['txtApellido2']);
            $claCiudadano->fchNacimiento = "";
            $claCiudadano->seqSexo = $_POST['seqSexo'];
            $claCiudadano->seqEstadoCivil = $_POST['seqEstadoCivil'];
            $claCiudadano->seqEtnia = $_POST['seqEtnia'];
            $claCiudadano->seqCondicionEspecial = $_POST['seqCondicionEspecial'];
            $claCiudadano->seqCondicionEspecial2 = $_POST['seqCondicionEspecial2'];
            $claCiudadano->seqCondicionEspecial3 = $_POST['seqCondicionEspecial3'];
            $claCiudadano->seqNivelEducativo = $_POST['seqNivelEducativo'];
            $claCiudadano->seqGrupoLgtbi = $_POST['seqGrupoLgtbi'];
            $claCiudadano->bolLgtb = $_POST['bolLgtb'];
            $claCiudadano->seqTipoVictima = $_POST['seqTipoVictima'];
            $claCiudadano->seqOcupacion = $_POST['seqOcupacion'];
            $claCiudadano->valIngresos = $_POST['valIngresoHogar'];
            $claCiudadano->seqParentesco = 1;

            $seqCiudadanoActo = $claCiudadano->ciudadanoExiste($_POST['seqTipoDocumento'], $_POST['numDocumento']);
            if ($seqCiudadano == 0) {
                $seqCiudadano = $claCiudadano->guardarCiudadano();
            } else {
                $claCiudadano->editarCiudadano($seqCiudadanoActo);
            }

            if (intval($seqCiudadano) != 0) {

                $valTotalRecursos = $_POST['valSaldoCuentaAhorro'] +
                        $_POST['valSubsidioNacional'] +
                        $_POST['valCredito'] +
                        $_POST['valDonacion'];



                $claFormulario->txtDireccion = $_POST['txtDireccion'];
                $claFormulario->seqTipoDireccion = $_POST['seqTipoDireccion'];
                $claFormulario->numTelefono1 = $_POST['numTelefono1'];
                $claFormulario->numTelefono2 = $_POST['numTelefono2'];
                $claFormulario->numCelular = $_POST['numCelular'];
                $claFormulario->txtBarrio = obtenerNombres("T_FRM_BARRIO", "seqBarrio", $_POST['seqBarrio']);
                $claFormulario->txtCorreo = $_POST['txtCorreo'];
                $claFormulario->txtMatriculaInmobiliaria = "";
                $claFormulario->txtChip = "";
                $claFormulario->bolViabilizada = 0;
                $claFormulario->bolIdentificada = 0;
                $claFormulario->bolDesplazado = $_POST['bolDesplazado'];
                $claFormulario->seqSolucion = $_POST['seqSolucion'];
                $claFormulario->valPresupuesto = 0;
                $claFormulario->valAvaluo = 0;
                $claFormulario->valTotal = 0;
                $claFormulario->seqModalidad = $_POST['seqModalidad'];
                $claFormulario->seqPlanGobierno = $_POST['seqPlanGobierno'];
                $claFormulario->seqBancoCuentaAhorro = $_POST['seqBancoCuentaAhorro'];
                $claFormulario->fchAperturaCuentaAhorro = "";
                $claFormulario->bolInmovilizadoCuentaAhorro = "";
                $claFormulario->valSaldoCuentaAhorro = $_POST['valSaldoCuentaAhorro'];
                $claFormulario->txtSoporteCuentaAhorro = "";
                $claFormulario->seqBancoCuentaAhorro2 = 1;
                $claFormulario->fchAperturaCuentaAhorro2 = "";
                $claFormulario->bolInmovilizadoCuentaAhorro2 = "";
                $claFormulario->valSaldoCuentaAhorro2 = "";
                $claFormulario->txtSoporteCuentaAhorro2 = "";
                $claFormulario->valSubsidioNacional = $_POST['valSubsidioNacional'];
                $claFormulario->txtSoporteSubsidioNacional = $_POST['txtSoporteSubsidioNacional'];
                $claFormulario->seqEntidadSubsidio = $_POST['seqEntidadSubsidio'];
                $claFormulario->txtSoporteSubsidio = "";
                $claFormulario->valAporteLote = 0;
                $claFormulario->txtSoporteAporteLote = "";
                $claFormulario->seqCesantias = 1;
                $claFormulario->valSaldoCesantias = 0;
                $claFormulario->txtSoporteCesantias = "";
                $claFormulario->valAporteAvanceObra = 0;
                $claFormulario->txtSoporteAvanceObra = "";
                $claFormulario->valAporteMateriales = 0;
                $claFormulario->txtSoporteAporteMateriales = "";
                $claFormulario->seqEmpresaDonante = $_POST['seqEmpresaDonante'];
                $claFormulario->valDonacion = $_POST['valDonacion'];
                $claFormulario->txtSoporteDonacion = "";
                $claFormulario->seqBancoCredito = $_POST['seqBancoCredito'];
                $claFormulario->valCredito = $_POST['valCredito'];
                $claFormulario->txtSoporteCredito = "";
                $claFormulario->valTotalRecursos = $valTotalRecursos;
                $claFormulario->valAspiraSubsidio = $_POST['valSubsidio'];
                $claFormulario->seqVivienda = $_POST['seqVivienda'];
                $claFormulario->valArriendo = $_POST['valArriendo'];
                $claFormulario->bolPromesaFirmada = 0;
                $claFormulario->fchInscripcion = date("Y-m-d H:i:s");
                $claFormulario->fchPostulacion = "";
                $claFormulario->fchVencimiento = "";
                $claFormulario->bolIntegracionSocial = 0;
                $claFormulario->bolSecSalud = 0;
                $claFormulario->bolSecEducacion = 0;
                $claFormulario->bolIpes = 0;
                $claFormulario->bolReconocimientoFP = 0;
                $claFormulario->txtOtro = "";
                $claFormulario->numAdultosNucleo = 1;
                $claFormulario->numNinosNucleo = 0;
                $claFormulario->seqUsuario = $_SESSION['seqUsuario'];
                $claFormulario->seqPuntoAtencion = $_SESSION['seqPuntoAtencion'];
                $claFormulario->bolCerrado = 0;
                $claFormulario->seqLocalidad = $_POST['seqLocalidad'];
                $claFormulario->seqCiudad = $_POST['seqCiudad'];
                $claFormulario->valIngresoHogar = $_POST['valIngresoHogar'];
                $claFormulario->seqEstadoProceso = $_POST['seqEstadoProceso'];
                $claFormulario->txtDireccionSolucion = "";
                $claFormulario->fchAprobacionCredito = "";
                $claFormulario->txtFormulario = "";
                $claFormulario->fchUltimaActualizacion = date("Y-m-d H:i:s");
                $claFormulario->seqProyecto = 37;
                $claFormulario->seqUnidadProyecto = 0;
                $claFormulario->seqProyectoHijo = 0;
                $claFormulario->numCortes = 0;
                $claFormulario->seqPeriodo = 1;
                $claFormulario->fchArriendoDesde = "";
                $claFormulario->bolSancion = 0;
                $claFormulario->fchVigencia = "";
                $claFormulario->seqUpz = $_POST['seqUpz'];
                $claFormulario->seqBarrio = $_POST['seqBarrio'];
                $claFormulario->seqSisben = 1;
                $claFormulario->fchNotificacion = "";
                $claFormulario->txtComprobanteArriendo = "";
                $claFormulario->numPuntajeSisben = 0;
                //$claFormulario->seqTipoEsquema = 1;
                $claFormulario->seqTipoEsquema = $_POST['seqTipoEsquema'];
                $claFormulario->arrCiudadano[$seqCiudadanoActo] = $claCiudadano;
//var_dump($claFormulario);
                $seqFormularioActo = $claFormulario->guardarFormulario();
                if ($seqFormulario != 0) {
                    try {
                        $sql = "
                            INSERT INTO  t_aad_hogar_acto (
                              seqCiudadanoActo,
                              seqFormularioActo,                             
                              seqParentesco
                            ) VALUES (
                              $seqCiudadanoActo,
                              $seqFormularioActo,
                              0,
                              1
                            )
                         ";
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se ha podido guardar la informacion del hogar, consulte al administrador.";
                        //$claCiudadano->borrarCiudadano($seqCiudadano);
                        $claFormulario->borrarFormulario($seqFormularioActo);
                    }
                } else { // error al salvar el formulario
                    $arrErrores[] = $claFormulario->arrErrores;
                    $claCiudadano->borrarCiudadano($seqCiudadanoActo);
                }
            } else { // error al salvar el ciudadano
                $arrErrores[] = $claCiudadano->arrErrores;
            }
        } else { // sin permisos para crear
            $arrErrores[] = "No tiene privilegios para realizar inscripciones";
        }

        $claFormularioAnterior = new FormularioSubsidiosActos();
        $claFormularioAnterior->cargarFormulario(0);
      
        $txtCambios = $claSeguimiento->cambiosPostulacionActo($seqFormularioActo, $claFormularioAnterior, $claFormulario);
    } else {         

        $claCiudadanoNuevo = new CiudadanoActo();
        $claFormularioNuevo = new FormularioSubsidiosActos();
        $claSeguimiento = new Seguimiento();

        // Datos Ciudadano Existente

        $claCiudadano->numDocumento = $_POST['numDocumento'];
        $claCiudadano->seqTipoDocumento = $_POST['seqTipoDocumento'];
        $claCiudadano->txtNombre1 = trim($_POST['txtNombre1']);
        $claCiudadano->txtNombre2 = trim($_POST['txtNombre2']);
        $claCiudadano->txtApellido1 = trim($_POST['txtApellido1']);
        $claCiudadano->txtApellido2 = trim($_POST['txtApellido2']);
        $claCiudadano->fchNacimiento = "";
        $claCiudadano->seqSexo = $_POST['seqSexo'];
        $claCiudadano->seqEstadoCivil = $_POST['seqEstadoCivil'];
        $claCiudadano->seqEtnia = $_POST['seqEtnia'];
        $claCiudadano->seqCondicionEspecial = $_POST['seqCondicionEspecial'];
        $claCiudadano->seqCondicionEspecial2 = $_POST['seqCondicionEspecial2'];
        $claCiudadano->seqCondicionEspecial3 = $_POST['seqCondicionEspecial3'];
        $claCiudadano->seqNivelEducativo = $_POST['seqNivelEducativo'];
        $claCiudadano->seqGrupoLgtbi = $_POST['seqGrupoLgtbi'];
        $claCiudadano->bolLgtb = $_POST['bolLgtb'];
        $claCiudadano->seqTipoVictima = $_POST['seqTipoVictima'];
        $claCiudadano->seqOcupacion = $_POST['seqOcupacion'];
        $claCiudadano->valIngresos = $_POST['valIngresoHogar'];
        $claCiudadano->seqParentesco = 1;

        // coloca los datoa del post en el formulario
        $claFormularioNuevo->seqFormulario = $_POST['seqFormulario'];
        $claFormularioNuevo->txtDireccion = $_POST['txtDireccion'];
        $claFormularioNuevo->seqTipoDireccion = 0;
        $claFormularioNuevo->numTelefono1 = $_POST['numTelefono1'];
        $claFormularioNuevo->numTelefono2 = $_POST['numTelefono2'];
        $claFormularioNuevo->numCelular = $_POST['numCelular'];
        $claFormularioNuevo->txtBarrio = obtenerNombres("T_FRM_BARRIO", "seqBarrio", $_POST['seqBarrio']);
        $claFormularioNuevo->txtCorreo = $_POST['txtCorreo'];
        $claFormularioNuevo->txtMatriculaInmobiliaria = $_POST['txtMatriculaInmobiliaria'];
        $claFormularioNuevo->txtChip = $_POST['txtChip'];
        $claFormularioNuevo->bolViabilizada = $_POST['bolViabilizada'];
        $claFormularioNuevo->bolIdentificada = $_POST['bolIdentificada'];
        $claFormularioNuevo->bolDesplazado = $_POST['bolDesplazado'];
        $claFormularioNuevo->seqSolucion = $_POST['seqSolucion'];
        $claFormularioNuevo->valPresupuesto = $_POST['valPresupuesto'];
        $claFormularioNuevo->valAvaluo = $_POST['valAvaluo'];
        $claFormularioNuevo->valTotal = $_POST['valTotal'];
        $claFormularioNuevo->seqModalidad = $_POST['seqModalidad'];
        $claFormularioNuevo->seqPlanGobierno = $_POST['seqPlanGobierno'];
        $claFormularioNuevo->seqBancoCuentaAhorro = $_POST['seqBancoCuentaAhorro'];
        $claFormularioNuevo->fchAperturaCuentaAhorro = $_POST['fchAperturaCuentaAhorro'];
        $claFormularioNuevo->bolInmovilizadoCuentaAhorro = intval($_POST['bolInmovilizadoCuentaAhorro']);
        $claFormularioNuevo->valSaldoCuentaAhorro = $_POST['valSaldoCuentaAhorro'];
        $claFormularioNuevo->txtSoporteCuentaAhorro = $_POST['txtSoporteCuentaAhorro'];
        $claFormularioNuevo->seqBancoCuentaAhorro2 = $_POST['seqBancoCuentaAhorro2'];
        $claFormularioNuevo->fchAperturaCuentaAhorro2 = $_POST['fchAperturaCuentaAhorro2'];
        $claFormularioNuevo->bolInmovilizadoCuentaAhorro2 = intval($_POST['bolInmovilizadoCuentaAhorro2']);
        $claFormularioNuevo->valSaldoCuentaAhorro2 = $_POST['valSaldoCuentaAhorro2'];
        $claFormularioNuevo->txtSoporteCuentaAhorro2 = $_POST['txtSoporteCuentaAhorro2'];
        $claFormularioNuevo->valSubsidioNacional = $_POST['valSubsidioNacional'];
        $claFormularioNuevo->txtSoporteSubsidioNacional = $_POST['txtSoporteSubsidioNacional'];
        $claFormularioNuevo->txtSoporteSubsidio = $_POST['txtSoporteSubsidio'];
        $claFormularioNuevo->valAporteLote = $_POST['valAporteLote'];
        $claFormularioNuevo->txtSoporteAporteLote = $_POST['txtSoporteLote'];
        $claFormularioNuevo->seqCesantias = 1;
        $claFormularioNuevo->valSaldoCesantias = $_POST['valSaldoCesantias'];
        $claFormularioNuevo->txtSoporteCesantias = $_POST['txtSoporteCesantias'];
        $claFormularioNuevo->valAporteAvanceObra = $_POST['valAporteAvanceObra'];
        $claFormularioNuevo->txtSoporteAvanceObra = $_POST['txtSoporteAvanceObra'];
        $claFormularioNuevo->valAporteMateriales = $_POST['valAporteMateriales'];
        $claFormularioNuevo->txtSoporteAporteMateriales = $_POST['txtSoporteAporteMateriales'];
        $claFormularioNuevo->seqEntidadSubsidio = $_POST['seqEntidadSubsidio'];
        $claFormularioNuevo->seqEmpresaDonante = $_POST['seqEmpresaDonante'];
        $claFormularioNuevo->valDonacion = $_POST['valDonacion'];
        $claFormularioNuevo->txtSoporteDonacion = $_POST['txtSoporteDonacion'];
        $claFormularioNuevo->seqBancoCredito = $_POST['seqBancoCredito'];
        $claFormularioNuevo->valCredito = $_POST['valCredito'];
        $claFormularioNuevo->txtSoporteCredito = $_POST['txtSoporteCredito'];
        $claFormularioNuevo->valTotalRecursos = $_POST['valSaldoCuentaAhorro'] + $_POST['valSubsidioNacional'] + $_POST['valCredito'] + $_POST['valDonacion'];
        $claFormularioNuevo->valAspiraSubsidio = $_POST['valAspiraSubsidio'];
        $claFormularioNuevo->seqVivienda = $_POST['seqVivienda'];
        $claFormularioNuevo->valArriendo = $_POST['valArriendo'];
        $claFormularioNuevo->bolPromesaFirmada = $_POST['bolPromesaFirmada'];
        //if ($claFormularioNuevo->seqEstadoProceso == 35){
        //$claFormularioNuevo->fchInscripcion             = $claFormulario->fchInscripcion;
        $claFormularioNuevo->fchInscripcion = $_POST['fchInscripcion'];
        //}
        $claFormularioNuevo->fchPostulacion = $claFormulario->fchPostulacion;
        $claFormularioNuevo->fchVencimiento = $claFormulario->fchVencimiento;
        //$claFormularioNuevo->bolIntegracionSocial         = $_POST['bolIntegracionSocial'];
        $claFormularioNuevo->bolSecSalud = $_POST['bolSecSalud'];
        $claFormularioNuevo->bolSecEducacion = $_POST['bolSecEducacion'];
        //$claFormularioNuevo->bolIpes                      = $_POST['bolIpes'];
        $claFormularioNuevo->txtOtro = $_POST['txtOtro'];
        $claFormularioNuevo->numAdultosNucleo = $numAdultos;
        $claFormularioNuevo->numNinosNucleo = $numNinos;
        $claFormularioNuevo->seqUsuario = $_SESSION['seqUsuario'];
        $claFormularioNuevo->seqPuntoAtencion = $_SESSION['seqPuntoAtencion'];
        $claFormularioNuevo->bolCerrado = $_POST['bolCerrado'];
        $claFormularioNuevo->seqLocalidad = $_POST['seqLocalidad'];
        $claFormularioNuevo->seqCiudad = $_POST['seqCiudad'];
        $claFormularioNuevo->valIngresoHogar = $_POST['valIngresoHogar'];
        $claFormularioNuevo->seqEstadoProceso = $_POST['seqEstadoProceso'];
        $claFormularioNuevo->txtDireccionSolucion = $_POST['txtDireccionSolucion'];
        $claFormularioNuevo->fchAprobacionCredito = $_POST['fchAprobacionCredito'];
        $claFormularioNuevo->txtFormulario = $_POST['txtFormulario'];
        $claFormularioNuevo->fchUltimaActualizacion = date("y-m-d H:i:s");
        $claFormularioNuevo->seqProyecto = $_POST['seqProyecto'];
        $claFormularioNuevo->seqUnidadProyecto = 0;
        $claFormularioNuevo->seqProyectoHijo = 0;
        $claFormularioNuevo->numCortes = 0;
        $claFormularioNuevo->seqPeriodo = 1;
        $claFormularioNuevo->fchArriendoDesde = $_POST['fchArriendoDesde'];
        $claFormularioNuevo->bolSancion = $_POST['bolSancion'];
        $claFormularioNuevo->fchVigencia = $claFormulario->fchVigencia;
        $claFormularioNuevo->seqUpz = $_POST['seqUpz'];
        $claFormularioNuevo->seqBarrio = $_POST['seqBarrio'];
        $claFormularioNuevo->seqSisben = $_POST['seqSisben'];
        $claFormularioNuevo->fchNotificacion = $claFormulario->fchNotificacion;
        $claFormularioNuevo->txtComprobanteArriendo = $_POST['txtComprobanteArriendo'];
        $claFormularioNuevo->numPuntajeSisben = 0;
        $claFormularioNuevo->seqTipoEsquema = $_POST['seqTipoEsquema'];
        
        // edita los datos del formulario
        $claFormularioNuevo->editarFormulario($_POST['seqFormularioActo']);
        $seqFormulario = $_POST['seqFormulario'];
        $seqFormularioActo = $_POST['seqFormularioActo'];
        // si hay errores los pasa al arreglo de errores
        if (!empty($claFormularioNuevo->arrErrores)) {
            foreach ($claFormularioNuevo->arrErrores as $txtError) {
                $arrErrores[] = $txtError;
            }
        }
        $claFormularioAnterior = new FormularioSubsidiosActos();
       
        $claFormularioAnterior->cargarFormulario($_POST['seqFormularioActo']);
// echo "<br><br>paso postulacion 2<br><br>";
// var_dump($claFormularioNuevo);
// echo "<br><br>paso postulacion 2<br><br>";
// var_dump($claFormularioAnterior);
        $txtCambios = $claSeguimiento->cambiosPostulacionActo($seqFormularioActo, $claFormularioAnterior, $claFormularioNuevo);
        //echo $txtCambios;
        //$txtCambios = "El Hogar se actualiza";
    }
}
//print_r($arrErrores);
if (empty($arrErrores)) {

    $sql = "
             INSERT INTO T_SEG_SEGUIMIENTO ( 
                seqFormulario, 
                fchMovimiento, 
                seqUsuario, 
                txtComentario, 
                txtCambios, 
                numDocumento, 
                txtNombre, 
                seqGestion,
                bolMostrar
             ) VALUES (
                \"" . $seqFormularioActo . "\",
                now(),
                \"" . $_SESSION['seqUsuario'] . "\",
                \"" . mb_ereg_replace("\n", "", $_POST["txtComentario"]) . "\",
                \"" . mb_ereg_replace("\"", "", $txtCambios) . "\",
                \"" . $claCiudadano->numDocumento . "\",
                \"" . $claCiudadano->txtNombre1 . " " . $claCiudadano->txtNombre2 . " " . $claCiudadano->txtApellido1 . " " . $claCiudadano->txtApellido2 . "\",
                \"" . $_POST['seqGestion'] . "\",
                    2
             )
          ";
    //echo "<br>".$sql;
    try {
        $aptBd->execute($sql);
    } catch (Exception $objError) {
        $arrMensajes[] = "El formulario se ha salvado pero no ha quedado registro de la actividad, contacte al administrador";
    }
}

if (empty($arrErrores)) {
    $txtAccion = ( intval($_POST['seqFormulario']) != 0 ) ? "Actualizado" : "Ingresado";
    $arrMensajes[] = "El formulario se ha $txtAccion, Cedula [ " . number_format($claCiudadano->numDocumento) . " ]";
    $txtEstilo = "msgOk";
} else {
    $arrMensajes = $arrErrores;
    $txtEstilo = "msgError";
}

echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px'>";
foreach ($arrMensajes as $txtMensaje) {
    echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
}
echo "</table>";
?>