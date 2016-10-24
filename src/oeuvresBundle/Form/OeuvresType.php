<?php

namespace oeuvresBundle\Form;

use oeuvresBundle\Repository\AvancementsRepository;
use oeuvresBundle\Repository\LanguesRepository;

use oeuvresBundle\Entity\Avancements;

use Doctrine\DBAL\Types\FloatType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use oeuvresBundle\Repository\TempsLiturgiquesRepository;
use oeuvresBundle\Repository\CompositeursRepository;
use oeuvresBundle\Repository\FonctionsRepository;
use oeuvresBundle\Repository\VoixRepository;
use oeuvresBundle\Repository\SouscategvoixRepository;

use oeuvresBundle\Repository\AccompagnementsRepository;
use oeuvresBundle\Repository\GenresRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OeuvresType extends AbstractType
{
    /**
     * @param FormBuilderIfnterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	   	
    	$builder 	 
    	
    	->add('titreOeuvre','text',array('label'=>'Titre','required'=>true))
    	 
    	
    	->add('traductiontitreOeuvre','text',array('label'=>'Traduction Titre','required'=>false))
    	 
    	->add('tps_litur_id','entity',array(
    			'property'=>'libelle',
    			'label'=>'Temps liturgique',
    			'multiple'    => false,
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

    	->add('cote','text',array('label'=>'Cote','required'=>false))
    	
    	->add('reference','text',array('label'=>'Numéro de dossier'))
/*
    	->add('Partitions', 'collection', [
    			'type' => new PartitionsType,
    			'allow_add' => true,
    			'allow_delete' => false
    			])
    			    	*/
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
    			
    	/*
    	 * sous catégorie de voix
    	 */
    	->add('sscategvoix_id','entity',array(
    			'property'=>'libelle',
    			'label'=>'Sous Categorie',
    			'label_attr' => array('class' => 'clsLabelEntity'),
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez une Sous Categorie',
    			'empty_data'  => null,
    	
    			/*'query_builder' => function (SouscategvoixRepository $er) {
    	
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},*/
    	'expanded'=>false,
    	'required'=>false,
    	'class'=>'oeuvresBundle:Souscategvoix'))
    	    	
    	->add('avancement_id','entity',array(
    			'property'=>'libelle',
    			'label'=>'Avancement',
    			'label_attr' => array('class' => 'clsLabelEntity'),
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez un Avancement',
    			'empty_data'  => null,
    	
    			'query_builder' => function (AvancementsRepository $er) {
    	
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},
    	'expanded'=>false,
    	'required'=>false,
    	'class'=>'oeuvresBundle:Avancements'))    					 	    	
    			
    	->add('anonyme','checkbox',array('required'=>false))
    			 
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
    	
/* */
    	->add('accompagnement_id','entity',array(
    			'property'=>'libelle',
    			'label'=>'Accompagnements',
    			'multiple'    => false,
    			'empty_value' => 'Selectionnez un Accompagnement',
    			'empty_data'  => null,
    			'query_builder' => function (AccompagnementsRepository $er) {
    			 
    			return $er->createQueryBuilder('t')
    			->where('t.active=1')
    			->orderBy('t.libelle', 'ASC')
    			;
    	},
    	 
    	'required'=>false,
    	 
    	'class'=>'oeuvresBundle:Accompagnements'
    	)
    	)
    	
    	/**/
    	
    	->add('Langues'
    			,'entity',array(
    					'property'=>'libelle',
    					'disabled'    => false,
    					'multiple'    => true,
    					'required'    => false,
    					'empty_data'  => null,
	   					'query_builder' => function (LanguesRepository $er) {
    					return $er->createQueryBuilder('t')
    					->where('t.active=1')
    					->orderBy('t.libelle', 'ASC')
    					;
    	},
    	
    	'class'=>'oeuvresBundle:Langues'
    	
    	))
    	/**/
    	
    	->add('siecle','text',array('label'=>'Siècle','required'=>false))
    	
    	->add('duree','number',array('label'=>'Durée','required'=>false,'attr'=>array('class'=>'Number', 'type' => 'number')))
    	 
    	->add('commentaire','textarea',array('label'=>'Commentaires','required'=>false))
    	 
    	->add('actif','checkbox',array('required'=>false))
    	 
    	->add('traductionfile','file',array('label'=>'Fichier PDF','required'=>false,'mapped'=>true,'multiple'=>false,'data_class'=>null))
    	
    	//->add('fichiertraduction','file',array('label'=>'Fichier PDF','required'=>false,'mapped'=>false,'multiple'=>false,'data_class'=>null))
    	
    	->add('fichiertraduction','text',array('label'=>'Fichier PDF','required'=>false,'mapped'=>true,'disabled'=>true,'data_class'=>null));
    	 
    	//->add('Compositeurs','text',array('label'=>'Compositeur'))
    	 
    	//->add('save', 'submit', array('label' => 'Ok'))
    	    	
    	;
    	/*
    	$this->setValidators(array(
    			'duree'    => new sfValidatorNumber(array('required' => false)),
    	
    	));    	
    	*/
    }
    
    public function configure()
    {
    	
    	$this->setValidators(array(
    			'duree'    => new sfValidatorNumber(array('required' => false)),
    	
    	));
    	    	
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Oeuvres'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_oeuvres';
    }
}
