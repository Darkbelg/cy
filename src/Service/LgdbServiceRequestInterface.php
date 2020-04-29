<?php

namespace App\Service;

interface LgdbServiceRequestInterface
{
    public function getMethode();
    public function getUrl();
    public function getOptions();
}