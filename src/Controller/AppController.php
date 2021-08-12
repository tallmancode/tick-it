<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function frontend(): Response
    {
        //redirect user to backend if authenticated
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('backend', ['path' => 'dashboard']));
        }

        //render frontend template
        return $this->render('frontend/frontendBase.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    public function backend() : Response
    {
        //redirect user to backend if not authenticated
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('frontend-base'));
        }

        //render backend template
        return $this->render('backend/backendBase.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
}
