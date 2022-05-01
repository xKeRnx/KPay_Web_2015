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
											
				}

		}			
}
?><!DOCTYPE html>

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

  <!-- Owl Catousel -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/owl.carousel/owl.carousel.css" />

  <!-- Magnific Popup -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/magnific-popup/magnific-popup.css" />

  <!-- Revolution Slider -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/slider-revolution/examples&amp;source/rs-plugin/css/settings.css" />

  <!-- Bootstrap Sweetalert -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-sweetalert/lib/sweet-alert.css" />

  <!-- Social Likes -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/social-likes/social-likes_flat.css" />
  <!-- youplay -->

  <link rel="stylesheet" type="text/css" href="../assets/youplay/css/youplay-light.min.css" />
  <!-- RTL (uncomment line before this to enable RTL support) -->
  <!-- <link rel="stylesheet" type="text/css" href="../assets/youplay/css/youplay-rtl.css" /> -->


  <!-- Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js"></script>
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
    <div class="youplay-banner banner-top small">
      <div class="image" style="background-image: url(assets/images/banner-blog-bg.jpg)" data-top="background-position: 50% 0px;" data-top-bottom="background-position: 50% -200px;">
      </div>

      <div class="info" data-top="opacity: 1; transform: translate3d(0px,0px,0px);" data-top-bottom="opacity: 0; transform: translate3d(0px,150px,0px);" data-anchor-target=".youplay-banner.banner-top">
        <div>
        </div>
      </div>
    </div>
    <!-- /Banner -->


    <div class="container youplay-content">
		<?php 
	If (isset($_GET['lang'])){
		If ($_GET['lang'] == 'en'){
				 include 'Include/lang/en/gs.php';
		}else{
				include 'Include/lang/de/gs.php';
		}
	}else{
				If (isset($_COOKIE["lang"])){
					If ($_COOKIE["lang"] == 'en'){
						include 'Include/lang/en/gs.php';
					}else{
						include 'Include/lang/de/gs.php';
					}
				}else{
					include 'Include/lang/de/gs.php';
				}
	}
	?>
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

  <!-- Owl Carousel -->
  <script type="text/javascript" src="assets/plugins/owl.carousel/owl.carousel.min.js"></script>

  <!-- Countdown -->
  <script type="text/javascript" src="assets/plugins/jquery.coundown/jquery.countdown.min.js"></script>

  <!-- Magnific Popup -->
  <script type="text/javascript" src="assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Revolution Slider -->
  <script type="text/javascript" src="assets/plugins/slider-revolution/examples&amp;source/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
  <script type="text/javascript" src="assets/plugins/slider-revolution/examples&amp;source/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

  <!-- Isotope -->
  <script type="text/javascript" src="assets/plugins/isotope/isotope.pkgd.min.js"></script>

  <!-- Bootstrap Validator -->
  <script type="text/javascript" src="assets/plugins/bootstrap-validator/dist/validator.min.js"></script>

  <!-- Bootstrap Validator -->
  <script type="text/javascript" src="assets/plugins/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>

  <!-- Social Likes -->
  <script type="text/javascript" src="assets/plugins/social-likes/social-likes.min.js"></script>

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