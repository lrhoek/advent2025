<?php

$banks = explode(PHP_EOL, file_get_contents('input'));
$banks = array_map(str_split(...), $banks);

function largest_joltage($bank) {

    arsort($bank);
    $highest = array_slice($bank, 0, 1, true);
    ksort($bank);

    if (array_key_first($highest) + 1 === count($bank)) {
        $right = array_pop($bank);
        $left = max($bank);
    }

    else {
        $right = max(array_slice($bank, array_key_first($highest) + 1));
        $left = reset($highest);
    }

    return $left . $right;
}

echo array_sum(array_map(largest_joltage(...), $banks)).PHP_EOL;
