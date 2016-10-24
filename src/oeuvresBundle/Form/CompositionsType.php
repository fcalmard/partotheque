<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use oeuvresBundle\Repository\TypesmusiquesRepository;


use oeuvresBundle\Repository\AccompagnementsRepository;
use oeuvresBundle\Repository\InstrumentsRepository;


class CompositionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                     
        	->add('active','checkbox',array('required'=>false))
        
        	->add('quantite','text',array('required'=>true))
        	         	 
            ->add('accompagnements_id','entity',array(
            		'property'=>'libelle',
            		'label'=>'Accompagnement',
            		'multiple'    => false,
            		'empty_value' => 'Selectionnez un Accompagnement',
            		'empty_data'  => null,
            		'query_builder' => function (AccompagnementsRepository $er) {
            		 
            		return $er->createQueryBuilder('t')
            		->where('t.active=1')
            		->orderBy('t.libelle', 'ASC')
            		;
            },
             
            'required'=>true,
             
            'class'=>'oeuvresBundle:Accompagnements'
            )
            )
            
            ->add('instruments_id','entity',array(
            		'property'=>'libelle',
            		'label'=>'Instrument',
            		'multiple'    => false,
            		'empty_value' => 'Selectionnez un Instrument',
            		'empty_data'  => null,
            		
            		'query_builder' => function (InstrumentsRepository $er) {
            		 
            		return $er->createQueryBuilder('t')
            		->where('t.active=1')
            		->orderBy('t.libelle', 'ASC')
            		;
            },
             
            'required'=>true,
             
            'class'=>'oeuvresBundle:Instruments'
            )
            )
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Compositions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_compositions';
    }
}
