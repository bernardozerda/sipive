<center>
    <center>
        <h3>Información de Calificación</h3>
        <div style="width: 100%" >
            <p>
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                <thead >
                    <tr>
                        <th bgcolor="#E4E4E4" align="center" ><b>Formulario</b></th>
                        <th bgcolor="#E4E4E4" ><b>Informacion Hogar</b></th>
                        <th bgcolor="#E4E4E4" ><b>Cant. Miembros</b></th>
                        <th bgcolor="#E4E4E4" ><b>Ingresos</b></th>
                        <th bgcolor="#E4E4E4" ><b>Calificación</b></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th bgcolor="#E4E4E4" align="center" ><b>Formulario</b></th>
                        <th bgcolor="#E4E4E4" ><b>Informacion Hogar</b></th>
                        <th bgcolor="#E4E4E4" ><b>Cant. Miembros</b></th>
                        <th bgcolor="#E4E4E4" ><b>Ingresos</b></th>
                        <th bgcolor="#E4E4E4" ><b>Calificación</b></th>
                    </tr>
                </tfoot>
                {foreach from=$datos key=key item=value} 

                    <tr>
                        <td  align="center" nowrap>{$value.seqFormulario}&nbsp;</td>
                        <td width="50%"> 
                            <table>{$value.infHogar|replace:",":"<br>"}</table>

                        </td>
                        <td align="center">{$value.cantMiembrosHogar }&nbsp;</td>
                        <td  align="center"><b>$</b>{$value.totalIngresos|number_format:2:".":","}&nbsp;</td>               
                        <td  align="center"><b> {$value.total|number_format:3:".":","}%</b>&nbsp;</td>            
                    </tr>
                {/foreach}
            </table>
        </div>
        <script src="../../librerias/javascript/dataTable.js"></script> 
    </center>