<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function frontend(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            //return $this->redirect($this->generateUrl('backend-base'));
        }

        return $this->render('frontend/frontendBase.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
}
