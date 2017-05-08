<?php

function validarSubida($archivo) {
    $_FILES['archivo'] = $archivo;


    if ($_FILES['archivo']['error'] != UPLOAD_ERR_NO_FILE) {
        $bolProhibidoAtras = true;

        // Errores en la carga de archivos
        switch ($_FILES['archivo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
                break;
            case UPLOAD_ERR_PARTIAL:
                $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
                break;
        }

        if (empty($arrErrores)) {

            // abre el 
            $aptArchivo = fopen($_FILES['archivo']['tmp_name'], "r");

            // validacion de titulos del archivo
            $txtTitulos = fgets($aptArchivo);
            $arrTitulos = split("\t", $txtTitulos);

            if (!is_array($arrTitulos)) {
                $arrErrores[] = "Al parecer el archivo no esta separado por tabulaciones";
            }

            if (strtolower(trim($arrTitulos[0])) != "documento") {
                $arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Documento\" ";
            }

            if (strtolower(trim($arrTitulos[1])) != "estado") {
                $arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Estado\" ";
            }

            if (strtolower(trim($arrTitulos[2])) != "comentario") {
                $arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Comentario\" ";
            }

            // validacion de las lineas del archivo
            $numLinea = 2;
            while ($txtLinea = fgets($aptArchivo)) {

                // obtiene los datos de la linea
                $arrLinea = split("\t", $txtLinea);
                $numDocumento = trim($arrLinea[0]);
                $seqEstadoProceso = trim($arrLinea[1]);
                $txtComentario = trim($arrLinea[2]);

                // validacion del numero de documento
                if (!is_numeric($numDocumento)) {
                    $arrErrores[] = "Error Linea $numLinea: El campo documento debe tener un valor numérico";
                }

                // validacion del estado
                if (!isset($arrEstadosNombre[$seqEstadoProceso])) {
                    $arrErrores[] = "Error Linea $numLinea: El estado del proceso $seqEstadoProceso no existe";
                }

                // si no hay comentario toma el del post
                $txtComentario = ( trim($txtComentario) == "" ) ? trim($_POST['txtComentario']) : trim($txtComentario);

                // numero de documento en la base de datos
                $seqFormulario = Ciudadano::formularioVinculado($numDocumento, false, true);
                if ($seqFormulario == 0) {
                    $arrErrores[] = "Error Linea $numLinea: El número de documento no existe en la base de datos";
                }

                // datos del archivo al arreglo
                $arrArchivo[$seqFormulario]['documento'] = $numDocumento;
                $arrArchivo[$seqFormulario]['estado'] = $seqEstadoProceso;
                $arrArchivo[$seqFormulario]['comentario'] = $txtComentario;

                // incrementa el numero de linea para el control
                $numLinea++;
            } // fin validacion de lineas
        }
    } else {
        
    }
}
?>

