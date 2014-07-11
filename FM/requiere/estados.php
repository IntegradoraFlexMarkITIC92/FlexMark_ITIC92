<?php
function estadosList(){
	$matriz[0]='Aguascalientes';
	$matriz[1]='Baja California';
	$matriz[2]='Baja California Sur';
	$matriz[3]='Campeche';
	$matriz[4]='Chiapas';
	$matriz[5]='Chihuahua';
	$matriz[6]='Coahuila';
	$matriz[7]='Colima';
	$matriz[8]='Distrito Federal';
	$matriz[9]='Durango';
	$matriz[10]='Guanajuato';
	$matriz[11]='Guerrero';
	$matriz[12]='Hidalgo';
	$matriz[13]='Jalisco';
	$matriz[14]='Estado de México';
	$matriz[15]='Michoacán';
	$matriz[16]='Morelos';
	$matriz[17]='Nayarit';
	$matriz[18]='Nuevo León';
	$matriz[19]='Oaxaca';
	$matriz[20]='Puebla';
	$matriz[21]='Querétaro';
	$matriz[22]='Quintana Roo';
	$matriz[23]='San Luis Potosí';
	$matriz[24]='Sinaloa';
	$matriz[25]='Sonora';
	$matriz[26]='Tabasco';
	$matriz[27]='Tamaulipas';
	$matriz[28]='Tlaxcala';
	$matriz[29]='Veracruz';
	$matriz[30]='Yucatán';
	$matriz[31]='Zacatecas';
	
	echo('<select name="estadosList" id="pref-perpage" class="form-control">');
	echo('<option selected="selected" value="">Seleccione.. </option>');
	for ($i=0; $i< count($matriz); $i++){ 
		echo('
			<option value="'.$matriz[$i].'">'.$matriz[$i].'</option>
			');	
	}
	echo('</select>');
	echo('<br>');		

}

function estadosListUp($estado){
	$matriz[0]='Aguascalientes';
	$matriz[1]='Baja California';
	$matriz[2]='Baja California Sur';
	$matriz[3]='Campeche';
	$matriz[4]='Chiapas';
	$matriz[5]='Chihuahua';
	$matriz[6]='Coahuila';
	$matriz[7]='Colima';
	$matriz[8]='Distrito Federal';
	$matriz[9]='Durango';
	$matriz[10]='Guanajuato';
	$matriz[11]='Guerrero';
	$matriz[12]='Hidalgo';
	$matriz[13]='Jalisco';
	$matriz[14]='Estado de México';
	$matriz[15]='Michoacán';
	$matriz[16]='Morelos';
	$matriz[17]='Nayarit';
	$matriz[18]='Nuevo León';
	$matriz[19]='Oaxaca';
	$matriz[20]='Puebla';
	$matriz[21]='Querétaro';
	$matriz[22]='Quintana Roo';
	$matriz[23]='San Luis Potosí';
	$matriz[24]='Sinaloa';
	$matriz[25]='Sonora';
	$matriz[26]='Tabasco';
	$matriz[27]='Tamaulipas';
	$matriz[28]='Tlaxcala';
	$matriz[29]='Veracruz';
	$matriz[30]='Yucatán';
	$matriz[31]='Zacatecas';
	
	echo('<select name="estadosList" id="pref-perpage" class="form-control">');
	echo('<option value="">Seleccione </option>');	
	for ($i=0; $i< count($matriz); $i++){ 
		if($estado==$matriz[$i]){
			echo('<option selected="selected" value="'.$matriz[$i].'">'.$matriz[$i].'</option>');	
		}else{
			echo('<option value="'.$matriz[$i].'">'.$matriz[$i].'</option>');	
		}
	}
	echo('</select>');
	echo('<br>');		

}

?>