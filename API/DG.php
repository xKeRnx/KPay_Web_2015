<?php
if($__TOKEN == "hardcodeshitbyKeRnPay"){
?>
<div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="PayPal">
		  <?php
		  if(isset($_POST['PayPalBuy'])){
			  // Digital Goods PAYPAL
			$checkTHEGoods = sqlsrv_query($conn, "SELECT * FROM tDigitalGoods WHERE NPrice = ? AND ProjectID = ? AND sEnabled = 1;", array($_POST['PayPal'], $fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			$fetchDGoods = sqlsrv_fetch_array($checkTHEGoods);
						$GETTHENEWPRICE = ($fetchDGoods['NPrice']);
						$GETTHEOLDPRICE = ($fetchDGoods['OPrice']);
						$GETTHELENGTH = ($fetchDGoods['Length']);
						$Productname = ($fetchDGoods['Productname']);
						
						If ($fetchDGoods['Period'] == 0){
							$GETTHEPERIOD = 'Month(s)';
						}elseif ($fetchDGoods['Period'] == 1){
							$GETTHEPERIOD = 'Week(s)';
						}elseif ($fetchDGoods['Period'] == 2){
							$GETTHEPERIOD = 'Year(s)';
						}elseif ($fetchDGoods['Period'] == 3){
							$GETTHEPERIOD = 'Day(s)';
						}
						
						If ($fetchDGoods['sDiscount'] == 1){
							$ShowDisc = 'Old Price: '.Exchange($GETTHEOLDPRICE);
						}else{
							$ShowDisc = '';
						}
			  
			  
			  $GetCur = GETCUR();
			  $User = $uid;
			  $Dollar = Exchange0($_POST['PayPal']);
			  $NEWGood = ''.$GETTHELENGTH.''.$GETTHEPERIOD.' '.$Productname.' for '.Exchange($GETTHENEWPRICE).'';
			  $NEWGood1 = ''.$GETTHELENGTH.''.$GETTHEPERIOD.' '.$Productname.' for '.($GETTHENEWPRICE).'$';
			  $Ran = RandomToken(50);
			  $Random = MD5($Ran.$NEWGood.$Dollar.$User.$Ran);
			  $PLink = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=&item_name='.$NEWGood.'&custom='.$Random.'&amount='.$Dollar.'&currency_code='.$GetCur.'';
			  $InsertLogg = sqlsrv_query($conn, "Insert into tPurchases (nOwner, sProjectKey, nUserID, sAmount, sDesc, tToken, sStatus, sIP, nCountry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);", array($fetchProject['nUserID'], $key, $User,  $_POST['PayPal'], $NEWGood1, $Random, 'PayPal', getRemoteIP(), getCountry()), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
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
					// Digital Goods PAYPAL
					$PI = 1;
					$checkDGoods = sqlsrv_query($conn, "SELECT * FROM tDigitalGoods WHERE ProjectID = ? AND sEnabled = 1 ORDER BY Length ASC;", array($fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					while($fetchDGoods = sqlsrv_fetch_array($checkDGoods)){
						If ($fetchDGoods['sDefault'] == 1){
							$SCHECK = 'checked="checked"';
						}else{
							$SCHECK = '';
						}
						If ($fetchDGoods['dValue'] == 1){
							$BVCHECK = '<span class="label label-success">Most popular</span>';
						}elseif ($fetchDGoods['dValue'] == 2){
							$BVCHECK = '<span class="label label-warning">Best value</span>';
						}elseif ($fetchDGoods['dValue'] == 3){
							$BVCHECK = '<span class="label label-danger">Discount</span>';
						}else{
							$BVCHECK = '';
						}
												
						$GETTHENEWPRICE = ($fetchDGoods['NPrice']);
						$GETTHEOLDPRICE = ($fetchDGoods['OPrice']);
						$GETTHELENGTH = ($fetchDGoods['Length']);
						$Productname = ($fetchDGoods['Productname']);
						
						If ($fetchDGoods['Period'] == 0){
							$GETTHEPERIOD = 'Month(s)';
						}elseif ($fetchDGoods['Period'] == 1){
							$GETTHEPERIOD = 'Week(s)';
						}elseif ($fetchDGoods['Period'] == 2){
							$GETTHEPERIOD = 'Year(s)';
						}elseif ($fetchDGoods['Period'] == 3){
							$GETTHEPERIOD = 'Day(s)';
						}
						
						If ($fetchDGoods['sDiscount'] == 1){
							$ShowDisc = 'Old Price: '.Exchange($GETTHEOLDPRICE);
						}else{
							$ShowDisc = '';
						}
						
						
						$GETPVALNEW = "'P".$PI."'";
						echo '<tr style="cursor: pointer;" onclick="Radcheck('.$GETPVALNEW.')">';
						echo '<th width="300px">';
						echo '<input type="Radio" name="PayPal" '.$SCHECK.' id="P'.$PI.'" value="'.$GETTHENEWPRICE.'">
						<label for="P'.$PI.'">'.$GETTHELENGTH.''.$GETTHEPERIOD.' '.$Productname.' for '.Exchange($GETTHENEWPRICE).'</label><br>';
						echo '</th>';
						echo '<th width="200px">';
						echo '<label for="P'.$PI.'">'.$ShowDisc.'</label>';
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
				  // Digital Goods SOFORTBUY
			$checkTHEGoods = sqlsrv_query($conn, "SELECT * FROM tDigitalGoods WHERE NPrice = ? AND ProjectID = ? AND sEnabled = 1;", array($_POST['Sofort'], $fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			$fetchDGoods = sqlsrv_fetch_array($checkTHEGoods);
						$GETTHENEWPRICE = ($fetchDGoods['NPrice']);
						$GETTHEOLDPRICE = ($fetchDGoods['OPrice']);
						$GETTHELENGTH = ($fetchDGoods['Length']);
						$Productname = ($fetchDGoods['Productname']);
						
						If ($fetchDGoods['Period'] == 0){
							$GETTHEPERIOD = 'Month(s)';
						}elseif ($fetchDGoods['Period'] == 1){
							$GETTHEPERIOD = 'Week(s)';
						}elseif ($fetchDGoods['Period'] == 2){
							$GETTHEPERIOD = 'Year(s)';
						}elseif ($fetchDGoods['Period'] == 3){
							$GETTHEPERIOD = 'Day(s)';
						}
						
						If ($fetchDGoods['sDiscount'] == 1){
							$ShowDisc = 'Old Price: '.Exchange($GETTHEOLDPRICE);
						}else{
							$ShowDisc = '';
						}
			  
			  
			  $GetCur = GETCUR();
			  $User = $uid;
			  $Dollar = Exchange0($_POST['Sofort']);
			  $NEWGood = ''.$GETTHELENGTH.''.$GETTHEPERIOD.' '.$Productname.' for '.Exchange($GETTHENEWPRICE).'';
			  $NEWGood1 = ''.$GETTHELENGTH.''.$GETTHEPERIOD.' '.$Productname.' for '.($GETTHENEWPRICE).'$';
			  $Ran = RandomToken(50);
			  $Random = MD5($Ran.$NEWGood.$Dollar.$User.$Ran);
				  $SLink = 'https://www.sofort.com/payment/start?amount='.$Dollar.'&currency_id=EUR&project_id=275989&user_id=129048&user_variable_0='.$Random.'&reason_1='.$User.'';
				  $InsertLogg = sqlsrv_query($conn, "Insert into tPurchases (nOwner, sProjectKey, nUserID, sAmount, sDesc, tToken, sStatus, sIP, nCountry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);", array($fetchProject['nUserID'], $key, $User,  $_POST['Sofort'], $NEWGood1, $Random, 'Sofort', getRemoteIP(), getCountry()), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
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
					// Digital Goods SOFORTBUY
					$SI = 1;
					$checkDGoods = sqlsrv_query($conn, "SELECT * FROM tDigitalGoods WHERE ProjectID = ? AND sEnabled = 1 ORDER BY Length ASC;", array($fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					while($fetchDGoods = sqlsrv_fetch_array($checkDGoods)){
						If ($fetchDGoods['sDefault'] == 1){
							$SCHECK = 'checked="checked"';
						}else{
							$SCHECK = '';
						}
						If ($fetchDGoods['dValue'] == 1){
							$BVCHECK = '<span class="label label-success">Most popular</span>';
						}elseif ($fetchDGoods['dValue'] == 2){
							$BVCHECK = '<span class="label label-warning">Best value</span>';
						}elseif ($fetchDGoods['dValue'] == 3){
							$BVCHECK = '<span class="label label-danger">Discount</span>';
						}else{
							$BVCHECK = '';
						}
												
						$GETTHENEWPRICE = ($fetchDGoods['NPrice']);
						$GETTHEOLDPRICE = ($fetchDGoods['OPrice']);
						$GETTHELENGTH = ($fetchDGoods['Length']);
						$Productname = ($fetchDGoods['Productname']);
						
						If ($fetchDGoods['Period'] == 0){
							$GETTHEPERIOD = 'Month(s)';
						}elseif ($fetchDGoods['Period'] == 1){
							$GETTHEPERIOD = 'Week(s)';
						}elseif ($fetchDGoods['Period'] == 2){
							$GETTHEPERIOD = 'Year(s)';
						}elseif ($fetchDGoods['Period'] == 3){
							$GETTHEPERIOD = 'Day(s)';
						}
						
						If ($fetchDGoods['sDiscount'] == 1){
							$ShowDisc = 'Old Price: '.Exchange($GETTHEOLDPRICE);
						}else{
							$ShowDisc = '';
						}
						
						
						$GETPVALNEW = "'S".$SI."'";
						echo '<tr style="cursor: pointer;" onclick="Radcheck('.$GETPVALNEW.')">';
						echo '<th width="300px">';
						echo '<input type="Radio" name="Sofort" '.$SCHECK.' id="S'.$SI.'" value="'.$GETTHENEWPRICE.'">
						<label for="S'.$SI.'">'.$GETTHELENGTH.''.$GETTHEPERIOD.' '.$Productname.' for '.Exchange($GETTHENEWPRICE).'</label><br>';
						echo '</th>';
						echo '<th width="200px">';
						echo '<label for="S'.$SI.'">'.$ShowDisc.'</label>';
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