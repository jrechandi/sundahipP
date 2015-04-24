<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiscalizacionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('responsable')
            ->add('codCedula', 'choice', array(
                'label' => 'Tipo',
                'choices' => array('V'=>'V', 'E'=>'E'),
                'horizontal_input_wrapper_class' => 'col-lg-2',
            ))
            ->add('cedula', null, array(
                'attr' => array(
                    'maxlength' => '8',
                    'title'     => 'El número de cédula ingresado no es válido',
                    'pattern'   => '[0-9]{6,8}'
                )
            ))
            ->add('cargo')
            ->add('juegos')
            ->add('estatus', 'choice', array(
                'label' => 'Estatus Inicial',
                'choices' => array('Solvente' => 'Solvente', 'Citado' => 'Citado')
            ))
            ->add('documentos', 'collection', array(
                    'type' =>  new DocumentoType(),
                    'horizontal' => true,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'label' => 'Adjuntos',
                    'by_reference' => false,
                    'options' => array( // options for collection fields
                       'label_render' => false,
                       'horizontal_input_wrapper_class' => "col-lg-3",                 
                    )
                )
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\FiscalizacionBundle\Entity\Fiscalizacion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_fiscalizacionbundle_fiscalizacion';
    }
}