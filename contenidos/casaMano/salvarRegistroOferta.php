<?php

    /**
     * SALVA LOS DATOS DE REGISTRO DE OFERTA EN EL ESQUEMA
     * DE CASA EN MANO
     * @author Bernardo Zerda
     * @version 1.0 Jul 2013
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
    include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php");

    // Verifica los permisos de creacion / edicion
    if (intval($_POST['seqCasaMano']) == 0) {
        if ($_SESSION["privilegios"]["crear"] != 1) {
            $arrErrores[] = "No tiene privilegios para salvar el registro";
        }
    } else {
        if ($_SESSION["privilegios"]["editar"] != 1) {
            $arrErrores[] = "No tiene privilegios para editar el registro";
        }
    }

    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($_POST['seqFormulario']);

    /****************************************************************************************************************
     * VALIDACIONES DE LA PESTAÑA DE DATOS DEL INMUEBLE
     ***************************************************************************************************************/

    $arrObligatorios['txtNombreVendedor'] = "Nombre del Vendedor";
    $arrObligatorios['numDocumentoVendedor'] = "Documento del Vendedor";
    $arrObligatorios['txtCompraVivienda'] = "Tipo de Vivienda";
    $arrObligatorios['numTelefonoVendedor'] = "N&uacute;mero de Tel&eacute;fono del Vendedor";
    $arrObligatorios['txtCorreoVendedor'] = "Correo Electr&oacute;nico";
    $arrObligatorios['txtDireccionInmueble'] = "Direcci&oacute;n del Inmueble";
    $arrObligatorios['seqCiudad'] = "Ciudad";
    $arrObligatorios['seqLocalidad'] = "Localidad";
    $arrObligatorios['seqBarrio'] = "Barrio";
    $arrObligatorios['txtMatriculaInmobiliaria'] = "Matr&iacute;cula Inmobiliaria";
    $arrObligatorios['txtChip'] = "CHIP";
    $arrObligatorios['txtCedulaCatastral'] = "Cedula Catastral";
    $arrObligatorios['numAreaLote'] = "Area del Lote o Porcentaje de Participaci&oacute;n";
    $arrObligatorios['numAreaConstruida'] = "Area Construida";
    $arrObligatorios['numAvaluo'] = "Valor del Avaluo del Inmueble";
    $arrObligatorios['numValorInmueble'] = "Valor del Inmueble";
    $arrObligatorios['txtTipoPredio'] = "Tipo de Predio";
    $arrObligatorios['numEstrato'] = "Estrato";
    $arrObligatorios['txtCorreoVendedor'] = "Correo del Vendedor";

    if ($_POST['txtCompraVivienda'] != "nueva") {
        switch ($_POST['txtPropiedad']) {
            case "escritura":
                $arrObligatorios['txtEscritura'] = "N&uacute;mero de la Escritura p&uacute;blica del Titulo de Propiedad";
                $arrObligatorios['fchEscritura'] = "Fecha de la Escritura p&uacute;blica del Titulo de Propiedad";
                $arrObligatorios['numNotaria'] = "N&uacute;mero de la Notar&iacute;a de la Escritura p&uacute;blica del Titulo de Propiedad";
                $arrObligatorios['txtCiudad'] = "Ciudad de la Escritura p&uacute;blica del Titulo de Propiedad";
                break;
            case "sentencia":
                $arrObligatorios['fchSentencia'] = "Fecha de la Sentencia del Titulo de Propiedad";
                $arrObligatorios['numJuzgado'] = "N&uacute;mero del Juzgado de la Sentencia del Titulo de Propiedad";
                $arrObligatorios['txtCiudadSentencia'] = "Ciudad de la Sentencia del Titulo de Propiedad";
                break;
            case "resolucion":
                $arrObligatorios['numResolucion'] = "N&uacute;mero de la Resoluci&oacute;n del Titulo de Propiedad";
                $arrObligatorios['fchResolucion'] = "Fecha de la Resoluci&oacute;n del Titulo de Propiedad";
                $arrObligatorios['txtEntidad'] = "Entidad de la Resoluci&oacute;n del Titulo de Propiedad";
                $arrObligatorios['txtCiudadResolucion'] = "Ciudad de la Resoluci&oacute;n del Titulo de Propiedad";
                break;
        }
    }

    /****************************************************************************************************************
     * VALIDACIONES DE LA PESTAÑA DE RECIBO DE DOCUMENTOS
     ***************************************************************************************************************/

    // Retorno o reubicacion
    if( $claFormulario->seqTipoEsquema == 11 ){
        if ($_POST['txtCompraVivienda'] == "nueva") {
            $arrObligatorios['numCertificadoTradicion'] = "Certificado de Tradicion y Libertad";
            $arrObligatorios['numAltoRiesgo'] = "Certificado de riesgo";
            $arrObligatorios['numHabitabilidad'] = "Certificado de Habitabilidad";
            $arrObligatorios['numBoletinCatastral'] = "Boletin Catastral";
            $arrObligatorios['numLicenciaConstruccion'] = "Licencia de Construcci&oacute;n";
            $arrObligatorios['numUltimoPredial'] = "Ultimo Recibo Predial";
            $arrObligatorios['numActaEntrega'] = "Certificado de Constructora de Entrega Inmueble";
        }else{
            $arrObligatorios['numCertificadoTradicion'] = "Certificado de Tradicion y Libertad";
            $arrObligatorios['numAltoRiesgo'] = "Certificado de riesgo";
            $arrObligatorios['numHabitabilidad'] = "Certificado de Habitabilidad";
            $arrObligatorios['numBoletinCatastral'] = "Boletin Catastral";
            $arrObligatorios['numUltimoPredial'] = "Último Recibo Predial";
            $arrObligatorios['numUltimoReciboAgua'] = "Último recibo de acueducto y alcantarillado";
            $arrObligatorios['numUltimoReciboEnergia'] = "Último recibo de Energ&iacute;a";
        }
    }elseif( $claFormulario->seqTipoEsquema == 10 ) { // proyectos fuera de la secretaría
        if ($_POST['txtCompraVivienda'] == "nueva") {
            $arrObligatorios['numCertificadoTradicion'] = "Certificado de Tradicion y Libertad";
            $arrObligatorios['numAltoRiesgo'] = "Certificado de riesgo";
            $arrObligatorios['numBoletinCatastral'] = "Boletin Catastral";
            $arrObligatorios['numLicenciaConstruccion'] = "Licencia de Construcci&oacute;n";
            $arrObligatorios['numUltimoPredial'] = "Ultimo Recibo Predial";
            $arrObligatorios['numActaEntrega'] = "Certificado de Constructora de Entrega Inmueble";
        }else{
            $arrErrores[] = "No puede tomar la opción de vivienda usada bajo el esquema de proyectos fuera de la secreataría";
        }

    } else{
        $arrErrores[] = "Esquema no permitido para el recibo de documentos ";
    }

    if ($_POST['documentos'] == "persona") {
        $arrObligatorios['numFotocopiaVendedor'] = "Fotocopia Cédula del Vendedor";
    } else {
        $arrObligatorios['numFotocopiaVendedor'] = "Fotocopia Cedula del Representante Legal";
        $arrObligatorios['numRut'] = "Fotocopia del RUT";
        $arrObligatorios['numRit'] = "Fotocopia del RIT";
    }

    // Si no hay errores se pasa a validar que los datos obligatorios esten diligenciados
    if(empty($arrErrores)) {
        foreach ($arrObligatorios as $txtClave => $txtValor) {
            if (isset($_POST[$txtClave])) {
                $bolError = false;
                switch (substr($txtClave, 0, 3)) {
                    case "num":
                        $bolError = (intval($_POST[$txtClave]) == 0) ? true : false;
                        break;
                    case "seq":
                        $bolError = (intval($_POST[$txtClave]) == 0) ? true : false;
                        break;
                    case "fch":
                        $bolError = (!esFechaValida(trim($_POST[$txtClave])));
                        break;
                    case "txt":
                        $bolError = (trim($_POST[$txtClave]) == "") ? true : false;
                        break;
                    default:
                        $bolError = (trim($_POST[$txtClave]) == "") ? true : false;
                        break;
                }
                if ($bolError == true) {
                    $arrErrores[] = "Debe dar un valor v&aacute;lido para el campo " . $arrObligatorios[$txtClave];
                }
            } else {
                $arrErrores[] = "Debe dar un valor v&aacute;lido para el campo " . $arrObligatorios[$txtClave];
            }
        }
    }

    // El valor del inmueble no debe superar ls 70 smmlv
    if (intval($_POST['numValorInmueble']) > ($arrConfiguracion['constantes']['salarioMinimo'] * 70)) {
        $arrErrores[] = "El Valor del Inmueble supera el l&iacute;mite permitido";
    }

    /****************************************************************************************************************
     * SALVA EL REGISTRO
     ***************************************************************************************************************/

    // Salvar el registro si no hay errores
    if (empty($arrErrores)) {

        $claCasaMano = new CasaMano();
        $seqCasaMano = $claCasaMano->salvar($_POST);

        if (!empty($claCasaMano->arrErrores)) {
            $arrErrores = $claCasaMano->arrErrores;
        }else{
            $arrMensajes = $claCasaMano->arrMensajes;
        }

    }

    /****************************************************************************************************************
     * IMPRIMIENDO MENSAJES
     ***************************************************************************************************************/

    imprimirMensajes($arrErrores,$arrMensajes);

?>
