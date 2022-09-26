<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RangeScoreTest extends KernelTestCase
{
    private $service;
    
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->service = self::getContainer()->get('App\Services\GithubService');
    }
    
    private function getResponse()
    {
        $this->service->setQueryParameter('php');
        $this->service->calculateScore();
        
        $score = round($this->service->calculateScore()['score'],2);
        
        if($score >= 0 && $score <= 10){
            return true;
        }
        
        return false;
    }
    
    /*
     *  @depends getResponse
     * */
    public function testGetToken()
    {
        $this->assertEquals(true, $this->getResponse());
    }
}