<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Compositeurs;
use oeuvresBundle\Form\CompositeursType;
use Symfony\Component\HttpFoundation\Session\Session;
use oeuvresBundle\Form\CompositeursFiltreType;

/**
 * Compositeurs controller.
 *
 */
class CompositeursController extends Controller
{

    /**
     * Lists all Compositeurs entities.
     *
     */
    public function indexAction()
    {
    	//$this->setSessionModifEnCours(0);
    	$gUserLoginLogged="";
    	$session = $this->getRequest()->getSession();
    	//var_dump($session);

		if($session)
		{
			$gUserLoginLogged=$session->get('gUserLoginLogged');
		}
    	if($gUserLoginLogged=='')
    	{
    		try {
    			$redir= new RedirectResponse($this->generateUrl('homepage'));
    			
    			return $redir;
    			
    		}catch (\ErrorException $e)
    		{
    			die('compositeurs 30 >'.$gUserLoginLogged.'<');
    			
    		}
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	
    	$aFiltres= $session->get($gUserLoginLogged.'_compositeurs_filtres');
    	//var_dump($aFiltres);
    	$compositeur=$aFiltres['compositeur'];
	    //echo "<br/>$compositeur";
    	$btous=$aFiltres['tous'];	    	
    	
    	$entities = $em->getRepository('oeuvresBundle:Compositeurs')->ChargeListe($aFiltres);

        $filtre_form=$this->filtreCreateForm();
        
        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=1;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
        return $this->render('oeuvresBundle:Compositeurs:index.html.twig', array(
            'entities' => $entities	,'filtre_form'   => $filtre_form->createView(),
        		'compositeur'=>$compositeur
        		,'tous'=>$btous
        		
        ));
    }
    
    public function filtrerAction(Request $request,$tous=1)
    {
    	/**
    	 * retour à la liste filtrée
    	 */
    	
    	$gUserLoginLogged="";
    	$session = $this->getRequest()->getSession();
    	
    	if($session)
    	{
    		$gUserLoginLogged=$session->get('gUserLoginLogged');
    	}
    	if($gUserLoginLogged=='')
    	{
    		try {
    			$redir= new RedirectResponse($this->generateUrl('homepage'));
    			
    			return $redir;
    			
    		}catch (\ErrorException $e)
    		{
    			die('compositeurs 30 >'.$gUserLoginLogged.'<');
    			
    		}
    	}
    	
    	$compositeur='';
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$post = $request->request->get('oeuvresbundle_filtre_compositeurs');
    	
    	$compositeur=$post['compositeur'];
    	
    	$tous=isset($post['tous']) ? $post['tous'] : 0;
    	
    	if($compositeur!='' || !$tous)
    	{
    		$session = new Session();
    		
    		$aFiltres=array('compositeur'=>$compositeur,'tous'=>$tous);
    		
    		$session->set($gUserLoginLogged.'_compositeurs_filtres',$aFiltres);
    		
    	}
    	$entities = $em->getRepository('oeuvresBundle:Compositeurs')->ChargeListe($post);
    	
    	$filtre_form=$this->filtreCreateForm();
    	
    	
    	/**
    	 * Recuperer valeur filtres
    	 */
    	
    	return $this->render('oeuvresBundle:Compositeurs:index.html.twig', array(
    			'entities' => $entities,
    			'filtre_form'   => $filtre_form->createView(),
    			'compositeur'=>$compositeur,
    			'tous'=>$tous
    			
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
    
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_compositeurs_tblenreg');
        
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
    		 
    		 
    		 
    		$aEnregTri=$aSessionTblEnreg['tricompositeurs'];
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
    			return $this->redirect($this->generateUrl('compositeurs_show', array('id' => $id)));
    
    		}
    		if($action=='edit')
    		{
    			//die("399");
    			return $this->redirect($this->generateUrl('compositeurs_edit', array('id' => $id)));
    
    		}
    	}else
    	{
    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
    		die("427");
    	}
    
    	return new RedirectResponse($this->generateUrl('compositeurs'));
    
    }
        
    /**
     * Creates a new Compositeurs entity.
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
    	
        $entity = new Compositeurs();
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
            
            $entities = $em->getRepository('oeuvresBundle:Compositeurs')->ChargeListe();
            
            $aEnregId=$this->listeDesIds($entities);
            
            $aSessionTblEnreg=$session->get($gUserLoginLogged.'_compositeurs_tblenreg');
            
            $aEnregTri=$aSessionTblEnreg['tricompositeurs'];
            
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
            
            
            
             /*
            echo "<br/> \$nbenreg >".$nbenreg."<";
            echo "<br/> \$iEnreg >".$iEnreg."<";
            echo "<br/> coltrienreg >".$sColDeTri."<";
            echo "<br/> ordretrienreg >".$sColDeTriOrdre."<";
            */

            $aEnregTri=array();
            $aEnreg=array('coltrienreg'=>$sColDeTri);
            $aEnregTri[]=$aEnreg;
            $aEnreg=array('ordretrienreg'=>$sColDeTriOrdre);
            $aEnregTri[]=$aEnreg;

             
            //die('CREATE ACTION 208');            
            
            /*
             * 
             */

            return $this->redirect($this->generateUrl('compositeurs_show', array('id' => $entity->getId())));
        }

