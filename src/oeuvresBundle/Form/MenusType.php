<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use oeuvresBundle\Repository\MenusRepository;
use oeuvresBundle\Repository\ProfilsRepository;

class MenusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('codeMenu')

            ->add('libelleMenu')

            ->add('lnk')
            
            ->add('ordreaff','text',array('required'=>false))

            ->add('actif','checkbox',array('required'=>false))
            
            ->add('id_mensup','entity',array(
            		'property'=>'libellemenu',
            		'label'=>'Menu parent',
            		'multiple'    => false,
            		'empty_value' => 'Selectionnez un menu parent',
            		'empty_data'  => null,
            		'query_builder' => function (MenusRepository $er) {
            		 
            		return $er->createQueryBuilder('t')
            		->where('t.actif=1 and (t.id_mensup=0 OR t.id_mensup IS NULL)')
            		->orderBy('t.libelleMenu', 'ASC')
            		;
            },
             
            'required'=>false,
             
            'class'=>'oeuvresBundle:Menus'
            )
            )
                        
            ->add('Profils'
            		,'entity',array(
            				'property'=>'libelleProfil',
            				
            				'disabled'    => true,
            				'multiple'    => true,
            				
            				'query_builder' => function (ProfilsRepository $er) {
            				 
            				return $er->createQueryBuilder('t')
            				->where('t.actif=1')
            				->orderBy('t.libelleProfil', 'ASC')
            				;
            				},
            				            				
            				'class'=>'oeuvresBundle:Profils'
            				
            				))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Menus'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_menus';
    }
}
