<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Repository\VoixRepository;

use oeuvresBundle\Entity\Souscategvoix;
use oeuvresBundle\Form\SouscategvoixType;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Souscategvoix controller.
 *
 */
class SouscategvoixController extends Controller
{

    /**
     * Lists all Souscategvoix entities.
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
        
        
        $entities = $em->getRepository('oeuvresBundle:Souscategvoix')->ChargeListe();

        
        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=1;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
                
        return $this->render('oeuvresBundle:Souscategvoix:index.html.twig', array(
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
    
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_souscategvoix_tblenreg');  	 
    	 
//  	var_dump($aSessionTblEnreg);
    	 
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
    		 
    		 
    		 
    		$aEnregTri=$aSessionTblEnreg['trisouscategvoix'];
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
    			return $this->redirect($this->generateUrl('sscategvoix_show', array('id' => $id)));
    			 
    		}
    		if($action=='edit')
    		{
    			//die("399");
    			return $this->redirect($this->generateUrl('sscategvoix_show', array('id' => $id)));
    			 
    		}
    	}else
    	{
    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
    		die("427");
    	}
    
    	return new RedirectResponse($this->generateUrl('souscategvoix'));
    
    }
    
    
    /**
     * Creates a new Souscategvoix entity.
     *
     */
    public function createAction(Request $request,$idvoix)
    {
        $entity = new Souscategvoix();
        $form = $this->createCreateForm($entity,$idvoix);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sscategvoix_show', array('id' => $entity->getId())));
        }

        return $this->render('oeuvresBundle:Souscategvoix:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Souscategvoix entity.
     *
     * @param Souscategvoix $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Souscategvoix $entity,$idvoix)
    {
    	$form = $this->createForm(new SouscategvoixType(), $entity, array(
            'action' => $this->generateUrl('sscategvoix_create',array('idvoix'=>$idvoix)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Souscategvoix entity.
     *
     */
    public function newAction($idvoix)
    {
        $entity = new Souscategvoix();
        $form   = $this->createCreateForm($entity,$idvoix);

        return $this->render('oeuvresBundle:Souscategvoix:edit.html.twig', array(
            'entity' => $entity,
        		'voix_id'=>$idvoix,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Souscategvoix entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Souscategvoix')->find($id);
        
        $voixid=$entity->getVoixId();
        
        $entityvoix = $em->getRepository('oeuvresBundle:Voix')->find($voixid);
        
        $slibvoix=$entityvoix->getLibelle();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Souscategvoix entity.');
        }

        return $this->render('oeuvresBundle:Souscategvoix:show.html.twig', array(
            'entity'      => $entity,
        		'voixid'=>$voixid,
                'slibvoix'=>$slibvoix
        ));
    }

    /**
     * Displays a form to edit an existing Souscategvoix entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Souscategvoix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Souscategvoix entity.');
        }

        $voix_id=$entity->getVoixId();
        
        $editForm = $this->createEditForm($entity);

        return $this->render('oeuvresBundle:Souscategvoix:edit.html.twig', array(
            'entity'      => $entity,
        		'voix_id'=>$voix_id,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Souscategvoix entity.
    *
    * @param Souscategvoix $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Souscategvoix $entity)
    {
        $form = $this->createForm(new SouscategvoixType(), $entity, array(
            'action' => $this->generateUrl('sscategvoix_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     *
     * @param $id
     */
    public function confirmdeleteAction($id)
    {
    
    	$em = $this->getDoctrine()->getManager();
    
    
    	$entity = $em->getRepository('oeuvresBundle:Souscategvoix')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Souscategvoix.');
    	}
    	//createConfirmDeleteForm confirmDelete.html.twig
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    	//	die('116');
    
    	return $this->render('oeuvresBundle:Souscategvoix:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    
    }
        
    /**
     * Edits an existing Souscategvoix entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Souscategvoix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Souscategvoix entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sscategvoix_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Souscategvoix:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Souscategvoix entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createConfirmDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('sscategvoix_delete', array('id' => $id)))
    	->add('submit', 'submit', array('label' => 'Oui'))
    	->getForm()
    	;
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
    	$entity = $em->getRepository('oeuvresBundle:Souscategvoix')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Souscategvoix.');
    	}
    	$entity->setActive(false);
    	$em->flush();
    
    	return $this->redirect($this->generateUrl('voix'));
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
    
    	$aSessionTblEnreg['trisouscategvoix']=$aEnregTri;
    		
    	$session = new Session();
    
    	$session->set($gUserLoginLogged.'_souscategvoix_tblenreg',$aSessionTblEnreg);
    
    	//var_dump($aSessionTblEnreg);
    
    	//die('139');
    
    	return $bOk;
    }
    
    

    
}
