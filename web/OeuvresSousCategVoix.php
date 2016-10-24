<?php
header('Content-Type: text/html;charset=UTF-8');

session_start();

$bdd=false;
try {
	$bdd = new PDO('mysql:host=localhost;dbname=mychoralebd.mysql', 'root', 'root');
} catch(Exception $e) {
	exit('Impossible de se connecter à la base de données.');
}

$idvoix = 0;

if($bdd)
{
	
	$id = htmlentities(intval($_POST['id']));
	
	/*
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voix_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `commentaire` longtext COLLATE utf8_unicode_ci,
  `datecreateAt` datetime NOT NULL,	 * 
	 */
	$sSql="select id,voix_id from Souscategvoix where id=".$id;
	foreach  ($bdd->query($sSql) as $donnees)
	{
		//$json['id']=$donnees['id'];
	//	$json[$donnees['id']][] = utf8_encode($donnees['libelle']);
			$idvoix= $donnees['voix_id'];
	}
	unset($bdd);
}

//$aRes=json_encode($aRes);

echo $idvoix;

?>