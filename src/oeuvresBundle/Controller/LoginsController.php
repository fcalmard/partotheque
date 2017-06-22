<?php

namespace oeuvresBundle\Controller;



use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Logins;
use oeuvresBundle\Form\LoginsType;
use oeuvresBundle\Form\LoginAskNewMdpType;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Logins controller.
 *
 */
class LoginsController extends Controller
{

    /**
     * Lists all Logins entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('oeuvresBundle:Logins')->findAll();

        return $this->render('oeuvresBundle:Logins:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function mdpperduAction(Request $request)
    {
    	
    	$form=$this->createAskMdpForm();
    	 
    	$form->handleRequest($request);
    	
    	$message="";
    	
    	if ($form->isValid()) {

    		$email="";
    		    		
    		if (isset($_POST['oeuvresbundle_newmdp']['email']))
    		{
    			$email=$_POST['oeuvresbundle_newmdp']['email'];
    			    			
    			$em = $this->getDoctrine()->getManager();
    			
    			$oUtil=$em->getRepository('oeuvresBundle:Utilisateurs');
    			
    			$b=$oUtil->ControleEmail($email);   			 
    			 
    			if($b)
    			{
    				return $this->redirect($this->generateUrl('sendnewmdp', array('email' => $email)));
    				
    			}else
    			{
    				$message="Votre email ( $email ) n'est pas enregistré ";
    			}   			 
    		}	
    	}
    	return $this->render('oeuvresBundle:Logins:mdpperdu.html.twig', array(
    			'form'   => $form->createView(),
    			'message'=>$message
    			));
    	    	
    }
    
    public function sendnewmdpAction(){
    	
    	
    	$email=isset($_POST['oeuvresbundle_newmdp']['email']) ? $_POST['oeuvresbundle_newmdp']['email'] : '';

    	if($email=='')
    	{
    		return new RedirectResponse($this->generateUrl('homepage'));
    	}
    	
    	
    	require_once dirname(__FILE__).'/../../../web/phpmailer/PHPMailerAutoload.php';;
    	
    	$pcl="Les petits chanteurs de Lyon";
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$oUtil=$em->getRepository('oeuvresBundle:Utilisateurs');
    	
    	/*
    	 * generation aleatoire mdp
    	 */
    	$snewmdp=$oUtil->genPassword();
    	    	
    	$object="Votre mot de passe partothèque/PCL";
    	$object=utf8_decode($object);
    	
    	$txtmessage="Les petis chanteurs de Lyon vous envoie votre nouveau mot de passe : ".$snewmdp;
    	$txtmessage=utf8_decode($txtmessage);
    	
    	
    	/**
    	 * mise à jour du mot de passe utilisateur
    	 */
    	$oUtil->miseajourmdp($email,$snewmdp);
    	
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
    	$mail->SMTPDebug = 0;
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
    	$mail->setFrom('fcalemard@gmail.com', $pcl);
    	//Set an alternative reply-to address
    	$mail->addReplyTo('fcalemard@gmail.com', $pcl);
    	//Set who the message is to be sent to
    	$mail->addAddress($email, 'Albert Doe');
    	//Set the subject line
    	$mail->Subject = $object;
    	//Read an HTML message body from an external file, convert referenced images to embedded,
    	//convert HTML into a basic plain-text alternative body

    	//$message="Veuillez trouvez ci-contre votre nouveau mot de passe";
    	
    	$sA="<a href='http://www.mychorale.fr/'>accés à la partothéque</a>";
    	$sA=utf8_decode($sA);
    	
    	$message="<html><h1>".$txtmessage."</h1>".$sA."</html>";
    	$mail->msgHTML($message);
    	
    	//Replace the plain text body with one created manually
    	$mail->AltBody = $txtmessage;

    	//Attach an image file
    	
    	//$sdir=dirname(__FILE__);
    	
    	//$mail->addAttachment($sdir.'/images/phpmailer_mini.png');
    	
