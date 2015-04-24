<?php

namespace Sunahip\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ExtraPerfilType extends AbstractType
{

    private $idEstado;
    private $idMunicipio;

    function __construct( $idEstado, $idMunicipio, $idParroquia )
    {
        $this->idEstado = $idEstado;
        $this->idMunicipio = $idMunicipio;
        $this->idParroquia = $idParroquia;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       //$idEstado = $this->idEstado;
        
        parent::buildForm($builder, $options);
        $builder
                ->remove('persJuridica')
                ->remove('rif')
                ->remove('ci')
                ->remove('nombre')
                ->remove('apellido')
                ->remove('email')
                ->remove('password')
                ->remove('confirm')
                
                
                ->add('estado', 'entity', array(
                    'class' => 'CommonBundle:SysEstado',
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Estado',
                    'empty_value' => 'Seleccione un estado',
                    'attr' => array(
                        'class' => 'estados'
                    )
                ))
                
                ->add('municipio', 'entity', array(
                    'class' => 'CommonBundle:SysMunicipio',
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Municipio',
                    'empty_value' => 'Seleccione un municipio',
                    'mapped' => true,
                    'error_bubbling' => true,
                    'attr' => array(
                        'class' => 'municipio',
                        'data-selected' => $this->idMunicipio
                    ),
                   /* 'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                        ->where('m.estado = :idEstado ')
                        ->setParameter('idEstado', $this->idEstado);
                        }*/
                ))
//                ->add('ciudad', 'entity', array(
//                    'class' => 'CommonBundle:SysCiudad',
//                    'property' => 'nombre',
//                    'required' => true,
//                    'label' => 'Ciudad',
//                    'mapped' => true,
//                    'error_bubbling' => true,
//                    'attr' => array(
//                        'class' => 'ciudades'
//                    ),
//                    'query_builder' => function (EntityRepository $er) {
//                        return $er->createQueryBuilder('c')
//                        ->where('c.estado = :idEstado ')
//                        ->setParameter('idEstado', $this->idEstado);
//                        }
//                ))
                ->add('parroquia', 'entity', array(
                    'class' => 'CommonBundle:SysParroquia',
                    'property' => 'nombre',
                    'required' => true,
                    'label' => 'Parroquia',
                    'mapped' => true,
                    'empty_value' => 'Seleccione una parroquia',
                    'error_bubbling' => true,
                    'attr' => array(
                        'data-selected' => $this->idParroquia
                    ),
                    /*'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                        ->where('p.municipio = :idMunicipio ')
                        ->setParameter('idMunicipio', $this->idMunicipio);
                        }*/
                ));
            
                
                 $builder
                 ->add('ciudad','text',array("label"=>'Ciudad'))
                 ->add('urbanizacion','text',array("label"=>'Urbanización/Sector'))
                 ->add('calle', 'text', array(
                    'required' => true,
                    'label' => "Avenida/Calle/Carrera",
                    'trim' => true
                ))
                ->add('apartamento', 'text', array(
                    'required' => true,
                    'label' => "Edificio/Casa",
                    'trim' => true
                ))
                ->add('apartamento_no', 'text', array(
                    'required' => true,
                    'label' => "Oficina/Apto/No.",
                    'trim' => true
                ))
                ->add('referencia', 'text', array(
                    'required' => false,
                    'label' => "Punto de Referencia",
                    'trim' => true
                ))
                ->add('codigo_postal', 'text', array(
                    'required' => false,
                    'label' => "Código Postal",
                    'trim' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 5
                    )
                ))
                ->add('cod_fax', 'text', array(
                    'required' => false,
                    'label' => "No. Fax",
                    'trim' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )
                ))
                ->add('fax', 'text', array(
                    'required' => false,
                    'trim' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 15
                    )
                ))
                ->add('cod_telefono_local', 'text', array(
                    'required' => true,
                    'label' => "Teléfono Fijo",
                    'trim' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )
                ))
                ->add('telefono_local', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )
                ))
                ->add('cod_telefono_movil', 'text', array(
                    'required' => true,
                    'label' => "Teléfono Móvil",
                    'trim' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 4, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )
                ))
                ->add('telefono_movil', 'text', array(
                    'required' => false,
                    'trim' => true,
                    'attr' => array(
                        'class' => 'numeric',
                        'maxlength' => 7, //Longitud máxima
                        "onkeypress" => "return isNumericInteger(event)"
                    )
                ))
                ->add('correo_alternativo', 'email', array(
                    'required' => true,
                    'label' => "Correo Electrónico Alternativo",
                    'trim' => true
                ))
                ->add('sitio_web', 'text', array(
                    'required' => false,
                    'label' => "Página Web",
                    'trim' => true,
                    'attr'=>array('size'=>'70')
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
                array(
                    'data_class' => 'Sunahip\UserBundle\Entity\SysPerfil',
                    'intention' => 'extra_user_profile'
                )
        );
    }

    public function getName()
    {
        return 'extra_user_profile';
    }

}
