<?php

namespace App\DataFixtures\Tickets;

use App\Entity\Tickets\TicketType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TicketTypeFixture extends Fixture
{
    const TYPES = [
        'Sales', 'Accounts', 'IT'
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::TYPES as $type){
            $ticketType = $manager->getRepository(TicketType::class)->findOneBy(['name' => $type]);

            if(!$ticketType){
                $ticketType = new TicketType();
                $ticketType->setName($type);
                $manager->persist($ticketType);
            }
        }
        $manager->flush();
    }
}
