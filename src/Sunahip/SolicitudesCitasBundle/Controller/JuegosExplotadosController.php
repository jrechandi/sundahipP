<?php
/**
 * Description of JuegosExplotadosController
 *
 * class JuegosExplotadosController
 * @author 'Ing Carlos A Salzar <csalazart33@gmail.com>'
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\SolicitudesCitasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 *  JuegosExplotadosController
 */
class JuegosExplotadosController extends Controller
{
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function showAction($ids) 
     {
        $em = $this->getDoctrine()->getManager();
        $DS= $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($ids);
        // Agregando el Recibo de pago de Procesamiento        
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_juegos_ed.html.twig', array(
                  'juegosE' =>$DS->getJuegosExplotados(),
                  ));
    }
  
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
  public function createAction(Request $request, $ids) 
  {
         $params=$request->request->all();
         $query=$request->query->all();
         $em = $this->getDoctrine()->getManager();
         $DS= $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($ids);
         //Elimina los Juegos y luego los Agrega
         $this->removeJuegosE($DS, $em);
         // Agrega los juegos Nuevos
         $juegos=explode(",", $params['juegose']);
         foreach ($juegos as $juego){             
             $DS->addJuegosExplotado($em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($juego));      
           }
          $em->persist($DS);
          $em->flush();
          return $this->redirect($this->generateUrl('juegosexplotados_show',array('ids'=>$DS->getId())));
   }
   
   private function removeJuegosE($DS, $em)
   {
       foreach($DS->getJuegosExplotados() as $key=>$juegoe ) {
           $DS->removeJuegosExplotado($juegoe);
           //$juegoe->setSolicitud(null);
           //$em->remove($juegoe);
           $em->flush();
       }
       //$em->persist($DS);
       $em->flush();
   }
   
   private function setSolicitudNull($juegoId)
   {   $em= $this->getDoctrine()->getManager();
       $repo=$em->getRepository("SolicitudesCitasBundle:DataSolicitudes");
       $repo->createQueryBuilder('je');
       
      // $sql="Update "
       //$conn->exec($sql);
   }

}

