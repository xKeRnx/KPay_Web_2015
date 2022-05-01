<?php
// 4 = ok || 3 = chargeback
$__TOKEN = "hardcodeshitbypuregames";
require_once('_init.php');
/**  
 *  Pingback Listener Script
 *  For Virtual Currency API
 *  Copyright (c) 2010-2013 Paymentwall Team
 */
 
/**  
 *  Define your application-specific options
 */
define('SECRET', ''); // secret key of your application
define('IP_WHITELIST_CHECK_ACTIVE', true);

define('CREDIT_TYPE_CHARGEBACK', 2);

/**  
 *  The IP addresses below are Paymentwall's
 *  servers. Make sure your pingback script
 *  accepts requests from these addresses ONLY.
 *
 */
$ipsWhitelist = array(
    '174.36.92.186',
    '174.36.96.66',
    '174.36.92.187',
    '174.36.92.192',
    '174.37.14.28',
	'91.121.145.41'
);

/**  
 *  Collect the GET parameters from the request URL
 */
$userId = isset($_GET['uid']) ? $_GET['uid'] : null;
$credits = isset($_GET['currency']) ? $_GET['currency'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$refId = isset($_GET['ref']) ? $_GET['ref'] : null;
$signature = isset($_GET['sig']) ? $_GET['sig'] : null;
$sign_version = isset($_GET['sign_version']) ? $_GET['sign_version'] : null;

$result = false;

/**  
 *  If there are any errors encountered, the script will list them
 *  in an array.
 */
$errors = array ();

if (!empty($userId) && !empty($credits) && isset($type) && !empty($refId) && !empty($signature)) {
    $signatureParams = array();
    
    /** 
     *  version 1 signature
     */
    if (empty($sign_version) || $sign_version <= 1) {
         $signatureParams = array(
            'uid' => $userId,
            'currency' => $credits,
            'type' => $type,
            'ref' => $refId
        );
    }
    /** 
     *  version 2+ signature
     */
    else {
        $signatureParams = array();
        foreach ($_GET as $param => $value) {    
            $signatureParams[$param] = $value;
        }
        unset($signatureParams['sig']);
    }
    
    /** 
     *  check if IP is in whitelist and if signature matches    
     */
    $signatureCalculated = calculatePingbackSignature($signatureParams, SECRET, $sign_version);
    
    /** 
     *  Run the security check -- if the request's origin is one
     *  of Paymentwall's servers, and if the signature matches
     *  the parameters.
     */
    if (!IP_WHITELIST_CHECK_ACTIVE || in_array(getRemoteIP(), $ipsWhitelist)) {
        if ($signature == $signatureCalculated) {
            $result = true;
            if ($type == CREDIT_TYPE_CHARGEBACK) {
				/** 
				*  Deduct credits from user. Note that currency amount
				*  sent for chargeback is negative, e.g. -5, so be
				*  careful about the sign Don't deduct negative
				*  number, otherwise user will gain credits instead
				*  of losing them
				*
				*/
				$conn = sqlsrv_connect($__CONFIG['SQLHost'], array('UID' => $__CONFIG['SQLUID'], 'PWD' => $__CONFIG['SQLPWD'], 'Database' => $__CONFIG['SQLDB']));
				if (!$conn){
					$result = false;
				}else{
					$nEMID = mssql_escape_string($userId);
					$coins = mssql_escape_string($credits);
					$refID = mssql_escape_string($refId);
					$checkAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE nEMID = ?;", array($nEMID), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
					if(sqlsrv_num_rows($checkAccount) == 1){
						$updateCoins = sqlsrv_query($conn, "UPDATE tAccounts SET nAGPoints = nAGPoints + ? WHERE nEMID = ?;", array($coins, $nEMID));
						$insertLog = sqlsrv_query($conn, "INSERT INTO tDonationHistory (nEMID, nCoins, nStatus, nRefID) VALUES (?, ?, 3, ?);", array($nEMID, $coins, $refID));
						if (!$updateCoins || !$insertLog){
							$errors['SQLDB'] = print_r(sqlsrv_errors(), true);
							$result = false;
						}
					}else{
						$errors['Account'] = 'Account not exists!';
						$result = false;
					}
				}
            } else {
                // Give credits to user
				$conn = sqlsrv_connect($__CONFIG['SQLHost'], array('UID' => $__CONFIG['SQLUID'], 'PWD' => $__CONFIG['SQLPWD'], 'Database' => $__CONFIG['SQLDB']));
				if (!$conn){
					$result = false;
				}else{
					$nEMID = mssql_escape_string($userId);
					$coins = mssql_escape_string($credits);
					$refID = mssql_escape_string($refId);
					$checkAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE nEMID = ?;", array($nEMID), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
					if(sqlsrv_num_rows($checkAccount) == 1){
						$updateCoins = sqlsrv_query($conn, "UPDATE tAccounts SET nAGPoints = nAGPoints + ? WHERE nEMID = ?;", array($coins, $nEMID));
						$insertLog = sqlsrv_query($conn, "INSERT INTO tDonationHistory (nEMID, nCoins, nStatus, nRefID) VALUES (?, ?, 4, ?);", array($nEMID, $coins, $refID));
						if (!$updateCoins || !$insertLog){
							$errors['SQLDB'] = print_r(sqlsrv_errors(), true);
							$result = false;
						}
					}else{
						$errors['Account'] = 'Account not exists!';
						$result = false;
					}
				}
            }
        } else {
            $errors['signature'] = 'Signature is not valid!';    
        }
    } else {
        $errors['whitelist'] = 'IP not in whitelist!';
    }
} else {
    $errors['params'] = 'Missing parameters!';
}

/**  
 *  Always make sure to echo OK so Paymentwall
 *  will know that the transaction is successful.
 */
if ($result) {
    echo 'OK';
} else {
    echo implode(' ', $errors);
}

// ----- FUNCTIONS ----

/**  
 *  Signature calculation function
 */
function calculatePingbackSignature($params, $secret, $version) {
    $str = '';
    if ($version == 2) {
        ksort($params);
    }
    foreach ($params as $k=>$v) {
        $str .= "$k=$v";
    }
    $str .= $secret;
    return md5($str);
}
?>