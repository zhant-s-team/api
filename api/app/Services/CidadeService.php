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

            // Aqui você pode mapear os dados se necessário
            return $data;
        } catch (RequestException $e) {
            // Tratar exceções de requisição
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
