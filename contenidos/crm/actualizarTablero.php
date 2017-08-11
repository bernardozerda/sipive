<?php

@set_time_limit(300);

chdir(dirname(__DIR__) . "/crm/");
include( "../../recursos/archivos/lecturaConfiguracion.php" );

function conecta() {
    global $arrConfiguracion;
    $conexion = mysql_connect($arrConfiguracion['baseDatos']['servidor'], $arrConfiguracion['baseDatos']['usuario'], $arrConfiguracion['baseDatos']['clave']);
    mysql_set_charset('utf8', $conexion);
    mysql_select_db($arrConfiguracion['baseDatos']['nombre'], $conexion);
    return $conexion;
}

actualizarTablero();

echo "Se ejecuto con Exito!!!";

//modificarDatosTablero();

function quitarTildes($cadena) {

    $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
    $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
    $texto = str_replace($no_permitidas, $permitidas, $cadena);
    return ($texto);
}

// En $arrEstado se vincula todos los nombres estados para mostrar por proyecto en el tablero de control
function variables($valor) {
    if ($valor == 1) {
        $arrEstado = array();
        //$arrEstado[15] = "Vinculado";
        $arrEstado[62] = "Revisión Documental";
        $arrEstado[17] = "Cargue Información Solución";
        $arrEstado[27] = "Captura datos Escrituracion";
        $arrEstado[22] = "Cargue Datos Escrituración";
        $arrEstado[23] = "Migración Estudios Técnicos";
        $arrEstado[25] = "Generación Certificado Habitabilidad";
        $arrEstado[26] = "Estudio de Titulos";
        $arrEstado[24] = "Cargue Datos Estudio Títulos";
        $arrEstado[31] = "Consolidación Documental";
        $arrEstado[29] = "Cierre Legalizado";

        return $arrEstado;
    } else if ($valor == 2) {
        $listEstados = "15,62,17,27,22,23,25,26,24,31,29,40";
        return $listEstados;
    } else {
        $arrEstadoCon = array();
        //$arrEstadoCon[15] = "";
        $arrEstadoCon[62] = "SELECT count(*) as cant, 
                            case WHEN (datediff(DATE(NOW()), fchRadicacion))between 0 and 4
                              THEN 'verde'
                              WHEN (datediff(DATE(NOW()), fchRadicacion)) between 5 and 6
                              THEN 'amarillo'
                              ELSE 'rojo' 
                            END
                            AS color
                               from t_pry_unidad_proyecto und
                               INNER JOIN t_frm_formulario frm USING (seqFormulario)
                               where und.seqProyecto = ** AND und.seqProyecto>0 and seqEstadoProceso = ¬¬
                               GROUP BY color";

        $arrEstadoCon[17] = "SELECT count(*) as cant, 
                            case WHEN (datediff(DATE(NOW()), fchInformacionSolucion))between 0 and 2
                            THEN 'verde'
                            WHEN (datediff(DATE(NOW()), fchInformacionSolucion)) between 3 and 3
                            THEN 'amarillo'
                            ELSE 'rojo' 
                            END
                            AS color
                             from t_pry_unidad_proyecto und
                             INNER JOIN t_frm_formulario frm USING (seqFormulario)
                             where  und.seqProyecto = **  AND und.seqProyecto>0 and seqEstadoProceso = ¬¬
                             GROUP BY color";

        $arrEstadoCon[27] = "SELECT count(*) as cant, 
                                case WHEN (datediff(DATE(NOW()), fchCreacionBusquedaOferta))between 0 and 7
                                THEN 'verde'
                                WHEN (datediff(DATE(NOW()), fchCreacionBusquedaOferta)) between 8 and 9
                                THEN 'amarillo'
                                ELSE 'rojo' 
                                END
                                AS color
                                 from t_pry_unidad_proyecto und
                                 INNER JOIN t_frm_formulario frm USING (seqFormulario)
                                 INNER JOIN t_des_desembolso des USING (seqFormulario)
                             where  und.seqProyecto = ** AND und.seqProyecto>0 and seqEstadoProceso = ¬¬
                             GROUP BY color";
        $arrEstadoCon[22] = "SELECT count(*) as cant, 
                                case WHEN (datediff(DATE(NOW()), fchCreacionEscrituracion)) between 0 and 1
                                THEN 'verde'
                                WHEN (datediff(DATE(NOW()), fchCreacionEscrituracion)) between 2 and 2
                                THEN 'amarillo'
                                ELSE 'rojo' 
                                END
                                AS color
                                 from t_pry_unidad_proyecto und
                                 INNER JOIN t_frm_formulario frm USING (seqFormulario)
                                 INNER JOIN t_des_desembolso des USING (seqFormulario)
                             where  und.seqProyecto = ** AND und.seqProyecto>0 and seqEstadoProceso = ¬¬
                             GROUP BY color";

        $arrEstadoCon[23] = "SELECT count(*) as cant, 
                                case WHEN (datediff(DATE(NOW()), fchCreacionEscrituracion)) between 0 and 2
                                THEN 'verde'
                                WHEN (datediff(DATE(NOW()), fchCreacionEscrituracion)) between 3 and 3
                                THEN 'amarillo'
                                ELSE 'rojo' 
                                END
                                AS color
                                 from t_pry_unidad_proyecto und
                                 INNER JOIN t_frm_formulario frm USING (seqFormulario)
                                 INNER JOIN t_des_escrituracion esc USING (seqFormulario)
                             where  und.seqProyecto = ** AND und.seqProyecto>0  and seqEstadoProceso = ¬¬
                             GROUP BY color";

        $arrEstadoCon[25] = "SELECT count(*) as cant, 
                        case WHEN (datediff(DATE(NOW()), tec.fchCreacion))between 0 and 2
                        THEN 'verde'
                        WHEN (datediff(DATE(NOW()), tec.fchCreacion)) between 3 and 3
                        THEN 'amarillo'
                        ELSE 'rojo' 
                        END
                        AS color
                         from t_pry_unidad_proyecto und
                         INNER JOIN t_frm_formulario frm USING (seqFormulario)
                         INNER JOIN t_des_desembolso des USING (seqFormulario)
                         INNER JOIN t_des_tecnico tec USING(seqDesembolso)
                          where  und.seqProyecto = **  AND und.seqProyecto>0 and seqEstadoProceso = ¬¬
                         GROUP BY color";

        $arrEstadoCon[26] = "SELECT count(*) as cant, 
                        case WHEN (datediff(DATE(NOW()), tec.fchActualizacion))between 0 and 7
                        THEN 'verde'
                        WHEN (datediff(DATE(NOW()), tec.fchActualizacion)) between 8 and 9
                        THEN 'amarillo'
                        ELSE 'rojo' 
                        END
                        AS color
                         from t_pry_unidad_proyecto und
                         INNER JOIN t_frm_formulario frm USING (seqFormulario)
                         INNER JOIN t_des_desembolso des USING (seqFormulario)
                         INNER JOIN t_des_tecnico tec USING(seqDesembolso)
                          where  und.seqProyecto = ** AND und.seqProyecto>0 and (seqEstadoProceso = ¬¬ or seqEstadoProceso=28)
                         GROUP BY color";

        $arrEstadoCon[24] = "SELECT count(*) as cant, 
                            case WHEN (datediff(DATE(NOW()), fchInformacionTitulos))between 0 and 2
                              THEN 'verde'
                              WHEN (datediff(DATE(NOW()), fchInformacionTitulos)) between 3 and 3
                              THEN 'amarillo'
                              ELSE 'rojo' 
                            END
                            AS color
                               from t_pry_unidad_proyecto und
                               INNER JOIN t_frm_formulario frm USING (seqFormulario)
                               where und.seqProyecto = ** AND und.seqProyecto>0 and seqEstadoProceso = ¬¬ 
                               GROUP BY color";
        $arrEstadoCon[31] = "SELECT count(*) as cant, 
                        case WHEN (datediff(DATE(NOW()), tit.fchCreacion))between 0 and 7
                        THEN 'verde'
                        WHEN (datediff(DATE(NOW()), tit.fchCreacion)) between 8 and 9
                        THEN 'amarillo'
                        ELSE 'rojo' 
                        END
                        AS color
                         from t_pry_unidad_proyecto und
                         INNER JOIN t_frm_formulario frm USING (seqFormulario)
                         INNER JOIN t_des_desembolso des USING (seqFormulario)
                         INNER JOIN t_des_estudio_titulos  tit USING(seqDesembolso)
                          where  und.seqProyecto = ** AND und.seqProyecto>0 and seqEstadoProceso = ¬¬ 
                         GROUP BY color";

        $arrEstadoCon[29] = "SELECT count(*) as cant, 
                        case WHEN (datediff(DATE(NOW()), tit.fchActualizacion))between 0 and 7
                        THEN 'verde'
                        WHEN (datediff(DATE(NOW()), tit.fchActualizacion)) between 8 and 9
                        THEN 'amarillo'
                        ELSE 'rojo' 
                        END
                        AS color
                         from t_pry_unidad_proyecto und
                         INNER JOIN t_frm_formulario frm USING (seqFormulario)
                         INNER JOIN t_des_desembolso des USING (seqFormulario)
                         INNER JOIN t_des_estudio_titulos  tit USING(seqDesembolso)
                          where  und.seqProyecto = **  AND und.seqProyecto>0 and seqEstadoProceso = ¬¬
                         GROUP BY color";
        return $arrEstadoCon;
    }
}

