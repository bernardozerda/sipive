<?php

$txtPrefijoRuta = "../../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );


$claSeguimiento = new SeguimientoProyectos();

if (file_exists($txtPrefijoRuta . '' . $_POST['ruta'])) {
    $idProyecto = $_REQUEST['idProyecto'];
    $retorna = "";
    $nameArchivo = explode("_", $_POST['ruta']);
    $type = $_POST['seqInformes'];
    $seqGestion = $_POST['seqGestion'];
    $txtComentarios = $_POST['txtComentario'];
    $seqPryEstadoProceso = $_POST['seqPryEstadoProceso'];
    if (unlink($txtPrefijoRuta . '' . $_POST['ruta'])) {
        $retorna .="<div class='alert alert-success' style='font-size: 12px'><strong>Success!</strong> Se ha eliminado el archivo " . $nameArchivo[1] . "</div>";
        $arrayDatosProyNew = Array();
        $arrayDatosProyOld = Array();
        $arrayDatosProyOld[$idProyecto]['archivo'] = "El archivo Eliminados es : " . $nameArchivo[1];
        $arrayDatosProyNew[$idProyecto]['archivo'] = "";
        $claSeguimiento->almacenarSeguimiento($idProyecto, $txtComentarios, $seqGestion, $arrayDatosProyOld, $arrayDatosProyNew);
    } else {
        $retorna .="<div class='alert alert-danger' style='font-size: 12px'><strong>Success!</strong> No se ha podido eliminar el archivo " . $nameArchivo[1] . "</div>";
    }
    $destino = '../../../recursos/proyectos/proyecto-' . $idProyecto . '/liquidacion/';
    $tmax = 200000;


    if (!file_exists($destino)) {
        mkdir($destino, 0777, true);
    }
    chmod($destino, 0777);

    $url = str_replace('index.php', '', $_SERVER['HTTP_REFERER']);
    $dir = @dir($destino);
    $arraArchivos = Array();
    if ($dir) {
        while (($archivo = $dir->read()) !== false) {
            if ($archivo[0] != ".") {
                $arraArchivos[] = 'proyecto-' . $idProyecto . '/liquidacion/' . $archivo;
                continue;
            }
        }
    }

    $countNombre = count($arraArchivos) + 1;
    $retorna .= "<div class='col-md-3'>
                    <label class='control-label' >Tipo Archivo</label>
                    <select name='seqInformes'
                            id='seqInformes'
                            style='width:170px;' 
                            class='form-control required' >                              
                        <option value=''>Seleccione</option>
                        <option value='Informe-de-Interventoria'>Informe de Interventoria</option>
                        <option value='Informe-Fiducia'>Informe Fiducia</option>
                        <option value='Informe'>Informe</option>
                        <option value='Revision-Oferente'>Revisión Oferente</option>
                    </select>
                    <input type='hidden' name='idProyecto' id='idProyecto' value='" . $idProyecto . "' />
                    <div id='val_seqInformes' class='divError'>Debe Seleccionar un tipo de informe</div> 
                </div>

                <div class='col-md-5' style='text-align: left'>                        
                    <div class='custom-file'>
                        <input type='file' name='archivoInforme' class='custom-file-input required' id='customFile' >
                        <label class='custom-file-label' for='customFile' id='nameInforme' onclick='fileActionUnit(\"nameInforme\");' >Seleccione Archivo</label>
                    </div>    
                    <p>&nbsp;</p><br>
                    <div id='val_customFile' class='divError'>Debe Seleccionar un archivo</div> 
                </div>
                <div class='col-md-2' id='idProgress' style='display: none;'>
                    <label class='control-label' >&nbsp;</label><br>
                    <div class='progress progress-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100' aria-valuenow='0'>
                        <div class='progress-bar progress-bar-success' style='width:10%;'></div>
                    </div>
                </div>
                <div class='col-md-2' >
                    <label class='control-label' >&nbsp;</label><br>
                    <input type='button' class='btn_volver subir' value='Importar&nbsp;' id='subir'  onclick='SubirInformes(\"frmProyectos\");'/>
                </div>
                <div class='col-md-12' ><p>&nbsp;</p><p>&nbsp;</p> </div>
            ";
    $retorna .= "<table role='presentation' class='table table-striped'>
    <tbody class='files'>";
    foreach ($arraArchivos as $key => $value) {
        $nombreArchivo = explode("/", $value)[2];
        $name = explode("_", $nombreArchivo);
        $retorna .=" <tr class='template-download fade in'><td>" . str_replace('-', ' ', $name[0]) . "</td><td style='padding: 12px; margin: 0'><p class='name'>
                    <a href='recursos/proyectos/proyecto-" . $idProyecto . "/liquidacion/" . $nombreArchivo . " ' title='' download='" . $nombreArchivo . "'>" . $nombreArchivo . "</a>
                </p>
            </td>
            <td style='padding: 12px; margin: 0; text-align: center'>" . round(filesize($destino . '' . $nombreArchivo) / 1024, 2) . " Kb </td>
             <td style='padding: 0; margin: 0; text-align: center'>
                <button class='btn btn-danger delete' data-type='Eliminar' data-url='' style='margin: 5px' onclick='eliminarArchivo(\"recursos/proyectos/proyecto-" . $idProyecto . "/liquidacion/" . $nombreArchivo . "\");'>
                    <i class='glyphicon glyphicon-trash'></i>
                    <span>Eliminar</span>
                </button>                
                </td></tr>
        ";
    }
    $retorna .= " </tbody></table>";

    echo $retorna;
} else {
    echo "no se encuentra archivo";
}
//var_dump($_FILES);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
