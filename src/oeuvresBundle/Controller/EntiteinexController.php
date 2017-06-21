<?php

namespace oeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;


//use Symfony\Component\Translation\Tests\String;


use \Swift_Mailer;
use \Swift_MailTransport;

/**
 * 
 */
require_once dirname(__FILE__).'../../../../vendor/swiftmailer/swiftmailer/lib/swift_required.php';

//require 'PHPMailerAutoload.php';

//require_once dirname(__FILE__).'../../../../vendor/phpmailer/PHPMailerAutoload.php';

//require '../web/PHPMailerAutoload.php';
//require_once dirname(__FILE__).'../../../../web/PHPMailerAutoload';
//require_once '../../../web/PHPMailerAutoload';


class EntiteinexController extends Controller
{
	/**
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction()
    {
    	$gUserLoginLogged="";
    	$session = $this->getRequest()->getSession();
    	if($session)
    	{
    		$gUserLoginLogged=$session->get('gUserLoginLogged');
    	}
    	if($gUserLoginLogged=='')
    	{
    		return new RedirectResponse($this->generateUrl('homepage'));
    	}
    	return $this->render('oeuvresBundle:Entiteinex:index.html.twig');
	}
    /**
     * 
     * @param string $entite
     * @param integer $id
     */
    public function showAction($entite,$id)
    {
    	
    	//die('EntiteinexController showAction $entite >'.$entite.'< \$id>'.$id.'<');
    	return $this->render('oeuvresBundle:Entiteinex:index.html.twig',array('entite'=>$entite,'id'=>$id));
    	
    }
    
    public function erreur_showAction($message)
    {
    	//die('oeuvresBundle:Entiteinex:erreur_showAction  >'.$message.'<');
    	return $this->render('oeuvresBundle:Entiteinex:erreur.html.twig',array('message'=>$message));
    	
    }
    public function testmailerAction(){
   	
    	
    	require_once dirname(__FILE__).'/../../../web/phpmailer/PHPMailerAutoload.php';;
    	
    	
    	/**
    	 smtp.google.com
    	 fcalemard@gmail.com
    	 lanza2017    	 *
    	 */
    	
    	//Create a new PHPMailer instance
    	$mail = new \PHPMailer;
    	//Tell PHPMailer to use SMTP
    	$mail->isSMTP();
    	//Enable SMTP debugging
    	// 0 = off (for production use)
    	// 1 = client messages
    	// 2 = client and server messages
    	$mail->SMTPDebug = 2;
    	//Ask for HTML-friendly debug output
    	$mail->Debugoutput = 'html';
    	//Set the hostname of the mail server
    	$mail->Host = "smtp.gmail.com";
    	//Set the SMTP port number - likely to be 25, 465 or 587
    	$mail->Port = 25;
    	//Whether to use SMTP authentication
    	$mail->SMTPAuth = true;
    	//Username to use for SMTP authentication
    	$mail->Username = "fcalemard@gmail.com";
    	//Password to use for SMTP authentication
    	$mail->Password = "lanza2017";
    	//Set who the message is to be sent from
    	$mail->setFrom('fcalemard@gmail.com', 'First Last');
    	//Set an alternative reply-to address
    	$mail->addReplyTo('fcalemard@gmail.com', 'First Last');
    	//Set who the message is to be sent to
    	$mail->addAddress('fcalemard@gmail.com', 'John Doe');
    	//Set the subject line
    	$mail->Subject = 'PHPMailer SMTP test';
    	//Read an HTML message body from an external file, convert referenced images to embedded,
    	//convert HTML into a basic plain-text alternative body
    	$sdir=dirname(__FILE__);
    	
    	$s=$sdir.'/contents.html';

		$mail->msgHTML(file_get_contents($s), dirname(__FILE__));

		//Replace the plain text body with one created manually
    	$mail->AltBody = 'This is a plain-text message body';
    	//Attach an image file
    	$mail->addAttachment($sdir.'/images/phpmailer_mini.png');
    	
    	//send the message, check for errors
    	if (!$mail->send()) {
    		
    		$message = "Problème de messagerie : " . $mail->ErrorInfo;
    		
    		return $this->render('oeuvresBundle:Entiteinex:erreur.html.twig',array('message'=>$message));
    		
    	} else {
    		//echo "Message sent!";
    	}
    	
    	//require_once dirname(__FILE__).'../../../../vendor/phpmailer/PHPMailerAutoload.php';
    	
    	//require '../web/PHPMailerAutoload.php';
    	//require_once dirname(__FILE__).'../../../../web/PHPMailerAutoload';
    	//require_once '../../../web/PHPMailerAutoload';
    	
    	return $this->render('oeuvresBundle:Entiteinex:messageenvoye.html.twig');
    	
    }

}
