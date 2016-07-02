<?php

namespace oeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
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
    		//return new RedirectResponse($this->generateUrl('homepage'));
    	}
    	//echo "<br/>".$gUserLoginLogged;
    	//die("DEFAULT INDEX ACTION");

    	return $this->render('oeuvresBundle:Default:index.html.twig');
    }
}
