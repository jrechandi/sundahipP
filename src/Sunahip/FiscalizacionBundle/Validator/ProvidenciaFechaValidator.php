<?php
namespace Sunahip\FiscalizacionBundle\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
class ProvidenciaFechaValidator extends ConstraintValidator
{

    protected $doctrine;

    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
    }

    public function validate($value, Constraint $constraint) {
        $em = $this->doctrine->getManager();
        $prov = $em->getRepository('FiscalizacionBundle:Providencia')->validProvidenciaByFecha($value->format("Y-m-d"));
        if(count($prov)>0){
           $this->context->addViolationAt(
                'foo',
                'Existe una providencia creada entre las fechas especificadas',
                array(),
                null
            );
        }
    }
}