<link rel="stylesheet" href="./librerias/jquery/css/bootstrap.min.css"/> 
<link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet" />        
<link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
<link href="./recursos/estilos/inputFile.css" rel="stylesheet" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" 
      integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<div class="panel panel-default" >
    <div class="panel-heading" style="min-height: 0px">
        <h6 class="panel-title">Consulta General Datos Del Hogar </h6>
    </div>
    <div class="panel-body">
        <div class="form-row">
            <div class="col-md-2 mb-3 md-form">
                <label for="seqTipoDocumento"><b>Tipo Documento</b</label>
                <select name="seqTipoDocumento" id="seqTipoDocumento" class="form-control">
                    <option value="1" selected="">CC</option>
                    <option value="2">CE</option>
                    <option value="3">TI</option>
                    <option value="4">RC</option>
                    <option value="5">PAS</option>
                    <option value="6">NIT</option>
                    <option value="7">NUIP</option>
                    <option value="8">Desconocido</option>
                </select>

            </div>
            <div class="col-md-5 mb-3 md-form">
                <label for="numDocumento"><b>Documento Ciudadano</b</label>
                <input type="text"  id="numDocumento" class="form-control is-valid" value="" required>
                <div class="invalid-tooltip" style="display: none">
                    Digite el numero de Documento.
                </div>
            </div>
            <div class="col-md-4 mb-3 md-form"><p>&nbsp;</p>
                <button class="btn btn-primary btn-sm btn-rounded" type="button" onclick="datosExternos(this.numDocumento)">Consultar</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default" style=" min-width: 900px; width: 95% ">
    <div class="panel-body">
        <div id="resultado"> </div>
    </div>
</div>