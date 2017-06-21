<?php

// Aqui para cada fase de desembolso se definen los estados hacia los cuales se puede
// avanzar, la plantilla smaty que se usa para mostrar los datos, el codigo php que responde 
// la peticion y la funcion que imprime el formulario
$arrFasesDesembolsoIndicadores['Asignados']['estados'][] = 15; // Asignacion - Asignado

$arrFasesDesembolsoIndicadores['Busqueda de la Oferta']['estados'][] = 19; // Desembolso - Busqueda Oferta

$arrFasesDesembolsoIndicadores['Revisión Jurídica']['estados'][] = 22; // Desembolso - Estudio de Predio

$arrFasesDesembolsoIndicadores['Revisión Técnica']['estados'][] = 24; // Desembolso - Revision juridica aprobada

$arrFasesDesembolsoIndicadores['Escrituración']['estados'][] = 26; // Desembolso - Revision tecnica aprobada
$arrFasesDesembolsoIndicadores['Escrituración']['estados'][] = 27; // Desembolso - Escrituracion
/// SEMAFORO TIEMPO TUTOR CON RADICADO DE ESCRITUTAS
$arrFasesDesembolsoIndicadores['Radicado Titulos']['estados'][] = 26; // Desembolso - Revision tecnica aprobada
$arrFasesDesembolsoIndicadores['Radicado Titulos']['estados'][] = 27; // Desembolso - Escrituracion 

$arrFasesDesembolsoIndicadores['Estudio de Titulos']['estados'][] = 28; // Desembolso - Estudio de Titulos
$arrFasesDesembolsoIndicadores['Estudio de Titulos']['estados'][] = 29; // Desembolso - Estudio de Titulos aprobado

$arrFasesDesembolsoIndicadores['Solicitud de Desembolso']['estados'][] = 30; // Desembolso - Solicitud de desembolso
$arrFasesDesembolsoIndicadores['Solicitud de Desembolso']['estados'][] = 32; // Desembolso - Parcial

$seqDesembolsoTotal = 33; // Desembolso - TOTAL


$arrMeses = array();
$arrMeses[1] = "Enero";
$arrMeses[2] = "Febrero";
$arrMeses[3] = "Marzo";
$arrMeses[4] = "Abril";
$arrMeses[5] = "Mayo";
$arrMeses[6] = "Junio";
$arrMeses[7] = "Julio";
$arrMeses[8] = "Agosto";
$arrMeses[9] = "Septiembre";
$arrMeses[10] = "Octubre";
$arrMeses[11] = "Noviembre";
$arrMeses[12] = "Diciembre";

$valAnno = date("Y");

$arrAnnos = array();
for ($anno = 2006; $anno <= ( $valAnno + 1 ); $anno++) {
    $arrAnnos[] = $anno;
}
?>
