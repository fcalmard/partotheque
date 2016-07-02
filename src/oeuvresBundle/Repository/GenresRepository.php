<?php

namespace oeuvresBundle\Repository;

use Doctrine\DBAL\Driver\PDOConnection;

use Doctrine\DBAL\Driver\PDOSqlite\Driver;

use Doctrine\ORM\EntityRepository;

//use \Doctrine\DBAL\Driver\Mysqli\MysqliConnection;

use Doctrine\ORM\Persisters\BasicEntityPersister;

/**
 * GenresRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GenresRepository extends EntityRepository
{

	
	public function ChargeListe()
	{
	
	
		$query = $this->getEntityManager()
		->createQuery(
				'SELECT
				t.id,
				t.active,t.code,
				
				t.libelle,
				t.datecreateAt
				FROM oeuvresBundle:Genres t
				WHERE t.active=1'
		);
		
		try {
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	
	
	}
	
}