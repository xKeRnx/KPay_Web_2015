<?php $__TOKEN = "hardcodeshitbyKeRnPay"; require_once('Include/_init.php'); ?>
<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>youplay</title>

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
  <nav class="navbar-youplay navbar navbar-default navbar-fixed-top ">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">
          <img src="assets/images/logo.png" alt="">
        </a>
      </div>  
  </nav>
  <!-- /Navbar -->

  <!-- Main Content -->
    <section class="content-wrap full youplay-404">

    <!-- Banner -->
    <div class="youplay-banner banner-top">
      <div class="image" style="background-image: url(assets/images/game-journey-7-1920x1080.jpg)">
      </div>

      <div class="info">
        <div>
          <div class="container align-center">
              <h2>Logout</h2>
			  <?php
				if(isset($_SESSION['nUserID'])){
					session_destroy();
					showMessage('success', 'Successfully logged out!', 3, '/');
				}else{
					showMessage('info', 'Already logged out!', 1, '/');
				}
			  ?>  
          </div>
        </div>
      </div>
    </div>
    <!-- /Banner -->
	
	 <!-- Footer -->
	 <?php include 'Include/FooterW.php'; ?>
    <!-- /Footer -->

  </section>
  <!-- /Main Content -->


  <!-- jQuery -->
  <script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>

  <!-- CSS Shapes Polyfill -->
  <script type="text/javascript" src="assets/plugins/css-shapes-polyfill/shapes-polyfill.min.js"></script>

  <!-- Hexagon Progress -->
  <script type="text/javascript" src="assets/plugins/jquery.hexagonprogress/jquery.hexagonprogress.min.js"></script>

  <!-- Bootstrap -->
  <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

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