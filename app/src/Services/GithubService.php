<?php
namespace App\Services;

use App\Interfaces\Repository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class GithubService implements Repository
{
    private object $request;
    private object $client;
    
    public function __construct(RequestStack $requestStack, HttpClientInterface $client)
    {
        $this->request = $requestStack;
        $this->client = $client;
    }
    
    public function score(): array | bool
    {
        $term = $this->request->getCurrentRequest()->get('term');
        $terms = ['rocks', 'sucks'];
        $responses = [];
        if(!$term){
            return false;
        }
        
        foreach ($terms as $item){
            $response = $this->client->request('GET', 'https://api.github.com/search/issues?q='.$term.'+'.$item, [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
//                    'Authorization' => 'Bearer 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',
                ],
            ])->getContent();
            
            $responses[$item] = json_decode($response)->total_count;
        }

        if($responses['rocks'] + $responses['sucks'] === 0){
            return ['term' => $term,'score' => 0];
        }

        $score = ($responses['rocks']/($responses['rocks'] + $responses['sucks']) / 10) * 100;
        
        if ($score > 10 || $score === 10){
            $score = 10;
        }
        
        return ['term' => $term,'score' => $score];
    }
    
}