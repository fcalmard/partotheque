<?php

namespace oeuvresBundle\Repository;

/**
 * InstrumentsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InstrumentsRepository extends \Doctrine\ORM\EntityRepository
{
	
	public function ChargeListe($aFiltres=null)
		{
			/*
			 * instrument
			 */
			$btous='1';
			$sinstrument='';
			if(isset($aFiltres) & is_array($aFiltres) & count($aFiltres)!=0)
			{
				$sinstrument=(isset($aFiltres['instrument'])) ? $aFiltres['instrument'] : '';
				$btous=(isset($aFiltres['tous'])) ? $aFiltres['tous'] : 0 ;
			}	
			$sSql='SELECT
					t.id,
					t.active,
					t.libelle,
					t.datecreateAt
					FROM oeuvresBundle:Instruments t ';
			
			
			$sSql.=' where ';
			
			if($btous=='2')
			{
				$sSql.='t.active=0';
			}
			else{
				$sSql.='t.active=1';
				$btous=($btous=='1');
				
				if(!$btous && $sinstrument!='')
				{
					$s=sprintf("%s",$sinstrument);
					$sSql.=" and (t.libelle like '%$s%'";
					$sSql.=" or t.libelle = '$sinstrument')";
				}
			}
			
			$sSql.=' order by t.libelle';
			
			$query = $this->getEntityManager()
			->createQuery($sSql);
				
			try {
				return $query->getResult();
			} catch (\Doctrine\ORM\NoResultException $e) {
				return null;
			}
				
		}
			
}
