<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class ToggleTest extends WebTestCase
{
    /**
     * @test
     */
    public function taskShouldToggledByAuthor(): void
    {
        // création du client
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        /** @var Task $task */
        $task = $entityManager->getRepository(Task::class)->find(2);
        /* On stock la valeur de $task->isDone() plutôt que de $task car task
        est modifié par la requête et on se retrouve à comparer 2 true après */
        $originalTask = $task->isDone(); // isDone return bool(false)

        // Requête du toggle
        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_toggle", ["id" => $task->getId()])
        ); // isDone return bool(true)

        // Récupère la nouvelle tâche toggled stocké dans $toggleTask
        /** @var Task $toggleTask */
        $toggleTask = $entityManager->getRepository(Task::class)->find(2);
        // Comparaison des 2 états
        $this->assertNotSame($originalTask, $toggleTask->isDone());
    }

    /**
     * @test
     */
    public function taskShouldNotBeToggleByOtherUserAndRaiseMessageError(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // User id 2 Morgane has ROLE_USER
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find(2);
        $client->loginUser($user);

        // Task id 23 has been created by user id 3 Clement (ROLE_USER)
        $client->request(Request::METHOD_GET, '/tasks/23/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertSelectorTextContains('html', 'Access Denied.');
    }

    /**
     * @test
     */
    public function userTaskShouldBeToggleByAdmin(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // User id 1 Audrey has ROLE_ADMIN
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find(1);
        $client->loginUser($user);

        // Task id 23 has been created by user id 3 Clement (ROLE_USER)
        /** @var Task $task */
        $task = $entityManager->getRepository(Task::class)->find(23);
        $originalTask = $task->isDone();

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_toggle", ["id" => $task->getId()])
        );

        /** @var Task $toggleTask */
        $toggleTask = $entityManager->getRepository(Task::class)->find(23);

        $this->assertNotSame($originalTask, $toggleTask->isDone());
    }

    /**
     * @test
     */
    public function anonymeTaskShouldBeToggleByAdminOnly(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // User id 1 Audrey has ROLE_ADMIN
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find(1);
        $client->loginUser($user);

        // Task id 1 is 'anonyme' -> no related user
        /** @var Task $task */
        $task = $entityManager->getRepository(Task::class)->find(1);
        $originalTask = $task->isDone();

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_toggle", ["id" => $task->getId()])
        );

        /** @var Task $toggleTask */
        $toggleTask = $entityManager->getRepository(Task::class)->find(1);

        $this->assertNotSame($originalTask, $toggleTask->isDone());
    }

    /**
     * @test
     */
    public function anonymeTaskShouldNotBeToggleByNonAdmin(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // User id 2 Morgane has ROLE_USER
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find(2);
        $client->loginUser($user);

        // Task id 1 is 'anonyme' -> no related user
        $client->request(Request::METHOD_GET, '/tasks/1/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertSelectorTextContains('html', 'Access Denied.');
    }
}
