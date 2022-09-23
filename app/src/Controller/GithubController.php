<?php

namespace App\Controller;

use App\Repository\ScoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\GithubService;

class GithubController extends AbstractController
{
    public object $scoreRepository;
    public function __construct(ScoreRepository $scoreRepository)
    {
        $this->scoreRepository = $scoreRepository;
    }
    
    public function score(GithubService $githubService): Response
    {
        $response = $githubService->score();
        if(!$response){
            return $this->json('Total count of the term was not taken',Response::HTTP_BAD_REQUEST);
        }
        $term = $response['term'];
        $score = round($response['score'], 2);
        $field = $this->scoreRepository->findBy(['term'=>$term]);

        if($field){
            $score = $field[0]->getScore();
        }
        elseif(!$this->create($term, $score)){
            return $this->json('This result was not saved',Response::HTTP_BAD_REQUEST);
        }
        
        return $this->json(['term'=>$term, 'score'=>round($score, 2)],Response::HTTP_OK);
    }
    
    public function create(string $term, float $score): Response
    {
        if(!$this->scoreRepository->create($term, $score)){
            return $this->json('The term was not created', Response::HTTP_BAD_REQUEST);
        }
        return $this->json('The term was create', Response::HTTP_OK);
    }
    
    public function update(Request $request): Response
    {
        $id = $request->query->get('id');
        $score = $request->query->get('score');
        if(!$this->scoreRepository->update($id, $score)){
           return $this->json('The term was not updated', Response::HTTP_BAD_REQUEST);
        }
        return $this->json('The term was updated', Response::HTTP_OK);
    }

}
