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
$wpm = new Rumus($data, $wr, $cost);
$res = $wpm->get_formatted();
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
        echo "<td>$criteria</td>";
    }
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
?>

    <h1>Scores</h1>

<?php

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
