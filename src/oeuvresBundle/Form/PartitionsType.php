<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartitionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
        	->add('active', 'checkbox',
        			array('label'=>'Activée','required'=>false))        	
            ->add('duree')
            ->add('historique','textarea',array('label'=>'Historique','required'=>false))
            
            ->add('oeuvre_id','hidden')

            //->add('pathfichier') telecharger fichier pdf
            //partitionFile
	        //	ouvrelnktxt
            //->add('ouvrelnktxt','file',array('label'=>'Fichier PDF','required'=>false,'mapped'=>false,'multiple'=>false
            		//'data_class'=>null
            		
            ->add('partitionFile','file',array('label'=>'Fichier PDF','required'=>false,'mapped'=>true,'multiple'=>false,'data_class'=>null
            		
            ))
                        
            
        
            //->add('datecreateAt')
            //->add('Oeuvres')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Partitions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_partitions';
    }
}
