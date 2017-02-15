<?php
/*
	WYŚWIETLANIE DIVÓW NA STRONIE GŁÓWNEJ ZAWIERAJĄCYCH INFO O URZĄDZENIACH ZNAJDUJĄCYCH SIĘ W BAZIE DANYCH
*/
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$polaczenie = new mysqli($host, $db_user, $db_pas, $db_name);
	       	try
	       	{

	       		//pobranie informacji z bazy danych
	       		$pobraneInformacje=$polaczenie->query("SELECT * FROM devices");
	       		//wpisanie wyników do tablicy

	       		for($i=1; $i<33; $i++)
	       		{
	       			if(!$pobraneInformacje) throw new Exception($polaczenie->error);
	       			else
	       			{
	       				$pobraneInformacjeTablica = $pobraneInformacje->fetch_assoc();
	       				$pobranaNazwa = $pobraneInformacjeTablica['deviceName'];
	       				$pobraneOnline = $pobraneInformacjeTablica['deviceOnline'];
	       				//jeżeli urządzenie jest online:
	       				//jeżeli urządzenie jest światłem - pokaż slider.
	       				if($pobraneInformacjeTablica['deviceType']=='light')
	       				{
	       					echo '<div class="light">';
	       					echo '<h3><i><img src="images/light.png" alt="" /> </i>'.$pobranaNazwa;
	       					echo '<online>';
	       					if($pobraneOnline == 0)
	       					{
	       						echo '<img src="images/offline.png" />';
	       					}
	       					else
	       					{
	       						echo '<img src="images/online.png" />';
	       					}
	       					echo '</online></h3>';
	       					echo '<div class="light_list">';
	       					echo '<ul>';
	       					echo '<li>';
	       					echo '<div class="controlValue">';
	       					echo '<div class = "boxTable">';
	       					echo '<div class="onoffswitch">';
	       					echo '<form action ="config.php" method="post">';
	       					if($pobraneOnline == 1)
	       					{
	       						echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox" checked="checked" onchange="check_me'.$i.'();">';
	       					}
	       					else
	       					{
	       						echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox" onchange="check_me'.$i.'();">';
	       					}
	       					echo '<label class="onoffswitch-label" for="myonoffswitch1'.$i.'">';
							echo '<span class="onoffswitch-inner"></span>';
							echo '<span class="onoffswitch-switch"></span>';
							echo '</label>';
							echo '</form>';
							echo '</div>';
							echo '</div>';
							if($pobraneInformacjeTablica['deviceOnline'] == 1)
							{
								echo '<div class="boxTable"><p class = "note"><span id="currentValue'.$i.'">0</span>%</p></div>';
								echo '</div>';
								echo '<div id="slider'.$i.'"></div>';
							}
							echo '</li>';
							echo '<li>';
							echo '<div class="infoValue">';
							echo '<div class="boxTable">';
							echo '<img src="images/info.png"/>';
							echo '</div>';
							echo '<div class = "boxTable">';
							echo '<p class = "info">';
							echo 'Pobór prądu: 0.45kWh</b></br>';
							echo 'Ostatni miesąc: 15.78 kWh</br>';
							echo 'Czas pracy: 248 godzin</br></br>';
							echo '</p>';
							echo '</div>';
							echo '</div> </li> </ul> </div> </div>';
	       				}
	       				else if($pobraneInformacjeTablica['deviceType'] == 'contact')
	       				{
	       					echo '<div class="socket">';
	       					echo '<h3><i><img src="images/socket.png" alt="" /> </i>'.$pobranaNazwa;
	       					echo '<online>';
	       					if($pobraneInformacjeTablica['deviceOnline'] == 0)
	       					{
	       						echo '<img src="images/offline.png" />';
	       					}
	       					else
	       					{
	       						echo '<img src="images/online.png" />';
	       					}
	       					echo '</online></h3>';
	       					echo '<div class="light_list">';
	       					echo '<ul>';
	       					echo '<li>';
	       					echo '<div class="controlValue">';
	       					echo '<div class = "boxTable">';
	       					echo '<div class="onoffswitch">';
	       					if($pobraneOnline == 1)
	       					{
	       						echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox" checked="checked" onchange="check_me'.$i.'();">';
	       					}
	       					else
	       					{
	       						echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox" onchange="check_me'.$i.'();">';
	       					}
	       					echo '<label class="onoffswitch-label" for="myonoffswitch1'.$i.'">';
							echo '<span class="onoffswitch-inner"></span>';
							echo '<span class="onoffswitch-switch"></span>';
							echo '</label>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
							echo '</li>';
							echo '<li>';
							echo '<div class="infoValue">';
							echo '<div class="boxTable">';
							echo '<img src="images/info.png"/>';
							echo '</div>';
							echo '<div class = "boxTable">';
							echo '<p class = "info">';
							echo 'Pobór prądu: 0.45kWh</b></br>';
							echo 'Ostatni miesąc: 15.78 kWh</br>';
							echo 'Czas pracy: 248 godzin</br></br>';
							echo '</p>';
							echo '</div>';
							echo '</div> </li> </ul> </div> </div>';

	       				}
	       			}

	       		}
	       }
	       catch(Exception $e)
	       {
	       	echo 'Błąd serwera!';
	       	echo 'Info develp. :'.$e;
	       }
	       ?>
