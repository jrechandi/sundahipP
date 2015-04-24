<?php

namespace Sunahip\LicenciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdmTipoAporteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('admClasfLicencias', 'entity', array(
                    'label' => 'Clasificación de Licencia',
                    'class' => 'LicenciaBundle:AdmClasfLicencias',
                    'required' => true,
                    'empty_value' => 'Seleccione',
                ))
            ->add('admClasfEstab', null, array(
                    'required' => true,
                    'label'    => 'Clasificación de Establecimiento',
                    'multiple' => true,
                    'attr'     => array('style'=>'width:400px; height: 100px;')
                ))
            ->add('montoAporte', 'text', array('label'=>'Monto del Aporte'))
            ->add('por_juego', 'choice', array(
                    'choices' => array('0' => 'No', '1' => 'Si'),
                    'label'   => 'Por Juego'
                ))
            ->add('status', 'choice', array(
                    'choices' => array('1' => 'Activo', '0' => 'Inactivo'),
                    'label'   => 'Estatus'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\LicenciaBundle\Entity\AdmTipoAporte'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_licenciabundle_admtipoaporte';
    }
}
