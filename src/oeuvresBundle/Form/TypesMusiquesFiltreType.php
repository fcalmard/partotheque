<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypesMusiquesFiltreType extends AbstractType
{
	
	public function __construct()
	{
	}
    /**
     * @param FormBuilderIfnterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder 	 
    	
    	->add('typesmusique','text',array('label'=>'Type de musique','required'=>false))
    	
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
        return 'oeuvresbundle_filtre_typesmusiques';
    }
}
