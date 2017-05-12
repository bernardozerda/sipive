<table align="center" border = "1">
    <tr>
        <td> <b>Nombre:</b>: <?php echo $_FILES["archivo"]["name"] ?></td>

        <td> <b>Tipo:</b>: <?php echo $_FILES["archivo"]["type"] ?></td>

        <td><b>Subida:</b>: <?php echo ($_FILES["archivo"]["error"]) ? "Incorrecta" : "Correcta" ?></td>

        <td> <b>Tamanio:</b>: <?php echo $_FILES["archivo"]["size"] ?> bytes</td>
    </tr>
</table>
<?php
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $nombreArchivo = $_FILES['archivo']['tmp_name'];
    $lineas = file($nombreArchivo);
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

    $file = fopen("query_insert.sql", "a") or die("Pro blemas");
    fputs($file, $consulta);
    fputs($file, "\n");

    foreach ($lineas as $linea_num => $linea) {
        $datos = explode("\t", $linea);

        $seqTecnicoUnidad = trim($datos [0]);
        $seqUnidadProyecto = trim($datos [0]);
        $numLargoMultiple = (trim($datos [5]) == '') ? 0 : str_replace(",", ".", trim($datos [5]));
        $numAnchoMultiple = (trim($datos [6]) == '') ? 0 : str_replace(",", ".", trim($datos [6]));
        $numAreaMultiple = (trim($datos [7]) == '') ? 0 : str_replace(",", ".", trim($datos [7]));
        $txtMultiple = trim($datos [8]);
        $numLargoAlcoba1 = (trim($datos [9]) == '') ? 0 : str_replace(",", ".", trim($datos [9]));
        $numAnchoAlcoba1 = (trim($datos [10]) == '') ? 0 : str_replace(",", ".", trim($datos [10]));
        $numAreaAlcoba1 = (trim($datos [11]) == '') ? 0 : str_replace(",", ".", trim($datos [11]));
        $txtAlcoba1 = trim($datos [12]);
        $numLargoAlcoba2 = (trim($datos [13]) == '') ? 0 : str_replace(",", ".", trim($datos [13]));
        $numAnchoAlcoba2 = (trim($datos [14]) == '') ? 0 : str_replace(",", ".", trim($datos [14]));
        $numAreaAlcoba2 = (trim($datos [15]) == '') ? 0 : str_replace(",", ".", trim($datos [15]));
        $txtAlcoba2 = trim($datos [16]);
        $numLargoAlcoba3 = (trim($datos [17]) == '') ? 0 : str_replace(",", ".", trim($datos [17]));
        $numAnchoAlcoba3 = (trim($datos [18]) == '') ? 0 : str_replace(",", ".", trim($datos [18]));
        $numAreaAlcoba3 = (trim($datos [19]) == '') ? 0 : str_replace(",", ".", trim($datos [19]));
        $txtAlcoba3 = trim($datos [20]);
        $numLargoCocina = (trim($datos [21]) == '') ? 0 : str_replace(",", ".", trim($datos [21]));
        $numAnchoCocina = (trim($datos [22]) == '') ? 0 : str_replace(",", ".", trim($datos [22]));
        $numAreaCocina = (trim($datos [23]) == '') ? 0 : str_replace(",", ".", trim($datos [23]));
        $txtCocina = trim($datos [24]);
        $numLargoBano1 = (trim($datos [25]) == '') ? 0 : str_replace(",", ".", trim($datos [25]));
        $numAnchoBano1 = (trim($datos [26]) == '') ? 0 : str_replace(",", ".", trim($datos [26]));
        $numAreaBano1 = (trim($datos [27]) == '') ? 0 : str_replace(",", ".", trim($datos [27]));
        $txtBano1 = trim($datos [28]);
        $numLargoBano2 = (trim($datos [29]) == '') ? 0 : str_replace(",", ".", trim($datos [29]));
        $numAnchoBano2 = (trim($datos [30]) == '') ? 0 : str_replace(",", ".", trim($datos [30]));
        $numAreaBano2 = (trim($datos [31]) == '') ? 0 : str_replace(",", ".", trim($datos [31]));
        $txtBano2 = trim($datos [32]);
        $numLargoLavanderia = (trim($datos [33]) == '') ? 0 : str_replace(",", ".", trim($datos [33]));
        $numAnchoLavanderia = (trim($datos [34]) == '') ? 0 : str_replace(",", ".", trim($datos [34]));
        $numAreaLavanderia = (trim($datos [35]) == '') ? 0 : str_replace(",", ".", trim($datos [35]));
        $txtLavanderia = trim($datos [36]);
        $numLargoCirculaciones = (trim($datos [37]) == '') ? 0 : str_replace(",", ".", trim($datos [37]));
        $numAnchoCirculaciones = (trim($datos [38]) == '') ? 0 : str_replace(",", ".", trim($datos [38]));
        $numAreaCirculaciones = (trim($datos [39]) == '') ? 0 : str_replace(",", ".", trim($datos [39]));
        $txtCirculaciones = trim($datos [40]);
        $numLargoPatio = (trim($datos [41]) == '') ? 0 : str_replace(",", ".", trim($datos [41]));
        $numAnchoPatio = (trim($datos [42]) == '') ? 0 : str_replace(",", ".", trim($datos [42]));
        $numAreaPatio = (trim($datos [43]) == '') ? 0 : str_replace(",", ".", trim($datos [43]));
        $txtPatio = trim($datos [44]);
        $numAreaTotal = (trim($datos [45]) == '') ? 0 : str_replace(",", ".", trim($datos [45]));
        $txtEstadoCimentacion = trim($datos [46]);
        $txtCimentacion = trim($datos [47]);
        $txtEstadoPlacaEntrepiso = trim($datos [48]);
        $txtPlacaEntrepiso = trim($datos [49]);
        $txtEstadoMamposteria = trim($datos [50]);
        $txtMamposteria = trim($datos [51]);
        $txtEstadoCubierta = trim($datos[52]);
        $txtCubierta = trim($datos [53]);
        $txtEstadoVigas = trim($datos [54]);
        $txtVigas = trim($datos [55]);
        $txtEstadoColumnas = trim($datos [56]);
        $txtColumnas = trim($datos [57]);
        $txtEstadoPanetes = trim($datos [58]);
        $txtPanetes = trim($datos [59]);
        $txtEstadoEnchapes = trim($datos [60]);
        $txtEnchapes = trim($datos [61]);
        $txtEstadoAcabados = trim($datos [62]);
        $txtAcabados = trim($datos [63]);
        $txtEstadoHidraulicas = trim($datos [64]);
        $txtHidraulicas = trim($datos [65]);
        $txtEstadoElectricas = trim($datos [66]);
        $txtElectricas = trim($datos [67]);
        $txtEstadoSanitarias = trim($datos [68]);
        $txtSanitarias = trim($datos [69]);
        $txtEstadoGas = trim($datos [70]);
        $txtGas = trim($datos [71]);
        $txtEstadoMadera = trim($datos [72]);
        $txtMadera = trim($datos [73]);
        $txtEstadoMetalica = trim($datos [74]);
        $txtMetalica = trim($datos [75]);
        $numLavadero = (trim($datos [76]) == '') ? 0 : str_replace(",", ".", trim($datos [76]));
        $txtLavadero = trim($datos [77]);
        $numLavaplatos = (trim($datos [78]) == '') ? 0 : str_replace(",", ".", trim($datos [78]));
        $txtLavaplatos = trim($datos [79]);
        $numLavamanos = (trim($datos [80]) == '') ? 0 : str_replace(",", ".", trim($datos [80]));
        $txtLavamanos = trim($datos [81]);
        $numSanitario = (trim($datos [82]) == '') ? 0 : str_replace(",", ".", trim($datos [82]));
        $txtSanitario = trim($datos [83]);
        $numDucha = (trim($datos [84]) == '') ? 0 : str_replace(",", ".", trim($datos [84]));
        $txtDucha = trim($datos [85]);
        $txtEstadoVidrios = trim($datos [86]);
        $txtVidrios = trim($datos [87]);
        $txtEstadoPintura = trim($datos [88]);
        $txtPintura = trim($datos [89]);
        $txtOtros = trim($datos [90]);
        $txtObservacionOtros = trim($datos [91]);
        $numContadorAgua = (trim($datos [92]) == '') ? 0 : str_replace(",", ".", trim($datos [92]));
        $txtEstadoConexionAgua = trim($datos [93]);
        $txtDescripcionAgua = trim($datos [94]);
        $numContadorEnergia = (trim($datos [95]) == '') ? 0 : str_replace(",", ".", trim($datos [95]));
        $txtEstadoConexionEnergia = trim($datos [96]);
        $txtDescripcionEnergia = trim($datos [97]);
        $numContadorAlcantarillado = (trim($datos [98]) == '') ? 0 : str_replace(",", ".", trim($datos [98]));
        $txtEstadoConexionAlcantarillado = trim($datos [99]);
        $txtDescripcionAlcantarillado = trim($datos [100]);
        $numContadorGas = (trim($datos [101]) == '') ? 0 : str_replace(",", ".", trim($datos [101]));
        $txtEstadoConexionGas = trim($datos [102]);
        $txtDescripcionGas = trim($datos [103]);
        $numContadorTelefono = (trim($datos [104]) == '') ? 0 : str_replace(",", ".", trim($datos [104]));
        $txtEstadoConexionTelefono = trim($datos [105]);
        $txtDescripcionTelefono = trim($datos [106]);
        $txtEstadoAndenes = trim($datos [107]);
        $txtDescripcionAndenes = trim($datos [108]);
        $txtEstadoVias = trim($datos [109]);
        $txtDescripcionVias = trim($datos [110]);
        $txtEstadoServiciosComunales = trim($datos [111]);
        $txtDescripcionServiciosComunales = trim($datos [112]);
        $txtDescripcionVivienda = trim($datos [113]);
        $txtNormaNSR98 = trim($datos [114]);
        $txtRequisitos = trim($datos [115]);
        $txtExistencia = trim($datos [116]);
        $txtDescipcionNormaNSR98 = trim($datos [117]);
        $txtDescripcionRequisitos = trim($datos [118]);
        $txtDescripcionExistencia = trim($datos [119]);
        $fchVisita = trim($datos [121]);
        $txtAprobo = trim($datos [122]);
        $fchCreacion = (trim($datos [123])) == '' ? 'now()' : trim($datos [123]);
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
                        '$txtEstadoServiciosComunales ',
                        ' $txtDescripcionServiciosComunales',
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
    Echo "Se ha terminado la generacion del archivo" . $file;
} else
    echo "Error de subida";
?>