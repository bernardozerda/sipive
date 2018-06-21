<?php

    $arrLetras[] = "A";
	$arrLetras[] = "B";
	$arrLetras[] = "C";
	$arrLetras[] = "D";
	$arrLetras[] = "E";
	$arrLetras[] = "F";
	$arrLetras[] = "G";
	$arrLetras[] = "H";
	$arrLetras[] = "I";
	$arrLetras[] = "J";
	$arrLetras[] = "K";
	$arrLetras[] = "L";
	$arrLetras[] = "M";
	$arrLetras[] = "N";
	$arrLetras[] = "O";
	$arrLetras[] = "P";
	$arrLetras[] = "Q";
	$arrLetras[] = "R";
	$arrLetras[] = "S";
	$arrLetras[] = "T";
	$arrLetras[] = "U";
	$arrLetras[] = "V";
	$arrLetras[] = "W";
	$arrLetras[] = "X";
	$arrLetras[] = "Y";
	$arrLetras[] = "Z";

	$arrNomenclaturas[] = "CLL";
	$arrNomenclaturas[] = "KR";
	$arrNomenclaturas[] = "DG";
	$arrNomenclaturas[] = "TV";
	$arrNomenclaturas[] = "AC";
	$arrNomenclaturas[] = "AK";
	$arrNomenclaturas[] = "AVENIDA";
	$arrNomenclaturas[] = "AV";
	$arrNomenclaturas[] = "AB";
	$arrNomenclaturas[] = "CALLE";
	$arrNomenclaturas[] = "CL";
	$arrNomenclaturas[] = "CARRERA";
	$arrNomenclaturas[] = "KRR";
	$arrNomenclaturas[] = "CRR";
	$arrNomenclaturas[] = "CRA";
	$arrNomenclaturas[] = "K";
	$arrNomenclaturas[] = "DIAGONAL";
	$arrNomenclaturas[] = "DIG";
	$arrNomenclaturas[] = "DGO";
	$arrNomenclaturas[] = "TRANSVERSAL";
	$arrNomenclaturas[] = "TR";
	$arrNomenclaturas[] = "TRV";
	$arrNomenclaturas[] = "TRS";
	$arrNomenclaturas[] = "TVS";
	
	$arrNomenclaturasCorrectas[] = "---";
	$arrNomenclaturasCorrectas[] = "CL";
	$arrNomenclaturasCorrectas[] = "KR";
	$arrNomenclaturasCorrectas[] = "DG";
	$arrNomenclaturasCorrectas[] = "TV";
	$arrNomenclaturasCorrectas[] = "AC";
	$arrNomenclaturasCorrectas[] = "AK";

	$arrNomenclaturasAsociadas["CL"][] = "CLL";
	$arrNomenclaturasAsociadas["CL"][] = "CALLE";
	$arrNomenclaturasAsociadas["CL"][] = "CL";
	
	$arrNomenclaturasAsociadas["KR"][] = "KR";
	$arrNomenclaturasAsociadas["KR"][] = "CARRERA";
	$arrNomenclaturasAsociadas["KR"][] = "KRR";
	$arrNomenclaturasAsociadas["KR"][] = "CRR";
	$arrNomenclaturasAsociadas["KR"][] = "CRA";
	$arrNomenclaturasAsociadas["KR"][] = "K";
	
	$arrNomenclaturasAsociadas["DG"][] = "DG";
	$arrNomenclaturasAsociadas["DG"][] = "DIAGONAL";
	$arrNomenclaturasAsociadas["DG"][] = "DIG";
	$arrNomenclaturasAsociadas["DG"][] = "DGO";
	
	$arrNomenclaturasAsociadas["TV"][] = "TV";
	$arrNomenclaturasAsociadas["TV"][] = "TRANSVERSAL";
	$arrNomenclaturasAsociadas["TV"][] = "TR";
	$arrNomenclaturasAsociadas["TV"][] = "TRV";
	$arrNomenclaturasAsociadas["TV"][] = "TRS";
	$arrNomenclaturasAsociadas["TV"][] = "TVS";
	
	$arrNomenclaturasAsociadas["AC"][] = "AC";
	$arrNomenclaturasAsociadas["AC"][] = "AVENIDA";
	$arrNomenclaturasAsociadas["AC"][] = "AV";
	$arrNomenclaturasAsociadas["AC"][] = "AB";
	
	$arrNomenclaturasAsociadas["AK"][] = "AK";
	
	$arrNomenclaturasAsociadas["SUR"][] = "SUR";
	$arrNomenclaturasAsociadas["SUR"][] = "S";
	$arrNomenclaturasAsociadas["SUR"][] = "SU";
	
	$arrNomenclaturasAsociadas["ESTE"][] = "ESTE";
	$arrNomenclaturasAsociadas["ESTE"][] = "E";
	$arrNomenclaturasAsociadas["ESTE"][] = "ES";
	
	$arrNomenclaturasAsociadas["NUM"][] = "NUM";
	$arrNomenclaturasAsociadas["NUM"][] = "NUMERO";
	$arrNomenclaturasAsociadas["NUM"][] = "N";
	$arrNomenclaturasAsociadas["NUM"][] = "Nº";
	$arrNomenclaturasAsociadas["NUM"][] = "#";
	$arrNomenclaturasAsociadas["NUM"][] = "*";
	
	$txtDireccion = $_POST["txtDireccion"]; 
	
	$divDireccionGenerada = "divDireccionGenerada_". $_POST['txtExtraDiv'];

	$txtDireccion = utf8_decode( $txtDireccion );
	$txtDireccion = strtoupper( $txtDireccion );
	$txtDireccion = trim( $txtDireccion );
	$txtDireccion = mb_ereg_replace( "  +", " ", $txtDireccion);
	
	$arrDireccion =  explode( " ", $txtDireccion );
	$arrDireccionDefinitiva = array();
	
	$i = 0;
	$j = 0;
	if( isset( $arrDireccion[$i] ) && in_array( trim( $arrDireccion[$i] ), $arrNomenclaturas) ){
		
		foreach($arrNomenclaturasAsociadas as $txtNomenclatura => $arrAsociada ){
			if( in_array( $arrDireccion[$i], $arrAsociada ) ){
				break;
			}
		}
		$i++;
		$arrDireccionDefinitiva[$j] = $txtNomenclatura;
		$j++;
		
		$arrDireccionDefinitiva[$j] = ( is_numeric( $arrDireccion[$i] ) )?$arrDireccion[$i]:"";
		if( $arrDireccionDefinitiva[$j] != "" ){
			$i++;
		}
		$j++;
		
		$arrDireccionDefinitiva[$j] = ( in_array( $arrDireccion[$i], $arrLetras) )?$arrDireccion[$i]:"";
		if( $arrDireccionDefinitiva[$j] != "" ){
			$i++;
		}
		$j++;
		
		$arrDireccionDefinitiva[$j] = ( $arrDireccion[$i] == "BIS" )?$arrDireccion[$i]:"";
		if( $arrDireccionDefinitiva[$j] != "" ){
			$i++;
		}
		$j++;
		
		$arrDireccionDefinitiva[$j] = ( in_array( $arrDireccion[$i], $arrLetras) )?$arrDireccion[$i]:"";
		if( $arrDireccionDefinitiva[$j] != "" ){
			$i++;
		}
		$j++;
		
		if( in_array( $arrDireccion[$i], $arrNomenclaturasAsociadas["SUR"] ) ){
			$arrDireccionDefinitiva[$j] = "S";
			$j++;
			$i++;
		}else if( in_array( $arrDireccion[$i], $arrNomenclaturasAsociadas["ESTE"] ) ){
			$arrDireccionDefinitiva[$j] = "E";
			$j++;
			$i++;
		}else{
			$arrDireccionDefinitiva[$j] = "";
			$j++;
		}
		
		if( in_array( $arrDireccion[$i], $arrNomenclaturasAsociadas["NUM"] ) ){
			 $i++;
		}
		
		$arrDireccionDefinitiva[$j] = ( is_numeric( $arrDireccion[$i] ) )?$arrDireccion[$i]:"";
		if( $arrDireccionDefinitiva[$j] != "" ){
			$i++;
		}
		$j++;
		
		$arrDireccionDefinitiva[$j] = ( in_array( $arrDireccion[$i], $arrLetras) )?$arrDireccion[$i]:"";
		if( $arrDireccionDefinitiva[$j] != "" ){
			$i++;
		}
		$j++;
		
		$arrDireccionDefinitiva[$j] = ( is_numeric( $arrDireccion[$i] ) )?$arrDireccion[$i]:"";
		if( $arrDireccionDefinitiva[$j] != "" ){
			$i++;
		}
		$j++;
		
		if( in_array( $arrDireccion[$i], $arrNomenclaturasAsociadas["SUR"] ) ){
			$arrDireccionDefinitiva[$j] = "S";
			$j++;
			$i++;
		}else if( in_array( $arrDireccion[$i], $arrNomenclaturasAsociadas["ESTE"] ) ){
			$arrDireccionDefinitiva[$j] = "E";
			$j++;
			$i++;
		}else{
			$arrDireccionDefinitiva[$j] = "";
			$j++;
		}

		// Imprime el fragmento adicional completo de la direccion
		if ($arrDireccion[$i] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i] . " ";
		}
		if ($arrDireccion[$i+1] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+1] . " ";
		}
		if ($arrDireccion[$i+2] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+2] . " ";
		}
		if ($arrDireccion[$i+3] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+3] . " ";
		}
		if ($arrDireccion[$i+4] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+4] . " ";
		}
		if ($arrDireccion[$i+5] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+5] . " ";
		}
		if ($arrDireccion[$i+6] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+6] . " ";
		}
		if ($arrDireccion[$i+7] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+7] . " ";
		}
		if ($arrDireccion[$i+8] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+8] . " ";
		}
		if ($arrDireccion[$i+9] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+9] . " ";
		}
		if ($arrDireccion[$i+10] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+10] . " ";
		}
		if ($arrDireccion[$i+11] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+11] . " ";
		}
		if ($arrDireccion[$i+12] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+12] . " ";
		}
		if ($arrDireccion[$i+13] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+13] . " ";
		}
		if ($arrDireccion[$i+14] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+14] . " ";
		}
		if ($arrDireccion[$i+15] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+15] . " ";
		}
		if ($arrDireccion[$i+16] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+16] . " ";
		}
		if ($arrDireccion[$i+17] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+17] . " ";
		}
		if ($arrDireccion[$i+18] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+18] . " ";
		}
		if ($arrDireccion[$i+19] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+19] . " ";
		}
		if ($arrDireccion[$i+20] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+20] . " ";
		}
		if ($arrDireccion[$i+21] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+21] . " ";
		}
		if ($arrDireccion[$i+22] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+22] . " ";
		}
		if ($arrDireccion[$i+23] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+23] . " ";
		}
		if ($arrDireccion[$i+24] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+24] . " ";
		}
		if ($arrDireccion[$i+25] <> ''){
			$arrDireccionDefinitiva[$j] .= $arrDireccion[$i+15] . " ";
		}

	}
	$j = 0;

