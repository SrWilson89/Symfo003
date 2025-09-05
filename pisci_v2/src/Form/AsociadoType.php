<?php

namespace App\Form;

use App\Entity\Asociado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsociadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label' => 'Nombre'])
            ->add('dni', TextType::class, ['label' => 'DNI'])
            ->add('telefono', TextType::class, ['label' => 'Teléfono'])
            ->add('esTitular', CheckboxType::class, [
                'label' => 'Es Titular',
                'required' => false,
            ])
            ->add('fecha', DateType::class, [
                'label' => 'Creación',
                'widget' => 'single_text',
                'html5' => false,
                'disabled' => true,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Asociado::class,
        ]);
    }
}