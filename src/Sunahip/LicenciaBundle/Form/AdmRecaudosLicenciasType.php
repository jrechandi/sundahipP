<?php

namespace Sunahip\LicenciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdmRecaudosLicenciasType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recaudo', 'textarea', array('label'=>'Recaudo', 'attr' => array('style'=>'height: 100px;')))
            ->add('fechaVencimiento', 'choice', array(
                    'choices' => array('1' => 'Si', '0' => 'No')))
            ->add('status', 'choice', array(
                    'choices' => array('1' => 'Activo', '0' => 'Inactivo'),
                    'label' => 'Estatus'
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_licenciabundle_admrecaudoslicencias';
    }
}
