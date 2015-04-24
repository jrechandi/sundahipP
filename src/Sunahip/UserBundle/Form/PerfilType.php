<?php

namespace Sunahip\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Sunahip\CommonBundle\DBAL\Types\RoleType;

class PerfilType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
                ->add('persJuridica', 'choice', array(
                    'choices' => RifType::getChoices(),
                    'required' => true,
                    'label' => 'RIF',
                    'trim' => true,
                    'empty_value' => '',
                    'attr' => array(
                        'class' => 'persJuridica'
                    )
                ))
                ->add('roleType', 'choice', array(
                    'choices' => RoleType::getFrontChoices(),
                    'required' => true,
                    'label' => "Registrarme como",
                    'trim' => true,
                    'empty_value' => 'Seleccione',
                ))
                ->add('rif', 'text', array(
                    'required' => true,
                    'label' => false,
                    'trim' => true,
                    'attr' => array("maxlength" => 9,
                        'class' => "numeric",
                        "onblur" => " validateRif(this)"
                    )
                ))
                               
                ->add('ci', 'text', array(
                    'label' => 'CI',
                    'trim' => true,
                    'attr' => array(
                        'class' => "numeric ci",
                        'disabled' => 'disabled',
                        "maxlength" => 9,
                        "onblur" => " validateCi(this)"
                    )
                ))
                ->add('nombre', 'text', array(
                    'required' => true,
                    'label' => 'Nombre',
                    'trim' => true,
                    'attr' => array(
                        "maxlength" => 30,
                        "onblur" => " validateNombre(this)"
                    )
                ))
                ->add('apellido', 'text', array(
                    'required' => true,
                    'label' => 'Apellidos',
                    'trim' => true,
                    'attr' => array(
                        "maxlength" => 30,
                        "onblur" => " validateApellido(this)"
                    )
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
                array(
                    'data_class' => 'Sunahip\UserBundle\Entity\SysPerfil',
                    'intention' => 'new_user_profile'
                )
        );
    }

    public function getName()
    {
        return 'user_profile';
    }

}
