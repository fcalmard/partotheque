<?php

namespace oeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\SecurityBundle\Tests\Functional\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

use Symfony\Component\Security\Http\Firewall\ContextListener;

class EntiteinexController extends Controller
{
	/**
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction()
    {
    	//die('EntiteinexController indexAction ');
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
		    	//echo "<br/>".$gUserLoginLogged;
		    	//die("DEFAULT INDEX ACTION");
		    	
		//$this->getRequest()->getc
		
		    	/**
		    	 * 
		    	 * @var ContextListener $context
		    	 */
		    	//$cl=new ContextListener($this->container);
		    	//var_dump($cl);
    	
    		//$context["legendetessitures"] = "legendetessitures from DefaultController";
	    	//var_dump($context);
	    	//die("DEFAULT INDEX ACTION");
    	
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
}
