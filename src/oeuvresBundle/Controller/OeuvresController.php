<?php


namespace oeuvresBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use oeuvresBundle\Entity\Oeuvres;
use oeuvresBundle\Form\OeuvresType;
use oeuvresBundle\Form\OeuvresImport;
use oeuvresBundle\Form\OeuvresFiltreType;

use \PDO;
use Doctrine\DBAL\Schema\Schema;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\HttpFoundation\Session\Session;

//use oeuvresBundle\Repository\PartitionsRepository;

use oeuvresBundle\Repository\TempsLiturgiquesRepository;
use oeuvresBundle\Repository\CompositeursRepository;
use oeuvresBundle\Repository\FonctionsRepository;
use oeuvresBundle\Repository\LanguesRepository;
use Doctrine\ORM\Repository\RepositoryFactory;

/**
 * Oeuvres controller.
 *
 */
class OeuvresController extends Controller
{
	/**
	 * Lists all Oeuvres entities.
	 * @param number $compoid
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction($compoid=0)
    {
    	$this->setSessionModifEnCours(0);
    	$gUserLoginLogged="";
    	/**
    	 * 
    	 * @var Ambiguous $session
    	 */    	
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
    	 
    	//$entities = $em->getRepository('oeuvresBundle:Oeuvres')->findAll();
    	 
    	$aFiltre=array();
    	 
    	$titreOeuvre="";
    	$compositeur_id="";
    	$nomcompositeur="";
    	$siecle="";
    	
    	$aLangues="";
    	
    	$genre_id="";
    	$tps_litur_id="";
    	$fonction_id="";
    	$voix_id="";
    	$atps_litur_id="0";
    	 
    	//echo $compoid;
    	if($compoid!=0)
    	{
    		$compositeur_id=$compoid;
    		/**
    public function filtrerAction(Request $request,$tous=1,$idcompo=0)
    		 * 
    		 */
    		
    		$nomcompositeur=$em->getRepository('oeuvresBundle:Compositeurs')->rechercheNomCompositeur($compoid);
    		
    		$request = new Request();
    		/**
    		 * filtrerAction(Request $request,$tous=1,$idcompo=0)
    		 */
    		$this->filtrerAction($request,0,$compoid);
    		
    		//die('90 '.$compoid.' >'.$nomcompositeur.'<');
    		
    	}
    	$skFiltre="filtre_oeuvres_".$gUserLoginLogged;
    	  	
    	/*
    	 * mettre dans index.html.twig
    	 */
    	$aFiltre=$session->get($skFiltre);
    	 
    	//
    	$aTriOeuvresSession=$session->get($gUserLoginLogged.'_oeuvres_tri');
    	    	 
    	$afficheapppdf=$session->get($gUserLoginLogged.'_oeuvres_affiche_apppdf',0);
    	
    	$bAffAppPdf=($afficheapppdf==1);
    	 
    	$entities = $em->getRepository('oeuvresBundle:Oeuvres')->ChargeListe($aFiltre,$aTriOeuvresSession,$bAffAppPdf);
    	
    	/*
    	 * Défilement dans les enregistrements des œuvres memo dans cookie
    	 */
    	
    	//liste des ids
    	 
    	$aEnregId=$this->listeDesIds($entities);    	
    	/*
    	 * tri
    	 */
    	$aTriOeuvres=$this->getParamTriOeuvres($aTriOeuvresSession);   	
    	
    	$sColDeTri='';
    	$sColDeTriOrdre='';
    	if(isset($aTriOeuvres['ColDeTri']))
    	{
    		$sColDeTri=$aTriOeuvres['ColDeTri'];
    		
    	}
    	if(isset($aTriOeuvres['ColDeTriOrdre']))
    	{
    		$sColDeTriOrdre=$aTriOeuvres['ColDeTriOrdre'];
    		
    	}
    	
    	//
    	$iEnreg=1;
    	$iPage=1;
    	 
    	$this->tblEnregSauveSession($aEnregId,$iEnreg,$iPage,$sColDeTri,$sColDeTriOrdre,$gUserLoginLogged);
    	   	    	
    	/*
    	 * 
    	 */
    	$entity = new Oeuvres();
    	$list = array();
    	
    	//var_dump($aFiltre);
    	
    	if (!is_null($aFiltre))
    	{
   	    	if(count($aFiltre!=0))
	    	{
	    		foreach ($aFiltre as $ak=>$avFiltre)
	    		{
	    			foreach ($avFiltre as $skFiltre2=>$avFiltre2)
	    			{
	    				//echo "<br/> skFiltre2".$skFiltre2."<";
	    					    
	    				switch ($skFiltre2)
	    				{
	    					case "titreOeuvre":
	    						$titreOeuvre=$avFiltre['titreOeuvre'];
	    						break;
	    					case "compositeur_id":
	    						$compositeur_id=$avFiltre['compositeur_id'];
	    						break;
	    					case "genre_id":
	    						$genre_id=$avFiltre['genre_id'];
	    						break;
	    					case "tps_litur_id":
	    						$tps_litur_id=$avFiltre['tps_litur_id'];
	    						
	    						$list = array();
	    							
	    						$sListeIds="";
	    						$atps_litur_id="";
	    								    							
	    						if(is_array($tps_litur_id))
	    						{
	    							
	    							foreach ($tps_litur_id as $idt)
	    							{
	    								$sListeIds.=($sListeIds!="") ? ",".$idt:"(".$idt;

	    								$atps_litur_id.=($atps_litur_id!="") ? ",".$idt:"".$idt;   								
	    									
	    							}
	    							
	    							$atps_litur_id.=($atps_litur_id!="") ? "":"";
	    							
	    							$sListeIds.=($sListeIds!="") ? ")":"";
	    							
	    							
	    						}
	    						//die("169");
	    							
	    						/*
	    						 * Repository
	    						 * TempsLiturgiquesRepository
	    						 * 
	    						 * listeTempsLiturgique
	    						foreach ($channel_rates as $channel_rate) {
	    							$list[$channel_rate->getId()] = $channel_rate->getNomeCameraTariffa();
	    						}
	    						    	$entities = $em->getRepository('oeuvresBundle:Oeuvres')->ChargeListe($aFiltre,$aTriOeuvresSession,$bAffAppPdf);

	    						*/

	    						$atpslit = $em->getRepository('oeuvresBundle:TempsLiturgiques')->listeTempsLiturgique($sListeIds);
	    							
	    						
	    						if(is_array($atpslit))
	    						{
	    							foreach ($atpslit as $kt=>$atps)
	    							{
	    								//echo "<br/>".$kt."<br/>";
	    								//var_dump($atps['id'] );
	    								//var_dump($atps['libelle'] );
	    								
	    								$list[$atps['id']]=$atps['libelle'] ;
	    										    								
	    								//var_dump($atps['libelle'])
	    									
	    							}
	    						}
	    						//echo "<br/>";
	    						
	    						//var_dump($list);
	    						
	    						//die("<br/>".$sListeIds);
	    							    	
	    						break;
	    					case "fonction_id":
	    						$fonction_id=$avFiltre['fonction_id'];
	    						break;
	    					case "voix_id":
	    						$voix_id=$avFiltre['voix_id'];
	    						break;
	    					case 'nomcompositeur';
	    						$nomcompositeur=$avFiltre['nomcompositeur'];
	    						break;
	    					case 'siecle';
	    						$siecle=$avFiltre['siecle'];
	    						break;
	    					case 'langue':			
	    						$aLangues=$avFiltre['langue'];
	    						break;
	    					default:
	    						break;
	    				}
	    				 
	    			}
	    			
	    		
	    		}
	    	}

    	}
    	 
