<?php

$txtPrefijoRuta = "./";

include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

//unlink('../recursos/imagenes/desembolsos/14100(7).jpg');
//foreach ($array as $key => $value) {
//    echo "<br>".'/recursos/imagenes/desembolsos/'.$value;
//    unlink('recursos/imagenes/desembolsos/'.$value);
//}
EliminarImagenes();

function EliminarImagenes() {

    global $aptBd;
    $sql = "SELECT seqTecnico, seqFormulario, txtNombreArchivo FROM t_des_tecnico 
left join t_des_adjuntos_tecnicos using(seqTecnico)
left join t_des_desembolso using(seqDesembolso)
where seqTecnico in (9212	,
9265	,
9210	,
9211	,
9257	,
9217	,
9209	,
9213	,
9218	,
9258	,
9256	,
9264	,
4640	,
9266	,
9418	,
9268	);";
    $objRes = $aptBd->execute($sql);
    $txtArchivo = "Archivo;Existe\n";
    $cont = 0;
    while ($objRes->fields) {
        if (file_exists("./recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'])) {
            echo $cont . " *** SI " . $objRes->fields['txtNombreArchivo'] . "<br>";
            unlink('recursos/imagenes/desembolsos/' . $objRes->fields['txtNombreArchivo']);
        } else {
            echo $cont . " &&& " . $objRes->fields['txtNombreArchivo'] . " NO<br>";
        }
        $cont++;
        $objRes->MoveNext();
    }
}
