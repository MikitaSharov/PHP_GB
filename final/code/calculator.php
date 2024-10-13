<?php

function sum(float $x, float $y): float
{
    return $x + $y;
}

function dif(float $x, float $y): float
{
    return $x - $y;
}

function div(float $x, float $y): float|string
{
    if (!$y) {
        return 'Деление на 0';
    }
    return $x / $y;
}

function multiply(float $x, float $y): float
{
    return $x * $y;
}

function calc(float $x, float $y, string $opp): float|string
{
    return match ($opp) {
        '+' => sum($x, $y),
        '-' => dif($x, $y),
        '/' => div($x, $y),
        '*' => multiply($x, $y),
        default => 'Неверный оператор'
    };
}


echo '<pre>';
echo calc(3,4, '+') . PHP_EOL;
echo calc(3,4, '-') . PHP_EOL;
echo calc(3,4, '/') . PHP_EOL;
echo calc(3,0, '/') . PHP_EOL;
echo calc(3,4, '*') . PHP_EOL;
echo calc(3,4, 'plus') . PHP_EOL;
echo '</pre>';
