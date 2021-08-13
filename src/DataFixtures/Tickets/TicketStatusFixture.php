<?php

namespace App\DataFixtures\Tickets;

use App\Entity\Tickets\TicketStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TicketStatusFixture extends Fixture
{
    CONST STATUSES = [
        'new', 'in progress', 'resolved'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUSES as $status) {
            $ticketStatus = $manager->getRepository(TicketStatus::class)->findOneBy(['name' => $status]);

            if (!$ticketStatus) {
                $ticketStatus = new TicketStatus();
                $ticketStatus->setName($status);
                $manager->persist($ticketStatus);
            }
        }
        $manager->flush();
    }

}
