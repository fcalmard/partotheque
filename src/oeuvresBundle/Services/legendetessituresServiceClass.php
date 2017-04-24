<?php
namespace oeuvresBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface; // <- Add this

class legendetessituresServiceClass{ 
	
	private $container; // <- Add this
	
	/**
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		
		//$this->parameters = $container->parameters; // Then discard container to preclude temptation
		//echo ('CONSTRUCT mailerService');
		
		//$sTransport = $this->container->getParameter('my_mailer.transport'); // <- Access your param
		
		//echo "<br/> CONSTRUCT TRANSPORT >".$sTransport."<";
		
	}
	public function getContainer()
	{
		return $this->container;
	}
}
	?>