<?php

namespace App\Controller\InterestsControllers;

use App\Service\InterestsService\DatabaseManager\DatabaseManager;
use App\Service\InterestsService\Repositories\InterestsRepository;
use App\Service\InterestsService\Repositories\PersonalDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeopleController extends AbstractController
{
    private PersonalDetailsRepository $repo;

    public function __construct(PersonalDetailsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/api/personal_details", name="complex_queries_personal_details", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $count = $this->repo->count();
        $personal_details = [];

        if($count > 0){
            $personal_details = $this->repo->fetchAll();
        }

        $response = [
            'data' => $personal_details,
            'count' => $count
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }


}
