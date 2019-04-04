<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <link rel="stylesheet" href="./librerias/jquery/css/bootstrap.min.css"/> 
    <link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet" />        
    <link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
</head>
{literal}
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "order": [[2, "desc"]],
                "scrollY": "450px",
                "scrollCollapse": true
            });
        });
        $(document).ready(function (e) {
            e(document).on("click", '.modal-backdrop.fade.in', function (t) {
                limpiar();
            })
        })



    </script>

    <style type="text/css">
        body {
            padding-top: 5px;
            padding-bottom: 40px;
        }
        .textoCeldas{
            padding: 7px;
            font-family: Arial;
            font-size: 12px;
        }
        .row{
            width: 100%;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
        {
            padding: 5px;
        }
        .dataTables_scrollHeadInner{
            width: 100% !important;
        }
        div.dataTables_scrollHead table.table-bordered{
            width: 100% !important;
        }

        .dataTables_scrollFootInner{
            width: 100% !important;
        }       
        div.dataTables_scrollFoot table{
            width: 100% !important;
        }
        .col-sm-1{
            right: 10%;
        }

        .md-form {
            position: relative;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .file-field {
            position: relative;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }
        a:not([href]):not([tabindex]), a:not([href]):not([tabindex]):focus, a:not([href]):not([tabindex]):hover {
            color: inherit;
            text-decoration: none;
        }
        a:not([href]):not([tabindex]) {
            color: inherit;
            text-decoration: none;
        }
        a.waves-effect, a.waves-light {
            display: inline-block;
        }
        .btn-floating {
            -webkit-box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);
            box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 15px 0 rgba(0,0,0,.15);
            width: 47px;
            height: 47px;
            position: relative;
            z-index: 1;
            vertical-align: middle;
            display: inline-block;
            overflow: hidden;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
            margin: 10px;
            -webkit-border-radius: 50%;
            border-radius: 50%;
            padding: 0;
            cursor: pointer;
        }
        .btn-floating i {
            display: inline-block;
            width: inherit;
            text-align: center;
            color: #fff;        
            font-size: 1.25rem;
            line-height: 47px;
        }
        .waves-effect {
            position: relative;
            cursor: pointer;
            overflow: hidden;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }
        .purple-gradient {
            background: -webkit-linear-gradient(50deg,#ff6ec4,#7873f5)!important;
            background: -o-linear-gradient(50deg,#ff6ec4,#7873f5)!important;
            background: linear-gradient(40deg,#ff6ec4,#7873f5)!important;
        }
        .mt-0, .my-0 {
            margin-top: 0!important;
        }
        .float-left {
            float: left!important;
        }
        a {
            cursor: pointer;
            text-decoration: none;
            color: #007bff;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
        }
        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }
        .file-field input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            cursor: pointer;
            opacity: 0;
        }
        .file-field .file-path-wrapper {
            overflow: hidden;
            padding-left: 10px;
            /* height: 2.5rem;*/
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }
        .file-field input.file-path {
            width: 100%;
            height: 36px;
            border-bottom: 1px solid #ced4da;
        }
        .md-form input[type=date], .md-form input[type=datetime-local], .md-form input[type=email], .md-form input[type=number], .md-form input[type=password], .md-form input[type=search-md], .md-form input[type=search], .md-form input[type=tel], .md-form input[type=text], .md-form input[type=time], .md-form input[type=url], .md-form textarea.md-textarea {
            -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            -o-transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            outline: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: none;
            border-bottom: 1px solid #ced4da;
            -webkit-border-radius: 0;
            border-radius: 0;
            -webkit-box-sizing: content-box;
            box-sizing: content-box;
            background-color: transparent;
        }
        .fa-cloud-upload-alt:before {
            content: "\f382";            
            font-family: FontAwesome;
            left:5px;
            position:absolute;
            top:0;
            color: #fff;          

        }        
        a:not([href]):not([tabindex]) {
            text-decoration: none;
            padding: 2.1%;
            color: #fff;
            top: 5px;
        }
        .svg-inline--fa {
            font-size: 2em;
        }
        .modal-body{
            height: 100%;
        }
        .modal-sm {
            width: 100%;
            height: 70%;
            margin: 0;
        }
        .mask{
            z-index: 1042;
        }
        #wait_c{
            z-index: 1043;
        }
    </style>
{/literal}

<body>
    <div id="contenidos" class="container">
        <!-- <div class="well well-large">
             <img src="../../recursos/imagenes/cabezote_ws.png" />
         </div>-->
        <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
            <strong>Listado de reportes Generales</strong>
        </div>
        <center>
            <div id="mensajes">
            </div>
        </center>
        <div class="thumbnail" style="min-height: 500px; ">
            <div class="caption">                
                <p style="padding: 1% 0% 0% 7%">
                <table id="example" class="table table-striped table-bordered" cellspacing="0"  >
                    <thead>
                        <tr align="center">
                            <th bgcolor="#F5F5F5" align="center" ><b>Nombre</b></th>                                    
                            <th bgcolor="#F5F5F5" ><b>Fecha</b></th>    
                            <th bgcolor="#F5F5F5" >Descarga</th>
                            <th bgcolor="#F5F5F5" >Descarga X Hogar </th>
                            <th bgcolor="#F5F5F5" >Importar</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr align="center">
                            <th bgcolor="#F5F5F5" align="center" ><b>Nombre</b></th>                                    
                            <th bgcolor="#F5F5F5" ><b>Fecha</b></th>    
                            <th bgcolor="#F5F5F5" >Descarga</th>                             
                            <th bgcolor="#F5F5F5" >Descarga X Hogar </th>
                            <th bgcolor="#F5F5F5" >Importar</th>
                        </tr>
                    </tfoot>

                    {foreach from=$arrayReportes key=keyReportes item=valueReportes}    


                        <tr align="center">
                            <td>{$valueReportes.txtNombreReporte}</td><!--onclick="location.href = './exportarRepGral.php?nombre=<?= $valueReportes['txtNombreReporte'] ?>'"-->
                            <td>{$valueReportes.fechaEjecucion}</td> 
                            <td style="text-align: center"><a class="btn btn-info btn-lg" onclick="location.href = './contenidos/reportes/exportarRepGral.php?nombre={$valueReportes.txtNombreReporte}'"  href="#"><span class="glyphicon glyphicon-download-alt" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a></td>
                            <td style="text-align: center"><a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2" onclick="limpiar();
                                    $('#nombre').val('{$valueReportes.txtNombreReporte}');
                                    $('#tipo').val(2)" href="#">
                                    <span class="glyphicon glyphicon-import" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                            </td>
                            <td style="text-align: center">
                                <a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="limpiar();
                                        $('#name').val('{$valueReportes.txtNombreReporte}');" href="#">
                                    <span class="glyphicon glyphicon-export" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                            </td>

                        </tr>

                    {/foreach}
                </table>
                </p>
            </div>
        </div>      

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog" style="height: 350px; width: 600px; z-index: 1041;">
            <div class="modal-dialog modal-sm" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="limpiar()">&times;</button>
                    <h4 class="modal-title">Modulo de modificación de reporte</h4>
                </div>
                <div class="modal-body">
                    <p> Por Favor Seleccione Archivo  </p>

                    <form class="md-form" onsubmit="someterFormulario('contenido', this, './contenidos/reportes/importarRepGral.php', true, true);
                            return false;
                            limpiar()"  enctype="multipart/form-data" method="post">
                        <div class="col-lg-10 col-md-10">
                            <div class="file-field">
                                <a class="btn-floating purple-gradient mt-0 float-left waves-effect waves-light" onclick="archivo()">
                                    <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
                                    <input id="archivo" accept=".xls" name="archivo" type="file"  required="true"/> 
                                    <input name="MAX_FILE_SIZE" type="hidden" value="400000" /> 
                                    <input type="hidden" name="name" id="name" value="" required="true">


                                </a>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate"  id="prueba" type="text" placeholder="Seleccione Archivo" style="border-bottom: 1px solid #ced4da !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2" style="top: 20px">                          
                            <button type="submit" class="btn btn-primary" name="enviar"  onclick="$('.modal-backdrop.fade').hide();"><span class="glyphicon glyphicon-paperclip" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;" ></span>  Subir</button>
                            <!--<input  class="btn btn-primary glyphicon glyphicon-paperclip" name="enviar" type="submit" value="Subir" /><span class="glyphicon glyphicon-paperclip" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;"></span>-->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                  
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="limpiar()">Cerrar</button>                    
                </div>
            </div>

        </div>    
        <div class="modal container" id="myModal2" role="dialog" style="height: 350px; width: 600px; z-index: 1041;">
            <div class="modal-dialog modal-sm" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="limpiar()">&times;</button>
                    <h4 class="modal-title">Modulo de modificación de reporte</h4>
                </div>
                <div class="modal-body">
                    <p> Por Favor Seleccione Archivo  </p>

                    <form class="md-form" onsubmit="someterFormulario('contenido', this, './contenidos/reportes/exportarRepGral.php', true, false);
                            return false;
                            limpiar();"  enctype="multipart/form-data" method="post">
                        <div class="col-lg-8 col-md-8">
                            <div class="file-field">
                                <a class="btn-floating purple-gradient mt-0 float-left waves-effect waves-light" onclick="archivo()">
                                    <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
                                    <input id="archivo2" accept=".txt" name="archivo" type="file"  required="true"/> 
                                    <input name="MAX_FILE_SIZE" type="hidden" value="400000" /> 
                                    <input type="hidden" name="nombre" id="nombre" value="" required="true">
                                    <input type="hidden" name="tipo" id="tipo" value="" required="true">

                                </a>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate"  id="prueba2" type="text" placeholder="Seleccione Archivo" style="border-bottom: 1px solid #ced4da !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2" style="top: 20px">                          
                            <button type="submit" class="btn btn-primary" name="enviar"  onclick="$('.modal-backdrop').hide();
                                    $('#myModal2').hide();"><span class="glyphicon glyphicon-paperclip" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;" ></span>  Descargar</button>
                            <!--<input  class="btn btn-primary glyphicon glyphicon-paperclip" name="enviar" type="submit" value="Subir" /><span class="glyphicon glyphicon-paperclip" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;"></span>-->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                  
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="limpiar()">Cerrar</button>                    
                </div>
            </div>

        </div> 
    </div>
    <!--
    action="./contenidos/reportes/importarRepGral.php" 
    -->
</body>
