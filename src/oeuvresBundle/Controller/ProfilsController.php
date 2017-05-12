<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\Routing\Router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Profils;
use oeuvresBundle\Entity\Menus;
use oeuvresBundle\Form\ProfilsType;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Profils controller.
 *
 */
class ProfilsController extends Controller
{

    /**
     * Lists all Profils entities.
     *
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
        $em = $this->getDoctrine()->getManager();

        $routes=$this->listeRoutings();
        
        $entities = $em->getRepository('oeuvresBundle:Profils')->ChargeListe();

        return $this->render('oeuvresBundle:Profils:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Profils entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Profils();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('profils_show', array('id' => $entity->getId())));
        }

        return $this->render('oeuvresBundle:Profils:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Profils entity.
     *
     * @param Profils $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Profils $entity)
    {
        $form = $this->createForm(new ProfilsType(), $entity, array(
            'action' => $this->generateUrl('profils_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Profils entity.
     *
     */
    public function newAction()
    {
        $entity = new Profils();
        $form   = $this->createCreateForm($entity);

        return $this->render('oeuvresBundle:Profils:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Profils entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Profils')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'profils','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Profils entity.');
        }


        return $this->render('oeuvresBundle:Profils:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Profils entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Profils')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'profils','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Profils entity.');
        }
        

        $menus = $em->getRepository('oeuvresBundle:Menus')->ChargeListe();
        
        $editForm = $this->createEditForm($entity);
        
        $aMenus=$entity->getMenus();
        
        
        return $this->render('oeuvresBundle:Profils:edit.html.twig', array(
            'entity'      => $entity,
        	'menus'		=>$menus,
        	'aMenus'		=>$aMenus,
        	'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Profils entity.
    *
    * @param Profils $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Profils $entity)
    {
        $form = $this->createForm(new ProfilsType(), $entity, array(
            'action' => $this->generateUrl('profils_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Profils entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Profils')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profils entity.');
        }

        $editForm = $this->createEditForm($entity);
        
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
        	
        	if(isset($_POST['oeuvresbundle_profils']["Menus"]))
        	{       		
        		foreach ($_POST['oeuvresbundle_profils']["Menus"] as $idmenu)
        		{
        			
        			$oMenu=new Menus();
        			$oMenu = $em->getRepository('oeuvresBundle:Menus')->find($idmenu);
        			if (!$oMenu) {
        				throw $this->createNotFoundException('Unable to find Menus entity.');
        			}else
        			{
        				$s=$oMenu->getLibelleMenu();
        			       				
        				$entity->addMenu($oMenu);
        				
        			}        			 
        		}
        	}
        	
        	
        	
            $em->flush();

            return $this->redirect($this->generateUrl('profils_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Profils:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * 
     * @return multitype:NULL
     */
    public function listeRoutings()
    {
    	$routes = array();
    	
    	$i=0;
    	foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
    		$routes[$name] = $route->compile();
    		/*
    		$a=explode('_', $name);
    		echo "<br/>";
    		
    		if(count($a)==0)
    		{
    			var_dump($name);
    			 
    			 
    		}
    		var_dump($a);
    		echo "<br/> TAILLE A=".count($a);
    		
    		foreach ($a as $kn=>$aname)
    		{
    			var_dump($aname);
    		}
    		
    		    //		var_dump($routes[$name]);
    		//private ['private']
    		
    		//var_dump($routes[$name]);
    		*/
	   	}
	   	
	  
    	return $routes;    	
    }
    

    /**
     * Desactive a Profils entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Profils')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Profil.');
    	}
    
    	$entity->setActif(false);
    
    	$em->flush();
    	return $this->redirect($this->generateUrl('profils'));
    }
    
    
    
    public function confirmdeleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Profils')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Profil.');
    	}
    
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    	//die ('confirmdeleteAction 216');
    
    	return $this->render('oeuvresBundle:Profils:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    }
    /**
     * Creates a form to delete a Profil entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createConfirmDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('profils_delete', array('id' => $id)))
    	->add('submit', 'submit', array('label' => 'Oui'))
    	->getForm()
    	;
    }
        
}
