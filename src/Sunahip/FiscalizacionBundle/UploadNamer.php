<?php

namespace Sunahip\FiscalizacionBundle;

use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\HttpFoundation\Request;

class UploadNamer implements NamerInterface
{
    public function name(FileInterface $file)
    {   
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        return sprintf('%s_%s.%s',$id , uniqid(), $file->getExtension());
    }
}
