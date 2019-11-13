<?php
require 'vendor/autoload.php';

use Rumus\Rumus;

$alternative1 = [
    [
        'value'=>250,
        'benefical'=>false,
    ],
    [
        'value'=>16,
        'benefical'=>true,
    ],
    [
        'value'=>12,
        'benefical'=>true,
    ],
    [
        'value'=>1,
        'benefical'=>true,
    ]
];
$alternative2 = [
    [
        'value'=>200,
        'benefical'=>false,
    ],
    [
        'value'=>16,
        'benefical'=>true,
    ],
    [
        'value'=>8,
        'benefical'=>true,
    ]
    ,[
        'value'=>0.6,
        'benefical'=>true,
    ]
];
$alternative3 = [
    [
        'value'=>300,
        'benefical'=>false,
    ],
    [
        'value'=>32,
        'benefical'=>true,
    ],
    [
        'value'=>16,
        'benefical'=>true,
    ],
    [
        'value'=>0.8,
        'benefical'=>true,
    ]
];
$alternative4 = [
    [
        'value'=>275,
        'benefical'=>false,
    ],
    [
        'value'=>32,
        'benefical'=>true,
    ],
    [
        'value'=>8,
        'benefical'=>true,
    ],
    [
        'value'=>0.8,
        'benefical'=>true,
    ],
];
$alternative5 = [
    [
        'value'=>225,
        'benefical'=>false,
    ],
    [
        'value'=>16,
        'benefical'=>true,
    ],
    [
        'value'=>16,
        'benefical'=>true,
    ],
    [
        'value'=>0.4,
        'benefical'=>true,
    ],
];
$data = [$alternative1,$alternative2,$alternative3,$alternative4, $alternative5];
$bobot = [0.25, 0.25, 0.25, 0.25];

$rumus = new Rumus($data, $bobot);