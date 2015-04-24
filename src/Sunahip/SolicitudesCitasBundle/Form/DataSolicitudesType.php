<?php

namespace Sunahip\SolicitudesCitasBundle\Form;

use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\ArrayToPartsTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Sunahip\PagosBundle\Form\PagoType;

class DataSolicitudesType extends AbstractType
{
    protected $user;
    protected $tipoL;
    protected $clasfL;


    public function __construct($user,$tipoL,$clasfL=array()) {
        $this->user=$user;
        $this->tipoL=$tipoL;
        $this->clasfL=$clasfL;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user=$this->user;
        $tipoL=$this->tipoL;
        $clasfL=$this->clasfL;
        
        $builder
          ->add('recaudoscargados','collection', array(
            'type' => new DataRecaudosCargadosType(),
            'allow_add' => true,
            'options' => array('data_class' => 'Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados'),
            'prototype' => true,
            'by_reference' => false,
            'label' => false,    
        ))
          ->add('pago',new PagoType())
          ->add('hipodromoInter','textarea',array(
                'label'=>'Hipódromos Internacionales'
            ))
                
          ->add('centroHipico','entity', array(
                    'class' => 'CentrohipicoBundle:DataCentrohipico',
                    'query_builder' => function(EntityRepository $er) use ($user) {
                                 return $er->createQueryBuilder('ch')
                                           ->where('ch.usuario='.$user->getId());
                        },
                    'property' => 'denominacionComercial',
                    'required' => true,
                    'label' => 'Mis Centros Hípicos<span class="oblig">(*)</span>',
                    'empty_value' => 'Seleccione Centro Hípico',
                    'attr' => array(
                        'id' =>"dch",
                        'class' => 'centrohipico'
                    )))

            ->add('ClasLicencia','entity', array(
                     'class' => 'LicenciaBundle:AdmClasfLicencias',
                     'query_builder' => function(EntityRepository $er) use($tipoL) {
                                 return $er->createQueryBuilder('l')
                                           ->where('l.status=1 and l.admTiposLicencias='.$tipoL);
                        },
                    'property' => 'clasfLicencia',
                    'required' => true,
                    'label' => 'Tipo de Autorización<span class="oblig">(*)</span>',
                    'empty_value' => 'Seleccione Licencia',
                     'attr' => array(
                        'id' =>"alic",
                        'class' => 'licencia'
                    )))
//              ->add('juegosExplotados')             
            ->add('juegosExplotados','entity', array(
                    'class' => 'LicenciaBundle:AdmJuegosExplotados',
                    'query_builder' => function(EntityRepository $er) use($clasfL) {
                                      return $this->getJuegose($er,$clasfL);
                        },
                    'property' => 'juego',
                    'required' => true,
                    'label' => 'Juegos a Explotar',
                    'empty_value' => 'Seleccione uno',
                    'multiple' => true,           
                    'attr' => array(
                        'id'=>'juegoe',
                        'class' => 'juegosexplotados'
                        
                    )))                                
              // Estos Campos se Agregan directamente en el controllador
              // por la entidad                  
            //->add('cita')                    
            //->add('operadora',null, array(
            //    'label'=>'Mis Operadoras'
            //))
            // ->add('status')
            //->add('fechaSolicitud')
            //->add('aprobacionTecnica')
            //->add('aprobacionAsesorlegal')
            //->add('numProvidencia')
            //->add('fechaProvidencia')
            //->add('aprobacion')
            //->add('fechaAprobacion')
            //->add('numLicenciaAdscrita')
            //->add('usuario')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes'
        ));
    }
    private function getJuegose($er, $clasfL) {
        $where='';        
        if(!$clasfL) $where='j.id=0';
       foreach($clasfL as $val){ $where.='j.id='.$val.' or ';}
        if(strlen($where)>6) $where=substr($where,0,-4);
        //var_dump($where);
     return $er->createQueryBuilder('j')
               ->where($where);
     //var_dump($q);
     //return $q;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_solicitudescitasbundle_datasolicitudes';
    }
}
