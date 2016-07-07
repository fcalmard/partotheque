<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use oeuvresBundle\Repository\VoixRepository;

class SouscategvoixType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
    		->add('active','checkbox',array('required'=>false))
                    ->add('libelle')
                    ->add('commentaire','textarea',array('label'=>'Commentaires','required'=>false))
                    
                    ->add('voix_id','entity',array(
                    		'property'=>'libelle',
                    		'label'=>'Voix',
                    		'multiple'    => false,
                    		'empty_value' => 'Selectionnez une catégorie de Voix',
                    		'empty_data'  => null,
                    		'query_builder' => function (VoixRepository $er) {
                    		 
                    		return $er->createQueryBuilder('t')
                    		->where('t.active=1')
                    		->orderBy('t.libelle', 'ASC')
                    		;
                    },
                     
                    'required'=>false,
                     
                    'class'=>'oeuvresBundle:Voix'
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
            'data_class' => 'oeuvresBundle\Entity\Souscategvoix'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_souscategvoix';
    }
}
