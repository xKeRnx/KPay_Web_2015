<?php
				if($__TOKEN == "hardcodeshitbyKeRnPay"){
?>	
 <div class="youplay-banner banner-top small">
      <div class="image" style="background-image: url(assets/images/game-journey-1400x460.jpg)" data-top="background-position: 50% 0px;" data-top-bottom="background-position: 50% -200px;">
      </div>

      <div class="youplay-user-navigation">
        <div class="container">
          <ul>
            <li <?php If (strtolower($_SERVER['PHP_SELF']) == '/user-index.php') { echo 'class="active"';}?>><a href="user-index.php">Activity</a>
            </li>
            <li <?php If (strtolower($_SERVER['PHP_SELF']) == '/user-profile.php') { echo 'class="active"';}?>><a href="user-profile.php">Profile</a>
            </li>
            <li <?php If (strtolower($_SERVER['PHP_SELF']) == '/in-messages.php') { echo 'class="active"';}?>><a href="in-messages.php">Messages <span class="badge"><?php echo $fetchMessagesCount[0]; ?></span></a>
            </li>
            <li <?php If (strtolower($_SERVER['PHP_SELF']) == '/user-settings.php') { echo 'class="active"';}?>><a href="user-settings.php">Settings</a>
            </li>
            <li <?php If (strtolower($_SERVER['PHP_SELF']) == '/payout.php') { echo 'class="active"';}?>><a href="payout.php">Payout</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="info" data-top="opacity: 1; transform: translate3d(0px,0px,0px);" data-top-bottom="opacity: 0; transform: translate3d(0px,150px,0px);" data-anchor-target=".youplay-banner.banner-top">
        <div>
          <div class="container youplay-user">
            <a class="angled-img">
              <div class="img">
                <img src="assets/images/user-avatar.jpg" alt="">
              </div>
            </a>
            <!--
                -->
            <div class="user-data">
              <h2><?php echo $fetchProfile['FirstName'].' '.$fetchProfile['LastName']; ?></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php				
				}
?>