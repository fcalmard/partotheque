<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use oeuvresBundle\Entity\Instruments;
use oeuvresBundle\Form\InstrumentsType;
/**
 * Instruments controller.
 *
 */
class InstrumentsController extends Controller
{

    /**
     * Lists all Instruments entities.
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

        $entities = $em->getRepository('oeuvresBundle:Instruments')->ChargeListe();

        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=1;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
                        
        return $this->render('oeuvresBundle:Instruments:index.html.twig', array(
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
    
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_instruments_tblenreg');
    
    	var_dump($aSessionTblEnreg);
    
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
    		 
    		 
    		 
    		$aEnregTri=$aSessionTblEnreg['triinstruments'];
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
    			return $this->redirect($this->generateUrl('instruments_show', array('id' => $id)));
    	
    		}
    		if($action=='edit')
    		{
    			//die("399");
    			return $this->redirect($this->generateUrl('instruments_edit', array('id' => $id)));
    	
    		}
    	}else
    	{
    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
    		die("427");
    	}
    	
    	return new RedirectResponse($this->generateUrl('instruments'));
    	    	
    }
    /**
     * Creates a new Instruments entity.
     *
     */
    public function createAction(Request $request)
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
    	    	
        $entity = new Instruments();
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
            
            $entities = $em->getRepository('oeuvresBundle:Instruments')->ChargeListe();
            
            $aEnregId=$this->listeDesIds($entities);
            
            $aSessionTblEnreg=$session->get($gUserLoginLogged.'_instruments_tblenreg');
            
            $aEnregTri=$aSessionTblEnreg['triinstruments'];
            
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
                     
            /*
             *
            */
            
            return $this->redirect($this->generateUrl('instruments_show', array('id' => $entity->getId())));
        }

        return $this->render('oeuvresBundle:Instruments:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Instruments entity.
     *
     * @param Instruments $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Instruments $entity)
    {
        $form = $this->createForm(new InstrumentsType(), $entity, array(
            'action' => $this->generateUrl('instruments_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Instruments entity.
     *
     */
    public function newAction()
    {
        $entity = new Instruments();
        $form   = $this->createCreateForm($entity);

        return $this->render('oeuvresBundle:Instruments:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Instruments entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Instruments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instruments entity.');
        }

        return $this->render('oeuvresBundle:Instruments:show.html.twig', array(
            'entity'      => $entity
        ));
    }

    /**
     * Displays a form to edit an existing Instruments entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Instruments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instruments entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('oeuvresBundle:Instruments:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Instruments entity.
    *
    * @param Instruments $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Instruments $entity)
    {
        $form = $this->createForm(new InstrumentsType(), $entity, array(
            'action' => $this->generateUrl('instruments_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Instruments entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Instruments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instruments entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('instruments_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Instruments:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Instruments entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('oeuvresBundle:Instruments')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Instruments entity.');
            }
            $entity->setActive(false);
            
            $em->flush();

        return $this->redirect($this->generateUrl('instruments'));
    }

    /**
     * Creates a form to delete a Instruments entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('instruments_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     *
     * @param Integer $id
     */
    public function confirmdeleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Instruments')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Instrument.');
    	}
    	//createConfirmDeleteForm confirmDelete.html.twig
    
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    
    	return $this->render('oeuvresBundle:Instruments:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    }
    
    /**
     * Creates a form to delete a instruments entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createConfirmDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('instruments_delete', array('id' => $id)))
    	->add('submit', 'submit', array('label' => 'Oui'))
    	->getForm()
    	;
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
    
    	$aSessionTblEnreg['triinstruments']=$aEnregTri;
    
    	$session = new Session();
    
    	$session->set($gUserLoginLogged.'_instruments_tblenreg',$aSessionTblEnreg);
    
    	//var_dump($aSessionTblEnreg);
    
    	//die('139');
    
    	return $bOk;
    }    
        
}
