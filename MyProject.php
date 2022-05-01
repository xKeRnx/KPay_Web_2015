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
					
					$checkProject = sqlsrv_query($conn, "SELECT * FROM tProjects WHERE nUserID = ? AND sEnabled = 1;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					
					
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

      <div class="col-md-9">

        <h2 class="mt-0">My Projects</h2>

		
		
			<?php
				$Delete = null;
				$ID = null;
				$ADD = null;
				$Acc = null;
				$TP = null;
				
				if(isset($_GET['Delete'])){
					$Delete = mssql_escape_string($_GET['Delete']);
				}
				if(isset($_GET['ID'])){
					$ID = mssql_escape_string($_GET['ID']);
					
					$checkProject = sqlsrv_query($conn, "SELECT * FROM tProjects WHERE nUserID = ? AND ID = ? AND sEnabled = 1;", array($_SESSION['nUserID'], $ID), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					$fetchProject = sqlsrv_fetch_array($checkProject);
					if(sqlsrv_num_rows($checkProject) != 1){
						echo '<meta http-equiv="refresh" content="0; url=MyProject.php" />';
						exit;  
					}
				}
				if(isset($_GET['Add'])){
					$ADD = mssql_escape_string($_GET['Add']);
				}
				if(isset($_GET['Acc'])){
					$Acc = mssql_escape_string($_GET['Acc']);
				}
				if(isset($_GET['TP'])){
					$TP = mssql_escape_string($_GET['TP']);
				}
			
			
			
				
					if($Delete != null && $ID != null && $ADD == null && $TP == null){
						If ($Acc != null){
							$DeleteProject = sqlsrv_query($conn, "Update tProjects SET sEnabled = 0 WHERE nUserID = ? AND ID = ?;", array($_SESSION['nUserID'], $ID), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							
							$NewDelMessage =  $fetchProject['ProjectName'].' has been successfully deleted';
							$InsertLogg = sqlsrv_query($conn, "Insert into tActivity (nUserID, Icon, Img, Title, Message) VALUES (?, 'bg-warning', 'fa-bell', 'Notification', ?);", array($_SESSION['nUserID'],  $NewDelMessage), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							
							
							
							If ($DeleteProject){
								showMessage('success', $fetchProject['ProjectName'].' has been successfully deleted', 3, 'MyProject.php');
							}else{
								showMessage('error', 'Unknown Delete Error!!! Please contact us for fixing that Problem.', 5, 'MyProject.php');
							}
						}else{
						echo 'Are you sure that you want to Delete '. $fetchProject['ProjectName'];
						echo '<div class="btn-group pull-right m-15">
							<a href="?Delete=True&Acc=True&ID='.$fetchProject['ID'].'" class="btn btn-default btn-sm">Yes</a>
							<a href="MyProject.php" class="btn btn-default btn-sm">No</a>
							</div>';	
						}
					}else if($Delete == null && $ID != null && $ADD == null && $TP != null){				
						?>
						<form id="TestPingback" method="post">
						 <table class="table table-bordered">
							<tbody>
							  <tr>
							   <td style="width: 300px;">
								  <p>Pingback URL</p>
								</td>
								<td>
								<?php echo $fetchProject['PingbackURL'];?>
								</td>
							  </tr>
							  <tr>
							   <td style="width: 300px;">
								  <p>Secret</p>
								</td>
								<td>
								<?php echo $fetchProject['SecretKey'];?>
								</td>
							  </tr>
							  <tr>
							   <td style="width: 300px;">
								  <p>Platform User ID</p>
								</td>
								<td>
								 <input type="text" name="PlatformUserID" size="35" Value="">
								</td>
							  </tr>
							  <tr>
							   <td style="width: 300px;">
								  <p>Currency Amount</p>
								</td>
								<td>
								 <input type="text" name="CurrencyAmount" size="35" Value="">
								</td>
							  </tr>
							<tr>
								<td style="width: 300px;">
								  <p>Type</p>
								</td>
								<td>
								  <select name="Type">
								  <option value="0" selected="">0 - Regular payment/offer completion</option>
								  <option value="1">1 - Product/Virtual Currency is given by customer service</option>
								  <option value="2">2 - Chargeback by customer service</option>
								  </select>
								</td>
							</tr>
							  							  
							  <tr>
							   <td style="width: 300px;">
								  <p>Reference</p>
								</td>
								<td>
								 <input type="text" name="Reference" size="35" Value="">
								</td>
							  </tr>
							</tbody>
						</table>
						<button class="btn btn-default" type="submit" name="TestPingback">Test Pingback</button>
						<div class="btn-group pull-right m-15">
									<a href="?ID=<?php echo $ID;?>" class="btn btn-default btn-sm">Back</a>
						</div>
						</form>
						

						<?php
							
						if(isset($_POST['TestPingback'])){
							$PingbackURL = mssql_escape_string($fetchProject['PingbackURL']);
							$SecretKey = mssql_escape_string($fetchProject['SecretKey']);
							$PlatformUserID = mssql_escape_string($_POST['PlatformUserID']);
							$CurrencyAmount = mssql_escape_string($_POST['CurrencyAmount']);
							$Type = mssql_escape_string($_POST['Type']);
							$Reference = mssql_escape_string($_POST['Reference']);
							$IsTest = '1';
							$SignatureBase = 'uid='.$PlatformUserID.'curency='.$CurrencyAmount.'type='.$Type.'ref='.$Reference.'';
							$Signature = MD5('uid='.$PlatformUserID.'curency='.$CurrencyAmount.'type='.$Type.'ref='.$Reference.'');
							$ResUrl = $PingbackURL.'?uid='.$PlatformUserID.'&curency='.$CurrencyAmount.'&type='.$Type.'&ref='.$Reference.'&is_test='.$IsTest.'&sig='.$Signature;
							
							$arrContextOptions=array(
								"ssl"=>array(
									"verify_peer"=>false,
									"verify_peer_name"=>false,
								),
							);  

							$Response = file_get_contents($ResUrl, false, stream_context_create($arrContextOptions));

							echo '<br></br>';
							
							If ($Response == 'OK'){
								echo "<h2 class='success'>Pingback was successful</h2>";
							}else{
								echo "<h4 class='wrong'>Pingback wasn't successful. <br> Reason: Response body does not match the expected pattern: OK</h4><br>";
							}
							echo '<strong>Signature base string</strong> <br>'.$SignatureBase.'<br></br>';
							echo '<strong>Signature = MD5(Signature base string)</strong> <br>'.$Signature.'<br></br>';
							echo '<br>';
							echo '<strong>Request</strong> <br>';
							echo 'GET '.$ResUrl.' HTTP/1.1';
							echo '<br></br>';
							echo '<strong>Response</strong> <br>';
							If ($Response == ''){
								echo 'No Response';
							}else{
								echo $Response;
							}
							
						}




							
					}else if($Delete == null && $ID != null && $ADD == null && $TP == null){
						if(isset($_POST['UpdateProjectSettings'])){
							
						$ProjectName = mssql_escape_string($_POST['ProjectName']);
						$ProjectUrl = mssql_escape_string($_POST['ProjectUrl']);
						$VirtualCurrencyName = mssql_escape_string($_POST['VirtualCurrencyName']);
						$CurrencyExRate = mssql_escape_string($_POST['CurrencyExRate']);
						$PingbackURL = mssql_escape_string($_POST['PingbackURL']);
						$Notifyemail = mssql_escape_string($_POST['Notifyemail']);
						$API = mssql_escape_string($_POST['PrefAPISel']);
						
						$UpdateProject = sqlsrv_query($conn, "Update tProjects SET ProjectName = ?, ProjectUrl = ?, VirtualCurrencyName = ?, CurrencyExRate = ?, PingbackURL = ?, Notifyemail = ?, API = ? WHERE nUserID = ? AND ID = ?;", array($ProjectName, $ProjectUrl, $VirtualCurrencyName, $CurrencyExRate, $PingbackURL, $Notifyemail, $API, $_SESSION['nUserID'], $ID), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
						$NewUpdateMessage =  $fetchProject['ProjectName'].' has been successfully Updated';
						$InsertLogg = sqlsrv_query($conn, "Insert into tActivity (nUserID, Icon, Img, Title, Message) VALUES (?, 'bg-warning', 'fa-bell', 'Notification', ?);", array($_SESSION['nUserID'],  $NewUpdateMessage), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							
							If ($UpdateProject){
								showMessage('success', $ProjectName.' has been successfully Updated', 3, 'MyProject.php');
							 }else{
								showMessage('error', 'Unknown Update Error!!! Please contact us for fixing that Problem.', 5, 'MyProject.php');
							}
						
						
						}else{
						?>
						<form id="Update" method="post">
						 <table class="table table-bordered">
							<tbody>
							  <tr>
							   <td style="width: 300px;">
								  <p>Project Name</p>
								</td>
								<td>
								 <input type="text" name="ProjectName" size="35" Value="<?php echo $fetchProject['ProjectName'];?>">
								</td>
							  </tr>
							  <tr>
							   <td style="width: 300px;">
								  <p>Project Key</p>
								</td>
								<td>
								 <input type="text" name="ProjectKey" size="35" readonly Value="<?php echo $fetchProject['ProjectKey'];?>">
								</td>
							  </tr>
							  <tr>
							   <td style="width: 300px;">
								  <p>Secret Key</p>
								</td>
								<td>
								 <input type="text" name="SecretKey" size="35" readonly Value="<?php echo $fetchProject['SecretKey'];?>">
								</td>
							  </tr>
							  	<tr>
							   <td style="width: 300px;">
								  <p>Project Url</p>
								</td>
								<td>
								 <input type="text" name="ProjectUrl" size="35" Value="<?php echo $fetchProject['ProjectURL'];?>">
								</td>
							  </tr>
							  	<tr>
								<td style="width: 300px;">
								<p>Your API</p>
								</td>
								<td>
								<select name="PrefAPISel" id="PrefAPISel" onchange="showPrefAPISel(this)" >
								<option value="1" <?php If ($fetchProject['API'] ==1){echo 'Selected';}?>>Virtual Currency</option>
								<option value="2" <?php If ($fetchProject['API'] ==2){echo 'Selected';}?>>Digital Goods</option>
								<option value="3" <?php If ($fetchProject['API'] ==3){echo 'Selected';}?>>Cart</option>
								</select>
								</td>
							  </tr>
							  </tbody>
							   </table>
							   
								<div id="API_div" style="display: none;">
								<table class="table table-bordered">
								<tbody>
								<tr>
								<td style="width: 300px;">
								  <p>Virtual Currency Name</p>
								</td>
								<td>
								 <input type="text" name="VirtualCurrencyName" size="35" Value="<?php echo $fetchProject['VirtualCurrencyName'];?>">
								</td>
								</tr>
							  	<tr>
								<td style="width: 300px;">
								  <p>Currency Exchange Rate</p>
								</td>
								<td>
								1$ = <input name="CurrencyExRate" value="<?php echo $fetchProject['CurrencyExRate'];?>" maxlength="100" size="5" type="text">
								</td>
								</tr>
								</tbody>
							   </table>
							   </div>
							  <table class="table table-bordered">
								<tbody>
							  	<tr>
							   <td style="width: 300px;">
								  <p>Pingback URL</p>
								</td>
								<td>
								 <input type="text" name="PingbackURL" size="35" Value="<?php echo $fetchProject['PingbackURL'];?>">
								 <a href="?TP=True&ID=<?php echo $ID;?>" class="btn btn-default btn-sm">Test Pingback</a>
								</td>
							  </tr>
							  	<tr>
							   <td style="width: 300px;">
								  <p>Notify email</p>
								</td>
								<td>
								 <input type="text" name="Notifyemail" size="35" Value="<?php echo $fetchProject['Notifyemail'];?>">
								</td>
							  </tr>
							  <br>
							  <tr>
							   <td style="width: 300px;">
								  <p>HTML</p>
								</td>
								<td>
								 <input type="text" name="HTML" size="35" readonly Value='<iframe src="https://kernpay.com/API/K_W_01?key=<?php echo $fetchProject['ProjectKey'];?>&uid=[USERID]" width="900" height="800" frameborder="0"></iframe>'>
								</td>
							  </tr>
							</tbody>
						</table>

							
							<?php
							If ($fetchProject['API'] ==1){
								echo '<a href="addproducts.php?ID='.$ID.'" class="btn btn-default">Price Points</a>';
							}elseif($fetchProject['API'] ==2){
								echo '<a href="addproducts.php?ID='.$ID.'" class="btn btn-default">Products</a>';
							}elseif($fetchProject['API'] ==3){
								echo '<a href="addproducts.php?ID='.$ID.'" class="btn btn-default">Products</a>';
							}else{
								echo '';
							}
							?>
							
							
								<div class="btn-group pull-right m-15">
								<button class="btn btn-default" type="submit" name="UpdateProjectSettings">Save Project Settings</button>	
								</div>
							</form>		

							<script type="text/javascript">
							function showPrefAPISel(elem){
							   if(elem.value == 1){
									document.getElementById('API_div').style.display = "block";
							   }else{
								   document.getElementById('API_div').style.display = "none";

							   }
								 
							}
							</script>
							
							 <script type="text/javascript">  
								if(<?php echo $fetchProject['API']; ?> == 1){
									document.getElementById('API_div').style.display = "block";
								}
							</script>
							
						<?php		
						}	
					}else if($Delete == null && $ID == null && $ADD != null && $TP == null){
						if(isset($_POST['AddProject'])){
							
						$ProjectName = mssql_escape_string($_POST['ProjectName']);
						$ProjectUrl = mssql_escape_string($_POST['ProjectUrl']);
						$VirtualCurrencyName = mssql_escape_string($_POST['VirtualCurrencyName']);
						$CurrencyExRate = mssql_escape_string($_POST['CurrencyExRate']);
						$PingbackURL = mssql_escape_string($_POST['PingbackURL']);
						$Notifyemail = mssql_escape_string($_POST['Notifyemail']);
						
						If ( $ProjectName == ''){
							showMessage('error', 'Project Name is empty', 5, 'MyProject.php?Add=True');	
						}else If ( $ProjectUrl == ''){
							showMessage('error', 'Project Url is empty', 5, 'MyProject.php?Add=True');	
						}else If ( $VirtualCurrencyName == ''){
							showMessage('error', 'Virtual Currency Name is empty', 5, 'MyProject.php?Add=True');	
						}else If ( $CurrencyExRate == ''){
							showMessage('error', 'Currency Exchange Rate is empty', 5, 'MyProject.php?Add=True');	
						}else If ( $PingbackURL == ''){
							showMessage('error', 'Pingback URL is empty', 5, 'MyProject.php?Add=True');	
						}else If ( $Notifyemail == ''){
							showMessage('error', 'Notifye mail is empty', 5, 'MyProject.php?Add=True');	
							
						}else{
						if(filter_var($Notifyemail, FILTER_VALIDATE_EMAIL)){
						if (strpos($Notifyemail,'trbvm') !== false) {
						showMessage('error', 'You cant use this email Service!');
						}else{		
						$RadomToken = RandomToken(50);
						$ProjectKey = Md5($_SESSION['nUserID'].$RadomToken.$ProjectName.$RadomToken);
						$SecretKey = Md5($_SESSION['nUserID'].$ProjectName.$RadomToken.$Notifyemail.$CurrencyExRate.$RadomToken);
						
						 if (is_numeric($CurrencyExRate)) {
							$AddProject = sqlsrv_query($conn, "Insert into tProjects (nUserID, ProjectName, ProjectUrl, VirtualCurrencyName, CurrencyExRate, PingbackURL, Notifyemail, ProjectKey, SecretKey) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);", array($_SESSION['nUserID'],  $ProjectName, $ProjectUrl, $VirtualCurrencyName, $CurrencyExRate, $PingbackURL, $Notifyemail, $ProjectKey, $SecretKey), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							$NewAddMessage =  $fetchProject['ProjectName'].' has been successfully added';
							$InsertLogg = sqlsrv_query($conn, "Insert into tActivity (nUserID, Icon, Img, Title, Message) VALUES (?, 'bg-warning', 'fa-bell', 'Notification', ?);", array($_SESSION['nUserID'],  $NewAddMessage), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							
							 If ($AddProject){
								showMessage('success', $ProjectName.' has been successfully added', 3, 'MyProject.php');
							 }else{
								showMessage('error', 'Unknown Insert Error!!! Please contact us for fixing that Problem.', 5, 'MyProject.php');
							}							
						} else {
							showMessage('error', 'Currency Exchange Rate('.$CurrencyExRate.') is not numeric', 5, 'MyProject.php');	
						}	
						}}else{
							showMessage('error', 'You entered a wrong email! The email need at least one @(at) and one .(dot)!');
						}
						}
						}else{
							echo '<form id="login" method="post">
							<div class="youplay-input">
							  <input type="text" name="ProjectName" placeholder="Project Name">
							</div>
							<div class="youplay-input">
							  <input type="text" name="ProjectUrl" placeholder="Project Url">
							</div>
							<div class="youplay-input">
							  <input type="text" name="VirtualCurrencyName" placeholder="Virtual Currency Name">
							</div>
							<div class="youplay-input">
							  <input type="text" name="CurrencyExRate" placeholder="Currency Exchange Rate: 1$ = 100 Coins">
							</div>
							<div class="youplay-input">
							  <input type="text" name="PingbackURL" placeholder="Pingback URL">
							</div>
							<div class="youplay-input">
							  <input type="text" name="Notifyemail" placeholder="Notify email">
							</div>
							<button class="btn btn-default db" type="submit" name="AddProject">Add Project</button>
						</form>';
						}
					}else{
						while($fetchProject = sqlsrv_fetch_array($checkProject)){
						
			?>
				<!-- Single Product Block -->
				<div class="item angled-bg">
				  <div class="row">
					<div class="col-lg-2 col-md-3 col-xs-4">
					  <div class="angled-img">
						<div class="img">
						  <img src="assets/images/game-broken-age-500x375.jpg" alt="">
						</div>
					  </div>
					</div>
					<div class="col-lg-10 col-md-9 col-xs-8">
					  <div class="row">
						<div class="col-xs-6 col-md-9">
						  <a href="?ID=<?php echo $fetchProject['ID'];?>"><h3><?php echo $fetchProject['ProjectName'];?></h3>
						</div>
						<div class="col-xs-6 col-md-3 align-right">
						  <a href="?Delete=True&ID=<?php echo $fetchProject['ID'];?>" class="remove glyphicon glyphicon-remove"></a>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				<!-- /Single Product Block -->		
			<?php
				}
				}
				if($Delete == null && $ID == null && $ADD == null && $TP == null){
					if(sqlsrv_num_rows($checkProject) != 1){
							echo '<br>';
							echo '<div class="alert alert-danger" role="alert">';
							echo '<strong>Oh snap!</strong> You have not Project jet. Lets go and add one!';
							echo '</div>';
							echo '<br>';
					}
			?>
			
              <div class="btn-group pull-right m-15">
                <a href="?Add=True" class="btn btn-default btn-sm">Add Project</a>
              </div>
			  
			  <?php
				}
			  ?>
      </div>

        <!-- Advert Side -->
        <?php include 'Include/Advert.php'; ?>
        <!-- Advert Side -->

    </div>

  </section>
  <!-- /Main Content -->


    <!-- Footer -->
	 <?php include 'Include/Footer.php'; ?>
    <!-- /Footer -->

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