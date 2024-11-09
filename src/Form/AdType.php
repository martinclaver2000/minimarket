<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a category',
            ])
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Give a title',
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Address where can get the article',
                ],
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Give a price',
                ],
            ])
            ->add('images', FileType::class, [
                'multiple' => true,
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Write the description of item',
                    'rows' => '7',
                    'cols' => '50',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
