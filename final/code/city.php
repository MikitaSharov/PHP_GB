<?php

$regions = [
    'Минская' => ['Минск', 'Логойск', 'Дзержинск'],
    'Гродненская' => ['Гродно', 'Лида', 'Скидель'],
    'Витебская' => ['Витебск', 'Орша']
];

foreach ($regions as $region => $cities) {
    $result = $region . ': ';
    foreach ($cities as $city) {
        $result .= $city . ', ';
    }

    echo '<pre>';
    echo substr($result, 0, -2) . PHP_EOL;
    echo '</pre>';
}

