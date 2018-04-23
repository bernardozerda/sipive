<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="#">SiPIVE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Padre
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {*<a class="dropdown-item" href="#">*}
                    <a class="dropdown-item dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Hijo
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">
                            Nieto 1
                        </a>
                        <a class="dropdown-item" href="#">
                            Nieto 2
                        </a>
                    </div>
                    <a class="dropdown-item" href="#">
                        Hermano
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>



{*<nav class="navbar navbar-default" style="background-color: #FDFDFD">*}
    {*<div class="container-fluid">*}

        {*<!-- Brand and toggle get grouped for better mobile display -->*}
        {*<div class="navbar-header" style="padding-left: 10px;">*}
            {*<button type="button" class="navbar-toggle pull-left collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">*}
                {*<span class="sr-only"></span>*}
                {*<span class="icon-bar"></span>*}
                {*<span class="icon-bar"></span>*}
                {*<span class="icon-bar"></span>*}
            {*</button>*}
            {*<a class="navbar-brand" href="#">Brand</a>*}
        {*</div>*}

        {*<!-- Collect the nav links, forms, and other content for toggling -->*}
        {*<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">*}
            {*<ul class="nav navbar-nav">*}
                {*{foreach name=menuPrincipal from=$arrMenu key=seqPadre item=objPadre}*}
                    {*{if not empty( $objPadre->hijos ) }*}
                        {*<li class="dropdown">*}
                            {*<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">*}
                                {*{$objPadre->txtEspanol}<span class="caret"></span>*}
                            {*</a>*}
                            {*<ul class="dropdown-menu">*}
                                {*{if $objPadre->txtCodigo != 'subsidios/vacio'}*}
                                    {*<li><a href="#menu-{$objPadre->txtEspanol}"*}
                                           {*onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true);*}
                                                   {*cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);">*}
                                            {*{$objPadre->txtEspanol} </a>*}
                                    {*</li>*}
                                {*{/if}*}
                                {*{foreach from=$objPadre->hijos key=seqHijo item=objHijo}*}
                                    {*<li><a href="#menu-{$objHijo->txtEspanol}"*}
                                           {*onClick="cargarContenido('contenido', './contenidos/{$objHijo->txtCodigo}.php', '', true);*}
                                                   {*cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqHijo}', false);">*}
                                            {*{$objHijo->txtEspanol} </a>*}
                                    {*</li>*}
                                {*{/foreach}*}
                            {*</ul>*}
                        {*</li>*}
                    {*{else}*}
                        {*{assign var=ruta value=""}*}
                        {*<li>*}
                            {*<a href="#menu-{$objPadre->txtEspanol}"*}
                               {*{if $objPadre->txtEspanol|lower == 'inicio' }*}
                                   {*onClick="location.reload(true);"*}
                               {*{else}*}
                                   {*{assign var=varArchivo value="?"|explode:$objPadre->txtCodigo} *}
                                   {*{if $varArchivo|@count gt 0}  *}
                                       {*{assign var=ruta value=$objPadre->txtCodigo}                           *}
                                    {*{else}   *}
                                        {*{assign var=ruta value=$varArchivo[0]".php?"$varArchivo[1]} *}
                                   {*{/if}*}
                                   {*onClick="cargarContenido('contenido', './contenidos/{$ruta}', '', true);*}
                                           {*cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);"*}
                               {*{/if}*}
                               {*>{$objPadre->txtEspanol}</a>*}
                        {*</li>*}
                    {*{/if}*}
                {*{/foreach}*}
            {*</ul>*}


            {*<ul class="nav navbar-nav navbar-right">*}
                {*<li class="dropdown">*}
                    {*<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">*}
                        {*Opciones<span class="caret"></span>*}
                    {*</a>*}
                    {*<ul class="dropdown-menu">*}
                        {*<li>*}
                            {*{foreach from=$arrProyectos key=seqProyecto item=objProyecto}*}
                                {*<a href="#" onClick="cargarContenido('bodyHtml', './index.php', 'proyecto={$seqProyecto}', true);">*}
                                    {*<img src="./recursos/imagenes/casa.png" width="10px"> {$objProyecto->txtProyecto}*}
                                {*</a>*}
                            {*{/foreach}*}
                        {*</li>*}
                        {*<li>*}
                            {*<a href="./consultaGeneralInterna.php" id="ayuda" target="_blank">*}
                                {*<img src="./recursos/imagenes/iconoLupa.png" width="10px"> Consulta General*}
                            {*</a>*}
                        {*</li>*}
                    {*</ul>*}
                {*</li>*}
                {*<li>*}
                    {*<a href="#" id="ayuda" onClick="popUpAyuda()">*}
                        {*<img src="./recursos/imagenes/library.png" width="10px">*}
                    {*</a>*}
                {*</li>*}
            {*</ul>*}

        {*</div><!-- /.navbar-collapse -->*}
    {*</div><!-- /.container-fluid -->*}
{*</nav>*}