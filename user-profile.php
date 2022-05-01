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

         <h3 class="mt-40 mb-20">Payment Recipient</h3>
          <table class="table table-bordered">
            <tbody>
			   <tr>
               <td style="width: 300px;">
                  <p>Who are You?</p>
                </td>
                <td>
                  <p><?php If ($fetchProfile['Type'] == 0) {echo 'Individual';}else{echo 'Company';} ?></p>
                </td>
              </tr>	
			  <?php If ($fetchProfile['Type'] == 1) { ?>
			   <tr>
                <td>
                  <p>Company Name</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['CompanyName']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Identification number/Tax ID number</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['TaxID']; ?></p>
                </td>
              </tr>
			  <?php }?>
			  <tbody>
			</table>
			
			<table class="table table-bordered">
			<tbody>
              <tr>
               <td style="width: 300px;">
                  <p>First Name</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['FirstName']; ?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Last Name</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['LastName']; ?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Email address</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['Emailaddress']; ?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Phone number</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['Phonenumber']; ?></p>
                </td>
              </tr>
            </tbody>
          </table>

          <h3 class="mt-40 mb-20">Payout Settings</h3>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td style="width: 300px;">
                  <p>Country</p>
                </td>
                <td>
                  <p><?php echo GetThCountry($fetchProfile['Country']); ?></p>
                </td>
              </tr>
			    <tr>
                <td>
                  <p>Preferred Payout Method</p>
                </td>
                <td>
                  <p><?php If ($fetchProfile['PayoutMethod'] == 0){echo 'PayPal';}else{echo 'Bank Transfer';} ?></p>
                </td>
              </tr>
			  <?php If ($fetchProfile['PayoutMethod'] == 1){?>
              <tr>
                <td>
                  <p>Beneficiary Name on bank account:</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['Nameonbank']; ?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Street Address</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['StreetAddress']; ?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>City</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['City']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Postal Code</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['PostalCode']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Name</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['BankName']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Country</p>
                </td>
                <td>
                  <p><?php echo GetThCountry($fetchProfile['BankCountry']); ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Address</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['BankAddress']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>SWIFT (BIC) Cod</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['BIC']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Routing No</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['BankRoutingNo']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Account No</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['BankAccountNo']; ?></p>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>IBAN</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['IBAN']; ?></p>
                </td>
              </tr>
			<?php }else{?>
			   <tr>
                <td>
                  <p>PayPal Email</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['PayPalEmail']; ?></p>
                </td>
              </tr>
			<?php }?>
			  <tr>
                <td>
                  <p>Preferred Currency</p>
                </td>
                <td>
                  <p>
				  <?php If ($fetchProfile['PreferredCurrency'] == 0){
					  echo '';
				  }elseif ($fetchProfile['PreferredCurrency'] == 1){
					  echo 'USD';
				  }elseif ($fetchProfile['PreferredCurrency'] == 2){
					  echo 'EUR';
				  }elseif ($fetchProfile['PreferredCurrency'] == 3){
					  echo 'PLN';
				  }elseif ($fetchProfile['PreferredCurrency'] == 4){
					  echo 'TRY';
				  }?></p>
                </td>
              </tr>
			  	 <tr>
                <td>
                  <p>Additional Notes</p>
                </td>
                <td>
                  <p><?php echo $fetchProfile['AdditionalNotes']; ?></p>
                </td>
              </tr>
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