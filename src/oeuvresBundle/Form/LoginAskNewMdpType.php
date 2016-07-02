<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


use \oeuvresBundle\Form\Type\lnkurlType;
class LoginAskNewMdpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder

        ->add('email','email',array('label'=>'Votre email','required'=>true,'mapped'=>false))
        ;
            	 
    	 
    }
        
        /*
         * 
 $builder->add('category', new CategoryType());         * 
         */
        
        
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
        return 'oeuvresbundle_newmdp';
    }
}
