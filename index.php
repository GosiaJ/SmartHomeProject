
<!DOCTYPE HTML>
<head>
<html lang="pl">
<meta charset="utf-8" />
<title>SmartHome - Strona główna</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>

  <!-- <link rel="stylesheet" href="css/clndr.css" type="text/css" /> -->
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" />
  <!-- dwa nizej odpowiedzialne za zwijane menu! -->
  <script src="js/site.js"></script>
  <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
 
</head>
<!--
OGÓLNE INFORMACJE:

class light -> deviceType : light
class socket -> devicetype : contact
onoffswitch -> deviceOn : 1/0
currentValue -> deviceValue : 0-100
jakakolwiek zmiana -> deviceChange : 1
Jeżeli urządzenie jest online: src="images/online.png"
offline: src="images/offline.png"

-->
<body>		       
 <!-- plik z suwakami 
		 <script src="js/slider-jqueryui.js"></script> -->
		  <!-- główny pojemnik -->
	    <div class="wrap">	
	    <!-- nagłówek - menu --> 
	      <div class="header">
	      	  <div class="header_top">
					  <div class="menu">
						  <a class="toggleMenu" href="#"><img src="images/nav.png" alt="" /></a>
							<ul class="nav">
							<!-- Menu rozwijane --> 
								<li class="active"><a href="index.php"><i><img src="images/home.png" alt="" /></i>Strona Główna</a></li>
								<li><a href="config.php"><i><img src="images/config.png" alt="" /></i>Konfiguracja</a></li> 
							<div class="clear"></div>
						    </ul>
							<script type="text/javascript" src="js/responsive-nav.js"></script>
				        </div>		
		 		      <div class="clear"></div>				 
				   </div>
			</div>	  					     
	</div>
	  <div class="main">  
	    <div class="wrap">  		 
	       <!--  dynamiczne pobieranie informacji z bazy danych i wyświetlanie kontentu - zainkludowanie pliku .php --> 
	       <?php
	       	include("przeslane.php");
	       ?>	 
	       <script src="js/przekazanie.js"></script>
	       <script src="js/slider-jqueryui.js"></script>
    	<div style="clear:both;"></div>

   </div>
   </div>
  		 <div class="copy-right">
				<p>© 2016 Designed by SmartHome</p>
	 	 </div>  

</body>
</html>

