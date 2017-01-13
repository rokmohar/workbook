<?php

namespace AppBundle\Form;


use CoreBundle\Entity\PostComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostCommentType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array(
                'disabled' => $options['content_disabled'],
                'label' => 'form.post_comment.content',
                'required' => true,
                'trim' => true,
            ))
            ->add('state', ChoiceType::class, array(
                'choices'  => PostComment::getStates(),
                'disabled' => $options['state_disabled'],
                'empty_data'  => null,
                'label' => 'form.post_comment.state',
                'required' => true,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'form.post_comment.submit',
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
            'data_class' => PostComment::class,
            'state_disabled' => false,
        ));
    }
}
