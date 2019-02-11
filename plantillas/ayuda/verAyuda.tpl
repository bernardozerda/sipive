<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es-Es" >
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Subsidios de Vivienda">
    <meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
    <meta name="description" content="Sistema de informacion de subsidios de vivienda"/>
    <meta http-equiv="Content-Language" content="es"/>
    <meta name="robots" content="index,  nofollow" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../../librerias/jquery/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../../recursos/estilos/ayuda.css" />

</head>
<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Secretaría Distrital de Hábitat <small>Ayudas en línea</small></h3>
            </div>
        </div>
    </nav>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3">
                <ol class='breadcrumb alert alert-info text-info h5' style='padding: 10px; margin: 0px;'>
                    <li><strong>{$txtProyecto}</strong></li>
                </ol>
            </div>
            <div class="col-md-9">
                <ol class='breadcrumb alert alert-warning text-info h5' style='padding: 10px; margin: 0px;'>
                    {$claMenu->obtenerMigaDePan($smarty.session.seqProyecto,$seqMenu)}
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3" style="padding-top: 30px;">
                {$claMenu->imprimirArbolMenuAyuda($arrArbolMenu,$smarty.session.seqProyecto,'ayuda')}
            </div>
            <div class="col-sm-9">
                {if $seqMenu == 0 or mb_strtolower($objMenu->txtEspanol) == 'inicio'}
                    {include file='./ayuda/bienvenida.tpl'}
                {else}
                    {if $objMenu->bolPublicar == 0 or $objMenu->txtAyuda == "" or $objMenu->txtAyuda == null}
                        {include file='./ayuda/construccion.tpl'}
                    {else}
                        {$objMenu->txtAyuda|htmlspecialchars_decode}
                    {/if}
                {/if}
            </div>
        </div>

    </div>

    <!-- JS -->
    <script language="JavaScript" type="text/javascript" src="../../librerias/bootstrap/js/jquery-1.10.1.js"></script>
    <script language="JavaScript" type="text/javascript" src="../../librerias/bootstrap/js/bootstrap.js"></script>
    <script language="JavaScript" type="text/javascript" src="../../librerias/javascript/funcionesAyuda.js"></script>

</body>
</html>