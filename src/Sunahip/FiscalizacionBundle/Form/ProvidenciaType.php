<?php

namespace Sunahip\FiscalizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

class ProvidenciaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $repository = $options['repository'];
        $builder
            ->add('num')
            ->add('finicio', null, array(
                'widget' => 'single_text',
                'datepicker' => true,
                'label'  => 'F. de Inicio',
            ))
            ->add('ffinal', null, array(
                'widget' => 'single_text',
                'datepicker' => true,
                'label'  => 'F. de Finalización',
            ))
           // ->add('status')
            ->add('motivo', 'choice', array(
                'choices' => array(
                    'Rutinaria'     => 'Rutinaria',
                    'Falta de Pago' => 'Falta de Pago',
                    'Denunciado'    => 'Denunciado'
                ),
                'empty_value' => 'Seleccione',
            ))

            ->add('gerente', 'entity', array(
                'empty_value' => 'Seleccione',
                'class' => 'UserBundle:SysPerfil',
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('u');
                    // the function returns a QueryBuilder object
                    return $qb
                        ->join('u.user', 'c')
                        ->where('c.roles LIKE  :role')
                        ->setParameter('role', '%ROLE_FISCAL%')
                        ->orderBy('u.nombre', 'ASC');
                },
                'property' => 'fullname'
            ))
            ->add('extra', 'integer', array(
                'mapped' => false,
                'label'  => 'Cant. de Fiscales',
                'attr'   => array(
                    'min' => 1
                ),
                'constraints' => array(
                    new Assert\Callback(function($cant, ExecutionContextInterface $context) use ($repository){
                        /*Menos el gerente*/
                        $disp = $repository->cantFisc() - 1; 
                        if($cant > $disp){
                            $context->addViolationAt(
                                'extra', 'Debe ingresar un numero menor de fiscales extras',
                                array(), null
                            );
                        }
                    }),
                    new Assert\Range(array(
                        'min'        => 1,
                    ))
                )
            ))
            ->add('estado', 'entity', array(
                'class' => 'CommonBundle:SysEstado',
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('u');
                    $a = $qb
                        /*->join('u.municipios', 'm')
                        ->leftjoin('m.centros',    'c')
                        ->leftjoin('m.operadoras', 'o')
                        ->where('m = c.municipio')
                        ->orWhere('m = o.municipio')*/
                        ->orderBy('u.nombre', 'ASC');
                        
                    return $a;
                },
                'property' => 'nombre',
                'mapped' => false,
                'empty_value' => 'Seleccione',
            ))
            ->add('municipio', 'entity', array(
                'class' => 'CommonBundle:SysMunicipio',
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('m');
                    return $qb
                        /*->leftjoin('m.centros', 'c')
                        ->leftjoin('m.operadoras', 'o')
                        ->where('m = c.municipio')
                        ->orWhere('m = o.municipio')*/
                        ->orderBy('m.nombre', 'ASC');
                },
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
                'mapped' => false
            ))


            ->add('centros', null, array(
                'property' => 'identificador',
                'required'  => false, 
            ))
            ->add('operadoras', null, array(
                'property' => 'identificador',
                'required'  => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunahip\FiscalizacionBundle\Entity\Providencia',
            'repository'     => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sunahip_fiscalizacionbundle_providencia';
    }
}
