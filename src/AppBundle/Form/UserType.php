<?php

namespace AppBundle\Form;

use CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, array(
                'disabled' => $options['email_disabled'],
                'label' => 'Email address',
                'required' => true,
                'trim' => true,
            ))
            ->add('password', RepeatedType::class, array(
                'disabled' => $options['password_disabled'],
                'first_options' => array(
                    'label' => 'Password',
                ),
                'property_path' => 'plainPassword',
                'required' => true,
                'second_options' => array(
                    'label' => 'Confirm password',
                ),
                'type' => PasswordType::class,
            ))
            ->add('name', TextType::class, array(
                'disabled' => $options['name_disabled'],
                'label' => 'Name',
                'required' => true,
                'trim' => true,
            ))
            ->add('state', ChoiceType::class, array(
                'choices'  => User::getStates(),
                'disabled' => $options['state_disabled'],
                'label' => 'State',
                'required' => true,
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
            'data_class' => User::class,
            'email_disabled' => false,
            'name_disabled' => false,
            'password_disabled' => false,
            'state_disabled' => false,
        ));
    }
}
