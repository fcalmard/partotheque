<?php
namespace oeuvresBundle\Services;

use Symfony\Component\Form\Extension\Templating\TemplatingRendererEngine;

use Symfony\Component\DependencyInjection\ContainerInterface; // <- Add this
use \Swift_Mailer;
use \Swift_MailTransport;
//use Symfony\Component\Templating\EngineInterface;
//use TemplatingRendererEngine;
use Symfony\Component\Templating\EngineInterface;

class messageServiceClass { 
	
	protected $mailer;
	
	protected $templating;
	//\Swift_Mailer $mailer, EngineInterface $templating
	//\Swift_Mailer $mailer
	public function __construct()
	{
			
		$oTrans=new Swift_MailTransport();
		
		$mailer= new Swift_Mailer($oTrans);
				
		//$o=new EngineInterface();
		$templating= new TemplatingRendererEngine(EngineInterface);
		
		$this->mailer = $mailer;
		echo ('<br/>__construct messageServiceClass 30');
		$this->templating = $templating;
		echo ('<br/>__construct messageServiceClass 32');
		
		
		
		$message = $mailer->createMessage()
		->setSubject('You have Completed Registration!')
		->setFrom('fcalemard@gmail.com')
		->setTo('fcalemard@gmail.com')
		->setBody(
				$this->renderView(
						// app/Resources/views/Emails/registration.html.twig
						'Emails/registration.html.twig',
						array('name' => $nom)
				),
				'text/html'
		);
		
		$bOk=$mailer->send($message);
				
		if($bOk)
		{
			echo "<br/>OK";
		}
		else
		{
			echo "<br/> PAS OK";
		}
		echo ('<br/>mailerService>FIN CONSTRUCT messageServiceClass');
		
	}
	/*	
	public function __construct(mailerServiceClass $mailer)
	{
		$this->mailer = $mailer;
				
		$omailerContainer = $this->mailer->getContainer();
		
		$sTransport=$omailerContainer->getParameter('my_mailer.transport'); // <- Access your param
		
		echo ('<br/>mailerService>CONSTRUCT messageServiceClass');
		echo ('<br/>mailerService>CONSTRUCT PARAMETRE container Transport>'.$sTransport."<");
		
	}
	sendEmail
		$to,$message
	
	*/
	
	/**
	 * 
	 * @param String $nom
	 */
	public function sendEmail(String $nom)
	{
		$bOk=false;
		echo ('<br/>mailerService sendEmail 88');
		
		$mailer = $this->mailer;
		/*
		echo ('<br/>mailerService sendEmail 52');
		
		$message = $mailer->createMessage()
		->setSubject('You have Completed Registration!')
		->setFrom('fcalemard@gmail.com')
		->setTo('fcalemard@gmail.com')
		->setBody(
				$this->renderView(
						// app/Resources/views/Emails/registration.html.twig
						'Emails/registration.html.twig',
						array('name' => $nom)
				),
				'text/html'
		);
		echo ('<br/>mailerService sendEmail 66');
		
		$bOk=$mailer->send($message);
		*/
		return $bOk;
		
		//$this->container->getParameter(''); // <- Access your param
	}	
}
	?>