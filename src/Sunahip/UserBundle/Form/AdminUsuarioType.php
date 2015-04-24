<?php

namespace Sunahip\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminUsuarioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
                ->add('email', 'email', array(
                    'required' => true,
                    'label' => 'Email',
                    'trim' => true
                ))
                ->add('password', 'password', array(
                    'required' => true,
                    'label' => 'Contraseña',
                    'always_empty' => true
                ))
                ->add('confirm', 'password', array(
                    'required' => true,
                    'mapped' => false,
                    'label' => 'Verificar contraseña',
                    'always_empty' => true
                ))
                ->add('enabled', 'checkbox', array(
                    'required' => false,
                    'label' => 'Activo?',
                    'data' => true
                ))
                ->add('perfil', new AdminPerfilType());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
                array(
                    'data_class' => 'Sunahip\UserBundle\Entity\SysUsuario',
                    'intention' => 'new_user'
                )
        );
    }

    public function getName()
    {
        return 'user_register';
    }

}
