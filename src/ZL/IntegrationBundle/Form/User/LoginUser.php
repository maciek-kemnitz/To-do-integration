<?php

namespace ZL\IntegrationBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class LoginUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', 'text')
				->add('password', 'password');
    }

    public function getName()
    {
        return 'login';
    }
	
	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'ZL\IntegrationBundle\Entity\User',
		);
	}
}