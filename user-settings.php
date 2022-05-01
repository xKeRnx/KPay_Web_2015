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
		<form id="UpdateSettings" method="post">
         <h3 class="mt-40 mb-20">Payment Recipient</h3>
		<table class="table table-bordered">
			<tbody>	
			<?php
			if (isset($_GET['s'])) {
				If ($_GET['s'] == 'True'){
					echo '<div class="alert alert-success" role="alert"><strong>Well done!</strong> Your data has been successfully saved.</div>';	
			   
				}elseif ($_GET['s'] == 'False'){
					echo '<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong>Something went wrong. Please try again later.</div>';
				}
			}
			?>
				<tr>
					<td style="width: 300px;">
					  <p>Who are you?</p>
					</td>
					<td>			
						<select id="Comp_select" name="Comp_select" onchange="showCompDiv(this)">
						   <option value="0" <?php If($fetchProfile['Type'] == 0){echo 'Selected';}?>>Individual</option>
						   <option value ="1" <?php If($fetchProfile['Type'] == 1){echo 'Selected';}?>>Company</option>
						</select>
					</td>
				</tr>
		 	</tbody>
		</table>
		<div id="Company_div" style="display: none;">
			<table class="table table-bordered">
				<tbody>
				 <tr>
					<td style="width: 300px;">
					  <p>Company Name</p>
					</td>
					<td>
					  <input type="text" name="CompanyName" Value="<?php echo $fetchProfile['CompanyName']; ?>">
					</td>
				  </tr>
				  <tr>
					<td>
					  <p>Identification number/Tax ID number</p>
					</td>
					<td>
					  <input type="text" name="TaxID" Value="<?php echo $fetchProfile['TaxID']; ?>">
					</td>
				  </tr>
				</tbody>
			</table>
		</div>
		 
		 
          <table class="table table-bordered">
            <tbody>
              <tr>
               <td style="width: 300px;">
                  <p>First Name</p>
                </td>
                <td>
				  <input type="text" name="FirstName" Value="<?php echo $fetchProfile['FirstName']; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <p>Last Name</p>
                </td>
                <td>
				<input type="text" name="LastName" Value="<?php echo $fetchProfile['LastName']; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <p>Email address</p>
                </td>
                <td>
				  <input type="text" name="Emailaddress" Value="<?php echo $fetchProfile['Emailaddress']; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <p>Phone number</p>
                </td>
                <td>
				  <input type="text" name="Phonenumber" Value="<?php echo $fetchProfile['Phonenumber']; ?>">
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
				<select name="SelectedCountry" id="SelectedCountry">
				<option value="0"<?php If($fetchProfile['Country'] == 0){echo 'Selected';}?>></option>
				<option value="1"<?php If($fetchProfile['Country'] == 1){echo 'Selected';}?>>United States</option>
				<option value="2"<?php If($fetchProfile['Country'] == 2){echo 'Selected';}?>>Canada</option>
				<option value="3"<?php If($fetchProfile['Country'] == 3){echo 'Selected';}?>>Afghanistan</option>
				<option value="4"<?php If($fetchProfile['Country'] == 4){echo 'Selected';}?>>Albania</option>
				<option value="5"<?php If($fetchProfile['Country'] == 5){echo 'Selected';}?>>Algeria</option>
				<option value="6"<?php If($fetchProfile['Country'] == 6){echo 'Selected';}?>>American Samoa</option>
				<option value="7"<?php If($fetchProfile['Country'] == 7){echo 'Selected';}?>>Andorra</option>
				<option value="8"<?php If($fetchProfile['Country'] == 8){echo 'Selected';}?>>Angola</option>
				<option value="9"<?php If($fetchProfile['Country'] == 9){echo 'Selected';}?>>Anguilla</option>
				<option value="10"<?php If($fetchProfile['Country'] == 10){echo 'Selected';}?>>Antigua and Barbuda</option>
				<option value="11"<?php If($fetchProfile['Country'] == 11){echo 'Selected';}?>>Argentina</option>
				<option value="12"<?php If($fetchProfile['Country'] == 12){echo 'Selected';}?>>Armenia</option>
				<option value="233"<?php If($fetchProfile['Country'] == 233){echo 'Selected';}?>>Aruba</option>
				<option value="14"<?php If($fetchProfile['Country'] == 14){echo 'Selected';}?>>Australia</option>
				<option value="15"<?php If($fetchProfile['Country'] == 15){echo 'Selected';}?>>Austria</option>
				<option value="16"<?php If($fetchProfile['Country'] == 16){echo 'Selected';}?>>Azerbaijan</option>
				<option value="17"<?php If($fetchProfile['Country'] == 17){echo 'Selected';}?>>Bahamas</option>
				<option value="18"<?php If($fetchProfile['Country'] == 18){echo 'Selected';}?>>Bahrain</option>
				<option value="19"<?php If($fetchProfile['Country'] == 19){echo 'Selected';}?>>Bangladesh</option>
				<option value="20"<?php If($fetchProfile['Country'] == 20){echo 'Selected';}?>>Barbados</option>
				<option value="21"<?php If($fetchProfile['Country'] == 21){echo 'Selected';}?>>Belarus</option>
				<option value="22"<?php If($fetchProfile['Country'] == 22){echo 'Selected';}?>>Belgium</option>
				<option value="23"<?php If($fetchProfile['Country'] == 23){echo 'Selected';}?>>Belize</option>
				<option value="24"<?php If($fetchProfile['Country'] == 24){echo 'Selected';}?>>Benin</option>
				<option value="25"<?php If($fetchProfile['Country'] == 25){echo 'Selected';}?>>Bermuda</option>
				<option value="26"<?php If($fetchProfile['Country'] == 26){echo 'Selected';}?>>Bhutan</option>
				<option value="27"<?php If($fetchProfile['Country'] == 27){echo 'Selected';}?>>Bolivia</option>
				<option value="28"<?php If($fetchProfile['Country'] == 28){echo 'Selected';}?>>Bosnia and Herzegovina</option>
				<option value="29"<?php If($fetchProfile['Country'] == 29){echo 'Selected';}?>>Botswana</option>
				<option value="30"<?php If($fetchProfile['Country'] == 30){echo 'Selected';}?>>Brazil</option>
				<option value="31"<?php If($fetchProfile['Country'] == 31){echo 'Selected';}?>>British Indian Ocean Territory</option>
				<option value="32"<?php If($fetchProfile['Country'] == 32){echo 'Selected';}?>>Brunei Darussalam</option>
				<option value="33"<?php If($fetchProfile['Country'] == 33){echo 'Selected';}?>>Bulgaria</option>
				<option value="34"<?php If($fetchProfile['Country'] == 34){echo 'Selected';}?>>Burkina Faso</option>
				<option value="35"<?php If($fetchProfile['Country'] == 35){echo 'Selected';}?>>Burundi</option>
				<option value="36"<?php If($fetchProfile['Country'] == 36){echo 'Selected';}?>>Cameroon</option>
				<option value="37"<?php If($fetchProfile['Country'] == 37){echo 'Selected';}?>>Cambodia</option>
				<option value="39"<?php If($fetchProfile['Country'] == 39){echo 'Selected';}?>>Cape Verde</option>
				<option value="40"<?php If($fetchProfile['Country'] == 40){echo 'Selected';}?>>Cayman Islands</option>
				<option value="41"<?php If($fetchProfile['Country'] == 41){echo 'Selected';}?>>Central African Republic</option>
				<option value="42"<?php If($fetchProfile['Country'] == 42){echo 'Selected';}?>>Chad</option>
				<option value="43"<?php If($fetchProfile['Country'] == 43){echo 'Selected';}?>>Chile</option>
				<option value="44"<?php If($fetchProfile['Country'] == 44){echo 'Selected';}?>>China</option>
				<option value="45"<?php If($fetchProfile['Country'] == 45){echo 'Selected';}?>>Colombia</option>
				<option value="46"<?php If($fetchProfile['Country'] == 46){echo 'Selected';}?>>Comoros</option>
				<option value="47"<?php If($fetchProfile['Country'] == 47){echo 'Selected';}?>>Congo</option>
				<option value="48"<?php If($fetchProfile['Country'] == 48){echo 'Selected';}?>>Cook Islands</option>
				<option value="49"<?php If($fetchProfile['Country'] == 49){echo 'Selected';}?>>Costa Rica</option>
				<option value="50"<?php If($fetchProfile['Country'] == 50){echo 'Selected';}?>>Cote d'Ivoire</option>
				<option value="51"<?php If($fetchProfile['Country'] == 51){echo 'Selected';}?>>Croatia</option>
				<option value="52"<?php If($fetchProfile['Country'] == 52){echo 'Selected';}?>>Cuba</option>
				<option value="53"<?php If($fetchProfile['Country'] == 53){echo 'Selected';}?>>Cyprus</option>
				<option value="54"<?php If($fetchProfile['Country'] == 54){echo 'Selected';}?>>Czech Republic</option>
				<option value="55"<?php If($fetchProfile['Country'] == 55){echo 'Selected';}?>>Denmark</option>
				<option value="56"<?php If($fetchProfile['Country'] == 56){echo 'Selected';}?>>Djibouti</option>
				<option value="57"<?php If($fetchProfile['Country'] == 57){echo 'Selected';}?>>Dominica</option>
				<option value="58"<?php If($fetchProfile['Country'] == 58){echo 'Selected';}?>>Dominican Republic</option>
				<option value="59"<?php If($fetchProfile['Country'] == 59){echo 'Selected';}?>>Ecuador</option>
				<option value="60"<?php If($fetchProfile['Country'] == 60){echo 'Selected';}?>>Egypt</option>
				<option value="61"<?php If($fetchProfile['Country'] == 61){echo 'Selected';}?>>El Salvador</option>
				<option value="62"<?php If($fetchProfile['Country'] == 62){echo 'Selected';}?>>Equatorial Guinea</option>
				<option value="63"<?php If($fetchProfile['Country'] == 63){echo 'Selected';}?>>Eritrea</option>
				<option value="64"<?php If($fetchProfile['Country'] == 64){echo 'Selected';}?>>Estonia</option>
				<option value="65"<?php If($fetchProfile['Country'] == 65){echo 'Selected';}?>>Ethiopia</option>
				<option value="66"<?php If($fetchProfile['Country'] == 66){echo 'Selected';}?>>Falkland Islands</option>
				<option value="67"<?php If($fetchProfile['Country'] == 67){echo 'Selected';}?>>Faroe Islands</option>
				<option value="68"<?php If($fetchProfile['Country'] == 68){echo 'Selected';}?>>Federated States of Micronesia</option>
				<option value="69"<?php If($fetchProfile['Country'] == 69){echo 'Selected';}?>>Fiji</option>
				<option value="70"<?php If($fetchProfile['Country'] == 70){echo 'Selected';}?>>Finland</option>
				<option value="71"<?php If($fetchProfile['Country'] == 71){echo 'Selected';}?>>France</option>
				<option value="72"<?php If($fetchProfile['Country'] == 72){echo 'Selected';}?>>French Guiana</option>
				<option value="73"<?php If($fetchProfile['Country'] == 73){echo 'Selected';}?>>French Polynesia</option>
				<option value="74"<?php If($fetchProfile['Country'] == 74){echo 'Selected';}?>>Gabon</option>
				<option value="75"<?php If($fetchProfile['Country'] == 75){echo 'Selected';}?>>Georgia</option>
				<option value="76"<?php If($fetchProfile['Country'] == 76){echo 'Selected';}?>>Germany</option>
				<option value="77"<?php If($fetchProfile['Country'] == 77){echo 'Selected';}?>>Ghana</option>
				<option value="78"<?php If($fetchProfile['Country'] == 78){echo 'Selected';}?>>Gibraltar</option>
				<option value="79"<?php If($fetchProfile['Country'] == 79){echo 'Selected';}?>>Greece</option>
				<option value="80"<?php If($fetchProfile['Country'] == 80){echo 'Selected';}?>>Greenland</option>
				<option value="81"<?php If($fetchProfile['Country'] == 81){echo 'Selected';}?>>Grenada</option>
				<option value="82"<?php If($fetchProfile['Country'] == 82){echo 'Selected';}?>>Guadeloupe</option>
				<option value="83"<?php If($fetchProfile['Country'] == 83){echo 'Selected';}?>>Guam</option>
				<option value="84"<?php If($fetchProfile['Country'] == 84){echo 'Selected';}?>>Guatemala</option>
				<option value="85"<?php If($fetchProfile['Country'] == 85){echo 'Selected';}?>>Guinea</option>
				<option value="86"<?php If($fetchProfile['Country'] == 86){echo 'Selected';}?>>Guinea-Bissau</option>
				<option value="87"<?php If($fetchProfile['Country'] == 87){echo 'Selected';}?>>Guyana</option>
				<option value="88"<?php If($fetchProfile['Country'] == 88){echo 'Selected';}?>>Haiti</option>
				<option value="89"<?php If($fetchProfile['Country'] == 89){echo 'Selected';}?>>Honduras</option>
				<option value="90"<?php If($fetchProfile['Country'] == 90){echo 'Selected';}?>>Hong Kong</option>
				<option value="91"<?php If($fetchProfile['Country'] == 91){echo 'Selected';}?>>Hungary</option>
				<option value="92"<?php If($fetchProfile['Country'] == 92){echo 'Selected';}?>>Iceland</option>
				<option value="93"<?php If($fetchProfile['Country'] == 93){echo 'Selected';}?>>India</option>
				<option value="94"<?php If($fetchProfile['Country'] == 94){echo 'Selected';}?>>Indonesia</option>
				<option value="95"<?php If($fetchProfile['Country'] == 95){echo 'Selected';}?>>Iran</option>
				<option value="96"<?php If($fetchProfile['Country'] == 96){echo 'Selected';}?>>Iraq</option>
				<option value="97"<?php If($fetchProfile['Country'] == 97){echo 'Selected';}?>>Ireland</option>
				<option value="98"<?php If($fetchProfile['Country'] == 98){echo 'Selected';}?>>Isle of Man</option>
				<option value="99"<?php If($fetchProfile['Country'] == 99){echo 'Selected';}?>>Israel</option>
				<option value="100"<?php If($fetchProfile['Country'] == 100){echo 'Selected';}?>>Italy</option>
				<option value="101"<?php If($fetchProfile['Country'] == 101){echo 'Selected';}?>>Jamaica</option>
				<option value="102"<?php If($fetchProfile['Country'] == 102){echo 'Selected';}?>>Japan</option>
				<option value="103"<?php If($fetchProfile['Country'] == 103){echo 'Selected';}?>>Jordan</option>
				<option value="104"<?php If($fetchProfile['Country'] == 104){echo 'Selected';}?>>Kazakhstan</option>
				<option value="105"<?php If($fetchProfile['Country'] == 105){echo 'Selected';}?>>Kenya</option>
				<option value="106"<?php If($fetchProfile['Country'] == 106){echo 'Selected';}?>>Kiribati</option>
				<option value="107"<?php If($fetchProfile['Country'] == 107){echo 'Selected';}?>>Korea (Peoples Republic of)</option>
				<option value="108"<?php If($fetchProfile['Country'] == 108){echo 'Selected';}?>>Korea (Republic of)</option>
				<option value="109"<?php If($fetchProfile['Country'] == 109){echo 'Selected';}?>>Kuwait</option>
				<option value="110"<?php If($fetchProfile['Country'] == 110){echo 'Selected';}?>>Kyrgyzstan</option>
				<option value="111"<?php If($fetchProfile['Country'] == 111){echo 'Selected';}?>>Laos</option>
				<option value="112"<?php If($fetchProfile['Country'] == 112){echo 'Selected';}?>>Latvia</option>
				<option value="113"<?php If($fetchProfile['Country'] == 113){echo 'Selected';}?>>Lebanon</option>
				<option value="114"<?php If($fetchProfile['Country'] == 114){echo 'Selected';}?>>Lesotho</option>
				<option value="115"<?php If($fetchProfile['Country'] == 115){echo 'Selected';}?>>Liberia</option>
				<option value="116"<?php If($fetchProfile['Country'] == 116){echo 'Selected';}?>>Libya</option>
				<option value="117"<?php If($fetchProfile['Country'] == 117){echo 'Selected';}?>>Liechtenstein</option>
				<option value="118"<?php If($fetchProfile['Country'] == 118){echo 'Selected';}?>>Lithuania</option>
				<option value="119"<?php If($fetchProfile['Country'] == 119){echo 'Selected';}?>>Luxembourg</option>
				<option value="120"<?php If($fetchProfile['Country'] == 120){echo 'Selected';}?>>Macau</option>
				<option value="121"<?php If($fetchProfile['Country'] == 121){echo 'Selected';}?>>Macedonia</option>
				<option value="122"<?php If($fetchProfile['Country'] == 122){echo 'Selected';}?>>Madagascar</option>
				<option value="123"<?php If($fetchProfile['Country'] == 123){echo 'Selected';}?>>Malawi</option>
				<option value="124"<?php If($fetchProfile['Country'] == 124){echo 'Selected';}?>>Malaysia</option>
				<option value="125"<?php If($fetchProfile['Country'] == 125){echo 'Selected';}?>>Maldives</option>
				<option value="126"<?php If($fetchProfile['Country'] == 126){echo 'Selected';}?>>Mali</option>
				<option value="127"<?php If($fetchProfile['Country'] == 127){echo 'Selected';}?>>Malta</option>
				<option value="128"<?php If($fetchProfile['Country'] == 128){echo 'Selected';}?>>Marshall Islands</option>
				<option value="129"<?php If($fetchProfile['Country'] == 129){echo 'Selected';}?>>Martinique</option>
				<option value="130"<?php If($fetchProfile['Country'] == 130){echo 'Selected';}?>>Mauritius</option>
				<option value="232"<?php If($fetchProfile['Country'] ==	232){echo 'Selected';}?>>Mauritania</option>
				<option value="131"<?php If($fetchProfile['Country'] == 131){echo 'Selected';}?>>Mayotte</option>
				<option value="132"<?php If($fetchProfile['Country'] == 132){echo 'Selected';}?>>Mexico</option>
				<option value="133"<?php If($fetchProfile['Country'] == 133){echo 'Selected';}?>>Moldova</option>
				<option value="134"<?php If($fetchProfile['Country'] == 134){echo 'Selected';}?>>Monaco</option>
				<option value="135"<?php If($fetchProfile['Country'] == 135){echo 'Selected';}?>>Mongolia</option>
				<option value="136"<?php If($fetchProfile['Country'] == 136){echo 'Selected';}?>>Montenegro</option>
				<option value="137"<?php If($fetchProfile['Country'] == 137){echo 'Selected';}?>>Montserrat</option>
				<option value="138"<?php If($fetchProfile['Country'] == 138){echo 'Selected';}?>>Morocco</option>
				<option value="139"<?php If($fetchProfile['Country'] == 139){echo 'Selected';}?>>Mozambique</option>
				<option value="140"<?php If($fetchProfile['Country'] == 140){echo 'Selected';}?>>Myanmar</option>
				<option value="141"<?php If($fetchProfile['Country'] == 141){echo 'Selected';}?>>Namibia</option>
				<option value="142"<?php If($fetchProfile['Country'] == 142){echo 'Selected';}?>>Nauru</option>
				<option value="143"<?php If($fetchProfile['Country'] == 143){echo 'Selected';}?>>Nepal</option>
				<option value="144"<?php If($fetchProfile['Country'] == 144){echo 'Selected';}?>>Netherlands</option>
				<option value="145"<?php If($fetchProfile['Country'] == 145){echo 'Selected';}?>>Netherlands Antilles</option>
				<option value="146"<?php If($fetchProfile['Country'] == 146){echo 'Selected';}?>>New Caledonia</option>
				<option value="147"<?php If($fetchProfile['Country'] == 147){echo 'Selected';}?>>New Zealand</option>
				<option value="148"<?php If($fetchProfile['Country'] == 148){echo 'Selected';}?>>Nicaragua</option>
				<option value="149"<?php If($fetchProfile['Country'] == 149){echo 'Selected';}?>>Niger</option>
				<option value="150"<?php If($fetchProfile['Country'] == 150){echo 'Selected';}?>>Nigeria</option>
				<option value="151"<?php If($fetchProfile['Country'] == 151){echo 'Selected';}?>>Niue</option>
				<option value="152"<?php If($fetchProfile['Country'] == 152){echo 'Selected';}?>>Norfolk Island</option>
				<option value="153"<?php If($fetchProfile['Country'] == 153){echo 'Selected';}?>>Northern Mariana Islands</option>
				<option value="154"<?php If($fetchProfile['Country'] == 154){echo 'Selected';}?>>Norway</option>
				<option value="155"<?php If($fetchProfile['Country'] == 155){echo 'Selected';}?>>Oman</option>
				<option value="156"<?php If($fetchProfile['Country'] == 156){echo 'Selected';}?>>Pakistan</option>
				<option value="157"<?php If($fetchProfile['Country'] == 157){echo 'Selected';}?>>Palau</option>
				<option value="231"<?php If($fetchProfile['Country'] ==	231){echo 'Selected';}?>>Palestinian Territory</option>
				<option value="158"<?php If($fetchProfile['Country'] == 158){echo 'Selected';}?>>Panama</option>
				<option value="159"<?php If($fetchProfile['Country'] == 159){echo 'Selected';}?>>Papua New Guinea</option>
				<option value="160"<?php If($fetchProfile['Country'] == 160){echo 'Selected';}?>>Paraguay</option>
				<option value="161"<?php If($fetchProfile['Country'] == 161){echo 'Selected';}?>>Peru</option>
				<option value="162"<?php If($fetchProfile['Country'] == 162){echo 'Selected';}?>>Philippines</option>
				<option value="163"<?php If($fetchProfile['Country'] == 163){echo 'Selected';}?>>Pitcairn</option>
				<option value="164"<?php If($fetchProfile['Country'] == 164){echo 'Selected';}?>>Poland</option>
				<option value="165"<?php If($fetchProfile['Country'] == 165){echo 'Selected';}?>>Portugal</option>
				<option value="166"<?php If($fetchProfile['Country'] == 166){echo 'Selected';}?>>Puerto Rico</option>
				<option value="167"<?php If($fetchProfile['Country'] == 167){echo 'Selected';}?>>Qatar</option>
				<option value="168"<?php If($fetchProfile['Country'] == 168){echo 'Selected';}?>>Reunion</option>
				<option value="169"<?php If($fetchProfile['Country'] == 169){echo 'Selected';}?>>Romania</option>
				<option value="170"<?php If($fetchProfile['Country'] == 170){echo 'Selected';}?>>Russia</option>
				<option value="171"<?php If($fetchProfile['Country'] == 171){echo 'Selected';}?>>Rwanda</option>
				<option value="172"<?php If($fetchProfile['Country'] == 172){echo 'Selected';}?>>Saint Vincent and the Grenadines</option>
				<option value="173"<?php If($fetchProfile['Country'] == 173){echo 'Selected';}?>>San Marino</option>
				<option value="174"<?php If($fetchProfile['Country'] == 174){echo 'Selected';}?>>Sao Tome and Principe</option>
				<option value="175"<?php If($fetchProfile['Country'] == 175){echo 'Selected';}?>>Saudi Arabia</option>
				<option value="176"<?php If($fetchProfile['Country'] == 176){echo 'Selected';}?>>Senegal</option>
				<option value="177"<?php If($fetchProfile['Country'] == 177){echo 'Selected';}?>>Serbia</option>
				<option value="178"<?php If($fetchProfile['Country'] == 178){echo 'Selected';}?>>Seychelles</option>
				<option value="179"<?php If($fetchProfile['Country'] == 179){echo 'Selected';}?>>Sierra Leone</option>
				<option value="180"<?php If($fetchProfile['Country'] == 180){echo 'Selected';}?>>Singapore</option>
				<option value="181"<?php If($fetchProfile['Country'] == 181){echo 'Selected';}?>>Slovakia</option>
				<option value="182"<?php If($fetchProfile['Country'] == 182){echo 'Selected';}?>>Slovenia</option>
				<option value="183"<?php If($fetchProfile['Country'] == 183){echo 'Selected';}?>>Solomon Islands</option>
				<option value="184"<?php If($fetchProfile['Country'] == 184){echo 'Selected';}?>>Somalia</option>
				<option value="185"<?php If($fetchProfile['Country'] == 185){echo 'Selected';}?>>South Africa</option>
				<option value="186"<?php If($fetchProfile['Country'] == 186){echo 'Selected';}?>>South Georgia</option>
				<option value="187"<?php If($fetchProfile['Country'] == 187){echo 'Selected';}?>>Spain</option>
				<option value="188"<?php If($fetchProfile['Country'] == 188){echo 'Selected';}?>>Sri Lanka</option>
				<option value="189"<?php If($fetchProfile['Country'] == 189){echo 'Selected';}?>>St. Kitts and Nevis</option>
				<option value="190"<?php If($fetchProfile['Country'] == 190){echo 'Selected';}?>>St. Lucia</option>
				<option value="191"<?php If($fetchProfile['Country'] == 191){echo 'Selected';}?>>St. Pierre and Miquelon</option>
				<option value="192"<?php If($fetchProfile['Country'] == 192){echo 'Selected';}?>>Sudan</option>
				<option value="193"<?php If($fetchProfile['Country'] == 193){echo 'Selected';}?>>Suriname</option>
				<option value="194"<?php If($fetchProfile['Country'] == 194){echo 'Selected';}?>>Swaziland</option>
				<option value="195"<?php If($fetchProfile['Country'] == 195){echo 'Selected';}?>>Sweden</option>
				<option value="196"<?php If($fetchProfile['Country'] == 196){echo 'Selected';}?>>Switzerland</option>
				<option value="197"<?php If($fetchProfile['Country'] == 197){echo 'Selected';}?>>Syrian Arab Republic</option>
				<option value="198"<?php If($fetchProfile['Country'] == 198){echo 'Selected';}?>>Taiwan</option>
				<option value="199"<?php If($fetchProfile['Country'] == 199){echo 'Selected';}?>>Tajikistan</option>
				<option value="200"<?php If($fetchProfile['Country'] == 200){echo 'Selected';}?>>Tanzania</option>
				<option value="201"<?php If($fetchProfile['Country'] == 201){echo 'Selected';}?>>Thailand</option>
				<option value="202"<?php If($fetchProfile['Country'] == 202){echo 'Selected';}?>>Gambia</option>
				<option value="203"<?php If($fetchProfile['Country'] == 203){echo 'Selected';}?>>Togo</option>
				<option value="204"<?php If($fetchProfile['Country'] == 204){echo 'Selected';}?>>Tokelau</option>
				<option value="205"<?php If($fetchProfile['Country'] == 205){echo 'Selected';}?>>Tonga</option>
				<option value="206"<?php If($fetchProfile['Country'] ==	206){echo 'Selected';}?>>Trinidad and Tobago</option>
				<option value="207"<?php If($fetchProfile['Country'] == 207){echo 'Selected';}?>>Tunisia</option>
				<option value="208"<?php If($fetchProfile['Country'] == 208){echo 'Selected';}?>>Turkey</option>
				<option value="209"<?php If($fetchProfile['Country'] == 209){echo 'Selected';}?>>Turkmenistan</option>
				<option value="210"<?php If($fetchProfile['Country'] == 210){echo 'Selected';}?>>Turks and Caicos Islands</option>
				<option value="211"<?php If($fetchProfile['Country'] == 211){echo 'Selected';}?>>Tuvalu</option>
				<option value="212"<?php If($fetchProfile['Country'] == 212){echo 'Selected';}?>>Uganda</option>
				<option value="213"<?php If($fetchProfile['Country'] == 213){echo 'Selected';}?>>Ukraine</option>
				<option value="214"<?php If($fetchProfile['Country'] == 214){echo 'Selected';}?>>United Arab Emirates</option>
				<option value="215"<?php If($fetchProfile['Country'] == 215){echo 'Selected';}?>>United Kingdom</option>
				<option value="216"<?php If($fetchProfile['Country'] == 216){echo 'Selected';}?>>Uruguay</option>
				<option value="217"<?php If($fetchProfile['Country'] == 217){echo 'Selected';}?>>Uzbekistan</option>
				<option value="218"<?php If($fetchProfile['Country'] == 218){echo 'Selected';}?>>Vanuatu</option>
				<option value="219"<?php If($fetchProfile['Country'] == 219){echo 'Selected';}?>>Venezuela</option>
				<option value="220"<?php If($fetchProfile['Country'] == 220){echo 'Selected';}?>>Vietnam</option>
				<option value="221"<?php If($fetchProfile['Country'] == 221){echo 'Selected';}?>>Virgin Islands (U.K.)</option>
				<option value="222"<?php If($fetchProfile['Country'] == 222){echo 'Selected';}?>>Virgin Islands (U.S.)</option>
				<option value="223"<?php If($fetchProfile['Country'] == 223){echo 'Selected';}?>>Wallis and Futuna Islands</option>
				<option value="224"<?php If($fetchProfile['Country'] == 224){echo 'Selected';}?>>Western Samoa</option>
				<option value="225"<?php If($fetchProfile['Country'] == 225){echo 'Selected';}?>>Yemen</option>
				<option value="227"<?php If($fetchProfile['Country'] == 227){echo 'Selected';}?>>Congo The Democratic Republic of the</option>
				<option value="228"<?php If($fetchProfile['Country'] == 228){echo 'Selected';}?>>Zambia</option>
				<option value="229"<?php If($fetchProfile['Country'] == 229){echo 'Selected';}?>>Zimbabwe</option>
				<option value="230"<?php If($fetchProfile['Country'] == 230){echo 'Selected';}?>>Western Sahara</option>
				<option value="13"<?php If($fetchProfile['Country'] == 13){echo 'Selected';}?>>Saint Helena</option>
				<option value="234"<?php If($fetchProfile['Country'] == 234){echo 'Selected';}?>>Kosovo</option>
				</select>
				
                </td>
              </tr>
			    <tr>
                <td>
                  <p>Preferred Payout Method</p>
                </td>
                <td>
					<select id="PayoutMeth" name="PayoutMeth" onchange="showDiv(this)" >
					   <option value="0" <?php If ($fetchProfile['PayoutMethod'] == '0') {echo 'selected';} ?>>PayPal</option>
					   <option value ="1" <?php If ($fetchProfile['PayoutMethod'] == '1') {echo 'selected';} ?>>Bank Transfer</option>
					</select>
                </td>
              </tr>
			 </tbody>
          </table>
			<div id="payout_bank_div" style="display: none;">
			<table class="table table-bordered">
            <tbody>
			 <tr>
                 <td style="width: 300px;">
                  <p>Beneficiary Name on bank account:</p>
                </td>
                <td>
				  <input type="text" name="Nameonbank" Value="<?php echo $fetchProfile['Nameonbank']; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <p>Street Address</p>
                </td>
                <td>
				  <input type="text" name="StreetAddress" Value="<?php echo $fetchProfile['StreetAddress']; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <p>City</p>
                </td>
                <td>
				  <input type="text" name="City" Value="<?php echo $fetchProfile['City']; ?>">
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Postal Code</p>
                </td>
                <td>
				  <input type="text" name="PostalCode" Value="<?php echo $fetchProfile['PostalCode']; ?>">
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Name</p>
                </td>
                <td>
				  <input type="text" name="BankName" Value="<?php echo $fetchProfile['BankName']; ?>">
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Country</p>
                </td>
                <td>
				<select name="SelectedBankCountry" id="SelectedBankCountry">
				<option value="0"<?php If($fetchProfile['BankCountry'] == 0){echo 'Selected';}?>></option>
				<option value="1"<?php If($fetchProfile['BankCountry'] == 1){echo 'Selected';}?>>United States</option>
				<option value="2"<?php If($fetchProfile['BankCountry'] == 2){echo 'Selected';}?>>Canada</option>
				<option value="3"<?php If($fetchProfile['BankCountry'] == 3){echo 'Selected';}?>>Afghanistan</option>
				<option value="4"<?php If($fetchProfile['BankCountry'] == 4){echo 'Selected';}?>>Albania</option>
				<option value="5"<?php If($fetchProfile['BankCountry'] == 5){echo 'Selected';}?>>Algeria</option>
				<option value="6"<?php If($fetchProfile['BankCountry'] == 6){echo 'Selected';}?>>American Samoa</option>
				<option value="7"<?php If($fetchProfile['BankCountry'] == 7){echo 'Selected';}?>>Andorra</option>
				<option value="8"<?php If($fetchProfile['BankCountry'] == 8){echo 'Selected';}?>>Angola</option>
				<option value="9"<?php If($fetchProfile['BankCountry'] == 9){echo 'Selected';}?>>Anguilla</option>
				<option value="10"<?php If($fetchProfile['BankCountry'] == 10){echo 'Selected';}?>>Antigua and Barbuda</option>
				<option value="11"<?php If($fetchProfile['BankCountry'] == 11){echo 'Selected';}?>>Argentina</option>
				<option value="12"<?php If($fetchProfile['BankCountry'] == 12){echo 'Selected';}?>>Armenia</option>
				<option value="233"<?php If($fetchProfile['BankCountry'] == 233){echo 'Selected';}?>>Aruba</option>
				<option value="14"<?php If($fetchProfile['BankCountry'] == 14){echo 'Selected';}?>>Australia</option>
				<option value="15"<?php If($fetchProfile['BankCountry'] == 15){echo 'Selected';}?>>Austria</option>
				<option value="16"<?php If($fetchProfile['BankCountry'] == 16){echo 'Selected';}?>>Azerbaijan</option>
				<option value="17"<?php If($fetchProfile['BankCountry'] == 17){echo 'Selected';}?>>Bahamas</option>
				<option value="18"<?php If($fetchProfile['BankCountry'] == 18){echo 'Selected';}?>>Bahrain</option>
				<option value="19"<?php If($fetchProfile['BankCountry'] == 19){echo 'Selected';}?>>Bangladesh</option>
				<option value="20"<?php If($fetchProfile['BankCountry'] == 20){echo 'Selected';}?>>Barbados</option>
				<option value="21"<?php If($fetchProfile['BankCountry'] == 21){echo 'Selected';}?>>Belarus</option>
				<option value="22"<?php If($fetchProfile['BankCountry'] == 22){echo 'Selected';}?>>Belgium</option>
				<option value="23"<?php If($fetchProfile['BankCountry'] == 23){echo 'Selected';}?>>Belize</option>
				<option value="24"<?php If($fetchProfile['BankCountry'] == 24){echo 'Selected';}?>>Benin</option>
				<option value="25"<?php If($fetchProfile['BankCountry'] == 25){echo 'Selected';}?>>Bermuda</option>
				<option value="26"<?php If($fetchProfile['BankCountry'] == 26){echo 'Selected';}?>>Bhutan</option>
				<option value="27"<?php If($fetchProfile['BankCountry'] == 27){echo 'Selected';}?>>Bolivia</option>
				<option value="28"<?php If($fetchProfile['BankCountry'] == 28){echo 'Selected';}?>>Bosnia and Herzegovina</option>
				<option value="29"<?php If($fetchProfile['BankCountry'] == 29){echo 'Selected';}?>>Botswana</option>
				<option value="30"<?php If($fetchProfile['BankCountry'] == 30){echo 'Selected';}?>>Brazil</option>
				<option value="31"<?php If($fetchProfile['BankCountry'] == 31){echo 'Selected';}?>>British Indian Ocean Territory</option>
				<option value="32"<?php If($fetchProfile['BankCountry'] == 32){echo 'Selected';}?>>Brunei Darussalam</option>
				<option value="33"<?php If($fetchProfile['BankCountry'] == 33){echo 'Selected';}?>>Bulgaria</option>
				<option value="34"<?php If($fetchProfile['BankCountry'] == 34){echo 'Selected';}?>>Burkina Faso</option>
				<option value="35"<?php If($fetchProfile['BankCountry'] == 35){echo 'Selected';}?>>Burundi</option>
				<option value="36"<?php If($fetchProfile['BankCountry'] == 36){echo 'Selected';}?>>Cameroon</option>
				<option value="37"<?php If($fetchProfile['BankCountry'] == 37){echo 'Selected';}?>>Cambodia</option>
				<option value="39"<?php If($fetchProfile['BankCountry'] == 39){echo 'Selected';}?>>Cape Verde</option>
				<option value="40"<?php If($fetchProfile['BankCountry'] == 40){echo 'Selected';}?>>Cayman Islands</option>
				<option value="41"<?php If($fetchProfile['BankCountry'] == 41){echo 'Selected';}?>>Central African Republic</option>
				<option value="42"<?php If($fetchProfile['BankCountry'] == 42){echo 'Selected';}?>>Chad</option>
				<option value="43"<?php If($fetchProfile['BankCountry'] == 43){echo 'Selected';}?>>Chile</option>
				<option value="44"<?php If($fetchProfile['BankCountry'] == 44){echo 'Selected';}?>>China</option>
				<option value="45"<?php If($fetchProfile['BankCountry'] == 45){echo 'Selected';}?>>Colombia</option>
				<option value="46"<?php If($fetchProfile['BankCountry'] == 46){echo 'Selected';}?>>Comoros</option>
				<option value="47"<?php If($fetchProfile['BankCountry'] == 47){echo 'Selected';}?>>Congo</option>
				<option value="48"<?php If($fetchProfile['BankCountry'] == 48){echo 'Selected';}?>>Cook Islands</option>
				<option value="49"<?php If($fetchProfile['BankCountry'] == 49){echo 'Selected';}?>>Costa Rica</option>
				<option value="50"<?php If($fetchProfile['BankCountry'] == 50){echo 'Selected';}?>>Cote d'Ivoire</option>
				<option value="51"<?php If($fetchProfile['BankCountry'] == 51){echo 'Selected';}?>>Croatia</option>
				<option value="52"<?php If($fetchProfile['BankCountry'] == 52){echo 'Selected';}?>>Cuba</option>
				<option value="53"<?php If($fetchProfile['BankCountry'] == 53){echo 'Selected';}?>>Cyprus</option>
				<option value="54"<?php If($fetchProfile['BankCountry'] == 54){echo 'Selected';}?>>Czech Republic</option>
				<option value="55"<?php If($fetchProfile['BankCountry'] == 55){echo 'Selected';}?>>Denmark</option>
				<option value="56"<?php If($fetchProfile['BankCountry'] == 56){echo 'Selected';}?>>Djibouti</option>
				<option value="57"<?php If($fetchProfile['BankCountry'] == 57){echo 'Selected';}?>>Dominica</option>
				<option value="58"<?php If($fetchProfile['BankCountry'] == 58){echo 'Selected';}?>>Dominican Republic</option>
				<option value="59"<?php If($fetchProfile['BankCountry'] == 59){echo 'Selected';}?>>Ecuador</option>
				<option value="60"<?php If($fetchProfile['BankCountry'] == 60){echo 'Selected';}?>>Egypt</option>
				<option value="61"<?php If($fetchProfile['BankCountry'] == 61){echo 'Selected';}?>>El Salvador</option>
				<option value="62"<?php If($fetchProfile['BankCountry'] == 62){echo 'Selected';}?>>Equatorial Guinea</option>
				<option value="63"<?php If($fetchProfile['BankCountry'] == 63){echo 'Selected';}?>>Eritrea</option>
				<option value="64"<?php If($fetchProfile['BankCountry'] == 64){echo 'Selected';}?>>Estonia</option>
				<option value="65"<?php If($fetchProfile['BankCountry'] == 65){echo 'Selected';}?>>Ethiopia</option>
				<option value="66"<?php If($fetchProfile['BankCountry'] == 66){echo 'Selected';}?>>Falkland Islands</option>
				<option value="67"<?php If($fetchProfile['BankCountry'] == 67){echo 'Selected';}?>>Faroe Islands</option>
				<option value="68"<?php If($fetchProfile['BankCountry'] == 68){echo 'Selected';}?>>Federated States of Micronesia</option>
				<option value="69"<?php If($fetchProfile['BankCountry'] == 69){echo 'Selected';}?>>Fiji</option>
				<option value="70"<?php If($fetchProfile['BankCountry'] == 70){echo 'Selected';}?>>Finland</option>
				<option value="71"<?php If($fetchProfile['BankCountry'] == 71){echo 'Selected';}?>>France</option>
				<option value="72"<?php If($fetchProfile['BankCountry'] == 72){echo 'Selected';}?>>French Guiana</option>
				<option value="73"<?php If($fetchProfile['BankCountry'] == 73){echo 'Selected';}?>>French Polynesia</option>
				<option value="74"<?php If($fetchProfile['BankCountry'] == 74){echo 'Selected';}?>>Gabon</option>
				<option value="75"<?php If($fetchProfile['BankCountry'] == 75){echo 'Selected';}?>>Georgia</option>
				<option value="76"<?php If($fetchProfile['BankCountry'] == 76){echo 'Selected';}?>>Germany</option>
				<option value="77"<?php If($fetchProfile['BankCountry'] == 77){echo 'Selected';}?>>Ghana</option>
				<option value="78"<?php If($fetchProfile['BankCountry'] == 78){echo 'Selected';}?>>Gibraltar</option>
				<option value="79"<?php If($fetchProfile['BankCountry'] == 79){echo 'Selected';}?>>Greece</option>
				<option value="80"<?php If($fetchProfile['BankCountry'] == 80){echo 'Selected';}?>>Greenland</option>
				<option value="81"<?php If($fetchProfile['BankCountry'] == 81){echo 'Selected';}?>>Grenada</option>
				<option value="82"<?php If($fetchProfile['BankCountry'] == 82){echo 'Selected';}?>>Guadeloupe</option>
				<option value="83"<?php If($fetchProfile['BankCountry'] == 83){echo 'Selected';}?>>Guam</option>
				<option value="84"<?php If($fetchProfile['BankCountry'] == 84){echo 'Selected';}?>>Guatemala</option>
				<option value="85"<?php If($fetchProfile['BankCountry'] == 85){echo 'Selected';}?>>Guinea</option>
				<option value="86"<?php If($fetchProfile['BankCountry'] == 86){echo 'Selected';}?>>Guinea-Bissau</option>
				<option value="87"<?php If($fetchProfile['BankCountry'] == 87){echo 'Selected';}?>>Guyana</option>
				<option value="88"<?php If($fetchProfile['BankCountry'] == 88){echo 'Selected';}?>>Haiti</option>
				<option value="89"<?php If($fetchProfile['BankCountry'] == 89){echo 'Selected';}?>>Honduras</option>
				<option value="90"<?php If($fetchProfile['BankCountry'] == 90){echo 'Selected';}?>>Hong Kong</option>
				<option value="91"<?php If($fetchProfile['BankCountry'] == 91){echo 'Selected';}?>>Hungary</option>
				<option value="92"<?php If($fetchProfile['BankCountry'] == 92){echo 'Selected';}?>>Iceland</option>
				<option value="93"<?php If($fetchProfile['BankCountry'] == 93){echo 'Selected';}?>>India</option>
				<option value="94"<?php If($fetchProfile['BankCountry'] == 94){echo 'Selected';}?>>Indonesia</option>
				<option value="95"<?php If($fetchProfile['BankCountry'] == 95){echo 'Selected';}?>>Iran</option>
				<option value="96"<?php If($fetchProfile['BankCountry'] == 96){echo 'Selected';}?>>Iraq</option>
				<option value="97"<?php If($fetchProfile['BankCountry'] == 97){echo 'Selected';}?>>Ireland</option>
				<option value="98"<?php If($fetchProfile['BankCountry'] == 98){echo 'Selected';}?>>Isle of Man</option>
				<option value="99"<?php If($fetchProfile['BankCountry'] == 99){echo 'Selected';}?>>Israel</option>
				<option value="100"<?php If($fetchProfile['BankCountry'] == 100){echo 'Selected';}?>>Italy</option>
				<option value="101"<?php If($fetchProfile['BankCountry'] == 101){echo 'Selected';}?>>Jamaica</option>
				<option value="102"<?php If($fetchProfile['BankCountry'] == 102){echo 'Selected';}?>>Japan</option>
				<option value="103"<?php If($fetchProfile['BankCountry'] == 103){echo 'Selected';}?>>Jordan</option>
				<option value="104"<?php If($fetchProfile['BankCountry'] == 104){echo 'Selected';}?>>Kazakhstan</option>
				<option value="105"<?php If($fetchProfile['BankCountry'] == 105){echo 'Selected';}?>>Kenya</option>
				<option value="106"<?php If($fetchProfile['BankCountry'] == 106){echo 'Selected';}?>>Kiribati</option>
				<option value="107"<?php If($fetchProfile['BankCountry'] == 107){echo 'Selected';}?>>Korea (Peoples Republic of)</option>
				<option value="108"<?php If($fetchProfile['BankCountry'] == 108){echo 'Selected';}?>>Korea (Republic of)</option>
				<option value="109"<?php If($fetchProfile['BankCountry'] == 109){echo 'Selected';}?>>Kuwait</option>
				<option value="110"<?php If($fetchProfile['BankCountry'] == 110){echo 'Selected';}?>>Kyrgyzstan</option>
				<option value="111"<?php If($fetchProfile['BankCountry'] == 111){echo 'Selected';}?>>Laos</option>
				<option value="112"<?php If($fetchProfile['BankCountry'] == 112){echo 'Selected';}?>>Latvia</option>
				<option value="113"<?php If($fetchProfile['BankCountry'] == 113){echo 'Selected';}?>>Lebanon</option>
				<option value="114"<?php If($fetchProfile['BankCountry'] == 114){echo 'Selected';}?>>Lesotho</option>
				<option value="115"<?php If($fetchProfile['BankCountry'] == 115){echo 'Selected';}?>>Liberia</option>
				<option value="116"<?php If($fetchProfile['BankCountry'] == 116){echo 'Selected';}?>>Libya</option>
				<option value="117"<?php If($fetchProfile['BankCountry'] == 117){echo 'Selected';}?>>Liechtenstein</option>
				<option value="118"<?php If($fetchProfile['BankCountry'] == 118){echo 'Selected';}?>>Lithuania</option>
				<option value="119"<?php If($fetchProfile['BankCountry'] == 119){echo 'Selected';}?>>Luxembourg</option>
				<option value="120"<?php If($fetchProfile['BankCountry'] == 120){echo 'Selected';}?>>Macau</option>
				<option value="121"<?php If($fetchProfile['BankCountry'] == 121){echo 'Selected';}?>>Macedonia</option>
				<option value="122"<?php If($fetchProfile['BankCountry'] == 122){echo 'Selected';}?>>Madagascar</option>
				<option value="123"<?php If($fetchProfile['BankCountry'] == 123){echo 'Selected';}?>>Malawi</option>
				<option value="124"<?php If($fetchProfile['BankCountry'] == 124){echo 'Selected';}?>>Malaysia</option>
				<option value="125"<?php If($fetchProfile['BankCountry'] == 125){echo 'Selected';}?>>Maldives</option>
				<option value="126"<?php If($fetchProfile['BankCountry'] == 126){echo 'Selected';}?>>Mali</option>
				<option value="127"<?php If($fetchProfile['BankCountry'] == 127){echo 'Selected';}?>>Malta</option>
				<option value="128"<?php If($fetchProfile['BankCountry'] == 128){echo 'Selected';}?>>Marshall Islands</option>
				<option value="129"<?php If($fetchProfile['BankCountry'] == 129){echo 'Selected';}?>>Martinique</option>
				<option value="130"<?php If($fetchProfile['BankCountry'] == 130){echo 'Selected';}?>>Mauritius</option>
				<option value="232"<?php If($fetchProfile['BankCountry'] ==	232){echo 'Selected';}?>>Mauritania</option>
				<option value="131"<?php If($fetchProfile['BankCountry'] == 131){echo 'Selected';}?>>Mayotte</option>
				<option value="132"<?php If($fetchProfile['BankCountry'] == 132){echo 'Selected';}?>>Mexico</option>
				<option value="133"<?php If($fetchProfile['BankCountry'] == 133){echo 'Selected';}?>>Moldova</option>
				<option value="134"<?php If($fetchProfile['BankCountry'] == 134){echo 'Selected';}?>>Monaco</option>
				<option value="135"<?php If($fetchProfile['BankCountry'] == 135){echo 'Selected';}?>>Mongolia</option>
				<option value="136"<?php If($fetchProfile['BankCountry'] == 136){echo 'Selected';}?>>Montenegro</option>
				<option value="137"<?php If($fetchProfile['BankCountry'] == 137){echo 'Selected';}?>>Montserrat</option>
				<option value="138"<?php If($fetchProfile['BankCountry'] == 138){echo 'Selected';}?>>Morocco</option>
				<option value="139"<?php If($fetchProfile['BankCountry'] == 139){echo 'Selected';}?>>Mozambique</option>
				<option value="140"<?php If($fetchProfile['BankCountry'] == 140){echo 'Selected';}?>>Myanmar</option>
				<option value="141"<?php If($fetchProfile['BankCountry'] == 141){echo 'Selected';}?>>Namibia</option>
				<option value="142"<?php If($fetchProfile['BankCountry'] == 142){echo 'Selected';}?>>Nauru</option>
				<option value="143"<?php If($fetchProfile['BankCountry'] == 143){echo 'Selected';}?>>Nepal</option>
				<option value="144"<?php If($fetchProfile['BankCountry'] == 144){echo 'Selected';}?>>Netherlands</option>
				<option value="145"<?php If($fetchProfile['BankCountry'] == 145){echo 'Selected';}?>>Netherlands Antilles</option>
				<option value="146"<?php If($fetchProfile['BankCountry'] == 146){echo 'Selected';}?>>New Caledonia</option>
				<option value="147"<?php If($fetchProfile['BankCountry'] == 147){echo 'Selected';}?>>New Zealand</option>
				<option value="148"<?php If($fetchProfile['BankCountry'] == 148){echo 'Selected';}?>>Nicaragua</option>
				<option value="149"<?php If($fetchProfile['BankCountry'] == 149){echo 'Selected';}?>>Niger</option>
				<option value="150"<?php If($fetchProfile['BankCountry'] == 150){echo 'Selected';}?>>Nigeria</option>
				<option value="151"<?php If($fetchProfile['BankCountry'] == 151){echo 'Selected';}?>>Niue</option>
				<option value="152"<?php If($fetchProfile['BankCountry'] == 152){echo 'Selected';}?>>Norfolk Island</option>
				<option value="153"<?php If($fetchProfile['BankCountry'] == 153){echo 'Selected';}?>>Northern Mariana Islands</option>
				<option value="154"<?php If($fetchProfile['BankCountry'] == 154){echo 'Selected';}?>>Norway</option>
				<option value="155"<?php If($fetchProfile['BankCountry'] == 155){echo 'Selected';}?>>Oman</option>
				<option value="156"<?php If($fetchProfile['BankCountry'] == 156){echo 'Selected';}?>>Pakistan</option>
				<option value="157"<?php If($fetchProfile['BankCountry'] == 157){echo 'Selected';}?>>Palau</option>
				<option value="231"<?php If($fetchProfile['BankCountry'] ==	231){echo 'Selected';}?>>Palestinian Territory</option>
				<option value="158"<?php If($fetchProfile['BankCountry'] == 158){echo 'Selected';}?>>Panama</option>
				<option value="159"<?php If($fetchProfile['BankCountry'] == 159){echo 'Selected';}?>>Papua New Guinea</option>
				<option value="160"<?php If($fetchProfile['BankCountry'] == 160){echo 'Selected';}?>>Paraguay</option>
				<option value="161"<?php If($fetchProfile['BankCountry'] == 161){echo 'Selected';}?>>Peru</option>
				<option value="162"<?php If($fetchProfile['BankCountry'] == 162){echo 'Selected';}?>>Philippines</option>
				<option value="163"<?php If($fetchProfile['BankCountry'] == 163){echo 'Selected';}?>>Pitcairn</option>
				<option value="164"<?php If($fetchProfile['BankCountry'] == 164){echo 'Selected';}?>>Poland</option>
				<option value="165"<?php If($fetchProfile['BankCountry'] == 165){echo 'Selected';}?>>Portugal</option>
				<option value="166"<?php If($fetchProfile['BankCountry'] == 166){echo 'Selected';}?>>Puerto Rico</option>
				<option value="167"<?php If($fetchProfile['BankCountry'] == 167){echo 'Selected';}?>>Qatar</option>
				<option value="168"<?php If($fetchProfile['BankCountry'] == 168){echo 'Selected';}?>>Reunion</option>
				<option value="169"<?php If($fetchProfile['BankCountry'] == 169){echo 'Selected';}?>>Romania</option>
				<option value="170"<?php If($fetchProfile['BankCountry'] == 170){echo 'Selected';}?>>Russia</option>
				<option value="171"<?php If($fetchProfile['BankCountry'] == 171){echo 'Selected';}?>>Rwanda</option>
				<option value="172"<?php If($fetchProfile['BankCountry'] == 172){echo 'Selected';}?>>Saint Vincent and the Grenadines</option>
				<option value="173"<?php If($fetchProfile['BankCountry'] == 173){echo 'Selected';}?>>San Marino</option>
				<option value="174"<?php If($fetchProfile['BankCountry'] == 174){echo 'Selected';}?>>Sao Tome and Principe</option>
				<option value="175"<?php If($fetchProfile['BankCountry'] == 175){echo 'Selected';}?>>Saudi Arabia</option>
				<option value="176"<?php If($fetchProfile['BankCountry'] == 176){echo 'Selected';}?>>Senegal</option>
				<option value="177"<?php If($fetchProfile['BankCountry'] == 177){echo 'Selected';}?>>Serbia</option>
				<option value="178"<?php If($fetchProfile['BankCountry'] == 178){echo 'Selected';}?>>Seychelles</option>
				<option value="179"<?php If($fetchProfile['BankCountry'] == 179){echo 'Selected';}?>>Sierra Leone</option>
				<option value="180"<?php If($fetchProfile['BankCountry'] == 180){echo 'Selected';}?>>Singapore</option>
				<option value="181"<?php If($fetchProfile['BankCountry'] == 181){echo 'Selected';}?>>Slovakia</option>
				<option value="182"<?php If($fetchProfile['BankCountry'] == 182){echo 'Selected';}?>>Slovenia</option>
				<option value="183"<?php If($fetchProfile['BankCountry'] == 183){echo 'Selected';}?>>Solomon Islands</option>
				<option value="184"<?php If($fetchProfile['BankCountry'] == 184){echo 'Selected';}?>>Somalia</option>
				<option value="185"<?php If($fetchProfile['BankCountry'] == 185){echo 'Selected';}?>>South Africa</option>
				<option value="186"<?php If($fetchProfile['BankCountry'] == 186){echo 'Selected';}?>>South Georgia</option>
				<option value="187"<?php If($fetchProfile['BankCountry'] == 187){echo 'Selected';}?>>Spain</option>
				<option value="188"<?php If($fetchProfile['BankCountry'] == 188){echo 'Selected';}?>>Sri Lanka</option>
				<option value="189"<?php If($fetchProfile['BankCountry'] == 189){echo 'Selected';}?>>St. Kitts and Nevis</option>
				<option value="190"<?php If($fetchProfile['BankCountry'] == 190){echo 'Selected';}?>>St. Lucia</option>
				<option value="191"<?php If($fetchProfile['BankCountry'] == 191){echo 'Selected';}?>>St. Pierre and Miquelon</option>
				<option value="192"<?php If($fetchProfile['BankCountry'] == 192){echo 'Selected';}?>>Sudan</option>
				<option value="193"<?php If($fetchProfile['BankCountry'] == 193){echo 'Selected';}?>>Suriname</option>
				<option value="194"<?php If($fetchProfile['BankCountry'] == 194){echo 'Selected';}?>>Swaziland</option>
				<option value="195"<?php If($fetchProfile['BankCountry'] == 195){echo 'Selected';}?>>Sweden</option>
				<option value="196"<?php If($fetchProfile['BankCountry'] == 196){echo 'Selected';}?>>Switzerland</option>
				<option value="197"<?php If($fetchProfile['BankCountry'] == 197){echo 'Selected';}?>>Syrian Arab Republic</option>
				<option value="198"<?php If($fetchProfile['BankCountry'] == 198){echo 'Selected';}?>>Taiwan</option>
				<option value="199"<?php If($fetchProfile['BankCountry'] == 199){echo 'Selected';}?>>Tajikistan</option>
				<option value="200"<?php If($fetchProfile['BankCountry'] == 200){echo 'Selected';}?>>Tanzania</option>
				<option value="201"<?php If($fetchProfile['BankCountry'] == 201){echo 'Selected';}?>>Thailand</option>
				<option value="202"<?php If($fetchProfile['BankCountry'] == 202){echo 'Selected';}?>>Gambia</option>
				<option value="203"<?php If($fetchProfile['BankCountry'] == 203){echo 'Selected';}?>>Togo</option>
				<option value="204"<?php If($fetchProfile['BankCountry'] == 204){echo 'Selected';}?>>Tokelau</option>
				<option value="205"<?php If($fetchProfile['BankCountry'] == 205){echo 'Selected';}?>>Tonga</option>
				<option value="206"<?php If($fetchProfile['BankCountry'] ==	206){echo 'Selected';}?>>Trinidad and Tobago</option>
				<option value="207"<?php If($fetchProfile['BankCountry'] == 207){echo 'Selected';}?>>Tunisia</option>
				<option value="208"<?php If($fetchProfile['BankCountry'] == 208){echo 'Selected';}?>>Turkey</option>
				<option value="209"<?php If($fetchProfile['BankCountry'] == 209){echo 'Selected';}?>>Turkmenistan</option>
				<option value="210"<?php If($fetchProfile['BankCountry'] == 210){echo 'Selected';}?>>Turks and Caicos Islands</option>
				<option value="211"<?php If($fetchProfile['BankCountry'] == 211){echo 'Selected';}?>>Tuvalu</option>
				<option value="212"<?php If($fetchProfile['BankCountry'] == 212){echo 'Selected';}?>>Uganda</option>
				<option value="213"<?php If($fetchProfile['BankCountry'] == 213){echo 'Selected';}?>>Ukraine</option>
				<option value="214"<?php If($fetchProfile['BankCountry'] == 214){echo 'Selected';}?>>United Arab Emirates</option>
				<option value="215"<?php If($fetchProfile['BankCountry'] == 215){echo 'Selected';}?>>United Kingdom</option>
				<option value="216"<?php If($fetchProfile['BankCountry'] == 216){echo 'Selected';}?>>Uruguay</option>
				<option value="217"<?php If($fetchProfile['BankCountry'] == 217){echo 'Selected';}?>>Uzbekistan</option>
				<option value="218"<?php If($fetchProfile['BankCountry'] == 218){echo 'Selected';}?>>Vanuatu</option>
				<option value="219"<?php If($fetchProfile['BankCountry'] == 219){echo 'Selected';}?>>Venezuela</option>
				<option value="220"<?php If($fetchProfile['BankCountry'] == 220){echo 'Selected';}?>>Vietnam</option>
				<option value="221"<?php If($fetchProfile['BankCountry'] == 221){echo 'Selected';}?>>Virgin Islands (U.K.)</option>
				<option value="222"<?php If($fetchProfile['BankCountry'] == 222){echo 'Selected';}?>>Virgin Islands (U.S.)</option>
				<option value="223"<?php If($fetchProfile['BankCountry'] == 223){echo 'Selected';}?>>Wallis and Futuna Islands</option>
				<option value="224"<?php If($fetchProfile['BankCountry'] == 224){echo 'Selected';}?>>Western Samoa</option>
				<option value="225"<?php If($fetchProfile['BankCountry'] == 225){echo 'Selected';}?>>Yemen</option>
				<option value="227"<?php If($fetchProfile['BankCountry'] == 227){echo 'Selected';}?>>Congo The Democratic Republic of the</option>
				<option value="228"<?php If($fetchProfile['BankCountry'] == 228){echo 'Selected';}?>>Zambia</option>
				<option value="229"<?php If($fetchProfile['BankCountry'] == 229){echo 'Selected';}?>>Zimbabwe</option>
				<option value="230"<?php If($fetchProfile['BankCountry'] == 230){echo 'Selected';}?>>Western Sahara</option>
				<option value="13"<?php If($fetchProfile['BankCountry'] == 13){echo 'Selected';}?>>Saint Helena</option>
				<option value="234"<?php If($fetchProfile['BankCountry'] == 234){echo 'Selected';}?>>Kosovo</option>
				</select>
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Address</p>
                </td>
                <td>
				  <input type="text" name="BankAddress" Value="<?php echo $fetchProfile['BankAddress']; ?>">
                </td>
              </tr>
			  <tr>
                <td>
                  <p>SWIFT (BIC) Cod</p>
                </td>
                <td>
				  <input type="text" name="BIC" Value="<?php echo $fetchProfile['BIC']; ?>">
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Routing No</p>
                </td>
                <td>
				  <input type="text" name="BankRoutingNo" Value="<?php echo $fetchProfile['BankRoutingNo']; ?>">
                </td>
              </tr>
			  <tr>
                <td>
                  <p>Bank Account No</p>
                </td>
                <td>
				  <input type="text" name="BankAccountNo" Value="<?php echo $fetchProfile['BankAccountNo']; ?>">
                </td>
              </tr>
			  <tr>
                <td>
                  <p>IBAN</p>
                </td>
                <td>
				  <input type="text" name="IBAN" Value="<?php echo $fetchProfile['IBAN']; ?>">
                </td>
              </tr>
			    </tbody>
					</table>
			</div>
			
			<div id="payout_PayPal_div" style="display: none;">
				<table class="table table-bordered">
					<tbody>
						<tr>
							 <td style="width: 300px;">
							  <p>PayPal Email</p>
							</td>
							<td>
							  <input type="text" name="PayPalEmail" Value="<?php echo $fetchProfile['PayPalEmail']; ?>">
							</td>
					  </tr>
					</tbody>
				</table>
			</div>
			<script type="text/javascript">
			function showDiv(elem){
			   if(elem.value == 1){
					document.getElementById('payout_bank_div').style.display = "block";
					document.getElementById('payout_PayPal_div').style.display = "none";
			   }else{
				   document.getElementById('payout_bank_div').style.display = "none";
				   document.getElementById('payout_PayPal_div').style.display = "block";
			   }
				 
			}
			
			function showCompDiv(elem){
			   if(elem.value == 1){
					document.getElementById('Company_div').style.display = "block";
			   }else{
				   document.getElementById('Company_div').style.display = "none";
			   }
				 
			}
			</script>
			 <script type="text/javascript">  
			  	if(<?php echo$fetchProfile['PayoutMethod']; ?> == 1){
					document.getElementById('payout_bank_div').style.display = "block";
				}else{
					document.getElementById('payout_PayPal_div').style.display = "block";
				}
				
				if(<?php echo$fetchProfile['Type']; ?> == 1){
					document.getElementById('Company_div').style.display = "block";
				}else{
					document.getElementById('Company_div').style.display = "none";
				}
			</script>
			<table class="table table-bordered">
				<tbody>
			  <tr>
                <td style="width: 300px;">
                  <p>Preferred Currency</p>
                </td>
                <td>
				<select name="PrefCurSel" id="PrefCurSel">
				<option value="0" <?php If ($fetchProfile['PreferredCurrency'] ==0){echo 'Selected';}?>></option>
				<option value="1" <?php If ($fetchProfile['PreferredCurrency'] ==1){echo 'Selected';}?>>USD</option>
				<option value="2" <?php If ($fetchProfile['PreferredCurrency'] ==2){echo 'Selected';}?>>EUR</option>
				<option value="3" <?php If ($fetchProfile['PreferredCurrency'] ==3){echo 'Selected';}?>>PLN</option>
				<option value="4" <?php If ($fetchProfile['PreferredCurrency'] ==4){echo 'Selected';}?>>TRY</option>
				</select>
                </td>
              </tr>
			  			  <tr>
                <td>
                  <p>Additional Notes</p>
                </td>
                <td>
				  <input type="text" name="AdditionalNotes" Value="<?php echo $fetchProfile['AdditionalNotes']; ?>">
                </td>
              </tr>
            </tbody>
          </table>
		  
		  <?php
		   if(isset($_POST['BtnSave'])){
			   $AdditionalNotes = mssql_escape_string($_POST['AdditionalNotes']);
			   $PrefCurSel = mssql_escape_string($_POST['PrefCurSel']);
			   $PayPalEmail = mssql_escape_string($_POST['PayPalEmail']);
			   $IBAN = mssql_escape_string($_POST['IBAN']);
			   $BankAccountNo = mssql_escape_string($_POST['BankAccountNo']);
			   $BankRoutingNo = mssql_escape_string($_POST['BankRoutingNo']);
			   $BIC = mssql_escape_string($_POST['BIC']);
			   $BankAddress = mssql_escape_string($_POST['BankAddress']);
			   $SelectedBankCountry = mssql_escape_string($_POST['SelectedBankCountry']);
			   $BankName = mssql_escape_string($_POST['BankName']);
			   $PostalCode = mssql_escape_string($_POST['PostalCode']);
			   $City = mssql_escape_string($_POST['City']);
			   $StreetAddress = mssql_escape_string($_POST['StreetAddress']);
			   $Nameonbank = mssql_escape_string($_POST['Nameonbank']);
			   $PayoutMeth = mssql_escape_string($_POST['PayoutMeth']);
			   $TaxID = mssql_escape_string($_POST['TaxID']);
			   $SelectedCountry = mssql_escape_string($_POST['SelectedCountry']);
			   $Phonenumber = mssql_escape_string($_POST['Phonenumber']);
			   $Emailaddress = mssql_escape_string($_POST['Emailaddress']);
			   $LastName = mssql_escape_string($_POST['LastName']);
			   $FirstName = mssql_escape_string($_POST['FirstName']);
			   $CompanyName = mssql_escape_string($_POST['CompanyName']);
			   $Comp_select = mssql_escape_string($_POST['Comp_select']);
			   
			   
			   $updateYourProfile = sqlsrv_query($conn, "Update tUserProfile SET Type = ?, FirstName = ?, LastName = ?, CompanyName = ?, EmailAddress = ?, Phonenumber = ?, Country = ?, TaxID = ?, PayoutMethod = ?, PayPalEmail = ?, Nameonbank = ?, StreetAddress = ?, City = ?, PostalCode = ?, BankName = ?, BankCountry = ?, BankAddress = ?, BIC = ?, BankRoutingNo = ?, BankAccountNo = ?, IBAN = ?, PreferredCurrency = ?, AdditionalNotes = ? WHERE nUserID = ?;", array($Comp_select, $FirstName, $LastName, $CompanyName, $Emailaddress, $Phonenumber, $SelectedCountry, $TaxID, $PayoutMeth, $PayPalEmail, $Nameonbank, $StreetAddress, $City, $PostalCode, $BankName, $SelectedBankCountry, $BankAddress, $BIC, $BankRoutingNo, $BankAccountNo, $IBAN, $PrefCurSel, $AdditionalNotes, $_SESSION['nUserID']), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
			   $NewMessage = 'Settings has been successfully updated';
			   $InsertLogg = sqlsrv_query($conn, "Insert into tActivity (nUserID, Icon, Img, Title, Message) VALUES (?, 'bg-warning', 'fa-bell', 'Notification', ?);", array($_SESSION['nUserID'],  $NewMessage), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							
			   
			   If ($updateYourProfile){
				showMessage('error', '<div class="alert alert-success" role="alert"><strong>Well done!</strong> Your data has been successfully saved.</div>', 0, 'https://kernpay.com/user-settings.php?s=True');				
			   }else{
				showMessage('error', '<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> Change a few things up and try submitting again.</div>', 0, 'https://kernpay.com/user-settings.php?s=False');				
			   }
			   

		   }
		  ?>
		  
		  

            <button type="submit" name="BtnSave" class="btn btn-default">Save Settings</button>
			</form>
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