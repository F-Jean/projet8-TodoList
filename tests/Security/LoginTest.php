<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{
    /**
     * @test
     */
    public function userShouldBeAuthenticatedAndRedirectToHomepage(): void
    {
        // Simule l'envoie d'une requête HTTP.
        $client = static::createClient();
        // On récupère le crawler & on souhaite accéder à la page de connexion.
        $crawler = $client->request(Request::METHOD_GET, '/login');
        // On test d'abord si on arrive bien sur notre page.
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Crawler pertmet de récupérer le contenu d'une page.
        $form = $crawler->filter("form[name=login]")->form([
            "_username" => "Jean",
            "_password" => "password"
        ]);

        $client->submit($form);

        // On test so on est bien en FOUND (code 302 redirection).
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();
        // On test si on est bien redirigé vers notre page d'accueil.
        $this->assertRouteSame('homepage');
    }

    /**
     * @test
     */
    public function userShouldNotBeAuthenticatedDueToInvalidCredentialsAndRaiseFormError(): void
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form[name=login]")->form([
            "_username" => "Jean",
            "_password" => "fail"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertSelectorTextContains('html', 'Invalid credentials.');
    }

    /**
     * @test
     */
    public function userShouldNotBeAuthenticatedDueToBlankUsernameRaiseFormErrorAndRedirectToLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form[name=login]")->form([
            "_username" => "",
            "_password" => "passworD1!"
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('http://localhost/login');
        $client->followRedirect();
        $this->assertSelectorTextContains('html', 'Invalid credentials.');
    }

    /**
     * @test
     */
    public function userShouldNotBeAuthenticatedDueToBlankPasswordRaiseFormErrorAndRedirectToLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form[name=login]")->form([
            "_username" => "Jean",
            "_password" => ""
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('http://localhost/login');
        $client->followRedirect();
        $this->assertSelectorTextContains('html', 'Invalid credentials.');
    }
}
