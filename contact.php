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

  <!-- Bootstrap Sweetalert -->
  <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-sweetalert/lib/sweet-alert.css" />
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
          <div class="container">
            <h2>Contact Us</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- /Banner -->

    <!-- Google Map -->
    <div id="google-map" class="youplay-gmaps"></div>
    <script>
      function initializeGmaps() {
            var LatLng = {lat: 49.819103, lng: 8.918731};
            var mapCanvas = document.getElementById('google-map');
            var mapOptions = {
                center      : LatLng,
                scrollwheel : false,
                zoom        : 17,
                mapTypeId   : google.maps.MapTypeId.ROADMAP,
                backgroundColor: 'none',
                styles      : [{
                    stylers: [
                        { hue: '#ff6600' },
                        { visibility: 'simplified' }
                    ]
                }]
            }
            var map = new google.maps.Map(mapCanvas, mapOptions);
            var marker = new google.maps.Marker({
                position: LatLng,
                map: map,
                icon: 'assets/images/marker.png',
                title: 'Hello World!'
            });
        }
        google.maps.event.addDomListener(window, 'load', initializeGmaps);
    </script>
    <!-- /Google Map -->

    <div class="container youplay-content">

      <div class="row">
        <div class="col-md-3">
          <h2 class="mt-0">Contact info</h2>
		  KeRnPay
		  <br>Hinter der Schießmauer 4a
          <br>64853 Otzberg
          <br>
          <br>Phone: +49 15117278742
          <br>Email: support@kernpay.com
          <br>
          <br>
        </div>
        <div class="col-md-9">
          <!-- Contact Form -->
          <div class="youplay-form p-0">
            <h2 class="mt-0">Drop us a line</h2>

            <form action="contactus.php" method="POST" role="form" class="youplay-form-ajax" data-toggle="validator">
              <div class="row">
                <div class="col-md-6">
                  <div class="youplay-input form-group">
                    <input type="text" name="name" placeholder="Name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="youplay-input form-group">
                    <input type="email" name="email" placeholder="Email" required>
                  </div>
                </div>
              </div>
              <div class="youplay-textarea form-group">
                <textarea name="message" placeholder="Message" rows="5" required></textarea>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
          </div>
          <!-- /Contact Form -->
        </div>
      </div>

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

  <!-- Bootstrap Validator -->
  <script type="text/javascript" src="assets/plugins/bootstrap-validator/dist/validator.min.js"></script>

  <!-- Bootstrap Validator -->
  <script type="text/javascript" src="assets/plugins/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>

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