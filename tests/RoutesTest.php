<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Gitonomy\Git\Admin;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutesTest extends WebTestCase
{
    public function testLogingPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }

    //--------------- USER ROUTES ---------------//

    /**
     * @dataProvider userProvideRoutes
     */
    public function testUserRoute(string $route): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('contributor@sf.com');

        $client->loginUser($testUser);

        $client->request('GET', $route);
        $this->assertResponseIsSuccessful();
    }

    public function userProvideRoutes(): array
    {
        return [
            ['/'],
            ['/idea/new'],
            ['/idea/MyOffice'],
            ['/idea/MyDepartment'],
            ['/user/1'],
        ];
    }

    /**
     * @dataProvider userUnaccessibleRoutes
     */
    public function testUserUnaccessibleRoute(string $route): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('contributor@sf.com');

        $client->loginUser($testUser);

        $client->request('GET', $route);
        $this->assertResponseStatusCodeSame(403);
    }

    public function userUnaccessibleRoutes(): array
    {
        return [
            ['/admin/users'],
            ['/admin/users/1/edit'],
        ];
    }

    //----------------- ADMIN ROUTES -----------------//

    /**
     * @dataProvider adminProvideRoutes
     */
    public function testAdminRoute(string $route): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('superadmin@sf.com');

        $client->loginUser($testUser);

        $client->request('GET', $route);
        $this->assertResponseIsSuccessful();
    }

    public function adminProvideRoutes(): array
    {
        return [
            ['/'],
            ['/idea/new'],
            ['/idea/MyOffice'],
            ['/idea/MyDepartment'],
            ['/user/1'],
            ['/admin/users'],
            ['/admin/users/1/edit'],
        ];
    }
}