    	$filtre_form = $this->filtreCreateForm($entity);
    	   
    	$affiche=$session->get($gUserLoginLogged.'_oeuvres_affiche_filtre',0);
    	 
    	$sDossierPartitions=$em->getRepository('oeuvresBundle:Oeuvres')->getDossierPartitions();
    	 /*
    	echo "<br/> atps_litur_id".$atps_litur_id."<";
    	'tps_litur_id'=>$tps_litur_id,
    	*/
    	
    	$atps_litur_id=explode(",", $atps_litur_id);
    	
    	$monocouleur=0;
    	$cpt=0;
    	 
    	$idxcoul="";
    	 
    	foreach ($entities as $ke=>$oeuvre)
    	{
    		foreach ($oeuvre as $kz=>$valo)
    		{
    			if($kz=='coultps') 
    			{
    				$zc=trim(strtoupper($valo));
    				if($idxcoul=='')
    				{
    					$idxcoul=$zc;
    					$cpt++;
    				}else{
    					if($idxcoul!=$zc)
    					{
    						$cpt++;
    						$idxcoul=$zc;
    					}
    				}
    			}  			 
    		}
    	}
    	
    	$monocouleur=($cpt<2) ? 1 : 0;
    	//echo "<br/>281 CPT=".$cpt."< >".$monocouleur;
        return $this->render('oeuvresBundle:Oeuvres:index.html.twig', array(
            'entities' => $entities,
        		'filtre_form'   => $filtre_form->createView(),
    			'titreOeuvre'=>$titreOeuvre,
        		'compositeur_id'=>$compositeur_id,
        		'nomcompositeur'=>$nomcompositeur,
        		'siecle'=>$siecle,
        		'langue'=>$aLangues,
        		'affiche_filtre'=>$affiche,
        		'afficheapppdf'=>$afficheapppdf,
        		'aTriOeuvresSession'=>$aTriOeuvresSession,
        		'genre_id'=>$genre_id,
        		'atps_litur_id'=>$atps_litur_id,
        		'monocouleur'=>$monocouleur,
        		'fonction_id'=>$fonction_id,
        		'voix_id'=>$voix_id,
        		'sDossierPartitions'=>$sDossierPartitions,
        		
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
    	
    	 
    	//$aSessionTblEnreg['pagesenreg']=10;//$aSessionTblPageEnreg;
    	$aSessionTblEnreg['pagesenreg']=$aSessionTblPageEnreg;
    	 
    	//$aSessionTblEnreg['tblenreg']=array('tblenreg'=>111);//$aEnregId
    	//$aSessionTblEnreg['tblenreg']=array('tblenreg'=>$aEnregId);
    	$aSessionTblEnreg['tblenreg']=$aEnregId;
    	 
    	 
    	$aSessionTblEnreg['enregencours']=$iEnreg;
    	
    	 
    	$aEnregTri=array();
    	$aEnreg=array('coltrienreg'=>$sColDeTri);
    	$aEnregTri[]=$aEnreg;
    	$aEnreg=array('ordretrienreg'=>$sColDeTriOrdre);
    	$aEnregTri[]=$aEnreg;
    	
    	$aSessionTblEnreg['trioeuvres']=$aEnregTri;
    	
    	
    	/*
    	
    	 
    	$aSessionTblEnreg['tblenreg']=$aEnreg;
    	
    	$aEnreg=array(''=>1);
    	$aSessionTblEnreg['enreg']=$aEnreg;
    	

    	*/
    	$session = new Session();
    	 
    	$session->set($gUserLoginLogged.'_oeuvres_tblenreg',$aSessionTblEnreg);
    	 
    	//var_dump($aSessionTblEnreg);
    	 
    	//die('251');
    	
    	return $bOk;
    }
    
    private function listeDesIds(&$entities)
    {
    	$aEnregId=array();
    	$c=0;
    	foreach ($entities as $oOeuvre)
    	{
  		 
    		$id=$oOeuvre['id'];
    		if($id!=0) 
    		{
    			$c++;
    			$aEnregId[$c]=$id;
    		}
    		 
    		/*if($c=$iNbEnregParPage)
    		 {
    		 
    		$iPage++;
    		 
    		}*/
    	}
    	return $aEnregId;
    }
    
    private function getParamTriOeuvres(&$aTriOeuvresSession)
    {
    	$aTriOeuvres=array();
    	 
    	$sColDeTri="";
    	$sColDeTriOrdre="";
    	if(is_array($aTriOeuvresSession))
    	{
    		foreach ($aTriOeuvresSession as $kt=> $colsession)
    		{
    	
    			foreach ($colsession as $col=>$tricol)
    			{
    				if($tricol!='')
    				{
    					$sColDeTri=$col;
    					$sColDeTriOrdre=$tricol;
    						
    					$aTriOeuvres['ColDeTri']=$sColDeTri;
    					$aTriOeuvres['ColDeTriOrdre']=$sColDeTriOrdre;
    				}
    			}
    	
    		}
    	}
    	return $aTriOeuvres;
    }
    private function setSessionModifEnCours($modif=0)
    {
    	$gUserLoginLogged="";
    	$session = $this->getRequest()->getSession();
    	if($session)
    	{
    		$gUserLoginLogged=$session->get('gUserLoginLogged');
    	}
    	
    	$session->set($gUserLoginLogged.'_oeuvres_modifencours',$modif);
    	 
    	
    }
    public function affichefiltresAction()
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
    	 
    	$affiche=$session->get($gUserLoginLogged.'_oeuvres_affiche_filtre',1);
    	 
    	$affiche=($affiche==1) ? 0 : 1;
    	
    	//$session = new Session();
    	 
    	$session->set($gUserLoginLogged.'_oeuvres_affiche_filtre',$affiche);
    	 
    	return new RedirectResponse($this->generateUrl('oeuvres'));
    	
    }
    /*
     * oeuvresBundle:Oeuvres:afficheapppdf
     */
    public function afficheapppdfAction()
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
    
