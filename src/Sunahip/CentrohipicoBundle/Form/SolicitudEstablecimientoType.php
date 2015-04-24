<?php

namespace Sunahip\CentrohipicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicitudEstablecimientoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'contratoFirmado',
                'vlabs_file',
                array(
                    "mapped" => true,
                    'label' => false,
                    'required' => true,
                )
            )
            ->add(
                'buenaPro',
                'vlabs_file',
                array(
                    "mapped" => true,
                    'label' => false,
                    'required' => true,
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_centrohipicobundle_data_operadora_establecimiento';
    }
}
