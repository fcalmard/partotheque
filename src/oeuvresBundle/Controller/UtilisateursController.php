<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Utilisateurs;
use oeuvresBundle\Form\UtilisateursType;
use oeuvresBundle\Form\UtilisateursFiltreType;
use oeuvresBundle\Form\UtilisateursNvmdpType;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Utilisateurs controller.
 *
 */
class UtilisateursController extends Controller
{
    /**
     * Lists all Utilisateurs entities.
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

    	$aFiltres= $session->get($gUserLoginLogged.'_utilisateurs_filtres');
    	$utilisateur=isset($aFiltres['utilisateur']) ? $aFiltres['utilisateur'] : '';
    	$btous=isset($aFiltres['tous']) ? $aFiltres['tous'] : 1;
    	
        $entities = $em->getRepository('oeuvresBundle:Utilisateurs')->ChargeListe($aFiltres);

        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=1;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);

        $filtre_form=$this->filtreCreateForm();
        
        return $this->render('oeuvresBundle:Utilisateurs:index.html.twig', array(
            'entities' => $entities,
        		'filtre_form'=>$filtre_form->createView(),
        		'utilisateur'=>$utilisateur,
        		'tous'=>$btous
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
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$post = $request->request->get('oeuvresbundle_filtre_utilisateurs');
    	
    	$utilisateur=$post['utilisateur'];
    	
    	$tous=isset($post['tous']) ? $post['tous'] : 0;
    	
    	if($utilisateur!='' || !$tous)
    	{
    		$session = new Session();
    		
    		$aFiltres=array('utilisateur'=>$utilisateur,'tous'=>$tous);
    		
    		$session->set($gUserLoginLogged.'_utilisateurs_filtres',$aFiltres);
    		
    	}
    	$entities = $em->getRepository('oeuvresBundle:Utilisateurs')->ChargeListe($post);
    	
    	$filtre_form=$this->filtreCreateForm();
    	
    	return $this->render('oeuvresBundle:Utilisateurs:index.html.twig', array(
    			'entities' => $entities,
    			'filtre_form'   => $filtre_form->createView(),
    			'utilisateur'=>$utilisateur,
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
    
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_utilisateurs_tblenreg');
    
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
    		 
    		 
    		 
    		$aEnregTri=$aSessionTblEnreg['triutilisateurs'];
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
    			return $this->redirect($this->generateUrl('utilisateurs_show', array('id' => $id)));
    
    		}
    		if($action=='edit')
    		{
    			//die("399");
    			return $this->redirect($this->generateUrl('utilisateurs_edit', array('id' => $id)));
    
    		}
    	}else
    	{
    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
    		die("427");
    	}
    
    	return new RedirectResponse($this->generateUrl('utilisateurs'));
    	
    }
    
    public function genernvmdpAction(Request $request,$id,$mdp)
    {
    	
    	$entity = new Utilisateurs();
    	
    	//$form = $this->createCreateForm($entity);
    	//$form->handleRequest($request);
    	
    	//if ($form->isValid()) {
    	
    		$em = $this->getDoctrine()->getManager();
    		
    		$entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);
    		
    		if (!$entity) {
    			return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'utilisateurs','id'=>$id)));
    			//throw $this->createNotFoundException('Unable to find Utilisateurs entity.');
    		}
    		
    		
    		$em = $this->getDoctrine()->getManager();
    		
    		$entity->setPasswd($mdp);//mode pass en clair
    		
    		$em->persist($entity);
    		
    		$em->flush();
    		
    		die('genernvmdpAction '.$id.' '.$entity->getNom());
    		
    	//}
    	
    	return new RedirectResponse($this->generateUrl('utilisateurs'));
    	
    }
    /**
     * Creates a new Utilisateurs entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Utilisateurs();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateurs_show', array('id' => $entity->getId())));
        }

        return $this->render('oeuvresBundle:Utilisateurs:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Utilisateurs entity.
     *
     * @param Utilisateurs $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Utilisateurs $entity)
    {
        $form = $this->createForm(new UtilisateursType(), $entity, array(
            'action' => $this->generateUrl('utilisateurs_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Utilisateurs entity.
     *
     */
    public function newAction()
    {
        $entity = new Utilisateurs();
        $form   = $this->createCreateForm($entity);

        return $this->render('oeuvresBundle:Utilisateurs:edit.html.twig', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        ));
    }
    /**
     * 
     * @param unknown $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|unknown
     */
    public function confirmnvmdpAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$oUser=$em->getRepository('oeuvresBundle:Utilisateurs');
    	
    	$entity = $oUser->find($id);
    	
    	$mdpclr=$oUser->genPassword();
    	
