<?php

namespace Cornichon\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserSignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email')
            ->add('password', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array('label' => 'password'),
                'second_options'  => array('label' => 'confirm.password'),
                'invalid_message' => 'password.not.match'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cornichon\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'cornichon_usersignup';
    }
}
