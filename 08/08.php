<?php

class Connections extends SplHeap {
    protected function compare($value1, $value2) : int {
        return distance(...$value2) <=> distance(...$value1);
    }
}

function distance(array $a, array $b) : float {
    if ($a === $b) {
        return 0;
    }
    return array_map(fn ($da, $db) => abs($da-$db) ** 2, $a, $b) |> array_sum(...) |> sqrt(...);
}

function connect(array $circuits, array $a, array $b) : array {
    $found = array_filter($circuits, fn($circuit) => in_array($a, $circuit) || in_array($b, $circuit));

    $i = array_key_first($found);
    switch (count($found)) {
        case 0:
            $circuits[] = [$a, $b];
            break;
        case 1:
            $circuits[$i][] = $a;
            $circuits[$i][] = $b;
            $circuits[$i] = array_unique($circuits[$i], SORT_REGULAR);
            break;
        case 2:
            $j = array_key_last($found);
            $circuits[$i] = array_merge($circuits[$i], $circuits[$j]);
            $circuits[$i] = array_unique($circuits[$i], SORT_REGULAR);
            unset($circuits[$j]);
            break;
    }
    return $circuits;
}

$junctions = array_map(fn ($junction) => explode(',', $junction), explode(PHP_EOL, file_get_contents('input')));
$all = count($junctions);


$connections = new Connections();
while ($current = array_pop($junctions)) {
    foreach ($junctions as $junction) {
        $connections->insert([$current, $junction]);
    }
}

$circuits = [];
foreach (new LimitIterator($connections, 0, 1000) as [$a, $b]) {
    $circuits = connect($circuits, $a, $b);
}

$counts = array_map(count(...), $circuits);
rsort($counts);
$largest = array_slice($counts, 0, 3) |> array_product(...);

foreach ($connections as [$a, $b]) {
    $circuits = connect($circuits, $a, $b);
    if (count($circuits) === 1 && reset($circuits) |> count(...) === $all) {
        break;
    }
}

echo $largest.PHP_EOL;
echo $a[0] * $b[0].PHP_EOL;