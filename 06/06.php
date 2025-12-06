<?php

$input = explode(PHP_EOL, file_get_contents('input'));

$problems = array_map(null, ...array_map(fn ($row) => preg_split('/\s+/', trim($row)), $input));
$answers = array_map(fn ($problem) => array_pop($problem) === '+' ? array_sum($problem) : array_product($problem), $problems);

$problems = array_map(join(...), array_map(null, ...array_map(str_split(...), $input)));
$answers2 = [];
$cache = [];
while ($chars = array_pop($problems)) {

    $cache[] = (int) $chars;

    if (!is_numeric($chars)) {
        $answers2[] = str_ends_with($chars, '+') ? array_sum($cache) : array_product($cache);;
        $cache = [];
    }
}

echo array_sum($answers).PHP_EOL;
echo array_sum($answers2).PHP_EOL;