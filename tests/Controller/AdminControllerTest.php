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
        $this->assertSelectorExists('.header');
        $this->assertSelectorExists('.topBarLogo');
        $this->assertSelectorExists('.top-bar');
        $this->assertSelectorExists('.top-nav');
        $this->assertSelectorExists('.main-container');
        $this->assertSelectorExists('.sidebar');
        $this->assertSelectorExists('.sidebar-nav');
    }

    public function testAddEmployee(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
        'email' => 'cyrille@gmail.com',
        'password' => 'cyrille',
        ]));
        $this->assertStringContainsString('Employés', $client->getPageSource());

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

    public function testAddVeterinary(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
        'email' => 'cyrille@gmail.com',
        'password' => 'cyrille',
        ]));

        $this->assertStringContainsString('Vétérinaires', $client->getPageSource());

        $link = $crawler->filterXPath('//aside[@class="sidebar"]//ul[@class="sidebar-nav"]//li[@class="sidebarLi"]//a[contains(text(), "Vétérinaires")]')->link();
        $crawler = $client->click($link);   

        $client->executeScript('document.getElementById("addVeterinarySection").style.display = "block";');


        $form = $crawler->selectButton('Enregistrer')->form([
            'veterinary[email]' => 'john.doe@example.com',
            'veterinary[password]' => 'pass/-mRc76',
        ]);

        $crawler = $client->submit($form);
        $crawler = $client->request('GET', $client->getCurrentURL());

        $link = $crawler->filterXPath('//aside[@class="sidebar"]//ul[@class="sidebar-nav"]//li[@class="sidebarLi"]//a[contains(text(), "Vétérinaires")]')->link();
        $crawler = $client->click($link); 
        $client->waitFor('#viewVeterinarySection', 2);
        $client->executeScript('document.getElementById("viewVeterinarySection").style.display = "block";');
        $content = $crawler->html();
        $this->assertStringContainsString('john.doe@example.com', $content);
        $this->removeTestVeterinary($client,'john.doe@example.com');
    }

    private function removeTestVeterinary($client, string $email): void
    {
        $crawler = $client->request('GET', '/admin/veterinaries');
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
    public function testIndexArea(): void
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
        ]));

        $client->request('GET', '/admin/area');

        $client->waitFor('.listeArea');
        $this->assertSelectorTextContains('h1', 'Liste des Zones');
        $this->assertSelectorExists('.listeArea');
    }

    public function testIndexAnimaux(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
        ]));

        $client->request('GET', '/admin/animaux');

        $this->assertSelectorTextContains('h1', 'Liste des Animaux par Zone');
        $this->assertSelectorExists('.listeAnimauxContent'); 
        $this->assertSelectorExists('.gridContainer');
        $this->assertSelectorExists('.gridItem');
    }

    public function testIndexService(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
        ]));

        $client->request('GET', '/service');
        
        $this->assertSelectorExists('.prestation');
        $this->assertSelectorExists('.article2');
        $this->assertSelectorExists('.service-item');
        $this->assertSelectorExists('.titrePrestationContent');
        $this->assertSelectorExists('.text');
    }

    public function testIndexReview(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
        ]));

        $client->request('GET', '/admin_review');
        
        $this->assertSelectorExists('.mainReview');
        $this->assertSelectorExists('.titreReview');
        $this->assertSelectorExists('.addReviewContent');
        $this->assertSelectorExists('.addReview');
        $this->assertSelectorExists('.reviewTotal');
        $this->assertSelectorExists('.starTitre');
        $this->assertSelectorExists('.table');
    }

    public function testDashboard(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
        ]));

        $client->request('GET', '/dashboard');
        
        $this->assertSelectorExists('.titre');
        $this->assertSelectorExists('.chart-container');
        $this->assertSelectorExists('.flex-container');
    }
    public function testPointSante(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submit($crawler->selectButton('Connexion')->form([
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
        ]));

        $client->request('GET', '/admin/pointsante');
        
        $this->assertSelectorExists('.titre');
        $this->assertSelectorExists('.animal-card');
        $this->assertSelectorExists('.animal-header');
        $this->assertSelectorExists('.card-container');
        $this->assertSelectorExists('.veterinary-card');
        $this->assertSelectorExists('.employee-card');
    }
}