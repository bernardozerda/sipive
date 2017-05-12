<?php

$lineas = file('data.txt');
$consulta = "INSERT INTO t_pry_tecnico(
                          seqTecnicoUnidad,
                          seqUnidadProyecto,
                          numLargoMultiple,
                          numAnchoMultiple,
                          numAreaMultiple,
                          txtMultiple,
                          numLargoAlcoba1,
                          numAnchoAlcoba1,
                          numAreaAlcoba1,
                          txtAlcoba1,
                          numLargoAlcoba2,
                          numAnchoAlcoba2,
                          numAreaAlcoba2,
                          txtAlcoba2,
                          numLargoAlcoba3,
                          numAnchoAlcoba3,
                          numAreaAlcoba3,
                          txtAlcoba3,
                          numLargoCocina,
                          numAnchoCocina,
                          numAreaCocina,
                          txtCocina,
                          numLargoBano1,
                          numAnchoBano1,
                          numAreaBano1,
                          txtBano1,
                          numLargoBano2,
                          numAnchoBano2,
                          numAreaBano2,
                          txtBano2,
                          numLargoLavanderia,
                          numAnchoLavanderia,
                          numAreaLavanderia,
                          txtLavanderia,
                          numLargoCirculaciones,
                          numAnchoCirculaciones,
                          numAreaCirculaciones,
                          txtCirculaciones,
                          numLargoPatio,
                          numAnchoPatio,
                          numAreaPatio,
                          txtPatio,
                          numAreaTotal,
                          txtEstadoCimentacion,
                          txtCimentacion,
                          txtEstadoPlacaEntrepiso,
                          txtPlacaEntrepiso,
                          txtEstadoMamposteria,
                          txtMamposteria,
                          txtEstadoCubierta,
                          txtCubierta,
                          txtEstadoVigas,
                          txtVigas,
                          txtEstadoColumnas,
                          txtColumnas,
                          txtEstadoPanetes,
                          txtPanetes,
                          txtEstadoEnchapes,
                          txtEnchapes,
                          txtEstadoAcabados,
                          txtAcabados,
                          txtEstadoHidraulicas,
                          txtHidraulicas,
                          txtEstadoElectricas,
                          txtElectricas,
                          txtEstadoSanitarias,
                          txtSanitarias,
                          txtEstadoGas,
                          txtGas,
                          txtEstadoMadera,
                          txtMadera,
                          txtEstadoMetalica,
                          txtMetalica,
                          numLavadero,
                          txtLavadero,
                          numLavaplatos,
                          txtLavaplatos,
                          numLavamanos,
                          txtLavamanos,
                          numSanitario,
                          txtSanitario,
                          numDucha,
                          txtDucha,
                          txtEstadoVidrios,
                          txtVidrios,
                          txtEstadoPintura,
                          txtPintura,
                          txtOtros,
                          txtObservacionOtros,
                          numContadorAgua,
                          txtEstadoConexionAgua,
                          txtDescripcionAgua,
                          numContadorEnergia,
                          txtEstadoConexionEnergia,
                          txtDescripcionEnergia,
                          numContadorAlcantarillado,
                          txtEstadoConexionAlcantarillado,
                          txtDescripcionAlcantarillado,
                          numContadorGas,
                          txtEstadoConexionGas,
                          txtDescripcionGas,
                          numContadorTelefono,
                          txtEstadoConexionTelefono,
                          txtDescripcionTelefono,
                          txtEstadoAndenes,
                          txtDescripcionAndenes,
                          txtEstadoVias,
                          txtDescripcionVias,
                          txtEstadoServiciosComunales,
                          txtDescripcionServiciosComunales,
                          txtDescripcionVivienda,
                          txtNormaNSR98,
                          txtRequisitos,
                          txtExistencia,
                          txtDescipcionNormaNSR98,
                          txtDescripcionRequisitos,
                          txtDescripcionExistencia,
                          fchVisita,
                          txtAprobo,
                          fchCreacion,
                          fchActualizacion) 
                          VALUES ";

$file = fopen("query_insert.sql", "a") or die("Problemas");
fputs($file, $consulta);
fputs($file, "\n");

