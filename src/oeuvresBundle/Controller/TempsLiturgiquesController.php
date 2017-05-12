<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\TempsLiturgiques;
use oeuvresBundle\Form\TempsLiturgiquesType;

/**
 * TempsLiturgiques controller.
 *
 */
class TempsLiturgiquesController extends Controller
{

    /**
     * Lists all TempsLiturgiques entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->getRequest()->getSession();
        if($session)
        {
        	$gUserLoginLogged=$session->get('gUserLoginLogged');
        	 
        	 
        }
        if($gUserLoginLogged=='')
        {
        	return new RedirectResponse($this->generateUrl('homepage'));
        }
        
        $entities = $em->getRepository('oeuvresBundle:TempsLiturgiques')->ChargeListe();

        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=1;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
        
        
        return $this->render('oeuvresBundle:TempsLiturgiques:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function pagineAction($idxenreg,$sens,$action)
    {
    	$id=0;
    	$gUserLoginLogged="";
    	 
    	$iPage=1;
    
    	$sColDeTri="";
    	$sColDeTriOrdre="";
    
    	$session = $this->getRequest()->getSession();
    	if($session)
    	{
    		$gUserLoginLogged=$session->get('gUserLoginLogged');
    		 
    		 
    	}
    	if($gUserLoginLogged=='')
    	{
    		return new RedirectResponse($this->generateUrl('homepage'));
    	}
    	 
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_tempsliturgiques_tblenreg');
    	
    	
    	
    	/*
    	 * 
    	 */
    	//$aSessionTblEnreg=$session->get($gUserLoginLogged.'_oeuvres_tblenreg');
    	
    	//if(!is_null($aSessionTblEnreg))
    	//if($aSessionTblEnreg)
    	//{
    	
    	//var_dump($aSessionTblEnreg);
    	
    	$nbenreg=0;
    	 
    	$nbenreg=$aSessionTblEnreg['nbenreg'];
    	
    	//echo ("<br/>NB ENREG=".$nbenreg);
    	//echo ("<br/>IDXENREG=".$idxenreg);
    	
    	$aEnregId=$aSessionTblEnreg['tblenreg'];
    	
    	//    	$aSessionTblEnreg['tblenreg']=array('tblenreg'=>$aEnregId);
    	
    	//var_dump($aEnregId);//['tblenreg']
    	
    	$aTblIds=array();
    	foreach ($aEnregId as $iAe=>$aE)
    	{
    		$aTblIds[$iAe]=$aE;
    	}
    	
    	$this->tblEnregSauveSession($aEnregId, $idxenreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
    	
    	
    	//die("///325");
    	
    	if($idxenreg>0 && $idxenreg<$nbenreg+1)
    	{
    		//$id=$aE[$idxenreg-1];
    		//echo "<br/> 329 >$sens<br/>";
    	
    		if($sens=='prec')
    		{
    			if($idxenreg >1)
    			{
    				$idxenreg--;
    				$id=$aTblIds[$idxenreg];
    	
    			}
    	
    		}
    		if($sens=='suiv')
    		{
    			if($idxenreg<$nbenreg)
    			{
    				$id=$aTblIds[$idxenreg];
    	
    				//echo "<br/> avant de passer au suivant $idxenreg $nbenreg ID:$id<br/>";
    				$idxenreg++;
    				$id=$aTblIds[$idxenreg];
    				//echo "<br/> on passe au suivant $idxenreg $nbenreg ID:$id<br/>";
    					
    			}
    			//echo ("<br/>372 $id");
    		}
    		 
    	
    		 
    		$aEnregTri=$aSessionTblEnreg['tritempsliturgiques'];
    		foreach ($aEnregTri as $ket=>$aEnregTriPar)
    		{
    			//echo "<br/>A ENREGTRI PAR <br/>";
    			//var_dump($aEnregTriPar);
    			foreach ($aEnregTriPar as $ket2=>$aEnregTriPar2)
    			{
    				//echo "<br/>A ENREGTRI PAR NIVEAU2 $ket2<br/>";
    	
    				//var_dump($aEnregTriPar2);
    	
    			}
    	
    		}
    		 
    		$this->tblEnregSauveSession($aEnregId, $idxenreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);

    	}
    	 
    	/*
    	 * 
    	 */
    	if($id!=0)
    	{
    		if($action=='show')
    		{
    			return $this->redirect($this->generateUrl('tempsliturgiques_show', array('id' => $id)));
    	
    		}
    		if($action=='edit')
    		{
    			//die("399");
    			return $this->redirect($this->generateUrl('tempsliturgiques_edit', array('id' => $id)));		
    	
    		}
    	}else
    	{
    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
    		die("427");
    	}

    	return new RedirectResponse($this->generateUrl('tempsliturgiques'));
    	 
    }
    
    private function listeDesIds(&$entities)
    {
    	$aEnregId=array();
    	$c=0;
    	foreach ($entities as $entity)
    	{
    		$c++;
    		     		 
    		$aEnregId[$c]=$entity['id'];
    		 
    		/*if($c=$iNbEnregParPage)
    		 {
    		 
    		$iPage++;
    		 
    		}*/
    	}
    	return $aEnregId;
    }    
    
