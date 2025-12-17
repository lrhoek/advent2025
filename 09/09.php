<?php

require_once 'vendor/autoload.php';

use Crell\fp;
use Lrhoek\pf;

function rectangles(array $tiles) : array {
    $rectangles = [];
    while ($current = array_pop($tiles)) {
        foreach ($tiles as $tile) {
            $rectangles[] = [$current, $tile];
        }
    }
    return $rectangles;
}

function area(?array $tiles = null) : int {
    [$a, $b] = $tiles;
    if ($a === $b) { return 0; }
    return array_map(fn ($da, $db) => abs($da - $db) + 1, $a, $b) |> array_product(...);
}

$largest_rectangle = file_get_contents('input')
    |> fp\explode(PHP_EOL)
    |> fp\amap(fp\explode(','))
    |> rectangles(...)
    |> pf\usort(fn ($a, $b) => area($b) <=> area($a))
    |> array_first(...)
    |> area(...);

echo $largest_rectangle.PHP_EOL;