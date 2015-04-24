<?php

namespace Sunahip\LicenciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AdmClasfLicenciasType extends AbstractType
{

     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clasfLicencia', 'text', array('label'=>'Licencia'))
            ->add('admTiposLicencias', 'entity', array(
                    'label' => 'Tipo de Licencia',
                    'class' => 'LicenciaBundle:AdmTiposLicencias',
                    'empty_value' => 'Seleccione',
                    'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('adm')
                                ->where('adm.status = (:pr)')
                                ->setParameter('pr', 1);
                        }
                ))
            ->add('admJuegosExplotados', null, array(
                    'required' => false,
                    'label'    => 'Juegos Explotados',
                    'multiple' => true,
                    'attr'     => array('style'=>'width:400px; height: 100px;')
                ))
            ->add('admRecaudosLicencias', null, array(
                    'label'    => 'Recaudos',
                    'multiple' => true,
                    'attr'     => array('style'=>'width:400px; height: 100px;')
                ))
            ->add('solicitudUt', 'text', array('label'=>'Valor Solicitud (UT)'))
            ->add('otorgamientoUt', 'text', array('label'=>'Valor Otorgamiento (UT)'))
            ->add('codLicencia', 'text', array('label'=>'Código Generación Licencia'))
            ->add('hasOperadora', 'choice', array(
                    'choices' => array('0' => 'No Requiere', '1' => 'Requiere'),
                    'label' => '¿Requiere Operadora?'
                ))
            ->add('hasHipodromo', 'choice', array(
                    'choices' => array('0' => 'No Requiere', '1' => 'Requiere'),
                    'label' => '¿Requiere Hipódromo?'
                ))
            ->add('status', 'choice', array(
                    'choices' => array('1' => 'Activo', '0' => 'Inactivo'),
                    'label'   => 'Estatus'
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\LicenciaBundle\Entity\AdmClasfLicencias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_licenciabundle_admclasflicencias';
    }
}
