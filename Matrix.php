<?php

class Matrix extends ArrayObject
{

    public function __construct($array = [], $flags = 0, $iteratorClass = "ArrayIterator")
    {
        parent::__construct($array, $flags, $iteratorClass);
    }

    public function getMatrixAsArray()
    {
        return parent::getArrayCopy();
    }

}


$mat = new Matrix([[1,2],[2,3]]);
$mat[0][1] = 111;

print_r($mat->getArray());