    public function tblEnregSauveSession($aEnregId,$iEnreg,$iPage,$sColDeTri,$sColDeTriOrdre,$gUserLoginLogged)
    {
    	$bOk=true;
    	 
    	/*
    	 * memoriser nbenreg liste des ids enreg en cours arguments de tri
    	*/
    	$aSessionTblEnreg=array();
    
    	//$aEnreg=array('nbenreg'=>count($entities));
    
    	$aSessionTblEnreg['nbenreg']=count($aEnregId);
    
    	$aSessionTblPageEnreg=array();
    	 
    	$iNbEnregParPage=15;
    	$aSessionTblPageEnreg['NbEnregParPage']=array('NbEnregParPage'=>$iNbEnregParPage);
    	 
    	$aSessionTblPageEnreg['PageEnCours']=array('PageEnCours'=>$iPage);
    
    	$aSessionTblEnreg['pagesenreg']=$aSessionTblPageEnreg;
       
    	$aSessionTblEnreg['tblenreg']=$aEnregId; 
    
    	$aSessionTblEnreg['enregencours']=$iEnreg;
    	 
    	$aEnregTri=array();
    	$aEnreg=array('coltrienreg'=>$sColDeTri);
    	$aEnregTri[]=$aEnreg;
    	$aEnreg=array('ordretrienreg'=>$sColDeTriOrdre);
    	$aEnregTri[]=$aEnreg;
    	 
    	$aSessionTblEnreg['tritempsliturgiques']=$aEnregTri;

    	$session = new Session();
    
    	$session->set($gUserLoginLogged.'_tempsliturgiques_tblenreg',$aSessionTblEnreg);
    
    	//var_dump($aSessionTblEnreg);
    
    	//die('139');
    	 
    	return $bOk;
    }
        
    /**
     * Creates a new TempsLiturgiques entity.
     *
     */
    public function createAction(Request $request)
    {
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$session = $this->getRequest()->getSession();
    	if($session)
    	{
    		$gUserLoginLogged=$session->get('gUserLoginLogged');
    	
    	
    	}
    	if($gUserLoginLogged=='')
    	{
    		return new RedirectResponse($this->generateUrl('homepage'));
    	}

    	$entity = new TempsLiturgiques();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($entity);
        	$em->flush();
        	
	        /*
	         * recalcul variable de session Accompagnements $aSessionTblEnreg
	        */
	        $last=$entity->getId();
	        
	        $iPage=1;
	        
	        $entities = $em->getRepository('oeuvresBundle:TempsLiturgiques')->ChargeListe();
	        
	        $aEnregId=$this->listeDesIds($entities);
	        
	        $aSessionTblEnreg=$session->get($gUserLoginLogged.'_tempsliturgiques_tblenreg');
	        
	        $aEnregTri=$aSessionTblEnreg['tritempsliturgiques'];
	        
	        $sColDeTri=(isset($aEnregTri['coltrienreg']) ? $aEnregTri['coltrienreg'] : "");
	        
	        $sColDeTriOrdre=(isset($aEnregTri['ordretrienreg']) ? $aEnregTri['coltrienreg'] : "");
	        
	        $nbenreg=$aSessionTblEnreg['nbenreg'];
	                
	        $iEnreg=1;
	        
	        foreach ($aEnregId as $ki=>$ae)
	        {
	        	if($ae==$last)
	        	{
	        		$iEnreg=$ki;
	        		break;
	        	}
	        }
	         
	        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
	                	        
	        $aEnregTri=array();
	        $aEnreg=array('coltrienreg'=>$sColDeTri);
	        $aEnregTri[]=$aEnreg;
	        $aEnreg=array('ordretrienreg'=>$sColDeTriOrdre);
	        $aEnregTri[]=$aEnreg;

            return $this->redirect($this->generateUrl('tempsliturgiques_show', array('id' => $last)));
        }

        return $this->render('oeuvresBundle:TempsLiturgiques:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TempsLiturgiques entity.
     *
     * @param TempsLiturgiques $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TempsLiturgiques $entity)
    {
        $form = $this->createForm(new TempsLiturgiquesType(), $entity, array(
            'action' => $this->generateUrl('tempsliturgiques_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TempsLiturgiques entity.
     *
     */
    public function newAction()
    {
        $entity = new TempsLiturgiques();
        $form   = $this->createCreateForm($entity);

        return $this->render('oeuvresBundle:TempsLiturgiques:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TempsLiturgiques entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:TempsLiturgiques')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'tempsliturgiques','id'=>$id)));
        	//throw $this->createNotFoundException('TempsLiturgiques inexistant.');
        }

        return $this->render('oeuvresBundle:TempsLiturgiques:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing TempsLiturgiques entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:TempsLiturgiques')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'tempsliturgiques','id'=>$id)));
        	
            //throw $this->createNotFoundException('Unable to find TempsLiturgiques entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('oeuvresBundle:TempsLiturgiques:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TempsLiturgiques entity.
    *
    * @param TempsLiturgiques $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TempsLiturgiques $entity)
    {
        $form = $this->createForm(new TempsLiturgiquesType(), $entity, array(
            'action' => $this->generateUrl('tempsliturgiques_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TempsLiturgiques entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:TempsLiturgiques')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TempsLiturgiques entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tempsliturgiques_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:TempsLiturgiques:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a TempsLiturgiques entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('oeuvresBundle:TempsLiturgiques')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Problème de lecture Temps Liturgiques.');
        }

        $entity->setActive(false);
           
        $em->flush();

        return $this->redirect($this->generateUrl('tempsliturgiques'));
    }

    public function confirmdeleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:TempsLiturgiques')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Genre.');
    	}
    
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    
    	return $this->render('oeuvresBundle:TempsLiturgiques:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    }
    /**
     * Creates a form to delete a Tempsliturgiques entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createConfirmDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('tempsliturgiques_delete', array('id' => $id)))
    	->add('submit', 'submit', array('label' => 'Oui'))
    	->getForm()
    	;
    }
    
}