    	$affiche=$session->get($gUserLoginLogged.'_oeuvres_affiche_apppdf',1);
    
    	$affiche=($affiche==1) ? 0 : 1;
    	    
    	$session->set($gUserLoginLogged.'_oeuvres_affiche_apppdf',$affiche);
    
    	return new RedirectResponse($this->generateUrl('oeuvres'));
    	 
    }    
    public function pagineAction($idxenreg,$sens,$action)
    {
    	$id=0;
    	$gUserLoginLogged="";
    	
    	$iPage=2;
    	 
    	//trioeuvres
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
    	
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_oeuvres_tblenreg');
    	    	
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
    			

    			
    			$aEnregTri=$aSessionTblEnreg['trioeuvres'];
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
    			 
    			//echo "<br/> on passe au suivant $idxenreg $nbenreg $id<br/>";  			    
    			
    			$this->tblEnregSauveSession($aEnregId, $idxenreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
    			 
    			//echo ("<br/>********* ID EN COURS : ".$id." idxenreg : ".$idxenreg);
    			 
    			//echo ('<br/>380');
    			    
    			 
    		}
    		
    		
    		//$aSessionTblEnreg['tblenreg']=array('tblenreg'=>$aEnregId);
    	 
    	
    		
	    	if($id!=0)
	    	{    		
	    		if($action=='show')
		    	{
		    		return $this->redirect($this->generateUrl('oeuvres_show', array('id' => $id)));
		    		
		    	}
		    	if($action=='edit')
		    	{
		    		//die("399");
		    		return $this->redirect($this->generateUrl('oeuvres_edit', array('id' => $id)));
		    		
		    	}
	    	}else 
	    	{
	    		echo ("<br/> ************* PROBLEME ID EN COURS : ".$id." ".$idxenreg);
	    		die("427");
	    	}
    	
    	//}else{
    		
    		//echo ("<br/> ************* PROBLEME TABLEAU SESSION VIDE<br/>");
    		//die("416");
    		
    	//}
    	//echo ("<br/> ************* PROBLEME ID EN COURS : ID=".$id." IDXENREG=".$idxenreg."<br/>");
    	
    	//die("419");
    	
    	//return $this->redirect($this->generateUrl('oeuvres_edit', array('id' => 12)));
    	 
    	return new RedirectResponse($this->generateUrl('oeuvres'));
    	 
    }
    public function trierAction($tripar,$ordretri)
    {
	    //	{ 'tripar': 'titreOeuvre' },'ordretri':'asc') }
	    
    	//echo "<br/> TRI PAR >".$tripar.'< ordre >'.$ordretri.'<';
    	
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
    	
    	
    	//$session = new Session();
    	 
		//$this->initialiseSessionTriOeuvre
		    	
		//oeuvresBundle:oeuvres o
		//oeuvresBundle:Compositeurs c
		//oeuvresBundle:Genres g
		//oeuvresBundle:TempsLiturgiques t
		//oeuvresBundle:Fonctions f
		//oeuvresBundle:Voix v
		    	    	
		//$aTablesColonnesOeuvres=array('o','','g','t','f','v','o');
		    	
    	$aColonnesOeuvres=array('o.titreOeuvre','compositeur','genre','tpslliturgique','fonction','voix','o.reference');
    	 
    	$aTriOeuvresSession=$session->get($gUserLoginLogged.'_oeuvres_tri',null);
    	
    	//if (!is_array($aTriOeuvresSession) or count($aTriOeuvresSession)<1)
    		
    	 
    	if (is_null($aTriOeuvresSession) )
    	{
    		
    		$aTriOeuvres=array();
    		foreach ($aColonnesOeuvres as $kcol=>$sCol)
    		{
    			$aTriCol=array($sCol=>'');
    			if($kcol==0)
    			{
    				$aTriCol=array($sCol=>'asc');
    		
    			}
    			$aTriOeuvres[]=$aTriCol;
    			 
    		}
    		$session = new Session();
    		
    		$session->set($gUserLoginLogged.'_oeuvres_tri',$aTriOeuvres);
    		
    	}else{
	
    			$sordretri=$ordretri;
    			
    			$aTriOeuvres=array();
    			 
    			foreach ($aTriOeuvresSession as $kt=> $colsession)
    			{
    				//echo '<br/> KT >'.$kt.'<< <br/> COLSESSION >';
    				
    							//var_dump($aTriOeuvresSession[$kt]);$tripar
    				
    				//var_dump($colsession);
    						
    						
    				foreach ($colsession as $col=>$tricol)
    				{
    					$aTriCol=array($col=>'');
    						
    					//echo '<br/> COLONNE >'.$col.'< >'.$tricol.'< <br/> >';
    						
    					if($col==$tripar)
    					{
    						$sordretri=($tricol=="asc") ? "desc" : "asc";
    						
    						//echo '<br/> NOUVEL ORDRE TRI >'.$sordretri.'< <br/> >';
    						
    						//die("<br/>TABLEAU SESSION TRI PRESERT ");
    						
    						$aTriCol=array($col=>$sordretri);
    						
    					}
    										
    					$aTriOeuvres[]=$aTriCol;
    						
    				} 
    							
    				
    			}
    			
    			 
    			 
    		//}
    		
    			
    			//echo "<br/> FIN TRAITEMENT <br/>";
    			
    			$session = new Session();
    			 
    		
    			$session->set($gUserLoginLogged.'_oeuvres_tri',$aTriOeuvres);
    		
    			//var_dump($aTriOeuvres);
    		
    		//die("<br/>TABLEAU SESSION TRI PRESENT");
    	}
    	
    	 
		//$aTriColUnique=array($tripar=>)
		    	 
		    	 
		    	 
    	
    	
    	 
    	//die('<br/>trierAction');
    	return new RedirectResponse($this->generateUrl('oeuvres'));
    	 
    	
    }
    public function filtrerAction(Request $request,$tous=1,$idcompo=0)
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
    	
    	$skFiltre="filtre_oeuvres_".$gUserLoginLogged;
    	
    	if($idcompo!=0)
    	{
    		
    		$nomcompositeur=$em->getRepository('oeuvresBundle:Compositeurs')->rechercheNomCompositeur($idcompo);
    		/**
    		 * memoriser les criteres de filtre
    		 */
    		$aFiltre=array();// TOUS
    		
    		$titreOeuvre='';
    		$compositeur_id=$idcompo;
    		$siecle='';
    		$Langues='';
    		$genre_id='';
    		$tps_litur_id=null;
    		$fonction_id='';
    		$voix_id='';
    		
    		$aFiltre[]=array("titreOeuvre"=>$titreOeuvre);
    		$aFiltre[]=array("compositeur_id"=>$compositeur_id);
    		$aFiltre[]=array("nomcompositeur"=>'');
    		$aFiltre[]=array("siecle"=>$siecle);
    		$aFiltre[]=array("langue"=>$Langues);
    		$aFiltre[]=array("genre_id"=>$genre_id);
    		$aFiltre[]=array("tps_litur_id"=>$tps_litur_id);
    		$aFiltre[]=array("fonction_id"=>$fonction_id);
    		$aFiltre[]=array("voix_id"=>$voix_id);

    		/*
    		//var_dump($aFiltre);
    		//ECHO '<br>823.................';

    		
    		//die('819 ...filtrerAction...'.$idcompo.' >'.$nomcompositeur.'<');
    		
    		 */
    		
    		
    	}
    	else{
    		
	    	
	    	$post = $request->request->get('oeuvresbundle_filtre_oeuvres');
	    	
	    	$titreOeuvre=$post['titreOeuvre'];
	
	    	$compositeur_id=isset($post['compositeur_id']) ? $post['compositeur_id'] : 0;
	    	
	    	$nomcompositeur=$post['compositeurOeuvre'];
	    	
	    	$siecle=$post['siecle'];
	    	
	    	$Langues=$post['Langues'];
	    	 
	    	//var_dump($Langues);
	    	//die("646");
	    	$genre_id=$post['genre_id'];
	    	
	    	$tps_litur_id=null;
	    	 
	    	if(isset($post['tps_litur_id']))
	    	{
	    		$tps_litur_id=$post['tps_litur_id'];
	    		
	    	}
	    	 
	    	$fonction_id=$post['fonction_id'];
	    	 
	    	$voix_id=$post['voix_id'];
	    	
	    	/**
	    	 * 
	    	 * @var array $aFiltre
	    	 */
	    	$aFiltre=array();
	    	
	    	/**
	    	 * mettre $aFiltre dans session
	    	 */
	    	//$skFiltre="filtre_oeuvres_".$gUserLoginLogged;
	    	
	    	if($tous==1)
	    	{
	    		//$aFiltre=null;
	    		

	    		
	    		
	    		//die("TOUS");
	    		
	    	}else
	    	{
	    		$aFiltre[]=array("titreOeuvre"=>$titreOeuvre);
	    		$aFiltre[]=array("compositeur_id"=>$compositeur_id);
	    		$aFiltre[]=array("nomcompositeur"=>$nomcompositeur);
	    		$aFiltre[]=array("siecle"=>$siecle);
	    		$aFiltre[]=array("langue"=>$Langues);
	    		$aFiltre[]=array("genre_id"=>$genre_id);
	    		$aFiltre[]=array("tps_litur_id"=>$tps_litur_id);
	    		$aFiltre[]=array("fonction_id"=>$fonction_id);
	    		$aFiltre[]=array("voix_id"=>$voix_id);
	    		
	    		
	    	}
	
    	}
    	
    	
    	if($idcompo!=0)
    	{
    		//var_dump($aFiltre);
    		//var_dump($aTriOeuvresSession);
    		//die('903...........'.$idcompo);
    	}
    	
    	/**
    	 * 
    	 */
    	$session->set($skFiltre, $aFiltre);
    	    	
    	$entities = $em->getRepository('oeuvresBundle:Oeuvres')->ChargeListe($aFiltre);
    	
    	$aSessionTblEnreg=$session->get($gUserLoginLogged.'_oeuvres_tblenreg');
    	 
    	$aTriOeuvresSession=$session->get($gUserLoginLogged.'_oeuvres_tri');
    	
    	if($idcompo!=0)
    	{
    		//var_dump($aFiltre);
    		//var_dump($aTriOeuvresSession);
    		//die('920...........'.$idcompo);
    	}
    	 
    	$aEnregId=$this->listeDesIds($entities);
    	
    	$aTriOeuvres=$this->getParamTriOeuvres($aTriOeuvresSession);
    	
    	$sColDeTri="";
    	$sColDeTriOrdre="";
    	if(isset($aTriOeuvres['ColDeTri']))
    	{
    		$sColDeTri=$aTriOeuvres['ColDeTri'];
    		
    	}
    	if(isset($aTriOeuvres['ColDeTriOrdre']))
    	{
    		$sColDeTriOrdre=$aTriOeuvres['ColDeTriOrdre'];
    		
    	}
    	    	
    	$iEnreg=1;
    	$iPage=1;
    	$this->tblEnregSauveSession($aEnregId, $iEnreg, $iPage, $sColDeTri, $sColDeTriOrdre, $gUserLoginLogged);
    	
    	$entity = new Oeuvres();
    	    	 
    	$filtre_form = $this->filtreCreateForm($entity);
    	
    	$monocouleur=0;
    	$cpt=0;
    	
    	$idxcoul="";
    	
    	foreach ($entities as $ke=>$oeuvre)
    	{
    		foreach ($oeuvre as $kz=>$valo)
    		{
    			if($kz=='coultps')
    			{
    				$zc=trim(strtoupper($valo));
    				if($idxcoul=='')
    				{
    					$idxcoul=$zc;
    					$cpt++;
    				}else{
    					if($idxcoul!=$zc)
    					{
    						$cpt++;
    						$idxcoul=$zc;
    					}
    				}
    			}
    		}
    	}
    	 
    	$monocouleur=($cpt<2) ? 1 : 0;
    	
    	/**
    	 * 
    	 */
    	if($nomcompositeur!='')
    	{
    		//die('943 >'.$nomcompositeur);
    		
    	}
    				
    	/**
    	 * retour à la liste filtrée
    	 */
    	
    	return $this->render('oeuvresBundle:Oeuvres:index.html.twig', array(
    			'entities' => $entities,
    			'filtre_form'   => $filtre_form->createView(),
    			'titreOeuvre'=>$titreOeuvre,
    			'compositeur_id'=>$compositeur_id,
    			'nomcompositeur'=>$nomcompositeur,
    			'siecle'=>$siecle,
    			'langue'=>$Langues,
    			'genre_id'=>$genre_id,
    			'tps_litur_id'=>$tps_litur_id,
    			'fonction_id'=>$fonction_id,
    			'voix_id'=>$voix_id,
    			'monocouleur'=>$monocouleur
    			 
    	));
    	 
    }
    /**
     * Creates a new Oeuvres entity.
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
    	    	
        $entity = new Oeuvres();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $newid=$entity->getId();
            
            $sFile=$this->deplace_upload($em);
            
            $iPage=1;
            
            $entities = $em->getRepository('oeuvresBundle:Oeuvres')->ChargeListe();
            
            $aEnregId=$this->listeDesIds($entities);
            
            $aSessionTblEnreg=$session->get($gUserLoginLogged.'_oeuvres_tblenreg');
            
            $aEnregTri=$aSessionTblEnreg['trioeuvres'];
            
            $sColDeTri=(isset($aEnregTri['coltrienreg']) ? $aEnregTri['coltrienreg'] : "");
            
            $sColDeTriOrdre=(isset($aEnregTri['ordretrienreg']) ? $aEnregTri['coltrienreg'] : "");
            
            $nbenreg=$aSessionTblEnreg['nbenreg'];
                        
            $iEnreg=1;
            
            foreach ($aEnregId as $ki=>$ae)
            {
            	if($ae==$newid)
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
            
            return $this->redirect($this->generateUrl('oeuvres_show', array('id' => $newid)));
        }

        $idoeuvre=$entity->getId();
        
        $identiTemps=$entity->getTpsLiturId();
        
        return $this->render('oeuvresBundle:Oeuvres:edit.html.twig', array(
        		'mode' => 'create',
        		'entity' => $entity,        		
        		'idTempsLiturgique'=>$identiTemps,
        		'edit_form'   => $form->createView()
        ));
        /*
        return $this->render('oeuvresBundle:Oeuvres:new.html.twig', array(
        		'entity' => $entity,
        		'form'   => $form->createView(),
        ));*/
    }

    /**
     * Creates a form to create a Oeuvres entity.
     *
     * @param Oeuvres $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Oeuvres $entity)
    {
        $form = $this->createForm(new OeuvresType(), $entity, array(
            'action' => $this->generateUrl('oeuvres_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        
        return $form;
    }

    /**
     * Creates a form to create a Oeuvres entity.
     *
     * @param Oeuvres $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function filtreCreateForm(Oeuvres $entity)
    {
    	$aCompositeurs=array();
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$aCompositeurs= $em->getRepository('oeuvresBundle:Compositeurs')->ChargeListeSelectFiltre();
    	
    	//var_dump($aCompositeurs);
    	//die('1043');     			'lstcompo'=>$aCompositeurs
    	
    	
    	$form = $this->createForm(new OeuvresFiltreType($aCompositeurs), $entity, array(
    			'action' => $this->generateUrl('oeuvres_filtrer', array('tous' => 0)),
    			'method' => 'POST'
    	));
    	 
    	$form->add('submit', 'submit', array('label' => ' ','attr'=>array('class'=>'tooltip')));
    
    	return $form;
    }
        
    /**
     * Displays a form to create a new Oeuvres entity.
     *
     */
    public function newAction()
    {
        $entity = new Oeuvres();
    	$form   = $this->createCreateForm($entity);
        
        return $this->render('oeuvresBundle:Oeuvres:edit.html.twig', array(
        		'mode' => 'create',
        		'entity' => $entity,
        		'edit_form'   => $form->createView(),        		
        ));
        
    }

    /**
     * Finds and displays a Oeuvres entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Oeuvres')->find($id);
        
        if (!$entity) {
        	throw $this->createNotFoundException('pb de recherche de l\'Oeuvres.');
        }
        
        $couleur="";
        $couleurfg="";
        $couleurdef="";
        
        $idt=$entity->getTpsLiturId();
        $entiTemps='';
        $identiTemps=0;
        if(!is_null($idt) && $idt!=0)
        {
        	$identiTemps=$idt;
        	$entiTemps = $em->getRepository('oeuvresBundle:TempsLiturgiques')->find($idt);
        	 
        	if (!$entiTemps) {
        		throw $this->createNotFoundException('pb de recherche du Temps Liturgique.');
        	}
        	$entiTemps=$entiTemps->getLibelle();
        	
        	$aCouleurs = $em->getRepository('oeuvresBundle:TempsLiturgiques')->getCouleurs($idt);
        	 
        	$couleur=$aCouleurs['couleur'];
        	$couleurfg=$aCouleurs['couleurfg'];
        	$couleurdef=$aCouleurs['couleurdef'];
        	 
        }
        
        $idt=$entity->getCompositeurId();
        $Compositeur='';
        $CompositeurId=0;
        if(!is_null($idt) && $idt!=0)
        {
        	$CompositeurId=$idt;
        	$Compositeur = $em->getRepository('oeuvresBundle:Compositeurs')->find($idt);
        
        	if (!$Compositeur) {
        		throw $this->createNotFoundException('pb de recherche du Compositeur.');
        	}
        	$Compositeur=$Compositeur->getNomPrenom();
        }
        
        $idt=$entity->getHarmonId();
        
        $Harm='';
        if(!is_null($idt) && $idt!=0)
        {
        	$Harm = $em->getRepository('oeuvresBundle:Compositeurs')->find($idt);
        
        	if (!$Harm) {
        		throw $this->createNotFoundException('pb de recherche Harmonisateur.');
        	}
        	$Harm=$Harm->getNom()." ".$Harm->getPrenom();
        }
               
        $Fonction='';
        $idt=$entity->getFonctionId();
        if(!is_null($idt) && $idt!=0)
        {
        	$Fonction = $em->getRepository('oeuvresBundle:Fonctions')->find($idt);
        
        	if (!$Fonction) {
        		throw $this->createNotFoundException('pb de recherche de la Fonction.');
        	}
        	$Fonction=$Fonction->getLibelle();
        }
        
        $voix='';
        $idt=$entity->getVoixId();
        if(!is_null($idt) && $idt!=0)
        {
        	$voix = $em->getRepository('oeuvresBundle:Voix')->find($idt);
        
        	if (!$voix) {
        		throw $this->createNotFoundException('pb de recherche de la Voix.');
        	}
        	$voix=$voix->getLibelle();
        }
        
        $sscategvoix='';
        $idt=$entity->getSscategvoixId();
        if(!is_null($idt) && $idt!=0)
        {
        	$sscategvoix = $em->getRepository('oeuvresBundle:Souscategvoix')->find($idt);
        
        	if (!$sscategvoix) {
        		throw $this->createNotFoundException('pb de recherche de la ss categ de Voix.');
        	}
        	$sscategvoix=$sscategvoix->getLibelle();
        }
                
        $accompagnement='';
        $idt=$entity->getAccompagnementId();
        if(!is_null($idt) && $idt!=0)
        {
        	$accompagnement = $em->getRepository('oeuvresBundle:Accompagnements')->find($idt);
        
        	if (!$accompagnement) {
        		throw $this->createNotFoundException('pb de recherche Accompagnement.');
        	}
        	$accompagnement=$accompagnement->getLibelle();
        }
        
        $genre='';
        $idt=$entity->getGenreId();
        if(!is_null($idt) && $idt!=0)
        {
        	$genre = $em->getRepository('oeuvresBundle:Genres')->find($idt);
        
        	if (!$genre) {
        		throw $this->createNotFoundException('pb de recherche Genre.');
        	}
        	$genre=$genre->getLibelle();
        }        
        
        
        $Langues='';
        
        
        //ChargeListe($aFiltre,$aTriOeuvresSession);
        
        /*
         * PARTITIONS
         */
        
        $aPartitions=$em->getRepository('oeuvresBundle:Oeuvres')->findPartitions($id);
        $sDossierPartitions=$em->getRepository('oeuvresBundle:Oeuvres')->getDossierPartitions();
        
        $aL=$entity->getLangues();
        foreach ($aL as $lang)
        {
        	$l = $em->getRepository('oeuvresBundle:Langues')->find($lang);
        	 
        	$Langues.=($Langues!='') ? ', ' : '';
        	$Langues.=$l->getLibelle();
        }     
        
        $bCanon=$entity->getCanon();
        
        $sDossierTraductions=$em->getRepository('oeuvresBundle:Oeuvres')->getDossierTraductions();
        
        return $this->render('oeuvresBundle:Oeuvres:show.html.twig', array(
            'entity'      => $entity,
        		'TempsLiturgique'=>$entiTemps,
        		'idTempsLiturgique'=>$identiTemps,
        		'idCompositeur'=>$CompositeurId,
        		'Compositeur'=>$Compositeur,
        		'Harmonisateur'=>$Harm,
                 'Fonction'=>$Fonction,
        		'Voix'=>$voix,
        		'Sscategvoix'=>$sscategvoix,
        		'Accompagnement'=>$accompagnement,
        		'sDossierTraductions'=>$sDossierTraductions,
        		
        		'Partitions'      => $aPartitions,
        		
        		'sDossierPartitions'=>$sDossierPartitions,
        		'canon'=>$bCanon,
        		
        		'Genre'=>$genre,
        		'Langues'=>$Langues,
        		'couleur'=>$couleur,
        		'couleurfg'=>$couleurfg,
        		'couleurdef'=>$couleurdef        		
        ));
    }

    /**
     * Displays a form to edit an existing Oeuvres entity.
     *
     */
    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Oeuvres')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Oeuvres entity.');
        }

        $couleur="#ff0000";
        $couleurfg="";
        $couleurdef="1";
        
        $aCrit=array("Oeuvres_id"=>$id);
                
        $iDtps_litur_id=$entity->getTpsLiturId();
        
        $idcomp=$entity->getCompositeurId();
        
        $idhar=$entity->getHarmonId();
        
        $idfon=$entity->getFonctionId();
        
        $idvoix=$entity->getVoixId();
        //
        $sscatvoix_id=$entity->getSscategvoixId();
        
        $idGenre=$entity->getGenreId();
        
        $idAvancement=$entity->getAvancementId();
        
        $idAccompagnement=$entity->getAccompagnementId();
        
        $entity = $em->getRepository('oeuvresBundle:Oeuvres')->find($id);
        
        //$aPartitions=array();//$em->getRepository('oeuvresBundle:Oeuvres')->findPartitions($id);
        $aPartitions=$em->getRepository('oeuvresBundle:Oeuvres')->findPartitions($id);
        
        $sDossierPartitions=$em->getRepository('oeuvresBundle:Oeuvres')->getDossierPartitions();
        
        $sDossierTraductions=$em->getRepository('oeuvresBundle:Oeuvres')->getDossierTraductions();
        
        $editForm = $this->createEditForm($entity);
        
        $identiTemps=$entity->getTpsLiturId();
        
        $bCanon=$entity->getCanon();
        
        $fichiertraduction=$entity->getTraductionfile();
        
        $coulwhite='#ffffff';
        $coulblack='#000000';
        $coulbeige='#f5f5dc';
        		
        if($couleurfg=='')
        {
        	$couleurfg=$coulbeige;
        }
        //echo "<br/> identiTemps >".$identiTemps.'<';
        $identiTemps=(is_null($identiTemps)) ? 0 : $identiTemps;

        if($identiTemps!=0)
        {
        	$aCouleurs = $em->getRepository('oeuvresBundle:TempsLiturgiques')->getCouleurs($identiTemps);
        	$couleur=$aCouleurs['couleur'];
        	$couleurfg=$aCouleurs['couleurfg'];
        	$couleurdef=$aCouleurs['couleurdef'];
        }else 
        {
        	$iDtps_litur_id=0;
        	$couleurdef=1;
        }
        
        return $this->render('oeuvresBundle:Oeuvres:edit.html.twig', array(
        		'mode' => 'edit',
        		'entity'      => $entity,
            	'edit_form'   => $editForm->createView(),
        		'Partitions'      => $aPartitions,        		
        		'tps_litur_id'=>$iDtps_litur_id,
        		'idTempsLiturgique'=>$iDtps_litur_id,        		
        		'compositeur_id'=>$idcomp,
        		'harmon_id'=>$idhar,        		
        		'fonction_id'=>$idfon,
        		 'voix_id'=>$idvoix,
        		 'sscatvoix_id'=>$sscatvoix_id,
        		'accompagnement_id'=>$idAccompagnement,
        		'genre_id'=>$idGenre,
        		'avancement_id'=>$idAvancement,
        		'fichiertraduction'=>$fichiertraduction,
        		'sDossierPartitions'=>$sDossierPartitions,
        		'sDossierTraductions'=>$sDossierTraductions,
        		'canon'=>$bCanon,        		
        		'couleur'=>$couleur,
        		'couleurfg'=>$couleurfg,
        		'couleurdef'=>$couleurdef
        		
        ));
    }

    /**
    * Creates a form to edit a Oeuvres entity.
    *
    * @param Oeuvres $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Oeuvres $entity)
    {
        $form = $this->createForm(new OeuvresType(), $entity, array(
            'action' => $this->generateUrl('oeuvres_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'OK'));

        return $form;
    }
    /**
     * Edits an existing Oeuvres entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Oeuvres')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Oeuvres entity.');
        }

        $editForm = $this->createEditForm($entity);
        
        $editForm->handleRequest($request);      
               
        if ($editForm->isValid()) {
        	
			$s="";
        	if(isset($_FILES['oeuvresbundle_oeuvres']['name']['traductionfile']))
        	{
        		$s=$_FILES['oeuvresbundle_oeuvres']['name']['traductionfile'];
        		
        	}
        	$entity->setFichiertraduction($s);        	
        	
            $em->flush();

            $sFile=$this->deplace_upload($em);
                        
            return $this->redirect($this->generateUrl('oeuvres_edit', array('id' => $id)));
        }

        return $this->render('oeuvresBundle:Oeuvres:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Oeuvres entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
    	 
        /*$form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('oeuvresBundle:Oeuvres')->find($id);
        
        throw $this->createNotFoundException('Unable to find Oeuvres entity.');
        
        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Oeuvres entity.');
        }
		$entity->setActif(false);
		$em->flush();
		*/

        return $this->redirect($this->generateUrl('oeuvres'));
    }
   
    /**
     *
     * @param $id
     */
    public function confirmdeleteAction($id)
    {
    
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('oeuvresBundle:Oeuvres')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Oeuvre.');
    	}
    	//confirm_form
    	$confirm_form=$this->createConfirmDeleteForm($id);
    	//	die('116');
    
    	return $this->render('oeuvresBundle:Oeuvres:confirmDelete.html.twig', array(
    			'entity'      => $entity,
    			'confirm_form'=>$confirm_form->createView()
    	));
    
    }
    
    
    public function exec_importAction(Request $request)
    {

    	$impform=$this->createImportForm();
    	 
    	$impform->handleRequest($request);
    	
    	$sencours='';
    	
    	if ($impform->isValid()) {
    		
    		$em = $this->getDoctrine()->getManager();
    		
    		$oFiles=$_POST;
    		$target_dir="";
    		$binitbd=false;
    		$bsimulation=false;
    		//traductionfile
    		if (isset($_FILES['oeuvresbundle_import']))
    		{
    			$oFiles=$_FILES['oeuvresbundle_import'];
    			 
    			if(isset($oFiles['name']['fichierimport']))
    			{
    				$target_dir=$oFiles['name']['fichierimport'];
    			}
    				
    		}
    		//..oeuvresbundle_import
    		
    		$post = $request->request->get('oeuvresbundle_import');
    		
    		if(isset($_POST['oeuvresbundle_import']))
    		{
    			 
    			$sTypeFile=$oFiles['type']['fichierimport'];
    			 
    			$sFile=$oFiles['name']['fichierimport'];
    		
    			$stmpFile=$oFiles['tmp_name']['fichierimport'];
    			 
    		
    			if(file_exists($stmpFile))
    			{
    					
    				$sPathCible=$em->getRepository('oeuvresBundle:Oeuvres')->getDossierImports();
    				 
    				$target_dir = $sPathCible . '/'.basename( $oFiles["name"]['fichierimport']);
    		
    				move_uploaded_file($stmpFile, $target_dir);
    		
    				if(isset($_POST['oeuvresbundle_import']['reinitbd']))
    				{
    		
    		
    					$binitbd=($_POST['oeuvresbundle_import']['reinitbd']==1) ? true : false;
    		
    		
    				}
    				if(isset($_POST['oeuvresbundle_import']['simulation']))
    				{
    		
    		
    					$bsimulation=($_POST['oeuvresbundle_import']['simulation']==1) ? true : false;
    		
    		
    				}
    				/*
    				 * Importations
    				 */
    				$bok = $em->getRepository('oeuvresBundle:Oeuvres')->Import($target_dir,$binitbd,$bsimulation);
    			}
    		}
    	}
    	//die("exec_importAction 2");
    	

    	return $this->render('oeuvresBundle:Oeuvres:importOeuvres.html.twig', array(
    			'import_form'=>$impform->createView()
    	));
    	 
    	
    }
    public function importAction(Request $request)
    {
    	
    	$impform=$this->createImportForm();
    	
    	$impform->handleRequest($request);
    	
    	if ($impform->isValid()) {

    		$em = $this->getDoctrine()->getManager();
    		
    		$oFiles=$_POST;
    		$target_dir="";
    		$binitbd=false;
    		$bsimulation=false;
    		
    		$sDossierDebut="";
    		$sDossierFin="";
    		
    		//traductionfile
    		if (isset($_FILES['oeuvresbundle_import']))
    		{
    			$oFiles=$_FILES['oeuvresbundle_import'];
    			
    			if(isset($oFiles['name']['fichierimport']))
    			{
    				$target_dir=$oFiles['name']['fichierimport'];
    			}
    				 
    		}
    		//..oeuvresbundle_import
    		
    		$post = $request->request->get('oeuvresbundle_import');

    		if(isset($_POST['oeuvresbundle_import']))
    		{
    			
    			$sTypeFile=$oFiles['type']['fichierimport'];
    			
    			$sFile=$oFiles['name']['fichierimport'];
    				
    			$stmpFile=$oFiles['tmp_name']['fichierimport'];
    			
    				
    			if(file_exists($stmpFile))
    			{
    					
    				$sPathCible=$em->getRepository('oeuvresBundle:Oeuvres')->getDossierImports();
    			
    				$target_dir = $sPathCible . '/'.basename( $oFiles["name"]['fichierimport']);
    				
    				//echo "<br/>$stmpFile<br/>";
    				///echo "<br/>$target_dir<br/>";
    				
    				move_uploaded_file($stmpFile, $target_dir);
    				
    				if(isset($_POST['oeuvresbundle_import']['reinitbd']))
    				{
    				
    				
    					$binitbd=($_POST['oeuvresbundle_import']['reinitbd']==1) ? true : false;
    				
    				
    				}
    				if(isset($_POST['oeuvresbundle_import']['simulation']))
    				{
    				
    				
    					$bsimulation=($_POST['oeuvresbundle_import']['simulation']==1) ? true : false;
    				
    				
    				}   
    				if(isset($_POST['oeuvresbundle_import']['premierdossier']))
    				{
    				
    				
    					$sDossierDebut=$_POST['oeuvresbundle_import']['premierdossier'];
    				
    				
    				}
    				
    				if(isset($_POST['oeuvresbundle_import']['dernierdossier']))
    				{
    				
    				
    					$sDossierFin=$_POST['oeuvresbundle_import']['dernierdossier'];
    				
    				
    				}
    				
    				/*
    				 * Importations
    				 */
    				$bok = $em->getRepository('oeuvresBundle:Oeuvres')->Import($target_dir,$binitbd,$bsimulation,$sDossierDebut,$sDossierFin);
    				if($bok)
    				{
    					return $this->render('oeuvresBundle:Oeuvres:importOeuvres.html.twig', array(
    							'import_form'=>$impform->createView(),'message'=>'Import terminé'));
    				}

    				    				
    			}    			
    			 
    		}    		    		
    	}

    	return $this->render('oeuvresBundle:Oeuvres:importOeuvres.html.twig', array(
    			'import_form'=>$impform->createView()
    	));
    	
    }

    /**
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportForm()
    {

    	$form = $this->createForm(new OeuvresImport(), null, array(
    			'action' => $this->generateUrl('oeuvres_import'),
    			'method' => 'POST',
    	));
  
    	/*
    	$form = $this->createForm(new OeuvresImport(), null, array(
    			'action' => $this->generateUrl('oeuvres_exec_import'),
    			'method' => 'POST',
    	))
    	;*/
    	
    	$form->add('submit', 'submit', array('label' => 'Create'));
    	
    	return $form;
    	
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
    
    	 
    	$entity = $em->getRepository('oeuvresBundle:Oeuvres')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Problème de lecture Oeuvre.');
    	}
    
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('oeuvres_delete', array('id' => $id)))
    	->add('submit', 'submit', array('label' => 'Oui'))
    	->getForm()
    	;


    	
    }
    
    /**
     * 
     * @param unknown_type $em
     * @return string
     * 
     */
    private function deplace_upload($em)
    {
    	
    	$sFile='suite test';
    	
    	$sPathCible = $em->getRepository('oeuvresBundle:Oeuvres')->getDossierTraductions();
    	 //$_POST
    	//$oFiles=$_FILES;//['oeuvresbundle_oeuvres'];
    	$oFiles=$_POST;
    	//traductionfile
    	if (isset($_FILES['oeuvresbundle_oeuvres']))
    	{
    		$oFiles=$_FILES['oeuvresbundle_oeuvres'];
    		//die("ok");
    	}

    	//$oFiles=$_FILES['oeuvresbundle_partitions'];
    	     	
    	//var_dump($oFiles);
    	 
    	//die("<br/>********* deplace_upload");
    	
    	if(file_exists($sPathCible))
    	{
    		
    		//chmod($sPathCible, "0777");
    		
    		//$oFiles=$_FILES['oeuvresbundle_oeuvres'];
    		
    		if($oFiles)
    		{

    			$sTypeFile=$oFiles['type']['traductionfile'];

    			$sFile=$oFiles['name']['traductionfile'];
    			    			 
    			$stmpFile=$oFiles['tmp_name']['traductionfile'];
    			
    			if(file_exists($stmpFile))
    			{

    				$target_dir = $sPathCible . '/'.basename( $oFiles["name"]['traductionfile']);
    				
    				move_uploaded_file($stmpFile, $target_dir);
    				 
    				//var_dump($stmpFile);
    				
    				//$sFile=$oFiles["name"]['traductionfile'];
    				
    				//var_dump($target_dir );
    				
    				//die("<br/>deplace_upload");
    				
    			}

    		}
    	}
    	
    	//die($sFile);
    	

    	return $sFile;
    	 
    }
        

    
}
