<?php
//rozpoczêscie sesji
session_start();
//$_SESSION['n'] = 0;
//pobierz dane dot. DB
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
//nawi¹¿ po³¹czenie
$polaczenie = new mysqli($host, $db_user, $db_pas, $db_name);
//pobierz wszystkie dane z tabeli
$pobraneInformacje=$polaczenie->query("SELECT * FROM devices");
//zapisz dane z dB do tablicy
$pobraneInformacjeTablica = $pobraneInformacje->fetch_assoc();
//przypisz poszczególne wartoœci do zmiennych
$pobranaNazwa = $pobraneInformacjeTablica['deviceName'];
$pobraneOnline = $pobraneInformacjeTablica['deviceOn'];
$pobraneAdres = $pobraneInformacjeTablica['deviceAddress'];
$pobraneValue = $pobraneInformacjeTablica['deviceValue'];

//wy³apanie zmiany stanu on/off
if(isset($_POST['done']))
{
	$deviceOn = $_POST['stan'];
	$adresZmienionegoObiektu = $_POST['adres'];
	$wasrtoscVal = $deviceOn*100;
	      //edytuj bazê danych
	try{

		$rezultatoff = $polaczenie->query("UPDATE devices SET deviceOn='$deviceOn', deviceValue='$wasrtoscVal', deviceChange='1' WHERE deviceAddress='$adresZmienionegoObiektu'");
		if(!$rezultatoff) throw new Exception($polaczenie->error);


	}
	catch(Exception $e)
	{
		echo '<span style="color:red;"> Błądd serwera </span>';
			//echo ' <br/> Info develop:'.$e;
	}




}

//wy³apanie zmiany slidera
if(isset($_POST['doneValue']))
{
	$deviceValueSlider = $_POST['stanValue'];
	$_SESSION['obecnySlider'] = $deviceValueSlider;
	$adresZmienionegoObiektuValue = $_POST['adresValue'];
	$_SESSION['adresSlider'] = $adresZmienionegoObiektuValue; 
	try{
	    $rezultatValue = $polaczenie->query("UPDATE devices SET deviceValue='$deviceValueSlider', deviceChange='1' WHERE deviceAddress='$adresZmienionegoObiektuValue'");
	    if(!$rezultatValue) throw new Exception($polaczenie->error);
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;"> B³¹d serwera </span>';
			//echo ' <br/> Info develop:'.$e;
	}
	//echo $deviceOnline;

}

try
{
	//pobranie informacji z bazy danych
	$pobraneInformacje=$polaczenie->query("SELECT * FROM devices");

	for($i=1; $i<33; $i++)
	{
	    if(!$pobraneInformacje) throw new Exception($polaczenie->error);
	    else
	    {
	       	$pobraneInformacjeTablica = $pobraneInformacje->fetch_assoc();
	       	$pobranaNazwa = $pobraneInformacjeTablica['deviceName'];
	       	$pobraneOnline = $pobraneInformacjeTablica['deviceOnline'];
	       	$pobraneAdres = $pobraneInformacjeTablica['deviceAddress'];
	       	$pobraneValue = $pobraneInformacjeTablica['deviceValue'];
	       	$pobraneOn = $pobraneInformacjeTablica['deviceOn'];
	       	//je¿eli urz¹dzenie jest online:
	       	//je¿eli urz¹dzenie jest œwiat³em - poka¿ slider.
				if($pobraneInformacjeTablica['deviceType']=='SWITCH')
				{
	       			echo '<div id="light"><input type="hidden" id="typ" value="'.$pobraneInformacjeTablica['deviceType'].'"/>';
	       			echo '<h3><i><img src="images/light.png"  alt="" style="height: 30px;"/> </i>'.$pobranaNazwa;
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
	       			echo '<form action ="config.php" method="post">';
	       			if($pobraneOn == 1)
	       			{
	       				echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox" checked="checked">';
	       			}
	       			else
	       			{
	       				echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox" >';
	       			}
	       			echo '<label class="onoffswitch-label" for="myonoffswitch1'.$i.'">';
					echo '<span class="onoffswitch-inner"></span>';
					echo '<span class="onoffswitch-switch"></span>';
					echo '</label>';
					echo '</form>';
					echo '</div>';
					echo '</div>';
					if($pobraneOn== 1)
					{
						echo '<div class="boxTable"><p class = "note"><span id="currentValue'.$i.'">'.$pobraneValue.'</span>%</p></div>';
						echo '</div>';
						echo '<div id="slider'.$i.'"></div>';
						echo '<input type="hidden" id="inputCurrentValue'.$i.'" value="'.$pobraneValue.'"';
					}
					echo '</li>';
					echo '<li>';
					echo '<div class="infoValue">';
					echo '<div class="boxTable">';
					echo '<img src="images/info.png"/>';
					echo '</div>';
					echo '<div class = "boxTable">';
					echo '<input type="hidden" id="unikatowyAdres'.$i.'" value="'.$pobraneAdres.'" >';
					echo '<p class = "info">';
					echo 'Pobór pr¹du: 0.45kWh</b></br>';
					echo 'Ostatni mies¹c: 15.78 kWh</br>';
					echo 'Czas pracy: 248 godzin</br></br>';
					echo '</p>';
					echo '</div>';
					echo '</div> </li> </ul> </div> </div>';
					//skrypt zapisuj¹cy zmienn¹ w localhoœcie
					echo  "<script type='text/javascript'>";
					echo 'localStorage.setItem("sliderValueBegin'.$i.'", $pobraneValue)';
					echo "</script>";
	       		}
	       		else if($pobraneInformacjeTablica['deviceType'] == 'SOCKET')
	       		{
	       			echo '<div id="socket"><input type="hidden" id="typ" value="'.$pobraneInformacjeTablica['deviceType'].'"/>';
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
	       			if($pobraneOn == 1)
	       			{
	       				echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox" checked="checked">';
	       			}
	       			else
	       			{
	       				echo '<input type="checkbox" id="myonoffswitch1'.$i.'" name="onoffswitch'.$i.'" class="onoffswitch-checkbox">';
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
					echo '<input type="hidden" id="unikatowyAdres'.$i.'" value="'.$pobraneAdres.'" >';
					echo '<p class = "info">';
					echo 'Pobór pr¹du: 0.45kWh</b></br>';
					echo 'Ostatni mies¹c: 15.78 kWh</br>';
					echo 'Czas pracy: 248 godzin</br></br>';
					echo '</p>';
					echo '</div>';
					echo '</div> </li> </ul> </div> </div>';
	       		}
	       			}

	       		}
	       		//OD T¥D ZMIANY 04-01-2017
	       }
	       catch(Exception $e)
	       {
	       	echo 'B³¹d serwera!';
	       	echo 'Info develp. :'.$e;
	       }


?>
