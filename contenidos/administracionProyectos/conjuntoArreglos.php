<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$arrayconjuntos[$seqProyecto]['seqProyectoHijo'] = $_POST["seqProyectoHijo"];
$arrayconjuntos[$seqProyecto]['txtNombreProyectoHijo'] = $_POST["txtNombreProyectoHijo"];
$arrayconjuntos[$seqProyecto]['txtNombreComercialHijo'] = $_POST["txtNombreComercialHijo"];
$arrayconjuntos[$seqProyecto]['txtDireccionHijo'] = $_POST["txtDireccionHijo"];
$arrayconjuntos[$seqProyecto]['valNumeroSolucionesHijo'] = $_POST["valNumeroSolucionesHijo"];
$arrayconjuntos[$seqProyecto]['txtChipLoteHijo'] = $_POST["txtChipLoteHijo"];
$arrayconjuntos[$seqProyecto]['txtMatriculaInmobiliariaLoteHijo'] = $_POST["txtMatriculaInmobiliariaLoteHijo"];
$arrayconjuntos[$seqProyecto]['txtLicenciaUrbanismoHijo'] = $_POST["txtLicenciaUrbanismoHijo"];
$arrayconjuntos[$seqProyecto]['fchLicenciaUrbanismo1Hijo'] = $_POST["fchLicenciaUrbanismo1Hijo"];
$arrayconjuntos[$seqProyecto]['fchVigenciaLicenciaUrbanismoHijo'] = $_POST["fchVigenciaLicenciaUrbanismoHijo"];
$arrayconjuntos[$seqProyecto]['txtExpideLicenciaUrbanismoHijo'] = $_POST["txtExpideLicenciaUrbanismoHijo"];
$arrayconjuntos[$seqProyecto]['txtLicenciaConstruccionHijo'] = $_POST["txtLicenciaConstruccionHijo"];
$arrayconjuntos[$seqProyecto]['fchLicenciaConstruccion1Hijo'] = $_POST["fchLicenciaConstruccion1Hijo"];
$arrayconjuntos[$seqProyecto]['fchVigenciaLicenciaConstruccionHijo'] = $_POST["fchVigenciaLicenciaConstruccionHijo"];
$arrayconjuntos[$seqProyecto]['txtNombreVendedorHijo'] = $_POST["txtNombreVendedorHijo"];
$arrayconjuntos[$seqProyecto]['numNitVendedorHijo'] = $_POST["numNitVendedorHijo"];
$arrayconjuntos[$seqProyecto]['txtCedulaCatastralHijo'] = $_POST["txtCedulaCatastralHijo"];
$arrayconjuntos[$seqProyecto]['txtEscrituraHijo'] = $_POST["txtEscrituraHijo"];
$arrayconjuntos[$seqProyecto]['fchEscrituraHijo'] = $_POST["fchEscrituraHijo"];
$arrayconjuntos[$seqProyecto]['numNotariaHijo'] = $_POST["numNotariaHijo"];

$arrayTipoViviendas[$seqProyecto]['seqTipoVivienda'] = $_POST["seqTipoVivienda"];
$arrayTipoViviendas[$seqProyecto]['txtNombreTipoVivienda'] = $_POST["txtNombreTipoVivienda"];
$arrayTipoViviendas[$seqProyecto]['numCantidad'] = $_POST["numCantidad"];
$arrayTipoViviendas[$seqProyecto]['numCantUdsDisc'] = $_POST["numCantUdsDisc"];
$arrayTipoViviendas[$seqProyecto]['numTotalParq'] = $_POST["numTotalParq"];
$arrayTipoViviendas[$seqProyecto]['numCantParqDisc'] = $_POST["numCantParqDisc"];
$arrayTipoViviendas[$seqProyecto]['numArea'] = $_POST["numArea"];
$arrayTipoViviendas[$seqProyecto]['numAnoVenta'] = $_POST["numAnoVenta"];
$arrayTipoViviendas[$seqProyecto]['valPrecioVenta'] = $_POST["valPrecioVenta"];
$arrayTipoViviendas[$seqProyecto]['valCierre'] = $_POST["valCierre"];
$arrayTipoViviendas[$seqProyecto]['txtDescripcion'] = $_POST["txtDescripcion"];

