<?php

class Apriori
{
    private $data;
    private $sparse;

    public function __construct(boolean $sparse)
    {
      $this->data = null;
      $this->sparse = $sparse;
    }

    public function fit(array $data)
    {
        $this->data = $data;
    }

    private function calculate_supports()
    {

    }

}