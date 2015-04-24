<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DataCentrohipicoType extends AbstractType
{

    private $userId;

    function __construct($userId = null, $hidden = false)
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
            ->add('denominacionComercial',null,array('label'=>'Denominación Comercial del lugar de explotación de la actividad hipica'))
            ->add('persJuridica',null,array('label'=>' ', 'required' => true))
            ->add('rif','text',array('label'=>'RIF Centro Hípico','required' => true,'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 9, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                )))
            ->add('persJuridicaDueno',null,array('label'=>' '))
            ->add('rifDueno','text',array('label'=>'RIF Dueño','required' => false,'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 9, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                )))
            ->add('nombre',null,array('label'=>'Nombre Dueño','required' => false))
            ->add('apellido',null,array('label'=>'Apellido Dueño','required' => false))
            ->add('tipoci',null,array('label'=>' ','required' => false))
            ->add('ci','text',array('label'=>'Cédula Dueño','required' => false,'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 8, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('urbanSector',null,array('label'=>'Urbanización/Sector','required' => false))
            ->add('avCalleCarrera',null,array('label'=>'Avenida/Calle/Carrera','required' => false))
            ->add('edifCasa',null,array('label'=>'Edificio/Casa','required' => false))
            ->add('ofcAptoNum',null,array('label'=>'Oficina/Apto/No.','required' => false))
            ->add('puntoReferencia',null,array('label'=>'Punto de Referencia', 'required' => false))
            ->add('codigoPostal',null,array(
                'required' => false
            ))
            ->add('codFax',null,array('label'=>' ',
                    'required' => false,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('fax',null, array('label'=>'No. Fax', 'required' => false))
                
            ->add('codTlfFijo',null,array('label'=>' ',
                'required' => false,
                'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
                
            ->add('tflFijo',null,array('label'=>'No. Teléfono Fijo',
                'required' => false,
                'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('codTlfCelular',null,array('label'=>' ',
                'required' => false,
                'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('tflCelular',null,array('label'=>'No. Teléfono Celular',
                'required' => false,
                'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('email',null,array('label'=>'Correo Electrónico', 'required' => false))
            ->add('estado','entity', array(
                    'class' => 'CommonBundle:SysEstado',
                    'property' => 'nombre',
                    'required' => false,
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione un estado',
                    'attr' => array(
                        'class' => 'estados'
                    )))     
             ->add('ciudad',null,array(
                 "label"=>'Ciudad',
                 'required' => false,
                 ))
            ->add('municipio', null, array(
                'property' => 'nombre',
                'empty_value' => 'Seleccione municipio',
                'required' => false
            ))
            ->add('parroquia', null, array(
                'property' => 'nombre',
                'empty_value' => 'Seleccione parroquia',
                'required' => false
            ))  
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\CentrohipicoBundle\Entity\DataCentrohipico'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_centrohipicobundle_datacentrohipico';
    }
}
