<?php

namespace App\Tests\Auth;

use App\DataFixtures\UserFixture;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
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

    public function testUserCanLogin(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixture::class
        ]);

        $formData = [
            'email' => 'user@user.com',
            'password' => 'password'
        ];

        $response = $this->postLoginRoute($formData);

        $this->assertEquals(204, $response['statusCode']);
    }

    public function testIncorrectPassword(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixture::class
        ]);

        $formData = [
            'email' => 'user@user.com',
            'password' => 'passw'
        ];

        $response = $this->postLoginRoute($formData);

        $this->assertEquals(401, $response['statusCode']);

        $this->assertArrayHasKey('error', $response['content']);

        $this->assertEquals('Invalid credentials.', $response['content']['error']);
    }

    public function testIncorrectEmail(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixture::class
        ]);

        $formData = [
            'email' => 'user@user.co',
            'password' => 'password'
        ];

        $response = $this->postLoginRoute($formData);

        $this->assertEquals(401, $response['statusCode']);

        $this->assertArrayHasKey('error', $response['content']);

        $this->assertEquals('Invalid credentials.', $response['content']['error']);
    }

    private function postLoginRoute($formData)
    {
        $this->client->request(
            'POST',
            '/login',
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
