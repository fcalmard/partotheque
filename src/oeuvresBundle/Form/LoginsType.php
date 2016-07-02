<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


use \oeuvresBundle\Form\Type\lnkurlType;
class LoginsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder

        ->add('login','text',array('label'=>'Login','required'=>true,'mapped'=>false))
        ->add('pwd','password',array('label'=>'Mot de passe','required'=>true,'mapped'=>false));
        
    	$builder->add('oublimdp', new lnkurlType(),array('label'=>'Mot de passe oublié','mapped'=>false));
    	 
    	
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
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Logins'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_logins';
    }
}
