<?php

namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use oeuvresBundle\Entity\Fonctions;
use oeuvresBundle\Form\FonctionsType;
use oeuvresBundle\Form\FonctionsFiltreType;

/**
 * Fonctions controller.
 *
 */
class FonctionsController extends Controller
{

    /**
     * Lists all Fonctions entities.
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

        $aFiltres= $session->get($gUserLoginLogged.'_fonctions_filtres');
        
        $sfonction=$aFiltres['fonction'];
        
        $btous=$aFiltres['tous'];
        
        $entities = $em->getRepository('oeuvresBundle:Fonctions')->ChargeListe($aFiltres);

        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=1;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";
        

        
        $filtre_form=$this->filtreCreateForm();
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
        
        return $this->render('oeuvresBundle:Fonctions:index.html.twig', array(
            'entities' => $entities,
        		'filtre_form'   => $filtre_form->createView()
        		,'fonction'=>$sfonction
        		,'tous'=>$btous
        ));
    }
    
    public function filtrerAction(Request $request,bool $tous)
    {
    	/**
    	 * retour à la liste filtrée
    	 */
    	
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
    	
    	$post = $request->request->get('oeuvresbundle_filtre_fonctions');
    	$sfonction=$post['fonction'];
    	$tous=isset($post['tous']) ? $post['tous'] : 0;
    	
    	$session = new Session();
    	$aFiltres=array('fonction'=>$sfonction,'tous'=>$tous);
    	$session->set($gUserLoginLogged.'_fonctions_filtres',$aFiltres);
    	
    	$entities = $em->getRepository('oeuvresBundle:Fonctions')->ChargeListe($post);
    	
    	$filtre_form=$this->filtreCreateForm();
    	
    	return $this->render('oeuvresBundle:Fonctions:index.html.twig', array(
    			'entities' => $entities,
    			'filtre_form'   => $filtre_form->createView()
    			,'fonction'=>$sfonction
    			,'tous'=>$tous
    	));
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
    
    	$aSessionTblEnreg['trifonctions']=$aEnregTri;
    
    	$session = new Session();
    
    	$session->set($gUserLoginLogged.'_fonctions_tblenreg',$aSessionTblEnreg);
    
    	//var_dump($aSessionTblEnreg);
    
    	//die('139');
    
    	return $bOk;
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
        
    /**
     * Creates a new Fonctions entity.
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
    	
        $entity = new Fonctions();
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
            
            $entities = $em->getRepository('oeuvresBundle:Fonctions')->ChargeListe();
            
            $aEnregId=$this->listeDesIds($entities);
            
            $aSessionTblEnreg=$session->get($gUserLoginLogged.'_fonctions_tblenreg');
            
            $aEnregTri=$aSessionTblEnreg['trifonctions'];
            
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
             
            
            $aEnregTri=array();
            $aEnreg=array('coltrienreg'=>$sColDeTri);
            $aEnregTri[]=$aEnreg;
            $aEnreg=array('ordretrienreg'=>$sColDeTriOrdre);
            $aEnregTri[]=$aEnreg;
            
            $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
            
             
            /*
             *
            */            
            $this->createListeResConfigRoutings($last);   
            
