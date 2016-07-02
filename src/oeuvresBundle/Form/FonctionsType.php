<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use oeuvresBundle\Repository\FonctionsRepository;
use oeuvresBundle\Repository\ProfilsRepository;

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
