<?php

namespace Sunahip\LicenciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdmClasfEstabType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clasificacionCentrohipico', 'text', array('label'=>'Clasificación de Establecimiento'))
            ->add('promedioVentas', 'text', array('label'=>'Promedio de Ventas'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\LicenciaBundle\Entity\AdmClasfEstab'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_licenciabundle_admclasfestab';
    }
}
