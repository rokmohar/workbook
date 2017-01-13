<?php

namespace AppBundle\Form;


use CoreBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array(
                'disabled' => $options['content_disabled'],
                'label' => 'What is on your mind?',
                'required' => true,
                'trim' => true,
            ))
            ->add('type', ChoiceType::class, array(
                'choices'  => Post::getTypes(),
                'disabled' => $options['type_disabled'],
                'empty_data'  => null,
                'label' => 'Type',
                'multiple' => false,
                'required' => true,
            ))
            ->add('privacy', ChoiceType::class, array(
                'choices'  => Post::getPrivacies(),
                'disabled' => $options['privacy_disabled'],
                'empty_data'  => null,
                'label' => 'Privacy',
                'required' => true,
            ))
            ->add('state', ChoiceType::class, array(
                'choices'  => Post::getStates(),
                'disabled' => $options['state_disabled'],
                'empty_data'  => null,
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
            'content_disabled' => false,
            'data_class' => Post::class,
            'privacy_disabled' => false,
            'state_disabled' => false,
            'type_disabled' => false,
        ));
    }
}
