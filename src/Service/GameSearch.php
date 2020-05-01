<?php

namespace App\Service;

use App\Service\LgdbServiceRequestInterface;


class GameSearch implements LgdbServiceRequestInterface{

    private $methode;
    private $url;
    private $options;


    public function __construct($body) {
        $this->methode = 'POST';
        $this->url = 'game';
        $this->options = ['body' => $body];
    }

    /**
     * Get the value of options
     */ 
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get the value of methode
     */ 
    public function getMethode()
    {
        return $this->methode;
    }

    /**
     * Get the value of url
     */ 
    public function getUrl()
    {
        return $this->url;
    }
}
