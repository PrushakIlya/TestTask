<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\GithubService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubController extends AbstractController
{
    public function score(GithubService $githubService): Response
    {
        if(!$githubService->score()){
            return $this->json('Total count of the term was not taken',Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['totalCount'=>$githubService->score()],Response::HTTP_BAD_REQUEST);
    }
    
    public function index(Request $request, HttpClientInterface $httpClient): Response
    {
    
//
//        $response = $httpClient->request('POST', 'https://github.com/login/oauth/access_token', [
//            'headers' => [
//                'content-type' => 'application/x-www-form-urlencoded',
//            ],
//            'body' => [
//                'client_id' => 'adab2fd2c743280d0e81',
//                'client_secret' => '96100d1251a49fe3323b0e73805b339c27b85d9b',
//                'code' => $request->get('code'),
//            ],
//        ])->getContent();

        return $this->json(1);
    }
}
