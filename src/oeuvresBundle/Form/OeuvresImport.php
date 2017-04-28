<?php

namespace oeuvresBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OeuvresImport extends AbstractType
{
    /**
     * @param FormBuilderIfnterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	   	
    	$builder 	 
    	    	 
    	->add('fichierimport','file',array('label'=>'Fichier XL','required'=>true,'mapped'=>false,'multiple'=>false,'data_class'=>null))

    	->add('reinitbd','checkbox',array('label'=>'Réinitialiser base de données','required'=>false,'mapped'=>false))
    	
    	->add('premierdossier','text',array('label'=>'Premier dossier à importer','required'=>false,'mapped'=>false))
    	 
    	->add('dernierdossier','text',array('label'=>'Dernier dossier à importer','required'=>false,'mapped'=>false))
    	 
    	->add('simulation','checkbox',array('label'=>'Simulation Import','required'=>false,'mapped'=>false))
    	
    	->add('ok','submit')
    	;
    	 
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_import';
    }
}
