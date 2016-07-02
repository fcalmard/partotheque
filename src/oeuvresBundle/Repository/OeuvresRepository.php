<?php

namespace oeuvresBundle\Repository;


use Doctrine\ORM\EntityRepository;
use \Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Session\Session;


//use Doctrine\ORM\Persisters\BasicEntityPersister;

/**
 * OeuvresRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OeuvresRepository extends EntityRepository
{
	/**
	 * ChargeListe
	 * @param array $aFiltre
	 */
	public function ChargeListe(array $aFiltre = null,$aTriOeuvresSession=null)
	{
		
		$gUserLoginLogged="";
		/*
		$aTriOeuvresSession=array();
		
		$session = $this->getRequest()->getSession();
		if($session)
		{
			$gUserLoginLogged=$session->get('gUserLoginLogged');
			 
		}
		if($gUserLoginLogged!="")
		{
			$aTriOeuvresSession=$session->get($gUserLoginLogged.'_oeuvres_tri');
				
		}*/
		
		$sWhere="";
		if(is_array($aFiltre) && count($aFiltre)!=0)
		{
			
			foreach ($aFiltre as $vf)
			{
				//echo "<br/> VF <br/> >";
				//var_dump($vf);
				

				
				//compositeurId
				
				foreach ($vf as $kvalf=>$valf)
				{
					//echo "<br/>******  kvalf >";
					//echo $kvalf;
					switch ($kvalf)
					{
						case 'titreOeuvre':
							if(trim($valf)!="")
							{
								//$sWhere=($sWhere!="") ? " and ".$sWhere : $sWhere;
								$sWhere=($sWhere!="") ? $sWhere." and " : $sWhere;
								
								$sWhere.="o.".$kvalf;
								$sWhere.=" like '%".$valf."%'";
							}
							//echo "libelle* >  valf >";
							//echo $valf;
							//echo "<br/>1 $kvalf <br/>".$sWhere."<br/>";
											
							break;
						case 'compositeur_id':
							if(trim($valf)!="")
							{
								$sWhere=($sWhere!="") ? $sWhere." and " : $sWhere;
								$sWhere.="c.id";
								$sWhere.="=".$valf;
								//echo "<br/> $kvalf <br/>".$sWhere."<br/>";								
							}
							break;
						case 'genre_id':
							if(trim($valf)!="")
							{
								$sWhere=($sWhere!="") ? $sWhere." and " : $sWhere;
								$sWhere.="g.id";
								$sWhere.="=".$valf;
								//echo "<br/> $kvalf <br/>".$sWhere."<br/>";								
							}
							break;						
						case 'tps_litur_id':
							if(trim($valf)!="")
							{
								$sWhere=($sWhere!="") ? $sWhere." and " : $sWhere;
								$sWhere.="t.id";
								$sWhere.="=".$valf;
								//echo "<br/> $kvalf <br/>".$sWhere."<br/>";								
							}
							break;
						case 'fonction_id':
							if(trim($valf)!="")
							{
								$sWhere=($sWhere!="") ? $sWhere." and " : $sWhere;
								$sWhere.="f.id";
								$sWhere.="=".$valf;
								//echo "<br/> $kvalf <br/>".$sWhere."<br/>";
							}
							break;
						case 'voix_id':
							if(trim($valf)!="")
							{
								$sWhere=($sWhere!="") ? $sWhere." and " : $sWhere;
								$sWhere.="v.id";
								$sWhere.="=".$valf;
								//echo "<br/> $kvalf <br/>".$sWhere."<br/>";
							}
							break;
						default:
							break;
					}
						
				}
				/*
				if($kf!="")
				{
						
					$sWhere.=$kf;
					
					$sWhere.="'".$vf."'";
					
						
				}
				*/
			}
			
				
			$sWhere=($sWhere!="") ? " and ".$sWhere ."" : $sWhere;
					
			//echo "<br/> fin <br/>".$sWhere."<br/>"; 
				
			
			
		
		}
		
		$sTri='c.nom,o.titreOeuvre,o.reference';
		
		if(  !is_null($aTriOeuvresSession) && is_array($aTriOeuvresSession) && count($aTriOeuvresSession)!=0)
		{
			foreach ($aTriOeuvresSession as $k=>$aTri)
			{
				//echo "<br/> TRI $k<br/>";
				
				foreach ($aTri as $koTri=>$oTri)
				{
					if($oTri!="")
					{
												
						
						$sTri=$koTri.' '.$oTri;
						
						//echo "<br/> OTRI $koTri >";
						//ECHO $sTri;
						
					}						
						
				}
				
			}
			
			//die("<br/>DANS REPOSITORY TRI");
		}
		
		$query = $this->getEntityManager()
		->createQuery(
				'SELECT 
					o.id,
					o.actif,
					o.reference,
					o.titreOeuvre,
					 o.traductiontitreOeuvre,
					o.cote,
					t.id as idtpslliturgique,
					t.libelle AS tpslliturgique,
					g.id as idgenre,
				    g.libelle AS genre,
					v.id as idvoix,
					v.libelle AS voix,
				    c.id as idcompositeur,
					concat(c.prenom,\' \',c.nom) as compositeur,
					o.genre_id,
					f.id as idfonction,
					f.libelle AS fonction
					FROM oeuvresBundle:Oeuvres o 
				 LEFT JOIN oeuvresBundle:TempsLiturgiques t WHERE t.id=o.tps_litur_id 
				 LEFT JOIN oeuvresBundle:Compositeurs c WHERE c.id=o.compositeur_id 
				 LEFT JOIN oeuvresBundle:Genres g WHERE g.id=o.genre_id
				 LEFT JOIN oeuvresBundle:Voix v WHERE v.id=o.voix_id
				 LEFT JOIN oeuvresBundle:Accompagnements a WHERE a.id=o.accompagnement_id
				 LEFT JOIN oeuvresBundle:Fonctions f WHERE f.id=o.fonction_id having o.actif=1 '
				.$sWhere
				.' order by '.$sTri
		);
		
		// $query->andWhere('o.actif = ?', array(1));
		//die('filtre');
		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}		
		
	}
	/*
	 		->createQuery('SELECT.id,Oeuvres_id	FROM oeuvresBundle:Partitions WHERE Oeuvres_id = $id'
* 
	 */
	public function findPartitions($id)
	{
		
		/*$query = $this->getEntityManager()
		->createQuery('SELECT id,Oeuvres_id	FROM oeuvresBundle:Partitions'
		);
		
		SELECT `Oeuvres_id`
FROM `Partitions`
WHERE 1
LIMIT 0 , 30


		*/
		
		$query = $this->getEntityManager()
		->createQuery(
				"SELECT t.id,t.active,t.oeuvre_id,t.libelle,t.duree,t.datecreateAt,
				t.oeuvre_id,		
				t.pathfichier FROM oeuvresBundle:Partitions t
				WHERE t.active=1 and t.oeuvre_id=".$id
		);		
		/*
		 * SELECT `Oeuvres_id` FROM `Partitions` WHERE 1
		 */
		
		
		//$query->andWhere('o.Oeuvres_id = ?', $id);
		
		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	}
	
	public function getDossierTraductions()
	{
		/**
		 * aller chercher dans config
		 * @var string
		 */
		
		
		//incorret $sPathCible="/var/www/sites/mychorale/web/uploads/traductions";

		$sPathCible="../web/uploads/traductions";
		
		$mode=0755;
		
		try {
			if(!file_exists($sPathCible))
			{
				mkdir($sPathCible,$mode, true);
				
			}else 
			{
				//chmod($sPathCible, $mode);
				
			}
		}catch(ErrorException $e){
		
			var_dump($e->getMessage());
			echo "<br/><h1>dossier existant</h1>";
			
			die("pb fichier");
		}
		
		//die($sPathCible);
		
		return $sPathCible;
	}

	public function getDossierPartitions()
	{
		/**
		 * aller chercher dans config
		 * @var string
		 */
	
	
		$sPathCible="/var/www/sites/mychorale/web/uploads/partitions";
	
		$sPathCible="../web/uploads/partitions"; //ErrorException
		
		$mode=0755;
	
		try {
			if(!file_exists($sPathCible))
			{
				mkdir($sPathCible,$mode, true);
	
			}else
			{
				//chmod($sPathCible, $mode);
	
			}
		}catch(ErrorException $e){
	
			var_dump($e->getMessage());
			echo "<br/><h1>dossier inexistant</h1>";
	
			die("pb fichier");
		}
	
		//die($sPathCible);
	
		return $sPathCible;
	}
	
}