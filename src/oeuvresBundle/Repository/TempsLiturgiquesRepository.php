<?php

namespace oeuvresBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TypesmusiquesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TempsLiturgiquesRepository extends EntityRepository
{
	
	public function ChargeListe()
	{
		
		
		$query = $this->getEntityManager()
		->createQuery(
				'SELECT
				t.id,
				t.active,
				t.libelle,
				t.couleurdef,
				t.couleur,
				t.couleurfg,
				t.datecreateAt
				FROM oeuvresBundle:TempsLiturgiques t
				WHERE t.active=1 order by t.libelle'
		);
		
		// $query->andWhere('o.actif = ?', array(1));
		
		try {
			//return $query->getSingleResult();
				
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
		
		
	}
	
	public function getCouleurs($id)
	{
		//$aCoul=array();
		
		$oTps=null;
		$query = $this->getEntityManager()
		->createQuery(
				'SELECT
				t.id,
				t.active,
				t.libelle,
				t.couleurdef,
				t.couleur,
				t.couleurfg,
				t.datecreateAt
				FROM oeuvresBundle:TempsLiturgiques t
				WHERE t.active=1 and t.id='.$id.' order by t.libelle'
				);
		try {
			$oTps=$query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return $aCoul;
		}
		return array('couleurfg'=>$oTps[0]['couleurfg'],'couleur'=>$oTps[0]['couleur'],'couleurdef'=>$oTps[0]['couleurdef']);		
		
	}
	public function rechercheTempsLiturgique($sLibelle)
	{
		$id=0;
		
		$sLibelle=$this->epure($sLibelle);
		$sLibelle=sprintf("%s",$sLibelle);

		$sql="SELECT
				t.id from oeuvresBundle:TempsLiturgiques t
				WHERE t.libelle = '".$sLibelle."'";
	
		$query = $this->getEntityManager()
		->createQuery(
				$sql
				);
			
		try {
			$aIds=$query->getResult();				
			if(is_array($aIds) && count($aIds)>0)
			{
				foreach ($aIds as $kid=>$id)
				{
					$id=$id['id'];
				}
			}
		} catch (\Doctrine\ORM\NoResultException $e) {
			$id=0;
		}
	
	
		return $id;
	}
	
	
	/**
	 *
	 */
	public function insertionTempsLiturgique($sLibelle)
	{
	
		$idcree=0;
		$sLibelle=$this->epure($sLibelle);
		
		$sLibelle=strtolower($sLibelle);
		$sLibelle=ucfirst($sLibelle);
	
		$conn=$this->getEntityManager()->getConnection();
	
		$nowUtc = new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) );
	
		$s= $nowUtc->format('Y-m-d h:i:s');
		
		$dataArray=array('libelle'=>$sLibelle
				,'active'=>1
				,'couleur'=>'#FFFFFF'
				,'couleurdef'=>1
				,'couleurfg'=>'#000000'
				,'datecreateAt'=>$s
		);
	
		try {
			$bOk=$conn->insert('TempsLiturgiques', $dataArray);
	
		} catch (\Doctrine\ORM\NoResultException $e) {
			die("Erreur ".$e->getMessage());
		}
	
		$idcree=$conn->lastInsertId();
	
		return $idcree;
	
	}
		
	
	private function epure($texte)
	{
	
		;
		$texte = trim(strtolower($texte));
		$texte = htmlentities($texte, ENT_NOQUOTES, 'utf-8');
		$texte = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $texte);
		$texte = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $texte); // pour les ligatures
		$texte = preg_replace('#&[^;]+;#', '', $texte); // supprime les autres caractères
		$texte = preg_replace('#&[^;]+;#', '', $texte); // supprime les autres caractères
	
		$texte = strtr(
				$texte,
				'@ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ'.CHR(34),
				'aAAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'.chr(32)
				);
		
		//double cote et simple cote
	
		$texte=str_ireplace(chr(34), "", $texte);
		$texte=str_ireplace(chr(39), "", $texte);
	
		return $texte;
	}
	
	public function listeTempsLiturgique($sListeIds)
	{
		$aTpsLit=array();
		if($sListeIds!='')
		{
			$sql="SELECT
				t.id,t.libelle from oeuvresBundle:TempsLiturgiques t
				WHERE t.id in ".$sListeIds;
			
			
			//die($sql);
			
			$query = $this->getEntityManager()
			->createQuery(
					$sql
					);
				
			try {
				$aTpsLit=$query->getResult();
				if(is_array($aTpsLit) && count($aTpsLit)>0)
				{
					foreach ($aTpsLit as $kid=>$tpslit)
					{
						//echo "<br/>tpslit <br/>";
						//var_dump($aTpsLit);
					}
				}
			} catch (\Doctrine\ORM\NoResultException $e) {
				$aTpsLit=null;
			}
		}

	
	
		return $aTpsLit;
	}
	
	
	
}
