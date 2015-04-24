<?php

namespace Sunahip\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vlabs\MediaBundle\Entity\BaseFile as VlabsFile;

/**
 * SysCiudad
 *
 * @ORM\Entity
 * @ORM\Table(name="media" )
 */
class Media extends VlabsFile
{
    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    protected $path;

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return $this->getPath();
    }

}
