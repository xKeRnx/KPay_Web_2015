<?php
$__TOKEN = "hardcodeshitbyKeRnPay"; require_once('../../Include/_init.php'); 
	$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD'], "CharacterSet" => "UTF-8"));
		if(!$conn){
			echo print_r(sqlsrv_errors(), true);
		}else{
				$Token = mssql_escape_string($_POST['custom']);
				$Status = mssql_escape_string($_POST['payment_status']);
			
				$checkPayment = sqlsrv_query($conn, "SELECT * FROM tPurchases WHERE tToken = ? AND sEnabled =  1 AND sValidate = 0;", array($Token), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				if(sqlsrv_num_rows($checkPayment) == 1){
					$fetchPayment = sqlsrv_fetch_array($checkPayment);
					
					$checkProject = sqlsrv_query($conn, "SELECT * FROM tProjects WHERE ProjectKey = ?;", array($fetchPayment['sProjectKey']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					if(sqlsrv_num_rows($checkProject) == 1){
						$fetchProject = sqlsrv_fetch_array($checkProject);
						$PBUrl = $fetchProject['PingbackURL'];
						$Amount = ($fetchProject['CurrencyExRate']*$fetchPayment['sAmount']);
						$UserID = $fetchPayment['nUserID'];
						$updatePayment = sqlsrv_query($conn, "Update tPurchases SET sValidate = 1 AND sStatus = ? WHERE tToken = ?;", array($Status, $Token), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							
						$checkAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE nUserID = ?;", array($fetchProject['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
						$fetchAccount = sqlsrv_fetch_array($checkAccount);
							
						$HUID = $fetchProject['nUserID'];
						$GetAmount = ($fetchPayment['sAmount']*$fetchAccount['sPercent']);
						$GetAmount = ($GetAmount-$fetchAccount['sValue']);
						$updateAmount = sqlsrv_query($conn, "Update tAccounts SET nAmount = ? WHERE nUserID = ?;", array($GetAmount, $HUID), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));	
							
							
						If ($Status == 'Completed'){
							//FINISH
						}
						
						$fp = fopen('Trans/'.$Token.'.txt', 'w'); 
						foreach($_POST as $key=>$value)
						{
							fputs($fp, $key." -> ".$value."\r\n"); 
						}
						fclose($fp); 
						
					}			
				}else{
					//Purchase doesn't exist.
				}
		}
?>