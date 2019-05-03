<link rel="stylesheet" href="./librerias/jquery/css/bootstrap.min.css"/> 
<link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet" />        
<link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
<link href="./recursos/estilos/inputFile.css" rel="stylesheet" />
{literal}
    <style>
        .panel-heading {
            padding: 10px 15px;
            min-height: 60px
        }
    </style>
{/literal}
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="col-lg-9 col-md-9" style="top: 10px">
            <h6 class="panel-title"> Información de Calificación {$fecha}</h6>
        </div>
        <div class="col-lg-3 col-md-3" style="text-align: right;">
            <button type="submit" class="pressed" style="width: 50%; background-color: #004080" name="enviar"   
                    onclick="cargarContenido('contenido', './contenidos/calificacion/calificacionFormularios.php', '', true);" >
                <span class ="glyphicon glyphicon-arrow-left" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;" ></span>&nbsp; Volver</button>
        </div>

    </div>
    <div class="panel-body">
        <center>
            <table id="example" class="table table-striped table-bordered" cellspacing="0"  >
                <thead>
                    <tr>
                        <th bgcolor="#E4E4E4" align="center" ><b>Formulario</b></th>
                        <th bgcolor="#E4E4E4" ><b>Informacion Hogar</b></th>
                        <th bgcolor="#E4E4E4" ><b>Cant. Miembros</b></th>
                        <th bgcolor="#E4E4E4" ><b>Ingresos</b></th>
                        <th bgcolor="#E4E4E4" ><b>Calificación</b></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th bgcolor="#E4E4E4" align="center" ><b>Formulario</b></th>
                        <th bgcolor="#E4E4E4" ><b>Informacion Hogar</b></th>
                        <th bgcolor="#E4E4E4" ><b>Cant. Miembros</b></th>
                        <th bgcolor="#E4E4E4" ><b>Ingresos</b></th>
                        <th bgcolor="#E4E4E4" ><b>Calificación</b></th>
                    </tr>
                </tfoot>
                {foreach from=$datos key=key item=value} 
                    {assign var="parts" value=","|explode:$value.infHogar}

                    <tr >
                        <td  align="center" nowrap style="text-align: center;vertical-align: middle;">{$value.seqFormulario}&nbsp;</td>
                        <td width="80%"> 
                            <table style="width: 80%">
                                {foreach from=$parts key=keyParts item=valueParts} 
                                    {assign var="valExpInfHog" value="-"|explode:$valueParts}
                                    <tr>
                                        <td style="margin: 0; padding: 0;border: 0; width: 10%">{$valExpInfHog[0]}</td>
                                        <td style="margin: 0; padding: 0; border: 0; padding-left: 1%; width: 50%">{$valExpInfHog[1]|substr:0:-2} </td>
                                        <td style="margin: 0; padding: 0; border: 0; padding-left: 1%; width: 10%">{$valExpInfHog[1]|substr:-2}</td>
                                    </tr>
                                {/foreach}
                                {*$value.infHogar|replace:",":"<br>"*}
                            </table>
                        </td>
                        <td align="center" style="text-align: center;vertical-align: middle;">{$value.cantMiembrosHogar }&nbsp;</td>
                        <td  align="center" style="text-align: center;vertical-align: middle;"><b>$</b>{$value.totalIngresos|number_format:2:".":","}&nbsp;</td>               
                        <td  align="center" style="text-align: center;vertical-align: middle;"><b> {$value.total|number_format:3:".":","}%</b>&nbsp;</td>            
                    </tr>
                {/foreach}
            </table>
        </center>
        <script src="../../librerias/javascript/dataTable.js"></script> 
    </div>