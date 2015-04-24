<?php

namespace Sunahip\SolicitudesCitasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataRecaudosCargadosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaVencimiento',null,array(
                'label'=>'Fecha de Vencimiento',
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'dd-MM-yyyy', // Presenta la Fecha por el formato del navegador
                'attr'=>array('placeholder' => 'dd/mm/aaaa'), 
                ))
            ->add('mediarecaudo', 'vlabs_file',
                array(
                    "mapped" => true,
                    'label' => false,
                    'required' => true,
                ))
            ->add('reciboN')    
            ->add('status','hidden',array(
                'data'=>"Cargado"
            ))
            ->add('tipodoc','hidden')
            //->add('status')
            //->add('recaudoLicencia',"hidden")    
            //->add('solicitud')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_solicitudescitasbundle_datarecaudoscargados';
    }
}
