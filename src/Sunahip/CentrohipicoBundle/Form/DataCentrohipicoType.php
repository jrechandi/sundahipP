<?php

namespace Sunahip\CentrohipicoBundle\Form;

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
        $this->hidden = $hidden;
    }

     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!$this->hidden){
        $builder
            ->add(
                'empresa', 'entity',  array(
                    'label' => 'Empresa',
                    "mapped" => true,
                    'class' => 'CentrohipicoBundle:DataEmpresa',
                    'property' => 'denominacionComercial',
                    'required' => true,
                    'empty_value' => 'Seleccione una empresa',
                    'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('de')
                                ->where('de.usuario = (:userId)')
                                ->andWhere('de.padre is null')
                                ->setParameter('userId', $this->userId);
                        }
                )
            );
        }
        $builder
            ->add('denominacionComercial',null,array('label'=>'Denominación Comercial del lugar de explotación de la actividad hipica'))
            ->add('estatusLocal','choice', array(
                'choices'   => array('Propio' => 'Propio', 'Arrendado' => 'Arrendado'),
                'required'  => true,
                'label'=>'Local Propio o arrendado'))
            ->add('propietarioLocal',null,array(
                'label'=>'Nombre de la Empresa o persona natural propietaria del local',
                    'required' => false
                ))
            ->add('persJuridicaDueno',null,array('label'=>' '))
            ->add('rifDueno','text',array('label'=>'Rif','required' => false,'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 9, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                )))
            ->add('nombre',null,array('label'=>'Nombre','required' => false))
            ->add('apellido',null,array('label'=>'Apellido','required' => false))
            ->add('tipoci',null,array('label'=>' ','required' => false))
            ->add('ci','text',array('label'=>'Cédula','required' => false,'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 8, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )))
            ->add('urbanSector',null,array('label'=>'Urbanización/Sector'))
            ->add('avCalleCarrera',null,array('label'=>'Avenida/Calle/Carrera'))
            ->add('edifCasa',null,array('label'=>'Edificio/Casa'))
            ->add('ofcAptoNum',null,array('label'=>'Oficina/Apto/No.'))
            ->add('puntoReferencia',null,array('label'=>'Punto de Referencia', 'required' => false))
            ->add('codigoPostal',null,array(
                'required' => false
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
            ->add('email',null,array('label'=>'Correo Electrónico', 'required' => true))
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
            /*->add('fechaRegistro','date',array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd'
                ))*/
             ->add('clasificacionLocal',null,array(
                    'class' => 'LicenciaBundle:AdmClasfEstab',
                    'property' => 'clasificacionCentrohipico',
                    'required' => true,
                    'label' => 'Clasificación del Local',
                    'empty_value' => 'Seleccione'))             
             //->add('usuario')              
             //->add('status')       
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
             //->add('legal')    
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
