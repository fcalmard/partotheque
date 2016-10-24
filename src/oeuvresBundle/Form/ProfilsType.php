<?php

namespace oeuvresBundle\Form;

use oeuvresBundle\Repository\MenusRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfilsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CodeProfil')
            ->add('libelleProfil')
            
            ->add('Menus','entity',array(
            		'property'=>'libelleMenu',
            		'label'=>'Menus',
            		'multiple'    => true,
            		'empty_value' => 'Selectionnez un Menu',
            		'empty_data'  => null,
            		'query_builder' => function (MenusRepository $er) {
            		 
            		return $er->createQueryBuilder('t')
            		->where('t.actif=1')
            		->orderBy('t.libelleMenu', 'ASC')
            		;
            },
             
            'required'=>false,
             
            'class'=>'oeuvresBundle:Menus'
            )
            )
                        
            ->add('actif','checkbox',array('required'=>false))

         
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Profils'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_profils';
    }
}
