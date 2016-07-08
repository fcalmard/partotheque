<?php
header('Content-Type: text/html;charset=UTF-8');

session_start();

$bdd=false;
try {
	$bdd = new PDO('mysql:host=localhost;dbname=mychoralebd.mysql', 'root', 'root');
} catch(Exception $e) {
	exit('Impossible de se connecter à la base de données.');
}

$json = array();

if($bdd)
{
	
	$voixid = htmlentities(intval($_POST['voix_id']));
	
	/*
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voix_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `commentaire` longtext COLLATE utf8_unicode_ci,
  `datecreateAt` datetime NOT NULL,	 * 
	 */
	$sSql="select id,voix_id,libelle,active from Souscategvoix where active=1 and voix_id=".$voixid;
	foreach  ($bdd->query($sSql) as $donnees)
	{
		//$json['id']=$donnees['id'];
	//	$json[$donnees['id']][] = utf8_encode($donnees['libelle']);
			$json[$donnees['id']]= utf8_encode($donnees['libelle']);
	}
	unset($bdd);
}

//$aRes=json_encode($aRes);

echo json_encode($json);

?>