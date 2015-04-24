<?php

namespace Sunahip\PagosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BancoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('banco')
            ->add('numeroCuenta', null, array(
                    'required' => true,
                'attr' => array(
                    'class' => 'numeric',
                    'maxlength' => 20
                )
                ))
            ->add('activo', 'checkbox', array(
                    'required' => false,
                    'label' => 'Activo?',
                    'data' => true
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\PagosBundle\Entity\Banco'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_pagosbundle_banco';
    }
}
