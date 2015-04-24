<?php

namespace Sunahip\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
                ->add('email', 'email', array(
                    'required' => true,
                    'label' => 'Email',
                    'trim' => true,
                    'attr' => array(
                        "maxlength" => 50,
                        "onblur" => " validateEmail(this)"
                    )
                ))
                ->add('password', 'password', array(
                    'required' => true,
                    'label' => 'Contraseña',
                    'always_empty' => true,
                    'attr' => array(
                        "maxlength" => 8,
                        "onblur" => " validatePassword(this)"
                    )
                ))
                ->add('confirm', 'password', array(
                    'required' => true,
                    'mapped' => false,
                    'label' => 'Verificar contraseña',
                    'always_empty' => true,
                    'attr' => array(
                        "maxlength" => 8,
                        "onblur" => " validatePassword(this)"
                    )
                ))
                ->add('perfil', new PerfilType());
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
