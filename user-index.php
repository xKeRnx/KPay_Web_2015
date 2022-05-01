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
					$Get24hCount = ($Fetch24h[1]*$fetchAccount['sValue']);
					$Get24hSUM = ($Fetch24h[0]*$fetchAccount['sPercent']) - $Get24hCount;	
					
					$Date7D = date('Y-m-d h:i', time()-(604800));
					$Check7D = sqlsrv_query($conn, "SELECT SUM(cast (sAmount as float)), COUNT(sAmount) FROM tPurchases WHERE nOwner = ? AND sValidate = 1 AND sEnabled = 1 AND dDate > = ?;", array($_SESSION['nUserID'], $Date7D), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					$Fetch7D = sqlsrv_fetch_array($Check7D);
					$Get7DCount = ($Fetch7D[1]*$fetchAccount['sValue']);
					$Get7DSUM = ($Fetch7D[0]*$fetchAccount['sPercent']) - $Get7DCount;
					
					$Date30D = date('Y-m-d h:i', time()-(2592000));
					$Check30D = sqlsrv_query($conn, "SELECT SUM(cast (sAmount as float)), COUNT(sAmount) FROM tPurchases WHERE nOwner = ? AND sValidate = 1 AND sEnabled = 1 AND dDate > = ?;", array($_SESSION['nUserID'], $Date30D), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					$Fetch30D = sqlsrv_fetch_array($Check30D);
					$Get30DCount = ($Fetch30D[1]*$fetchAccount['sValue']);
					$Get30DSUM = ($Fetch30D[0]*$fetchAccount['sPercent']) - $Get30DCount;
						
					$DateDY = date('Y-m-d h:i', time()-(31536000));	
					$CheckDY = sqlsrv_query($conn, "SELECT SUM(cast (sAmount as float)), COUNT(sAmount) FROM tPurchases WHERE nOwner = ? AND sValidate = 1 AND sEnabled = 1 AND dDate > = ?;", array($_SESSION['nUserID'], $DateDY), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));					
					$FetchDY = sqlsrv_fetch_array($CheckDY);
					$GetDYCount = ($FetchDY[1]*$fetchAccount['sValue']);
					$GetDYSUM = ($FetchDY[0]*$fetchAccount['sPercent']) - $GetDYCount;
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
	 <?php
	 if(isset($_SESSION['nUserID'])){
		 include 'Include/Navbar.php'; 
	 }else{
		 include 'Include/NavbarLo.php'; 
	 }
	 ?>
  <!-- /Navbar -->

  <!-- Main Content -->
  <section class="content-wrap">

    <!-- Banner -->
		<?php include 'Include/Banner.php'; ?>
    <!-- /Banner -->

    <div class="container youplay-content">

      <div class="row">

        <div class="col-md-9">

		  <!-- Small Analytics -->
          <h2>Small Analytics</h2>
		  Credit: <?php echo number_format($fetchAccount['nAmount'], 2, ".", ".");?>$  = <?php echo ExchangeEUR($fetchAccount['nAmount']);?>€ <- <a href="Payout.php">Payout</a><br></br>
		  
          Last 24 Hours:
          <div class="progress youplay-progress">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
			<?php echo number_format($Get24hSUM, 2, ".", ".");?>$  = <?php echo ExchangeEUR($Get24hSUM);?>€ in the Last 24 hours
            </div>
          </div>

          Last 7 Days:
          <div class="progress youplay-progress">
            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
			<?php echo number_format($Get7DSUM, 2, ".", ".");?>$ = <?php echo ExchangeEUR($Get7DSUM);?>€  in the Last 7 Days
            </div>
          </div>

          Last 30 Days:
          <div class="progress youplay-progress">
            <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
			<?php echo number_format($Get30DSUM, 2, ".", ".");?>$ = <?php echo ExchangeEUR($Get30DSUM);?>€  in the Last 30 Days
            </div>
          </div>

          This Year:
          <div class="progress youplay-progress">
            <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
			<?php echo number_format($GetDYSUM, 2, ".", ".");?>$ = <?php echo ExchangeEUR($GetDYSUM);?>€  in the This Year
            </div>
          </div>
          <!-- /Small Analytics -->
	
			<br></br>
		
          <!-- Activity -->
          <h2 class="mt-0">Activity</h2>
          <div class="youplay-timeline">

		  <?php
				$RecEx = 0;
				while($fetchActivity = sqlsrv_fetch_array($checkActivity)){
				$RecEx = 1;	
			?>	
            <!-- Timeline Notification -->
            <div class="youplay-timeline-block">
              <!-- icon -->
              <div class="youplay-timeline-icon <?php echo $fetchActivity['Icon'];?>">
			  <?php
				  echo'<i class="fa '.$fetchActivity['Img'].'"></i>';
			  ?>
              </div>
              <!-- /icon -->

              <!-- content -->
              <div class="youplay-timeline-content">
                <h3 class="mb-0"><?php echo $fetchActivity['Title']; ?></h3>
                <span class="youplay-timeline-date pt-0"><?php echo  date_format($fetchActivity['dDate'], 'd-m-Y H:i:s'); ?></span>
                <p><?php echo $fetchActivity['Message']; ?></p>
              </div>
              <!-- content -->
            </div>
            <!-- /Timeline Notification -->
			<?php	
				}
					if($RecEx == 0){
						echo '<div class="youplay-timeline-block">';
						echo '<div class="alert" role="alert"><strong>Sorry!</strong> You have no Activities.</div>';
						echo '</div>';
					}
		  ?>
          </div>
          <!-- /Activity -->


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