<?php

namespace App\Controller\ComplexQueries;

use App\Service\InterestsService\Repositories\InterestsRepository;
use App\Service\InterestsService\Seeder\Seeder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterestsController extends AbstractController
{
    private Seeder $seeder;

    private InterestsRepository $repo;

    public function __construct(InterestsRepository $repo, Seeder $seeder)
    {
        $this->repo = $repo;
        $this->seeder = $seeder;
    }

    /**
     * @Route("/api/interests", name="complex_queries_interests", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $count = $this->repo->count();
        $interests = [];

        if($count > 0){
            $interests = $this->repo->fetchAll();
        }

        $response = [
            'data' => $interests,
            'count' => $count
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @Route("/api/interests/seed", name="complex_queries_seed", methods={"POST"})
     */
    public function seedData(): JsonResponse
    {
        try{
            $response = $this->seeder->seedData();
            return new JsonResponse($response, 200);
        }catch(\Exception $e){
            dump($e);
            return new JsonResponse(['tables' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/interests/clear_seed", name="complex_queries_clear_seed", methods={"POST"})
     */
    public function clearSeedData(): JsonResponse
    {
        try{
            $response = $this->seeder->clearData();
            return new JsonResponse($response, 200);
        }catch(\Exception $e){
            dump($e);
            return new JsonResponse(['tables' => $e->getMessage()], $e->getCode());
        }
    }
}
