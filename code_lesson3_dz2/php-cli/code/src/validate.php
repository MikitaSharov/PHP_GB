<?php

function validateDateOfBirth(string $date): bool
{
    $date_array = explode('-', $date);

    if (count($date_array) !== 3) {
        echo "Неверный формат даты. Попробуйте снова.\n";
        return false;
    }

    list($day, $month, $year) = $date_array;
    if (!ctype_digit($day) || !ctype_digit($month) || !ctype_digit($year)) {
        echo "Вводить надо цифры. Попробуйте снова.\n";
        return false;
    }

    $day = (int)$day;
    $month = (int)$month;
    $year = (int)$year;

    $currentYear = (int)date('Y');
    $minYear = $currentYear - 150;

    if ($year < $minYear || $year > $currentYear) {
        echo "Вам не может быть больше 150 лет или вы ещё не родились. Попробуйте снова.\n";
        return false;
    }

    if (!checkdate($month, $day, $year)) {
        echo "Такой даты не существует. Попробуйте снова.\n";
        return false;
    }

    return true;
}