//    	echo "<br/> 324 $mdpclr";
    	$mdp=md5($mdpclr);
    	if (!$entity) {
    		return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'utilisateurs','id'=>$id)));
    		//throw $this->createNotFoundException('Unable to find Utilisateurs entity.');
    	}
    	$sUser=$entity->getPrenom();
    	$sUser.=' '.$entity->getNom();
    	
    	$form=$this->nvmdpCreateForm($id,$mdpclr);
    	
    	return $this->render('oeuvresBundle:Utilisateurs:confirmNvmdp.html.twig', array('id'=>$id,
    			'entity'      => $entity,'user'=>$sUser,'mdp'=>$mdp,'mdpclr'=>$mdpclr,'form'=>$form->createView()
    	));
    	
    	/*
    	 return $this->render('oeuvresBundle:Utilisateurs:confirmNvmdp.html.twig', array(
    	 'form'=>$form->createView(),'id'=>$id
    	 ,'entity'=>$entity
    	 ));
    	 */
    }
    /**
     * Finds and displays a Utilisateurs entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'utilisateurs','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Utilisateurs entity.');
        }


        return $this->render('oeuvresBundle:Utilisateurs:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Utilisateurs entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);

        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'utilisateurs','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Utilisateurs entity.');
        }

        $editForm = $this->createEditForm($entity);

        $ProfilsId=$entity->getProfilsId();
        
        
        return $this->render('oeuvresBundle:Utilisateurs:edit.html.twig', array(
            'entity'      => $entity,
        	 'ProfilsId'=>$ProfilsId,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Utilisateurs entity.
    *
    * @param Utilisateurs $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Utilisateurs $entity)
    {
        $form = $this->createForm(new UtilisateursType(), $entity, array(
            'action' => $this->generateUrl('utilisateurs_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Utilisateurs entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Utilisateurs entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateurs_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Utilisateurs:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Desactive a Utilisateurs entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Utilisateur.');
    	}
    
    	$entity->setActif(false);
    
    	$em->flush();
    	return $this->redirect($this->generateUrl('utilisateurs'));
    }
    /**
     * 
     * @param Request $request
     * @param unknown $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reactivAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);
    	
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Utilisateur.');
    	}
    	$entity->setActif(true);
    	$em->flush();
    	return $this->redirect($this->generateUrl('utilisateurs'));
    }
    /**
     *
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmdeleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Utilisateur.');
    	}
    	
    	$confirm_form=$this->createConfirmDeleteForm($id);
    	
    	return $this->render('oeuvresBundle:Utilisateurs:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    }
    /**
     *
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmreactivAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Utilisateurs')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Utilisateur.');
    	}
    	
    	$confirm_form=$this->createConfirmReactivForm($id);
    	
    	return $this->render('oeuvresBundle:Utilisateurs:confirmReactive.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    }
    
	/**
	 * Creates a form to delete a Utilisateur entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createConfirmDeleteForm($id)
	{	
		return $this->createFormBuilder()
		->setAction($this->generateUrl('utilisateurs_delete', array('id' => $id)))
		->add('submit', 'submit', array('label' => 'Oui'))
		->getForm()
		;
	}
	/**
	 * Creates a form to reactiver a Utilisateur entity by id.
	 * @param integer $id
	 * @return \Symfony\Component\Form\Form
	 */
	private function createConfirmReactivForm($id)
	{
		return $this->createFormBuilder()
		->setAction($this->generateUrl('utilisateurs_reactiv', array('id' => $id)))
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
	
		$aSessionTblEnreg['triutilisateurs']=$aEnregTri;
	
		$session = new Session();
	
		$session->set($gUserLoginLogged.'_utilisateurs_tblenreg',$aSessionTblEnreg);
	
		//var_dump($aSessionTblEnreg);
	
		//die('139');
	
		return $bOk;
	}
	
	private function filtreCreateForm()
	{
		
		$form = $this->createForm(new UtilisateursFiltreType(), null,array(
				'action' => $this->generateUrl('utilisateurs_filtrer', array('tous' => 0)),
				'method' => 'POST'
		));
		$form->add('submit', 'submit', array('label' => ' '));
		
		return $form;
	}
	
	private function nvmdpCreateForm($id,$mdp)
	{
		
		$form = $this->createForm(new UtilisateursNvmdpType(), null,array(
				'action' => $this->generateUrl('utilisateurs_gener_nvmdp', array('id' => $id,'mdp'=>$mdp)),
				'method' => 'POST'
		));
		$form->add('submit', 'submit', array('label' => ' '));
		
		return $form;
	}
}
