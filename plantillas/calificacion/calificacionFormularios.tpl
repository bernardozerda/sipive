<center>
    <script src="../../librerias/javascript/dataTable.js"></script> 
    <form enctype="multipart/form-data" method="POST" id="frmCalificacionHogares">
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
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
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
                    <td align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/calificacion/listaCalificacion.php?fecha={$fechaCalificacion}', '', true);"><img src="recursos/imagenes/list.png" width="24px"/></a></td>
                    <td align="center"><a href="contenidos/calificacion/expCalificacion.php?fchCal={$fechaCalificacion}" target='_blank'><img src="recursos/imagenes/excel-48.png" width="24px"/></a></td>

                </tr>
            {/foreach}
        </table>
    </div>
     <div style="text-align: left; left: 10%; position: relative;"><br>
                        <button onclick="cargarContenido('contenido', './contenidos/calificacion/reporte/archivo.php', '', true);" style="width:70px;">
                            <img src="recursos/imagenes/reportEncuesta.png" width="25px" height="25px"><br>
                            <span style="font-size: 10px; font-weight: bold;">Exportar<br>Cal. Encuestas</span>
                        </button>
                    </div>


    {include file="calificacion/simulador.tpl"}
    <script src="../../librerias/javascript/dataTable.js"></script> 

</center>
