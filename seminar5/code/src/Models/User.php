<?php

namespace Geekbrains\Application1\Models;

class User {

    private ?string $userName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, int $birthday = null){
        $this->userName = $name;
        $this->userBirthday = $birthday;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString): void {
        $timestamp = strtotime($birthdayString);

        if ($timestamp !== false) {
            $this->userBirthday = $timestamp;
        }
    }

    public static function getAllUsersFromStorage(): array|false {
        $address = $_SERVER['DOCUMENT_ROOT'] . User::$storageAddress;

        if (file_exists($address) && is_readable($address)) {
            $file = fopen($address, "r");

            $users = [];

            while (!feof($file)) {
                $userString = trim(fgets($file));
                if ($userString === "") continue; // Пропускаем пустые строки

                $userArray = explode(", ", $userString);
                if (count($userArray) < 2) continue; // Пропускаем строки с некорректным форматом

                $user = new User($userArray[0]);
                $user->setBirthdayFromString($userArray[1]);

                $users[] = $user;
            }

            fclose($file);

            return $users;
        }

        return false;
    }

    public function saveToStorage(): bool {
        $address = $_SERVER['DOCUMENT_ROOT'] . self::$storageAddress;
        $dataString = $this->userName . ', ' . date('Y-m-d', $this->userBirthday) . PHP_EOL;

        return file_put_contents($address, $dataString, FILE_APPEND | LOCK_EX) !== false;
    }
}
