<?php

namespace Sunahip\CentrohipicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataSucursalType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaRegistro')
            ->add('status')
            ->add('denominacionComercial')
            ->add('persJuridica')
            ->add('rif')
            ->add('estatusLocal')
            ->add('propietarioLocal')
            ->add('nombre')
            ->add('apellido')
            ->add('tipoci')
            ->add('ci')
            ->add('urbanSector')
            ->add('avCalleCarrera')
            ->add('edifCasa')
            ->add('ofcAptoNum')
            ->add('puntoReferencia')
            ->add('codigoPostal')
            ->add('fax')
            ->add('codTlfFijo')
            ->add('tflFijo')
            ->add('codTlfCelular')
            ->add('tflCelular')
            ->add('email')
            ->add('pagWeb')
            ->add('ciudad')
            ->add('usuario')
            ->add('estado')
            ->add('municipio')
            ->add('parroquia')
            ->add('legal')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\CentrohipicoBundle\Entity\DataSucursal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_centrohipicobundle_datasucursal';
    }
}
