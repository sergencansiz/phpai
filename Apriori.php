<?php

class Apriori
{
    private $data;

    public function __construct()
    {
      $this->data = null;
    }

    public function fit(array $data)
    {
        $this->data = $data;
    }

    private function calculate_supports()
    {

    }

}