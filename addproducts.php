<?php header('Content-Type: text/html; charset=UTF-8');
ob_start();
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

			<?php
				$ID = null;
				$S = null;
				if(isset($_GET['ID'])){
					$ID = mssql_escape_string($_GET['ID']);
					$checkProject = sqlsrv_query($conn, "SELECT * FROM tProjects WHERE nUserID = ? AND ID = ? AND sEnabled = 1;", array($_SESSION['nUserID'], $ID), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					if(sqlsrv_num_rows($checkProject) != 1){
						echo '<meta http-equiv="refresh" content="0; url=MyProject.php" />';
						exit;  
					}							
				}
				if(isset($_GET['S'])){
					$S = mssql_escape_string($_GET['S']);
					if($S == 's'){
						echo '<div class="alert alert-success" role="alert">
						<strong>Well done!</strong> Price Points successfully updated.
						</div>';
					}elseif($S == 'ps'){
						echo '<div class="alert alert-success" role="alert">
						<strong>Well done!</strong> Price Points successfully added.
						</div>';
					}elseif($S == 'e'){
						echo '<div class="alert alert-danger" role="alert">
						<strong>Oh snap!</strong> Change a few things up and try submitting again.
						</div>';
					}elseif($S == 'pe'){
						echo '<div class="alert alert-danger" role="alert">
						<strong>Oh snap!</strong> Change a few things up and try submitting again.
						</div>';
					}elseif($S == 'pexi'){
						echo '<div class="alert alert-danger" role="alert">
						<strong>Oh snap!</strong> Price Point already exists.
						</div>';
					}
				}	
				while($fetchProject = sqlsrv_fetch_array($checkProject)){
					// TITLE START
							If ($fetchProject['API'] ==1){
								echo '<h2 class="mt-0">Price Points</h2>';
							}elseif($fetchProject['API'] ==2){
								echo '<h2 class="mt-0">Products</h2>';
							}elseif($fetchProject['API'] ==3){
								echo '<h2 class="mt-0">Products</h2>';
							}
					// TITLE END
					
					// Project START
							If ($fetchProject['API'] ==1){
								// Price Points
							echo '<form id="Update" method="post">';
								echo '<table class="table table-striped">';
									echo '<tbody>';
									echo '<thead>
									  <tr>
										<th>Price</th>
										<th>Discount type</th>
										<th>Discount amount</th>
										<th>Promotion</th>
										<th>Option</th>
										<th>Default</th>
										<th>Enabled</th>
										
									  </tr>
									</thead>';
								$PPi = 0;
								$checkPricePoints = sqlsrv_query($conn, "SELECT * FROM tPricePoint WHERE ProjectID = ? ORDER BY cast (Price as float) ASC;", array($fetchProject['ID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
									while($fetchPricePoints = sqlsrv_fetch_array($checkPricePoints)){ 
									  if(isset($_POST['UpdateNow'])){
										$PDType = mssql_escape_string($_POST['DType'.$PPi]);
										$PDAmount = mssql_escape_string($_POST['DAmount'.$PPi]);
										$PsPromo = mssql_escape_string($_POST['sPromo'.$PPi]);
										$PdValue = mssql_escape_string($_POST['dValue'.$PPi]);
										
										If (mssql_escape_string($_POST['nEnabled'.$PPi]) == 1){
											$PnEnabled = 1;
										}else{
											$PnEnabled = 0;
										}
										
										
										If ($PPi == mssql_escape_string($_POST['sDefault'])){
											$PsDefault = 1;
										}else{
											$PsDefault = 0;
										}						
										 
										$updatePricePoints = sqlsrv_query($conn, "Update tPricePoint SET DType = ?, DAmount = ?, Promotion = ?, sDefault = ?, dValue = ?, nEnabled = ? WHERE ProjectID = ? AND Price = ?;", array($PDType, $PDAmount, $PsPromo, $PsDefault, $PdValue, $PnEnabled, $fetchProject['ID'], $fetchPricePoints['Price']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
										If ($updatePricePoints){
											header('Location:addproducts.php?ID=5&S=s');
										}else{
											header('Location:addproducts.php?ID=5&S=e');
										}
								
									  }
									
									$Dtype0 = '';
									$Dtype1 = '';
									$Dtype2 = '';
									$Dtype3 = '';
									If ($fetchPricePoints['DType'] == 0){
										$Dtype0 = 'selected';
									}elseif ($fetchPricePoints['DType'] == 1){
										$Dtype1 = 'selected';
									}elseif ($fetchPricePoints['DType'] == 2){
										$Dtype2 = 'selected';
									}elseif ($fetchPricePoints['DType'] == 3){
										$Dtype3 = 'selected';
									}
									
									$dVaule0 = '';
									$dVaule1 = '';
									$dVaule2 = '';
									$dVaule3 = '';
									If ($fetchPricePoints['dValue'] == 0){
										$dVaule0 = 'selected';
									}elseif ($fetchPricePoints['dValue'] == 1){
										$dVaule1 = 'selected';
									}elseif ($fetchPricePoints['dValue'] == 2){
										$dVaule2 = 'selected';
									}elseif ($fetchPricePoints['dValue'] == 3){
										$dVaule3 = 'selected';
									}
									
									
									
													echo '<tr>';
														echo ' <td style="width: 50px;">';
															echo ''.$fetchPricePoints['Price'].'$';
														echo '</td>';
														echo ' <td style="width: 150px;">';
															echo '<select name="DType'.$PPi.'" id="'.$PPi.'_discount_type" >
															<option value="0" '.$Dtype0.'></option>
															<option value="1" '.$Dtype1.'>Bonus +</option>
															<option value="2" '.$Dtype2.'>Bonus %</option>
															<option value="3" '.$Dtype3.'>Discount</option>
															</select>';
														echo '</td>';
														echo ' <td style="width: 150px;">';
															echo '<input type="text" name="DAmount'.$PPi.'" size="5" Value="'.$fetchPricePoints['DAmount'].'">';
														echo '</td>';
														echo ' <td style="width: 150px;">';
															echo '<input type="text" name="sPromo'.$PPi.'" size="15" Value="'.$fetchPricePoints['Promotion'].'">';
														echo '</td>';
														echo ' <td style="width: 150px;">';
															echo '<select name="dValue'.$PPi.'" id="'.$PPi.'_option_type" >
															<option value="0" '.$dVaule0.'></option>
															<option value="1" '.$dVaule1.'>Most popular</option>
															<option value="2" '.$dVaule2.'>Best value</option>
															<option value="3" '.$dVaule3.'>Discount</option>
															</select>';
														echo '</td>';
														echo ' <td style="width: 50px;">';
															echo '<input type="radio" name="sDefault" value="'.$PPi.'" ';
															If ($fetchPricePoints['sDefault'] == 1){
																echo 'checked="checked"';
															}
															echo '>';
														echo '</td>';
														echo ' <td style="width: 50px;">';
															echo '<input type="checkbox" value="1" name="nEnabled'.$PPi.'"   ';
															If ($fetchPricePoints['nEnabled'] == 1){
																echo 'checked="checked"';
															}
															echo '>';
														echo '</td>';
													echo '</tr>';
									$PPi = $PPi + 1;				
									}
									echo '</tbody>';	
								echo '</table>';
								echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Price Points</button>';
								echo '<button class="btn btn-lg" type="submit" name="UpdateNow">Save</button>';
							echo '</form>';		
								
								if(isset($_POST['AddPP'])){
									$PADDPRICE = mssql_escape_string($_POST['ADDPRICE']);
									
									$checkNewPoints = sqlsrv_query($conn, "SELECT * FROM tPricePoint WHERE ProjectID = ? AND Price = ?;", array($fetchProject['ID'], $PADDPRICE), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
										if(sqlsrv_num_rows($checkNewPoints) == 1){	
												header('Location:addproducts.php?ID='.$fetchProject['ID'].'&S=pexi');	
										}else{
											$insertPrice = sqlsrv_query($conn, "INSERT INTO tPricePoint (ProjectID, Price) VALUES (?, ?);", array($fetchProject['ID'], $PADDPRICE));
											If ($insertPrice){
												header('Location:addproducts.php?ID='.$fetchProject['ID'].'&S=ps');	
											}else{
												header('Location:addproducts.php?ID='.$fetchProject['ID'].'&S=pe');	
											}
										}
									
									
								
									
								}
								
								echo '
								<form id="AddPP" method="post">
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog12">
									  <div class="modal-content">
										<div class="modal-header">
										  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
										  </button>
										  <h4 class="modal-title" id="myModalLabel">Add Price Points</h4>
										</div>
										<div class="modal-body">
										<center>
										<input type="text" name="ADDPRICE" size="9" placeholder="Price in $">
										</center>
										</div>
										<div class="modal-footer">
										  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										  <button type="submit" name="AddPP" class="btn btn-primary">Add Price Points</button>
										</div>
									  </div>
									</div>
								  </div>
								</form>
								  ';
								
								
							}elseif($fetchProject['API'] ==2){
								// Digital Goods
								
							}elseif($fetchProject['API'] ==3){
								// Cart
								
							}
					// Project END
					
		
		
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