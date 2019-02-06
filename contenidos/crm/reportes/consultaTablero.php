<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function calculaFecha($modo, $valor, $fecha_inicio = false) {

    if ($fecha_inicio != false) {
        $fecha_base = strtotime($fecha_inicio);
    } else {
        $time = time();
        $fecha_actual = date("Y-m-d", $time);
        $fecha_base = strtotime($fecha_actual);
    }

    $calculo = strtotime("$valor $modo", "$fecha_base");

    return date("Y-m-d", $calculo);
}

function obtenerConsulta($seqEstado, $proyecto, $tipo) {
    $fch = "fchRadicacion";
    if ($seqEstado == 62) {
        $fec = date("y-m-d");
        $fch = "fchRadicacion";
        if ($tipo == 3) {
          
            $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . "))> 6 OR ".$fch." = '0000-00-00 00:00:00')";
        } else if ($tipo == 2) {

            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 5 and 6 ";
        } else if ($tipo == 1) {
            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 0 and 4 ";
        }
    } else if ($seqEstado == 17) {
        $fec = date("y-m-d");
        $fch = "fchInformacionSolucion";
        if ($tipo == 3) {
//      
            $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . "))> 3 OR ".$fch." = '0000-00-00 00:00:00')";
        } else if ($tipo == 2) {

            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 3 and 3 ";
        } else if ($tipo == 1) {

            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 0 and 2 ";
        }
    } else if ($seqEstado == 27 || $seqEstado == 22) {
        $fec = date("y-m-d");
        if ($seqEstado == 27) {
            $fch = "fchCreacionBusquedaOferta";
            if ($tipo == 3) {

                $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . "))> 9 OR ".$fch." = '0000-00-00 00:00:00')";
            } else if ($tipo == 2) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 8 and 9 ";
            } else if ($tipo == 1) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 0 and 7 ";
            }
        } else {
            $fch = "fchCreacionEscrituracion";
            if ($tipo == 3) {
                $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . ")) > 2 OR ".$fch." = '0000-00-00 00:00:00')";
            } else if ($tipo == 2) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 2 and 2 ";
            } else if ($tipo == 1) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 0 and 1 ";
            }
        }
    } else if ($seqEstado == 23) {
        $fec = date("y-m-d");
        $fch = "esc.fchCreacionEscrituracion";
        if ($tipo == 3) {
            $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . ")) > 3 OR ".$fch." = '0000-00-00 00:00:00')";
        } else if ($tipo == 2) {
            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 3 and 3 ";
        } else if ($tipo == 1) {
            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . ")) between 0 and 2 ";
        }
    } else if ($seqEstado == 25 || $seqEstado == 26) {
        $fec = date("y-m-d");
        if ($seqEstado == 25) {
            $fch = "tec.fchCreacion";
            if ($tipo == 3) {
                $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . "))> 3 OR ".$fch." = '0000-00-00 00:00:00')";
            } else if ($tipo == 2) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 3 and 3";
            } else if ($tipo == 1) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 0 and 2";
            }
        } else {
            $fch = " tec.fchActualizacion";
            if ($tipo == 3) {
                $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . "))> 9 OR ".$fch." = '0000-00-00 00:00:00')";
            } else if ($tipo == 2) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 8 and 9";
            } else if ($tipo == 1) {
                $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 0 and 7";
            }
        }
    } else if ($seqEstado == 24) {
        $fch = "fchInformacionTitulos";
        if ($tipo == 3) {
            $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . "))> 3 OR ".$fch." = '0000-00-00 00:00:00')";
        } else if ($tipo == 2) {
            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 3 and 3";
        } else if ($tipo == 1) {
            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 0 and 2 ";
        }
    } else if ($seqEstado == 31 || $seqEstado == 29) {
        $fch = " fchInformacionTitulos";
        if ($seqEstado == 31) {
            $fch = "tit.fchCreacion";
        } else {
            $fch = "tit.fchActualizacion";
        }
        if ($tipo == 3) {
            $fechaFin = "((workdaydiff(DATE(NOW()), " . $fch . "))> 9 OR ".$fch." = '0000-00-00 00:00:00')";
        } else if ($tipo == 2) {
            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 8 and 9 ";
        } else if ($tipo == 1) {
            $fechaFin = "(workdaydiff(DATE(NOW()), " . $fch . "))between 0 and 7 ";
        }
    }

    $sql = "SELECT pry.txtNombreProyecto, txtNombreUnidad, frm.seqFormulario, numDocumento, concat(txtNombre1, ' ', txtNombre1, ' ', txtApellido1, ' ', txtApellido2 ) AS postulante,
        txtEstadoProceso, fchRadicacion, " . $fch . "  
               from t_pry_unidad_proyecto und   
               INNER JOIN t_pry_proyecto pry ON(und.seqProyecto=pry.seqProyecto)
               INNER JOIN t_frm_formulario frm USING (seqFormulario)               
               INNER JOIN t_frm_hogar hog USING(seqFormulario)
               INNER JOIN t_ciu_ciudadano USING(seqCiudadano)";

    if ($seqEstado == 27 || $seqEstado == 22 || $seqEstado == 25 || $seqEstado == 26 || $seqEstado == 31 || $seqEstado == 29) {
        $sql .= " INNER JOIN t_des_desembolso des USING (seqFormulario)";
    }
    if ($seqEstado == 23) {
        $sql .= " INNER JOIN t_des_escrituracion esc USING (seqFormulario)";
    }
    if ($seqEstado == 25 || $seqEstado == 26) {
        $sql .= " INNER JOIN t_des_tecnico tec USING(seqDesembolso)";
    }
    if ($seqEstado == 31 || $seqEstado == 29) {
        $sql .= " INNER JOIN t_des_estudio_titulos  tit USING(seqDesembolso)";
    }
    $sql .= " INNER JOIN t_frm_estado_proceso USING(seqEstadoProceso)";
    if ($seqEstado != 26 && $seqEstado != 47) {
        $sql .= "where seqEstadoProceso = " . $seqEstado . " and seqParentesco = 1 ";
    } else if ($seqEstado == 26) {
        $sql .= " where seqParentesco = 1 AND (seqEstadoProceso = 28 or seqEstadoProceso = " . $seqEstado . ") ";
    } else if ($seqEstado == 47) {
        $sql .= " where seqEstadoProceso in (7, 47, 54, 16, 56) and seqParentesco = 1 and frm.bolCerrado = 1 ";
    }
    if(isset($fechaFin)){
        $sql .= " AND " . $fechaFin; 
    }
    
    if ($proyecto != "") {
        $sql .= " AND und.seqProyecto =" . $proyecto;
    }

//    echo $sql;
//    die();
    return $sql;
}
