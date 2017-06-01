<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/*
 
Titre
Compositeur
Genre
Temps liturgique
Fonction
Voix* 
 */

class CompositeursFiltreType extends AbstractType
{
	
	/**
	 * $aCompositeurs
	 */
	public function __construct()
	{
		//$this->aCompositeur=$aCompositeurs;
	}
    /**
     * @param FormBuilderIfnterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder 	 
    	
    	->add('compositeur','text',array('label'=>'Compositeur','required'=>false))
    	
    	->add('tous','checkbox',array('required'=>false));
    	
    }
    
    public function configure()
    {

    	    	
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_filtre_compositeurs';
    }
}