        return $this->render('oeuvresBundle:Compositeurs:edit.html.twig', array(
            'entity' => $entity,
        	'mode'=>'modif',
        	'edit_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Compositeurs entity.
     *
     * @param Compositeurs $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Compositeurs $entity)
    {
        $form = $this->createForm(new CompositeursType(), $entity, array(
            'action' => $this->generateUrl('compositeurs_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Compositeurs entity.
     *
     */
    public function newAction()
    {
        $entity = new Compositeurs();
        $form   = $this->createCreateForm($entity);

        return $this->render('oeuvresBundle:Compositeurs:edit.html.twig', array(
            'entity' => $entity,
        	'mode'=>'new',
        	'edit_form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Compositeurs entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Compositeurs')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'compositeurs','id'=>$id)));
            //throw $this->createNotFoundException('Problème de lecture compositeur.');
        }
//die("show".$id);
        return $this->render('oeuvresBundle:Compositeurs:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Compositeurs entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Compositeurs')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'compositeurs','id'=>$id)));
        	//throw $this->createNotFoundException('Compositeur non trouvé');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('oeuvresBundle:Compositeurs:edit.html.twig', array(
        	'entity'      => $entity,
        	'id'		=>$id,
        	'mode'=>'modif',
        	'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Compositeurs entity.
    *
    * @param Compositeurs $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Compositeurs $entity)
    {
        $form = $this->createForm(new CompositeursType(), $entity, array(
            'action' => $this->generateUrl('compositeurs_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Compositeurs entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Compositeurs')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Compositeurs entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('compositeurs_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Compositeurs:edit.html.twig', array(
            'entity'      => $entity,
        	'mode'=>'modif',
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Compositeurs entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('oeuvresBundle:Compositeurs')->find($id);

        if (!$entity) {
                throw $this->createNotFoundException('Problème de lecture Compositeur.');
        }

        $entity->setActive(false);
        
        $em->flush();
        return $this->redirect($this->generateUrl('compositeurs'));
    }

    
    public function confirmdeleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Compositeurs')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Compositeur.');
    	}
    
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    
    	return $this->render('oeuvresBundle:Compositeurs:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    }
    /**
     * Creates a form to delete a Compositeur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createConfirmDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('compositeurs_delete', array('id' => $id)))
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
    
    	$aSessionTblEnreg['tricompositeurs']=$aEnregTri;
    
    	$session = new Session();
    
    	$session->set($gUserLoginLogged.'_compositeurs_tblenreg',$aSessionTblEnreg);
    
    	//var_dump($aSessionTblEnreg);
    
    	//die('139');
    
    	return $bOk;
    }
        
    
    /**
     * Creates a form to create a Oeuvres entity.
     *
     * @param Oeuvres $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function filtreCreateForm()
    {
    	
    	$form = $this->createForm(new CompositeursFiltreType(), null,array(
    			'action' => $this->generateUrl('compositeurs_filtrer', array('tous' => 0)),
    			'method' => 'POST'
    	));
    	
    	$form->add('submit', 'submit', array('label' => ' '));
    	
    	return $form;
    	
    }
    
    
}
