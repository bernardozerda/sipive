<div class="form-group" >
    {foreach from=$arrImagenes key=keyImg item=valueImg} 
        {*  <img src="recursos/proyectos/{$valueImg}" >{$valueImg}*}
        <div class="col-md-3">
            <img src="recursos/proyectos/{$valueImg}" class="img-circle" alt="Card image cap" height="150" width="150" />        
        </div>
    {/foreach}
</div>