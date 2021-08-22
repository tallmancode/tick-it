<?php

namespace App\Controller\FileManipulation;

use App\Service\ManipulatorService\Manipulator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FileManipulationController extends AbstractController
{

    private Manipulator $manipulator;

    public function __construct(Manipulator $manipulator)
    {
        $this->manipulator = $manipulator;
    }

    /**
     * @Route("/file/manipulation/file/manipulation", name="file_manipulation_file_manipulation", methods={"POST"})
     */
    public function upload(Request $request)
    {

        $uploadedFile = $request->files->get('file');
        $this->manipulator->setOrder($request->get('ordering'));
        $this->manipulator->setLocation($this->getParameter('manipulation_directory'));

        try{
            return $this->manipulator->processFile($uploadedFile);
        }catch(\Exception $e){
            return new JsonResponse([$e->getMessage()], 500);
        }


    }
}
