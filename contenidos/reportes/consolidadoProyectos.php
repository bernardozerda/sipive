<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

$sql = "SELECT txtNombreProyecto, pry.seqProyecto, txtNombreOferente, numActo, YEAR( fchActo ) AS fecha, COUNT( seqTipoActoUnidad ) AS numeroUnidades, SUM( valIndexado ) AS valorAsignado
FROM T_PRY_AAD_UNIDAD_ACTO
LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON ( T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo ) 
LEFT JOIN T_PRY_UNIDAD_PROYECTO uni ON ( T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = uni.seqUnidadProyecto ) 
LEFT JOIN T_PRY_PROYECTO pry ON ( uni.seqProyecto = pry.seqProyecto ) 
LEFT JOIN t_pry_entidad_oferente tpeo ON ( tpeo.seqProyecto = pry.seqProyecto ) 
WHERE seqTipoActoUnidad =1
GROUP BY txtNombreProyecto";
$sqlYear  ="select distinct(year(fchActo)) as fechaActo from t_pry_aad_unidad_acto where seqTipoActoUnidad = 2 group by fechaActo order by fechaActo asc";
		$objYear = $aptBd->execute($sqlYear);
		$i=0;
		$year = Array();
		 while ($objYear->fields) {
			 $year[$i] = $objYear->fields['fechaActo'];
			 $i++;
			 $objYear->MoveNext();
		 }
$tabla = "<table border='1'>";
$tabla .="<tr>"
        . "<th>Nombre del Proyecto</th>"
        . "<th>Entidad Oferente - Constructora</th>"
        . "<th>Resolucion Aprobacion del comite de Elegibilidad</th>"
        . "<th>". utf8_decode("Año")." de resoluci&oacuten</th>"
        . "<th>Cantidad de VIP generadas</th>"
        . "<th>Valor inicial SDVE</th>";
		for($j=0; $j < count($year); $j++){
			$tabla .= "<th>".$year[$j]."</th>";
		}
       $tabla .= "</tr>";
		
		
		
			 

try {
    $objRes = $aptBd->execute($sql);
    while ($objRes->fields) {
		  $tabla .="<tr>";
        $tabla .= "<td>".$objRes->fields['seqProyecto']." -> ".$objRes->fields['txtNombreProyecto']."</td>"
                . "<td>".$objRes->fields['txtNombreOferente']."</td>"
                . "<td>".$objRes->fields['numActo']."</td>"
                . "<td>".$objRes->fields['fecha']."</td>"
                . "<td>".$objRes->fields['numeroUnidades']."</td>"
                . "<td>".$objRes->fields['valorAsignado']."</td>"	;	

		for($j=0; $j < count($year); $j++){
			//echo "j:" . $j . " i: ". $i. "<br>";
			$sql2 ="SELECT txtNombreProyecto,  numActo, YEAR(fchActo) AS fecha, SUM(valIndexado) AS valorIndexado
FROM T_PRY_AAD_UNIDAD_ACTO
LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON (T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo)
LEFT JOIN T_PRY_UNIDAD_PROYECTO uni ON (T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = uni.seqUnidadProyecto)
LEFT JOIN T_PRY_PROYECTO pry ON (uni.seqProyecto = pry.seqProyecto)
WHERE YEAR(fchActo) = ".$year[$j]."
AND seqTipoActoUnidad = 2
and uni.seqProyecto = ".$objRes->fields['seqProyecto']."
GROUP BY txtNombreProyecto
ORDER BY txtNombreProyecto";
$obj2 = $aptBd->execute($sql2);
$tabla .= "<td><table border='1'>";
 while ($obj2->fields) {
			
		$tabla .= "<tr>
			<td>".$obj2->fields['numActo']."</td>
			<td>".$year[$j]."</td>
			<td>".$obj2->fields['valorIndexado']."</td>
			</tr>
			";			
			
			 $obj2->MoveNext();
			 
		}
	$tabla .= "</table></td>";
		}		
        $tabla .="</tr>";
        $objRes->MoveNext();
    }
} catch (Exception $objError) {
    return $objError->msg;
}

$tabla .="</table>";
echo $tabla;