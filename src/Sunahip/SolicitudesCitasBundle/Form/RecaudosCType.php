<?php

namespace Sunahip\SolicitudesCitasBundle\Form;

use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\ArrayToPartsTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RecaudosCType extends AbstractType
{
   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('recaudoscargados','collection', array(
            'type' => new DataRecaudosCargadosType(),
            'allow_add' => true,
            'options' => array('data_class' => 'Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados'),
            'prototype' => true,
            'by_reference' => false,
            'label' => false,    
        ))
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
        return 'solicitudescitas_recaudosC';
    }
}
