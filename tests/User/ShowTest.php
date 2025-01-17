<?php

namespace App\Tests\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class ShowTest extends WebTestCase
{
    /**
     * @test
     */
    public function usersManagementShouldBeDisplayedForAdmin(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("user_list")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(14, $crawler->filter('.user-infos'));
    }

    /**
     * @test
     */
    public function usersManagementShouldNotBeDisplayedForNonAdmin(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // User w/ id 2 has ROLE_USER
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find(2);
        $client->loginUser($user);

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("user_list")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}
