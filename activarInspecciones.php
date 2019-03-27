<?php

include("./recursos/archivos/verificarSesion.php");
include("./recursos/archivos/lecturaConfiguracion.php");
include("./recursos/archivos/coneccionBaseDatos.php");
//prueba liliana
$sql = "
    select count(*) as cuenta
    from t_cor_usuario usu
    inner join t_cor_perfil per on usu.seqUsuario = per.seqUsuario
    inner join t_cor_proyecto_grupo pgr on per.seqProyectoGrupo = pgr.seqProyectoGrupo and pgr.seqProyecto = " . $_SESSION['seqProyecto'] . "
    inner join t_cor_grupo gru on pgr.seqGrupo = gru.seqGrupo
    where gru.seqGrupo = 20
    and usu.seqUsuario = " . $_SESSION['seqUsuario'] . "
";
$objRes = $aptBd->execute($sql);

echo $objRes->fields['cuenta'];

?>