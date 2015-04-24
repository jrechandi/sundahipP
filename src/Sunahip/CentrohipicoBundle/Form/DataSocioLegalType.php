<?php

namespace Sunahip\CentrohipicoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DataSocioLegalType extends AbstractType
{

    private $userId;

    function __construct($userId = null)
    {
        $this->userId = $userId;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'padre',
                'entity',
                array(
//                    "multiple" => true,
                    'label' => 'Empresa',
                    "mapped" => true,
                    'class' => 'CentrohipicoBundle:DataLegal',
                    'property' => 'nombreComercial',
                    'required' => true,
                    'empty_value' => 'Seleccione una empresa',
                    'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('dl')
                                ->where('dl.usuario = (:userId)')
                                ->andWhere('dl.padre is null')
                                ->setParameter('userId', $this->userId);
                        }
                )
            )
            ->add('nombreComercial',null,array('label'=>'Nombre de la Empresa'))
            ->add('nombre',null,array('label'=>'Nombre'))
            ->add('apellido',null,array('label'=>'Apellido'))
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

            ->add('urbanSector',null,array('label'=>'Urbanización/Sector'))
            ->add('avCalleCarrera',null,array('label'=>'Avenida/Calle/Carrera'))
            ->add('edifCasa',null,array('label'=>'Edificio/Casa'))
            ->add('ofcAptoNum',null,array('label'=>'Oficina/Apto/No.'))
            ->add('puntoReferencia',null,array('label'=>'Punto de Referencia'))
            ->add('codigoPostal',null, array(
                    'label'=>'Código Postal',
                    'required' => true
                ))
            ->add('fax',null, array(
                    'label'=>'No. Fax',
                    'required' => false
                ))

            ->add('codTlfFijo',null,array('label'=>' ',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))
            ->add('tflFijo',null,array('label'=>'No. Teléfono Fijo',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))

            ->add('codTlfCelular',null,array('label'=>' ',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))
            ->add('tflCelular',null,array('label'=>'No. Teléfono Celular',
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)",
                        'required' => false
                    )))
            ->add('email',null,array(
                    'label'=>'Correo Electrónico',
                    'required' => false
                ))
            ->add('pagWeb','text',array(
                    'label'=>'Página Web',
                    'required' => false
                ))
            ->add('estado','entity', array(
                    'class' => 'CommonBundle:SysEstado',
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione un estado',
                    'attr' => array(
                        'class' => 'dlestados'
                    )))
            // ->add('isSocio',null,array('label'=>'Es Socio'))
            //->add('fechaRegistro')
            //->add('status')
            //->add('usuario')
            //->add('ciudad')
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
        return 'sunahip_centrohipicobundle_datalegal_socio';
    }
}
