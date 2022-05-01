<?php $__TOKEN = "hardcodeshitbyKeRnPay"; require_once('Include/_init.php'); ?>
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
    <section class="content-wrap full youplay-404">

    <!-- Banner -->
    <div class="youplay-banner banner-top">
      <div class="image" style="background-image: url(assets/images/game-journey-7-1920x1080.jpg)">
      </div>

      <div class="info">
        <div>
          <div class="container align-center">
              <h2>Login</h2>
			  <?php
			  if(isset($_SESSION['nUserID'])){
				  showMessage('', 'You are already logged in!<br>You will be redirected in 3 seconds', 3, '/');
			  }else{
				  if(isset($_POST['submit'])){
						$username = mssql_escape_string($_POST['username']);
						$password = mssql_escape_string($_POST['password']);
						
						$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD']));
						if(!$conn){
							echo print_r(sqlsrv_errors(), true);
						}else{
							$checkPWAccount = sqlsrv_query($conn, "SELECT sUserPassSalt FROM tAccounts WHERE sUsername = ?;", array($username), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							if(sqlsrv_num_rows($checkPWAccount) == 1){
								$fetchPWAccount = sqlsrv_fetch_array($checkPWAccount);
								$PWSALT = $fetchPWAccount['sUserPassSalt'];
								$checkAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE sUsername = ? AND sUserPass = ?;", array($username, MD5(MD5($password).$PWSALT)), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
								if(sqlsrv_num_rows($checkAccount) == 1){
										$fetchAccount = sqlsrv_fetch_array($checkAccount);
										$_SESSION['nUserID'] = $fetchAccount['nUserID'];
										showMessage('alert alert-success', 'Successfully logged in!', 3, '/');
								}else{
									showMessage('alert alert-warning alert-dismissible', 'Username and/or Password wrong!!');
								}
							}else{
									showMessage('alert alert-warning alert-dismissible', 'Username and/or Password wrong!!');
							}
						}
				  }else{
					  echo'
						<form id="login" method="post">
							<div class="youplay-input">
							  <input type="text" name="username" placeholder="Username">
							</div>
							<div class="youplay-input">
							  <input type="password" name="password" placeholder="Password">
							</div>
							<button class="btn btn-default db" type="submit" name="submit">Login</button>
						</form>';
				  }
				 
			  }
			  
			  ?>
					

			  
          </div>
        </div>
      </div>
    </div>
    <!-- /Banner -->

	    <!-- Footer -->
	 <?php include 'Include/Footer.php'; ?>
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