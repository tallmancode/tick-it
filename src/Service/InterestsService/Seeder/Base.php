<?php


namespace App\Service\InterestsService\Seeder;


use App\Service\InterestsService\DatabaseManager\DatabaseManager;

class Base
{
    protected DatabaseManager $dbm;

    protected $conn;

    public function __construct(DatabaseManager $database)
    {
        $this->dbm = $database;
        $this->conn = $this->dbm->getConnection();
    }

    public function findOrCreate(string $table, $identifier, array $data)
    {
        $check = $this->dbm->findBy($table, $identifier, $data[$identifier]);

        if(!$check) {
            $id = $this->dbm->insert($table, $data);

            $check =  $this->dbm->findBy($table, 'id', $id);
        }

        return $check;
    }

    public function createOne(string $table,array $data)
    {
        $id = $this->dbm->insert($table, $data);

        return $this->dbm->findBy($table, 'id', $id);
    }

    public static function feelingLucky($chanceTrue = 50)
    {
        return random_int(1, 100) <= $chanceTrue;
    }

}