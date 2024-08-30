<?php
namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\PantherTestCase;


class AdminControllerTest extends PantherTestCase
{
    private function authenticateAsAdmin($client): void
    {
        $user = [
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
        ];

        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(0, $crawler->filter('input[name="email"]')->count(), 'Email field not found');
        $this->assertGreaterThan(0, $crawler->filter('input[name="password"]')->count(), 'Password field not found');
        $this->assertGreaterThan(0, $crawler->filter('button[type="submit"]')->count(), 'Submit button not found');

        $form = $crawler->selectButton('Connexion')->form([
            'email' => $user['email'],
            'password' => $user['password'],
            '_csrf_token' => $crawler->filter('input[name="_csrf_token"]')->attr('value'),
        ]);

        $client->submit($form);
        $client->followRedirect();
    }

    public function testAdminIndex(): void
    {
        $client = static::createClient();
        $this->authenticateAsAdmin($client);
        $client->request('GET', '/admin');
        
        $this->assertResponseIsSuccessful();
    }

    public function testAddEmployee(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
        'email' => 'cyrille@gmail.com',
        'password' => 'cyrille',
        ]));

        $link = $crawler->filterXPath('//aside[@class="sidebar"]//ul[@class="sidebar-nav"]//li[@class="sidebarLi"]//a[contains(text(), "Employés")]')->link();
        $crawler = $client->click($link);   

        $client->executeScript('document.getElementById("addEmployeeSection").style.display = "block";');


        $form = $crawler->selectButton('Enregistrer')->form([
            'employe[email]' => 'john.doe@example.com',
            'employe[password]' => 'pass/-mRc76',
        ]);

        $crawler = $client->submit($form);
        $crawler = $client->request('GET', $client->getCurrentURL());

        $link = $crawler->filterXPath('//aside[@class="sidebar"]//ul[@class="sidebar-nav"]//li[@class="sidebarLi"]//a[contains(text(), "Employés")]')->link();
        $crawler = $client->click($link); 
        $client->waitFor('#viewEmployeesSection', 2);
        $client->executeScript('document.getElementById("viewEmployeesSection").style.display = "block";');
        $content = $crawler->html();
        $this->assertStringContainsString('john.doe@example.com', $content);
        $this->removeTestEmployee($client,'john.doe@example.com');
    }

    private function removeTestEmployee($client, string $email): void
    {
        $crawler = $client->request('GET', '/admin/employees');
        $form = $crawler->filterXPath("//p[text()='{$email}']/following-sibling::div//form")->first();

    if ($form->count() > 0) {
        $form = $form->form();

        $client->executeScript('window.confirm = function() { return true; }');
        $client->submit($form);

        $crawler = $client->request('GET', $client->getCurrentURL());
        $content = $crawler->html();
        $this->assertStringNotContainsString($email, $content);
    } else {
        $this->fail("Le formulaire de suppression pour l'email '{$email}' n'a pas été trouvé.");
    }
    }
}/* End of AdminControllerTest.php */