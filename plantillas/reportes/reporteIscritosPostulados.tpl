<table cellspacing="0" cellpadding="0" border="0" width="100%">

	<tr>
		<td>
		
			<div id="tabView" class="yui-navset" style="width:100%; text-align:left;">
			
				<ul class="yui-nav">
					<li class="selected"><a href="#tabReportes"><em>Tablas</em></a></li>
					<li><a href="#tabGrafica"><em>Graficas</em></a></li>
				</ul>
				
				<div class="yui-content">

					<!-- TABLAS -->
					<div id="tabReportes" style="height:412px; overflow:auto">
					
						<!-- FILTROS -->
						<table width="98%" cellspacing="0" cellpadding="2">
						
							<tr>
								<td colspan="2" style="border:1px dotted #999999; padding:2px;" id="busquedaAvanzada" valign="top">
									<table cellpadding="2" cellspacing="0" border="0" width="100%">
										<tr>
											<td style="width:14px; height:14px; cursor:pointer;" align="center">
											<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; text-align:center;" 
											 	 onClick="cuadroBusquedaAvanzada( 'busquedaAvanzada' );"
												 onMouseOver="this.style.backgroundColor='#ADD8E6';"
												 onMouseOut="this.style.backgroundColor='#F9F9F9';"
												 id="masbusquedaAvanzada"
											>+</div>
											</td>
											<td>
												<a href="#" onClick="cuadroBusquedaAvanzada( 'busquedaAvanzada' );" style="text-decoration: hidden;">Filtros</a>
											</td>
										</tr>
									</table>
									
									<div id="cuadrobusquedaAvanzada" style="display:none;">
										<form id="frmReporteInscritosPostulados">
										<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#E4E4E4">
											<tr>
												<td><b>Estado del Proceso</b></td>
												<td><b>Usuario / Punto Atencion</b></td>	
											</tr>
											<tr>
												<td>
													<input type="radio" name="filtroEstadoProceso" id="filtroEstadoProceso" value="inscritos"> Inscritos <br />
													<input type="radio" name="filtroEstadoProceso" id="filtroEstadoProceso" value="postulados"> Postulados 
												</td>
												<td>
													<input type="radio" name="filtroUsuarioPunto" id="filtroUsuarioPunto" value="usuario"> Usuario <br />
													<input type="radio" name="filtroUsuarioPunto" id="filtroUsuarioPunto" value="punto"> Punto
												</td>
											</tr>
											<tr>
											<td height="18px" colspan="2" align="left">
												<input type="button" 
													   value="Reporte"
													   onClick="generarReporteInscritosPostulados( );"
												/>
											</tr>
										</table> 
										</form>
									</div>
									
								</td>
							</tr>
							<tr>
								<td>
									<div id="divTablasReportesInscritos"></div>
								</td>
							</tr>
							
							
						</table>
						
					</div>
							
					<!-- GRAFICAS -->
					<div id="graReportes" style="height:412px; overflow:auto">
					</div>
			    
			    </div> 
			
			</div>
		
		</td>
	</tr>
	

</table>

<div id="activarTabView"></div>	