<?php
/*
 * 
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\FiscalizacionBundle\Controller;

use Sunahip\CentrohipicoBundle\Entity\DataCentrohipico;
use Sunahip\FiscalizacionBundle\Form\DataCentrohipicoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{
    /*
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function centroAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $entity = new DataCentrohipico();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user= $this->getUser();
        $prov = $em->getRepository('FiscalizacionBundle:Providencia')->current();
        if(count($prov)==0) {
            /*No hay proviencia vigente*/
            return $this->render('FiscalizacionBundle:Fiscalizacion:noprov.html.twig');
        }
        if($form->isValid()) {
            //$entity->setRif($entity->getRifDueno());
            //$entity->setPersJuridica($entity->getPersJuridicaDueno()); 
            //Agregar valores Faltantes
            //Datos Centro Hipico
            $entity->setCiudad(strtoupper($entity->getCiudad()));
            $entity->setUsuario($user);
            $entity->setFechaRegistro(new \DateTime());
            $entity->setStatus("Pendiente");

            $em->persist($entity);
            $em->flush();            
            return $this->redirect($this->generateUrl('fiscalizacion_new',
                array('idcentro' => $entity->getId(), 'tipo'=>'centro', 'idprov'=> $prov[0]->getId() )));
        }

        return $this->render('FiscalizacionBundle:Default:centro.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            /*NO ELIMINAR SE USA EN FISCALIZACION*/
            'hidden' => isset($this->hidden)
            ));
    }

    protected function createCreateForm(DataCentrohipico $entity)
    {
        $user= $this->getUser();
        $form = $this->createForm(new DataCentrohipicoType($user->getId()), $entity, array(
            'action' => $this->generateUrl('fiscalizacion_centro'),
            'method' => 'POST',
        ));
        return $form;
    }
}
