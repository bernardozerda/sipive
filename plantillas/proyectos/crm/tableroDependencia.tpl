<html lang="en">
    <head>     
        <link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 
    </head>
    {literal}
        <style>
            .title1{
                background: #008FA6; 
                color: #FFF;               
                padding: 2%;
                text-align: center;
                font-weight: bold;
            }
            .panel-heading{
                min-height: 50px
            }
        </style>
    {/literal}
    <body>
        <br><br>
        <div class="alert alert-danger">
            <h5> <strong>Atención!!! </strong> <b>Esta información esta sujeta a verificación y actualizacion.</b></h5>
        </div>
        <table  class="table table-striped table-bordered" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <td class="title1">DEPENDENCIA</td>
                    <td class="title1">N° DE PROYECTOS</td>
                    <td class="title1">N° UNIDADES DE VIVIENDA</td>     
                    <td class="title1">DETALLE</td>
                </tr>
            </thead>
            <tr>      
                <td align="center" >SubDirección de Recursos Públicos </td>
                <td align="center">{$arrayProyDependencia[0].canProySdht} </td>
                <td align="center" >{$arrayProyDependencia[0].undProySdht}</td>
                <td align="center"> <a href="#"
                                       onclick="cargarContenido('contenido', './contenidos/proyectos/crm/indicadoresEstado.php?&seqProyGrupo=1', '', true);"
                                       >
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    </a></td>
            </tr>
            <tr>      
                <td align="center" >SubDirección de Recursos Privados </td>
                <td align="center">{$arrayProyDependencia[0].canProyPublicos} </td>
                <td align="center" >{$arrayProyDependencia[0].undProyPublicos}</td>
                <td align="center"> <a href="#"
                                       onclick="cargarContenido('contenido', './contenidos/proyectos/crm/indicadoresEstado.php?&seqProyGrupo=2', '', true);" >
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    </a></td>
            </tr>
            <tfoot>
                <tr style="text-align: center; font-weight: bold; font-size: 12px">
                    <td >TOTAL</td>
                    <td>{$arrayProyDependencia[0].canProySdht+$arrayProyDependencia[0].canProyPublicos}</td>
                    <td>{$arrayProyDependencia[0].undProyPublicos+$arrayProyDependencia[0].undProySdht}</td>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>