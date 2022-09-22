<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class GithubService
{
    private object $request;
    private object $client;
    
    public function __construct(RequestStack $requestStack, HttpClientInterface $client)
    {
        $this->request = $requestStack;
        $this->client = $client;
    }
    
    public function score(): int
    {
        $term = $this->request->getCurrentRequest()->get('term');
        
        if(!$term){
            return false;
        }
        
        $response = $this->client->request('GET', 'https://api.github.com/search/issues?q='.$term, [
            'headers' => [
                'Accept' => 'application/vnd.github+json',
                'Authorization' => 'Bearer '.$_ENV['BEARER_TOKEN'],
            ],
        ])->getContent();
        
        return json_decode($response)->total_count;
    }
}