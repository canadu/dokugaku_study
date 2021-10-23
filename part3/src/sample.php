<?php
// $viewingTimes = [];
// $periods = ['0' => [10, 20, 30], '1' => [40, 50]];
// foreach ($periods as $period) {
//     echo "================" . PHP_EOL;
//     $viewingTimes = array_merge($viewingTimes, $period);
//     var_dump($viewingTimes);
// }

$viewingTimes = [];
$periods = [10, 20, 30];
$periods2 = [40, 50, 60];
$viewingTimes = array_merge($periods, $periods2);
var_dump($viewingTimes);
