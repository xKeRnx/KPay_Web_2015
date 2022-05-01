<?php
$__TOKEN = "hardcodeshitbyKeRnPay"; require_once('../../Include/_init.php'); 
	$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD'], "CharacterSet" => "UTF-8"));
		if(!$conn){
			echo print_r(sqlsrv_errors(), true);
		}else{
			$checkProject = sqlsrv_query($conn, "SELECT * FROM tPurchases;", array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			If ($_GET['nSecret'] == 'JustForSofort'){
				echo '<h1>This is a test Site where you can see all Purchases [Just for testing!!!]</h1>';
				echo '<h1>sValidate:1 = Payment Complete!!!</h1>';
				while($fetchProject = sqlsrv_fetch_array($checkProject)){
					echo '<br>nUserID: '.$fetchProject['nUserID'].' <br> sAmount:'.$fetchProject['sAmount'].' <br> sDesc:'.$fetchProject['sDesc'].' <br> tToken:'.$fetchProject['tToken'].' <br> sValidate:'.$fetchProject['sValidate'].' <br> sStatus:'.$fetchProject['sStatus'].'<br>___________________________________<br>';
				}
			}
			}
?>