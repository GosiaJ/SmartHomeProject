<?php
include("config_kod.php");
include("edytowanie.php");
?>

<!DOCTYPE HTML>
 <head>
  <title>SmartHome - Strona główna</title>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <!-- Style dla całego dokumentu-->
  <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
  <!--  Style dla menu -->
  <link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
  <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" />
  <!-- dwa nizej odpowiedzialne za zwijane menu! -->
  <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

 </head>

<body>
<!-- *********************************************************************************************************************  -->
<!-- Pasek Menu  -->
	<div class="wrap">
	    <div class="header">
	      	<div class="header_top">
				<div class="menu">
					<a class="toggleMenu" href="#"><img src="images/nav.png" alt="" /></a>
					<ul class="nav">
						<li><a href="index.php"><i><img src="images/home.png" alt="" /></i>Strona Główna</a></li>
						<li class="active"><a href="config.php"><i><img src="images/config.png" alt="" /></i>Konfiguracja</a></li>
						<div class="clear"></div>
					</ul>
					<script type="text/javascript" src="js/responsive-nav.js"></script>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
<!-- *********************************************************************************************************************  -->
<!-- Główna tabela  -->
	<div class="main">
	    <div class="wrap">
	  		<div class="lightConfig">
		        <h3>Konfiguracja urządzeń</h3>
				<div class="light_list">
				    <ul>
						<li>
<!-- Tabela użytkownika - zarządznie urządzeniami po kolei podajemy: nazwę, adres, typ, stan, i akcje możliwe do wykonania przez użytkownika-->
							<table class="table1">
								<thead>
									<tr>
										<th scope="col" abbr="Starter">Nazwa</th>
										<th scope="col" abbr="Medium">Adres</th>
										<th scope="col" abbr="Business">Typ</th>
										<th scope="col" abbr="Deluxe">Online</th>
										<th scope="col" abbr="DEluxe">Dodaj/ Edytuj/ Usuń</th>
									</tr>
								</thead>
								<form action ="config.php" method="post">
									<tbody>
										<!-- wiersze pobrane z bazy danych -->
										<?php
										//wyświetl informację jeżeli usunięto zmienną
											if($zmiennaUsunieta == 1)
												{
													echo '<span style="color:red;">Usuięto urządzenie '.$nazwaUsunietegoUrzadzenia['deviceName'].' o adresie '.bindec($nazwaUsunietegoUrzadzenia['deviceAddress']).'.</span>';
													$zmiennaUsunieta = 0;
												}
												$zmienna=1;
												//połącz z bazą
												$polaczenie = @new mysqli($host, $db_user, $db_pas, $db_name);
  												$wynik = $polaczenie->query("select * from devices") or die(mysql_error());

												while($row = $wynik->fetch_assoc())
												{
													echo'<tr>';
													//nazwa
													echo '<td>';
														if($zmiennaEdycyjna == 0)
														{
															echo $row['deviceName'];
														}
													echo '</td>';
													//adres
													echo '<td>';
															echo '<input type="hidden" id="istniejaceAdresy'.$zmienna.'" name="deviceAddress'.$zmienna.'" value="'.bindec($row['deviceAddress']).'">'.bindec($row['deviceAddress']).'</input>';
															//zapisanie adresu do zmiennej sesyjnej
													echo '</td>';
													//typ
													echo '<td>';
															if($row['deviceType']==="SWITCH")
															{
																echo "Światło";
															}
															else if($row['deviceType']==="SOCKET")
															{
																echo "Gniazdko";
															}
															else{
															    echo "Konflikt adresów";
															}
													echo '</td>';
													//online/offline
													echo '<td>';
															if($row['deviceOnline']==1)
															{
																echo "On";
															}
															else
															{
																echo "Off";
															}
													echo '</td>';
													// przyciski
													echo '<td>';
														if($zmiennaEdycyjna==0)
														{
															echo '<input type="submit" name="edit'.$zmienna.'" id="but2" value="Edytuj"/>';
															echo '<input type="submit" name="delete'.$zmienna.'" class="myButton"  value="Usuń"/>';
														}
														else
															'<input type="submit" name="editPotw'.$zmienna.'" id="but1" value="Dodaj"/>';
													echo '</td>';
													echo '</tr>';
													$zmienna++;
												}
										//<!-- nowy wiersz -->

										echo '<tr>';
											echo '<td>';
											if($wszystkoOK == 1 && $errorDodawanie == 0 && $dodanoNazwe == 0 && $nazwaPowtorzona == 0)
											{
												echo '<input type="text" name="deviceName0" />';
											}
											else if($wszystkoOK == 0 && $errorDodawanie == 1 && $dodanoNazwe == 0 && $nazwaPowtorzona == 0)
											{
												echo '<input type="text" name="deviceName0" /><br/><span style="color:red">NIE PODANO NAZWY!</span>';
											}
											else if($wszystkoOK == 0 && $errorDodawanie == 1 && $dodanoNazwe == 1 && $nazwaPowtorzona == 1)
											{
												echo '<input type="text" name="deviceName0" /><br/> <span style="color:red">Podana nazwa już istnieje</span>';
											}
											else if($wszystkoOK == 1 && $errorDodawanie == 0 && $dodanoNazwe == 1 && $nazwaPowtorzona == 0)
											{
												echo $deviceName;
											}
											echo '</td>';
											//adres urządzenia
											echo '<td>';
												if($adresPowtorzony == 0)
												{
													if($nadanyAdres == 0)
													{
														echo '<input type="number" name="deviceAddress0" min="1" max="32"></input>';
													}
													else
														echo $deviceAddress_dec;
												}
												else if($adresPowtorzony == 1)
													echo '<input type="number" name="deviceAddress0" min="1" max="32"></input> <br/> <span style="color:red">Podany adres już istnieje</span>';
											echo '</td>';
											//typ urządzenia też wybiera użytkownik light/contact
											echo '<td>';
													if($nadanyTyp == 0)
													{
														echo '<select class="form-control" name="deviceType0">';
			  												echo '<option value="SWITCH">Światło</option>';
			 												echo '<option value="SOCKET">Gniazdko</option>';
		 												echo '</select>';
	 												}
	 												else
	 												{
	 													echo $deviceType;
	 												}

											echo '</td>';
											//domyślnie stan urządzenia po dodaniu jest off - wartość 0, online 1
											echo '<td>Off</td>';
											//przyciski akcji użytkownika
											echo '<td>';
												echo '<input type="submit" name="add0" id="but1" value="Dodaj"/>';
											echo '</td>';
										echo '</tr>';
									?>

									</tbody>
							</table>
							</form>
						</li>
				    </ul>
				</div>
			</div>
        	<div class="clear"></div>
 	 	</div>
   	</div>
   	<div class="copy-right">
				<p>© 2016 Designed by SmartHome</p>
	 	 </div>
</body>
<script src="js/modal.js"></script>
</html>

