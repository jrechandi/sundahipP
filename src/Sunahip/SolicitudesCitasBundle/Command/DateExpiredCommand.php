<?php

namespace Sunahip\SolicitudesCitasBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DateExpiredCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sunahip:licencias:fechavencimiento')
            ->setDescription('Verifica la fecha de vencimiento de las licencias')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        
        $date =  date("Y/m/d", strtotime("-1 day"));
        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->getListPorVencer($date);
        
        if($entities)
        {
            foreach ($entities as $entity)
            {
                $entity->setStatus('Vencida');
                $em->flush();
                
                $title = "Notificación SUNAHIP: Licencia Vencida";
                $params['nombre']= $entity->getUsuario()->getFullname();
                $params['message'] = "A través de este comunicado le informamos que su Licencia No. <b>".$entity->getNumLicenciaAdscrita()."</b>, ha vencido.<br><br>
                                      Por favor recuerde realizar oportunamente la solicitud de renovación de licencia, evite ser sancionado.";
                
                $html = $this->getContainer()->get('templating')->render('UserBundle:Notification:mail.html.twig', $params);                
                
                $message = \Swift_Message::newInstance()
                                ->setSubject($title)
                                ->setFrom($this->getContainer()->getParameter('mailer_user'))
                                ->setTo($entity->getUsuario()->getEmail())
                                ->setBody($html,'text/html');                
                
                $this->getContainer()->get('mailer')->send($message); 
            }
        }
        
        $date =  date("Y/m/d", strtotime("-5 day"));
        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->getListPorVencer($date);
        
        if($entities)
        {
            foreach ($entities as $entity)
            {
                $title = "Notificación SUNAHIP: Vencimiento y Renovación de Licencia";
                $params['nombre']= $entity->getUsuario()->getFullname();
                $params['message'] = "A través de este comunicado le informamos que su Licencia No. <b>".$entity->getNumLicenciaAdscrita()."</b>, ésta por vencer.<br><br>
                                      Por favor recuerde realizar oportunamente la solicitud de renovación de licencia, evite ser sancionado.";
                
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