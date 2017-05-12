<?php

namespace oeuvresBundle\Controller;

use oeuvresBundle\Repository\MenusRepository;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Menus;
use oeuvresBundle\Form\MenusType;
/**
 * Menus controller.
 *
 */
class MenusController extends Controller
{

    /**
     * Lists all Menus entities.
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

        $entities = $em->getRepository('oeuvresBundle:Menus')->ChargeListe();

        return $this->render('oeuvresBundle:Menus:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Menus entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Menus();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->createListeResConfigRoutings($entity->getId());
            
            
            return $this->redirect($this->generateUrl('menus_show', array('id' => $entity->getId())));
        }

        return $this->render('oeuvresBundle:Menus:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Menus entity.
     *
     * @param Menus $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Menus $entity)
    {
        $form = $this->createForm(new MenusType(), $entity, array(
            'action' => $this->generateUrl('menus_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Menus entity.
     *
     */
    public function newAction()
    {
        $entity = new Menus();
        $form   = $this->createCreateForm($entity);

        
        
        return $this->render('oeuvresBundle:Menus:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Menus entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Menus')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'menus','id'=>$id)));
        	//throw $this->createNotFoundException('Unable to find Menus entity.');
        }


        return $this->render('oeuvresBundle:Menus:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Menus entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Menus')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'menus','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Menus entity.');
        }

        $editForm = $this->createEditForm($entity);

        $id_mensup=$entity->getIdMensup();
        
        
        return $this->render('oeuvresBundle:Menus:edit.html.twig', array(
            'entity'      => $entity,
        	'id_mensup'      => $id_mensup,
        	'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Menus entity.
    *
    * @param Menus $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Menus $entity)
    {
        $form = $this->createForm(new MenusType(), $entity, array(
            'action' => $this->generateUrl('menus_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Menus entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Menus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menus entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('menus_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Menus:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    
    /**
     * 
     * @param integer $id
     * @return array $aRoutings
     */
    private function createListeResConfigRoutings($id)
    {
    	$aRoutings=array();
    	

    	$em = $this->getDoctrine()->getManager();

    	//=new \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route($data);
    	
    	//$Route=new Route($path);
    	
    	//$aRoutings=new RouteCollection();
    	
    	return $aRoutings;
    }
}
