<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>Consulta General Interna</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="./recursos/estilos/consultaGeneral.css" rel="stylesheet">

    {literal}
        <style type="text/css">
            * {
                font-size: 12px;
            }
        </style>
    {/literal}


</head>

<body>

<div class="container">

    <header class="header clearfix">
        <nav>
            <ul class="nav nav-pills float-right">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="window.close();">
                        Cerrar <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
        </nav>
        <h3 class="text-muted">Consulta General</h3>
    </header>

    <div class="jumbotron">
        <form method="post" action="./consultaGeneralInterna.php" class="form-horizontal">
            <div class="form-group row">
                <label for="numDocumento" class="col-4 col-form-label">
                    <strong>Documento</strong>
                </label>
                <div class="col-3">
                    <select name="seqTipoDocumento" id="seqTipoDocumento" class="form-control">
                        <option value="1" {if $seqTipoDocumento == 1} selected {/if}>CC</option>
                        <option value="2" {if $seqTipoDocumento == 2} selected {/if}>CE</option>
                        <option value="3" {if $seqTipoDocumento == 3} selected {/if}>TI</option>
                        <option value="4" {if $seqTipoDocumento == 4} selected {/if}>RC</option>
                        <option value="5" {if $seqTipoDocumento == 5} selected {/if}>PAS</option>
                        <option value="6" {if $seqTipoDocumento == 6} selected {/if}>NIT</option>
                        <option value="7" {if $seqTipoDocumento == 7} selected {/if}>NUIP</option>
                        <option value="8" {if $seqTipoDocumento == 8} selected {/if}>NUIP</option>
                    </select>
                </div>
                <div class="col-5">
                    <input class="form-control"
                           type="number"
                           value="{if $numDocumento != 0}{$numDocumento}{/if}"
                           id="numDocumento"
                           name="numDocumento"
                    >
                </div>
            </div>
            <div class="form-group row">
                <label for="seqFormulario" class="col-4 col-form-label">
                    <strong>Formulario</strong>
                </label>
                <div class="col-8">
                    <input class="form-control"
                           type="number"
                           value="{if $seqFormulario != 0}{$seqFormulario}{/if}"
                           id="seqFormulario"
                           name="seqFormulario"
                    >
                </div>
            </div>
            <div class="form-group row">
                <label for="seqFormulario" class="col-4 col-form-label">
                    <strong>Consultar en </strong>
                </label>
                <div class="col-4">
                    <input class="form-control"
                           type="radio"
                           value="sipive"
                           id="txtSistema"
                           name="txtSistema"
                           {if $txtSistema == 'sipive' or $txtSistema == ''}checked{/if}
                    > SiPIVE
                </div>
                <div class="col-4">
                    <input class="form-control"
                           type="radio"
                           value="sdht_subsidios"
                           id="txtSistema"
                           name="txtSistema"
                           {if $txtSistema == 'sdht_subsidios'}checked{/if}
                    > SIFSV
                </div>
            </div>

            <div class="form-group row justify-content-md-center">
                <div class="col-3">
                    <input type="submit"
                           id="consultar"
                           name="consultar"
                           value="Consultar"
                           class="btn btn-success"
                    >
                </div>
                <div class="col-3">
                    <input type="reset"
                           id="limpiar"
                           name="limpiar"
                           value="Limpiar"
                           class="btn btn-light"
                    >
                </div>
            </div>
        </form>
    </div>

    <div class="mb-3">
        <div class="row justify-content-md-center">
            <div class="col col-3" style="text-align: center">
                <a href="#datosBasicos" class="btn btn-secondary">Datos Básicos</a>
            </div>
            <div class="col col-3" style="text-align: center">
                <a href="#miembrosHogar" class="btn btn-secondary">Miembros Hogar</a>
            </div>
            <div class="col col-3" style="text-align: center">
                <a href="#actosAdminsitrativos" class="btn btn-secondary">Actos Adm.</a>
            </div>
            <div class="col col-3" style="text-align: center">
                <a href="#desembolso" class="btn btn-secondary">Desembolso</a>
            </div>
        </div>
    </div>

