<?php
namespace oeuvresBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface; // <- Add this

class emailServiceClass { 
	
	private $container; // <- Add this
		
	/**
	 * 
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
				
		//$this->parameters = $container->parameters; // Then discard container to preclude temptation
		
		echo ('CONSTRUCT emailServiceClass');
	}
	
	public function sendEmail()
	{
		$this->container->getParameter(''); // <- Access your param
	}	
}
	?>