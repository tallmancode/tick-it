<?php


namespace App\Service\InterestsService\Repositories;


use App\Service\InterestsService\DatabaseManager\DatabaseManager;
use App\Service\InterestsService\Repositories\Base\BaseRepo;

class PersonalDetailsRepository extends  BaseRepo
{
    public const TABLE = 'personal_detail';

    public function __construct(DatabaseManager $database)
    {
        parent::__construct($database);
        $this->setTable(self::TABLE);
    }

    public function fetchAll()
    {
        $conn = $this->dbm->getConnection();
        $queryBuilder = $conn->createQueryBuilder();
        $rows = $queryBuilder->select('p.id, p.first_name, p.last_name, count(distinct phi.interest_id) as interest_count, count(distinct d.id) as doc_count')
            ->from($this->table, 'p')
            ->leftJoin('p', 'person_has_interest ', 'phi', 'phi.person_id = p.id')
            ->leftJoin('p', 'document ', 'd', 'd.person_id = p.id')
            ->groupBy('p.id')
            ->execute()->fetchAll();
        return  $rows;
    }
}