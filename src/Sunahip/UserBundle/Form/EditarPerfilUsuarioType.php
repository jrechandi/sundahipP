<?php

namespace Sunahip\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Sunahip\CommonBundle\DBAL\Types\RoleType;

class EditarPerfilUsuarioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('persJuridica', 'text', array(
                    'required' => true,
                    'label' => 'RIF',
                    'trim' => true,
                    'attr' => array(
                        'class' => 'persJuridica'
                    )
                ))
            ->add('roleType', 'choice', array(
                    'choices' => RoleType::getChoices(),
                    'required' => true,
                    'label' => "Registrarme como",
                    'trim' => true,
                    'empty_value' => 'Seleccione',
                ))
            ->add('rif', 'text', array(
                    'required' => true,
                    'label' => false,
                    'trim' => true,
                    'attr' => array(
                        'class' => "numeric"
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
                'intention' => 'edit_user_profile'
            )
        );
    }

    public function getName()
    {
        return 'user_profile_edit';
    }

}
