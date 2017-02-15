<?php
/*
 ŁADOWANIE WARTOŚCI SLIDERA
*/
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
//nawiąż połączenie
$polaczenie = new mysqli($host, $db_user, $db_pas, $db_name);

try{
	$pobierzDane=$polaczenie->query("SELECT deviceValue FROM devices WHERE deviceAddress='$adresSlidera'");
	if(!$pobierzDane) throw new Exception($polaczenie->error);
	$tablicaDanyh = $pobierzDane->fetch_assoc();
	$pobrWart = $tablicaDanyh['deviceValue'];
	if($pobrWart!=$obecnaWartSlidera)
	{
		
	}

}
catch(Exception $e)
{
	'<span style="color:red;"> Błąd serwera </span>'; 
}
$polaczenie->close();
?>