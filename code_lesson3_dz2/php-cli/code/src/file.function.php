<?php
require_once 'validate.php';
function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

function addFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");

    do {
        $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");
        $validDate = validateDateOfBirth($date);
    } while (!$validDate);

    $data = "$name, $date" . PHP_EOL;

    $fileHandler = fopen($address, 'a');

    if(fwrite($fileHandler, $data)){
        fclose($fileHandler);
        return "Запись $data добавлена в файл $address"; 
    }

    fclose($fileHandler);
    return handleError("Произошла ошибка записи. Данные не сохранены");
}

// function clearFunction(string $address) : string {
function clearFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        
        fwrite($file, '');
        
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

function helpFunction() {
    return handleHelp();
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }

    $files = scandir($profilesDirectoryAddress);

    $result = "";

    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
                continue;
            
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }

    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . $_SERVER['argv'][2] . ".json";

    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";

    return $info;
}

function birthdayToday(array $config): string
{
    $path = $config['storage']['address'];
    $today = date("d-m");
    $file = fopen($path, "r");
    $birthday_today = '';

    if ($file) {
        while (($line = fgets($file)) !== false) {
            $array_line = explode(", ", trim($line));

            if (count($array_line) === 2) {
                list($name, $birthDate) = $array_line;
                $birthDateArray = explode("-", $birthDate);

                if (count($birthDateArray) === 3) {
                    $birthDayMonth = "$birthDateArray[0]-$birthDateArray[1]";

                    if ($birthDayMonth === $today) {
                        $birthday_today .= $name . PHP_EOL;
                    }
                }
            }
        }

        fclose($file);
    } else {
        echo 'Не удалось открыть файл';
    }

    return $birthday_today !== '' ? $birthday_today : 'сегодня нет ДР';
}

function deleteLine(array $config): string {
    $path = $config['storage']['address'];
    $tempFilePath = $path . '.tmp';

    $file = fopen($path, 'r');
    $tempFile = fopen($tempFilePath, 'w');

    if (!$file || !$tempFile) {
        return 'Не удалось открыть файл.';
    }

    $strSearch = readline('Введите имя или дату для удаления: ');
    $found = false;

    while (($line = fgets($file)) !== false) {
        list($name, $date) = explode(', ', trim($line));

        if ($name !== $strSearch && $date !== $strSearch) {
            fwrite($tempFile, $line);
        } else {
            $found = true;
        }
    }

    fclose($file);
    fclose($tempFile);

    if ($found) {
        rename($tempFilePath, $path);
        return "Строка с $strSearch успешно удалена.";
    } else {
        unlink($tempFilePath); // Удаляем временный файл, если строка не найдена
        return "Строка с $strSearch не найдена.";
    }
}
