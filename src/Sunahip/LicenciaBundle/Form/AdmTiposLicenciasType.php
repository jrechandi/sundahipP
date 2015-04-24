<?php

namespace Sunahip\LicenciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Sunahip\CommonBundle\DBAL\Types\UsuarioLicenciaType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdmTiposLicenciasType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoLicencia', 'text', array('label'=>'Tipo de Licencia'))
            ->add('roleType', 'choice', array(
                    'choices' => UsuarioLicenciaType::getChoices(),
                    'required' => true,
                    'label' => "Válida Para",
                    'trim' => true,
                    'empty_value' => 'Seleccione',
                ))
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
            'data_class' => 'Sunahip\LicenciaBundle\Entity\AdmTiposLicencias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_licenciabundle_admtiposlicencias';
    }
}
