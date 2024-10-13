<?php

$alphabet = [
    'а' => 'a', 'б' => 'b', 'в' => 'v',
    'г' => 'g', 'д' => 'd', 'е' => 'e',
    'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
    'и' => 'i', 'й' => 'j', 'к' => 'k',
    'л' => 'l', 'м' => 'm', 'н' => 'n',
    'о' => 'o', 'п' => 'p', 'р' => 'r',
    'с' => 's', 'т' => 't', 'у' => 'u',
    'ф' => 'f', 'х' => 'h', 'ц' => 'c',
    'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
    'ъ' => '"','ы' => 'y','ь' => '\'',
    'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
];


function translit(string $str): string
{
    $result = '';
    global $alphabet;

    foreach (mb_str_split($str) as $ch) {
        if (array_key_exists($lowedChar = mb_strtolower($ch), $alphabet)){
            if ($ch === $lowedChar) {
                $translitedChar = $alphabet[$ch];
            } else {
                $translitedChar = ucfirst($alphabet[$lowedChar]);
            }
        } else {
            $translitedChar = $ch;
        }

        $result .= $translitedChar;
    }

    return $result;
}

echo translit('Привет мир, удачи ь ъ - щЩ Я!');


