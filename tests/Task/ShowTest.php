<?php

namespace App\Tests\Task;

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
    public function taskTodoShouldBeDisplayed(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        /* On récupère le router pour générer directement une url
        car plus tard l'url peut évolué donc on ne veut pas l'écrire en dure */
        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_list_todo")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        /* On test l'affichage des 9 tasks max par page due à la pagination */
        $this->assertCount(9, $crawler->filter('.card'));
    }

    /**
     * @test
     */
    public function taskDoneShouldBeDisplayed(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        /* On récupère le router pour générer directement une url
        car plus tard l'url peut évolué donc on ne veut pas l'écrire en dure */
        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_list_done")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
