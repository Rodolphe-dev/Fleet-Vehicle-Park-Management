<?php

for ($i = 1; $i <= 100; $i++) {
    $Every_3 = (0 === $i % 3);
    $Every_5 = (0 === $i % 5);

    if (!$Every_3 && !$Every_5) {
        echo $i . PHP_EOL;

        continue;
    }

    if ($Every_3) {
        echo 'Fizz';
    }

    if ($Every_5) {
        echo 'Buzz';
    }

    echo PHP_EOL;
}

?>