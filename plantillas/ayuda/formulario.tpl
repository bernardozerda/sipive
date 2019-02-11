
<ol class="breadcrumb text-info">
    {if not is_null($objMenu)}
        {$objMenu->obtenerMigaDePan($seqProyecto, $seqMenu)}
    {else}
        <li>&nbsp;</li>
    {/if}
</ol>

<form method="post" onsubmit="someterFormulario('contenido',this,'./contenidos/ayuda/salvarAyuda.php',false,true); return false;">

    <div class="form-group">
        <textarea name="texto" id="textoAyuda">{$objMenu->txtAyuda}</textarea>
    </div>

    <div class="form-group h5" style="background-color: #F5F5F5; padding: 5px;">
        <input type="checkbox" name="publicar" value="1" {if $objMenu->bolPublicar == 1} checked {/if}>
        Texto publicado
    </div>

    <div class="row text-center">
        <button class="btn btn-primary btn-sm {if intval($seqMenu) == 0} disabled {/if}" {if intval($seqMenu) == 0} disabled {/if}>
            Guardar
        </button>
    </div>

    <input type="hidden" name="seqProyecto" value="{$seqProyecto}">
    <input type="hidden" name="seqMenu" value="{$seqMenu}">

</form>

<div id="editorAyuda"></div>