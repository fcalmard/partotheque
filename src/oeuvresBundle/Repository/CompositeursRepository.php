<?php

namespace oeuvresBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CompositeursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompositeursRepository extends EntityRepository
{

	public function ChargeListe()
	{
		
			$query = $this->getEntityManager()
			->createQuery(
					'SELECT
					t.id,
					t.active,
					t.prenom,
					t.nom,
					t.nationalite,
					t.datenaiss,
					t.datedeces,
					t.datecreateAt
					FROM oeuvresBundle:Compositeurs t
					WHERE t.active=1 order by t.nom,t.prenom'
			);
			
			try {
				return $query->getResult();
			} catch (\Doctrine\ORM\NoResultException $e) {
				return null;
			}
		
	}
	
	public function ChargeListeIds($sNom)
	{
		
		$sListeIds="";
		
		$s=sprintf("%s",$sNom);
		
		$sql="SELECT
				t.id from oeuvresBundle:Compositeurs t
				WHERE t.active=1 and t.nom like '%".$s."%'";
		
		$sql.=" or t.prenom like '%".$s."%'";
		//echo "<br/>ChargeListeIds >".$sql."<";
		
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
					$sListeIds.=($sListeIds!="") ? "," : "";
										
					$sListeIds.=$id['id'];
				}
			}
		} catch (\Doctrine\ORM\NoResultException $e) {
			$sListeIds="";
		}
		return $sListeIds;
		
	}
}
