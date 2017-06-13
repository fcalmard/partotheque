<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Typesmusiques;
use oeuvresBundle\Form\TypesmusiquesType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use oeuvresBundle\Form\TypesMusiquesFiltreType;

/**
 * Typesmusiques controller.
 *
 */
class TypesmusiquesController extends Controller
{

    /**
     * Lists all Typesmusiques entities.
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

    	$aFiltres= $session->get($gUserLoginLogged.'_typesmusiques_filtres');
    	
    	$stypesmusique=$aFiltres['typesmusique'];
    	
    	$btous=$aFiltres['tous'];
    	
        $entities = $em->getRepository('oeuvresBundle:Typesmusiques')->ChargeListe($aFiltres);
        
        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=1;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";

      	$filtre_form=$this->filtreCreateForm();
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
                
        return $this->render('oeuvresBundle:Typesmusiques:index.html.twig', array(
            'entities' => $entities
        		,'filtre_form'   => $filtre_form->createView()
        		,'typesmusique'=>$stypesmusique
        		,'tous'=>$btous
        ));
    }
    
    public function filtrerAction(Request $request,bool $tous)
    {
    	/**
    	 * retour à la liste filtrée
    	 */
    	//var_dump($tous);
    	//die('filtrerAction  retour à la liste filtrée');
    	    	
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
    	
    	$post= $request->request->get('oeuvresbundle_filtre_typesmusiques');
    	$stypesmusique=$post['typesmusique'];
    	$tous=isset($post['tous']) ? $post['tous'] : 0;
    	
    	var_dump($post);

    	$session = new Session();
    	
    	$aFiltres=array('typesmusique'=>$stypesmusique,'tous'=>$tous);
    	
    	
    	$session->set($gUserLoginLogged.'_typesmusiques_filtres',$aFiltres);
    	
    	
    	$entities = $em->getRepository('oeuvresBundle:Typesmusiques')->ChargeListe($post);
    	
    	$filtre_form=$this->filtreCreateForm();
    	
    	//var_dump($banonyme);
    	return $this->render('oeuvresBundle:Typesmusiques:index.html.twig', array(
    			'entities' => $entities,
    			'filtre_form'   => $filtre_form->createView()
    			,'typesmusique'=>$stypesmusique
    			,'tous'=>$tous   			
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
    
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_typesmusiques_tblenreg');
    
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
    		 
    		 
    		 
    		$aEnregTri=$aSessionTblEnreg['tritypesmusiques'];
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
    			return $this->redirect($this->generateUrl('typesmusiques_show', array('id' => $id)));
    			 
    		}
    		if($action=='edit')
    		{
    			//die("399");
    			return $this->redirect($this->generateUrl('typesmusiques_edit', array('id' => $id)));
    			 
    		}
    	}else
    	{
    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
    		die("427");
    	}
    	 
    	return new RedirectResponse($this->generateUrl('typesmusiques'));
    
    }

    
    /**
     * Creates a new Typesmusiques entity.
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

    	
        $entity = new Typesmusiques();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $last=$entity->getId();
            
            /*
             * recalcul variable de session Accompagnements $aSessionTblEnreg
            */
            $last=$entity->getId();
            
            $iPage=1;
            
            $entities = $em->getRepository('oeuvresBundle:Typesmusiques')->ChargeListe();
            
            $aEnregId=$this->listeDesIds($entities);
            
            $aSessionTblEnreg=$session->get($gUserLoginLogged.'_typesmusiques_tblenreg');
            
            $aEnregTri=$aSessionTblEnreg['tritypesmusiques'];
            
            $sColDeTri=(isset($aEnregTri['coltrienreg']) ? $aEnregTri['coltrienreg'] : "");
            
            $sColDeTriOrdre=(isset($aEnregTri['ordretrienreg']) ? $aEnregTri['coltrienreg'] : "");
            
            $nbenreg=$aSessionTblEnreg['nbenreg'];
            
            
            //echo "<br/> \LAST ID >".$last."<";
            
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
                        

            return $this->redirect($this->generateUrl('typesmusiques_show', array('id' => $last)));
        }

        return $this->render('oeuvresBundle:Typesmusiques:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Typesmusiques entity.
     *
     * @param Typesmusiques $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Typesmusiques $entity)
    {
        $form = $this->createForm(new TypesmusiquesType(), $entity, array(
            'action' => $this->generateUrl('typesmusiques_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Typesmusiques entity.
     *
     */
    public function newAction()
    {
        $entity = new Typesmusiques();
        $form   = $this->createCreateForm($entity);

        return $this->render('oeuvresBundle:Typesmusiques:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Typesmusiques entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Typesmusiques')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'typesmusiques','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Typesmusiques entity.');
        }


        return $this->render('oeuvresBundle:Typesmusiques:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Typesmusiques entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Typesmusiques')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'typesmusiques','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Typesmusiques entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('oeuvresBundle:Typesmusiques:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Typesmusiques entity.
    *
    * @param Typesmusiques $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Typesmusiques $entity)
    {
        $form = $this->createForm(new TypesmusiquesType(), $entity, array(
            'action' => $this->generateUrl('typesmusiques_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Typesmusiques entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Typesmusiques')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Typesmusiques entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typesmusiques_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Typesmusiques:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Typesmusiques entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('oeuvresBundle:Typesmusiques')->find($id);
            
        if (!$entity) {
            throw $this->createNotFoundException('Problème de lecture Type de musique.');
        }
        $entity->setActive(0);
            
        $em->flush();

        return $this->redirect($this->generateUrl('typesmusiques'));
    }

    public function confirmdeleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	
    	$entity = $em->getRepository('oeuvresBundle:Typesmusiques')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Typesmusiques.');
    	}
    	//createConfirmDeleteForm confirmDelete.html.twig
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    	//	die('116');
    	
    	return $this->render('oeuvresBundle:Typesmusiques:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));

    
    }
    
    /**
     * Creates a form to delete a typesmusiques entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createConfirmDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('typesmusiques_delete', array('id' => $id)))
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
    
    	$aSessionTblEnreg['tritypesmusiques']=$aEnregTri;
    
    	$session = new Session();
    
    	$session->set($gUserLoginLogged.'_typesmusiques_tblenreg',$aSessionTblEnreg);
    
    	//var_dump($aSessionTblEnreg);
    
    	//die('139');
    
    	return $bOk;
    }    
    

    private function filtreCreateForm()
    {
    	
    	$form = $this->createForm(new TypesMusiquesFiltreType(), null,array(
    			'action' => $this->generateUrl('typesmusiques_filtrer', array('tous' => 0)),
    			'method' => 'POST'
    	));
    	$form->add('submit', 'submit', array('label' => ' '));
    	
    	return $form;
    	
    	
    	
    }
    
}
