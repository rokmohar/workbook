<?php

namespace AppBundle\Form;

use CoreBundle\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, array(
                'label' => 'Email address',
                'required' => true,
                'trim' => true,
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'first_options' => array(
                    'label' => 'Password',
                ),
                'required' => true,
                'second_options' => array(
                    'label' => 'Confirm password',
                ),
                'type' => PasswordType::class,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Submit',
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Admin::class,
        ));
    }
}
