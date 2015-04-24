<?php

namespace Sunahip\CentrohipicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Sunahip\CentrohipicoBundle\Form\DataLegalType;

class DataEmpresaType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denominacionComercial',null,array('label'=>'Nombre de la empresa'))
            ->add('persJuridica',null,array('label'=>' '))
            ->add('rif','text',array('label'=>'Rif','attr' => array(
                    'class' => 'numeric',
                    'maxlength' => 9, //Longitud máxima
                    "onkeypress" => "return isNumericInteger(event)"
                )))
            ->add('urbanSector',null,array('label'=>'Urbanización/Sector'))
            ->add('avCalleCarrera',null,array('label'=>'Avenida/Calle/Carrera'))
            ->add('edifCasa',null,array('label'=>'Edificio/Casa'))
            ->add('ofcAptoNum',null,array('label'=>'Oficina/Apto/No.'))
            ->add('puntoReferencia',null,array('label'=>'Punto de Referencia', 'required' => false))
            ->add('codigoPostal',null,array(
                    'attr'=>array(
                        ''=>''
                    )
                ))

            ->add('codFax',null,array('label'=>' ',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('fax',null, array('label'=>'No. Fax'))

            ->add('codTlfFijo',null,array('label'=>' ',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))

            ->add('tflFijo',null,array('label'=>'No. Teléfono Fijo',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('codTlfCelular',null,array('label'=>' ',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('tflCelular',null,array('label'=>'No. Teléfono Celular',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('email',null,array('label'=>'Correo Electrónico','required' => true,))
            ->add('pagWeb','text',array('label'=>'Página Web','required' => false))
            ->add('estado','entity', array(
                    'class' => 'CommonBundle:SysEstado',
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione un estado',
                    'attr' => array(
                        'class' => 'estados'
                    )))
            ->add('ciudad',null,array(
                    "label"=>'Ciudad',
                    'required' => true,
                ))
            ->add('municipio', null, array(
                    'property' => 'nombre',
                    'empty_value' => 'Seleccione municipio',
                ))
            ->add('parroquia', null, array(
                    'property' => 'nombre',
                    'empty_value' => 'Seleccione parroquia',
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Sunahip\CentrohipicoBundle\Entity\DataEmpresa'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_centrohipicobundle_dataempresa';
    }
}
