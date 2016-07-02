<?php
// src/oeuvresBundle/Form/Type/lnkurlType.php

namespace oeuvresBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class lnkurlType extends AbstractType
{
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array());
	}
	
	/*
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'oeuvresBundle\Entity\Partitions',
		));
	}
	*/
	public function getParent()
	{
		return 'url';
	}

	public function getName()
	{
		return 'lnkurl';
	}
}
?>