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
                'label' => 'What is on your mind?',
                'required' => true,
                'trim' => true,
            ))
            ->add('type', ChoiceType::class, array(
                'choices'  => array_flip(Post::getTypes()),
                'empty_data'  => null,
                'label' => 'Type',
                'required' => true,
            ))
            ->add('privacy', ChoiceType::class, array(
                'choices'  => array_flip(Post::getPrivacies()),
                'empty_data'  => null,
                'label' => 'Privacy',
                'required' => true,
            ))
            ->add('state', ChoiceType::class, array(
                'choices'  => array_flip(Post::getStates()),
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
            'data_class' => Post::class,
        ));
    }
}
