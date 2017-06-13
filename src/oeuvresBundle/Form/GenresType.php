<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use oeuvresBundle\Repository\TypesmusiquesRepository;


class GenresType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('libelle')
            ->add('historique','textarea',array('label'=>'Historique','required'=>false))
            ->add('active','checkbox',array('required'=>false))
            
            ->add('typesmus_id','entity',array(
            		'property'=>'libelle',
            		'label'=>'Type de musique',
            		'multiple'    => false,
            		'empty_value' => 'Selectionnez un type de musique',
            		'empty_data'  => null,
            		'query_builder' => function (TypesmusiquesRepository $er) {
            		 
            		return $er->createQueryBuilder('t')
            		->where('t.active=1')
            		->orderBy('t.libelle', 'ASC')
            		;
            },
             
            'required'=>false,
             
            'class'=>'oeuvresBundle:Typesmusiques'
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
            'data_class' => 'oeuvresBundle\Entity\Genres'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_genres';
    }
}
