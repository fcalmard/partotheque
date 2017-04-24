<?php

namespace oeuvresBundle\Form;

use oeuvresBundle\Repository\AvancementsRepository;

use oeuvresBundle\Entity\Avancements;

use Doctrine\DBAL\Types\FloatType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use oeuvresBundle\Repository\TempsLiturgiquesRepository;
use oeuvresBundle\Repository\CompositeursRepository;
use oeuvresBundle\Repository\FonctionsRepository;
use oeuvresBundle\Repository\VoixRepository;
use oeuvresBundle\Repository\GenresRepository;
use oeuvresBundle\Repository\LanguesRepository;
use Doctrine\ORM\EntityRepository;
use oeuvresBundle\Repository\OeuvresRepository;
/*
 
Titre
Compositeur
Genre
Temps liturgique
Fonction
Voix* 
 */
class OeuvresFiltreType extends AbstractType
{
	private $aCompositeur;
	
	public function __construct($aCompositeurs)
	{
		$this->aCompositeur=$aCompositeurs;
	}
    /**
     * @param FormBuilderIfnterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	//var_dump($this->aCompositeur);
    	    	
    	$ordre=array();
    	
    	$oCompositeurs=array();
    	$oCompositeurs=$this->aCompositeur;
    	
    	$aListeCompo=array();
    	foreach ($oCompositeurs as $kc=>$oCompo)
    	{
    		//var_dump($oCompo);
    		
    		$aListeCompo[]=array('id'=>$oCompo['id'],'nom'=>$oCompo['nom'],'prenom'=>$oCompo['prenom']);
    	}

    	
    	//var_dump($aListeCompo);
    	//die('63');
    	
    	/*
    	$builder->add('isAttending', 'choice', array(
    			'choices'  => array(
    					'Maybe' => null,
    					'Yes' => true,
    					'No' => false,
    			),
    			// *this line is important*
    			'choices_as_values' => true,
    	));
    	
    	//getDoctrine()->getManager();
    	
    	//$em = conte
    	
    	
    	//$oCompositeurs=new CompositeursRepository($em, CompositeursRepository	);
    	
    	
    	//$qb = $em->createQueryBuilder();
    	
    	/*
    	$qb->select(array('c'))
    	->from('oeuvresBundle\Entity\Compositeurs', 'c');

    	// $qb instanceof QueryBuilder
    	$query = $qb->getQuery();
    	// Execute Query
    	$oCompositeurs = $query->getResult();
    	
    	var_dump($oCompositeurs);

    	die('56');

    	*/
    	
    	/*
    	 * 
    	 */
    	
    	//$em=$this->getEntityManager();
    	/*
    	*/
    	
    	//var_dump($comporepo)
    	//;
    	//die('48');
    	
    	//$em = $this->getDoctrine();
    	
    	//Ordre de 1 à 10
    	//Pour ne pas avoir deux fois le même ordre il faut supprimer les ordre déja attribuer
    	for($i=1;$i<=10;$i++)
    	{
    		$ordre[$i] = $i;
    	}
    	
    	/*$conn=$this->getEntityManager()->getConnection();
    	
    	$comporepo=new CompositeursRepository($conn, 'CompositeursRepository');
    	*/
    	
    	$builder 	 
    	
    	->add('titreOeuvre','text',array('label'=>'Titre','required'=>false))
  	
    	
    	->add('compositeur_id','entity',array(
    			'property'=>'nom prenom',
    			'label'=>'Compositeur',
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez un Compositeur',
    			'empty_data'  => null,
    			'query_builder' => function (CompositeursRepository $er) {
    			
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.nom,t.prenom', 'ASC')
    			;
    			},
    			
    			'required'=>false,
    			
    			'class'=>'oeuvresBundle:Compositeurs'
    					)
    	)
    	
    	

    			/*
    	->add('compositeur_id','choice',array('choices'=>$aListeCompo,
    			'multiple'=>false,
    			'expanded' => false
    			
    	))
    	*/
    	
    	->add('compositeurOeuvre','text',array('label'=>'Compositeur','required'=>false))
    	
    	->add('siecle','text',array('label'=>'Siècle','required'=>false))
    	 
    	
    	->add('genre_id','entity',array(
    			'property'=>'libelle',
    			'label'=>'Genre',
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez un Genre',
    			'empty_data'  => null,
    			'query_builder' => function (GenresRepository $er) {
    			 
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},
    	 
    	'required'=>false,
    	 
    	'class'=>'oeuvresBundle:Genres'
    	)
    	)

    	/*
    	->add('tps_litur_id', 'entity',
    			array('class'=>'oeuvresBundle:TempsLiturgiques'
    					,'empty_value' => 'Selectionnez un Temps liturgique'
    					, 'multiple'=>true, 'expanded'=>false,'empty_data'=>null,'property'=>'CouleurLibelle')
    			)*/
    			
    	
    	->add('tps_litur_id','entity',array(
    			'property'=>'CouleurLibelle',
    			'label'=>'Temps liturgique',
    			'multiple'    => true,
    			'empty_value' => 'Selectionnez un Temps liturgique',
    			'empty_data'  => null,
    			'query_builder' => function (TempsLiturgiquesRepository $er) {
    	
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},
    	
    	'required'=>false,
    	
    	'class'=>'oeuvresBundle:TempsLiturgiques'
    	)
    	)
    	
    	->add('fonction_id','entity',array(
    			'property'=>'libelle',
    			'label'=>'Fonction du rite liturgique',
    			'label_attr' => array('class' => 'clsLabelEntity'),
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez une Fonction',
    			'empty_data'  => null,
    			'query_builder' => function (FonctionsRepository $er) {
    	
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},
    	'expanded'=>false,
    	'required'=>false,
    	'class'=>'oeuvresBundle:Fonctions'))
  	
    	->add('voix_id','entity',array(
    			'property'=>'libelle',
    			'label'=>'Voix',
    			'label_attr' => array('class' => 'clsLabelEntity'),
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez une Voix',
    			'empty_data'  => null,
    			 
    			'query_builder' => function (VoixRepository $er) {
    			 
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},
    	'expanded'=>false,
    	'required'=>false,
    	'class'=>'oeuvresBundle:Voix'))
    	

    	->add('Langues','entity',array(
    			'property'=>'libelle',
    			'label'=>'Langue',
    			'label_attr' => array('class' => 'clsLabelEntity'),
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez une Langue',
    			'empty_data'  => null,
    	
    			'query_builder' => function (LanguesRepository $er) {
    	
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},
    	'expanded'=>false,
    	'required'=>false,
    	'class'=>'oeuvresBundle:Langues'))	
    	;

    }
    
    public function configure()
    {
    	/*
    	$this->setValidators(array(
    			'duree'    => new sfValidatorNumber(array('required' => false)),
    	
    	));
    	*/
    	    	
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       /* $resolver->setDefaults(array(
            'data_class' => ''
        ));*/
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_filtre_oeuvres';
    }
}
