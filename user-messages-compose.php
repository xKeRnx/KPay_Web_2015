<?php $__TOKEN = "hardcodeshitbyKeRnPay"; require_once('Include/_init.php'); 
if(isset($_SESSION['nUserID'])){
	$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD']));
		if(!$conn){
			echo print_r(sqlsrv_errors(), true);
		}else{
			if (isset($_GET['u'])) {
				$UserID = $_GET['u'];
			}else{
				echo '<meta http-equiv="refresh" content="0; url=/" />';
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
					
					$CountFriend = sqlsrv_query($conn, "SELECT COUNT(UserID) FROM tFriend WHERE UserID = ? AND Enabled = 1;", array($_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
					$FriendCount = sqlsrv_fetch_array($CountFriend);
					$GetFriendCount = $FriendCount[0];			
						
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

          <ul class="pagination pagination-sm mt-0">
                <li>
                  <a href="in-messages.php">Inbox</a>
                </li>
				<li>
                  <a href="out-messages.php">Outbox</a>
                </li>
				<li>
                  <a href="<?php echo 'user-messages.php?u='.$_GET['u'];?>">In/Outbox</a>
                </li>
            <li class="active">
              <a href="<?php echo 'user-messages-compose.php?u='.$_GET['u'];?>">Compose</a>
            </li>
          </ul>
		  <?php
		    if(isset($_POST['submit'])){
				$subject = mssql_escape_string($_POST['subject']);
				$message = mssql_escape_string($_POST['message']);
				$MynUserID = $_SESSION['nUserID'];
				$PartnernUserID = $fetchAccount['nUserID'];
						
				$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD']));
				if(!$conn){
					echo print_r(sqlsrv_errors(), true);
				}else{
					$insertMessage = sqlsrv_query($conn, "INSERT INTO tMessage (nUserID, nPartnerID, sTitle, sMessage) VALUES (?, ?, ?, ?);", array($MynUserID, $PartnernUserID, $subject, $message));
						if($insertMessage)
						{
							showMessage('', 'Successfully send!', 3, '/');
						}else{
							showMessage('', 'Error: could not send message', 3, 'user-messages.php?u='.$fetchAccount['sSearchLink'].'');					
						}
				}
			}else{
			?>

		  <form id="send" method="post">
            <div class="youplay-input">
              <input type="text" value="Send To <?php echo $fetchAccount['sDisplayName'];?>" readonly="readonly" name="message-to">
            </div>
            <div class="youplay-input">
              <input type="text" placeholder="Subject" name="subject">
            </div>
            <div class="youplay-textarea">
              <textarea placeholder="Message" name="message" rows="5"></textarea>
            </div>
            <button class="btn btn-default" type="submit" name="submit">Send</button>
          </form>
		  <?php
			}
		  ?>

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