<?php
require 'vendor/autoload.php';

use \phpai\Matrix as Matrix;


$matrix = new Matrix([1,2,3,4]);
print_r($matrix);
$s = $matrix->shape();
echo $s;