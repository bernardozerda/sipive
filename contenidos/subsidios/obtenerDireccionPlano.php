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
	
	
	for( $i = ord( "A" ); $i <= ord( "Z" ); $i++  ){
		$arrLetras[] = chr( $i );
	}
	
//	pr($arrLetras);

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
//	$divDireccionGenerada = "divDireccionGenerada";
	
	$txtDireccion = utf8_decode( $txtDireccion );
	$txtDireccion = strtoupper( $txtDireccion );
	// $txtDireccion = ereg_replace( "\"", "", $txtDireccion );
	$txtDireccion = trim( $txtDireccion );
	$txtDireccion = ereg_replace( "  +", " ", $txtDireccion);
	
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
		//$arrDireccionDefinitiva[$j] = $arrDireccion[$i] . " " . $arrDireccion[$i+1] . " " . $arrDireccion[$i+2] . " " . $arrDireccion[$i+3] . " " . $arrDireccion[$i+4] . " " . $arrDireccion[$i+5] . " " . $arrDireccion[$i+6] . " " . $arrDireccion[$i+7] . " " . $arrDireccion[$i+8] . " " . $arrDireccion[$i+9] . " " . $arrDireccion[$i+10] . " " . $arrDireccion[$i+11] . " " . $arrDireccion[$i+12] . " " . $arrDireccion[$i+13] . " " . $arrDireccion[$i+14] . " " . $arrDireccion[$i+15] . " " . $arrDireccion[$i+16] . " " . $arrDireccion[$i+17] . " " . $arrDireccion[$i+18] . " " . $arrDireccion[$i+19] . " " . $arrDireccion[$i+20] . " " . $arrDireccion[$i+21] . " " . $arrDireccion[$i+22] . " " . $arrDireccion[$i+23];

		//$arrDireccionDefinitiva[$j] = isset( $arrDireccion[$i] )? $arrDireccion[$i]:"";
			
	}
	$j = 0;	
	
?>

