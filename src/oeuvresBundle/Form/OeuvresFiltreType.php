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
    /**
     * @param FormBuilderIfnterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	   	
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

			    	//->add('cote','text',array('label'=>'Cote','required'=>false))
			    	
			    	//->add('reference','text',array('label'=>'Numéro de dossier'))
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
