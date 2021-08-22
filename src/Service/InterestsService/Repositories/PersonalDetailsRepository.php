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

    public function fetchAllWithRelations()
    {
        $people = $this->fetchAll();
        $results = [];
        foreach($people as $person){
            $this->dbm->getConnection();
            $sql = "SELECT count(id) as count FROM ".$this->table;
        }
    }
}