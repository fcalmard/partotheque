<?php

namespace oeuvresBundle\Form;

use oeuvresBundle\Repository\ProfilsRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateursType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Login')
            ->add('passwd','password')
            ->add('nom')
            ->add('prenom')
            ->add('email','email',array('required'=>true))
            ->add('actif','checkbox',array('required'=>false))
            
           // ->add('idPays')
            //->add('datecreateAt')
            //->add('Profils')
            
			//->add('Profils_id',array('required'=>true))
        
        ->add('Profils_id','entity',array(
        		'property'=>'libelleProfil',
        		'label'=>'Profil',
        		'multiple'    => false,
        		'empty_value' => 'Selectionnez un Profil',
        		'empty_data'  => null,
        		'query_builder' => function (ProfilsRepository $er) {
        		 
        		return $er->createQueryBuilder('t')
        		->where('t.actif=1')
        		->orderBy('t.libelleProfil', 'ASC')
        		;
        },
         
        'required'=>true,
         
        'class'=>'oeuvresBundle:Profils'
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
            'data_class' => 'oeuvresBundle\Entity\Utilisateurs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_utilisateurs';
    }
}
