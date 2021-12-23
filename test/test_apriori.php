<?php
require 'vendor/autoload.php';

use \phpai\Apriori as Apriori;


$data = array(['A','B'] , ['A','B', 'C', 'D'], ['B','D', 'C'], ['A' ,'D']);
$apriori = new Apriori(false, $data);
print_r($apriori->fit());