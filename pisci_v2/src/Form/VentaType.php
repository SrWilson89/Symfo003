<?php

namespace App\Form;

use App\Entity\Empleado;
use App\Entity\Venta;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('empleado', EntityType::class, [
                'class' => Empleado::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Selecciona un empleado',
                'label' => 'Empleado',
            ])
            ->add('total', NumberType::class, [
                'label' => 'Cantidad',
                'required' => true,
            ])
            ->add('fecha', DateType::class, [
                'label' => 'Fecha de la Venta',
                'widget' => 'single_text',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venta::class,
        ]);
    }
}