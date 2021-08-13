<?php

namespace App\Controller;

use App\Entity\Users\User;
use App\Service\AuthService\AuthService;
use App\Service\AuthService\exceptions\UserRegistrationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;

class SecurityController extends AbstractController
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @Route("/register", name="app_register" , methods={"POST"})
     * @throws UserRegistrationException
     */
    public function register(Request $request): Response
    {
        $data = $request->toArray();

        try{
            $user = $this->authService->registerUser($data);
        } catch(\Exception $e) {
            throw $e;
        }


        if ($user instanceof ConstraintViolationList) {
            $violations = [];
            for ($i = 0; $i < $user->count(); $i++) {
                $violation = $user->get($i);
                $violations[] = [
                    'message' => $violation->getMessage(),
                    'propertyPath' => $violation->getPropertyPath()
                ];
            }
            return new Response(json_encode(['violations' => $violations]), 422);
        }

        if($user instanceof User) {
            return new Response(null, 201, [
                'Location' => $this->generateUrl('backend', ['path' => 'dashboard'])
            ]);
        }
    }

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login()
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => 'Invalid login request.'
            ], 400);
        }

        $redirectPath = ['path' => 'support-center'];

        if($this->isGranted('ROLE_SUPPORT')){
            $redirectPath = ['path' => 'dashboard'];
        }

        return new Response(null, 204, [
            'Location' => $this->generateUrl('backend', $redirectPath)
        ]);
    }

}
