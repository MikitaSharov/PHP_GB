<?php

function getCurrentTime(): string
{
    $hours = (int)date('H');
    $minutes = (int)date('i');

    $hourSuffix = match (true) {
        $hours % 10 == 1 && $hours % 100 != 11 => 'час',
        in_array($hours % 10, [2, 3, 4]) && !in_array($hours % 100, [12, 13, 14]) => 'часа',
        default => 'часов'
    };

    $minuteSuffix = match (true) {
        $minutes % 10 == 1 && $minutes % 100 != 11 => 'минута',
        in_array($minutes % 10, [2, 3, 4]) && !in_array($minutes % 100, [12, 13, 14]) => 'минуты',
        default => 'минут'
    };

    return "$hours $hourSuffix $minutes $minuteSuffix";
}

echo getCurrentTime();
