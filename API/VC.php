<?php
if($__TOKEN == "hardcodeshitbyKeRnPay"){
?>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane" id="PayPal">
		  <?php
		  if(isset($_POST['PayPalBuy'])){
			  // Virtual Currency PAYPAL
			$checkTHEPoints = sqlsrv_query($conn, "SELECT * FROM tPricePoint WHERE Price = ? AND ProjectID = ? AND nEnabled = 1;", array($_POST['PayPal'], $fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			$fetchTHEPoints = sqlsrv_fetch_array($checkTHEPoints);
			  			If ($fetchTHEPoints['DType'] == 0){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = ($fetchProject['CurrencyExRate']);
							$DTypeInfo1 = '';
						}elseif ($fetchTHEPoints['DType'] == 1){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1) + $fetchTHEPoints['DAmount']);
							$DTypeInfo1 = 'Bonus +'.$fetchTHEPoints['DAmount'].' '.$fetchProject['VirtualCurrencyName'].' - New Value:'.$GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchTHEPoints['DType'] == 2){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1) + (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1) *($fetchTHEPoints['DAmount']/100) ));
							$DTypeInfo1 = 'Bonus +'.$fetchTHEPoints['DAmount'].'% - New Value:'.$GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchTHEPoints['DType'] == 3){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = ($fetchProject['CurrencyExRate']);
							$DTypeInfo1 = 'Discount -'.$fetchPPoints['DAmount'].'% - Old Price: '.Exchange($GETTHENEWPRICE1 + ($fetchPPoints['DAmount']/100)).'';
						}else{
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = ($fetchProject['CurrencyExRate']);
							$DTypeInfo1 = '';
						}
			  
			  
			  
			  $GetCur = GETCUR();
			  $User = $uid;
			  $Dollar = Exchange0($_POST['PayPal']);
			  $Coins = $GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'].' for '.Exchange($_POST['PayPal']).'';
			  $Coins1 = $GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'].' for '.$_POST['PayPal'].'$';
			  $Ran = RandomToken(50);
			  $Random = MD5($Ran.$Coins.$Dollar.$User.$Ran);
			  $PLink = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=&item_name='.$Coins.'&custom='.$Random.'&amount='.$Dollar.'&currency_code='.$GetCur.'';
			  $InsertLogg = sqlsrv_query($conn, "Insert into tPurchases (nOwner, sProjectKey, nUserID, sAmount, sDesc, tToken, sStatus, sIP, nCountry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);", array($fetchProject['nUserID'], $key, $User,  $_POST['PayPal'], $Coins1, $Random, 'PayPal', getRemoteIP(), getCountry()), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				If ($InsertLogg){
					header('Location:'.$PLink.'');
					exit();
				}else{
					showMessage('error', 'Unknown Purchase Error!!! Please contact us for fixing that Problem.', 5, 'https://kernpay.com/');
				}			
			  
		  }
		  ?>
			<form id="PayPal" method="post">
			<table class="table table-striped">
				<tbody>
				<?php
				// Virtual Currency PAYPAL
					$PI = 1;
					$checkPPoints = sqlsrv_query($conn, "SELECT * FROM tPricePoint WHERE ProjectID = ? AND nEnabled = 1 ORDER BY cast (Price as float) ASC;", array($fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					while($fetchPPoints = sqlsrv_fetch_array($checkPPoints)){
						If ($fetchPPoints['sDefault'] == 1){
							$SCHECK = 'checked="checked"';
						}else{
							$SCHECK = '';
						}
						If ($fetchPPoints['dValue'] == 1){
							$BVCHECK = '<span class="label label-success">Most popular</span>';
						}elseif ($fetchPPoints['dValue'] == 2){
							$BVCHECK = '<span class="label label-warning">Best value</span>';
						}elseif ($fetchPPoints['dValue'] == 3){
							$BVCHECK = '<span class="label label-danger">Discount</span>';
						}else{
							$BVCHECK = '';
						}
						
						If ($fetchPPoints['DType'] == 0){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = ($fetchProject['CurrencyExRate']);
							$DTypeInfo = '';
						}elseif ($fetchPPoints['DType'] == 1){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE) + $fetchPPoints['DAmount']);
							$DTypeInfo = 'Bonus +'.$fetchPPoints['DAmount'].' '.$fetchProject['VirtualCurrencyName'].' - New Value:'.$GETTHENEWCURRENCY.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchPPoints['DType'] == 2){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE) + (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE) *($fetchPPoints['DAmount']/100) ));
							$DTypeInfo = 'Bonus +'.$fetchPPoints['DAmount'].'% - New Value:'.$GETTHENEWCURRENCY.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchPPoints['DType'] == 3){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = ($fetchProject['CurrencyExRate']);
							$DTypeInfo = 'Discount -'.$fetchPPoints['DAmount'].'% - Old Price: '.Exchange($GETTHENEWPRICE + ($fetchPPoints['DAmount']/100)).'';
						}else{
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = ($fetchProject['CurrencyExRate']);
							$DTypeInfo = '';
						}
						
						
						
						$GETPVALNEW = "'P".$PI."'";
						echo '<tr style="cursor: pointer;" onclick="Radcheck('.$GETPVALNEW.')">';
						echo '<th width="200px">';
						echo '<input type="Radio" name="PayPal" '.$SCHECK.' id="P'.$PI.'" value="'.$GETTHENEWPRICE.'"> <label for="P'.$PI.'">'.($fetchProject['CurrencyExRate']*$GETTHENEWPRICE).' '.$fetchProject['VirtualCurrencyName'].' for '. Exchange($GETTHENEWPRICE).'</label><br>';
						echo '</th>';
						echo '<th width="300px">';
						echo '<label for="P'.$PI.'">'.$DTypeInfo.'</label>';
						echo '</th>';
						echo '<th width="200px">';
						echo '<label for="P'.$PI.'">'.$BVCHECK.'</label>';
						echo '</th>';
						echo '</tr>';
						$PI = $PI + 1;
					}
				?>
				</tbody>
			</table>

				<button class="btn btn-lg" type="submit" name="PayPalBuy">Buy</button>
			</form>
			
			<script>
			function Radcheck(ID) {
				document.getElementById(ID).checked = true;
			}
			</script>
			
			
		   </div>
          <div role="tabpanel" class="tab-pane" id="PaySafe">
           PaySafeCard
		   </div>
          <div role="tabpanel" class="tab-pane" id="Sofort">
		  	<?php
			  if(isset($_POST['SofortBuy'])){
				  // Virtual Currency SOFORTBUY
				$checkTHEPoints = sqlsrv_query($conn, "SELECT * FROM tPricePoint WHERE Price = ? AND ProjectID = ? AND nEnabled = 1;", array($_POST['Sofort'], $fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				$fetchTHEPoints = sqlsrv_fetch_array($checkTHEPoints);
			  			If ($fetchTHEPoints['DType'] == 0){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = ($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1);
							$DTypeInfo1 = '';
						}elseif ($fetchTHEPoints['DType'] == 1){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1) + $fetchTHEPoints['DAmount']);
							$DTypeInfo1 = 'Bonus +'.$fetchTHEPoints['DAmount'].' '.$fetchProject['VirtualCurrencyName'].' - New Value:'.$GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchTHEPoints['DType'] == 2){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1) + (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1) *($fetchTHEPoints['DAmount']/100) ));
							$DTypeInfo1 = 'Bonus +'.$fetchTHEPoints['DAmount'].'% - New Value:'.$GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchTHEPoints['DType'] == 3){
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = ($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1);
							$DTypeInfo1 = 'Discount -'.$fetchPPoints['DAmount'].'% - Old Price: '.Exchange($GETTHENEWPRICE1 + ($fetchPPoints['DAmount']/100)).'';
						}else{
							$GETTHENEWPRICE1 = ($fetchTHEPoints['Price']);
							$GETTHENEWCURRENCY1 = ($fetchProject['CurrencyExRate']*$GETTHENEWPRICE1);
							$DTypeInfo1 = '';
						}
			  
			  
			  
				  $User = $uid;
				  $Dollar = ExchangeEUR($_POST['Sofort']);
				  $Coins = $GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'].' for '.Exchange($_POST['Sofort']).'';
				  $Coins1 = $GETTHENEWCURRENCY1.' '.$fetchProject['VirtualCurrencyName'].' for '.$_POST['Sofort'].'$';
				  $Ran = RandomToken(50);
				  $Random = MD5($Ran.$Coins.$Dollar.$User.$Ran);
				  $SLink = 'https://www.sofort.com/payment/start?amount='.$Dollar.'&currency_id=EUR&project_id=275989&user_id=129048&user_variable_0='.$Random.'&reason_1='.$User.'';
				  $InsertLogg = sqlsrv_query($conn, "Insert into tPurchases (nOwner, sProjectKey, nUserID, sAmount, sDesc, tToken, sStatus, sIP, nCountry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);", array($fetchProject['nUserID'], $key, $User,  $_POST['Sofort'], $Coins1, $Random, 'Sofort', getRemoteIP(), getCountry()), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					If ($InsertLogg){
						header('Location:'.$SLink.'');
						exit();
					}else{
						showMessage('error', 'Unknown Purchase Error!!! Please contact us for fixing that Problem.', 5, 'https://kernpay.com/');
					}			
				  
			  }
			?>
			<form id="Sofort" method="post">
			<table class="table table-striped">
				<tbody>
				<?php
				// Virtual Currency SOFORTBUY
					$SI = 1;
					$checkPPoints = sqlsrv_query($conn, "SELECT * FROM tPricePoint WHERE ProjectID = ? AND nEnabled = 1 ORDER BY cast (Price as float) ASC;", array($fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					while($fetchPPoints = sqlsrv_fetch_array($checkPPoints)){
						If ($fetchPPoints['sDefault'] == 1){
							$SCHECK = 'checked="checked"';
						}else{
							$SCHECK = '';
						}
						If ($fetchPPoints['dValue'] == 1){
							$BVCHECK = '<span class="label label-success">Most popular</span>';
						}elseif ($fetchPPoints['dValue'] == 2){
							$BVCHECK = '<span class="label label-warning">Best value</span>';
						}elseif ($fetchPPoints['dValue'] == 3){
							$BVCHECK = '<span class="label label-danger">Discount</span>';
						}else{
							$BVCHECK = '';
						}
						
						If ($fetchPPoints['DType'] == 0){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = ($fetchProject['CurrencyExRate']);
							$DTypeInfo = '';
						}elseif ($fetchPPoints['DType'] == 1){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE) + $fetchPPoints['DAmount']);
							$DTypeInfo = 'Bonus +'.$fetchPPoints['DAmount'].' '.$fetchProject['VirtualCurrencyName'].' - New Value:'.$GETTHENEWCURRENCY.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchPPoints['DType'] == 2){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE) + (($fetchProject['CurrencyExRate']*$GETTHENEWPRICE) *($fetchPPoints['DAmount']/100) ));
							$DTypeInfo = 'Bonus +'.$fetchPPoints['DAmount'].'% - New Value:'.$GETTHENEWCURRENCY.' '.$fetchProject['VirtualCurrencyName'];
						}elseif ($fetchPPoints['DType'] == 3){
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = ($fetchProject['CurrencyExRate']);
							$DTypeInfo = 'Discount -'.$fetchPPoints['DAmount'].'% - Old Price: '.Exchange($GETTHENEWPRICE + ($fetchPPoints['DAmount']/100)).'';
						}else{
							$GETTHENEWPRICE = ($fetchPPoints['Price']);
							$GETTHENEWCURRENCY = ($fetchProject['CurrencyExRate']);
							$DTypeInfo = '';
						}
						
						
						
						$GETPVALNEW = "'S".$SI."'";
						echo '<tr style="cursor: pointer;" onclick="Radcheck('.$GETPVALNEW.')">';
						echo '<th width="200px">';
						echo '<input type="Radio" name="Sofort" '.$SCHECK.' id="S'.$SI.'" value="'.$GETTHENEWPRICE.'"> <label for="S'.$SI.'">'.($fetchProject['CurrencyExRate']*$GETTHENEWPRICE).' '.$fetchProject['VirtualCurrencyName'].' for '. Exchange($GETTHENEWPRICE).'</label><br>';
						echo '</th>';
						echo '<th width="300px">';
						echo '<label for="S'.$SI.'">'.$DTypeInfo.'</label>';
						echo '</th>';
						echo '<th width="200px">';
						echo '<label for="S'.$SI.'">'.$BVCHECK.'</label>';
						echo '</th>';
						echo '</tr>';
						$SI = $SI + 1;
					}
				?>
				</tbody>
			</table>
				<button class="btn btn-lg" type="submit" name="SofortBuy">Buy</button>
			</form>
		   </div>
          <div role="tabpanel" class="tab-pane" id="MobilePay">
           MobilePay
		   </div>
        </div>
<?php
}
?>