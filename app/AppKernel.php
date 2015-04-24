<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Ob\HighchartsBundle\ObHighchartsBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Fresh\Bundle\DoctrineEnumBundle\FreshDoctrineEnumBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Sg\DatatablesBundle\SgDatatablesBundle(),
            //new Oneup\UploaderBundle\OneupUploaderBundle(),
            new Vlabs\MediaBundle\VlabsMediaBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new TFox\MpdfPortBundle\TFoxMpdfPortBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new Endroid\Bundle\QrCodeBundle\EndroidQrCodeBundle(),

            # Sunahip Bundles
            new Sunahip\UserBundle\UserBundle(),
            new Sunahip\CommonBundle\CommonBundle(),
            new Sunahip\SolicitudesCitasBundle\SolicitudesCitasBundle(),
            new Sunahip\NewTemplateBundle\NewTemplateBundle(),
            new Sunahip\FiscalizacionBundle\FiscalizacionBundle(),
            new Sunahip\LicenciaBundle\LicenciaBundle(),
            new Sunahip\CentrohipicoBundle\CentrohipicoBundle(),
            new Sunahip\PagosBundle\PagosBundle(),
            new Sunahip\ReporteBundle\ReporteBundle(),
            new Sunahip\ExportBundle\ExportBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