//En $listEstados se encuentra la lista de estados a listar en la consulta por proyecto
// La funcion actualizarTablero borra los datos de la tabla y los vuelve a crear actualizando lo datos 
// por cada estado particular al proyecto

function actualizarTablero() {
    $conexion = conecta();
    $sqlT = "truncate t_pry_tablero_control";
    $resultT = mysql_query($sqlT, $conexion) or die(mysql_error());
    //$arrEstadoCon = variables(0);
    $arrEstado = variables(1);
    $listEstados = variables(2);
    // $sql = "create table t_pry_tablero_control AS ";
    $sql = "INSERT INTO  t_pry_tablero_control";
    $sql .= " SELECT pry.seqProyecto, txtNombreProyecto,";
    $sqlUpdate = "ALTER TABLE t_pry_tablero_control";
    foreach ($arrEstado as $key => $value) {

        $value = str_replace(" ", "", $value);
        $value = quitarTildes($value);
        $sql .= "(SELECT DISTINCT (count(frm1.seqEstadoProceso))
                        FROM t_frm_formulario frm1
                        WHERE     frm1.seqProyecto = und.seqProyecto
                              AND frm1.seqEstadoProceso = " . $key . ") and
                        0 AS 'val" . $value . "',";
        $sql .= " 0  AS 'v" . $value . "', 0  AS 'a" . $value . "', 0  AS 'r" . $value . "',";
        $sqlUpdate .= " CHANGE v" . $value . " v" . $value . " INT,
                    CHANGE a" . $value . " a" . $value . " INT,
                    CHANGE r" . $value . " r" . $value . " INT,";
    }

    $sql .= " '' AS total FROM t_pry_unidad_proyecto und 
                INNER JOIN t_pry_proyecto pry using(seqProyecto) 
                INNER JOIN t_frm_formulario frm USING(seqFormulario) 
                WHERE und.seqFormulario is not null 
                and frm.seqEstadoProceso IN (" . $listEstados . ") AND und.bolActivo = 1
                #AND pry.seqTipoEsquema in (1,2,8,9) 
                and und.seqProyecto > 0 
                GROUP BY und.seqProyecto                
                ";
    $sqlUpdate = substr_replace($sqlUpdate, ';', -1, 1);
    //echo $sqlUpdate;
