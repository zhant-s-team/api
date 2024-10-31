<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CidadeService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function getCidades()
    {
        try {
            $response = $this->client->request('GET', 'https://servicodados.ibge.gov.br/api/v1/localidades/distritos?orderBy=nome');
            $data = json_decode($response->getBody()->getContents(), true);

            //filtra cidades do sul do maranhao
            $filteredCities = array_filter($data, function ($cidade) {
                return isset($cidade['municipio']['microrregiao']['mesorregiao']['nome']) &&
                       $cidade['municipio']['microrregiao']['mesorregiao']['nome'] === 'Sul Maranhense';
            });

            return array_values($filteredCities);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

}
