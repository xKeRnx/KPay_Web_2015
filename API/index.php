<?php 
header('Content-Type: text/html; charset=UTF-8');
ob_start();
$__TOKEN = "hardcodeshitbyKeRnPay";
require_once('../Include/_init.php'); 
	$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD'], "CharacterSet" => "UTF-8"));
		if(!$conn){
			echo print_r(sqlsrv_errors(), true);
		}else{
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
  <link rel="icon" type="image/png" href="../assets/images/icon.png">
  <!-- Google Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>


  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap/css/bootstrap.min.css" />

  <!-- FontAwesome -->
  <link rel="stylesheet" type="text/css" href="../assets/plugins/fontawesome/css/font-awesome.min.css" />

  <!-- Owl Catousel -->
  <link rel="stylesheet" type="text/css" href="../assets/plugins/owl.carousel/owl.carousel.css" />

  <!-- Magnific Popup -->
  <link rel="stylesheet" type="text/css" href="../assets/plugins/magnific-popup/magnific-popup.css" />

  <!-- Revolution Slider -->
  <link rel="stylesheet" type="text/css" href="../assets/plugins/slider-revolution/examples&amp;source/rs-plugin/css/settings.css" />

  <!-- Bootstrap Sweetalert -->
  <link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap-sweetalert/lib/sweet-alert.css" />

  <!-- Social Likes -->
  <link rel="stylesheet" type="text/css" href="../assets/plugins/social-likes/social-likes_flat.css" />
  <!-- youplay -->

  <link rel="stylesheet" type="text/css" href="../assets/youplay/css/youplay-light.min.css" />
  <!-- RTL (uncomment line before this to enable RTL support) -->
  <!-- <link rel="stylesheet" type="text/css" href="../assets/youplay/css/youplay-rtl.css" /> -->


  <!-- Google Maps API -->
  <script src="https://maps.googleapis.com/maps/api/js"></script>
  <!--[if lt IE 9]>
      <script src="../assets/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>

  <!-- Preloader -->
  <div class="page-preloader preloader-wrapp">
    <img src="../assets/images/logo.png" alt="">
    <div class="preloader"></div>
  </div>
  <!-- /Preloader -->

  <!-- Navbar -->
  <nav class="navbar-youplay navbar navbar-default navbar-fixed-top ">
    <div class="container">
      <div class="navbar-header">
		
        <a class="navbar-brand" href="#">
          <img src="../assets/images/logo.png" alt="">
        </a>
      </div>
    </div>
  </nav>
  <!-- /Navbar -->

  <!-- Main Content -->
  <section class="content-wrap" style="padding-top: 50px;">




    <div class="container youplay-content"><br>
		<?php
		$key = null;
		$uid = null;
		
		if(isset($_GET['key'])){
			$key = mssql_escape_string($_GET['key']);
		}
		
		if(isset($_GET['uid'])){
			$uid = mssql_escape_string($_GET['uid']);
		}
		
		
		If ($key == null){
			echo '<br></br>';
			echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong> Parameter is missing, please go back to Merchant and try again.</div>';
		}else if ($uid == null){
			echo '<br></br>';
			echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong> Parameter is missing, please go back to Merchant and try again.</div>';	
		}
		?>
	  
    </div>

	


  </section>
  <!-- /Main Content -->

    <!-- Footer -->
	 <footer style="position:absolute;">

        

        <!-- Copyright -->
        <div class="copyright">
          <div class="container">
            <strong>KeRnPay</strong> &copy; 2016. All rights reserved
          </div>
        </div>
		
        <!-- /Copyright -->

   
    </footer>

    <!-- /Footer -->
  

  <!-- jQuery -->
  <script type="text/javascript" src="../assets/plugins/jquery/jquery.min.js"></script>

  <!-- CSS Shapes Polyfill -->
  <script type="text/javascript" src="../assets/plugins/css-shapes-polyfill/shapes-polyfill.min.js"></script>

  <!-- Hexagon Progress -->
  <script type="text/javascript" src="../assets/plugins/jquery.hexagonprogress/jquery.hexagonprogress.min.js"></script>

  <!-- Bootstrap -->
  <script type="text/javascript" src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

  <!-- Skrollr -->
  <script type="text/javascript" src="../assets/plugins/skrollr/skrollr.min.js"></script>

  <!-- Smooth Scroll -->
  <script type="text/javascript" src="../assets/plugins/smoothscroll/smoothscroll.js"></script>

  <!-- Owl Carousel -->
  <script type="text/javascript" src="../assets/plugins/owl.carousel/owl.carousel.min.js"></script>

  <!-- Countdown -->
  <script type="text/javascript" src="../assets/plugins/jquery.coundown/jquery.countdown.min.js"></script>

  <!-- Magnific Popup -->
  <script type="text/javascript" src="../assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Revolution Slider -->
  <script type="text/javascript" src="../assets/plugins/slider-revolution/examples&amp;source/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
  <script type="text/javascript" src="../assets/plugins/slider-revolution/examples&amp;source/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

  <!-- Isotope -->
  <script type="text/javascript" src="../assets/plugins/isotope/isotope.pkgd.min.js"></script>

  <!-- Bootstrap Validator -->
  <script type="text/javascript" src="../assets/plugins/bootstrap-validator/dist/validator.min.js"></script>

  <!-- Bootstrap Validator -->
  <script type="text/javascript" src="../assets/plugins/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>

  <!-- Social Likes -->
  <script type="text/javascript" src="../assets/plugins/social-likes/social-likes.min.js"></script>

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