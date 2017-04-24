<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Oeuvres;
use oeuvresBundle\Entity\Partitions;
use oeuvresBundle\Form\PartitionsType;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Partitions controller.
 *
 */
class PartitionsController extends Controller
{

    /**
     * Lists all Partitions entities.
     *
     */
    public function indexAction($oeuvre_id)
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
        
        $entities=array();
        
        $entities = $em->getRepository('oeuvresBundle:Partitions')->findAll();
        
        return $this->render('oeuvresBundle:Partitions:index.html.twig', array(
            'entities' => $entities,
                    'oeuvre_id' => 11,
        ));
    }
    /**
     * Creates a new Partitions entity.
     *
     */
    public function createAction(Request $request,$oeuvre_id)
    {
        $entity = new Partitions();
    	$form = $this->createCreateForm($entity,$oeuvre_id);
    	
    	//$form->setAction($this->generateUrl('partitions_create_part'),array("oeuvre_id"=>$oeuvre_id));
    	
        $form->handleRequest($request);

        if ($form->isValid()) {
        
        	$em = $this->getDoctrine()->getManager();
        	 
       		$sFile=$this->deplace_upload($em);
       		
       		$entity->setPathfichier($sFile);
       		 
            $entity->setOeuvreId($oeuvre_id);
            
            $sdossier='99566';
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('oeuvres_edit', 
            		array('id' => $oeuvre_id,
            				'dossieroeuvre'=>$sdossier
            		
            )));
            //return $this->redirect($this->generateUrl('partitions_show', array('id' => $entity->getId(),'oeuvre_id'=>$oeuvre_id)));
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('oeuvresBundle:Partitions')->findAll();
        
        /*
         * retrouver l'oeuvre
         */
        $sdossier='';
        $repoOeuvre = $em->getRepository('oeuvresBundle:Oeuvres');
        
        $entityOeuvres = $repoOeuvre->find($oeuvre_id);
        if($entityOeuvres)
        {
        	$sdossier=$entityOeuvres->getReference();
        	 
        }
        
        
        
        $soeuvre=$entityOeuvres->getTitreoeuvre();
                
        return $this->render('oeuvresBundle:Partitions:edit.html.twig', array(
            'entity' => $entity,
        		'mode' => 'create',
        		'oeuvre_id'=>$oeuvre_id,
        		'dossieroeuvre'=>$sdossier,
        		'oeuvre'=>$soeuvre,
        		
            'edit_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Partitions entity.
     *
     * @param Partitions $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Partitions $entity,$oeuvre_id)
    {
    	
        $form = $this->createForm(new PartitionsType(), $entity, array(
            'action' => $this->generateUrl('partitions_create_part',array('oeuvre_id'=>$oeuvre_id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Partitions entity.
     *
     */
    public function newAction($oeuvre_id)
    {
        $entity = new Partitions();
        $form   = $this->createCreateForm($entity);

        
        $entityoeuvre = $em->getRepository('oeuvresBundle:Oeuvres')->find($oeuvre_id);
        if (!$entityoeuvre) {
        	throw $this->createNotFoundException('Probléme de recherche de la l oeuvre de la Partition.');
        }
        $soeuvre=$entityoeuvre->getTitreoeuvre();
        
        return $this->render('oeuvresBundle:Partitions:edit.html.twig', array(
            'entity' => $entity,
        		'oeuvre_id'=>$oeuvre_id,
        		'oeuvre'=>$soeuvre,
        		
            'edit_form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Partitions entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Partitions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partitions entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        return $this->render('oeuvresBundle:Partitions:show.html.twig', array(
            'entity'      => $entity,
        		'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Partitions entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Partitions')->find($id);
        if (!$entity) {
        	throw $this->createNotFoundException('Probléme de recherche de la Partition.');
        }
        $oeuvre_id=$entity->getOeuvreId();
        
        $entityoeuvre = $em->getRepository('oeuvresBundle:Oeuvres')->find($oeuvre_id);
        if (!$entityoeuvre) {
        	throw $this->createNotFoundException('Probléme de recherche de la l oeuvre de la Partition.');
        }        
        $soeuvre=$entityoeuvre->getTitreoeuvre();
        
        $sdossier=$entityoeuvre->getReference();
        
        $editForm = $this->createEditForm($entity);

        return $this->render('oeuvresBundle:Partitions:edit.html.twig', array(
            'entity'      => $entity,
        		'mode'=>'modif',
        		'oeuvre_id'=>$oeuvre_id,
        		'oeuvre'=>$soeuvre,
        		'dossieroeuvre'=>$sdossier,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Partitions entity.
    *
    * @param Partitions $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Partitions $entity)
    {
        $form = $this->createForm(new PartitionsType(), $entity, array(
            'action' => $this->generateUrl('partitions_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Partitions entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Partitions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partitions entity.');
        }
        $oeuvre_id=$entity->getOeuvreId();
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        $sFile=$this->deplace_upload($em);
        
        if ($editForm->isValid()) {
        	 
        	//die('236 updateAction');
        	 
        	$sFile=$this->deplace_upload($em);
        	 
        	$entity->setPathfichier($sFile);
        	 
        	$em->flush();          
            
            return $this->redirect($this->generateUrl('oeuvres_edit', array('id' => $oeuvre_id)));
            /*
            return $this->redirect($this->generateUrl('partitions_edit', 
            		array('id' => $id,
            				'oeuvre_id'=>$oeuvre_id            				
            		)));
            		*/
        }
       //die("252 updateAction");
        
        return $this->render('oeuvresBundle:Partitions:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'oeuvre_id'=>$oeuvre_id,        		
        ));
    }
    /**
     * 
     * @param unknown_type $em
     * @return string
     */
    private function deplace_upload($em)
    {
    	$sFile='suite test';
    	     	 
    	
    	//var_dump($_FILES);
    	$stmpFile="?";
    	 
    	if(isset($_FILES['oeuvresbundle_partitions']))
    	{
    		$oFiles=$_FILES['oeuvresbundle_partitions'];
    		//die("deplace_upload");
    		 
    		if($oFiles)
    		{
    		
    			$sTypeFile=$oFiles['type']['partitionFile'];
    			 
    			$sFile=$oFiles['name']['partitionFile'];
    		
    			$stmpFile=$oFiles['tmp_name']['partitionFile'];
    				
    			$sPathCible = $em->getRepository('oeuvresBundle:Oeuvres')->getDossierPartitions();
    		
    			$target_dir = $sPathCible . '/'.basename( $oFiles["name"]['partitionFile']);
    				
    			move_uploaded_file($stmpFile, $target_dir);
    		
    		}
    		//die($stmpFile);
    	}

    	 
    	return $sFile;
    	     	
    }
    /**
     * desactive entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
    	$form = $this->createConfirmDeleteForm($id);
    	$form->handleRequest($request);
    
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Partitions')->find($id);
    	 
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Partitions.');
    	}
    	$oeuvre_id=$entity->getOeuvreId();
    	 
    	$entity->setActive(false);
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('oeuvres_edit', array('id' => $oeuvre_id)));
    }

    /**
     *
     * @param $id
     */
    public function confirmdeleteAction($id)
    {
    
    	$em = $this->getDoctrine()->getManager();
    
    
    	$entity = $em->getRepository('oeuvresBundle:Partitions')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Partitions.');
    	}
    	//createConfirmDeleteForm confirmDelete.html.twig
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    	//	die('116');
    	$oeuvre_id=$entity->getOeuvreId();
    	 
    	return $this->render('oeuvresBundle:Partitions:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'oeuvre_id'	=>$oeuvre_id,
    			'confirm_form'=>$confirm_form->createView()
    	));
    
    }
    
    
    /**
     * Creates a form to delete a Partitions entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createConfirmDeleteForm($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	 
    	
    	$entity = $em->getRepository('oeuvresBundle:Partitions')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Partitions.');
    	}
    	$oeuvre_id=$entity->getOeuvreId();
    	 
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('partitions_delete', array('oeuvreid'=>$oeuvre_id,'id' => $id)))
    	->add('submit', 'submit', array('label' => 'Oui'))
    	->getForm()
    	;
    }   
    
}
