<?php

function rotate(string $rotation, int $start, int $zeroesEnded, int $zeroesPassed) : array {

    $clicks = (int) substr($rotation, 1);
    $position = $start + (str_starts_with($rotation, "L") ? - $clicks : $clicks) ;

    $zeroesEnded += $position % 100 === 0;
    $zeroesPassed += abs(intdiv($position, 100)) + ($position <= 0 && $start !== 0);

    return [gmp_intval(gmp_mod($position, 100)), $zeroesEnded, $zeroesPassed];
}

$rotations = explode(PHP_EOL, file_get_contents('input'));
$start = [50, 0, 0];

$result = array_reduce($rotations, fn ($state, $rotation) => rotate($rotation, ...$state), $start);

echo $result[1].PHP_EOL;
echo $result[2].PHP_EOL;