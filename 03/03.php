<?php

$banks = explode(PHP_EOL, file_get_contents('input'));
$banks = array_map(str_split(...), $banks);

function joltage($length) : callable {

    return function ($bank) use ($length) : int {

        $joltage = [];

        while ($battery = array_shift($bank)) {
            while (end($joltage) < $battery && !empty($joltage) && count($joltage) + count($bank) > $length - 1) {
                array_pop($joltage);
            }

            if (count($joltage) < $length) {
                $joltage[] = $battery;
            }
        }

        return (int)join($joltage);
    };
}

echo array_sum(array_map(joltage(2), $banks)).PHP_EOL;
echo array_sum(array_map(joltage(12), $banks)).PHP_EOL;
