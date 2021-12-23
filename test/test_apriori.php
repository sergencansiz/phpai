<?php
require 'vendor/autoload.php';

use \phpai\Apriori as Apriori;

$apriori = new Apriori($sparse = false);
print_r($apriori);