<?php
if($__TOKEN == "hardcodeshitbyKeRnPay"){
?>
<h1>1. Wähle eine API</h1>

	<section class="youplay-features container">
		<a onclick="ShowDiv('1', this)" style="cursor: pointer;" >
        <div class="col-md-3 col-xs-12">
          <div class="feature angled-bg">
            <i class="fa fa-file"></i>
            <h3>Digital Goods</h3>
          </div>
        </div>
		</a>
		
		<a onclick="ShowDiv('2', this)" style="cursor: pointer;">
        <div class="col-md-3 col-xs-12">
          <div class="feature angled-bg">
            <i class="fa fa-gamepad"></i>
            <h3> Virtual Currency </h3>
          </div>
        </div>
		</a>
		
		<a onclick="ShowDiv('3', this)" style="cursor: pointer;">
        <div class="col-md-3 col-xs-12">
          <div class="feature angled-bg">
            <i class="fa fa-shopping-cart"></i>
            <h3>Cart</h3>
          </div>
        </div>
		</a>
		
		<a onclick="ShowDiv('4', this)" style="cursor: pointer;">
        <div class="col-md-3 col-xs-12">
          <div class="feature angled-bg">
            <i class="fa fa-heart"></i>
            <h3>Individual</h3>
          </div>
        </div>
		</a>
    </section>


<h1>2. Widget einrichten</h1>
 <div id="DG_div" style="display: block;">
 
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		11
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	11
 </div>
 
 </div>
  
 <div id="VC_div" style="display: none;">
 
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		21
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	21
 </div>
 
 </div>
 
 <div id="CT_div" style="display: none;">
 
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		31
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	31
 </div>
 
 </div>
 
 <div id="ID_div" style="display: none;">
 
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		41
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	41
 </div>
 
 </div>
 
  <div style="clear:both"></div>
<h1>3. Zahlungsbestätigung einrichten</h1>
 <div id="DG_div1" style="display: block;">
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		12
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	Jedes mal wenn ein Kunde bezahlt oder ein kauf abschließt, senden wir einen server-to-server pingback, auch bekannt als Callback, Postback oder sofortige Zahlungsbestätigung. Um die Pingback Funktion nutzen zu können, beachten Sie bitte unser Code Beispiel. Und tragen Sie die Pingback URL in Ihren Projekt einstellungen ein.
	</div>
 </div>
 
 <div id="VC_div1" style="display: none;">
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		22
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	Jedes mal wenn ein Kunde bezahlt oder ein kauf abschließt, senden wir einen server-to-server pingback, auch bekannt als Callback, Postback oder sofortige Zahlungsbestätigung. Um die Pingback Funktion nutzen zu können, beachten Sie bitte unser Code Beispiel. Und tragen Sie die Pingback URL in Ihren Projekt einstellungen ein. </div>
 </div>
 
 <div id="CT_div1" style="display: none;">
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		32
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	Jedes mal wenn ein Kunde bezahlt oder ein kauf abschließt, senden wir einen server-to-server pingback, auch bekannt als Callback, Postback oder sofortige Zahlungsbestätigung. Um die Pingback Funktion nutzen zu können, beachten Sie bitte unser Code Beispiel. Und tragen Sie die Pingback URL in Ihren Projekt einstellungen ein. </div>
 </div>
 
 <div id="ID_div1" style="display: none;">
 <div id="left_box" style="width: 500px; float:left;margin-right: 50px;">
	<pre>
		<code>
		42
		</code>
	</pre>
 </div>
 
  <div id="left_box" style="width: 500px; float:left;">
	Jedes mal wenn ein Kunde bezahlt oder ein kauf abschließt, senden wir einen server-to-server pingback, auch bekannt als Callback, Postback oder sofortige Zahlungsbestätigung. Um die Pingback Funktion nutzen zu können, beachten Sie bitte unser Code Beispiel. Und tragen Sie die Pingback URL in Ihren Projekt einstellungen ein. </div>
 </div>
  <div style="clear:both"></div>
<h1>4. Erstelle einen KeRnPay Account</h1>
<h4>Um KeRnPay zu nutzen zu können müssen Sie sich Registrieren.</h4>
<br>
<a href="https://kernpay.com/register" class="btn btn-primary">Registrieren</a>
   
   
			 <script type="text/javascript">  
				function ShowDiv(id){
				   if(id == 1){
						document.getElementById('DG_div').style.display = "block";
						document.getElementById('DG_div1').style.display = "block";
						document.getElementById('ID_div').style.display = "none";
						document.getElementById('CT_div').style.display = "none";
						document.getElementById('VC_div').style.display = "none";
						document.getElementById('ID_div1').style.display = "none";
						document.getElementById('CT_div1').style.display = "none";
						document.getElementById('VC_div1').style.display = "none";
				   }else if(id == 2){
						document.getElementById('VC_div').style.display = "block";
						document.getElementById('VC_div1').style.display = "block";
						document.getElementById('DG_div').style.display = "none";
						document.getElementById('ID_div').style.display = "none";
						document.getElementById('CT_div').style.display = "none";
						document.getElementById('DG_div1').style.display = "none";
						document.getElementById('ID_div1').style.display = "none";
						document.getElementById('CT_div1').style.display = "none";
				   }else if(id == 3){
						document.getElementById('CT_div').style.display = "block";
						document.getElementById('CT_div1').style.display = "block";
						document.getElementById('DG_div').style.display = "none";
						document.getElementById('ID_div').style.display = "none";
						document.getElementById('VC_div').style.display = "none";
						document.getElementById('DG_div1').style.display = "none";
						document.getElementById('ID_div1').style.display = "none";
						document.getElementById('VC_div1').style.display = "none";
				   }else if(id == 4){
						document.getElementById('ID_div').style.display = "block";
						document.getElementById('ID_div1').style.display = "block";
						document.getElementById('DG_div').style.display = "none";
						document.getElementById('CT_div').style.display = "none";
						document.getElementById('VC_div').style.display = "none";
						document.getElementById('DG_div1').style.display = "none";
						document.getElementById('CT_div1').style.display = "none";
						document.getElementById('VC_div1').style.display = "none";
				   }else{
					   document.getElementById('DG_div').style.display = "none";
					   document.getElementById('ID_div').style.display = "none";
					   document.getElementById('CT_div').style.display = "none";
					   document.getElementById('VC_div').style.display = "none";
					   document.getElementById('DG_div1').style.display = "none";
					   document.getElementById('ID_div1').style.display = "none";
					   document.getElementById('CT_div1').style.display = "none";
					   document.getElementById('VC_div1').style.display = "none";
				   } 
				}
			</script> 
   
   
<?php
}
?>