<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Estilos CSS -->        
        <link href="librerias/bootstrap/css/bootstrap.css" rel="stylesheet">        
        <link href="librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    </head>
    <body> 
        <div style="width: 25%; float: left;">
            <ul class="nav nav-pills nav-stacked" >
                <li class="active"><a href="javascript:void(0)">Opciones Cargue masivo</a></li>
                <li ><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosInformacionSolucion/index.php');">Cargue Informaci&oacute;n Soluci&oacute;n</a></li>
                <li><a href="javascript:void(0)" onClick=" cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/migracionEstudiosTecnicosPryDes/index.php');">Migraci&oacute;n Estudios T&eacute;cnicos Proyectos a Desembolsos</a></li>
                <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosLegalizacion/index.php');" >Cargue Unidades Legalizadas</a></li>
                <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/masivoPlantillaEscrituracion/index.php');">Carga Masiva de Escrituración</a></li>
                <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosEstudioTitulos/index.php');">Migraci&oacute;n Masiva de Estudio de Titulos</a></li>
            </ul>
        </div>
        <div style="width: 73%; float: right;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td colspan="2" align="center" valign="top" id="contenidoLegalizacion" class="tituloLogin">Seleccione el m&oacute;dulo de legalizaci&oacute;n</td>
                </tr>
            </table>
        </div>

    </body>
</html>