            return $this->redirect($this->generateUrl('fonctions_show', array('id' => $last)));
        }

        return $this->render('oeuvresBundle:Fonctions:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Fonctions entity.
     *
     * @param Fonctions $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Fonctions $entity)
    {
        $form = $this->createForm(new FonctionsType(), $entity, array(
            'action' => $this->generateUrl('fonctions_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Fonctions entity.
     *
     */
    public function newAction()
    {
        $entity = new Fonctions();
        $form   = $this->createCreateForm($entity);   
        return $this->render('oeuvresBundle:Fonctions:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fonctions entity.
     *
     */
    public function showAction($id)
    {
    	
    	$session = $this->getRequest()->getSession();
    	if($session)
    	{
    		$gUserLoginLogged=$session->get('gUserLoginLogged');
    	}
    	if($gUserLoginLogged=='')
    	{
    		return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'fonctions','id'=>$id)));
    	}
    	    	
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('oeuvresBundle:Fonctions')->find($id);
        
        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'fonctions','id'=>$id)));
        }
        
        $slib_tpslitur='';
        $id_tpslitur=$entity->getIdTpslitur();
        $id_tpslitur=(is_null($id_tpslitur)) ? 0 : $id_tpslitur;
        
        if($id_tpslitur!=0)
        {
        	$entitytps= $em->getRepository('oeuvresBundle:TempsLiturgiques')->find($id_tpslitur);
        	if (!$entitytps) {
        		return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'TempsLiturgiques','id'=>$id)));
        	}
        	$slib_tpslitur=$entitytps->getLibelle();
        }
        
        
        $entities = $em->getRepository('oeuvresBundle:Fonctions')->ChargeListeIds( );
        
        $aEnregId=$this->listeDesIds($entities);
        
        $iEnreg=$id;
        $iPage=1;
        $sColDeTri="";
        $sColDeTriOrdre="";
        
        $this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
                
        return $this->render('oeuvresBundle:Fonctions:show.html.twig', array(
            'entity'      => $entity,
        	'libtpslitur'=>$slib_tpslitur
        ));
    }

    /**
     * Displays a form to edit an existing Fonctions entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Fonctions')->find($id);
       
        if (!$entity) {
        	return new RedirectResponse($this->generateUrl('entiteinex_show',array('entite'=>'fonctions','id'=>$id)));
            //throw $this->createNotFoundException('Unable to find Fonctions entity.');
        }
        $id_tpslitur=$entity->getIdTpslitur();
        
        $editForm = $this->createEditForm($entity);     
        
        return $this->render('oeuvresBundle:Fonctions:edit.html.twig', array(
            'entity'      => $entity,
        		'id_tpslitur'=>$id_tpslitur,
        	'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Fonctions entity.
    *
    * @param Fonctions $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fonctions $entity)
    {
        $form = $this->createForm(new FonctionsType(), $entity, array(
            'action' => $this->generateUrl('fonctions_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * desactive entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
    	$form = $this->createDeleteForm($id);
    	$form->handleRequest($request);
    
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Fonctions')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Fonction.');
    	}
    	$entity->setActive(false);
    	$em->flush();
    
    	return $this->redirect($this->generateUrl('fonctions'));
    }    
    
    /**
     * Creates a form to delete a Genres entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('fonctions_delete', array('id' => $id)))
    	->setMethod('DELETE')
    	->add('submit', 'submit', array('label' => 'Delete'))
    	->getForm()
    	;
    }
        
    public function confirmdeleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('oeuvresBundle:Fonctions')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Fonction.');
    	}
    
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    
    	return $this->render('oeuvresBundle:Fonctions:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    }

    private function createConfirmDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('fonctions_delete', array('id' => $id)))
    	->add('submit', 'submit', array('label' => 'Oui'))
    	->getForm()
    	;
    }    
        
    /**
     * Edits an existing Fonctions entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Fonctions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fonctions entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fonctions_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Fonctions:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
    
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_fonctions_tblenreg');
    
    	$nbenreg=0;
    
    	$nbenreg=$aSessionTblEnreg['nbenreg'];
    
    	$aEnregId=$aSessionTblEnreg['tblenreg'];
    
    	$aTblIds=array();
    	foreach ($aEnregId as $iAe=>$aE)
    	{
    		$aTblIds[$iAe]=$aE;
    	}
    
    	$this->tblEnregSauveSession($aEnregId, $idxenreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
    
    	if($idxenreg>0 && $idxenreg<$nbenreg+1)
    	{
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
    				$idxenreg++;
    				$id=$aTblIds[$idxenreg];
    			}
    		}
    		$aEnregTri=$aSessionTblEnreg['trifonctions'];
    		
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
    			return $this->redirect($this->generateUrl('fonctions_show', array('id' => $id)));
    			 
    		}
    		if($action=='edit')
    		{
    			//die("399");
    			return $this->redirect($this->generateUrl('fonctions_edit', array('id' => $id)));
    			 
    		}
    	}else
    	{
    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
    		die("427");
    	}
    	 
    	return new RedirectResponse($this->generateUrl('fonctions'));
    
    }    
    
    private function filtreCreateForm()
    {
    	
    	$form = $this->createForm(new FonctionsFiltreType(), null,array(
    			'action' => $this->generateUrl('fonctions_filtrer', array('tous' => 1)),
    			'method' => 'POST'
    	));
    	$form->add('submit', 'submit', array('label' => ' '));
    	
    	return $form;
    	
    	
    	
    }
    
    public function f()
    {
    	//
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