<!-- <form method='post' onSubmit='return true' action=''> --> 
	<p><b>Digite la dirección</b></p>
	
	<table style='border-spacing: 0px; width:98%'>
		<tr>
			<td bgcolor='#dee4e4' colspan='11'>
				<input type="radio" onClick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>"); actualizaTipoDireccion(this)' name="radTipoDireccion" id="radTipoDireccion" checked value="0" /> 
				Dirección Ciudad, Ejemplo: 
			</td>
		</tr>
		<tr bgcolor='#dee4e4'>
			<td class='subitems'>Dg</td> 
			<td class='subitems'>84</td> 
			<td class='subitems'>B</td> 
			<td class='subitems'>Bis</td>
			<td class='subitems'>A</td> 
			<td class='subitems'>Sur</td> 
			<td class='subitems'>No. 8</td> 
			<td class='subitems'>B</td> 
			<td class='subitems'>62</td> 
			<td class='subitems'>Este</td>
			<td class='subitems'>Apto. 101</td>
		</tr>
		<tr height="15px" />
		<tr>
			<td>
				<select onchange='eventoCambioCalleDireccion();actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' size='1' class='cajas' id='txtDireccionTipoVia'>
					<?php
						foreach($arrNomenclaturasCorrectas as $txtNomenclatura){
							$txtSelected = ( $arrDireccionDefinitiva[$j] == $txtNomenclatura )?"selected":"";
							echo "<option value='$txtNomenclatura' $txtSelected />$txtNomenclatura";
						}
						$j++
					?>
				</select>
			</td>
			<td>
	
				<input type='text' style='width: 40px;' onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' value="<?php echo $arrDireccionDefinitiva[$j]; $j++; ?>" maxlength='3' class='cajas' id='txtNumeroVia' />				
			</td>
			<td>
				<select style='width: 50px;' onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' size='1' class='cajas' id='txtLetraVia'>	
					<option selected='selected' value='' />--
					<?php
						foreach( $arrLetras as $txtLetra ){
							$txtSelected = ( $arrDireccionDefinitiva[$j] == $txtLetra )?"selected":"";
							echo "<option value='$txtLetra' $txtSelected />$txtLetra";
						}
						$j++;
					?>
				</select>
			</td>
			<td>
				<table>
					<tr>
						<td>
						<?php $txtChecked = ( $arrDireccionDefinitiva[$j] == "BIS")?"checked":"";$j++; ?>
						<input type='checkbox' <?php echo $txtChecked; ?> onclick='eventoActivarLetraBis( "chkViaBis", "txtLetraViaBis" ); actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' id='chkViaBis'/>
						</td>
					</tr>
					<tr><td class='subitems' style='text-align: center;'>Bis</td></tr>
				</table>
			</td>
			<td>
				<select style='width: 50px;' onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' size='1' class='cajas <?php echo $checked; ?>' id='txtLetraViaBis' disabled=''>	
					<option selected='selected' value='' />--
					<?php
						foreach( $arrLetras as $txtLetra ){
							$txtSelected = ( $arrDireccionDefinitiva[$j] == $txtLetra )?"selected":"";
							echo "<option value='$txtLetra' $txtSelected />$txtLetra";
						}
						$j++;
					?>
				</select>
			</td>
			<td>
				<table>
					<tbody>
						<tr>
							<td>
								<?php
									$txtCheckDisable = "";
									if( !isset( $arrDireccionDefinitiva[$j] ) ){
										$txtCheckDisable = "disabled";										
									}else if( $arrDireccionDefinitiva[$j] == "E" ){
										$txtCheckDisable = "checked";
									}
									
								?>
								<input type='checkbox' <?php echo $txtCheckDisable; ?> onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' id='frmCheckEsteVia'/>
							</td>
						</tr>
						<tr><td class='subitems' style='text-align: center;'>E</td></tr>
						<tr>
							<td>
								<?php
									$txtCheckDisable = "";
									if( !isset( $arrDireccionDefinitiva[$j] ) ){
										$txtCheckDisable = "disabled";										
									}else if( $arrDireccionDefinitiva[$j] == "S" ){
										$txtCheckDisable = "checked";
									}
									
									$j++;
								?>
								<input type='checkbox' <?php echo $txtCheckDisable; ?> onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' id='frmCheckSurVia'/>
							</td>
						</tr>
						<tr><td class='subitems' style='text-align: center;'>S</td></tr>
					</tbody>
				</table>
			</td>
			<td class='subitems'>
				<span id=''>No</span><input type='text' style='width: 40px;' onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' maxlength='3' class='cajas' value="<?php echo $arrDireccionDefinitiva[$j]; $j++; ?>" id='txtDireccionNumeroVia'/>
			</td>
			<td>
				<select onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' size='1' class='cajas' id='txtLetraNumero'>	
					<option selected='selected' value='' />--
					<?php
						foreach( $arrLetras as $txtLetra ){
							$txtSelected = ( $arrDireccionDefinitiva[$j] == $txtLetra )?"selected":"";
							echo "<option value='$txtLetra' $txtSelected />$txtLetra";
						}
						$j++;
					?>
				</select>
			</td>		 			 
			<td> - <input type='text' style='width: 40px;' onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' maxlength='2' class='cajas' value="<?php echo $arrDireccionDefinitiva[$j]; $j++; ?>" id='txtNumeroAdicional'/>
			</td>
			<td>
				<table>
					<tr>
						<td>
							<?php
								$txtCheckDisable = "";
								if( !isset( $arrDireccionDefinitiva[$j] ) ){
									$txtCheckDisable = "disabled";										
								}else if( $arrDireccionDefinitiva[$j] == "E" ){
									$txtCheckDisable = "checked";
								}
								
							?>
							<input type='checkbox' <?php echo $txtCheckDisable; ?> onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' id='frmCheckEsteNumero'/>
						</td>
					</tr>
					<tr>
						<td class='subitems' style='text-align: center;'>E</td>
					</tr>
					<tr>
						<td>
							<?php
								$txtCheckDisable = "";
								if( !isset( $arrDireccionDefinitiva[$j] ) ){
									$txtCheckDisable = "disabled";										
								}else if( $arrDireccionDefinitiva[$j] == "S" ){
									$txtCheckDisable = "checked";
								}
								
								$j++;
							?>
							<input type='checkbox' <?php echo $txtCheckDisable; ?> onclick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' id='frmCheckSurNumero'/>
						</td>
					</tr>
					<tr>
						<td class='subitems' style='text-align: center;'>S</td>
					</tr>
				</table>
			</td>
			<td> 
				<?php
					$txtAdicional = ( !isset( $arrDireccionDefinitiva[$j] ) )?"":$arrDireccionDefinitiva[$j];
				?>
				<input type='text' id='txtDireccionAdicional' value='<?php echo $txtAdicional; ?>' onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' onblur="sinCaracteresEspeciales( this ); " style='width:100%' />
			</td>
		</tr>
		<tr height="15px" />
		<tr bgcolor='#dee4e4'>
			<td colspan='11'>
				<input type="radio" name="radTipoDireccion" onClick='actualizarDireccion("<?php echo $divDireccionGenerada; ?>"); actualizaTipoDireccion(this)' id="radTipoDireccion" value="1" /> 
				Dirección Rural</td>
		</tr>
		<tr>
			<td colspan='11' >
				<input type='text' id='txtDireccionRural' value='' onkeyup='actualizarDireccion("<?php echo $divDireccionGenerada; ?>");' onblur="sinCaracteresEspeciales( this );" style='width:100%' />
			</td>
		</tr>
		<tr height="30px" />
		<tr>
			<td  colspan='11'><div id="<?php echo $divDireccionGenerada; ?>" style="bgcolor:#dee4e4" ><?php echo $txtDireccion; ?></td>
		</tr>
	</table> 
<!-- </form> -->