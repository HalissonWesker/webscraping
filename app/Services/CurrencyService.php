<?php

namespace App\Services;

use App\Repositories\CurrencyRepositoryInterface;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CurrencyService
{
    private $currencyRepository;
    private $client;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
        $this->client = new Client(['base_uri' => 'https://pt.wikipedia.org']);
    }

    public function getCurrencyData($codeOrNumber)
    {
        $currency = $this->currencyRepository->getCurrencyByCodeOrNumber($codeOrNumber);

        if ($currency) {
            return [$currency->toArray()];
        }

        $response = $this->client->request('GET', '/wiki/ISO_4217');
        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        $table = $crawler->filter('table.wikitable')->first();

        $currencyData = [];

        $table->filter('tr')->each(function ($row) use (&$currencyData, $codeOrNumber) {
            $cells = $row->filter('td');

            if ($cells->count() > 0) {
                $code = $cells->eq(0)->text();
                $number = (int)$cells->eq(1)->text();
                $decimal = (int)$cells->eq(2)->text();
                $currency = $cells->eq(3)->text();
                
                $locations = [];
                if ($cells->eq(4)->filter('a')->count() > 0) {
                    $locations = $cells->eq(4)->filter('a')->each(function ($location) {
                        return [
                            'location' => $location->text(),
                            'icon' => $location->filter('img')->attr('src') ?? ''
                        ];
                    });
                }

                if (strtoupper($codeOrNumber) === strtoupper($code) || (int)$codeOrNumber === $number) {
                    $currencyData[] = [
                        'code' => $code,
                        'number' => $number,
                        'decimal' => $decimal,
                        'currency' => $currency,
                        'currency_locations' => $locations
                    ];

                    // Salve no banco de dados
                    $this->currencyRepository->saveCurrencyData([
                        'code' => $code,
                        'number' => $number,
                        'decimal' => $decimal,
                        'currency' => $currency,
                        'currency_locations' => json_encode($locations)
                    ]);
                }
            }
        });

        return $currencyData;
    }
}
