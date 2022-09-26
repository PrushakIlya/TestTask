<?php

namespace App\Services;

use App\Interfaces\Repository;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ScoreRepository;

class GithubService extends ScoreRepository implements Repository
{
    private object $request;
    private object $client;

    public function __construct(RequestStack $requestStack, HttpClientInterface $client)
    {
        $this->request = $requestStack;
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getData(): array | bool
    {
        $term = $this->request->getCurrentRequest()->get('term');
        if (!$term) {
            return false;
        }
        $terms = ['rocks', 'sucks'];
        $data['term'] = $term;

        foreach ($terms as $item) {
            $response = $this->client->request(
                'GET',
                'https://api.github.com/search/issues?q='.$term.'+'.$item,
                [
                    'headers' => [
                        'Accept' => 'application/vnd.github+json',
                    ],
                ]
            )->getContent();

            $data[$item] = json_decode($response)->total_count;
        }

        return $data;
    }

    public function calculateScore(): array
    {
        $data = $this->getData();
        if ($data['rocks'] + $data['sucks'] === 0) {
            return ['term' => $data['term'], 'score' => 0];
        }

        $score = ($data['rocks'] / ($data['rocks'] + $data['sucks']) / 10) * 100;
        if ($score > 10 || $score === 10) {
            $score = 10;
        }

        return ['term' => $data['term'], 'score' => $score];
    }

    //for unittest
    public function setQueryParameter(string $term)
    {
        $this->request->push(new Request(['term' => $term]));
    }
}
