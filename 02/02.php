<?php

$ranges = explode(',', file_get_contents('input'));
$ranges = array_map(fn ($range) => explode('-', $range), $ranges);

function validate($range) : int {
    list ($start, $end) = $range;
    $invalid = 0;


    $start_left = strlen($start) > 1 ? str_split($start, intdiv(strlen($start), 2))[0] : $start;

    $current = $start_left . $start_left;
    while ($current <= $end) {
        if ($current >= $start) {
            $invalid += (int) $current;
        }
        $start_left++;
        $current = $start_left . $start_left;
    }

    return $invalid;
}

function validate2($range) : int {

    list ($start, $end) = $range;
    $invalid = 0;

    for ($current = $start; $current <= $end; $current++) {
        for ($test = 1; $test <= intdiv(strlen($current), 2); $test++) {
            $found = count(array_unique(str_split($current, $test))) === 1;
            if ($found) {
                $invalid += $current;
                break;
            }
        }
    }

    return $invalid;

}

echo array_sum(array_map(validate(...), $ranges)).PHP_EOL;
echo array_sum(array_map(validate2(...), $ranges)).PHP_EOL;
