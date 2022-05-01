<?php header('Content-Type: text/html; charset=UTF-8');
$__TOKEN = "hardcodeshitbyKeRnPay"; require_once('Include/_init.php'); 
if(isset($_SESSION['nUserID'])){
	$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD'], "CharacterSet" => "UTF-8"));
		if(!$conn){
			echo print_r(sqlsrv_errors(), true);
		}else{
				
				$checkMessagesCount = sqlsrv_query($conn, "SELECT COUNT(nPartnerID) FROM tMessage WHERE nPartnerID = ? AND sRead = 0 AND sEnabled = 1;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				$fetchMessagesCount = sqlsrv_fetch_array($checkMessagesCount);
				
				$checkAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE nUserID = ?;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				if(sqlsrv_num_rows($checkAccount) == 1){
					$fetchAccount = sqlsrv_fetch_array($checkAccount);
					$checkProfile = sqlsrv_query($conn, "SELECT * FROM tUserProfile WHERE nUserID = ?;", array($fetchAccount['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));				
					$fetchProfile = sqlsrv_fetch_array($checkProfile);
						

					$checkActivity = sqlsrv_query($conn, "SELECT * FROM tActivity WHERE nUserID = ? OR ShowAll = 1 ORDER BY dDate DESC;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					
					$Date24h = date('Y-m-d h:i', time()-(86400));
					$Check24h = sqlsrv_query($conn, "SELECT SUM(cast (sAmount as float)), COUNT(sAmount) FROM tPurchases WHERE nOwner = ? AND sValidate = 1 AND sEnabled = 1 AND dDate > = ?;", array($_SESSION['nUserID'], $Date24h), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					$Fetch24h = sqlsrv_fetch_array($Check24h);
					$Get24hCount = ($Fetch24h[1]*0.30);
					$Get24hSUM = ($Fetch24h[0]*0.9) - $Get24hCount;	
					
					$Date7D = date('Y-m-d h:i', time()-(604800));
					$Check7D = sqlsrv_query($conn, "SELECT SUM(cast (sAmount as float)), COUNT(sAmount) FROM tPurchases WHERE nOwner = ? AND sValidate = 1 AND sEnabled = 1 AND dDate > = ?;", array($_SESSION['nUserID'], $Date7D), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					$Fetch7D = sqlsrv_fetch_array($Check7D);
					$Get7DCount = ($Fetch7D[1]*0.30);
					$Get7DSUM = ($Fetch7D[0]*0.9) - $Get7DCount;
					
					$Date30D = date('Y-m-d h:i', time()-(2592000));
					$Check30D = sqlsrv_query($conn, "SELECT SUM(cast (sAmount as float)), COUNT(sAmount) FROM tPurchases WHERE nOwner = ? AND sValidate = 1 AND sEnabled = 1 AND dDate > = ?;", array($_SESSION['nUserID'], $Date30D), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					$Fetch30D = sqlsrv_fetch_array($Check30D);
					$Get30DCount = ($Fetch30D[1]*0.30);
					$Get30DSUM = ($Fetch30D[0]*0.9) - $Get30DCount;
						
					$DateDY = date('Y-m-d h:i', time()-(31536000));	
					$CheckDY = sqlsrv_query($conn, "SELECT SUM(cast (sAmount as float)), COUNT(sAmount) FROM tPurchases WHERE nOwner = ? AND sValidate = 1 AND sEnabled = 1 AND dDate > = ?;", array($_SESSION['nUserID'], $DateDY), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					$FetchDY = sqlsrv_fetch_array($CheckDY);
					$GetDYCount = ($FetchDY[1]*0.30);
					$GetDYSUM = ($FetchDY[0]*0.9) - $GetDYCount;
				}

		}			
	
?>
<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $__CONFIG['Name']; ?></title>

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Icon -->
  <link rel="icon" type="image/png" href="assets/images/icon.png">
  <!-- Google Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>


  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css" />

    <!-- New -->
  <link rel="stylesheet" type="text/css" href="../assets/youplay/css/youplay-new.css" />
  
  
  <!-- FontAwesome -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/fontawesome/css/font-awesome.min.css" />

  <!-- Magnific Popup -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/magnific-popup/magnific-popup.css" />
  <!-- youplay -->

  <link rel="stylesheet" type="text/css" href="../assets/youplay/css/youplay-light.min.css" />
  <!-- RTL (uncomment line before this to enable RTL support) -->
  <!-- <link rel="stylesheet" type="text/css" href="../assets/youplay/css/youplay-rtl.css" /> -->

  <!--[if lt IE 9]>
      <script src="assets/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>

  <!-- Preloader -->
  <div class="page-preloader preloader-wrapp">
    <img src="assets/images/logo.png" alt="">
    <div class="preloader"></div>
  </div>
  <!-- /Preloader -->

    <!-- Navbar -->
	 <?php include 'Include/Navbar.php'; ?>
  <!-- /Navbar -->

  <!-- Main Content -->
  <section class="content-wrap">

    <!-- Banner -->
		<?php include 'Include/Banner.php'; ?>
    <!-- /Banner -->

    <div class="container youplay-content">

      <div class="row">

        <div class="col-md-9">
		<h3><center> Hello <?php echo $fetchAccount['sDisplayName'];?> you have a Credit from <?php echo number_format($fetchAccount['nAmount'], 2, ".", ".");?>$  = <?php echo ExchangeEUR($fetchAccount['nAmount']);?>€</center></h3>
			<center>		
				<form id="PayOutForm" method="post">	
					<input type="number" step="0.01"  name="PriceOut"  Value="0.00">
					<select name="CurOut" id="CurOut">
					<option value="0"></option>
					<option value="1">USD</option>
					<option value="2">EUR</option>
					</select>
					<button type="submit" name="BtnPayOut" class="btn btn-default">PayOut</button>
						<?php
							if(isset($_POST['BtnPayOut'])){
								$PriceOut = mssql_escape_string($_POST['PriceOut']);
								$CurOut = mssql_escape_string($_POST['CurOut']);
								
								If ($PriceOut == 0 AND $CurOut == 0){
									echo '<br><div class="alert alert-warning" role="alert">
									<strong>Warning!</strong> Value and Currency forgotten?
									</div>';
								}elseif ($PriceOut == 0){
									echo '<br><div class="alert alert-warning" role="alert">
									<strong>Warning!</strong> Value forgotten?
									</div>';
								}elseif ($CurOut == 0){
									echo '<br><div class="alert alert-warning" role="alert">
									<strong>Warning!</strong> Currency forgotten?
									</div>';
								}elseif ($CurOut == 1 OR $CurOut == 2){
								If ($CurOut == 1){
									$PriceP = number_format($fetchAccount['nAmount'], 2, ".", ".");
									$PCUR = 'USD';
								}elseif($CurOut == 2){
									$PriceP = ExchangeEUR($fetchAccount['nAmount']);
									$PCUR = 'EUR';
								}else{
									echo '<br><div class="alert alert-warning" role="alert">
									<strong>Warning!</strong> Unknown Error.
									</div>';
								}
									If ($PriceP >= number_format($PriceOut, 2, ".", ".")){
										if($CurOut == 2){
											$NewValPrice = ExchangeUSD($PriceOut);
										}elseif($CurOut == 1){
											$NewValPrice = number_format($PriceOut, 2, ".", ".");
										}
										
										$updateAmount = sqlsrv_query($conn, "Update tAccounts SET nAmount = CAST(nAmount AS float)-? WHERE nUserID = ?;", array($NewValPrice, $fetchAccount['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
										If ($updateAmount){
											$InsertLogg = sqlsrv_query($conn, "Insert into tPayout (nUserID, sAmount, Currency) VALUES (?, ?, ?);", array($fetchAccount['nUserID'], $NewValPrice, $PCUR), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
											If ($InsertLogg){
												showMessage('SUC', '<div class="alert alert-success" role="alert">
												<strong>Well done!</strong> You successfully paid out '.number_format($PriceOut, 2, ".", ".").' '.$PCUR.'.
												</div>', 2, 'payout.php');
											}else{
												echo '<br><div class="alert alert-warning" role="alert">
												<strong>Warning!</strong> Unknown Payout Error. Please Contact our Support.
												</div>';
											}
										}else{
												$ChangeAmount = sqlsrv_query($conn, "Update tAccounts SET nAmount = CAST(nAmount AS float)+? WHERE nUserID = ?;", array($NewValPrice, $fetchAccount['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
												echo '<br><div class="alert alert-warning" role="alert">
												<strong>Warning!</strong> Unknown Payout Error. Please Contact our Support.
												</div>';
										}
										
										
									}else{
										echo '<br><div class="alert alert-warning" role="alert">
										<strong>Warning!</strong> You do not have '.number_format($PriceOut, 2, ".", ".").' '.$PCUR.'!!!
										</div>';
									}
								}else{
									echo '<br><div class="alert alert-warning" role="alert">
									<strong>Warning!</strong> Unknown Error.
									</div>';
								}
							}
						?>
				</form>
			</center>
			
			<br></br>
			
			<?php
			$checkPayout = sqlsrv_query($conn, "SELECT * FROM tPayout Where nUserID = ? ORDER BY dDate DESC;", array($fetchAccount['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			$iP = 1;
			?>
			
			
			<h3><center>Payout Log</center></h3>
			<center>
				<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>#</th>
					<th>Amount</th>
					<th>Currency</th>
					<th>Status</th>
					<th>Notice</th>
				  </tr>
				</thead>
				<tbody>
				<?php
				while($fetchPayout = sqlsrv_fetch_array($checkPayout)){
					If ($fetchPayout['sStatus'] == 0){
						$sStatus = 'Pending';
					}elseif ($fetchPayout['sStatus'] == 1){
						$sStatus = 'Paid';
					}elseif ($fetchPayout['sStatus'] == 2){
						$sStatus = 'Reversed';
					}else{
						$sStatus = 'Error';
					}
					echo '
					<tr>
					<th scope="row">'.$iP.'</th>
					<td>'.$fetchPayout['sAmount'].'</td>
					<td>'.$fetchPayout['Currency'].'</td>
					<td>'.$sStatus.'</td>
					<td>'.$fetchPayout['sNotice'].'</td>
					</tr>';
					$iP = $iP+1;} ?>
				</tbody>
			  </table>
			</center>
			
        </div>

        <!-- Advert Side -->
        <?php include 'Include/Advert.php'; ?>
        <!-- Advert Side -->

      </div>

    </div>

  </section>
  <!-- /Main Content -->
  
      <!-- Footer -->
	 <?php include 'Include/Footer.php'; ?>
    <!-- /Footer -->

  <!-- Search Block -->
  <div class="search-block">
    <a href="#!" class="search-toggle glyphicon glyphicon-remove"></a>
    <form action="search.html">
      <div class="youplay-input">
        <input type="text" name="search" placeholder="Search...">
      </div>
    </form>
  </div>
  <!-- /Search Block -->


  <!-- jQuery -->
  <script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>

  <!-- CSS Shapes Polyfill -->
  <script type="text/javascript" src="assets/plugins/css-shapes-polyfill/shapes-polyfill.min.js"></script>

  <!-- Hexagon Progress -->
  <script type="text/javascript" src="assets/plugins/jquery.hexagonprogress/jquery.hexagonprogress.min.js"></script>

  <!-- Bootstrap -->
  <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

  <!-- Skrollr -->
  <script type="text/javascript" src="assets/plugins/skrollr/skrollr.min.js"></script>

  <!-- Smooth Scroll -->
  <script type="text/javascript" src="assets/plugins/smoothscroll/smoothscroll.js"></script>

  <!-- Magnific Popup -->
  <script type="text/javascript" src="assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- youplay -->
  <script type="text/javascript" src="../assets/youplay/js/youplay.min.js"></script>
  <!-- init youplay -->
  <script>
    if(typeof youplay !== 'undefined') {
        youplay.init({
            smoothscroll: false,
        });
    }
  </script>

</body>

</html>
<?php
	}else{
		echo '<meta http-equiv="refresh" content="0; url=login.php" />';
	}				  
 ?>