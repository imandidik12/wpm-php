<?php
require 'vendor/autoload.php';

use Rumus\Rumus;



$bobot = [3, 4, 5, 5, 4, 4, 4, 3];

$dataset = [
    [0.75,2000,18,50,500],
    [0.50,1500,20,40,450],
    [0.90,2050,35,35,800]
];
$dataset1 = [
    [42,66006,60,75,2.355],
    [50,90000,72,60,1.421],
    [63,91500,65,80,2.585]
];
$dataset2 = [
    [250,16,12,1,],
    [200,16,8,.6,],
    [300,32,16,.8,],
    [275,32,16,.8,],
    [225,16,16,.4,],
];
$dataset3 = [
    [1,4,2,4,1,3,3,3],
    [1,4,1,2,2,3,3,3],
    [1,3,2,3,2,2,3,3],
    [1,3,2,2,3,4,2,3],
    [1,4,3,3,3,3,3,3],
];

$data = [
    'Bayu'=>$dataset3[0],
    'Agung'=>$dataset3[1],
    'Andre'=>$dataset3[2],
    'Fuad'=>$dataset3[3],
    'Deni'=>$dataset3[4],
];
$benefical = [];
$rumus = new Rumus($data, $bobot, $benefical);

dd($rumus->get_formatted());