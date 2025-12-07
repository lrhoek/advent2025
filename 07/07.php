<?php

$grid = array_map(str_split(...), explode(PHP_EOL, file_get_contents('input')));

$splits = 0;
$timelines = array_map(fn ($location) => $location === '.' ? 0 : 1, array_shift($grid));

foreach ($grid as $locations) {
    foreach (array_keys($locations, '^') as $x) {
        $timelines[$x] === 0 ?: $splits++;
        $timelines[$x-1] += $timelines[$x];
        $timelines[$x+1] += $timelines[$x];
        $timelines[$x] = 0;
    }
}

echo $splits.PHP_EOL;
echo array_sum($timelines).PHP_EOL;