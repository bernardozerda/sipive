<link rel="stylesheet" href="recursos/estilos/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<div class="navbar navbar-default" role="navigation">
    <div class="container" style="background-color: white; width: 900px;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {*<a class="navbar-brand" href="#">NavBar</a>*}
        </div>
        <div class="collapse navbar-collapse">

            <!-- MENU DE LA IZQUIERDA (RECURSIVO A N NIVELES) -->
            <ul class="nav navbar-nav">
                {$claMenu->imprimirMenuPrincipal($arrMenu)}
            </ul>

            <!-- MENU DE LA DERECHA -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Opciones <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            {foreach from=$arrProyectos key=seqProyecto item=objProyecto}
                                <a href="#" onClick="cargarContenido('bodyHtml', './index.php', 'proyecto={$seqProyecto}', true);">
                                    <img src="./recursos/imagenes/casa.png" width="10px"> {$objProyecto->txtProyecto}88
                                </a>
                            {/foreach}
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="./consultaGeneralInterna.php" id="ayuda" target="_blank">
                                <img src="./recursos/imagenes/iconoLupa.png" width="10px"> Consulta General
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="ayuda" onClick="popUpAyuda()">
                        <img src="./recursos/imagenes/library.png" width="10px">
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>