foreach ($lineas as $linea_num => $linea) {
    $datos = explode("\t", $linea);

    $seqTecnicoUnidad = trim($datos [5]);
    $seqUnidadProyecto = trim($datos [5]);
    $numLargoMultiple = (trim($datos [6]) == '') ? 0 : str_replace(",", ".", trim($datos [6]));
    $numAnchoMultiple = (trim($datos [7]) == '') ? 0 : str_replace(",", ".", trim($datos [7]));
    $numAreaMultiple = (trim($datos [8]) == '') ? 0 : str_replace(",", ".", trim($datos [8]));
    $txtMultiple = trim($datos [9]);
    $numLargoAlcoba1 = (trim($datos [10]) == '') ? 0 : str_replace(",", ".", trim($datos [10]));
    $numAnchoAlcoba1 = (trim($datos [11]) == '') ? 0 : str_replace(",", ".", trim($datos [11]));
    $numAreaAlcoba1 = (trim($datos [12]) == '') ? 0 : str_replace(",", ".", trim($datos [12]));
    $txtAlcoba1 = trim($datos [13]);
    $numLargoAlcoba2 = (trim($datos [14]) == '') ? 0 : str_replace(",", ".", trim($datos [14]));
    $numAnchoAlcoba2 = (trim($datos [15]) == '') ? 0 : str_replace(",", ".", trim($datos [15]));
    $numAreaAlcoba2 = (trim($datos [16]) == '') ? 0 : str_replace(",", ".", trim($datos [16]));
    $txtAlcoba2 = trim($datos [17]);
    $numLargoAlcoba3 = (trim($datos [18]) == '') ? 0 : str_replace(",", ".", trim($datos [18]));
    $numAnchoAlcoba3 = (trim($datos [19]) == '') ? 0 : str_replace(",", ".", trim($datos [19]));
    $numAreaAlcoba3 = (trim($datos [20]) == '') ? 0 : str_replace(",", ".", trim($datos [20]));
    $txtAlcoba3 = trim($datos [21]);
    $numLargoCocina = (trim($datos [22]) == '') ? 0 : str_replace(",", ".", trim($datos [22]));
    $numAnchoCocina = (trim($datos [23]) == '') ? 0 : str_replace(",", ".", trim($datos [23]));
    $numAreaCocina = (trim($datos [24]) == '') ? 0 : str_replace(",", ".", trim($datos [24]));
    $txtCocina = trim($datos [25]);
    $numLargoBano1 = (trim($datos [26]) == '') ? 0 : str_replace(",", ".", trim($datos [26]));
    $numAnchoBano1 = (trim($datos [27]) == '') ? 0 : str_replace(",", ".", trim($datos [27]));
    $numAreaBano1 = (trim($datos [28]) == '') ? 0 : str_replace(",", ".", trim($datos [28]));
    $txtBano1 = trim($datos [29]);
    $numLargoBano2 = (trim($datos [30]) == '') ? 0 : str_replace(",", ".", trim($datos [30]));
    $numAnchoBano2 = (trim($datos [31]) == '') ? 0 : str_replace(",", ".", trim($datos [31]));
    $numAreaBano2 = (trim($datos [32]) == '') ? 0 : str_replace(",", ".", trim($datos [32]));
    $txtBano2 = trim($datos [33]);
    $numLargoLavanderia = (trim($datos [34]) == '') ? 0 : str_replace(",", ".", trim($datos [34]));
    $numAnchoLavanderia = (trim($datos [35]) == '') ? 0 : str_replace(",", ".", trim($datos [35]));
    $numAreaLavanderia = (trim($datos [36]) == '') ? 0 : str_replace(",", ".", trim($datos [36]));
    $txtLavanderia = trim($datos [37]);
    $numLargoCirculaciones = (trim($datos [38]) == '') ? 0 : str_replace(",", ".", trim($datos [38]));
    $numAnchoCirculaciones = (trim($datos [39]) == '') ? 0 : str_replace(",", ".", trim($datos [39]));
    $numAreaCirculaciones = (trim($datos [40]) == '') ? 0 : str_replace(",", ".", trim($datos [40]));
    $txtCirculaciones = trim($datos [41]);
    $numLargoPatio = (trim($datos [42]) == '') ? 0 : str_replace(",", ".", trim($datos [42]));
    $numAnchoPatio = (trim($datos [43]) == '') ? 0 : str_replace(",", ".", trim($datos [43]));
    $numAreaPatio = (trim($datos [44]) == '') ? 0 : str_replace(",", ".", trim($datos [44]));
    $txtPatio = trim($datos [45]);
    $numAreaTotal = (trim($datos [46]) == '') ? 0 : str_replace(",", ".", trim($datos [46]));
    $txtEstadoCimentacion = trim($datos [47]);
    $txtCimentacion = trim($datos [48]);
    $txtEstadoPlacaEntrepiso = trim($datos [49]);
    $txtPlacaEntrepiso = trim($datos [50]);
    $txtEstadoMamposteria = trim($datos [51]);
    $txtMamposteria = trim($datos [52]);
    $txtEstadoCubierta = trim($datos [53]);
    $txtCubierta = trim($datos [54]);
    $txtEstadoVigas = trim($datos [55]);
    $txtVigas = trim($datos [56]);
    $txtEstadoColumnas = trim($datos [57]);
    $txtColumnas = trim($datos [58]);
    $txtEstadoPanetes = trim($datos [59]);
    $txtPanetes = trim($datos [60]);
    $txtEstadoEnchapes = trim($datos [61]);
    $txtEnchapes = trim($datos [62]);
    $txtEstadoAcabados = trim($datos [63]);
    $txtAcabados = trim($datos [64]);
    $txtEstadoHidraulicas = trim($datos [65]);
    $txtHidraulicas = trim($datos [66]);
    $txtEstadoElectricas = trim($datos [67]);
    $txtElectricas = trim($datos [68]);
    $txtEstadoSanitarias = trim($datos [69]);
    $txtSanitarias = trim($datos [70]);
    $txtEstadoGas = trim($datos [71]);
    $txtGas = trim($datos [72]);
    $txtEstadoMadera = trim($datos [73]);
    $txtMadera = trim($datos [74]);
    $txtEstadoMetalica = trim($datos [75]);
    $txtMetalica = trim($datos [76]);
    $numLavadero = (trim($datos [77]) == '') ? 0 : str_replace(",", ".", trim($datos [77]));
    $txtLavadero = trim($datos [78]);
    $numLavaplatos = (trim($datos [79]) == '') ? 0 : str_replace(",", ".", trim($datos [79]));
    $txtLavaplatos = trim($datos [80]);
    $numLavamanos = (trim($datos [81]) == '') ? 0 : str_replace(",", ".", trim($datos [81]));
    $txtLavamanos = trim($datos [82]);
    $numSanitario = (trim($datos [83]) == '') ? 0 : str_replace(",", ".", trim($datos [83]));
    $txtSanitario = trim($datos [84]);
    $numDucha = (trim($datos [85]) == '') ? 0 : str_replace(",", ".", trim($datos [85]));
    $txtDucha = trim($datos [86]);
    $txtEstadoVidrios = trim($datos [87]);
    $txtVidrios = trim($datos [88]);
    $txtEstadoPintura = trim($datos [89]);
    $txtPintura = trim($datos [90]);
    $txtOtros = trim($datos [91]);
    $txtObservacionOtros = trim($datos [92]);
    $numContadorAgua = (trim($datos [93]) == '') ? 0 : str_replace(",", ".", trim($datos [93]));
    $txtEstadoConexionAgua = trim($datos [94]);
    $txtDescripcionAgua = trim($datos [95]);
    $numContadorEnergia = (trim($datos [96]) == '') ? 0 : str_replace(",", ".", trim($datos [96]));
    $txtEstadoConexionEnergia = trim($datos [97]);
    $txtDescripcionEnergia = trim($datos [98]);
    $numContadorAlcantarillado = (trim($datos [99]) == '') ? 0 : str_replace(",", ".", trim($datos [99]));
    $txtEstadoConexionAlcantarillado = trim($datos [100]);
    $txtDescripcionAlcantarillado = trim($datos [101]);
    $numContadorGas = (trim($datos [102]) == '') ? 0 : str_replace(",", ".", trim($datos [102]));
    $txtEstadoConexionGas = trim($datos [103]);
    $txtDescripcionGas = trim($datos [104]);
    $numContadorTelefono = (trim($datos [105]) == '') ? 0 : str_replace(",", ".", trim($datos [105]));
    $txtEstadoConexionTelefono = trim($datos [106]);
    $txtDescripcionTelefono = trim($datos [107]);
    $txtEstadoAndenes = trim($datos [108]);
    $txtDescripcionAndenes = trim($datos [109]);
    $txtEstadoVias = trim($datos [110]);
    $txtDescripcionVias = trim($datos [111]);
    $txtEstadoServiciosComunales = trim($datos [112]);
    $txtDescripcionServiciosComunales = trim($datos [113]);
    $txtDescripcionVivienda = trim($datos [114]);
    $txtNormaNSR98 = trim($datos [115]);
    $txtRequisitos = trim($datos [116]);
    $txtExistencia = trim($datos [117]);
    $txtDescipcionNormaNSR98 = trim($datos [118]);
    $txtDescripcionRequisitos = trim($datos [119]);
    $txtDescripcionExistencia = trim($datos [120]);
    $fchVisita = trim($datos [121]);
    $txtAprobo = trim($datos [122]);
    $fchCreacion = trim($datos [123]);
    $fchActualizacion = trim($datos [124]);


    $valores = "(
                        $seqTecnicoUnidad,
                        $seqUnidadProyecto,
                        $numLargoMultiple,
                        $numAnchoMultiple,
                        $numAreaMultiple,
                        '$txtMultiple',
                        $numLargoAlcoba1,
                        $numAnchoAlcoba1,
                        $numAreaAlcoba1,
                        '$txtAlcoba1',
                        $numLargoAlcoba2,
                        $numAnchoAlcoba2,
                        $numAreaAlcoba2,
                        '$txtAlcoba2',
                        $numLargoAlcoba3,
                        $numAnchoAlcoba3,
                        $numAreaAlcoba3,
                        '$txtAlcoba3',
                        $numLargoCocina,
                        $numAnchoCocina,
                        $numAreaCocina,
                        '$txtCocina',
                        $numLargoBano1,
                        $numAnchoBano1,
                        $numAreaBano1,
                        '$txtBano1',
                        $numLargoBano2,
                        $numAnchoBano2,
                        $numAreaBano2,
                        '$txtBano2',
                        $numLargoLavanderia,
                        $numAnchoLavanderia,
                        $numAreaLavanderia,
                        '$txtLavanderia',
                        $numLargoCirculaciones,
                        $numAnchoCirculaciones,
                        $numAreaCirculaciones,
                        '$txtCirculaciones',
                        $numLargoPatio,
                        $numAnchoPatio,
                        $numAreaPatio,
                        '$txtPatio',
                        $numAreaTotal,
                        '$txtEstadoCimentacion',
                        '$txtCimentacion',
                        '$txtEstadoPlacaEntrepiso',
                        '$txtPlacaEntrepiso',
                        '$txtEstadoMamposteria',
                        '$txtMamposteria',
                        '$txtEstadoCubierta',
                        '$txtCubierta',
                        '$txtEstadoVigas',
                        '$txtVigas',
                        '$txtEstadoColumnas',
                        '$txtColumnas',
                        '$txtEstadoPanetes',
                        '$txtPanetes',
                        '$txtEstadoEnchapes',
                        '$txtEnchapes',
                        '$txtEstadoAcabados',
                        '$txtAcabados',
                        '$txtEstadoHidraulicas',
                        '$txtHidraulicas',
                        '$txtEstadoElectricas',
                        '$txtElectricas',
                        '$txtEstadoSanitarias',
                        '$txtSanitarias',
                        '$txtEstadoGas',
                        '$txtGas',
                        '$txtEstadoMadera',
                        '$txtMadera',
                        '$txtEstadoMetalica',
                        '$txtMetalica',
                        $numLavadero,
                        '$txtLavadero',
                        $numLavaplatos,
                        '$txtLavaplatos',
                        $numLavamanos,
                        '$txtLavamanos',
                        $numSanitario,
                        '$txtSanitario',
                        $numDucha,
                        '$txtDucha',
                        '$txtEstadoVidrios',
                        '$txtVidrios',
                        '$txtEstadoPintura',
                        '$txtPintura',
                        '$txtOtros',
                        '$txtObservacionOtros',
                        $numContadorAgua,
                        '$txtEstadoConexionAgua',
                        '$txtDescripcionAgua',
                        $numContadorEnergia,
                        '$txtEstadoConexionEnergia',
                        '$txtDescripcionEnergia',
                        $numContadorAlcantarillado,
                        '$txtEstadoConexionAlcantarillado',
                        '$txtDescripcionAlcantarillado',
                        $numContadorGas,
                        '$txtEstadoConexionGas',
                        '$txtDescripcionGas',
                        $numContadorTelefono,
                        '$txtEstadoConexionTelefono',
                        '$txtDescripcionTelefono',
                        '$txtEstadoAndenes',
                        '$txtDescripcionAndenes',
                        '$txtEstadoVias',
                        '$txtDescripcionVias',
                        '$txtEstadoServiciosComunales',
                        '$txtDescripcionServiciosComunales',
                        '$txtDescripcionVivienda',
                        '$txtNormaNSR98',
                        '$txtRequisitos',
                        '$txtExistencia',
                        '$txtDescipcionNormaNSR98',
                        '$txtDescripcionRequisitos',
                        '$txtDescripcionExistencia',
                        '$fchVisita',
                        '$txtAprobo',
                        '$fchCreacion',
                        '$fchActualizacion'),";


    fputs($file, $valores);
    fputs($file, "\n");
}
Echo "Se ha terminado la generacion del archivo".$file;
?>