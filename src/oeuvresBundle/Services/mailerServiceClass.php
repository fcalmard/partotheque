<?php
namespace oeuvresBundle\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
/*
use Symfony\Component\Translation\Tests\String;

use Symfony\Component\DependencyInjection\ContainerInterface; // <- Add this
*/
class mailerServiceClass { 
	
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
		
		$sTransport = $this->container->getParameter('my_mailer.transport'); // <- Access your param
		
		//echo "<br/> CONSTRUCT TRANSPORT >".$sTransport."<";
				
	}
	public function getContainer()
	{
		return $this->container;
	}
	/**
	 * 
	 * @param string $to
	 */
	public function sendEmail(Symfony\Component\Translation\Tests\String $to
			,Symfony\Component\Translation\Tests\String $subject
			,Symfony\Component\Translation\Tests\String $message)
	{
		$sTransport = $this->container->getParameter('my_mailer.transport'); // <- Access your param
		
		$errLevel = error_reporting(E_ALL ^ E_NOTICE);  // suppress NOTICEs
		
		try {
			$message = str_replace("\n.", "\n..", $message);
			
			$bok=mail($to,$subject,$message);
			
		} catch (Exception $e) {
			die("ERREUR SEND MAIL ".$e->getMessage());
		}
		
		error_reporting($errLevel);  // restore old error levels
	
		//echo "<br/> send email TRANSPORT >".$sTransport."<";
		
		return $bok;
	}	
}
	?>