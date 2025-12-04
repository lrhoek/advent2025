<?php

$grid = array_map(str_split(...), explode(PHP_EOL, file_get_contents('input')));

$removed = [];

while (true) {

    $remove = [];

    foreach ($grid as $y => $row) {
        foreach ($row as $x => $value) {

            $neighbours = [
                $grid[$y - 1][$x - 1] ?? '.',
                $grid[$y - 1][$x] ?? '.',
                $grid[$y - 1][$x + 1] ?? '.',
                $row[$x - 1] ?? '.',
                $row[$x + 1] ?? '.',
                $grid[$y + 1][$x - 1] ?? '.',
                $grid[$y + 1][$x] ?? '.',
                $grid[$y + 1][$x + 1] ?? '.'
            ];

            if ($value === '@' && count(array_filter($neighbours, fn ($neighbour) => $neighbour === '@')) < 4) {
                $remove[] = [$y, $x];
            }

        }
    }

    if (empty($remove)) {
        break;
    }

    foreach ($remove as list ($y, $x)) {
         $grid[$y][$x] = '.';
    }

    $removed[] = $remove;
}


echo count(reset($removed)).PHP_EOL;
echo array_sum(array_map(count(...), $removed)).PHP_EOL;