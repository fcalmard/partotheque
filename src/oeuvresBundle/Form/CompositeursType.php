<?php

namespace oeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompositeursType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom','text',array('required'=>true,'label_attr' => array('class' => 'clsLabelEntity')))
            ->add('prenom','text',array('required'=>false,'label_attr' => array('class' => 'clsLabelEntity')))
            ->add('nationalite','text',array('required'=>false,'label_attr' => array('class' => 'clsLabelEntity')))
/*
            ->add('datenaiss', 'date', array(
            		'label' => 'Né le',
            		'widget' => 'single_text',
            		'input' => 'datetime',
            		'format' => 'dd/MM/yyyy'),array('required'=>false),array('label_attr' => array('class' => 'clsLabelEntity')))
            		       */     
            ->add('datenaiss','text',array('required'=>false,'label_attr' => array('class' => 'clsLabelEntity')))
            ->add('datedeces','text',array('required'=>false,'label_attr' => array('class' => 'clsLabelEntity')))
            ->add('historique','textarea',array('label'=>'Historique','required'=>false,'label_attr' => array('class' => 'clsLabelEntity')))
            ->add('active','checkbox',array('required'=>false,'label_attr' => array('class' => 'clsLabelEntity')))
            ->add('datecreateAt','text',array('disabled'=>true,'required'=>false,'label_attr' => array('class' => 'clsLabelEntity')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oeuvresBundle\Entity\Compositeurs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oeuvresbundle_compositeurs';
    }
}
