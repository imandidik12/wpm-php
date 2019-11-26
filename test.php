<?php
require 'vendor/autoload.php';

use Rumus\Rumus;

function parsefromstring( $string, $todouble = true ){
    $data = explode("\n", $string);
    $data = collect($data)->filter(static function($item){return $item;});

    if ($todouble){
        $data = $data->map(static function($item){
            return (double) $item;
        });
    }
    return $data;
}

$harga = '35
15
15
40
10
30
12
5
3
10
7
10
10
10
10
5
10
15
8
30
35
12.5
25
5
3
5
100
5
12
10
15
10
7
10
10
5
85
5
10
';
$jaraks ='3.1
6.6
3.9
7.6
6.5
6.7
6.7
7.2
6.5
14.2
5.8
7.9
15
10
11.7
12.5
12.5
5.9
16.6
2.9
6.3
16.6
8.1
26.6
24.7
27.3
10.4
32.9
20.7
24.6
6.2
18
39.6
30.3
15.2
14.8
11.8
14.2
7.9
';
$ratings = '4.5
4
3
4.5
1.9
4
2.7
2
2
2
2
2
2
2.1
2.5
1.9
2
2.2
2.2
3
3
3
4.1
2.5
2.6
1.9
5
2.6
2
2
3.1
2
2.1
2.1
2.1
2
5
2.3
2.3
';
$jumkolams = '2
2
1
2
1
2
2
2
3
4
2
3
3
2
1
1
1
2
3
2
2
2
2
2
2
2
4
2
2
2
2
1
3
2
3
3
2
3
3
';
$operasionals='12
11
7
15
10
10
9
24
10
11
10
10
10
10
10
9.5
10
9
10
9.5
8.5
9
8
9
10
10
9
10
10
9
9
7
9.5
9
13
10
12
9
10
';
$alternatives = 'Permata Jingga Swimming Pool & Cafe
Kolam Renang Lembah Dieng
Kolam Renang Stadion Gajayana
Araya Family Club House Swimming Pool
Kolam Renang In Jaya
Royal Pool
Kolam Renang Ukhuwah
Swimming Pool Wiroto
Swimming Pool And Fishing Sumber Beling
Swimming Pool Kalimeri
Warna Swimming Pool
Kolam Renang Simpang Sulfat Selatan
Kolam Renang Cerme 1
Kolam Renang Tirta Alam
Pemandian Kendedes Singosari
Swimming Pool Tirta Buana
Tirta Vicadha Swimming Pool
Kolam Renang Tirta Marabunta
Kalirejo Swimming Pool
Tlogomas Park
Water Park Tirtasani
Water Boom 88
Club House Green Hills
Swimming Pool Dewi Sri
Swimming Pool Kali Gayam
Swimming Pool Kanjuruhan
Hawai Water Park
Swimming Pool Permata Alam
Swimming Pool Wonosari
Recreation Pool Metro
Kolam Renang Rampal
Swimming Pool Songgoriti
Selo Agung Swimming Pool
Kolam Renang Tirta Agung
Dolan Park
Kolam Renang Kharisma
The Singhasari Resort & Convention Batu
De Berran
Kolam Renang Efyusi
';
$harga = parsefromstring($harga);
$jaraks = parsefromstring($jaraks);
$ratings = parsefromstring($ratings);
$jumkolams = parsefromstring($jumkolams);
$operasionals = parsefromstring($operasionals);

$alternatives = parsefromstring($alternatives, false);

$alternatives = $alternatives->map(static function($item, $index) use ($harga, $jaraks, $ratings , $jumkolams, $operasionals) {
    return [
            $item=>[
                $harga[$index], $jaraks[$index], $ratings[$index], $jumkolams[$index], $operasionals[$index]
            ]
    ];
});

$dataset = [];
foreach ($alternatives as $index=>$alternative){
    foreach ($alternative as $name=>$value){
        $dataset[$name] = $value;
    }
}
$bobot = [5,10,40,20,10];
$cost = [1,2];
$wpm = new Rumus($dataset, $bobot, $cost);
$res = $wpm->get_formatted();
dd($wpm->preferences->normalized);
//$wr = [5, 2, 4, 4, .5];
//
//$dataset = [
//    [42,66006,60,75,2.355],
//    [50,90000,72,60,1.421],
//    [63,91500,65,80,2.585]
//];
//
//$data = [
//    'A1'=>$dataset[0],
//    'A2'=>$dataset[1],
//    'A3'=>$dataset[2],
//];
//$cost = [2,5];
?>

<h1>Raw</h1>

<?php

echo '<table>';
$th = ['Alternatives','C1','C2','C3','C4','C5'];
echo '<thead><tr>';
foreach ($th as $_th){
    echo "<th>$_th</th>";
}
echo '</tr></thead>';
echo '<tbody>';
foreach ($res as $index=> $alternative){
    echo '<tr>';
    echo "<th>$index</th>";
    foreach ($alternative['criterias'] as $criteria){
        echo "<td>$criteria</td>";
    }
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
?>

    <h1>Normalized</h1>

<?php
echo 'Weight = [';
foreach ($wr as $_preference) {
    echo $_preference . ',';
}
echo ']<br>';
echo 'Normalized Weight = [';
$wpm->preferences->normalized->each(function ($entry){
    echo round($entry,2).',';
});
echo ']';
echo '<table>';
$th = ['Alternatives','C1','C2','C3','C4','C5'];
echo '<thead><tr>';
foreach ($th as $_th){
    echo "<th>$_th</th>";
}
echo '</tr></thead>';
echo '<tbody>';
foreach ($res as $index=> $alternative){
    echo '<tr>';
    echo "<th>$index</th>";
    foreach ($alternative['normalized'] as $criteria){
        echo "<td>| $criteria </td>";
    }
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
?>

    <h1>Scores</h1>

<?php
echo 'Normalized score total = '.$wpm->s_total;
echo '<table>';
$th = ['Alternatives','Normalized scores','Scores'];
echo '<thead><tr>';
foreach ($th as $_th){
    echo "<th>$_th</th>";
}
echo '</tr></thead>';
echo '<tbody>';
foreach ($res as $index=> $alternative){
    echo '<tr>';
    echo "<th>$index</th>";
    foreach ($alternative['score'] as $score){
        echo "<td>$score</td>";
    }
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
