<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\GithubService;

class GithubController extends AbstractController
{
    public function score(GithubService $githubService): Response
    {
        if(!$githubService->score()){
            return $this->json('Total count of the term was not taken',Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['totalCount'=>$githubService->score()],Response::HTTP_BAD_REQUEST);
    }
}
