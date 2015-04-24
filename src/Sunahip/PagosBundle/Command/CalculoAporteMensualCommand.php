<?php

namespace Sunahip\PagosBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CalculoAporteMensualCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sunahip:pagos:calculo')
            ->setDescription('Realiza el calculo de aporte mensual')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $ut = intval($this->getContainer()->getParameter('unidad_tributaria'));
        
        //Operadoras
        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array('status' => 'Aprobada', 'tipoSolicitud' => 'operadora'));
        foreach ($entities as $entity) {
            $operadora = $entity->getOperadora();
            if($operadora) {
                $monto = 0;
                $operdoraEstablecimiento = $em->getRepository('CentrohipicoBundle:DataOperadoraEstablecimiento')->findByOperadora($operadora);                
                foreach($operdoraEstablecimiento as $item) {
                    $centroHipico = $item->getCentroHipico();
                    $licencia = $item->getClasLicencia();
                    $aporte = $em->getRepository('LicenciaBundle:AdmTipoAporte')->findOneBy(array('admClasfLicencias'=>$licencia->getId()));
                    $solicitud = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findOneBy(array('centroHipico'=>$centroHipico, 'ClasLicencia'=>$licencia));
                    if($aporte && $solicitud) {
                        if($aporte->getPorJuego()==1) {
                            $juegos = $solicitud->getJuegosExplotados();
                            $monto += count($juegos) * ($aporte->getMontoAporte() * $ut);
                        } else {
                            $monto += ($aporte->getMontoAporte() * $ut);
                        }
                    }
                }
                //Creación del pago
                $pagos = new \Sunahip\PagosBundle\Entity\Pagos();
                $pagos->setOperadora($operadora);
                $pagos->setSolicitud($entity);
                $pagos->setTipoPago(\Sunahip\CommonBundle\DBAL\Types\PaymentType::APORTE_MENSUAL);
                $pagos->setMonto($monto);
                $pagos->setFechaCreacion(new \DateTime());
                $pagos->setStatus("CREADA");
                $em->persist($pagos);
                $em->flush();

                //Mail                    
                $title = "Notificación SUNAHIP: Aporte Mensual Licencia ".$entity->getNumLicenciaAdscrita();
                $params['nombre']= $entity->getUsuario()->getFullname();
                $params['message'] = "El aporte mensual de su licencia No <b>". $entity->getNumLicenciaAdscrita() ."</b> es: $monto Bs.";

                $html = $this->getContainer()->get('templating')->render('UserBundle:Notification:mail.html.twig', $params);                

                $message = \Swift_Message::newInstance()
                                ->setSubject($title)
                                ->setFrom($this->getContainer()->getParameter('mailer_user'))
                                ->setTo($entity->getUsuario()->getEmail())
                                ->setBody($html,'text/html');

                $this->getContainer()->get('mailer')->send($message);
            }
        }
        //Centros Hípicos
        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findAllCentroHipico();
        foreach ($entities as $entity) {
            $centroHipico = $entity->getCentroHipico();
            if($centroHipico) {
                $monto = 0;
                $licencia = $entity->getClasLicencia();
                $aporte = $em->getRepository('LicenciaBundle:AdmTipoAporte')->findOneBy(array('admClasfLicencias'=>$licencia->getId()));
                if($aporte) {
                    if($aporte->getPorJuego()==1) {
                        $juegos = $entity->getJuegosExplotados();
                        $monto += count($juegos) * ($aporte->getMontoAporte() * $ut);
                    } else {
                        $monto += ($aporte->getMontoAporte() * $ut);
                    }
                }
                //Creación del pago
                $pagos = new \Sunahip\PagosBundle\Entity\Pagos();
                $pagos->setCentroHipico($centroHipico);
                $pagos->setSolicitud($entity);
                $pagos->setTipoPago(\Sunahip\CommonBundle\DBAL\Types\PaymentType::APORTE_MENSUAL);
                $pagos->setMonto($monto);
                $pagos->setFechaCreacion(new \DateTime());
                $pagos->setStatus("CREADA");
                $em->persist($pagos);
                $em->flush();

                //Mail                    
                $title = "Notificación SUNAHIP: Aporte Mensual Licencia ".$entity->getNumLicenciaAdscrita();
                $params['nombre']= $entity->getUsuario()->getFullname();
                $params['message'] = "El aporte mensual de su licencia No <b>". $entity->getNumLicenciaAdscrita() ."</b> es: $monto Bs.";

                $html = $this->getContainer()->get('templating')->render('UserBundle:Notification:mail.html.twig', $params);                

                $message = \Swift_Message::newInstance()
                                ->setSubject($title)
                                ->setFrom($this->getContainer()->getParameter('mailer_user'))
                                ->setTo($entity->getUsuario()->getEmail())
                                ->setBody($html,'text/html');

                $this->getContainer()->get('mailer')->send($message);
            }
        }
    }
}