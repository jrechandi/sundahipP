<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MercantilType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, array('label'=>'Nombre Registro Mercantil'))
            ->add('fecha', null, array(
                'widget' => 'single_text',
                'datepicker' => true,
                'label'  => 'Fecha de Registro Mercantil',
            ))
            ->add('num',null, array('label'=>'Número Registro Mercantil'))
            ->add('tomo',null, array('label'=>'Tomo Registro Mercantil'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\FiscalizacionBundle\Entity\Mercantil'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_fiscalizacionbundle_mercantil';
    }
}
