<div class="alert">
    <div class="row">
        <div class="col-sm-10">
            <h4>
                <p>{$claInscripcion->txtEstado}</p>
                {if $claInscripcion->seqEstado == 2 and $claInscripcion->numProgreso == 100}
                    <small>Almacenando novedades en la base de datos</small>
                {else}
                    <small>{$claInscripcion->txtDescripcion}</small>
                {/if}
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="progress">
                <div class="progress-bar"
                     role="progressbar"
                     aria-valuenow="{$claInscripcion->numProgreso}"
                     aria-valuemin="0"
                     aria-valuemax="100"
                     style="min-width: 4em; width: {$claInscripcion->numProgreso}%;"
                >
                    {$claInscripcion->numProgreso}%
                </div>
            </div>
        </div>
    </div>
</div>
{if $claInscripcion->seqEstado == 2}
    <div id="progresoFNV" style="display: none">{$claInscripcion->seqCargue}</div>
{/if}