    	//send the message, check for errors
    	if (!$mail->send()) {
    		
    		$message= "Problème de messagerie : " . $mail->ErrorInfo;
    		
    		return $this->render('oeuvresBundle:Entiteinex:erreur.html.twig',array('message'=>$message));
    		
    	} else {
    		//echo "Message sent!";
    	}
    	
    	
    	return $this->render('oeuvresBundle:Entiteinex:messageenvoye.html.twig');
    	
    }
    
    public function unlogAction()
    {
    	$session = $this->getRequest()->getSession();
    	//$gUserLoginLogged='';
    	if($session)
    	{
    		$login=$session->get('gUserLoginLogged', '');
    		
    		$profilencours=$session->get('CodeProfilEnCours','' );
    		
    		$session->set('aMenusProfil_'.$login, '');
    		
    		$session->set('gUserLoginLogged', '');
    		$session->set('aMenusProfil', '');  	
    		
    		$session->remove('aMenusProfil_'.$login);
    		
    		$session->remove('aMenusProfil');
    		
    		$session->remove('aMenusProfil_'.$profilencours);    		
	    	
    	}
    	return $this->redirect($this->generateUrl('homepage'));
    	 
    }
                
    /**
     * Creates a new Logins entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Logins();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
     
        echo ('create action');
        
        if ($form->isValid()) {
        	
        	$em = $this->getDoctrine()->getManager();
        	
        	/*
				oeuvresbundle_logins
        	 */
        	$post = $request->request->get('oeuvresbundle_logins');
        	$login=$post['login'];
        	
        	$bOk=true;
        	
        	/*
        	 * 
        	 */
        	$iProfil= $em->getRepository('oeuvresBundle:Utilisateurs')->ControleLogin($login);
        	$bOk=($iProfil!=0) ? true : false;
        	if($bOk)
        	{
	        	$sMdp=$post['pwd'];
	        	
	        	$stmsp=md5($sMdp);
	        		        	
	        	$stmsp=$sMdp;
	        	
	        	$iUtilisateur=$em->getRepository('oeuvresBundle:Utilisateurs')->controlemdplogin($login,$stmsp);
	        	
//	        	echo "<br/> 255 $login 	$sMdp $stmsp <br/>IDU=$iUtilisateur";
	        	
	        	$bOk= ($iUtilisateur!=0);

	        	if($bOk)
	        	{
	        		$session = new Session();
	        		
	        		$session->set('gUserLoginLogged', $login);
	        		 
	        		$entityProfils = $em->getRepository('oeuvresBundle:Profils')->find($iProfil);
	        		$sP="";
	        		
	        		$profilencours="";
	        		
	        		$aMenusProfil=array();	     
	        		$aMenusProfilSession=array();
	        		if($entityProfils)
	        		{
	        			$sP=$entityProfils->getLibelleProfil();
	        			
	        			$profilencours=$entityProfils->getCodeProfil();
	        			
	        			$aMenusProfil=$entityProfils->getMenusActif();
	        			
	        			//die('282');
	        			
	        			foreach ($aMenusProfil as $kmenu=>$oMenu)
	        			{
	        				//charger menu premiere ligne
	        				
	        				if($oMenu->getIdMensup()==0)
	        				{
	        					
	        					$iMenu=$oMenu->getId();
	        					
	        					$sMenu=$oMenu->getLibelleMenu();
	        					 
	        					$sLienMenu=$oMenu->getLnk();
	        					
	        					$iOrdreAff=$oMenu->getOrdreaff();
	        					
	        					//echo "<br/>LIBELLEMENU >$kmenu $sMenu >$sLienMenu<";
	        					
	        					$aSousMenus=array();
	        					
	        					foreach ($aMenusProfil as $kssmenu=>$oSsMenu)
	        					{
	        						$iMenuParent=$oSsMenu->getIdMensup();
	        						if($iMenuParent==$iMenu)
	        						{	        						 
		        						$LibelleSsMenu=$oSsMenu->getLibelleMenu();
		        						$sLienSsMenu=$oSsMenu->getLnk();	        						
		        						$iOrdreAffSsMenu=$oSsMenu->getOrdreaff();
		        						$aSsMenus=array("niveau"=>1,"LibelleMenu"=>$LibelleSsMenu,"LnkMenu"=>$sLienSsMenu,"Ordreaff"=>$iOrdreAffSsMenu);
		        						$aSousMenus[]=$aSsMenus;
	        						}
	        						 
	        					}
	        					
	        					$niveau=array();
	        					$Ordreaff=array();
	        					foreach ($aSousMenus as $key => $row)
	        					{
	        						$niveau[$key]  = $row['niveau'];
	        						$Ordreaff[$key]  = $row['Ordreaff'];
	        					
	        					}
	        					
	        					array_multisort($niveau, SORT_ASC, $Ordreaff, SORT_ASC, $aSousMenus);
	        						        					
	        					$aMenus=array("niveau"=>0,"LibelleMenu"=>$sMenu,"LnkMenu"=>$sLienMenu,"Ordreaff"=>$iOrdreAff,"SousMenus"=>$aSousMenus);
	        					
	        					/*
	        					 * trier par niveau  Ordreaff
	        					*/
	        					
	        					$aMenusProfilSession[]=$aMenus;	        					
	        				}

	        			}
	        			
	        			$profilencoursTrie=array();
	        			
	        			$niveau=array();
	        			$Ordreaff=array();
	        			foreach ($aMenusProfilSession as $key => $row)
	        			{
	        				$niveau[$key]  = $row['niveau'];
	        				$Ordreaff[$key]  = $row['Ordreaff'];
	        			
	        			}
	        			
	        			array_multisort($niveau, SORT_ASC, $Ordreaff, SORT_ASC, $aMenusProfilSession);
	        				 
        				//echo "<br/> APRES TRI <br/>";
        				foreach ($aMenusProfilSession as $kd => $odata)
        				{
        					//echo "<br/> $kd<br/>";
        					//var_dump($odata);
        					foreach ($odata as $ko=>$okdata)
        					{
        						//echo "<br/> $ko<br/>";
        						//var_dump($okdata);
        					}
        				
        				}	        				
	        				
        				$bOk= $em->getRepository('oeuvresBundle:Utilisateurs')->initProfil($login);
        				
        				$bok=false;
        				
	        			$session->set('CodeProfilEnCours', $profilencours);
	        			
	        			$session->set('aMenusProfil_'.$profilencours, $aMenusProfilSession);
	        			
	        			//die("<br/> fin liste menu");
	        			
	        		}
	        		
	        		$session->set('aMenusProfil_'.$login, $aMenusProfil);
	        		 
	        		$session->remove('aMenusProfil_'.$login);
	        		 
	        		$sU="";
	        		if($iUtilisateur!=0)
	        		{
	        			$entityUtilisateur = $em->getRepository('oeuvresBundle:Utilisateurs')->find($iUtilisateur);
	        			if($entityUtilisateur)
	        			{
	        				$sU=$entityUtilisateur->getNom();
	        			}
	        		}       		 
	        		 
	        		//die("<br/>createAction $login $sU $sP");
	        		
	        		
	        		
	        		
	        		/*
	        		 * rechercher profil utilisateur
	        		 */
	        		
	        		//$this->container->get('request')->getSession()->set('info', $session);
	        		
	        		//$aSessionOffres=array('Offres'=>array('tri'=>'datecand','order'=>'desc'));
	        		
	        		//$aSession=array($sLogin=>$aSessionOffres);
	        			
	        		//$session->set('aSession', $aSession);
	        		
	        		return $this->redirect($this->generateUrl('homepage'));
	        		
	        	}
	        	else
	        	{
	        		//die("<br/>ECHEC CONNEXION");
	        		$message="Mot de passe ou login invalide";
	        		return $this->redirect($this->generateUrl('logins_message', array('message' => $message)));      		 
	        	}
        	}else
        	{
        		$message="Mot de passe ou login invalide ou desactivé";
        		return $this->redirect($this->generateUrl('logins_message', array('message' => $message)));        		
        		//die("<br/>LOGIN INEXISTANT");
        		
        	}
	        	
        	/*
    		$this->getDoctrine()->getRepository('MyJobsMainBundle:Profils')
    		
    		$this->getDoctrine()->getRepository('MyJobsMainBundle:Utilisateurs')
    		 * 
        	  */
        	//die('CONNEXTION OK');
        	 
        	/*
        	 * 
        	 * recherche utilisateur
        	 * 
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('logins_show', array('id' => $entity->getId())));
            */
        }

        return $this->render('oeuvresBundle:Logins:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Creates a form to create a Logins entity.
     *
     * @param Logins $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Logins $entity)
    {
        $form = $this->createForm(new LoginsType(), $entity, array(
            'action' => $this->generateUrl('logins_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Logins entity.
     *
     */
    public function newAction()
    {
        $entity = new Logins();
        $form   = $this->createCreateForm($entity);
       
        if($this->container)
        {
        	$container=$this->container;
        }
       
         //die('<br/>LoginsController FIN newAction');
       
        return $this->render('oeuvresBundle:Logins:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Logins entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Logins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logins entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('oeuvresBundle:Logins:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Logins entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Logins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logins entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('oeuvresBundle:Logins:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Logins entity.
    *
    * @param Logins $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Logins $entity)
    {
        $form = $this->createForm(new LoginsType(), $entity, array(
            'action' => $this->generateUrl('logins_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Creates a form pour la saisie d'un email envoie de mot de passe
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAskMdpForm()
    {
    	$form = $this->createForm(new LoginAskNewMdpType(),null, array(
    			'action' => $this->generateUrl('sendnewmdp'),
    			'method' => 'POST',
    	));
/**
    	$form = $this->createForm(new LoginAskNewMdpType(),null, array(
    			'action' => $this->generateUrl('sendnewmdp',array('email'=>' ')),
    			'method' => 'POST',
    	));
 * 
 */
    	$form->add('submit', 'submit', array('label' => 'Update'));
    	return $form;
    }    
    /**
     * Edits an existing Logins entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Logins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logins entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('logins_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Logins:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Logins entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('oeuvresBundle:Logins')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Logins entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('logins'));
    }

    /**
     * Creates a form to delete a Logins entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logins_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    private function envoieMessage()
    {
    	/**
    	 *
    	 */
    	
    	$mailer = $this->get('mailer');
    	
    	$name="dupont marcel";
    	
    	$object="tests de messagerie gmail";
    	
    	$message="Pour récuperer votre mot de passe clickez sur le lien suivant";
    	
    	
    	/*
    	 * If you also want to include a plaintext version of the message
    	->addPart(
    			$this->renderView(
    					'Emails/registration.txt.twig',
    					array('name' => $name)
    			),
    			'text/plain'
    	)
    	*/
    	$to="cvinsonsylvie@gmail.com";
    	
    	$to="fcalemard@gmail.com";
    	
    	$from="fcalemard@gmail.com";
    	
    	$message = $mailer->createMessage()
    	->setSubject($object)
    	->setFrom($from)
    	->setTo($from)
    	 
    	->setBody(
    			$this->renderView(
    					// app/Resources/views/Emails/registration.html.twig
    					'Emails/messagesimple.html.twig',
    					array('message' => $message)
    			),
    			'text/html'
    	);
    	 
    	// ENVOIE MESSAGE
    	$bOk=$mailer->send($message);
    	if($bOk==1)
    	{
    		echo "<h1>Message envoyé à $to</h1>";
    	}
    		/**
    		*
    		*/
    	return $bOk;    	
    }
    
    public function messageAction($message)
    {
    	return $this->render('oeuvresBundle:Logins:message.html.twig', array(
    			'message'      => $message,
    	));
    }
        
}

