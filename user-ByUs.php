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
	<br>

    <div class="container youplay-content">

      <div class="row">
          <!-- Activity -->
          <h2 class="mt-0">Users</h2>
          <div class="">

		  <?php		
				$OFFSET = 0;
				$Next = 100;
				$i = 1;
				
				if(isset($_GET['O']) AND isset($_GET['N'])){
					
					$OFFSET = mssql_escape_string($_GET['O']);
					$OFFSET = intval($OFFSET);
					$Next = mssql_escape_string($_GET['N']);
					$Next = intval($Next);
				}
				
				$Proje = Null;
				$DateFrom = '01'.date('-m-Y');
				$DateTo = date("d-m-Y", time()+(60*60*24));
				$DateToNo = date("d-m-Y", time()+(60*60*24));
				
				if(isset($_GET['DateFrom'])){
					$DateFrom = mssql_escape_string($_GET['DateFrom']);
				}
				if(isset($_GET['DateTo'])){
					$DateTo = mssql_escape_string($_GET['DateTo']);
					$DateToNo = mssql_escape_string($_GET['DateTo']);
					$DateTo = strtotime('+1 day', strtotime($DateTo));
					$DateTo = date('d.m.Y', $DateTo);
				}

					
					echo '<form id="search" action="https://kernpay.com/user-byus" method="GET">';
					
						echo '<input type="text" value="'.$DateFrom.'" name="DateFrom">';
						echo '<input type="text" value="'.$DateToNo.'" name="DateTo">';
					
					
					echo '<button type="submit" class="btn btn-default btn-sm">Get Report</button>';
					echo '</form> <br>';
					
					//Start DIV
					echo ' <div id="DG_div" style="display: block;">';
					echo '<div id="left_box" style="width: 500px; float:left;margin-right: 50px;">';
					
					echo '<table class="table table-hover" style="width:300px">';
					
					echo '<thead>';
					 echo ' <tr Style="font-size: 12px;">';
						echo '<th style="width:10%">#</th>';
						echo '<th style="width:30%">UserID</th>';
						echo '<th style="width:30%" >Conversions</th>';
						echo '<th style="width:30%">Revenue</th>';
					  echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
					
				$RecEx = 0;
				$checkTransaction = sqlsrv_query($conn, "Select nUserID, Count(nUserID) as nUserID, SUM(cast (sAmount as float)) as  sAmount from tPurchases Where dDate >= Convert(datetime,?,103) AND dDate <= Convert(datetime,?,103) AND sValidate = 1 AND sEnabled = 1  GROUP BY nUserID Order by sAmount DESC OFFSET  ? ROWS FETCH NEXT ? ROWS ONLY;", array($DateFrom, $DateTo, $OFFSET, $Next), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));				
				
				while($fetchTransaction = sqlsrv_fetch_array($checkTransaction)){
					$RecEx = 1;

					 echo '<tr Style="font-size: 12px;">';
						echo '<th scope="row">'.$i.'</th>';
						echo '<td>'.$fetchTransaction[0].'</td>';
						echo '<td>'.$fetchTransaction[1].'</td>';
						echo '<td>$'.$fetchTransaction[2].'</td>';
					echo '</tr>	';				

				$i = $i +1;
				}
					echo '</tbody>';
					echo '</table>';
						if($RecEx == 0){
						echo '<div class="youplay-timeline-block">';
						echo '<div class="alert" role="alert"><strong>Sorry!</strong> You have no Activities.</div>';
						echo '</div>';
						}					
					echo '</div>';
					
					
					
					echo '<div id="left_box" style="width: 500px; float:left;">';
					echo '<table class="table table-hover" style="width:300px">';
					echo '<thead>';
					 echo ' <tr Style="font-size: 12px;">';
						echo '<th style="width:50%"># of Paying Users</th>';
						echo '<th style="width:50%">Total Revenue</th>';
					  echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
					
				$checkTransaction1 = sqlsrv_query($conn, "Select Count(*), SUM(cast (sAmount as float)) as  sAmount From (Select Count(nUserID) as nUserID, SUM(cast (sAmount as float)) as  sAmount from tPurchases Where dDate >= Convert(datetime,?,103) AND dDate <= Convert(datetime,?,103) AND sValidate = 1 AND sEnabled = 1 GROUP BY nUserID Order by sAmount DESC OFFSET  ? ROWS FETCH NEXT ? ROWS ONLY) As Z;", array($DateFrom, $DateTo, $OFFSET, $Next), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));				
					
				while($fetchTransaction1 = sqlsrv_fetch_array($checkTransaction1)){
					if($fetchTransaction1[0] != 0){
						echo '<tr Style="font-size: 12px;">';
							echo '<th scope="row">'.$fetchTransaction1[0].'</th>';
							echo '<td>$'.$fetchTransaction1[1].'</td>';
						echo '</tr>	';				
					}
				
					echo '</tbody>';
					echo '</table>';
						if($fetchTransaction1[0] == 0){
						echo '<div class="youplay-timeline-block">';
						echo '<div class="alert" role="alert"><strong>Sorry!</strong> You have no Activities.</div>';
						echo '</div>';
						}
				}	
					echo '</div>';
					
					echo '</div>';
					echo '<div style="clear:both"></div>';
					// END DIV
					
					
					echo '<br>';
					echo '<nav>';
						if (strpos($_SERVER['REQUEST_URI'], '?') !== false) {
							$O1 = $OFFSET +100;
							$N1 = $Next +100;
							
							$O2 = $OFFSET -100;
							$N2 = $Next -100;
							
							if(isset($_GET['O']) AND isset($_GET['N'])){
								$arr1 = array('O='.$_GET['O'] => 'O='.$O1, 'N='.$_GET['N'] => 'N='.$N1); 
								$Link1 = strtr($_SERVER['REQUEST_URI'],$arr1); 
								
								$arr2 = array('O='.$_GET['O'] => 'O='.$O2, 'N='.$_GET['N'] => 'N='.$N2); 
								$Link2 = strtr($_SERVER['REQUEST_URI'],$arr2);								
							}else{
								$Link1 = $_SERVER['REQUEST_URI'].'&O='.$O1.'&N='.$N1;
								$Link2 = $_SERVER['REQUEST_URI'].'&O='.$O2.'&N='.$N2;
							}
							
						}else{
							$O1 = $OFFSET +100;
							$N1 = $Next +100;
							
							$O2 = $OFFSET -100;
							$N2 = $Next -100;
							
							if(isset($_GET['O']) AND isset($_GET['N'])){
								$arr1 = array('O='.$_GET['O'] => 'O='.$O1, 'N='.$_GET['N'] => 'N='.$N1); 
								$Link1 = strtr($_SERVER['REQUEST_URI'],$arr1); 
								
								$arr2 = array('O='.$_GET['O'] => 'O='.$O2, 'N='.$_GET['N'] => 'N='.$N2); 
								$Link2 = strtr($_SERVER['REQUEST_URI'],$arr2);								
							}else{
								$Link1 = $_SERVER['REQUEST_URI'].'?O='.$O1.'&N='.$N1;
								$Link2 = $_SERVER['REQUEST_URI'].'?O='.$O2.'&N='.$N2;
							}
						}
						
						echo '<ul class="pager">';
						if(isset($_GET['O']) AND isset($_GET['N']) AND $_GET['O'] != 0){
							 echo '<li><a href="'.$Link2.'" >Previous</a>';
						}else{
							 echo '<li><a href="#" >Previous</a>';
						}
						  echo '</li>';
						  echo '<li><a href="'.$Link1.'">Next</a>';
						  echo '</li>';
						echo '</ul>';
					echo '</nav>';
					
					
		  ?>
          </div>
          <!-- /Activity -->


      

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