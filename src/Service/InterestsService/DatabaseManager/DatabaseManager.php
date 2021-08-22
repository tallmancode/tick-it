<?php


namespace App\Service\InterestsService\DatabaseManager;


use App\Service\InterestsService\Exceptions\TablesNotFoundException;
use Psr\Container\ContainerInterface;

class DatabaseManager
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getConnection()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application. Try running "composer require symfony/orm-pack".');
        }

        $doctrine =  $this->container->get('doctrine');

        return $doctrine->getConnection();
    }

    public function runQuery($query)
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @throws TablesNotFoundException
     * Checks if the tables are present in the database
     */
    public function tablesExist(array $tables = []): bool
    {
        $dbName = $this->getConnection()->getDatabase();

        $tablesNotFound = [];

        foreach($tables as $tableName){
            $sql = 'show tables FROM '.$dbName.' like "'.$tableName.'"';
            $result = $this->runQuery($sql);
            if(empty($result)){
                $tablesNotFound[] = $tableName;
            }
        }

        if(!empty($tablesNotFound)){
            throw new TablesNotFoundException($tablesNotFound);
        }

        return true;
    }

    public function insert(string $table, array $vars)
    {
        $conn = $this->getConnection();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->insert($table)
            ->values($this->mapValues($vars))
            ->setParameters($vars)
            ->execute();

        return $conn->lastInsertId();
    }

    public function findBy(string $table, $col, $value)
    {
        $conn = $this->getConnection();
        $queryBuilder = $conn->createQueryBuilder();
        $row = $queryBuilder->select('*')
            ->from($table)
            ->where($this->toSnakecase($col).' = :'.$col)
            ->setParameter($col, $value)
            ->execute()->fetchAssociative();

        return $row;
    }

    private function mapValues($vars): array
    {
        $returnArray = [];

        foreach($vars as $key => $value){
            $returnArray[$this->toSnakecase($key)] = ':'.$key;
        }

        return $returnArray;
    }

    private function toSnakecase($input): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }


}