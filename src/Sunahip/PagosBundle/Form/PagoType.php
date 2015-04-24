<?php

namespace Sunahip\PagosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PagoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoPago')
            ->add('numReferencia',null,array(
                'attr' => array('maxlength ' => '15'),
            ))
            ->add('fechaDeposito',null,array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datePago','placeholder' => 'dd/mm/aaaa'),
                'label'=>'Fecha Deposito',
                ))
            ->add('monto')
            ->add('fechaCreacion')
            ->add('fechaProceso')
            ->add('status')
            ->add('operadora')
            ->add('centroHipico')
            ->add('banco','entity', array(
                    'class' => 'PagosBundle:Banco',
                    'property' => 'banco',
                    'required' => true,
                    'label' => 'Banco',
                    'empty_value' => 'Seleccione Banco ',
                    'attr' => array(
                        'class' => 'banco'
                    )))
            ->add('usuarioCreacion')
            ->add('usuarioPaga')
            ->add('archivoAdjunto','vlabs_file',
                array(
                    "mapped" => true,
                    'label' => false,
                    'required' => true,
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\PagosBundle\Entity\Pagos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_pagosbundle_pagos';
    }
}
