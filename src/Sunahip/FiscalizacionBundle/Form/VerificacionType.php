<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class VerificacionType extends AbstractType
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
                        'label' => 'Funcionario que genera acta'
                    ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
         $resolver->setDefaults(array(
            'data_class' => 'Sunahip\FiscalizacionBundle\Entity\Verificacion'
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
