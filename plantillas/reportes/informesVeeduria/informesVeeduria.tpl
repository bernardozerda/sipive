<p>
    <fieldset style="width: 90%; border: 1px dotted #999999; padding:10px; padding-bottom:30px;">
        <legend><strong>LISTADO DE CORTES</strong></legend>
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <thead align="left">
                <th width="120px">Periodo</th>
                <th width="120px">Fecha de Creación</th>
                <th>Usuario</th>
                <th width="120px">Informe Vinculación a Proyectos</th>
                <th width="120px">Informe de Hogares con Asignación</th>
            </thead>
            <tfoot align="left">
                <th>Periodo</th>
                <th>Fecha de Creación</th>
                <th>Usuario</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tfoot>
            <tbody>
                {foreach name=cortes from=$arrCortes item=arrDato}
                    <tr bgcolor="{cycle name=cortes values="#E5E5E5,#F9F9F9"}">
                        <td>{$arrDato.txtCorte}</td>
                        <td>{$arrDato.fchCorte}</td>
                        <td>{$arrDato.txtNombre}</td>
                        <td align="center">
                            <button onClick="location.href='./contenidos/reportes/informesVeeduria/informeProyectos.php?seqCorte={$arrDato.seqCorte}'" style="width: 35px; height: 30px">
                                <img src="./recursos/imagenes/excel-48.png"
                                     width="20px"
                                     height="20px"
                                     style="cursor: hand"
                                >
                            </button>
                        </td>
                        <td align="center">
                            <button onClick="location.href='./contenidos/reportes/informesVeeduria/informeNoProyectos.php?seqCorte={$arrDato.seqCorte}'" style="width: 35px; height: 30px">
                                <img src="./recursos/imagenes/excel-48.png"
                                     width="20px"
                                     height="20px"
                                     style="cursor: hand"
                                >
                            </button>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </fieldset>
</p>