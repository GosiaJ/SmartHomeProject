<?php

//czy przeszliśmy walidację
$wszystkoOK = 1;

//czy wciśnięto add z podaną nazwą
$dodanoNazwe = 0;

//sprawdzenie czy okienko formularza nie jest puste
$errorDodawanie = 0;

//nazwa powtórzona
$nazwaPowtorzona = 0;

//adres powtórzony
$adresPowtorzony = 0;

//spr podania typu
$podanoTypN = 0;

//wyświetlanie komunikatu
$dodanoNazwe_kom = "";

//wyswietlenie zapisanego adresu i typu urzadzenia
$nadanyAdres = 0;
$nadanyTyp = 0;

//kontrola edycji
$zmiennaEdycyjna = 0;

//edytowanie zmiennych
$index=1;
//usunięcie mziennej
$zmiennaUsunieta = 0;

//jednokrotne "pobranie" danych z pliku connect.php
require_once "connect.php";
//sposób raportowania błędów - informacja, że chcemy "rzucać" wyajtki
mysqli_report(MYSQLI_REPORT_STRICT);
$polaczenie = new mysqli($host, $db_user, $db_pas, $db_name);
//-----------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------
	//wykrycie przycisku dodaj
for($i=0; $i<32; $i++){
	if(isset($_POST['add'.$i]))
	{
		$deviceName = $_POST['deviceName'.$i];
		//pobranie wybranego typu urządzenia
		$deviceType = $_POST['deviceType'.$i];
		//pobranie wskazanego adresu zmiennej (10)
		$deviceAddress_dec = $_POST['deviceAddress'.$i];
		//przeliczenie na binarne
		$deviceAddress_bin = decbin($deviceAddress_dec);

		//czy nie zostawiono pustego pola?
		if($deviceName == "")
		{
			$errorDodawanie = 1;
			$wszystkoOK = 0;
			$dodanoNazwe = 0;
		}

		//wszystko jest ok
		else if($wszystkoOK == 1)
		{
			$dodanoNazwe = 1;
		}

		try
		{
			if($polaczenie->connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errorno());
			}
			//połączenie nawiązano
			else
			{
				//czy nazwa już istnieje?
				$rezultat = $polaczenie->query("SELECT deviceName FROM devices WHERE deviceName='$deviceName'");
				//jeżeli wynikiem zapytania jest false
				if(!$rezultat) throw new Exception($polaczenie->error);
				//jeżeli jest dobrze, to sprawdzimy ile jest takich nazw
				$ileNazwIstnieje = $rezultat->num_rows;
				//jeżeli $ileNazwIstnieje >0 to znaczy, ze już taka nazwa jest:
				if($ileNazwIstnieje>0)
				{
					$nazwaPowtorzona = 1;
					$errorDodawanie = 1;
					$dodanoNazwe = 1;
					$wszystkoOK = 0;
				}
				//czy adres już istnieje?
				$rezultat_adres = $polaczenie->query("SELECT deviceAddress FROM devices WHERE deviceAddress='$deviceAddress_bin'");
				if(!$rezultat_adres) throw new Exception($polaczenie->error);
				$ileAdresowIstnieje = $rezultat_adres->num_rows;
				if($ileAdresowIstnieje>0)
				{
					$adresPowtorzony = 1;
					$wszystkoOK = 0;
					$errorDodawanie = 0 ;
					$dodanoNazwe = 0;
					$nazwaPowtorzona = 0;
				}
				//brak powtórzeń - dodaj do bazy danych
				else
				{
					//jakiekolwiek połączenie nawiąż tylko jeżeli nazwa nie jest pustym łańcuchem!
					if($deviceName != "" && $deviceAddress_dec != "" && $deviceType != "")
					{
						if($polaczenie->query("INSERT INTO devices VALUES (NULL, '$deviceName', '$deviceAddress_bin', '$deviceType', 0, 0, 0, 0)"))
						{

							$wszystkoOK =1;
							$errorDodawanie = 0;
							$dodanoNazwe = 0;
							$nazwaPowtorzona = 0;
							$nadanyTyp = 0;
							$nadanyAdres = 0;
							$adresPowtorzony = 0;
							$nadanyTyp = 1;
							$nadanyAdres = 1;
						}
						else
						{
							throw new Exception($polaczenie->error);
						}
					}

				}
				//dane do wyświetlenia zapisanego adresu (binarnego) i typu
				$nadanyAdres=0;
				$nadanyTyp=0;

				//zamknięcie połączenia
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;"> Błąd serwera </span>';
			//echo ' <br/> Info develop:'.$e;
		}
	}
}
//-----------------------------------------------------------------------------------------------------------------------------------------------
	//WYKRYCIE PRZYCISKU USUNIĘCIA!
	for($i=1; $i<32; $i++)
	{
	if(isset($_POST['delete'.$i]))
	{
		try
		{
			//POŁĄCZENIE Z BAZĄ DANYCH
			//pobranie adresu urządzenia wybranego rekordu
			$deletedDeviceAddress = $_POST['deviceAddress'.$i];
			//obiekt reprezentujący połączenie
			//$polaczenie = @new mysqli($host, $db_user, $db_pas, $db_name);
			//sprawdzanie czy połączenie zostało ustanowione (połączenie spełnione [connect_errno == 0] )
			if($polaczenie->connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errorno());
			}
			//połączenie nawiązano
			else
			{
				$deletedDeviceAddress_bin = decbin($deletedDeviceAddress);
				$nazwaUsunietego = $polaczenie->query("SELECT deviceName, deviceAddress FROM devices WHERE deviceAddress='$deletedDeviceAddress_bin'");
				$nazwaUsunietegoUrzadzenia = $nazwaUsunietego->fetch_assoc();
				if($usuniecie = $polaczenie->query("DELETE FROM devices WHERE deviceAddress='$deletedDeviceAddress_bin'") or die ('Błąd zapytania: '.mysql_error()))
				{
					$zmiennaUsunieta = 1;
				}
				else
					throw new Exception($usuniecie->error);

			}
		}
		catch(Exception $ex)
		{
			echo '<span style="color:red;"> Błąd serwera </span>';
			//echo ' <br/> Info develop:'.$ex;
		}
	}
	}
	//WYKRYCIE PRZYCISKU EDYCJI!
	for($j=0; $j<33; $j++)
	{
		if(isset($_POST['edit'.$j]))
		{
			//pokaż modal z textboxem:
				echo '<div id="myModal">';
				echo '<div class="modal-content">';
				echo '<span class="close">&times;</span><br/>';
				echo '<p>Podaj nową nazwę zmiennej: </p><br/>';
				echo '<form name="formularzZmianyNazwy" method="POST">';
				echo '<input type="text" id="nowaNazwaUrzadzenia" name="changedDeviceName"><br/>';
				echo '<input type="submit" id="but" value="Zatwierdź" /> ';
				echo '<input type="hidden" id="iteracja" name="nrIteracji" value="'.$j.'" />';
				echo '</form>';
				echo '</div> </div>';
		}
	}
	include("edytowanie.php");
	//$polaczenie->close();

?>
