

<center>
    <div style="width: 80%; text-align: left; padding-left: 20px; border-bottom: 1px dotted #666666;">
        <h1>
            Bienvenido:&nbsp;
            <small style="font-size: 75%; color: #666666">
                {$smarty.session.txtNombre}&nbsp;{$smarty.session.txtApellido}
            </small>
        </h1>        
    </div>

    <div style="width: 80%; text-align: left; padding-top: 20px; padding-left: 20px;">
        <h3 style="text-align: justify; color:#666666;">
            <p>
            Consulta de hogares que se encuentran inscritos en el programa de Subsidio Distrital de Vivienda en Especie. 
            La información corresponde al grupo familiar, con datos de Esquema de postulación, Modalidad de SDVE y 
            Proyecto con el cual se encuentra Vinculado.
            </p>
            <p>
            <span style="color: #009900;">Para los proyectos del Programa VIPA el hogar debe estar inscrito así: Esquema de postulación individual,  
            Modalidad Adquisición de Vivienda y no estar vinculado a NINGÚN proyecto.</span>
            </p>
            <p>
            <small>Digite la cedula de cualquiera de las personas mayores de edad que conforman el hogar para adelantar la consulta correspondiente</small>
            </p>
        </h3>
    </div>    

    <div style="width: 80%; text-align: center; padding-top: 5px; padding-left: 20px;">
        <form onSubmit="return false;">
            <input type="text"
                   name="documento"
                   id="documento"
                   style="font-size: 150%; color: #666666;"
                   onBlur="soloNumeros(this)"
                   ><br>
            <button style="font-size: 120%;" onClick="someterFormulario('informacion',this.form,'./contenidos/constructoras/consulta.php', false, true);">
                Consultar
            </button>
        </form>
    </div>
            
    <div id="informacion" style="width: 80%; text-align: center; padding-top: 5px; padding-left: 20px;"></div>
            
</center>
            
            
            

            
            

