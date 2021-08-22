<?php


namespace App\Service\InterestsService\Repositories\Base;

use App\Service\InterestsService\DatabaseManager\DatabaseManager;

class BaseRepo
{
    protected DatabaseManager $dbm;

    protected $table;

    public function __construct(DatabaseManager $database)
    {
        $this->dbm = $database;
    }

    protected function setTable(String $name)
    {
        $this->table = $name;
    }

    public function count()
    {
        $conn = $this->dbm->getConnection();
        $sql = "SELECT count(id) as count FROM ".$this->table;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetch();
        return (int)$result['count'];
    }

    public function fetchAll()
    {
        $conn = $this->dbm->getConnection();
        $queryBuilder = $conn->createQueryBuilder();
        $rows = $queryBuilder->select('*')
            ->from($this->table)
            ->execute()->fetchAll();
        return  $rows;
    }
}