//    echo $sql . "<br>";
//    die();
    $result = mysql_query($sql, $conexion) or die(mysql_error());
    mysql_query($sqlUpdate, $conexion) or die(mysql_error());
    modificarDatosTablero();
}

function modificarDatosTablero() {
    $conexion = conecta();
    $arrEstadoCon = variables(0);
    //$arrEstadoCon."<br>"; 
    $arrEstado = variables(1);
    $sql = "SELECT * FROM t_pry_tablero_control";
    $query = mysql_query($sql, $conexion) or die(mysql_error());


    if (mysql_num_rows($query) > 0) {
        while ($row = mysql_fetch_array($query)) {
            //echo "<br>" . $row['seqProyecto'];
            foreach ($arrEstadoCon as $key => $value) {
                if ($value != "") {
                    $variable = $arrEstado[$key];
                    $variable = str_replace(" ", "", $variable);
                    $variable = quitarTildes($variable);
                    if ($row['seqProyecto'] != "") {
                        $value = str_replace("**", $row['seqProyecto'], $value);
                    } else {
                        $value = str_replace("und.seqProyecto = **  and", ' ', $value);
                    }

                    $value = str_replace("¬¬", $key, $value);

                  //  echo "<p>" . $value . "</p>";

                    $rs = mysql_query($value, $conexion) or die(mysql_error());
                    if (mysql_num_rows($rs) > 0) {
                        $total = 0;
                        while ($req = mysql_fetch_array($rs)) {
                            if ($req['color'] == 'amarillo') {
                                $sql = "UPDATE t_pry_tablero_control SET a" . $variable . " = " . $req['cant'] . " where seqProyecto = " . $row['seqProyecto'];
                                $total += $req['cant'];
                            } else if ($req['color'] == 'verde') {
                                $sql = "UPDATE t_pry_tablero_control SET v" . $variable . " = " . $req['cant'] . " where seqProyecto = " . $row['seqProyecto'];
                                $total += $req['cant'];
                            } else if ($req['color'] == 'rojo') {
                                $sql = "UPDATE t_pry_tablero_control SET r" . $variable . " = " . $req['cant'] . " where seqProyecto = " . $row['seqProyecto'];
                                $total += $req['cant'];
                            }
                            //echo "<br><br>****" . $sql;
                            mysql_query($sql, $conexion) or die(mysql_error());
                        }
                        $sql = "UPDATE t_pry_tablero_control SET val" . $variable . " = " . $total . " where seqProyecto = " . $row['seqProyecto'];

//                       if($variable == 'EstudiodeTitulos'){
//                           echo "<br>". $sql;
//                       }

                        mysql_query($sql, $conexion) or die(mysql_error());

                    }

                    //echo "<br>" . $sql;
                    //$sql = "UPDATE t_pry_tablero_control SET "
                }
            }
        }
    }
}
?>


