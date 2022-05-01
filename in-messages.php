<?php $__TOKEN = "hardcodeshitbyKeRnPay"; require_once('Include/_init.php'); 
if(isset($_SESSION['nUserID'])){
	$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD']));
		if(!$conn){
			echo print_r(sqlsrv_errors(), true);
		}else{
			if (isset($_GET['u'])) {
				$UserID = $_GET['u'];
				$ItsYou = False;
			}else{
				$checkU = sqlsrv_query($conn, "SELECT sSearchLink FROM tAccounts WHERE nUserID = ?;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));				
				$fetchU = sqlsrv_fetch_array($checkU);
				$UserID = $fetchU['sSearchLink'];
				$ItsYou = True;
			}
				$checkMe = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE nUserID = ?;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				$fetchMe = sqlsrv_fetch_array($checkMe);
				
				$checkMessagesCount = sqlsrv_query($conn, "SELECT COUNT(nPartnerID) FROM tMessage WHERE nPartnerID = ? AND sRead = 0 AND sEnabled = 1;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				$fetchMessagesCount = sqlsrv_fetch_array($checkMessagesCount);
				
				$checkAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE sSearchLink = ?;", array($UserID), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				if(sqlsrv_num_rows($checkAccount) == 1){
					$fetchAccount = sqlsrv_fetch_array($checkAccount);
					$checkProfile = sqlsrv_query($conn, "SELECT * FROM tUserProfile WHERE nUserID = ?;", array($fetchAccount['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));				
					$fetchProfile = sqlsrv_fetch_array($checkProfile);
										
						
				}else{
					echo '<meta http-equiv="refresh" content="0; url=/" />';
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

          <div class="row">
            <div class="col-md-9">
              <ul class="pagination pagination-sm mt-0">
                <li class="active">
                  <a href="in-messages.php">Inbox</a>
                </li>
				<li>
                  <a href="out-messages.php">Outbox</a>
                </li>
                <li>
				<?php 
				if (isset($_GET['u'])) {
					echo '<a href="user-messages-compose.php?u='.$_GET['u'].'">Compose</a>';
				}
				?>
                  
                </li>
              </ul>
            </div>
            <div class="col-md-3">

             

            </div>
          </div>

          <table class="youplay-messages table table-hover">
            <tbody>
			<?php
				$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD']));
				if(!$conn){
					echo print_r(sqlsrv_errors(), true);
				}else{
					if (isset($_GET['u'])) {
						$checkMessage = sqlsrv_query($conn, "SELECT * FROM tMessage WHERE nUserID = ? AND nPartnerID = ? OR nUserID = ? AND nPartnerID = ? AND sEnabled = 1 Order by dDate DESC;", array($_SESSION['nUserID'], $fetchAccount['nUserID'], $fetchAccount['nUserID'], $_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					}else{
						$checkMessage = sqlsrv_query($conn, "SELECT * FROM tMessage WHERE nPartnerID = ? AND sEnabled = 1 Order by dDate DESC;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					}
							if(sqlsrv_num_rows($checkMessage) == 0){
								echo '<div class="alert alert-warning" role="alert">
								<strong>Sorry!</strong> You have no Messages.
								</div>';
							}
					
							while($fetchMessage = sqlsrv_fetch_array($checkMessage)){									
										If ($fetchMessage['nUserID'] == $_SESSION['nUserID']){
											$checkPartner1 = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE nUserID = ?;", array($fetchMessage['nPartnerID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
											$fetchPartner1 = sqlsrv_fetch_array($checkPartner1);
											$Send = True;
											$SValue = 'To:';
											echo '<tr>';
										}else{
											$checkPartner1 = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE nUserID = ?;", array($fetchMessage['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
											$fetchPartner1 = sqlsrv_fetch_array($checkPartner1);
											$Send = False;
											$SValue = 'From:';
											If ($fetchMessage['sRead'] == 1){
												echo '<tr>';
											}else{
												echo '<tr class="message-unread">';
											}
										}
								
										$newdate = date_format($fetchMessage['dDate'], 'd-m-Y H:i:s');
										
										?>
										        <td class="message-from">
												  <a href="#" class="angled-img">
													<div class="img">
													  <img src="assets/images/avatar-user-1.png" width="80" height="80" alt="">
													</div>
												  </a>
													<?php if (isset($_GET['u'])) {
														?>
														 <a href="https://youplay.KeRnPay.co/?u=<?php echo $fetchPartner1['sSearchLink']; ?>" class="message-from-name" title="<?php echo $fetchPartner1['sDisplayName']; ?>"><?php echo $SValue.' '.$fetchPartner1['sDisplayName']; ?></a>
														<?php											
													}else{
														?>
														 <a href="https://youplay.KeRnPay.co/user-messages.php?u=<?php echo $fetchPartner1['sSearchLink']; ?>" class="message-from-name" title="<?php echo $fetchPartner1['sDisplayName']; ?>"><?php echo $SValue.' '.$fetchPartner1['sDisplayName']; ?></a>
														<?php
													}?>									 
												  <br>
												  <span class="date"><?php echo $newdate; ?></span>
												</td>
												<td class="message-description">
												  <a href="#" class="message-description-name" title="View Message"><?php echo $fetchMessage['sTitle']; ?></a>
												  <br>
												  <div class="message-excerpt"><?php echo $fetchMessage['sMessage']; ?></div>
												</td>
												<td class="message-action">
												 
												  <a class="message-delete" href="#"><i class="fa fa-times"></i></a>
												</td>
											  </tr>
										<?php											
						}	
				}		
			?>
			
            </tbody>

          </table>


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