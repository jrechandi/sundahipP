<?php
namespace Sunahip\FiscalizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;



/**
 * Documento
 *
 * @ORM\Table(name="data_documento")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Documento{
     /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

     /**
     * @var string
     * @Assert\NotBlank(message="Falta seleccionar el archivo")
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

     /**
     * @ORM\ManyToOne(targetEntity="Fiscalizacion", inversedBy="documentos")
     * @ORM\JoinColumn(name="fiscalizacion_id", referencedColumnName="id")
     */
    private $fiscalizacion;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $archivo;
  
    private $temp;

    /**
     * Retorna la ruta de upload
     * @return string
     */
    protected function getUploadDir()
    {
        return 'media/doc';
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return str_replace('src/', '',
            str_replace(str_replace('\\', DIRECTORY_SEPARATOR, __NAMESPACE__), '', __DIR__)).
            '/web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setArchivo(UploadedFile $file = null)
    {
        $this->archivo = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
     
    public function getArchivo()
    {
        return $this->archivo;
    }



    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getArchivo()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getArchivo()->guessExtension();
        }

        $this->upload();
    }

    public function upload()
    {
        if (null === $this->getArchivo()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getArchivo()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->archivo = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }





    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Documento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Documento
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set fiscalizacion
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Fiscalizacion $fiscalizacion
     * @return Documento
     */
    public function setFiscalizacion(\Sunahip\FiscalizacionBundle\Entity\Fiscalizacion $fiscalizacion = null)
    {
        $this->fiscalizacion = $fiscalizacion;

        return $this;
    }

    /**
     * Get fiscalizacion
     *
     * @return \Sunahip\FiscalizacionBundle\Entity\Fiscalizacion 
     */
    public function getFiscalizacion()
    {
        return $this->fiscalizacion;
    }
}
