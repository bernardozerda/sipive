
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                Exportables Financieros
            </h6>
        </div>
        <div class="panel-body">
            {foreach from=$arrReporte key=txtClave item=arrDatos}
                <div class="col-sm-6 form-group">
                    <div class="media" style="cursor: pointer" onclick="location.href='./contenidos/pryGestionFinanciera/reportes.php?reporte={$txtClave}'">
                        <div class="media-left">
                            <span class="h1 text-success">
                                <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                            </span>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{$arrDatos.titulo}</h4>
                            {$arrDatos.descripcion}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>