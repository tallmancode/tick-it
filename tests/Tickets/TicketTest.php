<?php

namespace App\Tests\Tickets;

use App\DataFixtures\Tickets\TicketStatusFixture;
use App\DataFixtures\Tickets\TicketTypeFixture;
use App\DataFixtures\UserFixture;
use App\Entity\Tickets\TicketStatus;
use App\Entity\Tickets\TicketType;
use App\Repository\Tickets\TicketStatusRepository;
use App\Repository\Tickets\TicketTypeRepository;
use App\Repository\Users\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketTest extends WebTestCase
{
    /**
     * @var AbstractDatabaseTool
     */
    private $databaseTool;

    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->databaseTool = $this->client->getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testCanLogTicket(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixture::class,
            TicketStatusFixture::class,
            TicketTypeFixture::class
        ]);

        $userRepository = $this->client->getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'user@user.com']);
        $this->client->loginUser($user);

        $ticketStatusRepository = $this->client->getContainer()->get(TicketStatusRepository::class);
        $status = $ticketStatusRepository->findOneBy(['name' => 'new']);


        $ticketTypeRepo =  $this->client->getContainer()->get(TicketTypeRepository::class);
        $type = $ticketTypeRepo->findOneBy(['name' => 'Sales']);

        $formData = [
            'ticketType' => '/api/ticket_types/'.$type->getId(),
            'ticketStatus' => '/api/ticket_statuses/'.$status->getId(),
            'title' => 'Test Title',
            'description' => 'Test Description'
        ];

        $response = $this->postTicketRoute($formData);

        $this->assertEquals(201, $response['statusCode']);

        $this->assertEquals('Test Title', $response['content']['title']);
        $this->assertEquals('Test Description', $response['content']['description']);
    }

    public function testTicketTitleValidation(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixture::class,
            TicketStatusFixture::class,
            TicketTypeFixture::class
        ]);

        $userRepository = $this->client->getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'user@user.com']);
        $this->client->loginUser($user);

        $ticketStatusRepository = $this->client->getContainer()->get(TicketStatusRepository::class);
        $status = $ticketStatusRepository->findOneBy(['name' => 'new']);


        $ticketTypeRepo =  $this->client->getContainer()->get(TicketTypeRepository::class);
        $type = $ticketTypeRepo->findOneBy(['name' => 'Sales']);

        $formData = [
            'ticketType' => '/api/ticket_types/'.$type->getId(),
            'ticketStatus' => '/api/ticket_statuses/'.$status->getId(),
            'description' => 'Test Description'
        ];

        $response = $this->postTicketRoute($formData);

        $this->assertEquals(422, $response['statusCode']);
    }

    private function postTicketRoute($formData)
    {
        $this->client->request(
            'POST',
            '/api/tickets',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($formData)
        );

        return [
            'statusCode' => $this->client->getResponse()->getStatusCode(),
            'content' => json_decode($this->client->getResponse()->getContent(), true)
        ];
    }
}
