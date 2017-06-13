<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use oeuvresBundle\Repository\FonctionsRepository;
use oeuvresBundle\Repository\ProfilsRepository;
use oeuvresBundle\Repository\TempsLiturgiquesRepository;

class FonctionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('code','text',array('required'=>true))

            ->add('libelle','text',array('required'=>true))

            ->add('active','checkbox',array('required'=>false))
            
            ->add('id_tpslitur','entity',array(
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

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Fonctions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_fonctions';
    }
}
