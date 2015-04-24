<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class EquipoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('num', 'text',  array(
                'widget_form_group' => false,
                'label' => 'Número',
                'required' => true,
                'attr' => array(
                        'placeholder' => "Nº",
                        'class' => "input-medium"
                    )
                )
            )
            ->add('descr', 'choice', array(
                //'horizontal' => false,
                'widget_form_group' => false,
                'label' => 'Descripción',
                'choices' => array(     'TV' => 'TV',
                        'MONITOR' => 'MONITOR',
                        'CPU' => 'CPU',
                        'TECLADO' => 'TECLADO',
                        'MOUSE' => 'MOUSE',
                        'TIQUERAS' => 'TIQUERAS',
                        'DECODIFICADORES' => 'DECODIFICADORES',
                        'EQUIPOS DE SONIDO' => 'EQUIPOS DE SONIDO',
                        'PLANTAS ELECTRICAS' => 'PLANTAS ELECTRICAS',
                        'AMPLIFICADOR' => 'AMPLIFICADOR',
                        'IMPRESORA' => 'IMPRESORA',
                        'ANTENAS DE TRANSMISION SATELITAL ' => 'ANTENAS DE TRANSMISION SATELITAL ',
                        'OTROS'   => 'OTROS'
                    )
                )
            )
            ->add('cant', 'integer', array(
                'label' => 'Cant.',
                'widget_form_group' => false,
                'attr' => array(
                        'placeholder' => "Cant",
                        'class' => "input-medium",
                        'min'   => 1
                    )
                )
            )
            ->add('serial', 'text',  array(
                'label' => 'Serial',
                'widget_form_group' => false,
                'attr' => array(
                        'placeholder' => 'Serial',
                    )
                )
            )
            ->add('observacion', 'text',  array(
                'label' => 'Observación',
                'widget_form_group' => false,
                'attr' => array(
                        'placeholder' => 'Observación',
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
            'render_fieldset' => false,
            //'label_render' => false,
            'show_legend' => false,
            'data_class' => 'Sunahip\FiscalizacionBundle\Entity\Equipo'
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
