<?php

namespace App\Controller\ComplexQueries;

use App\Service\InterestsService\DatabaseManager\DatabaseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QueriesController extends AbstractController
{
    private DatabaseManager $dbm;

    private $conn;

    public function __construct(DatabaseManager $dbm)
    {
        $this->dbm = $dbm;
        $this->conn = $this->dbm->getConnection();
    }
    /**
     * @Route("/queries/youre_a_animal", name="queries_get_animal_lovers", methods={"GET"})
     */
    public function GetAnimalLovers(): JsonResponse
    {

        $query = "select p.id, p.first_name, p.last_name from document d 
left join interest i on i.id = d.interest_id 
left join personal_detail p on p.id = d.person_id
where i.name = 'Animals'
group by p.id
having count(distinct d.id) = 1
order by p.id";

        $results = $this->dbm->runQuery($query);

        $response = [
            'data' => $results,
            'query' => $query
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @Route("/queries/children_and_sports", name="queries_children_and_sports", methods={"GET"})
     */
    public function GetChildrenAndSports(): JsonResponse
    {

        $query = "select p.id, p.first_name, p.last_name from personal_detail p
left join person_has_interest phi ON phi.person_id = p.id 
inner join interest i ON i.id = phi.interest_id
where i.name = 'Sport' or i.name = 'Children'
group by p.id
order by p.id";

        $results = $this->dbm->runQuery($query);

        $response = [
            'data' => $results,
            'query' => $query
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @Route("/queries/unique_interest", name="unique_interest", methods={"GET"})
     */
    public function GetUniqueInterest(): JsonResponse
    {

        $query = "SELECT 
    (SELECT 
            COUNT(*)
        FROM
            (SELECT 
                phi.person_id
            FROM
                tick_it.person_has_interest phi
            LEFT JOIN tick_it.document d ON d.person_id = phi.person_id
            GROUP BY phi.person_id
            HAVING COUNT(DISTINCT d.id) = 0) AS subquery) AS no_docs_count,
    GROUP_CONCAT(DISTINCT i.name
        SEPARATOR ', ') AS unique_interests
FROM
    interest i
        LEFT JOIN
    person_has_interest phi ON phi.interest_id = i.id
WHERE
    phi.interest_id IN (SELECT 
            *
        FROM
            (SELECT 
                i.id
            FROM
                tick_it.interest i
            LEFT JOIN person_has_interest phi ON phi.interest_id = i.id
            GROUP BY i.id
            HAVING COUNT(phi.id) = 1) AS subquery)
";

        $results = $this->dbm->runQuery($query);

        $response = [
            'data' => $results,
            'query' => $query
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }


    /**
     * @Route("/queries/fivers_and_sixers", name="queries_fivers_and_sixers", methods={"GET"})
     */
    public function GetFiversAndSixers(): JsonResponse
    {

        $query = "SELECT p.id, p.first_name, p.last_name
FROM personal_detail p
left join person_has_interest phi on phi.person_id = p.id
WHERE phi.person_id  IN
(
    SELECT * FROM
    (
        SELECT d.person_id
        FROM document d
		where d.person_id = 3
        GROUP BY d.interest_id, d.person_id
        HAVING COUNT(distinct d.id) > 1
    ) AS subquery
)
group by phi.person_id
having count(distinct phi.id) >= 5 and count(distinct phi.id) <= 6";

        $results = $this->dbm->runQuery($query);

        $response = [
            'data' => $results,
            'query' => $query
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }

}
