<?php session_start(); ?>
<html>
    <head>
        <!-- Estilos CSS -->
        <link href="librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    </head>
    <body>
        <?php if ($_SESSION['seqUsuario'] == 421 || $_SESSION['seqUsuario'] == 414) { ?>
            <iframe src="contenidos/desembolso/moduloImportacion/importar.php" frameborder="0" height="500" width="100%"></iframe>
        <?php }else{ ?>
             <p class='alert alert-danger'>Usted no tiene permisos para este módulo!</p>
            
        <?php }?>
    </body>
</html>
