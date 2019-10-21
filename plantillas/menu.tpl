<link rel="stylesheet" href="recursos/estilos/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<div class="navbar navbar-default" role="navigation" style="padding: 0px; margin: 0px;">
    <div class="container" style="background-color: white; width: 100%;">
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
          {if $smarty.session.seqProyecto != 8}
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-cog"></span> Opciones {$seqProyecto}<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                {foreach from=$arrProyectos key=seqProyecto item=objProyecto}
                                    <a href="#" onClick="cargarContenido('bodyHtml', './index.php', 'proyecto={$seqProyecto}', true);">
                                        <span class="glyphicon glyphicon-menu-right"></span> {$objProyecto->txtProyecto}
                                    </a>
                                {/foreach}
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="./consultaGeneralInterna.php" target="_blank">
                                    <span class="glyphicon glyphicon-search"></span> Consulta general
                                </a>
                            </li>

                            <li>
                                <a href="#" onclick="abrirAyuda()">
                                    <span class="glyphicon glyphicon-globe"></span> Ayuda en línea
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
            {/if}

        </div>
    </div>
</div>
