<!--*С помощью рекурсии организовать функцию возведения числа в степень. Формат: function power($val, $pow), где $val – заданное число, $pow – степень.-->

<?php

function power($val, $pow): float|int|string
{
    if (!$pow) {
        return 1;
    } elseif ($pow < 0) {
        if (!$val) {
            return 'Деление на 0';
        }

        return 1 / ($val * power($val, $pow + 1));
    }

    return $val * power($val, $pow - 1);
}

echo power(1.5, -1);