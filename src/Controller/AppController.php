<?php

namespace App\Controller;

use App\Entity\Tickets\Ticket;
use App\Repository\Tickets\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function frontend(): Response
    {
        //redirect user to backend if authenticated
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {

            $redirectPath = ['path' => 'support-center'];

            if($this->isGranted('ROLE_SUPPORT')){
                $redirectPath = ['path' => 'dashboard'];
            }

            return $this->redirect($this->generateUrl('backend', $redirectPath));
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
            'user' => $this->getUser()
        ]);
    }

    public function checkStatus($token){
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['token' => $token]);
        dump($ticket);
        return $this->render('tickets/status.html.twig', [
            'controller_name' => 'AppController',
            'ticket' => $ticket
        ]);
    }
}
