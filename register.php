<?php header('Content-Type: text/html; charset=UTF-8');
$__TOKEN = "hardcodeshitbyKeRnPay"; require_once('Include/_init.php'); 
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
	<?php 
	If (isset($_GET['lang'])){
		If ($_GET['lang'] == 'en'){
				 include 'Include/lang/en/register.php';
		}else{
				include 'Include/lang/de/register.php';
		}
	}else{
				If (isset($_COOKIE["lang"])){
					If ($_COOKIE["lang"] == 'en'){
						include 'Include/lang/en/register.php';
					}else{
						include 'Include/lang/de/register.php';
					}
				}else{
					include 'Include/lang/de/register.php';
				}
	}
	?>

    <div class="container youplay-content">
		<form id="RegisterForm" method="post">
	      <div class="col-md-9">
        <!-- Billing Information -->
        <h2 class="mt-0"><?php echo $RTitle;?></h2>

		<?php
		if(isset($_POST['BtnReg'])){
			$Comp_select = mssql_escape_string($_POST['Comp_select']);
			$CompanyName = mssql_escape_string($_POST['CompanyName']);
			$TaxID = mssql_escape_string($_POST['TaxID']);
			$billing_firstname = mssql_escape_string($_POST['billing_firstname']);
			$billing_lastname = mssql_escape_string($_POST['billing_lastname']);
			$billing_street = mssql_escape_string($_POST['billing_street']);
			$billing_country = mssql_escape_string($_POST['billing_country']);
			$billing_city = mssql_escape_string($_POST['billing_city']);
			$billing_postcode = mssql_escape_string($_POST['billing_postcode']);
			$billing_email = mssql_escape_string($_POST['billing_email']);
			$billing_phone = mssql_escape_string($_POST['billing_phone']);
			$billing_Username = mssql_escape_string($_POST['billing_Username']);
			$billing_Password = mssql_escape_string($_POST['billing_Password']);
			
			$conn = sqlsrv_connect($__CONFIG['SQLHost'], array("Database"=>$__CONFIG['SQLDB'], "UID"=>$__CONFIG['SQLUID'], "PWD"=>$__CONFIG['SQLPWD'], "CharacterSet" => "UTF-8"));
			if(!$conn){
			echo print_r(sqlsrv_errors(), true);
			}else{
			If ($Comp_select == 0){
				If ($billing_Username != '' AND $billing_Password != '' AND $billing_firstname != '' AND $billing_lastname != '' AND $billing_street != '' AND $billing_country != '' AND $billing_city != '' AND $billing_postcode != '' AND $billing_email != '' AND $billing_phone != ''){
					if(filter_var($billing_email, FILTER_VALIDATE_EMAIL)){
						if (strpos($billing_email,'trbvm') !== false) {
								//echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Du kannst diesen E-mail Service nicht benutzen.</div>';
						}else{
							$RandomTok = RandomToken(32);
							$SECPW = MD5(MD5($billing_Password).$RandomTok);
							$IPADR = getRemoteIP();
							$DISPName = $billing_firstname.' '.$billing_lastname;
							$SeaLink = $billing_Username;
							
							$checkAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE sUsername = ?;", array($billing_Username), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							if(sqlsrv_num_rows($checkAccount) == 1){	
								echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Benutzername bereits in benutzung.</div>';						
							}else{
								$checkEmail = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE sEmail = ?;", array($billing_email), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
								if(sqlsrv_num_rows($checkEmail) == 1){	
									echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>E-mail bereits in benutzung.</div>';						
								}else{
								$insertAccount = sqlsrv_query($conn, "INSERT INTO tAccounts (sUsername, sDisplayName, sSearchLink, sUserPass, sUserPassSalt, sEmail, sIP) VALUES (?, ?, ?, ?, ?, ?, ?);", array($billing_Username, $DISPName, $SeaLink, $SECPW, $RandomTok, $billing_email, $IPADR));
								if($insertAccount)
								{
									$checkNewAccount = sqlsrv_query($conn, "SELECT * FROM tAccounts WHERE sUsername = ?;", array($billing_Username), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
									if(sqlsrv_num_rows($checkNewAccount) == 1){	
										$fetchNewAccount = sqlsrv_fetch_array($checkNewAccount);
										$TCOMP = '-';
										$TTAX = '-';
										$insertProfile = sqlsrv_query($conn, "INSERT INTO tUserProfile (nUserID, Type, FirstName, LastName, CompanyName, Emailaddress, Phonenumber, Country, TaxID, StreetAddress, City, PostalCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array($fetchNewAccount['nUserID'], $Comp_select, $billing_firstname, $billing_lastname, $TCOMP, $billing_email, $billing_phone, $billing_country, $TTAX, $billing_street, $billing_city, $billing_postcode));
										if($insertProfile)
										{
											echo '<div class="alert alert-success" role="alert"><strong>Well done!</strong> Account wurde erfolgreich erstellt.</div>';	
										}else{
											$deleteAccount = sqlsrv_query($conn, "Delete tAccounts WHERE sUsername = ?;", array($billing_Username), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
										}
									}
								}else{
									echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Unknown Error.</div>';	
								}
								}
							}
						}
					}else{
						//echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Du hast eine falsche E-mail eingegeben. Die E-mail muss mindestens ein @(at) und ein .(Punkt) enthalten.</div>';
					}
				}
			}elseif ($Comp_select == 1){
				If ($billing_Username != '' AND $billing_Password != '' AND $TaxID != '' AND $CompanyName != '' AND $billing_firstname != '' AND $billing_lastname != '' AND $billing_street != '' AND $billing_country != '' AND $billing_city != '' AND $billing_postcode != '' AND $billing_email != '' AND $billing_phone != ''){
					if(filter_var($billing_email, FILTER_VALIDATE_EMAIL)){
						if (strpos($billing_email,'trbvm') !== false) {
								//echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Du kannst diesen E-mail Service nicht benutzen.</div>';
						}else{
						echo 'Comp 1';	
						}
					}else{
						//echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Du hast eine falsche E-mail eingegeben. Die E-mail muss mindestens ein @(at) und ein .(Punkt) enthalten.</div>';
					}
				}	
			}
			}
			
			If ($Comp_select == 1){
				If ($CompanyName == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bite trage deinen Firmennamen ein.</div>';
				}
				If ($TaxID == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bite trage deine Tax ID / Steuernummer ein.</div>';
				}
			}
			
			If ($billing_Username == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deinen Benutzernamen ein.</div>';
			}
			
			If ($billing_Password == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deinen Passwort ein.</div>';
			}

			If ($billing_firstname == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deinen Vornamen ein.</div>';
			}
			
			If ($billing_lastname == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deinen Nachnamen ein.</div>';
			}
			
			If ($billing_street == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deine Adresse ein.</div>';
			}
			
			If ($billing_country == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte wähle dein Herkunftsland aus.</div>';
			}
			
			If ($billing_city == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deine Stadt ein.</div>';
			}
			
			If ($billing_postcode == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deine Postleitzahl ein.</div>';
			}
			
			If ($billing_email == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deine E-Mail-Adresse ein.</div>';
			}
			
			if(filter_var($billing_email, FILTER_VALIDATE_EMAIL)){
				if (strpos($billing_email,'trbvm') !== false) {
						echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Du kannst diesen E-mail Service nicht benutzen.</div>';
				}
			}else{
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Du hast eine falsche E-mail eingegeben. Die E-mail muss mindestens ein @(at) und ein .(Punkt) enthalten.</div>';
			}
			
			If ($billing_phone == ''){
				echo '<div class="alert alert-warning" role="alert"><strong>Warning!</strong>Bitte trage deine Telefonnummer ein.</div>';
			}
			
			
		}
		
		?>
		
		
		<!-- SeLect -->
		 <p><?php echo $RWAY;?>?:</p>
		<label class="youplay-select">
		<select id="Comp_select" name="Comp_select" onchange="showCompDiv(this)">
			<option value="0" ><?php echo $RIND;?></option>
			<option value ="1"><?php echo $RCOMP;?></option>
		</select>
		</label>
		<!-- SeLect -->			

			<div id="Company_div" style="display: none;">
				<div class="row">
					<div class="col-md-6">
						  <p><?php echo $RCOMPN;?></p>
						  <div class="youplay-input">
						  <input type="text" name="CompanyName" placeholder="<?php echo $RCOMPN;?>">
						  </div>
					 </div>
					 
					<div class="col-md-6">
						  <p><?php echo $RTAXID;?></p>
						  <div class="youplay-input">
						  <input type="text" name="TaxID" placeholder="<?php echo $RTAXID;?>">
						  </div>
					 </div>  
				 </div> 
			</div>
		
		
		
        <div class="row">
          <div class="col-md-6">
            <p><?php echo $RFN;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_firstname" placeholder="<?php echo $RFN;?>">
            </div>
          </div>
          <div class="col-md-6">
            <p><?php echo $RLN;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_lastname" placeholder="<?php echo $RLN;?>">
            </div>
          </div>
        </div>
		<div class="row">
          <div class="col-md-6">
            <p><?php echo $RUN;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_Username" placeholder="<?php echo $RUN;?>">
            </div>
          </div>
          <div class="col-md-6">
            <p><?php echo $RPW;?>:</p>
            <div class="youplay-input">
              <input type="password" name="billing_Password" placeholder="<?php echo $RPW;?>">
            </div>
          </div>
        </div>
			<br></br>

		
		
       
        <div class="row">
          <div class="col-md-6">
		   <p><?php echo $RADR;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_street" placeholder="<?php echo $RADR;?>">
            </div>
          </div>
          <div class="col-md-6">
			<p><?php echo $RCOUNT;?>:</p>
			<div class="youplay-select">
			  <select name="billing_country">
				<option value=""><?php echo $RSCOUNT; ?></option>
				<option value="1"<?php If(5 == 1){}?>>United States</option>
				<option value="2"<?php If(5 == 2){}?>>Canada</option>
				<option value="3"<?php If(5 == 3){}?>>Afghanistan</option>
				<option value="4"<?php If(5 == 4){}?>>Albania</option>
				<option value="5"<?php If(5 == 5){}?>>Algeria</option>
				<option value="6"<?php If(5 == 6){}?>>American Samoa</option>
				<option value="7"<?php If(5 == 7){}?>>Andorra</option>
				<option value="8"<?php If(5 == 8){}?>>Angola</option>
				<option value="9"<?php If(5 == 9){}?>>Anguilla</option>
				<option value="10"<?php If(5 == 10){}?>>Antigua and Barbuda</option>
				<option value="11"<?php If(5 == 11){}?>>Argentina</option>
				<option value="12"<?php If(5 == 12){}?>>Armenia</option>
				<option value="233"<?php If(5 == 233){}?>>Aruba</option>
				<option value="14"<?php If(5 == 14){}?>>Australia</option>
				<option value="15"<?php If(5 == 15){}?>>Austria</option>
				<option value="16"<?php If(5 == 16){}?>>Azerbaijan</option>
				<option value="17"<?php If(5 == 17){}?>>Bahamas</option>
				<option value="18"<?php If(5 == 18){}?>>Bahrain</option>
				<option value="19"<?php If(5 == 19){}?>>Bangladesh</option>
				<option value="20"<?php If(5 == 20){}?>>Barbados</option>
				<option value="21"<?php If(5 == 21){}?>>Belarus</option>
				<option value="22"<?php If(5 == 22){}?>>Belgium</option>
				<option value="23"<?php If(5 == 23){}?>>Belize</option>
				<option value="24"<?php If(5 == 24){}?>>Benin</option>
				<option value="25"<?php If(5 == 25){}?>>Bermuda</option>
				<option value="26"<?php If(5 == 26){}?>>Bhutan</option>
				<option value="27"<?php If(5 == 27){}?>>Bolivia</option>
				<option value="28"<?php If(5 == 28){}?>>Bosnia and Herzegovina</option>
				<option value="29"<?php If(5 == 29){}?>>Botswana</option>
				<option value="30"<?php If(5 == 30){}?>>Brazil</option>
				<option value="31"<?php If(5 == 31){}?>>British Indian Ocean Territory</option>
				<option value="32"<?php If(5 == 32){}?>>Brunei Darussalam</option>
				<option value="33"<?php If(5 == 33){}?>>Bulgaria</option>
				<option value="34"<?php If(5 == 34){}?>>Burkina Faso</option>
				<option value="35"<?php If(5 == 35){}?>>Burundi</option>
				<option value="36"<?php If(5 == 36){}?>>Cameroon</option>
				<option value="37"<?php If(5 == 37){}?>>Cambodia</option>
				<option value="39"<?php If(5 == 39){}?>>Cape Verde</option>
				<option value="40"<?php If(5 == 40){}?>>Cayman Islands</option>
				<option value="41"<?php If(5 == 41){}?>>Central African Republic</option>
				<option value="42"<?php If(5 == 42){}?>>Chad</option>
				<option value="43"<?php If(5 == 43){}?>>Chile</option>
				<option value="44"<?php If(5 == 44){}?>>China</option>
				<option value="45"<?php If(5 == 45){}?>>Colombia</option>
				<option value="46"<?php If(5 == 46){}?>>Comoros</option>
				<option value="47"<?php If(5 == 47){}?>>Congo</option>
				<option value="48"<?php If(5 == 48){}?>>Cook Islands</option>
				<option value="49"<?php If(5 == 49){}?>>Costa Rica</option>
				<option value="50"<?php If(5 == 50){}?>>Cote d'Ivoire</option>
				<option value="51"<?php If(5 == 51){}?>>Croatia</option>
				<option value="52"<?php If(5 == 52){}?>>Cuba</option>
				<option value="53"<?php If(5 == 53){}?>>Cyprus</option>
				<option value="54"<?php If(5 == 54){}?>>Czech Republic</option>
				<option value="55"<?php If(5 == 55){}?>>Denmark</option>
				<option value="56"<?php If(5 == 56){}?>>Djibouti</option>
				<option value="57"<?php If(5 == 57){}?>>Dominica</option>
				<option value="58"<?php If(5 == 58){}?>>Dominican Republic</option>
				<option value="59"<?php If(5 == 59){}?>>Ecuador</option>
				<option value="60"<?php If(5 == 60){}?>>Egypt</option>
				<option value="61"<?php If(5 == 61){}?>>El Salvador</option>
				<option value="62"<?php If(5 == 62){}?>>Equatorial Guinea</option>
				<option value="63"<?php If(5 == 63){}?>>Eritrea</option>
				<option value="64"<?php If(5 == 64){}?>>Estonia</option>
				<option value="65"<?php If(5 == 65){}?>>Ethiopia</option>
				<option value="66"<?php If(5 == 66){}?>>Falkland Islands</option>
				<option value="67"<?php If(5 == 67){}?>>Faroe Islands</option>
				<option value="68"<?php If(5 == 68){}?>>Federated States of Micronesia</option>
				<option value="69"<?php If(5 == 69){}?>>Fiji</option>
				<option value="70"<?php If(5 == 70){}?>>Finland</option>
				<option value="71"<?php If(5 == 71){}?>>France</option>
				<option value="72"<?php If(5 == 72){}?>>French Guiana</option>
				<option value="73"<?php If(5 == 73){}?>>French Polynesia</option>
				<option value="74"<?php If(5 == 74){}?>>Gabon</option>
				<option value="75"<?php If(5 == 75){}?>>Georgia</option>
				<option value="76"<?php If(5 == 76){}?>>Germany</option>
				<option value="77"<?php If(5 == 77){}?>>Ghana</option>
				<option value="78"<?php If(5 == 78){}?>>Gibraltar</option>
				<option value="79"<?php If(5 == 79){}?>>Greece</option>
				<option value="80"<?php If(5 == 80){}?>>Greenland</option>
				<option value="81"<?php If(5 == 81){}?>>Grenada</option>
				<option value="82"<?php If(5 == 82){}?>>Guadeloupe</option>
				<option value="83"<?php If(5 == 83){}?>>Guam</option>
				<option value="84"<?php If(5 == 84){}?>>Guatemala</option>
				<option value="85"<?php If(5 == 85){}?>>Guinea</option>
				<option value="86"<?php If(5 == 86){}?>>Guinea-Bissau</option>
				<option value="87"<?php If(5 == 87){}?>>Guyana</option>
				<option value="88"<?php If(5 == 88){}?>>Haiti</option>
				<option value="89"<?php If(5 == 89){}?>>Honduras</option>
				<option value="90"<?php If(5 == 90){}?>>Hong Kong</option>
				<option value="91"<?php If(5 == 91){}?>>Hungary</option>
				<option value="92"<?php If(5 == 92){}?>>Iceland</option>
				<option value="93"<?php If(5 == 93){}?>>India</option>
				<option value="94"<?php If(5 == 94){}?>>Indonesia</option>
				<option value="95"<?php If(5 == 95){}?>>Iran</option>
				<option value="96"<?php If(5 == 96){}?>>Iraq</option>
				<option value="97"<?php If(5 == 97){}?>>Ireland</option>
				<option value="98"<?php If(5 == 98){}?>>Isle of Man</option>
				<option value="99"<?php If(5 == 99){}?>>Israel</option>
				<option value="100"<?php If(5 == 100){}?>>Italy</option>
				<option value="101"<?php If(5 == 101){}?>>Jamaica</option>
				<option value="102"<?php If(5 == 102){}?>>Japan</option>
				<option value="103"<?php If(5 == 103){}?>>Jordan</option>
				<option value="104"<?php If(5 == 104){}?>>Kazakhstan</option>
				<option value="105"<?php If(5 == 105){}?>>Kenya</option>
				<option value="106"<?php If(5 == 106){}?>>Kiribati</option>
				<option value="107"<?php If(5 == 107){}?>>Korea (Peoples Republic of)</option>
				<option value="108"<?php If(5 == 108){}?>>Korea (Republic of)</option>
				<option value="109"<?php If(5 == 109){}?>>Kuwait</option>
				<option value="110"<?php If(5 == 110){}?>>Kyrgyzstan</option>
				<option value="111"<?php If(5 == 111){}?>>Laos</option>
				<option value="112"<?php If(5 == 112){}?>>Latvia</option>
				<option value="113"<?php If(5 == 113){}?>>Lebanon</option>
				<option value="114"<?php If(5 == 114){}?>>Lesotho</option>
				<option value="115"<?php If(5 == 115){}?>>Liberia</option>
				<option value="116"<?php If(5 == 116){}?>>Libya</option>
				<option value="117"<?php If(5 == 117){}?>>Liechtenstein</option>
				<option value="118"<?php If(5 == 118){}?>>Lithuania</option>
				<option value="119"<?php If(5 == 119){}?>>Luxembourg</option>
				<option value="120"<?php If(5 == 120){}?>>Macau</option>
				<option value="121"<?php If(5 == 121){}?>>Macedonia</option>
				<option value="122"<?php If(5 == 122){}?>>Madagascar</option>
				<option value="123"<?php If(5 == 123){}?>>Malawi</option>
				<option value="124"<?php If(5 == 124){}?>>Malaysia</option>
				<option value="125"<?php If(5 == 125){}?>>Maldives</option>
				<option value="126"<?php If(5 == 126){}?>>Mali</option>
				<option value="127"<?php If(5 == 127){}?>>Malta</option>
				<option value="128"<?php If(5 == 128){}?>>Marshall Islands</option>
				<option value="129"<?php If(5 == 129){}?>>Martinique</option>
				<option value="130"<?php If(5 == 130){}?>>Mauritius</option>
				<option value="232"<?php If(5 ==	232){}?>>Mauritania</option>
				<option value="131"<?php If(5 == 131){}?>>Mayotte</option>
				<option value="132"<?php If(5 == 132){}?>>Mexico</option>
				<option value="133"<?php If(5 == 133){}?>>Moldova</option>
				<option value="134"<?php If(5 == 134){}?>>Monaco</option>
				<option value="135"<?php If(5 == 135){}?>>Mongolia</option>
				<option value="136"<?php If(5 == 136){}?>>Montenegro</option>
				<option value="137"<?php If(5 == 137){}?>>Montserrat</option>
				<option value="138"<?php If(5 == 138){}?>>Morocco</option>
				<option value="139"<?php If(5 == 139){}?>>Mozambique</option>
				<option value="140"<?php If(5 == 140){}?>>Myanmar</option>
				<option value="141"<?php If(5 == 141){}?>>Namibia</option>
				<option value="142"<?php If(5 == 142){}?>>Nauru</option>
				<option value="143"<?php If(5 == 143){}?>>Nepal</option>
				<option value="144"<?php If(5 == 144){}?>>Netherlands</option>
				<option value="145"<?php If(5 == 145){}?>>Netherlands Antilles</option>
				<option value="146"<?php If(5 == 146){}?>>New Caledonia</option>
				<option value="147"<?php If(5 == 147){}?>>New Zealand</option>
				<option value="148"<?php If(5 == 148){}?>>Nicaragua</option>
				<option value="149"<?php If(5 == 149){}?>>Niger</option>
				<option value="150"<?php If(5 == 150){}?>>Nigeria</option>
				<option value="151"<?php If(5 == 151){}?>>Niue</option>
				<option value="152"<?php If(5 == 152){}?>>Norfolk Island</option>
				<option value="153"<?php If(5 == 153){}?>>Northern Mariana Islands</option>
				<option value="154"<?php If(5 == 154){}?>>Norway</option>
				<option value="155"<?php If(5 == 155){}?>>Oman</option>
				<option value="156"<?php If(5 == 156){}?>>Pakistan</option>
				<option value="157"<?php If(5 == 157){}?>>Palau</option>
				<option value="231"<?php If(5 ==	231){}?>>Palestinian Territory</option>
				<option value="158"<?php If(5 == 158){}?>>Panama</option>
				<option value="159"<?php If(5 == 159){}?>>Papua New Guinea</option>
				<option value="160"<?php If(5 == 160){}?>>Paraguay</option>
				<option value="161"<?php If(5 == 161){}?>>Peru</option>
				<option value="162"<?php If(5 == 162){}?>>Philippines</option>
				<option value="163"<?php If(5 == 163){}?>>Pitcairn</option>
				<option value="164"<?php If(5 == 164){}?>>Poland</option>
				<option value="165"<?php If(5 == 165){}?>>Portugal</option>
				<option value="166"<?php If(5 == 166){}?>>Puerto Rico</option>
				<option value="167"<?php If(5 == 167){}?>>Qatar</option>
				<option value="168"<?php If(5 == 168){}?>>Reunion</option>
				<option value="169"<?php If(5 == 169){}?>>Romania</option>
				<option value="170"<?php If(5 == 170){}?>>Russia</option>
				<option value="171"<?php If(5 == 171){}?>>Rwanda</option>
				<option value="172"<?php If(5 == 172){}?>>Saint Vincent and the Grenadines</option>
				<option value="173"<?php If(5 == 173){}?>>San Marino</option>
				<option value="174"<?php If(5 == 174){}?>>Sao Tome and Principe</option>
				<option value="175"<?php If(5 == 175){}?>>Saudi Arabia</option>
				<option value="176"<?php If(5 == 176){}?>>Senegal</option>
				<option value="177"<?php If(5 == 177){}?>>Serbia</option>
				<option value="178"<?php If(5 == 178){}?>>Seychelles</option>
				<option value="179"<?php If(5 == 179){}?>>Sierra Leone</option>
				<option value="180"<?php If(5 == 180){}?>>Singapore</option>
				<option value="181"<?php If(5 == 181){}?>>Slovakia</option>
				<option value="182"<?php If(5 == 182){}?>>Slovenia</option>
				<option value="183"<?php If(5 == 183){}?>>Solomon Islands</option>
				<option value="184"<?php If(5 == 184){}?>>Somalia</option>
				<option value="185"<?php If(5 == 185){}?>>South Africa</option>
				<option value="186"<?php If(5 == 186){}?>>South Georgia</option>
				<option value="187"<?php If(5 == 187){}?>>Spain</option>
				<option value="188"<?php If(5 == 188){}?>>Sri Lanka</option>
				<option value="189"<?php If(5 == 189){}?>>St. Kitts and Nevis</option>
				<option value="190"<?php If(5 == 190){}?>>St. Lucia</option>
				<option value="191"<?php If(5 == 191){}?>>St. Pierre and Miquelon</option>
				<option value="192"<?php If(5 == 192){}?>>Sudan</option>
				<option value="193"<?php If(5 == 193){}?>>Suriname</option>
				<option value="194"<?php If(5 == 194){}?>>Swaziland</option>
				<option value="195"<?php If(5 == 195){}?>>Sweden</option>
				<option value="196"<?php If(5 == 196){}?>>Switzerland</option>
				<option value="197"<?php If(5 == 197){}?>>Syrian Arab Republic</option>
				<option value="198"<?php If(5 == 198){}?>>Taiwan</option>
				<option value="199"<?php If(5 == 199){}?>>Tajikistan</option>
				<option value="200"<?php If(5 == 200){}?>>Tanzania</option>
				<option value="201"<?php If(5 == 201){}?>>Thailand</option>
				<option value="202"<?php If(5 == 202){}?>>Gambia</option>
				<option value="203"<?php If(5 == 203){}?>>Togo</option>
				<option value="204"<?php If(5 == 204){}?>>Tokelau</option>
				<option value="205"<?php If(5 == 205){}?>>Tonga</option>
				<option value="206"<?php If(5 ==	206){}?>>Trinidad and Tobago</option>
				<option value="207"<?php If(5 == 207){}?>>Tunisia</option>
				<option value="208"<?php If(5 == 208){}?>>Turkey</option>
				<option value="209"<?php If(5 == 209){}?>>Turkmenistan</option>
				<option value="210"<?php If(5 == 210){}?>>Turks and Caicos Islands</option>
				<option value="211"<?php If(5 == 211){}?>>Tuvalu</option>
				<option value="212"<?php If(5 == 212){}?>>Uganda</option>
				<option value="213"<?php If(5 == 213){}?>>Ukraine</option>
				<option value="214"<?php If(5 == 214){}?>>United Arab Emirates</option>
				<option value="215"<?php If(5 == 215){}?>>United Kingdom</option>
				<option value="216"<?php If(5 == 216){}?>>Uruguay</option>
				<option value="217"<?php If(5 == 217){}?>>Uzbekistan</option>
				<option value="218"<?php If(5 == 218){}?>>Vanuatu</option>
				<option value="219"<?php If(5 == 219){}?>>Venezuela</option>
				<option value="220"<?php If(5 == 220){}?>>Vietnam</option>
				<option value="221"<?php If(5 == 221){}?>>Virgin Islands (U.K.)</option>
				<option value="222"<?php If(5 == 222){}?>>Virgin Islands (U.S.)</option>
				<option value="223"<?php If(5 == 223){}?>>Wallis and Futuna Islands</option>
				<option value="224"<?php If(5 == 224){}?>>Western Samoa</option>
				<option value="225"<?php If(5 == 225){}?>>Yemen</option>
				<option value="227"<?php If(5 == 227){}?>>Congo The Democratic Republic of the</option>
				<option value="228"<?php If(5 == 228){}?>>Zambia</option>
				<option value="229"<?php If(5 == 229){}?>>Zimbabwe</option>
				<option value="230"<?php If(5 == 230){}?>>Western Sahara</option>
				<option value="13"<?php If(5 == 13){}?>>Saint Helena</option>
				<option value="234"<?php If(5 == 234){}?>>Kosovo</option>
			  </select>
			</div>
            </div>
         
        </div>

        <div class="row">
          <div class="col-md-6">
            <p><?php echo $RCITY;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_city" placeholder="<?php echo $RCITY;?>">
            </div>
          </div>
          <div class="col-md-6">
            <p><?php echo $RPOCO;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_postcode" placeholder="<?php echo $RPOCO;?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <p><?php echo $REMAIL;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_email" placeholder="<?php echo $REMAIL;?>">
            </div>
          </div>
          <div class="col-md-6">
            <p><?php echo $RPhone;?>:</p>
            <div class="youplay-input">
              <input type="text" name="billing_phone" placeholder="<?php echo $RPhone;?>">
            </div>
          </div>
        </div>


        
        <div class="align-right">
         <button type="submit" name="BtnReg" class="btn btn-default"><?php echo $RBUTTON;?></button>
        </div>
                   
	
      </div>
	</form>
	  
    </div>

  </section>
  <!-- /Main Content -->
  
      <!-- Footer -->
	 <?php include 'Include/Footer.php'; ?>
    <!-- /Footer -->

  			<script type="text/javascript">		
				function showCompDiv(elem){
				   if(elem.value == 1){
						document.getElementById('Company_div').style.display = "block";
				   }else{
					   document.getElementById('Company_div').style.display = "none";
				   }
					 
				}
			</script>
  
  

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