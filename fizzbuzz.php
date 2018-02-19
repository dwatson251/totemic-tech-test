<?php

function fizzbuzz($iterations = 20)
{
    for($i = 1; $i <= $iterations; $i++) {

        $output = '';

        if($i % 3 === 0) {
            $output .= 'Fizz';
        }

        if($i % 5 === 0) {
            $output .= 'Buzz';
        }

        if(!empty($output)) {
            echo $output;
            continue;
        } else {
            echo $i;
        }
    }
}

fizzbuzz();