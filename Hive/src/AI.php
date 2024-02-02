<?php

class AI
{
    private $httpClient;

    /**
     * @param $httpClient
     */
    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }


    public function getMove()
    {
    }
}