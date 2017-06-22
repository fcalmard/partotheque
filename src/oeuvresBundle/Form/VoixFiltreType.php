<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VoixFiltreType extends AbstractType
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
    	
    	->add('voix','text',array('label'=>'Tessiture','required'=>false))
    	
    	->add('tous', 'choice', array('label'=>'Tous',
    			'empty_value'=>null,
    			'choices'   => array(0=>'Selection',1 => 'Tous', 2 => 'Inactifs'),
    			'required'  => false,
    	))
    	;
    	
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
        return 'oeuvresbundle_filtre_voix';
    }
    
}