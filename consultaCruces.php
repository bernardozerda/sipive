<?php
$txtPrefijoRuta = "";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" >
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="Subsidios de Vivienda">
            <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
            <meta name="description" content="Sistema de informacion de subsidios de vivienda">
                <meta http-equiv="Content-Language" content="es">
                    <meta name="robots" content="index,  nofollow" />

                    <title>SDVE</title>

                    <!-- Estilos CSS -->        
                    <link href="librerias/bootstrap/css/bootstrap.css" rel="stylesheet">        
                        <link href="librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

                            <style type="text/css">
                                body {
                                    padding-top: 20px;
                                    padding-bottom: 40px;
                                }
                                .textoCeldas{
                                    padding: 7px;
                                    font-family: Arial;
                                    font-size: 12px;
                                }
                            </style>
                            <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
                            <!--[if lt IE 9]>
                             <script src="librerias/bootstrap/htmlIE/respond.min.js"></script>
                             <script src="librerias/bootstrap/htmlIE/html5.js"></script>
                             <script src="librerias/bootstrap/htmlIE/html5shiv.js"></script>
                            <script>
                                var e = ("article,aside,audio,bdi,canvas,command,datalist,details,dialog,embed,figcaption,figure,footer,header,keygen,mark,meter,nav,output,progress,rp,rt,ruby,section,source,summary,time,track,video,wbr,").split(',');
                                for (var i=0; i<e.length; i++) {document.createElement(e[i]);}
                                </script>
                            <![endif]-->


                            <!-- ICONO DE LA VENTANA DEL NAVEGADOR -->
                            <link rel="shortcut icon" href="./recursos/imagenes/urlIcon.ico">

                                </head>
                                <body>     


                                    <div id="contenidos" class="container">

                                        <div class="well well-large">
                                            <img src="./recursos/imagenes/cabezote_ws.png">
                                        </div>

                                        <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                                            <strong>SISTEMA DE INFORMACI&Oacute;N DEL SUBSIDIO DISTRITAL DE VIVIENDA</strong>
                                        </div>

                                        <center>
                                            <div id="mensajes">
                                            </div>
                                        </center>

                                        <div id="fila">

                                            <!-- NO BORRAR -->
                                            <div class="row"><div class="span12">&nbsp;</div></div>

                                            <div class="row">

                                                <!-- ESPACIO LATERAL -->
                                                <div class="span1">&nbsp;</div>

                                                <!-- Buscador -->
                                                <div class="span10" style="height: 330px;">

                                                    <div class="thumbnail" style="height: 280px;">
                                                        <div class="caption">
                                                            <h3>Consulta de Cruces</h3>
                                                            <p>
                                                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                                                    <fieldset>

                                                                        <!-- documento -->
                                                                        <div class="control-group">
                                                                            <label class="control-label" for="documento">Documento</label>
                                                                            <div class="controls">
                                                                                <input 
                                                                                    type="text" 
                                                                                    name="documento" 
                                                                                    id="documento" 
                                                                                    size="10"
                                                                                    placeholder="Numero de Documento"
                                                                                    >
                                                                                    <select name="tipodoc" id="tipodoc">
                                                                                        <option value="1">C.C.</option>
                                                                                        <option value="2">C.E.</option>
                                                                                        <option value="3">T.I.</option>
                                                                                        <option value="4">R.C.</option>
                                                                                        <option value="5">PAS</option>
                                                                                        <option value="6">N.I.T.</option>
                                                                                        <option value="7">N.U.I.</option>
                                                                                    </select>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Formulario -->
                                                                        <div class="control-group">
                                                                            <label class="control-label" for="formulario">Formulario</label>
                                                                            <div class="controls">
                                                                                <input 
                                                                                    type="text" 
                                                                                    name="formulario"
                                                                                    placeholder="Numero de Formulario" 
                                                                                    id="formulario" 
                                                                                    value="<?php echo $_POST['formulario'];?>"
                                                                                    >                             
                                                                            </div>
                                                                        </div>


                                                                        <!-- Boton de Busqueda -->
                                                                        <div class="control-group">
                                                                            <div class="controls">
                                                                                <button type="submit" class="btn" style="width: 200px;">
                                                                                    Consultar
                                                                                </button>                                       

                                                                            </div>
                                                                        </div>

                                                                    </fieldset>
                                                                </form>
                                                            </p>
                                                        </div>
                                                    </div><br>
                                                        <?php
                                                        if (isset($_POST['documento']) AND ( $_POST['documento'] != '')) {
                                                            $cedula = str_replace(",", "", str_replace(".", "", $_POST['documento']));
                                                            $tipoDocumento = $_POST['tipodoc'];
                                                            $sqlForm = $aptBd->execute("SELECT DISTINCT(T_CRU_CRUCES.seqCruce),T_CRU_CRUCES.txtNombre,
                                                                                        fchCruce,
                                                                                        fchCreacionCruce,
                                                                                        numDocumento,
                                                                                        seqFormulario,
                                                                                        t_cru_cruces.txtUsuario,
                                                                                        t_cru_cruces.txtNombreArchivo,
                                                                                        t_cru_cruces.seqUsuario,
                                                                                        t_cru_cruces.txtUsuarioActualiza,
                                                                                        t_cru_cruces.txtNombreArchivoActualiza,
                                                                                        t_cru_cruces.seqUsuarioActualiza 
                                                                                        FROM T_CRU_CRUCES INNER JOIN T_CRU_RESULTADO ON (T_CRU_CRUCES.seqCruce = T_CRU_RESULTADO.seqCruce) 
                                                                                    WHERE numDocumento = '" . $cedula . "' AND seqTipoDocumento = $tipoDocumento");
                                                        } elseif (isset($_POST['formulario']) AND ( $_POST['formulario'] != '')) {
                                                            $formulario = $_POST['formulario'];
                                                            $sqlForm = $aptBd->execute("SELECT DISTINCT(seqCruce), seqFormulario FROM T_CRU_RESULTADO WHERE seqFormulario = '" . $formulario . "'");
                                                        }

                                                        while ($sqlForm->fields) {
                                                            $rowCruces = $sqlForm->fields;
                                                            // MUESTRA DATOS BASICOS DEL CRUCE
                                                            if (isset($_POST['documento']) AND ( $_POST['documento'] != '')) {
                                                                echo "<div class='well'><table width='100%' align='center'>";
                                                                echo "<tr><td width='20%'><b>Nombre Cruce:</b></td><td class='textoCeldas' colspan = '5'><b>" . $rowCruces['txtNombre'] . "</b></td></tr>";
                                                                echo "<tr><td><b>Fecha Cruce:</b></td><td class='textoCeldas'>" . $rowCruces['fchCreacionCruce'] . "</td>";
                                                                echo "<td><b>Usuario:</b></td><td class='textoCeldas'>[" . $rowCruces['seqUsuario'] . "] " . $rowCruces['txtUsuario'] . "</td>";
                                                                echo "<td><b>Archivo:</b></td><td class='textoCeldas'>" . $rowCruces['txtNombreArchivo'] . "</td></tr>";
                                                                echo "<tr><td><b>Fecha Actualizaci&oacute;n:</b></td><td class='textoCeldas'>" . $rowCruces['fchCruce'] . "</td>";
                                                                echo "<td><b>Usuario Actualiza:</b></td><td class='textoCeldas'>" . $rowCruces['txtUsuarioActualiza'] . "</td>";
                                                                echo "<td><b>Archivo Actualiza:</b></td><td class='textoCeldas'>" . $rowCruces['txtNombreArchivoActualiza'] . "</td></tr>";
                                                                echo "<tr><td><b>Formulario:</b></td><td class='textoCeldas' colspan = '5'>" . $rowCruces['seqFormulario'] . "</td></tr>";
                                                            } elseif (isset($_POST['formulario']) AND ( $_POST['formulario'] != '')) {
                                                                $sqlFormulario = $aptBd->execute("SELECT T_CRU_CRUCES.txtNombre, fchCruce, fchCreacionCruce, 
                                                                                        t_cru_cruces.txtUsuario,
                                                                                        t_cru_cruces.txtNombreArchivo,
                                                                                        t_cru_cruces.seqUsuario,
                                                                                        t_cru_cruces.txtUsuarioActualiza,
                                                                                        t_cru_cruces.txtNombreArchivoActualiza,
                                                                                        t_cru_cruces.seqUsuarioActualiza FROM T_CRU_CRUCES WHERE seqCruce = " . $rowCruces['seqCruce']);
                                                                $rowFormulario = $sqlFormulario->fields;

                                                                echo "<div class='well'><table width='100%' align='center'>";
                                                                echo "<tr><td width='20%'><b>Nombre Cruce:</b></td><td class='textoCeldas' colspan = '5'><b>" . $rowFormulario['txtNombre'] . "</b></td></tr>";
                                                                echo "<tr><td><b>Fecha Cruce:</b></td><td class='textoCeldas'>" . $rowFormulario['fchCreacionCruce'] . "</td>";
                                                                echo "<td><b>Usuario:</b></td><td class='textoCeldas'>[" . $rowFormulario['seqUsuario'] . "] " . $rowFormulario['txtUsuario'] . "</td>";
                                                                echo "<td><b>Archivo:</b></td><td class='textoCeldas'>" . $rowFormulario['txtNombreArchivo'] . "</td></tr>";
                                                                echo "<tr><td><b>Fecha Actualizaci&oacute;n:</b></td><td class='textoCeldas'>" . $rowFormulario['fchCruce'] . "</td>";
                                                                echo "<td><b>Usuario Actualiza:</b></td><td class='textoCeldas'>" . $rowFormulario['txtUsuarioActualiza'] . "</td>";
                                                                echo "<td><b>Archivo Actualiza:</b></td><td class='textoCeldas'>" . $rowFormulario['txtNombreArchivoActualiza'] . "</td></tr>";
                                                                echo "<tr><td><b>Formulario:</b></td><td class='textoCeldas' colspan = '5'>" . $rowCruces['seqFormulario'] . "</td></tr>";
                                                            }
                                                            // POSTULANTE PRINCIPAL
                                                            $sqlPpal = $aptBd->execute("SELECT seqFormulario, numDocumento, CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombrePpal FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano) WHERE seqParentesco = 1 AND seqFormulario = " . $rowCruces['seqFormulario']);
                                                            $rowPpal = $sqlPpal->fields;
                                                            echo "<tr><td><b>Postulante Principal:</b></td><td class='textoCeldas' colspan = '5'>[" . $rowPpal['numDocumento'] . "] " . $rowPpal['nombrePpal'] . "</td></tr></table>";
                                                            // APARICIONES DEL DOCUMENTO EN T_CRU_RESULTADOS SEGUN EL SEQCRUCE
                                                            $sqlResultadosCruce = $aptBd->execute("SELECT * FROM T_CRU_RESULTADO WHERE seqCruce = " . $rowCruces['seqCruce'] . " AND seqFormulario = " . $rowCruces['seqFormulario']);
                                                            echo "<br><table border='1' cellspacing='1' cellpadding='1' width='100%' align='center'>";
                                                            echo "<tr><th width='9%'>Documento</th><th width='20%'>Nombre</th><th width='10%'>Entidad</th><th width='10%'>T&iacute;tulo</th><th width='30%'>Detalle</th><th width='9%'>Inhabilitar</th><th width='12%'>Observaciones</th></tr>";
                                                            while ($sqlResultadosCruce->fields) {
                                                                $rowResultado = $sqlResultadosCruce->fields;
                                                                echo "<tr><td class='textoCeldas'>" . $rowResultado['numDocumento'] . "</td>";
                                                                echo "<td class='textoCeldas'>" . $rowResultado['txtNombre'] . "</td>";
                                                                echo "<td class='textoCeldas' align='center'>" . $rowResultado['txtEntidad'] . "</td>";
                                                                echo "<td class='textoCeldas'>" . $rowResultado['txtTitulo'] . "</td>";
                                                                echo "<td class='textoCeldas'>" . $rowResultado['txtDetalle'] . "</td>";
                                                                echo "<td class='textoCeldas' align='center'>" . $rowResultado['bolInhabilitar'] . "</td>";
                                                                echo "<td class='textoCeldas'>" . $rowResultado['txtObservaciones'] . "</td></tr>";
                                                                $sqlResultadosCruce->MoveNext();
                                                            }
                                                            echo "</table></div>";

                                                            $sqlForm->MoveNext();
                                                        }
                                                        ?>
                                                        <footer>
                                                            <div class="well well-small">
                                                                <center>
                                                                    <img src="./recursos/imagenes/pie_ws.png"><br>
                                                                            <h6>Para visualizar mejor este sitio se recomienda el uso de Chrome, Mozilla Firefox ó Internet Explorer 10.</h6>
                                                                            </center>
                                                                            </div>
                                                                            </footer>
                                                                            </div>

                                                                            <!-- ESPACIO LATERAL -->
                                                                            <div class="span1">&nbsp;</div>

                                                                            </div>
                                                                            </div>    
                                                                            </div> <!-- /container -->

                                                                            <!-- PIE DE PAGINA -->
                                                                            <!--<footer>
                                                                                <div class="well well-small">
                                                                                    <center>
                                                                                        <img src="./recursos/imagenes/pie_ws.png"><br>
                                                                                        <h6>Para visualizar mejor este sitio se recomienda el uso de Chrome, Mozilla Firefox ó Internet Explorer 10.</h6>
                                                                                    </center>
                                                                                </div>
                                                                            </footer>-->

                                                                            <!-- POP UP DE OLVIDO DE CLAVE -->
                                                                            <div id="olvidoClave" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <form id="frmOlvidoClave" class="form-horizontal">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                        <h3 id="myModalLabel">¿Olvid&oacute; su clave?</h3>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <p class="text-center alert alert-info">
                                                                                            Digite el correo electrónico del usuario, se le regresará un mensaje con una nueva contraseña
                                                                                        </p>
                                                                                        <div class="control-group">
                                                                                            <label class="control-label" for="usuario">Usuario</label>
                                                                                            <div class="controls">
                                                                                                <input type="text" id="olvidoUsuario" name="olvidoUsuario" required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="control-group">
                                                                                            <label class="control-label" for="correo">Correo</label>
                                                                                            <div class="controls">
                                                                                                <input type="email" id="olvidoCorreo" name="correo" required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">    
                                                                                        <button type="submit" class="btn">
                                                                                            Aceptar
                                                                                        </button>
                                                                                        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
                                                                                            Cancelar
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>      

                                                                            <div id="cargando" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h3 id="myModalLabel">Espere un momento por favor...</h3>
                                                                                </div>
                                                                                <div class="modal-body text-center">
                                                                                    <div class="progress progress-striped active">
                                                                                        <div class="bar" style="width: 100%;"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div id="offLine" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h3 id="myModalLabel">Temporalmente fuera de servicio</h3>
                                                                                </div>
                                                                                <div class="modal-body text-center">
                                                                                    <div class="alert alert-info">
                                                                                        <h4>Disculpenos, estamos trabajando para ofrecerle mas servicios.</h4>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">    
                                                                                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
                                                                                        Cerrar
                                                                                    </button>
                                                                                </div>
                                                                            </div>

                                                                            <!-- INCLUSIONES JAVASCRIPT [NO MOVER DEL FINAL] -->
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/jquery-1.10.1.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap.js"></script>        
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-collapse.js"></script>  
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-transition.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-alert.js"></script>
                                                                            <!-- <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-modal.js"></script> -->
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-dropdown.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-scrollspy.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-tab.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-popover.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-tooltip.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-button.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-carousel.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-typeahead.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/bootstrap/js/bootstrap-affix.js"></script>

                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/yui/yahoo/yahoo-min.js"></script>  
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/yui/event/event-min.js"></script>  
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/encripcion.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/autenticacion.js"></script>
                                                                            <script language="JavaScript" type="text/javascript" src="./librerias/javascript/ciudadano.js"></script>

                                                                            </body>
                                                                            </html>