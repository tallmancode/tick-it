<?php


namespace App\Service\InterestsService\Seeder;


use App\Service\InterestsService\DatabaseManager\DatabaseManager;
use App\Service\InterestsService\Exceptions\TablesNotFoundException;
use App\Service\InterestsService\Seeder\DataProviders\InterestFaker;
use App\Service\InterestsService\Seeder\DataProviders\PersonFaker;
use Symfony\Component\Routing\Route;

class Seeder extends Base
{
    //Tables required for seeding
    private const TABLES = [
        'interest', 'document', 'personal_detail', 'interest_category', 'person_has_interest'
    ];

    private $interests = [];

    private $interestCategories = [];

    private InterestFaker $interestFaker;

    public function __construct(DatabaseManager $database)
    {
        parent::__construct($database);

        $this->interestFaker = new InterestFaker();
    }

    /**
     * @throws TablesNotFoundException
     */
    public function seedData()
    {
        if ($this->dbm->tablesExist(self::TABLES)) {
            $this->setup();
            $people = $this->createPeopleDetails(random_int(50, 100));
            $this->specialSeeds();
            return $people;
        }
    }

    public function clearData()
    {
        $conn = $this->dbm->getConnection();
        $platform = $conn->getDatabasePlatform();
        $conn->query('SET FOREIGN_KEY_CHECKS=0');
        foreach (self::TABLES as $table) {
            $sql = $platform->getTruncateTableSql($table);
            $conn->executeUpdate($sql);
        }
        $conn->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

        return true;
    }

    private function setup()
    {
        foreach ($this->interestFaker->all() as $interest) {

            $category = $this->findOrCreate('interest_category', 'name', ['name' => $interest['category']]);

            $this->interestCategories = $category;

            $interest = $this->findOrCreate('interest',
                'name',
                [
                    'interestCategoryId' => $category['id'],
                    'name' => $interest['name']
                ]);

            $this->interests[] = $interest;
        }
    }

    private function createPeopleDetails($count = 1)
    {
        $faker = new PersonFaker();
        $returnArray = [];

        while (count($returnArray) < $count) {
            $person = $this->createOne('personal_detail',
                [
                    'firstName' => $faker->firstName(),
                    'lastName' => $faker->lastName()
                ]);

            $personsInterests = $this->addInterest($person);
            $this->docCheck($person, $personsInterests);

            $returnArray[] = $person;
        }

        return $returnArray;
    }

    private function addInterest($person)
    {
        $count = random_int(3, 12);
        $i = 0;
        $personsInterests = $this->interestFaker::randomElements($this->interests, $count);
        $returnArray = [];

        foreach ($personsInterests as $interest) {

            $personHasInterestId = $this->dbm->insert('person_has_interest',
                [
                    'interestId' => $interest['id'],
                    'personId' => $person['id']
                ]);

            $returnArray[] = $interest;
        }


        return $returnArray;
    }

    private function docCheck($person, $interests)
    {
        if (!$this->hasValue('name', ['Sport', 'Fishing'], $interests)) {
            $multi = false;
            if ($this->hasValue('name', ['Gardening;', 'Animals', 'Children;'], $interests)) {
                $multi = true;
            }

            foreach ($interests as $interest) {
                if (self::feelingLucky(60)) {
                    $numberOfDocs = $multi ? random_int(1, 3) : 1;
                    $this->addDocs($numberOfDocs, $interest, $person);
                }
            }
        }
    }

    private function addDocs($count, $interest, $person)
    {
        $fileExtentions = [
            '.pdf',
            '.txt',
            '.docx',
        ];
        $i = 0;
        while ($count > $i) {
            $uuid = uniqid(strtolower(str_replace(' ', '_', $interest['name'])), false);
            $filePath = 'documents/' . strtolower($person['first_name']) . '_' . strtolower(str_replace(' ', '_', $person['last_name'])) . '/' . $uuid . $fileExtentions[random_int(0, 2)];
            $this->createOne('document', [
                'name' => $uuid,
                'filePath' => $filePath,
                'interestId' => $interest['id'],
                'personId' => $person['id']
            ]);
            $i++;
        }
    }

    private function hasValue($key, $value, $interests)
    {
        $hasValue = false;

        if (is_array($value)) {
            foreach ($interests as $interest) {
                if (in_array($interest[$key], $value)) {
                    $hasValue = true;
                }
            }
        } else {
            foreach ($interests as $interest) {
                if ($interest[$key] === $value) {
                    $hasValue = true;
                }
            }
        }
        return $hasValue;
    }

    //create do so the queries don't return blank result sets
    private function specialSeeds()
    {
        $uniqueIntrest = [
            ['category' => 'Exercise', 'name' => 'Unicorn Hugging'],
            ['category' => 'Software Development', 'name' => 'Not Sleeping']
        ];

        $conn = $this->dbm->getConnection();
        $queryBuilder = $conn->createQueryBuilder();
        $rows = $queryBuilder->select('*')
            ->from('personal_detail', 'p')
            ->execute()->fetchAll();

        $newInt = [];

        foreach ($uniqueIntrest as $int) {
            $category = $this->findOrCreate('interest_category', 'name', ['name' => $int['category']]);

            $interest = $this->findOrCreate('interest',
                'name',
                [
                    'interestCategoryId' => $category['id'],
                    'name' => $int['name']
                ]);

            $newInt[] = $interest;
        }

        $this->dbm->insert('person_has_interest',
            [
                'interestId' => $newInt[0]['id'],
                'personId' => $rows[3]['id']
            ]);

        $this->dbm->insert('person_has_interest',
            [
                'interestId' => $newInt[1]['id'],
                'personId' => $rows[7]['id']
            ]);

        $results = $this->dbm->runQuery(" SELECT p.id, p.first_name, p.last_name
FROM personal_detail p
left join person_has_interest phi on phi.person_id = p.id
group by p.id
having count(distinct phi.id) >= 5 and count(distinct phi.id) <= 6");

        $i = 0;
        foreach($results as $result){
            dump($result);
            if($i < 2){
                $interests = $this->dbm->runQuery(" SELECT i.id, i.name, i.interest_category_id FROM tick_it.interest i
left join tick_it.person_has_interest phi on phi.interest_id = i.id
where phi.person_id = 6;");
            }

            $this->addDocs(2, $interests[0], $result);
            $i++;
        }





    }
}