<?php
namespace Sunahip\FiscalizacionBundle\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
/**
 * @Annotation
 */
class ProvidenciaFecha extends Constraint
{
    public $message = 'La fecha de inicio y finalización de la providencia  debe ser la actual o superior  a la actual';

    protected $inicio; 

    public function validatedBy(){
        return 'my_validador';
    }

    public function __construct($options){
        $this->inicio =  isset($options['inicio']) && $options['inicio'];
    }

    public function getInicio(){
        return $this->inicio;
    }
}