
   <!-- TABLA DE INFORMACION PARA LA RESOLUCION DE ASIGNADOS -->
   {if intval( $arrPost.seqTipoActo ) == 0 || intval( $arrPost.seqTipoActo ) == 1}
      {assign var=objTipoActo value=$arrTipoActo.1}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td colspan="">
               {assign var="seqCaracteristica" value="17"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td colspan="">
               {assign var="seqCaracteristica" value="48"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
		 <!-- INICIO FILA 1 'CDP'  -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="9"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="23"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="40"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            
            <td>
               {assign var="seqCaracteristica" value="51"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="59"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="67"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="75"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="83"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            
            <td>
               {assign var="seqCaracteristica" value="100"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="108"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="116"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="124"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="132"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
		 </tr>
		 		 <!-- INICIO FILA 2 'Valor CDP'  -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="10"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="24"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="41"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="52"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="60"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="68"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="76"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="84"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="101"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="109"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="117"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="125"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="133"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
		 		 <!-- INICIO FILA 3 'Fecha CDP' -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="11"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="25"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="42"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>          
            <td>
               {assign var="seqCaracteristica" value="53"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="61"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="69"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="77"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="85"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            
             <td>
               {assign var="seqCaracteristica" value="102"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="110"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="118"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="126"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="134"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
		 		 <!-- INICIO FILA 4 'Vigencia CDP'  -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="12"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="26"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="43"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>            
            <td>
               {assign var="seqCaracteristica" value="54"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="62"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="70"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="78"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="86"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            
            <td>
               {assign var="seqCaracteristica" value="103"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="111"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="119"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="127"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="135"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
		 		 <!-- INICIO FILA 5 'RP' -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="13"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="27"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="44"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>           
            <td>
               {assign var="seqCaracteristica" value="55"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="63"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="71"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="79"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="87"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            
            <td>
               {assign var="seqCaracteristica" value="104"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="112"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="120"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="128"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="136"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
		 		 <!-- INICIO FILA 6 'Valor RP'  -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="14"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="28"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="45"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>          
            <td>
               {assign var="seqCaracteristica" value="56"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="64"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="72"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="80"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="88"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            
            <td>
               {assign var="seqCaracteristica" value="105"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="113"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="121"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="129"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="137"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
		 		 <!-- INICIO FILA 7 'Fecha RP'  -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="15"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="29"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="46"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>           
            <td>
               {assign var="seqCaracteristica" value="57"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="65"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="73"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="81"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="89"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            
            <td>
               {assign var="seqCaracteristica" value="106"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="114"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="122"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="130"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="138"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
		 		 <!-- INICIO FILA 8 'Vigencia RP'  -->
         <tr>
            <td>
               {assign var="seqCaracteristica" value="16"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="30"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="47"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>         
            <td>
               {assign var="seqCaracteristica" value="58"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="66"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="74"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="82"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="90"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="107"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="115"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="123"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="131"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			<td>
               {assign var="seqCaracteristica" value="139"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         
      </table>
   
   <!-- TABLA DE INFORMACION PARA LA RESOLUCION MODIFICATORIA -->
   {elseif intval( $arrPost.seqTipoActo ) == 2}
      {assign var=objTipoActo value=$arrTipoActo.2}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               {assign var="seqCaracteristica" value="4"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="7"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
      </table>
	  <div align="center"><a href="#" onClick="plantillaProyectoUnidadHabitacional()">Gu&iacute;a de proyectos y unidades habitacionales</a></div><br>
   
   <!-- TABLA DE INFORMACION PARA LA RESOLUCION DE INHABILITADOS -->
   {elseif intval( $arrPost.seqTipoActo ) == 3}
      <span class="msgOk">Este tipo de Acto administrativo no tiene informaci&oacute;n adicional</span>
      
   <!-- TABLA DE INFORMACION PARA LOS RECURSOS DE REPOSICION -->   
   {elseif intval( $arrPost.seqTipoActo ) == 4}
      {assign var=objTipoActo value=$arrTipoActo.4}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               {assign var="seqCaracteristica" value="5"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="6"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
      </table>
   
   <!-- TABLA DE INFORMACION PARA LOS NO ASIGNADOS -->   
   {elseif intval( $arrPost.seqTipoActo ) == 5}
      {assign var=objTipoActo value=$arrTipoActo.5}
      <span class="msgOk">Este tipo de Acto administrativo no tiene informaci&oacute;n adicional</span>
      
   <!-- TABLA DE INFORMACION PARA LOS RECURSOS DE RENUNCIA -->   
   {elseif intval( $arrPost.seqTipoActo ) == 6}
      {assign var=objTipoActo value=$arrTipoActo.6}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               {assign var="seqCaracteristica" value="18"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="19"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
      </table>   
   
   <!-- TABLA DE INFORMACION PARA LOS RECURSOS DE PERDIDA -->   
   {elseif intval( $arrPost.seqTipoActo ) == 9}
      {assign var=objTipoActo value=$arrTipoActo.9}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               {assign var="seqCaracteristica" value="49"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="50"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
      </table>
	  
	<!-- TABLA DE INFORMACION PARA LOS RECURSOS DE REVOCATORIA -->   
   {elseif intval( $arrPost.seqTipoActo ) == 10}
      {assign var=objTipoActo value=$arrTipoActo.10}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               {assign var="seqCaracteristica" value="91"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="92"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
      </table>
	<!-- TABLA DE INFORMACION PARA VIVIENDA GRATUITA -->   
   {elseif intval( $arrPost.seqTipoActo ) == 11}
      {assign var=objTipoActo value=$arrTipoActo.11}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               {assign var="seqCaracteristica" value="140"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="141"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
      </table>
   
   <!-- TABLA DE INFORMACION PARA LAS NOTIFICACIONES -->
   {elseif intval( $arrPost.seqTipoActo ) == 7}
      {assign var=objTipoActo value=$arrTipoActo.7}        
      <span class="msgOk">Este tipo de Acto administrativo no tiene informaci&oacute;n adicional</span>
   
   <!-- TABLA DE INFORMACION PARA LAS RESOLUCIONES DE INDEXACION -->   
   {elseif intval( $arrPost.seqTipoActo ) == 8}
      {assign var=objTipoActo value=$arrTipoActo.8}
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td colspan="2">
               {assign var="seqCaracteristica" value="38"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="32"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="35"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			
			<td>
               {assign var="seqCaracteristica" value="93"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="96"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="33"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="36"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			
			<td>
				{assign var="seqCaracteristica" value="94"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="97"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			
         </tr>
         <tr>
            <td>
               {assign var="seqCaracteristica" value="34"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="37"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			
			<td>
               {assign var="seqCaracteristica" value="95"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
            <td>
               {assign var="seqCaracteristica" value="98"}
               {assign var=arrCaracteristica value=$objTipoActo->arrCaracteristicas.$seqCaracteristica}
               {include file="actosAdministrativos/camposActos.tpl"}
            </td>
			
         </tr>
      </table>   
   {/if}
   
