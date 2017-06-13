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
}
