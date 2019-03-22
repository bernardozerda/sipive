<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
//var_dump($_SESSION['arrGrupos']);
$array = $_SESSION['arrGrupos'];
$grupos = array();
$int = 0;
foreach ($array as $key => $value) {
    foreach ($value as $values) {
        $grupos[$int] = $values;
        $int++;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Estilos CSS -->        
        <script language="JavaScript" type="text/javascript" src="librerias/javascript/funciones.js"></script>
        <link href="librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    </head>
    <body> 
        <div style="width: 25%; float: left;">
            <ul class="nav nav-pills nav-stacked" >
                <li class="active"><a href="javascript:void(0)">Opciones Cargue masivo</a></li>
                <?php if (in_array("6", $grupos)) { ?>
                    <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/cargarRadicacion/index.php');">Radicaci&oacute;n Expedientes</a></li>
                <?php }if (in_array("7", $grupos) && in_array("8", $grupos) && in_array("9", $grupos)) { ?>
                    <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargueGeneralTablero/indexDS.php?code=17');">Remisi&oacute;n Datos Soluci&oacute;n</a></li>
                <?php } ?>
                <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosInformacionSolucion/index.php');">Cargue Informaci&oacute;n Soluci&oacute;n</a></li>
                <?php if (in_array("8", $grupos)) { ?>   
                    <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargueGeneralTablero/indexDS.php?code=22');">Remisi&oacute;n Informaci&oacute;n Escrituraci&oacute;n</a></li>
                <?php } ?>
                <?php if (in_array("1", $grupos) || in_array("8", $grupos)) { ?>

                    <!------------------------------------------------------------------------------------------------------
                        CARGUE DATOS ESCRITURACION
                     ------------------------------------------------------------------------------------------------------>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Escrituración<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/masivoPlantillaEscrituracion/index.php'
                                   );"
                                >
                                    Postulación Individual
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/DesembolsoMiCasaYa/index.php'
                                   );"
                                >
                                    Complementariedad VIPA
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/leasing/escrituracion.php'
                                   );"
                                >
                                    Leasing Habitacional
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!------------------------------------------------------------------------------------------------------
                        CARGUE DATOS ESTUDIOS TÉCNICOS
                     ------------------------------------------------------------------------------------------------------>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Estudios Técnicos<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0)"
                                   onClick=" cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/migracionEstudiosTecnicosPryDes/index.php'
                                   );"
                                >
                                    Postulación Individual / Proyectos gestionados por SDHT
                                </a>
                            </li>
<!--                            <li>-->
<!--                                <a href="javascript:void(0)"-->
<!--                                   onClick="cambiarOpcionLegalizacion(-->
<!--                                       'contenidoLegalizacion',-->
<!--                                       'contenidos/migracionesIndividual/EstudiosTecnicosMiCasaYa/index.php'-->
<!--                                   );"-->
<!--                                >-->
<!--                                    Mi Casa Ya-->
<!--                                </a>-->
<!--                            </li>-->
                        </ul>
                    </li>

                <?php } ?>
                <?php if (in_array("8", $grupos)) { ?>
                    <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargueGeneralTablero/indexDS.php?code=26');">Generaci&oacute;n Certificado Habitabilidad</a></li>
                    <li>
                        <a href="javascript:void(0)"
                           onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/CargueGeneralTablero/indexDS.php?code=24');"
                        >
                            Remisi&oacute;n Estudio de Titulos
                        </a>
                    </li>
                <?php } ?>
                <?php if (in_array("1", $grupos) || in_array("8", $grupos)) { ?>

                    <!------------------------------------------------------------------------------------------------------
                        CARGUE DATOS ESTUDIO DE TITULOS
                     ------------------------------------------------------------------------------------------------------>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Estudio de Títulos<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/CargaMasivosEstudioTitulos/index.php'
                                   );"
                                >
                                    Postulación Individual / Complementariedad VIPA
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/leasing/estudioTitulos.php'
                                   );"
                                >
                                    Leasing Habitacional
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargueGeneralTablero/indexDS.php?code=29');">Conformaci&oacute;n Definitiva Documentaci&oacute;n</a></li>
                <?php } ?>


                <!------------------------------------------------------------------------------------------------------
                    CARGUE DATOS LEGALIZACION
                 ------------------------------------------------------------------------------------------------------>

                <?php if (in_array("10", $grupos)) { ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Legalización<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/CargaMasivosLegalizacion/index.php'
                                       );"
                                >
                                    Cargue Unidades Legalizadas
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/legalizacionVipa/giroFiducia.php'
                                   );"
                                >
                                    Giro a Fiducia Complementariedad VIPA
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                   onClick="cambiarOpcionLegalizacion(
                                       'contenidoLegalizacion',
                                       'contenidos/migracionesIndividual/legalizacionVipa/giroConstructor.php'
                                   );"
                                >
                                    Giro a Constructor Complementariedad VIPA
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php } ?>

                <!------------------------------------------------------------------------------------------------------
                    DEVOLUCION DE EXPEDIENTES
                 ------------------------------------------------------------------------------------------------------>

                <!--<li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaCopiaDesembolso/index.php');">Migraci&oacute;n Masiva de desembolso a Primer desembolso</a></li>-->
                <?php if (in_array("8", $grupos) || in_array("1", $grupos)) { ?>
                    <li><a href="javascript:void(0)" onClick="cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/DevolucionExpedientes/index.php');">Devolución Expedientes</a></li>
                <?php } ?>

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

