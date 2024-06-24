<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CurrencyService;
use App\Repositories\CurrencyRepositoryInterface;
use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\DomCrawler\Crawler;

class CurrencyServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = Mockery::mock(CurrencyRepositoryInterface::class);
        $this->clientMock = Mockery::mock(Client::class);
        $this->service = new CurrencyService($this->repositoryMock, $this->clientMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetCurrencyData()
    {
        $codeOrNumber = 'GBP';

        // Mock the repository and HTTP client responses
        $this->repositoryMock
            ->shouldReceive('getCurrencyByCodeOrNumber')
            ->with($codeOrNumber)
            ->andReturn(null);

        $html = '<table class="wikitable"><tr><td>GBP</td><td>826</td><td>2</td><td>Libra Esterlina</td><td><a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Flag_of_the_United_Kingdom.svg/22px-Flag_of_the_United_Kingdom.svg.png"></a></td></tr></table>';

        $responseMock = Mockery::mock(Response::class);
        $responseMock
            ->shouldReceive('getBody->getContents')
            ->andReturn($html);

        $this->clientMock
            ->shouldReceive('request')
            ->with('GET', '/wiki/ISO_4217')
            ->andReturn($responseMock);

        $result = $this->service->getCurrencyData($codeOrNumber);

        $this->assertNotEmpty($result);
        $this->assertEquals('GBP', $result[0]['code']);
        $this->assertEquals(826, $result[0]['number']);
        $this->assertEquals('Libra Esterlina', $result[0]['currency']);
    }
}
