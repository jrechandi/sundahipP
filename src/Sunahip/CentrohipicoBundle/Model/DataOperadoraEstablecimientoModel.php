<?php
namespace Sunahip\CentrohipicoBundle\Model;

use Brown298\DataTablesBundle\Model\DataTable\AbstractQueryBuilderDataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Symfony\Component\HttpFoundation\Request;

class DataOperadoraEstablecimientoModel extends AbstractQueryBuilderDataTable implements QueryBuilderDataTableInterface
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em       = $em;
    }

    /**
     * @var array
     */
    protected $columns = array(
        'doe.id'   => 'Id',
        'dc.denominacionComercial' => 'Name',
    );

    /**
     * getDataFormatter
     *
     * @return \Closure
     */
    public function getDataFormatter()
    {
        $renderer = $this->container->get('templating');
        return function($data) use ($renderer) {
            $count   = 0;
            $results = array();

            foreach ($data as $row) {
                $results[$count][] = $row['id'];
                $results[$count][] = $row['denominacionComercial'];
                $count += 1;
            }

            echo "<pre>";
            print_r($results);
            echo "</pre>";
            die();

            return $results;
        };
    }

    /**
     * getQueryBuilder
     *
     * @param Request $request
     *
     * @return null
     */
    public function getQueryBuilder(Request $request = null)
    {
        $dataRepository = $this->em->getRepository('Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento');
        $qb = $dataRepository->createQueryBuilder('doe','dc')
            ->InnerJoin("SunahipBundle:DataCentrohipico", "dc", "WITH", "dc.id = doe.centroHipico");

        echo "<pre>";
        print_r($qb->getDQL());
        echo "</pre>";
        die();

        return $qb;
    }
}


