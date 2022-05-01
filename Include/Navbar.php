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
  <nav class="navbar-youplay navbar navbar-default navbar-fixed-top ">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="off-canvas" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">
          <img src="assets/images/logo.png" alt="">
        </a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
			 <li class="dropdown dropdown-hover ">
			   <a href="#!" class="dropdown-toggle" role="button" aria-expanded="false">
                      <?php echo $NProjects; ?>
                    </a>
			<div class="dropdown-menu" style="width: 220px;">
              <ul role="menu">
                <li><a href="MyProject"><?php echo $NSPRO; ?></a>
                </li>
                <li><a href="MyProject?Add=True"><?php echo $NAPRO; ?></a>
                </li>
              </ul>
            </div>
			 </li>
          <li class="dropdown dropdown-hover ">
            <a href="#!" class="dropdown-toggle" role="button" aria-expanded="false">
                      <?php echo $NAnalisty; ?>
                    </a>
            <div class="dropdown-menu" style="width: 220px;">
              <ul role="menu">
                <li><a href="user-trans"><?php echo $NTRANS; ?></a>
                </li>
                <li><a href="user-byus"><?php echo $NUSER; ?></a>
                </li>
                <li><a href="user-psys"><?php echo $NPSYS; ?></a>
                </li>
              </ul>
            </div>
          </li>
		  
		   <li class="dropdown dropdown-hover">
            <a href="#!" class="dropdown-toggle" role="button" aria-expanded="false">
                     <?php echo $NDOK; ?>
                    </a>
            <div class="dropdown-menu" style="width: 220px;">
              <ul role="menu">
                <li><a href="GS"><?php echo $NGS; ?></a>
                </li>
                <li><a href="APIS"><?php echo $APIS; ?></a>
                </li>
				 <li><a href="INT"><?php echo $NINT; ?></a>
                </li>
				<li><a href="PST"><?php echo $NTEPE; ?></a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="dropdown dropdown-hover">
            <a href="#!" class="dropdown-toggle" role="button" aria-expanded="false">
                     <?php echo $NDocuments; ?>
                    </a>
            <div class="dropdown-menu" style="width: 220px;">
              <ul role="menu">
                <li><a href="Agb"><?php echo $NAGB; ?></a>
                </li>
               <li><a href="Impressum"><?php echo $NIMPR; ?></a>
                </li>
                <li><a href="Datenschutz"><?php echo $NDASCHU; ?></a>
                </li>
              </ul>
            </div>
          </li>
		  
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown dropdown-hover">
            <a href="#!" class="dropdown-toggle" role="button" aria-expanded="false">
                     <?php echo $fetchProfile['FirstName'].' '.$fetchProfile['LastName']; ?> <span class="badge bg-default"></span> <span class="caret"></span> <span class="label"><?php echo $NITYU; ?></span>
                    </a>
            <div class="dropdown-menu">
              <ul role="menu">
				<li><a href="user-index"><?php echo $NACT; ?> <span class="badge pull-right bg-warning"></span></a></li>
                <li class="divider"></li>
                <li><a href="user-profile"><?php echo $NPROF; ?> <span class="badge pull-right bg-warning"></span></a></li>
				<li><a href="user-settings"><?php echo $NSETTINGS; ?> <span class="badge pull-right bg-warning"></span></a></li>
                <li class="divider"></li>
				<li><a href="in-messages"><?php echo $NMESSAGE; ?> <span class="badge pull-right bg-warning"><?php echo $fetchMessagesCount[0]; ?></span></a></li>
				 <li class="divider"></li>
                <li><a href="logout"><?php echo $NLOGOUT; ?></a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="dropdown dropdown-hover">
            <a href="#!" class="dropdown-toggle" role="button" aria-expanded="false">
                     <i class="fa fa-globe"></i>
                    </a>
            <div class="dropdown-menu">
              <ul role="menu">
                <li><a href="?lang=de"><?php echo $NDE; ?> <?php echo $DECHECK; ?></a></li>
                <li class="divider"></li>
				 <li><a href="?lang=en"><?php echo $NEN; ?> <?php echo $ENCHECK; ?></a></li>
              </ul>
            </div>
          </li>
		  
        </ul>
      </div>
    </div>
  </nav>
<?php				
				}
?>