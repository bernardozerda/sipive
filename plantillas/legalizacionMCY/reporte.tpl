&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
      >

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Lista de Informes de Legalización Mi Casa Ya!</h6>
    </div>
    <div class="panel-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Consecutivo</th>
                    <th>Fecha Autorización</th>
                    <th>N° Hogares</th>
                    <th>Detalles</th>
                    <th>Archivo</th>
                    
                </tr>
            </thead>
            {foreach from=$listaReportes item=arrDatos}
                {assign var=fecha value=$arrDatos.fchCreacion} 


                <tr>
                    <td class="col-sm-5">
                        {$arrDatos.txtConsecutivo}
                    </td>
                    <td class="col-sm-5">
                        {$arrDatos.fchOrden}
                    </td>
                    <td class="col-sm-5">
                        {$arrDatos.Cantidad}
                    </td>
                    <td class="col-sm-5" nowrap>
                       <span class="btn btn-default btn-sm" >
                            <a href="contenidos/legalizacionMCY/detalles.php?fchCreacion={$arrDatos.fchCreacion}">
                                <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                        </span>
                    </td>
                    <td class="col-sm-5">
                        <span class="btn btn-default btn-sm" >
                            <a href="recursos/informesMCY/ReporteMCY_{$fecha|date_format:"%b"|capitalize|replace:".":""}_{$fecha|replace:":":""}.xlsx">
                                <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span></a>
                        </span>

                    </td>
                </tr>
            {/foreach}
        </table>
    </div>
    <div class="panel-footer text-center" style="height: 55px;">

    </div>
</div>