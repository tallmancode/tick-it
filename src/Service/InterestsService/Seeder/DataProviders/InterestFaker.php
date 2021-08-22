<?php


namespace App\Service\InterestsService\Seeder\DataProviders;


class InterestFaker extends Base
{
    protected static array $interests = [
        ['category' => 'Exercise', 'name' => 'Cheesemaking'],
        ['category' => 'Exercise', 'name' => 'Line Dancing'],
        ['category' => 'Australian', 'name' => 'Prawns'],
        ['category' => 'Parenting', 'name' => 'Mooing'],
        ['category' => 'Wildlife', 'name' => 'Beetle Fighting'],
        ['category' => 'Parenting', 'name' => 'Metal Detecting'],
        ['category' => 'Lifestyle', 'name' => 'Collecting In-Flight Sick Bags'],
        ['category' => 'Adventure', 'name' => 'Toy voyaging'],
        ['category' => 'Lifestyle', 'name' => 'Sport'],
        ['category' => 'Wildlife', 'name' => 'Fishing'],
        ['category' => 'Lifestyle', 'name' => 'Foraging'],
        ['category' => 'Adventure', 'name' => 'Brewing Beer'],
        ['category' => 'Lifestyle', 'name' => 'Gardening'],
        ['category' => 'Wildlife', 'name' => 'Animals'],
        ['category' => 'Parenting', 'name' => 'Children'],
        ['category' => 'Software Development', 'name' => 'Turning coffee into code'],
        ['category' => 'Software Development', 'name' => 'Quidditch'],
        ['category' => 'Software Development', 'name' => 'Yoda'],
        ['category' => 'Software Development', 'name' => 'Unicorns'],
    ];

    public function all(): array
    {
        return self::$interests;
    }
}