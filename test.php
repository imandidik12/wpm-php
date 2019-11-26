<?php
require 'vendor/autoload.php';

use Rumus\Rumus;



$wr = [5, 3, 4, 4, 2];

$dataset = [
    [42,66006,60,75,2.355],
    [50,90000,72,60,1.421],
    [63,91500,65,80,2.585]
];

$data = [
    'A1'=>$dataset[0],
    'A2'=>$dataset[1],
    'A3'=>$dataset[2],
];
$cost = [2,5];
$rumus = new Rumus($data, $wr, $cost);
$rumus->get_formatted();