<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// Obtiene los datos
$txtConsulta = strtolower(trim($_GET['query']));
$arrResultados = array();

try {
    $sql = "SELECT DISTINCT
        UPPER(txtNombreOferente) AS nombre
    FROM
        t_pry_entidad_oferente  where txtNombreOferente like '%$txtConsulta%' 
        UNION ALL
        SELECT DISTINCT
            UPPER(txtNombreConstructor) AS nombre
        FROM
            t_pry_constructor  where txtNombreConstructor like '%$txtConsulta%' 
            group by nombre
            order by nombre";


    $objRes = $aptBd->execute($sql);
    while ($objRes->fields) {
        $arrResultados[] = $objRes->fields['nombre']." ". $txtConsulta;
        $objRes->MoveNext();
    }
} catch (Exception $objError) {
    $arrResultados = array();
}

// Despliega los resultados
if(count($arrResultados) <1){
    $arrResultados[0] = $txtConsulta;
}
echo implode("\n", $arrResultados);
?>
