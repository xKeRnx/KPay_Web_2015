<?php
				if($__TOKEN == "hardcodeshitbyKeRnPay"){
				
				$ENCHECK = NULL;
				$DECHECK = NULL;
				
				If (isset($_GET['lang'])){
					If ($_GET['lang'] == 'en'){
						setcookie("lang", "en");
						include 'Include/lang/en/Navbar.php';
						$ENCHECK = '<i class="fa fa-check"></i>';	
					}elseif ($_GET['lang'] == 'de'){
						setcookie("lang", "de");
						include 'Include/lang/de/Navbar.php';
						$DECHECK = '<i class="fa fa-check"></i>';	
					}
				}elseif (!isset($_GET['lang']) AND isset($_COOKIE["lang"])){
						If ($_COOKIE["lang"] == 'en'){
							include 'Include/lang/en/Navbar.php';
							$ENCHECK = '<i class="fa fa-check"></i>';
						}else{
							include 'Include/lang/de/Navbar.php';
							$DECHECK = '<i class="fa fa-check"></i>';	
						}	
				}elseif (!isset($_GET['lang']) AND !isset($_COOKIE["lang"])){
						setcookie("lang", "de");
						include 'Include/lang/de/Navbar.php';
						$DECHECK = '<i class="fa fa-check"></i>';	
				}
					
?>		
 <footer style="position:absolute;">

        <!-- Social  -->
        <div class="social">
            <h3><strong><?php echo $__CONFIG['FName']; ?></strong> - Easy way to Pay</h3>
        </div>
        <!-- /Social  -->

        <!-- Copyright -->
        <div class="copyright">
			<a href="impressum.php"><?php echo $NIMPR; ?></a> - <a href="datenschutz.php"><?php echo $NDASCHU; ?></a> - <a href="AGB.php"><?php echo $NAGB; ?></a>
            <br>© 2016 KeRnPay 
        </div>
        <!-- /Copyright -->

 
</footer>
<?php				
				}
?>