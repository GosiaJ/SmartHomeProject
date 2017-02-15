<?php
/*
	EDYTOWANIE NAZWY ZMIENNEJ
*/

$index=0;
$newName="";
//jednokrotne "pobranie" danych z pliku connect.php
require_once "connect.php";
//sposób raportowania błędów - informacja, że chcemy "rzucać" wyajtki
mysqli_report(MYSQLI_REPORT_STRICT);
$polaczenie = new mysqli($host, $db_user, $db_pas, $db_name);
$pobraneAdresy=$polaczenie->query("SELECT * FROM devices");
//utwórz tablicę adresów
	while($pobraneAdresyTablica = $pobraneAdresy->fetch_assoc())
	{
		$tablicaAdresow[$index] = $pobraneAdresyTablica['deviceAddress'];
		$index++;
	}
	//jeżeli wykryto zmianę nazwy zmiennej
	if(isset($_POST['doneChange']))
	{
		$newName = $_POST['nameChange'];
		$i = $_POST['number']-1;
		$newAddress = $tablicaAdresow[$i];
		if($newName!=""){
			try
			{
		    	$rezultatEdit = $polaczenie->query("UPDATE devices SET deviceName='$newName', deviceChange='1' WHERE deviceAddress='$newAddress'");
		    	if(!$rezultat) throw new Exception($polaczenie->error);
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;"> Błąd serwera </span>';
				echo ' <br/> Info develop:'.$e;
			}
		}
	}
//$polaczenie->close();

?>
