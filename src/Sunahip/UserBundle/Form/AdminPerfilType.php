<?php

namespace Sunahip\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Sunahip\CommonBundle\DBAL\Types\AdminRoleType;

class AdminPerfilType extends AbstractType
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
                    'attr' => array(
                        'class' => 'persJuridica'
                    )
                ))
                ->add('roleType', 'choice', array(
                    'choices' => AdminRoleType::getChoices(),
                    'required' => true,
                    'label' => "Tipo de Usuario",
                    'trim' => true
                ))
                ->add('rif', 'text', array(
                    'required' => true,
                    'label' => false,
                    'trim' => true,
                    'attr' => array(
                        'class' => "numeric",
                        'maxlength' => 15
                    )
                ))
                ->add('ci', 'text', array(
                    'label' => 'CI',
                    'trim' => true,
                    'attr' => array(
                        'class' => "numeric ci",
                        'disabled' => 'disabled'
                    )
                ))
                ->add('nombre', 'text', array(
                    'required' => true,
                    'label' => 'Nombre',
                    'trim' => true
                ))
                ->add('apellido', 'text', array(
                    'required' => true,
                    'label' => 'Apellidos',
                    'trim' => true
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