?>

<table border="0" cellspacing="0" cellpadding="5" width="800px" class="table">

    <!-- CABEVERA DE DIRECCION URBANA -->
    <tr>
        <td bgcolor='#dee4e4' colspan='11' height="40px;">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="30px">
                        <input type="radio"
                               onClick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>"); actualizaTipoDireccion(this);'
                               name="radTipoDireccion"
                               id="radTipoDireccion"
                               value="0"
                               <?php if( (! empty($arrDireccionDefinitiva)) or ( empty($arrDireccionDefinitiva) and trim($txtDireccion) ) == "" ){ ?> checked <?php } ?>
                        />
                    </td>
                    <td style="font-size: 14px;">
                        Dirección Ciudad, Ejemplo:
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- EJEMPLO DE DIRECCION URBANA -->
    <tr bgcolor='#dee4e4'>
        <td align="center">Dg</td>
        <td align="center">84</td>
        <td align="center">B</td>
        <td align="center">Bis</td>
        <td align="center">A</td>
        <td align="center">Sur</td>
        <td align="center">No. 8</td>
        <td align="center">B</td>
        <td align="center">62</td>
        <td align="center">Este</td>
        <td align="center">Apto. 101</td>
    </tr>

    <!-- CAMPOS PARA LA DIRECCION URBANA -->
    <tr>

        <!-- CAMPO DG -->
        <td width="60px" height="70px">
            <select id='txtDireccionTipoVia'
                    onchange='eventoCambioCalleDireccion();actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                    style="width: 100%"
            >
            <?php
                foreach($arrNomenclaturasCorrectas as $txtNomenclatura){
                    $txtSelected = ( $arrDireccionDefinitiva[$j] == $txtNomenclatura )?"selected":"";
                    echo "<option value='$txtNomenclatura' $txtSelected>$txtNomenclatura</option>";
                }
                $j++
            ?>
            </select>
        </td>

        <!-- CAMPO 84 -->
        <td width="60px">
            <input type='text'
                   id='txtNumeroVia'
                   style='width: 100%; height: 16px;'
                   onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                   value="<?php echo $arrDireccionDefinitiva[$j]; $j++; ?>"
                   maxlength='3'
            />
        </td>

        <!-- CAMPO B -->
        <td width="60px">
            <select id='txtLetraVia'
                    onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                    style='width: 100%'
            >
                <option selected='selected' value='' >--</option>
                <?php
                    foreach( $arrLetras as $txtLetra ){
                        $txtSelected = ( $arrDireccionDefinitiva[$j] == $txtLetra )?"selected":"";
                        echo "<option value='$txtLetra' $txtSelected>$txtLetra</option>";
                    }
                    $j++;
                ?>
            </select>
        </td>

        <!-- CAMPO BIS -->
        <td width="60px">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td width="20px;">
                        <?php $txtChecked = ( $arrDireccionDefinitiva[$j] == "BIS")?"checked":"";$j++; ?>
                        <input id='chkViaBis'
                               type='checkbox'
                               onclick='eventoActivarLetraBis( "chkViaBis", "txtLetraViaBis" ); actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                               <?php echo $txtChecked; ?>
                        />
                    </td>
                    <td align="center">
                        Bis
                    </td>
                </tr>
            </table>
        </td>

        <!-- CAMPO A -->
        <td width="60px">
            <select id='txtLetraViaBis'
                    style='width: 100%;'
                    onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                    <?php if($txtChecked != "checked"){ echo "disabled=''"; } ?>
            >
                <option selected='selected' value='' >--</option>
                <?php
                    foreach( $arrLetras as $txtLetra ){
                        $txtSelected = ( $arrDireccionDefinitiva[$j] == $txtLetra )?"selected":"";
                        echo "<option value='$txtLetra' $txtSelected>$txtLetra</option>";
                    }
                    $j++;
                ?>
            </select>
        </td>

        <!-- CAMPO SUR -->
        <td width="60px">
            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td width="20px">
                        <?php
                            $txtCheckDisable = "";
                            if(in_array($arrDireccionDefinitiva[0],array("CL","DG","AC"))){
                                $txtCheckDisable = "disabled";
                            }elseif( $arrDireccionDefinitiva[$j] == "E" ){
                                $txtCheckDisable = "checked";
                            }
                        ?>
                        <input type='checkbox'
                               <?php echo $txtCheckDisable; ?>
                               onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                               id='frmCheckEsteVia'
                        />
                    </td>
                    <td align="center">E</td>
                </tr>
                <tr>
                    <td>
                        <?php
                            $txtCheckDisable = "";
                            if(! in_array($arrDireccionDefinitiva[0],array("CL","DG","AC"))){
                                $txtCheckDisable = "disabled";
                            }elseif( $arrDireccionDefinitiva[$j] == "S" ){
                                $txtCheckDisable = "checked";
                            }
                            $j++;
                        ?>
                        <input type='checkbox' <?php echo $txtCheckDisable; ?> onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' id='frmCheckSurVia'/>
                    </td>
                    <td align="center">S</td>
                </tr>
            </table>
        </td>

        <!-- CAMPO NUMERO -->
        <td width="60px">
            <span id=''>#</span>&nbsp;
            <input type='text'
                   style='width: 70%; height: 16px;'
                   onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                   maxlength='3'
                   value="<?php echo $arrDireccionDefinitiva[$j]; $j++; ?>"
                   id='txtDireccionNumeroVia'
            />
        </td>

        <!-- CAMPO B -->
        <td width="60px">
            <select onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                    id='txtLetraNumero'
                    style="width: 100%"
            >
                <option selected='selected' value=''>--</option>
                <?php
                    foreach( $arrLetras as $txtLetra ){
                        $txtSelected = ( $arrDireccionDefinitiva[$j] == $txtLetra )?"selected":"";
                        echo "<option value='$txtLetra' $txtSelected>$txtLetra</option>";
                    }
                    $j++;
                ?>
            </select>
        </td>

        <!-- CAMPO 62 -->
        <td width="60px">
            -
            <input type='text'
                   style='width: 80%; height: 16px;'
                   onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                   maxlength='3'
                   value="<?php echo $arrDireccionDefinitiva[$j]; $j++; ?>"
                   id='txtNumeroAdicional'
            />
        </td>

        <!-- CAMPO ESTE -->
        <td width="60px">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td>
                        <?php
                            $txtCheckDisable = "";
                            if(! in_array($arrDireccionDefinitiva[0],array("CL","DG","AC"))){
                                $txtCheckDisable = "disabled";
                            }else if( $arrDireccionDefinitiva[$j] == "E" ){
                                $txtCheckDisable = "checked";
                            }
                        ?>
                        <input type='checkbox'
                               <?php echo $txtCheckDisable; ?>
                               onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                               id='frmCheckEsteNumero'
                        />
                    </td>
                    <td align="center">E</td>
                </tr>
                <tr>
                    <td>
                        <?php
                            $txtCheckDisable = "";
                            if(in_array($arrDireccionDefinitiva[0],array("CL","DG","AC"))){
                                $txtCheckDisable = "disabled";
                            }else if( $arrDireccionDefinitiva[$j] == "S" ){
                                $txtCheckDisable = "checked";
                            }
                            $j++;
                        ?>
                        <input type='checkbox'
                               <?php echo $txtCheckDisable; ?>
                               onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                               id='frmCheckSurNumero'
                        />
                    </td>
                    <td align="center">S</td>
                </tr>
            </table>
        </td>

        <!-- CAMPO APTO 101 -->
        <td>
            <?php $txtAdicional = ( !isset( $arrDireccionDefinitiva[$j] ) )?"":$arrDireccionDefinitiva[$j]; ?>
            <input type='text'
                   id='txtDireccionAdicional' 7
                   value='<?php echo $txtAdicional; ?>'
                   onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                   onblur="sinCaracteresEspeciales( this ); "
                   style='width:100%; height: 16px;'
            />
        </td>

    </tr>

    <!-- CABECERA DIRECCION RURAL -->
    <tr bgcolor='#dee4e4'>
        <td colspan='11'>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="30px">
                        <input type="radio"
                               name="radTipoDireccion"
                               onClick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>"); actualizaTipoDireccion(this)'
                               id="radTipoDireccionR"
                               value="1"
                               <?php if(empty($arrDireccionDefinitiva) and trim($txtDireccion) != ""){ ?> checked <?php } ?>
                        />
                    </td>
                    <td style="font-size: 14px;">
                        Dirección Rural
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- CAMPO DE DIRECCION RURAL -->
    <tr>
        <td colspan='11' height="70px" align="center">
            <input type='text'
                   id='txtDireccionRural'
                   value='<?php if(empty($arrDireccionDefinitiva)){ echo $txtDireccion; } ?>'
                   onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");'
                   onblur="sinCaracteresEspeciales( this );"
                   onfocus="document.getElementById('radTipoDireccionR').checked = true; actualizarDireccion('<?php echo $divDireccionGenerada; ?>');"
                   style='width:100%; height: 18px;'
            />
        </td>
    </tr>

    <!-- CAMPO PREVISUALIZACION DE DIRECCION -->
    <tr>
        <td colspan='11' bgcolor="#e4e4e4" height="40px">
            <div id="<?php echo $divDireccionGenerada; ?>"
                 style="width: 100%; padding-left: 10px; font-size: 14px; text-align: center;"
            ><?php echo $txtDireccion; ?></div>
        </td>
    </tr>

</table>