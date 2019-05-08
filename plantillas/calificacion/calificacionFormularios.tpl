<center>

    <link rel="stylesheet" href="./librerias/jquery/css/bootstrap.min.css"/> 
    <link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet" />        
    <link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
    <link href="./recursos/estilos/inputFile.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" 
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Generar Calificación &nbsp;&nbsp;</h6>
        </div>
        <div class="panel-body">
            <form class="md-form" onsubmit="someterFormulario('contenido', this, './contenidos/calificacion/calificacionPive.php', true, false);
                    return false;
                    limpiar();"  enctype="multipart/form-data" method="post">
                <div class="col-lg-6 col-md-6">
                    <div class="file-field">
                        <a class="btn-floating purple-gradient mt-0 float-left waves-effect waves-light" onclick="archivo()">
                            <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
                            <input id="archivo2" accept=".txt" name="fileDocumentos" type="file"  required="true"/> 
                            <input name="MAX_FILE_SIZE" type="hidden" value="400000" /> 
                            <input type="hidden" name="nombre" id="nombre" value="" required="true">
                            <input type="hidden" name="tipo" id="tipo" value="" required="true">

                        </a>
                        <div class="file-path-wrapper">
                            <input class="file-path validate"  id="prueba2" type="text" placeholder="Seleccione Archivo" style="border-bottom: 1px solid #ced4da !important;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4" style="top: 15px; text-align: left">
                    <button type="submit" class="pressed" style="width: 65%" name="enviar" >
                        <span class="glyphicon glyphicon-play-circle" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;" ></span>&nbsp; Proceder A Calificar</button>
                </div>
                <div class="col-lg-3 col-md-3" style="text-align: right; width: 105px">
                    <button onclick="cargarContenido('contenido', './contenidos/calificacion/reporte/archivo.php', '', true);" class="pressed" style="background-color: #004080 ">
                        <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                        <span>Exportar Cal. Encuestas</span></button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Lista de Reportes Calificación Pive &nbsp;&nbsp;
                <a href="#popup" class="popup-link"><span class="glyphicon glyphicon-modal-window" aria-hidden="true"></span>
                </a>
            </h6>
        </div>
        <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" >
                <thead >
                    <tr>
                        <th bgcolor="#E4E4E4" align="center" ><b>Fecha Calificación</b></th>
                        <th bgcolor="#E4E4E4" ><b>Total Calificados</b></th>
                        <th bgcolor="#E4E4E4" ><b>Listar</b></th>
                        <th bgcolor="#E4E4E4" ><b>XLS</b></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th bgcolor="#E4E4E4" align="center" ><b>Fecha Calificación</b></th>
                        <th bgcolor="#E4E4E4" ><b>Total Calificados</b></th>
                        <th bgcolor="#E4E4E4" ><b>Listar</b></th>
                        <th bgcolor="#E4E4E4" ><b>XLS</b></th>
                    </tr>
                </tfoot>

                {foreach from=$arrFchCalifica key=fechaCalificacion item=cuantos}                    
                    <tr>
                        <td  align="center"><b>{$fechaCalificacion}</b>&nbsp;</td>
                        <td  align="center">{$cuantos}</td>
                        <td style="text-align: center"><a href="#" onclick="cargarContenido('contenido', './contenidos/calificacion/listaCalificacion.php?fecha={$fechaCalificacion}', '', true);"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>
                        <td style="text-align: center"><a href="contenidos/calificacion/expCalificacion.php?fchCal={$fechaCalificacion}" target='_blank'><span class="glyphicon glyphicon-save" aria-hidden="true"></span></a></td>
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>

    <!--   <form enctype="multipart/form-data" method="POST" id="frmCalificacionHogares">
           <table cellpadding="2" cellspacing="0" border="0" width="80%">
               <tr>
                   <td colspan="2" bgcolor="#E4E4E4" class="tituloTabla" align="center" width="250px">
                       <h4>Carga de documentos a calificar</h4>
                   </td>
               </tr>
               <tr>
                   <td><br><b>Seleccione el archivo:</b><br>En el archivo plano debe ir la lista de los documentos sin encabezado </td>
                   <td valign="top"><br>
                       <input type="file" name="fileDocumentos" /></td></tr>
               <tr>
   
                   <td colspan="2" align="right">
                       <br><br><input  type="button" 
                                       value="Proceder a Calificar" 
                                       class="botonCal"
                                       onClick="someterFormulario(
                                                       'mensajes',
                                                       this.form,
                                                       './contenidos/calificacion/calificacionPive.php',
                                                       true,
                                                       true
                                                       );
                                       "
                                       />
                   </td></tr>
           </table></form>
       <br> 
   
   
       <br>
       <h3>Información de Calificación    <a href="#popup" class="popup-link"><img src="recursos/imagenes/simulador.png"  height="28px" /></a></h3>
       <div> 
           <p>
   
       </div>
       <div style="text-align: left; left: 10%; position: relative;"><br>
           <button onclick="cargarContenido('contenido', './contenidos/calificacion/reporte/archivo.php', '', true);" style="width:70px;">
    <!--<img src="recursos/imagenes/reportEncuesta.png" width="25px" height="25px"><br>
    <span style="font-size: 10px; font-weight: bold;">Exportar<br>Cal. Encuestas</span>
</button>
</div>
    -->

    {include file="calificacion/simulador.tpl"}
    <script src="../../librerias/javascript/dataTable.js"></script> 

</center>
