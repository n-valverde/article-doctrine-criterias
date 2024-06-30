<?php

namespace App\Tests;

use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;

class BestSellersTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $author = AuthorFactory::new(['name' => 'John Doe'])->create();

        BookFactory::createMany(5, function() use ($author) {
            return [
                'rating' => faker()->unique()->randomElement([null, 2, 5, 7, 8]),
                'authors' => [$author]
            ];
        });
    }

    /**
     * @dataProvider provideUrl
     */
    public function testBestSellersFromRepository(string $url): void
    {
        $this->client->request('GET', $url);

        $this->assertResponseIsSuccessful();

        preg_match_all('/\d\/10/', $this->client->getResponse()->getContent(), $matches);
        $this->assertCount('3', $matches[0] ?? []);
        $this->assertSame('8/10', $matches[0][0]);
        $this->assertSame('7/10', $matches[0][1]);
        $this->assertSame('5/10', $matches[0][2]);
    }

    public static function provideUrl(): \Generator
    {
        yield 'From repository' => ['/author/from-repo/John%20Doe'];
        yield 'From entity relationship' => ['/author/John%20Doe'];
        yield 'From search form' => ['/?search=John%20Doe'];
    }
}