$arraycronograma[$seqProyecto]['seqCronogramaFecha'] = $_POST['seqCronogramaFecha'];
$arraycronograma[$seqProyecto]['numActaDescriptiva'] = $_POST['numActaDescriptiva'];
$arraycronograma[$seqProyecto]['numAnoActaDescriptiva'] = $_POST['numAnoActaDescriptiva'];
$arraycronograma[$seqProyecto]['fchInicialProyecto'] = $_POST['fchInicialProyecto'];
$arraycronograma[$seqProyecto]['fchFinalProyecto'] = $_POST['fchFinalProyecto'];
$arraycronograma[$seqProyecto]['valPlazoEjecucion'] = $_POST['valPlazoEjecucion'];
$arraycronograma[$seqProyecto]['fchInicialEntrega'] = $_POST['fchInicialEntrega'];
$arraycronograma[$seqProyecto]['fchFinalEntrega'] = $_POST['fchFinalEntrega'];
$arraycronograma[$seqProyecto]['fchInicialEscrituracion'] = $_POST['fchInicialEscrituracion'];
$arraycronograma[$seqProyecto]['fchFinalEscrituracion'] = $_POST['fchFinalEscrituracion'];

$arrayAmparos[$seqProyecto]['seqAmparo'] = $_POST['seqAmparo'];
$arrayAmparos[$seqProyecto]['seqAmparoPadre'] = $_POST['seqAmparoPadre'];
$arrayAmparos[$seqProyecto]['seqTipoAmparo'] = $_POST['seqTipoAmparo'];
$arrayAmparos[$seqProyecto]['fchVigenciaIni'] = $_POST['fchVigenciaIni'];
$arrayAmparos[$seqProyecto]['fchVigenciaFin'] = $_POST['fchVigenciaFin'];
$arrayAmparos[$seqProyecto]['valAsegurado'] = $_POST['valAsegurado'];
$arrayAmparos[$seqProyecto]['seqUsuario'] = $_POST['seqUsuario'];
$arrayAmparos[$seqProyecto]['bolAprobo'] = $_POST['bolAprobo'];

$arrayFiducia['seqDatoFiducia'] = $_POST['seqDatoFiducia'];
$arrayFiducia['seqTipoContrato'] = $_POST['seqTipoContrato'];
$arrayFiducia['numContratoFiducia'] = $_POST['numContratoFiducia'];
$arrayFiducia['fchContratoFiducia'] = $_POST['fchContratoFiducia'];
$arrayFiducia['numCuentaFiducia'] = $_POST['numCuentaFiducia'];
$arrayFiducia['seqTipoCuentaFiducia'] = $_POST['seqTipoCuentaFiducia'];
$arrayFiducia['txtContactoFiducia'] = $_POST['txtContactoFiducia'];
$arrayFiducia['numTelContactoFiducia'] = $_POST['numTelContactoFiducia'];
$arrayFiducia['seqEntidadFiducia'] = $_POST['seqEntidadFiducia'];
$arrayFiducia['txtEntidadFiducia'] = $_POST['txtEntidadFiducia'];
$arrayFiducia['numIdEntidad'] = $_POST['numIdEntidad'];
$arrayFiducia['seqCiudad'] = $_POST['seqCiudad'];
$arrayFiducia['valContratoFiducia'] = $_POST['valContratoFiducia'];
$arrayFiducia['fchVigenciaContratoFiducia'] = $_POST['fchVigenciaContratoFiducia'];
$arrayFiducia['seqTipoRecursoFiducia'] = $_POST['seqTipoRecursoFiducia'];
$arrayFiducia['txtRazonSocialFiducia'] = $_POST['txtRazonSocialFiducia'];
$arrayFiducia['numNitFiducia'] = $_POST['numNitFiducia'];
$arrayFiducia['seqBanco'] = $_POST['seqBanco'];
$arrayFiducia['seqBanco1'] = $_POST['seqBanco1'];

$arrayFiducia['seqTipoFideicomitente'] = $_POST['seqTipoFideicomitente'];
$arrayFiducia['txtNombreFideicomitente'] = $_POST['txtNombreFideicomitente'];
$arrayFiducia['seqFideicomitente'] = $_POST['seqFideicomitente'];

//foreach ($arrayFiducia['seqTipoFideicomitente'] as $key => $value) {
//    echo "key = ".$key ." value -> ".$value."   nombre = ".$arrayFiducia['txtFideicomitiente'][$key];
//}

