<?php

function in_range(int $test, array $range) : bool {
    return $test >= $range[0] && $test <= $range[1];
}

function overlap(array $test, array $range) : bool {
    return in_range($test[0], $range) || in_range($test[1], $range) || in_range($range[0], $test) || in_range($range[1], $test);
}

list($ranges, $ingredients) = array_map(fn ($input) => explode(PHP_EOL, $input), explode(PHP_EOL.PHP_EOL, file_get_contents('input')));
$ranges = array_map(fn ($range) => explode('-', $range), $ranges);

$fresh = 0;
foreach ($ingredients as $ingredient) {
    if (array_reduce($ranges, fn ($found, $range) => $found || in_range($ingredient, $range), false)) {
        $fresh++;
    }
}

$fresh_ranges = 0;
while ($range = array_shift($ranges)) {

    $overlaps = array_filter($ranges, fn ($test) => overlap($test, $range));

    if (empty($overlaps)) {
        $fresh_ranges += $range[1] - $range[0] + 1;
    }

    else {
        $overlaps = array_map(fn ($test) => [min($test[0], $range[0]), max($test[1], $range[1])], $overlaps);
        $ranges = array_replace($ranges, $overlaps);
    }
}

echo $fresh.PHP_EOL;
echo $fresh_ranges.PHP_EOL;