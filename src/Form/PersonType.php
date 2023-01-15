<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['required' => true, 'label_attr' => ['class' => 'form-label'], 'attr' => ['class' => 'form-control']])
            ->add('lastname', TextType::class, ['required' => true, 'label_attr' => ['class' => 'form-label'], 'attr' => ['class' => 'form-control']])
            ->add('position', TextType::class, ['required' => true, 'label_attr' => ['class' => 'form-label'], 'attr' => ['class' => 'form-control']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
