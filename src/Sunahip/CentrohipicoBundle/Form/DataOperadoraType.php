<?php

namespace Sunahip\CentrohipicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sunahip\CentrohipicoBundle\Form\DataLegalType;

class DataOperadoraType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denominacionComercial','text',array('label'=>'Denominación Comercial del lugar de explotación de la actividad hipica'))
            ->add('estatusLocal','choice', array(
                'choices'   => array('Propio' => 'Propio', 'Arrendado' => 'Arrendado'),
                'required'  => true,
                'label'=>'Local Propio o arrendado'))
            ->add('propietarioLocal',null,array(
                'label'=>'Nombre de la Empresa o persona natural propietaria del local'
                ))
            ->add('persJuridica',null,array('label'=>' '))
            ->add('rif','text',array('label'=>'Rif','attr' => array(
                            'class' => 'numeric',
                            'maxlength' => 9, //Longitud máxima
                            "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('nombre',null,array('label'=>'Nombre'))
            ->add('apellido',null,array('label'=>'Apellido'))
            ->add('tipoci',null,array('label'=>' '))
            ->add('ci','text',array('label'=>'Cédula','attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 8, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('urbanSector',null,
                  array('label'=>'Urbanización/Sector', 'attr' => array('maxlength' => 25))
            )
            ->add('avCalleCarrera',null, array(
                  'label'=>'Avenida/Calle/Carrera',
                  'attr' => array('maxlength' => 25))
            )
            ->add('edifCasa',null, array(
                'label'=>'Edificio/Casa',
                'attr' => array('maxlength' => 25)
                )
            )
            ->add('ofcAptoNum',null, array(
                'label'=>'Oficina/Apto/No.',
                'attr' => array('maxlength' => 25)
                )
            )
            ->add('puntoReferencia',null, array(
                  'label'=>'Punto de Referencia',
                  'attr' => array(
                      'maxlength' => 25,
                      'required'=> false
                  )
                )
            )
            ->add('codigoPostal',null,array(
                'label' =>'Código Postal',
                'required' => false
            ))
            ->add('codFax',null,array('label'=>' ',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required'=> false
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
                        "onkeypress" => "return isNumericInteger(event)",
                        'required'=> false
                    )))
            ->add('tflCelular',null,array('label'=>'No. Teléfono móvil',
                'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required'=> false
                    )))
            ->add('email',null,array('label'=>'Correo Electrónico'))
            ->add('pagWeb',null,array('label'=>'Página Web'))
            ->add('estado','entity', array(
                    'class' => 'CommonBundle:SysEstado',
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione un estado',
                    'attr' => array(
                        'class' => 'estados'
                    )))
//            ->add('legal',new DataLegalType())
            ->add('ciudad',null, array(
                  "label"=>'Ciudad',
                  'attr' => array('maxlength' => 25)
                )
            )
            //->add('usuario')    
            ->add('municipio', null,  array(
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione un municipio',
                    'attr' => array(
                        'class' => 'municipio'
                    )
                )
            )
            ->add('parroquia', null,  array(
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione una parroquia',
                    'attr' => array(
                        'class' => 'parroquia'
                    )
                )
            )
            //->add('fechaRegistro')
            //->add('status')     
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\CentrohipicoBundle\Entity\DataOperadora'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_centrohipicobundle_dataoperadora';
    }
}
