<?php

namespace Sunahip\SolicitudesCitasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdmFechasCitasType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',null,array(
                'label'=>'Fecha',
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'dd-MM-yyyy',
                'attr'=>array('type'=>'date')
              ))
            ->add('description',null,array('label'=>'Descripción'))
            ->add('allways',null,array('label'=>'Siempre'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\SolicitudesCitasBundle\Entity\AdmFechasCitas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_solicitudescitasbundle_admfechascitas';
    }
}
