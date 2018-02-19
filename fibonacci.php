<?php

function fibonacci($iteration, $f1 = 0, $f2 = 1)
{
    // The fibonacci result is '0' indexed,
    // so we subtract 1 from the iteration amount in our check
    if($iteration - 1 > 0) {
        $iteration--;
        return fibonacci($iteration, $f2, ($f1 + $f2));
    } else {
        return $f2;
    }
}

echo fibonacci(5) . '<br />';
echo fibonacci(10) . '<br />';
echo fibonacci(1) . '<br />';