<?php

namespace phpai;

class Matrix
{

    /**
     * @var array|mixed
     */
    private $array;

    public function __construct($array = [])
    {
        $this->array = $array;
    }

    public function get(): array
    {
        return $this->array;
    }

    public function shape(): int
    {

        return count($this->array);
    }

}

