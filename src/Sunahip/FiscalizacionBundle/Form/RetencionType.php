<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RetencionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('funcionario', 'entity', 
                array(  'class' => 'UserBundle:SysPerfil',
                        'query_builder' => function(EntityRepository $er) { 
                            return $er->createQueryBuilder('p')->where('p.roleType=:role')->setParameter("role","ROLE_FISCAL");                            
                        },
                        'label' => 'Funcionario que genera el acta'
                    ))
            ->add('equipos', 'collection', array(
                'type'   => new EquipoType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'options' => array( // options for collection fields
                       'label_render' => false,
                       'horizontal_input_wrapper_class' => "col-lg-3",                 
                    )
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\FiscalizacionBundle\Entity\Retencion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_fiscalizacionbundle_verifiacion';
    }
}
