<?php


namespace App\Service\InterestsService\Repositories;


use App\Service\InterestsService\DatabaseManager\DatabaseManager;
use App\Service\InterestsService\Repositories\Base\BaseRepo;

class InterestsRepository extends  BaseRepo
{
    public const TABLE = 'interest';

    public function __construct(DatabaseManager $database)
    {
        parent::__construct($database);
        $this->setTable(self::TABLE);
    }
}