<?php
$modif="";
if(isset($_POST['modif']))
{
	$modif=$_POST['modif'];
}
session_start();

$asf2Attributes=$_SESSION['_sf2_attributes'];

//print_r($asf2Attributes['gUserLoginLogged']);

$cle="";
$valcle="";
foreach ($_SESSION as $sess)
{
	
	foreach ($sess as $k=> $sess2)
	{
		if($k=="gUserLoginLogged")
		{
			$cle=$k;
			//$_SESSION[$k."_oeuvres_modifencours"] = $modif;
			$valcle=$sess2;
		}
	}
}

$valcle=$valcle."_oeuvres_modifencours";

//echo "\n> valcle>".$valcle;

$asf2Attributes[$valcle]=$modif;
session_start();

$_SESSION['_sf2_attributes']=$asf2Attributes;

session_start();
$asf2Attributes=$_SESSION['_sf2_attributes'];

//print_r($asf2Attributes);
?>