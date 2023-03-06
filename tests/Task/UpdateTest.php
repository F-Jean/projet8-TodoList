<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Entity\User;

class UpdateTest extends WebTestCase
{
    /**
     * @test
     */
    public function taskShouldBeEditedByAuthorAndRedirectToTasksList(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Task $originalTask */
        $originalTask = $entityManager->getRepository(Task::class)->findOneBy([]);

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_edit", ["id" => $originalTask->getId()])
        );

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => 'new edited task',
            'task[content]' => 'new edited task',
        ]);

        $client->submit($form);

        $editedTask = $entityManager->getRepository(Task::class)->findOneBy([]);

        // Comparer le changement d'état
        $this->assertNotSame($originalTask, $editedTask);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertSelectorTextContains('html', 'Superbe ! La tâche a bien été modifiée.');
    }

    /**
     * @test
     */
    public function editTaskShouldNotBeAvailableToOtherUserAndRaiseMessageError(): void
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
        $client->request(Request::METHOD_GET, '/tasks/23/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertSelectorTextContains('html', 'Access Denied.');
    }

    /**
     * @test
     */
    public function userTaskCanBeUpdateByAdmin(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // Task id 23 has been created by user id 3 Clement (ROLE_USER)
        /** @var Task $originalTask */
        $originalTask = $entityManager->getRepository(Task::class)->find(23);

        // User id 1 Audrey has ROLE_ADMIN
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find(1);
        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_edit", ["id" => $originalTask->getId()])
        );

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => 'new edited task',
            'task[content]' => 'new edited task',
        ]);

        $client->submit($form);

        /** @var Task $editedTask */
        $editedTask = $entityManager->getRepository(Task::class)->find(23);

        $this->assertNotSame($originalTask, $editedTask);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertSelectorTextContains('html', 'Superbe ! La tâche a bien été modifiée.');
    }

    /**
     * @test
     */
    public function anonymeTaskCanBeUpdatedByAdminOnly(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // Task id 1 is 'anonyme' -> no related user
        /** @var Task $originalTask */
        $originalTask = $entityManager->getRepository(Task::class)->find(1);

        // User id 1 Audrey has ROLE_ADMIN
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find(1);
        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_edit", ["id" => $originalTask->getId()])
        );

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => 'new edited task',
            'task[content]' => 'new edited task',
        ]);

        $client->submit($form);

        /** @var Task $editedTask */
        $editedTask = $entityManager->getRepository(Task::class)->find(1);

        $this->assertNotSame($originalTask, $editedTask);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertSelectorTextContains('html', 'Superbe ! La tâche a bien été modifiée.');
    }

    /**
     * @test
     */
    public function anonymeTaskCanNotBeAvailableByNonAdminAndRaiseMessageError(): void
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
        $client->request(Request::METHOD_GET, '/tasks/1/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertSelectorTextContains('html', 'Access Denied.');
    }

    /**
     * @test
     */
    public function EditedTaskShouldBeDisplayed(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Task $task */
        $task = $entityManager->getRepository(Task::class)->findOneBy([]);

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_edit", ["id" => $task->getId()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function taskShouldNotBeEditedDueToBlankTitleAndRaiseFormError(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Task $originalTask */
        $originalTask = $entityManager->getRepository(Task::class)->findOneBy([]);

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_edit", ["id" => $originalTask->getId()])
        );

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => '',
            'task[content]' => 'new edited task',
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains('html', 'Vous devez saisir un titre.');
    }

    /**
     * @test
     */
    public function taskShouldNotBeEditedDueToBlankContentAndRaiseFormError(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Task $originalTask */
        $originalTask = $entityManager->getRepository(Task::class)->findOneBy([]);

        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("task_edit", ["id" => $originalTask->getId()])
        );

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => 'new edited task',
            'task[content]' => '',
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains('html', 'Vous devez saisir du contenu.');
    }
}
