<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PagosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('banco','entity', array(
                    'class' => 'PagosBundle:Banco',
                    'property' => 'banco',
                    'required' => true,
                    'label' => 'Banco',
                    'empty_value' => 'Seleccione Banco ',
                    'attr' => array(
                        'class' => 'banco'
                    )))
            ->add('numReferencia','text',array(
                'attr' => array('maxlength' => '15', 'class' => 'numeric')
            ))
            ->add('fechaDeposito',null,array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datePago')
            ))
            ->add('archivoAdjunto', 'vlabs_file', array('required' => true))
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
        return 'sunahip_fiscalizacionbundle_pagos';
    }
}