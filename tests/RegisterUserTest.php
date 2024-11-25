<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {

        /** test fonctionnel pour l inscription d un user
         * 1. creer un faux client (navigateur) et le faire pointer vers une url
         * 2. remplir les champs de mon formlaire d'inscription 
         * 3. est-ce que tu peux regarder si dans ma page le message (alerte) suivant : Bienvenu dans notre boutique, veuillez vous connecter.
         */
        $client = static::createClient(); // creer un faux client
        $client->request('GET', '/inscription'); // le faire pointer vers une url
        
        // 2. remplir les champs de mon formlaire d'inscription 
        $client->submitForm('Valider',[
            'register_user[email]' => 'example@example.se',
            'register_user[lastname]' => 'Ret',
            'register_user[firstname]' => 'Johnny',
            'register_user[plainPassword][first]' => '123456',
            'register_user[plainPassword][second]' => '123456',
        ]);

        //"client" suis les redirection pour savoir ce qui ce passe
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();
        
        // 3. est-ce que tu peux regarder si dans ma page le message (alerte) suivant : Bienvenu dans notre boutique, veuillez vous connecter.
        $this->assertSelectorExists('div:contains("Bienvenu dans notre boutique, veuillez vous connecter.")'); // est ce que ma div contient le message suivant <-::->

    }
}