</div>

<div class="container-fluid col-10">

    <div class="card mb-3" id="datosBasicos">
        <div class="card-body">
            <h5 class="card-title">Datos Básicos <a href="#" class="btn btn-secondary">Volver</a></h5>
            <table class="table table-striped">
                {foreach from=$arrDatosBasicos item=arrDatos}
                    {foreach from=$arrDatos key=txtTitulo item=txtValor}
                        <tr>
                            <td width="300px"><h6 class="text-muted">{$txtTitulo}</h6></td>
                            <td>{$txtValor}</td>
                        </tr>
                    {/foreach}
                {/foreach}
            </table>
        </div>
    </div>

    <div class="card mb-3" id="miembrosHogar">
        <div class="card-body">
            <h5 class="card-title">Miembros de Hogar <a href="#" class="btn btn-secondary">Volver</a></h5>
            <table class="table table-striped">
                <tr>
                    {foreach from=$arrDatosMiembros.0 key=txtTitulo item=txtValor}
                        <th><h6 class="text-muted">{$txtTitulo}</h6></th>
                    {/foreach}
                </tr>
                {foreach from=$arrDatosMiembros item=arrDatos}
                    <tr>
                        {foreach from=$arrDatos key=txtTitulo item=txtValor}
                            <td>{$txtValor}</td>
                        {/foreach}
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>

    <div class="card mb-3" id="actosAdminsitrativos">
        <div class="card-body">
            <h5 class="card-title">Actos Administrativos <a href="#" class="btn btn-secondary">Volver</a></h5>
            <table class="table table-striped">
                <tr>
                    {foreach from=$arrDatosAAD.0 key=txtTitulo item=txtValor}
                        <th><h6 class="text-muted">{$txtTitulo}</h6></th>
                    {/foreach}
                </tr>
                {foreach from=$arrDatosAAD item=arrDatos}
                    <tr>
                        {foreach from=$arrDatos key=txtTitulo item=txtValor}
                            <td>{$txtValor}</td>
                        {/foreach}
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>

    <div class="card mb-3" id="desembolso">
        <div class="card-body">
            <h5 class="card-title">Desembolso <a href="#" class="btn btn-secondary">Volver</a></h5>
            <table class="table table-striped">
                {foreach from=$arrDatosDesembolso key=seqDesembolso item=arrEtapas}
                    {foreach from=$arrEtapas key=txtEtapa item=arrDatos}
                        <tr>
                            <th colspan="2">
                                <h6 class="text-muted">
                                    <strong>
                                        {$txtEtapa|ucwords}
                                    </strong>
                                </h6>
                            </th>
                        </tr>
                        {foreach from=$arrDatos key=txtTitulo item=txtValor}
                            {if not is_array($txtValor)}
                                <tr>
                                    <td width="300px" style="padding-left: 50px;">{$txtTitulo}</td>
                                    <td>{$txtValor}</td>
                                </tr>
                            {else}
                                <tr>
                                    <td width="300px" style="padding-left: 50px;">Adjuntos</td>
                                    <td>{$txtTitulo}</td>
                                </tr>
                                {foreach from=$txtValor key=txtTituloCelda item=txtvalorCelda}
                                    <tr>
                                        <td width="500px" style="padding-left: 150px;">{$txtTituloCelda}</td>
                                        <td>{$txtvalorCelda}</td>
                                    </tr>
                                {/foreach}
                            {/if}
                        {/foreach}
                    {/foreach}
                {/foreach}
            </table>
        </div>
    </div>

</div>

<div class="row justify-content-md-center mb-3">
    <div class="col-sm-1">
        <a href="#" class="btn btn-secondary">Volver</a>
    </div>
</div>

<div class="container-fluid">
    <footer class="footer text-center">
        <p><img src="./recursos/imagenes/pie_ws.png"></p>
    </footer>
</div>

</body>
</html>
