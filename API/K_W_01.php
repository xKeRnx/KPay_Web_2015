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
			echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong> Parameter <strong>key</strong> is missing, please go back to Merchant and try again.</div>';
		}else if ($uid == null){
			echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong> Parameter <strong>uid</strong> is missing, please go back to Merchant and try again.</div>';	
		}else{

		
			$checkProject = sqlsrv_query($conn, "SELECT * FROM tProjects WHERE ProjectKey = ? AND sEnabled = 1;", array($key), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			if(sqlsrv_num_rows($checkProject) != 1){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong> Parameter <strong>key</strong> is wrong, please go back to Merchant and try again.</div>'; 
			}else if(sqlsrv_num_rows($checkProject) == 1){	
				$fetchProject = sqlsrv_fetch_array($checkProject);
					echo '<center><h2>'.$fetchProject['ProjectName'].'</h2></center>';	
				If (getCountry() == 'AD' OR getCountry() == 'BE' OR getCountry() == 'DE' OR getCountry() == 'EE' OR getCountry() == 'FI' OR getCountry() == 'FR' OR getCountry() == 'GR' OR getCountry() == 'IE' OR getCountry() == 'IT' OR getCountry() == 'LU' OR getCountry() == 'MT' OR getCountry() == 'MC' OR getCountry() == 'ME' OR getCountry() == 'NL' OR getCountry() == 'AT' OR getCountry() == 'PT' OR getCountry() == 'SM' OR getCountry() == 'SK' OR getCountry() == 'SI' OR getCountry() == 'ES' OR getCountry() == 'CY') {
					echo '<center><h4>1$ = '.Exchange(1).' / 1€ = '.ExchangeTUSD(1).'</h4></center>';
				}
				
				$checkSystems = sqlsrv_query($conn, "SELECT * FROM tPaymentSystems WHERE ProjectKey = ?;", array($fetchProject['ProjectKey']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
				$fetchSystems = sqlsrv_fetch_array($checkSystems);		
		?>
		
		<div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
		<?php 
		If ($fetchSystems['PayPal'] == 1){
			echo '<li role="presentation"><a href="#PayPal" aria-controls="PayPal" role="tab" data-toggle="tab">PayPal</a></li>';
		}
		If ($fetchSystems['PaySafeCard'] == 1){
			echo '<li role="presentation"><a href="#PaySafe" aria-controls="PaySafe" role="tab" data-toggle="tab">PaySafeCard</a></li>';
		}
		If ($fetchSystems['SofortTransfer'] == 1){
			echo '<li role="presentation"><a href="#Sofort" aria-controls="Sofort" role="tab" data-toggle="tab">Sofort transfer</a></li>';
		}
		If ($fetchSystems['MobilePay'] == 1){
			echo '<li role="presentation"><a href="#MobilePay" aria-controls="MobilePay" role="tab" data-toggle="tab">MobilePay</a></li>';
		}
		
		?>

		  <button type="button" class="btn btn-warning btn-lg1" data-toggle="modal" data-target="#myModal">
			Help
		  </button>
		  
        </ul>
		
		
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Help / Informations</h4>
            </div>
            <div class="modal-body">
			<table class="table table-striped">
				<thead>
				  <tr>
					<th>#</th>
					<th>Description</th>
					<th>TransID</th>
					<th>Date</th>
					<th>System</th>
					<th>Status</th>
				  </tr>
				</thead>
				<tbody>
			<?php
			$IPU = 1;
			$checkPurcha = sqlsrv_query($conn, "SELECT TOP 10 * FROM tPurchases WHERE sProjectKey = ? AND nUserID = ?;", array($fetchProject['ProjectKey'], $uid), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			while($fetchPurcha = sqlsrv_fetch_array($checkPurcha)){
			$newdate = date_format($fetchPurcha['dDate'], 'd-m-Y H:i:s');
			echo '<tr>';
            echo '<th scope="row">'.$IPU.'</th>';
            echo '<td>'.$fetchPurcha['sDesc'].'</td>';
            echo '<td>'.$fetchPurcha['ID'].'</td>';
			echo '<td>'.$newdate.'</td>';
			echo '<td>'.$fetchPurcha['sStatus'].'</td>';
			If ($fetchPurcha['sValidate'] == 0){
			echo '<td><span class="label label-default">Pending</span></td>';
			}elseif ($fetchPurcha['sValidate'] == 1){
			echo '<td><span class="label label-success">Success</span></td>';	
			}elseif ($fetchPurcha['sValidate'] == 2){
			echo '<td><span class="label label-danger">Error</span></td>';	
			}
			echo '</tr>';
			$IPU = $IPU +1;
			}
			?>
				</tbody>
			  </table>
			</div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Contact us</button>
            </div>
          </div>
        </div>
      </div>
		
		<?php				
				If ($fetchProject['API'] == '1'){	
					include 'VC.php';
				}elseif ($fetchProject['API'] == '2'){
					include 'DG.php';
				}elseif ($fetchProject['API'] == '3'){
				echo 'Currently in Work';
			}
				?>
      </div>
	  
		<?php	
		}		
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