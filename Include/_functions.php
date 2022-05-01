<?php

	function mssql_escape_string($str){
		$search=array("\\","\0","\n","\r","\x1a","'",'"');
		$replace=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
		return str_replace($search,$replace,$str);
	}
	
	function showMessage($status, $str, $time = 0, $url = null){
		if($time != 0 && $url != null){
			echo '<meta http-equiv="refresh" content="'.$time.'; url='.$url.'" /><div class="s'.$status.'">'.$str.'</div>';
		}else{
			echo '<div class="s'.$status.'">'.$str.'</div>';
		}
	}
	
	function Exchange( $price ){
		If (getCountry() == 'AD' OR getCountry() == 'BE' OR getCountry() == 'DE' OR getCountry() == 'EE' OR getCountry() == 'FI' OR getCountry() == 'FR' OR getCountry() == 'GR' OR getCountry() == 'IE' OR getCountry() == 'IT' OR getCountry() == 'LU' OR getCountry() == 'MT' OR getCountry() == 'MC' OR getCountry() == 'ME' OR getCountry() == 'NL' OR getCountry() == 'AT' OR getCountry() == 'PT' OR getCountry() == 'SM' OR getCountry() == 'SK' OR getCountry() == 'SI' OR getCountry() == 'ES' OR getCountry() == 'CY') {
			$Dollarprice = '0.8956';
			$str = number_format($Dollarprice*$price, 2, ",", ".");
			return $str.'€';
		}else{
			return $price.'$';
		}
	}
	
	function Exchange0( $price ){
		If (getCountry() == 'AD' OR getCountry() == 'BE' OR getCountry() == 'DE' OR getCountry() == 'EE' OR getCountry() == 'FI' OR getCountry() == 'FR' OR getCountry() == 'GR' OR getCountry() == 'IE' OR getCountry() == 'IT' OR getCountry() == 'LU' OR getCountry() == 'MT' OR getCountry() == 'MC' OR getCountry() == 'ME' OR getCountry() == 'NL' OR getCountry() == 'AT' OR getCountry() == 'PT' OR getCountry() == 'SM' OR getCountry() == 'SK' OR getCountry() == 'SI' OR getCountry() == 'ES' OR getCountry() == 'CY') {
			$Dollarprice = '0.8956';
			$str = number_format($Dollarprice*$price, 2, ".", ".");
			return $str;
		}else{
			return $price;
		}
	}
	
	function ExchangeEUR( $price ){
			$Dollarprice = '0.8956';
			$str = number_format($Dollarprice*$price, 2, ".", ".");
			return $str;
	}
	
	function ExchangeUSD( $price ){
			$Dollarprice = '1.11657';
			$str = number_format($price*$Dollarprice, 2, ".", ".");
			return $str;
	}
	
	function ExchangeTUSD( $price ){
			$Dollarprice = '1.11657';
			$str = number_format($price*$Dollarprice, 2, ",", ".");
			return $str.'$';
	}
	
	function GETCUR(){
		If (getCountry() == 'AD' OR getCountry() == 'BE' OR getCountry() == 'DE' OR getCountry() == 'EE' OR getCountry() == 'FI' OR getCountry() == 'FR' OR getCountry() == 'GR' OR getCountry() == 'IE' OR getCountry() == 'IT' OR getCountry() == 'LU' OR getCountry() == 'MT' OR getCountry() == 'MC' OR getCountry() == 'ME' OR getCountry() == 'NL' OR getCountry() == 'AT' OR getCountry() == 'PT' OR getCountry() == 'SM' OR getCountry() == 'SK' OR getCountry() == 'SI' OR getCountry() == 'ES' OR getCountry() == 'CY') {
			return 'EUR';
		}else{
			return 'USD';
		}
	}
	
	function RandomToken( $length ){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$str = "";
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	 
	
	function getRemoteIP(){
		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
			$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
		}
		return $_SERVER['REMOTE_ADDR'];
	}
	
	function getCountry(){
		$Country = get_data('http://api.wipmania.com/'.getRemoteIP());
		return $Country;
	}
	
	function generateRandomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	function get_data($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	function minutesToTime($minutes) {
		$d = floor ($minutes / 1440);
		$h = floor (($minutes - $d * 1440) / 60);
		$m = $minutes - ($d * 1440) - ($h * 60);
		//
		// Then you can output it like so...
		//
		return "{$d} days, {$h} hours, {$m} minutes";
	}
	
	function date2timestamp($datum) {
        list($tag, $monat, $jahr) = explode(".", $datum);
        $jahr = sprintf("%04d", $jahr);
		$monat = sprintf("%02d", $monat);
        $tag = sprintf("%02d", $tag);
		return(mktime(0, 0, 0, $monat, $tag, $jahr));
    }    
	
	function GetThCountry($id) {
		if ($id == 0){
			return '';
		}
		elseif ($id == 1){
			return '';
		}
		elseif ($id == 2){
			return '';
		}
		elseif ($id == 3){
			return '';
		}
		elseif ($id == 4){
			return '';
		}
		elseif ($id == 5){
			return '';
		}
		elseif ($id == 6){
			return '';
		}
		elseif ($id == 7){
			return '';
		}
		elseif ($id == 8){
			return '';
		}
		elseif ($id == 9){
			return '';
		}
		elseif ($id == 10){
			return '';
		}
		elseif ($id == 11){
			return '';
		}
		elseif ($id == 12){
			return '';
		}
		elseif ($id == 13){
			return '';
		}
		elseif ($id == 14){
			return '';
		}
		elseif ($id == 15){
			return '';
		}
		elseif ($id == 16){
			return '';
		}
		elseif ($id == 17){
			return '';
		}
		elseif ($id == 18){
			return '';
		}
		elseif ($id == 19){
			return '';
		}
		elseif ($id == 20){
			return '';
		}
		elseif ($id == 21){
			return '';
		}
		elseif ($id == 22){
			return '';
		}
		elseif ($id == 23){
			return '';
		}
		elseif ($id == 24){
			return '';
		}
		elseif ($id == 25){
			return '';
		}
		elseif ($id == 26){
			return '';
		}
		elseif ($id == 27){
			return '';
		}
		elseif ($id == 28){
			return '';
		}
		elseif ($id == 29){
			return '';
		}
		elseif ($id == 30){
			return '';
		}
		elseif ($id == 31){
			return '';
		}
		elseif ($id == 32){
			return '';
		}
		elseif ($id == 33){
			return '';
		}
		elseif ($id == 34){
			return '';
		}
		elseif ($id == 35){
			return '';
		}
		elseif ($id == 36){
			return '';
		}
		elseif ($id == 37){
			return '';
		}
		elseif ($id == 38){
			return '';
		}
		elseif ($id == 39){
			return '';
		}
		elseif ($id == 40){
			return '';
		}
		elseif ($id == 41){
			return '';
		}
		elseif ($id == 42){
			return '';
		}
		elseif ($id == 43){
			return '';
		}
		elseif ($id == 44){
			return '';
		}
		elseif ($id == 45){
			return '';
		}
		elseif ($id == 46){
			return '';
		}
		elseif ($id == 47){
			return '';
		}
		elseif ($id == 48){
			return '';
		}
		elseif ($id == 49){
			return '';
		}
		elseif ($id == 50){
			return '';
		}
		elseif ($id == 51){
			return '';
		}
		elseif ($id == 52){
			return '';
		}
		elseif ($id == 53){
			return '';
		}
		elseif ($id == 54){
			return '';
		}
		elseif ($id == 55){
			return '';
		}
		elseif ($id == 56){
			return '';
		}
		elseif ($id == 57){
			return '';
		}
		elseif ($id == 58){
			return '';
		}
		elseif ($id == 59){
			return '';
		}
		elseif ($id == 60){
			return '';
		}
		elseif ($id == 61){
			return '';
		}
		elseif ($id == 62){
			return '';
		}
		elseif ($id == 63){
			return '';
		}
		elseif ($id == 64){
			return '';
		}
		elseif ($id == 65){
			return '';
		}
		elseif ($id == 66){
			return '';
		}
		elseif ($id == 67){
			return '';
		}
		elseif ($id == 68){
			return '';
		}
		elseif ($id == 69){
			return '';
		}
		elseif ($id == 70){
			return '';
		}
		elseif ($id == 71){
			return '';
		}
		elseif ($id == 72){
			return '';
		}
		elseif ($id == 73){
			return '';
		}
		elseif ($id == 74){
			return '';
		}
		elseif ($id == 75){
			return '';
		}
		elseIf ($id == 76){
			return 'Germany';
		}
		elseif ($id == 77){
			return '';
		}
		elseif ($id == 78){
			return '';
		}
		elseif ($id == 79){
			return '';
		}
		elseif ($id == 80){
			return '';
		}
		elseif ($id == 81){
			return '';
		}
		elseif ($id == 82){
			return '';
		}
		elseif ($id == 83){
			return '';
		}
		elseif ($id == 84){
			return '';
		}
		elseif ($id == 85){
			return '';
		}
		elseif ($id == 86){
			return '';
		}
		elseif ($id == 87){
			return '';
		}
		elseif ($id == 88){
			return '';
		}
		elseif ($id == 89){
			return '';
		}
		elseif ($id == 90){
			return '';
		}
		elseif ($id == 91){
			return '';
		}
		elseif ($id == 92){
			return '';
		}
		elseif ($id == 93){
			return '';
		}
		elseif ($id == 94){
			return '';
		}
		elseif ($id == 95){
			return '';
		}
		elseif ($id == 96){
			return '';
		}
		elseif ($id == 97){
			return '';
		}
		elseif ($id == 98){
			return '';
		}
		elseif ($id == 99){
			return '';
		}
		elseif ($id == 100){
			return '';
		}
		elseif ($id == 101){
			return '';
		}
		elseif ($id == 102){
			return '';
		}
		elseif ($id == 103){
			return '';
		}
		elseif ($id == 104){
			return '';
		}
		elseif ($id == 105){
			return '';
		}
		elseif ($id == 106){
			return '';
		}
		elseif ($id == 107){
			return '';
		}
		elseif ($id == 108){
			return '';
		}
		elseif ($id == 109){
			return '';
		}
		elseif ($id == 110){
			return '';
		}
		elseif ($id == 111){
			return '';
		}
		elseif ($id == 112){
			return '';
		}
		elseif ($id == 113){
			return '';
		}
		elseif ($id == 114){
			return '';
		}
		elseif ($id == 115){
			return '';
		}
		elseif ($id == 116){
			return '';
		}
		elseif ($id == 117){
			return '';
		}
		elseif ($id == 118){
			return '';
		}
		elseif ($id == 119){
			return '';
		}
		elseif ($id == 120){
			return '';
		}
		elseif ($id == 121){
			return '';
		}
		elseif ($id == 122){
			return '';
		}
		elseif ($id == 123){
			return '';
		}
		elseif ($id == 124){
			return '';
		}
		elseif ($id == 125){
			return '';
		}
		elseif ($id == 126){
			return '';
		}
		elseif ($id == 127){
			return '';
		}
		elseif ($id == 128){
			return '';
		}
		elseif ($id == 129){
			return '';
		}
		elseif ($id == 130){
			return '';
		}
		elseif ($id == 131){
			return '';
		}
		elseif ($id == 132){
			return '';
		}
		elseif ($id == 133){
			return '';
		}
		elseif ($id == 134){
			return '';
		}
		elseif ($id == 135){
			return '';
		}
		elseif ($id == 136){
			return '';
		}
		elseif ($id == 137){
			return '';
		}
		elseif ($id == 138){
			return '';
		}
		elseif ($id == 139){
			return '';
		}
		elseif ($id == 140){
			return '';
		}
		elseif ($id == 141){
			return '';
		}
		elseif ($id == 142){
			return '';
		}
		elseif ($id == 143){
			return '';
		}
		elseif ($id == 144){
			return '';
		}
		elseif ($id == 145){
			return '';
		}
		elseif ($id == 146){
			return '';
		}
		elseif ($id == 147){
			return '';
		}
		elseif ($id == 148){
			return '';
		}
		elseif ($id == 149){
			return '';
		}
		elseif ($id == 150){
			return '';
		}
		elseif ($id == 151){
			return '';
		}
		elseif ($id == 152){
			return '';
		}
		elseif ($id == 153){
			return '';
		}
		elseif ($id == 154){
			return '';
		}
		elseif ($id == 155){
			return '';
		}
		elseif ($id == 156){
			return '';
		}
		elseif ($id == 157){
			return '';
		}
		elseif ($id == 158){
			return '';
		}
		elseif ($id == 159){
			return '';
		}
		elseif ($id == 160){
			return '';
		}
		elseif ($id == 161){
			return '';
		}
		elseif ($id == 162){
			return '';
		}
		elseif ($id == 163){
			return '';
		}
		elseif ($id == 164){
			return '';
		}
		elseif ($id == 165){
			return '';
		}
		elseif ($id == 166){
			return '';
		}
		elseif ($id == 167){
			return '';
		}
		elseif ($id == 168){
			return '';
		}
		elseif ($id == 169){
			return '';
		}
		elseif ($id == 170){
			return '';
		}
		elseif ($id == 171){
			return '';
		}
		elseif ($id == 172){
			return '';
		}
		elseif ($id == 173){
			return '';
		}
		elseif ($id == 174){
			return '';
		}
		elseif ($id == 175){
			return '';
		}
		elseIf ($id == 176){
			return '';
		}
		elseif ($id == 177){
			return '';
		}
		elseif ($id == 178){
			return '';
		}
		elseif ($id == 179){
			return '';
		}
		elseif ($id == 180){
			return '';
		}
		elseif ($id == 181){
			return '';
		}
		elseif ($id == 182){
			return '';
		}
		elseif ($id == 183){
			return '';
		}
		elseif ($id == 184){
			return '';
		}
		elseif ($id == 185){
			return '';
		}
		elseif ($id == 186){
			return '';
		}
		elseif ($id == 187){
			return '';
		}
		elseif ($id == 188){
			return '';
		}
		elseif ($id == 189){
			return '';
		}
		elseif ($id == 190){
			return '';
		}
		elseif ($id == 191){
			return '';
		}
		elseif ($id == 192){
			return '';
		}
		elseif ($id == 193){
			return '';
		}
		elseif ($id == 194){
			return '';
		}
		elseif ($id == 195){
			return '';
		}
		elseif ($id == 196){
			return '';
		}
		elseif ($id == 197){
			return '';
		}
		elseif ($id == 198){
			return '';
		}
		elseif ($id == 199){
			return '';
		}
		elseif ($id == 200){
			return '';
		}
		elseif ($id == 201){
			return '';
		}
		elseif ($id == 202){
			return '';
		}
		elseif ($id == 203){
			return '';
		}
		elseif ($id == 204){
			return '';
		}
		elseif ($id == 205){
			return '';
		}
		elseif ($id == 206){
			return '';
		}
		elseif ($id == 207){
			return '';
		}
		elseif ($id == 208){
			return '';
		}
		elseif ($id == 209){
			return '';
		}
		elseif ($id == 210){
			return '';
		}
		elseif ($id == 211){
			return '';
		}
		elseif ($id == 212){
			return '';
		}
		elseif ($id == 213){
			return '';
		}
		elseif ($id == 214){
			return '';
		}
		elseif ($id == 215){
			return '';
		}
		elseif ($id == 216){
			return '';
		}
		elseif ($id == 217){
			return '';
		}
		elseif ($id == 218){
			return '';
		}
		elseif ($id == 219){
			return '';
		}
		elseif ($id == 220){
			return '';
		}
		elseif ($id == 221){
			return '';
		}
		elseif ($id == 222){
			return '';
		}
		elseif ($id == 223){
			return '';
		}
		elseif ($id == 224){
			return '';
		}
		elseif ($id == 225){
			return '';
		}
		elseif ($id == 226){
			return '';
		}
		elseif ($id == 227){
			return '';
		}
		elseif ($id == 228){
			return '';
		}
		elseif ($id == 229){
			return '';
		}
		elseif ($id == 230){
			return '';
		}
		elseif ($id == 231){
			return '';
		}
		elseif ($id == 232){
			return '';
		}
		elseif ($id == 233){
			return '';
		}
		elseif ($id == 234){
			return '';
		}
	}
			
?>