&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
      >
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Proceso Legalización Mi Casa Ya!</h6>
    </div>
    <div class="panel-body">


    </div>
    <div class="panel-footer text-center" style="height: 55px;">
        <form method="post"
              class="form-horizontal"
              onsubmit="someterFormulario('contenido', this, './contenidos/legalizacionMCY/salvar.php', true, true);
                      return false;"
              >

            <label for="archivo" class="col-sm-1 control-label ">Archivo</label>
            <div class="col-sm-5">
                <div class="input-group input-group-sm">
                    <label class="input-group-btn">
                        <span class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                            <input id="archivo" type="file" name="archivo" style="display: none;">
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                    <div id="fileSelect"></div>
                </div>
            </div>

            <div class="col-sm-2">
                <button type="submit"
                        class="btn btn-primary btn-sm"
                        >
                    Cargar Datos
                </button>
            </div>

            <div class="col-sm-2">
                <button type="button"
                        class="btn btn-success btn-sm"
                        onclick="filasPlantilla();">Plantilla</button>
                <!-- location.href = './contenidos/legalizacionMCY/plantilla.php'"-->                        

            </div>
        </form>
    </div>
</div>