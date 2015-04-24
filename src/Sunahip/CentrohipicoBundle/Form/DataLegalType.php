<?php

namespace Sunahip\CentrohipicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataLegalType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreComercial',null,array('label'=>'Nombre de la Empresa'))
            ->add('nombre',null,array('label'=>'Nombre','required' => true))
            ->add('apellido',null,array('label'=>'Apellido','required' => true))
            ->add('persJuridica',null,array('label'=>' '))
                
            ->add('rif','text',array('label'=>'Rif','attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 9, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('tipoci',null,array('label'=>' '))
                
            ->add('ci','text',array('label'=>'Cédula','attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 8, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"                        
                    )))
                
            ->add('urbanSector', null, array('label'=>'Urbanización/Sector', 'attr'  => array('maxlength'=> 25)))
            ->add('avCalleCarrera',null,array('label'=>'Avenida/Calle/Carrera', 'attr'  => array('maxlength'=> 25)))
            ->add('edifCasa',null,array('label'=>'Edificio/Casa', 'attr'  => array('maxlength'=> 25)))
            ->add('ofcAptoNum',null,array('label'=>'Oficina/Apto/No.', 'attr'  => array('maxlength'=> 25)))
            ->add('puntoReferencia',null,array('label'=>'Punto de Referencia', 'required' => false, 'attr'  => array('maxlength'=> 25)))
            ->add('codigoPostal',null, array(
                'label'=>'Código Postal',
                'required' => true
                ))
            ->add('codFax',null,array('label'=>' ',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('fax',null, array(
                'label'=>'No. Fax',
                'required' => false
                ))
                
            ->add('codTlfFijo',null,array('label'=>' ',
                    'required' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))
            ->add('tflFijo',null,array('label'=>'No. Teléfono Fijo',
                    'required' => true,
                'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))
                
            ->add('codTlfCelular',null,array('label'=>' ',
                    'required' => true,
                'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))
            ->add('tflCelular',null,array('label'=>'No. Teléfono Celular',
                'required' => true,
                 'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))
            ->add('email',null,array(
                'label'=>'Correo Electrónico',
                'required' => true,
                'attr'     => array('maxlength'=> 50)
                ))
            ->add('pagWeb','text',array(
                'label'=>'Página Web',
                'required' => false
                ))
            ->add('estado','entity', array(
                    'class' => 'CommonBundle:SysEstado',
                    'property' => 'nombre',
                    
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione un estado',
                    'attr' => array(
                        'class' => 'dlestados'
                    )))
            ->add('ciudad',null,array(
                "label"=>'Ciudad',
                'required' => true,
                ))
            ->add('municipio','entity', array(
                    'class' => 'CommonBundle:SysMunicipio',
                    'property' => 'nombre',

                    'label' => 'Municipio',
                    'empty_value' => 'Seleccione un municipio',
                    'attr' => array(
                    )))
            ->add('parroquia','entity', array(
                    'class' => 'CommonBundle:SysParroquia',
                    'property' => 'nombre',

                    'label' => 'Parroquia',
                    'empty_value' => 'Seleccione una parroquia',
                    'attr' => array(
                    )))
            // ->add('isSocio',null,array('label'=>'Es Socio'))   
            //->add('fechaRegistro')
            //->add('status')                
            //->add('usuario')      
            //->add('municipio')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\CentrohipicoBundle\Entity\DataLegal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_centrohipicobundle_datalegal';
    }
}
