&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


<form onsubmit="someterFormulario('contenido',this,'./contenidos/cruces2/salvar.php',true,true); return false;">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Crear Cruce</h4>
        </div>
        <div class="panel-body" style="padding-left: 30px; padding-right: 30px;">

            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <td width="120px">Nombre</td>
                    <td width="400px">
                        <input type="text"
                               id="txtNombre"
                               name="txtNombre"
                               value="{$arrPost.txtNombre}"
                               style="width:100%;"
                               onFocus="
                                   autocompletar( 'txtFirma'   , 'txtFirmaContenedor'   , './contenidos/cruces2/nombres.php' , '' );
                                   autocompletar( 'txtElaboro' , 'txtElaboroContenedor' , './contenidos/cruces2/nombres.php' , '' );
                                   autocompletar( 'txtReviso'  , 'txtRevisoContenedor'  , './contenidos/cruces2/nombres.php' , '' );
                               "
                               required
                        >
                    </td>
                    <td width="120px">Publicación</td>
                    <td>
                        <input type="text"
                               id="fchCruce"
                               name="fchCruce"
                               value="{$arrPost.fchCruce}"
                               style="width: 100px"
                               onfocus="this.value=''; calendarioPopUp('fchCruce')"
                               required
                        >
                    </td>
                </tr>
                <tr>
                    <td>Cuerpo</td>
                    <td colspan="3">
                        <textarea id="txtCuerpo" name="txtCuerpo" style="width: 700px; height: 50px;">{$arrPost.txtCuerpo}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Pie</td>
                    <td colspan="3">
                        <textarea id="txtPie" name="txtPie" style="width: 700px; height: 50px;">{$arrPost.txtPie}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Firma</td>
                    <td colspan="3">
                        <input type="text"
                               id="txtFirma"
                               name="txtFirma"
                               value="{$arrPost.txtFirma}"
                               style="width:300px"
                        >
                        <div id="txtFirmaContenedor" style="width:300px;"></div>
                    </td>
                </tr>
                <tr>
                    <td>Elaboró</td>
                    <td colspan="3">
                        <input type="text"
                               id="txtElaboro"
                               name="txtElaboro"
                               value="{$arrPost.txtElaboro}"
                               style="width:300px;"
                        >
                        <div id="txtElaboroContenedor" style="width:300px"></div>
                    </td>
                </tr>
                <tr>
                    <td>Revisó</td>
                    <td colspan="3">
                        <input type="text"
                               id="txtReviso"
                               name="txtReviso"
                               value="{$arrPost.txtReviso}"
                               style="width:300px;"
                        >
                        <div id="txtRevisoContenedor" style="width:300px"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Archivo
                    </td>
                    <td colspan="3">
                        <input type="file" name="archivo" required>
                    </td>
                </tr>
            </table>

        </div>
        <div class="panel-footer" align="center">
            <button type="submit" class="btn btn-primary" style="width: 100px">
                Salvar
            </button>&nbsp;
            <button type="button" class="btn btn-danger" onclick="cargarContenido('contenido','./contenidos/cruces2/formularioCruces.php','',true);" style="width: 100px">
                Cancelar
            </button>&nbsp;
            <button type="button" class="btn btn-default" onclick="cargarContenido('contenido','./contenidos/cruces2/cruces.php','',true);" style="width: 100px">
                Volver
            </button>
        </div>
    </div>

</form>

