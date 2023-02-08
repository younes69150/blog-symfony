<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr'=>['class'=>'w-full border border-gray-400 p-2 rounded-lg']
            ])
            ->add('description', TextareaType::class, [
                'attr'=>['class'=>'w-full border border-gray-400 p-2 rounded-lg']
            ])
            ->add('createdAT', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'hidden'],
                'label' => ' ',
                'data' => new \DateTime(),]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
