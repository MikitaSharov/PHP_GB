<?php

namespace Geekbrains\Application1\Domain\Models;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Infrastructure\Storage;

class User {

    private ?int $idUser;

    private ?string $userName;

    private ?string $userLastName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, string $lastName = null, int $birthday = null, int $id_user = null){
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
        $this->idUser = $id_user;
    }

    public function setUserId(int $id_user): void {
        $this->idUser = $id_user;
    }

    public function getUserId(): ?int {
        return $this->idUser;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function setLastName(string $userLastName) : void {
        $this->userLastName = $userLastName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserLastName(): string {
        return $this->userLastName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    public static function getUserById(int $id): ?User {
        // SQL-запрос для получения пользователя по ID
        $sql = "SELECT * FROM users WHERE id_user = :id_user";

        // Подготовка и выполнение запроса
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id_user' => $id]);
        $result = $handler->fetch();

        // Проверка, был ли пользователь найден
        if ($result) {
            // Создание и возвращение объекта User с данными из базы
            return new User(
                $result['user_name'] ?? null,
                $result['user_lastname'] ?? null,
                $result['user_birthday_timestamp'] ?? null,
                $result['id_user']
            );
        }

        // Возвращаем null, если пользователь не найден
        return null;
    }

    public static function getAllUsersFromStorage(): array {
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll();

        $users = [];

        foreach($result as $item){
            $user = new User($item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp'], $item['id_user']);
            $users[] = $user;
        }
        
        return $users;
    }

    public static function validateRequestData(): bool{
        if(
            !empty($_GET['name']) &&
            !empty($_GET['lastname']) &&
            !empty($_GET['birthday'])
        ){
            return true;
        }
        else{
            return false;
        }
    }

    public function setParamsFromRequestData(): void {
        $this->userName = $_GET['name'];
        $this->userLastName = $_GET['lastname'];
        $this->setBirthdayFromString($_GET['birthday']); 
    }

    public function saveToStorage(): bool
    {
        $sql = "INSERT INTO users(user_name, user_lastname, user_birthday_timestamp) VALUES (:user_name, :user_lastname, :user_birthday)";

        $handler = Application::$storage->get()->prepare($sql);
        return $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }

    public static function exists(int $id): bool{
        $sql = "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id_user' => $id
        ]);

        $result = $handler->fetchAll();

        if(count($result) > 0 && $result[0]['user_count'] > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function updateUser(array $userDataArray): void {
        // Убедитесь, что id_user не включён в обновляемые данные
        if (isset($userDataArray['id_user'])) {
            unset($userDataArray['id_user']);
        }

        $sql = "UPDATE users SET ";

        $counter = 0;
        foreach ($userDataArray as $key => $value) {
            $sql .= $key . " = :" . $key;
            if ($counter != count($userDataArray) - 1) {
                $sql .= ", ";
            }
            $counter++;
        }

        // Добавляем условие WHERE для обновления конкретного пользователя
        $sql .= " WHERE id_user = :id_user";

        // Добавляем id_user в параметры запроса
        $userDataArray['id_user'] = $this->idUser;

        // Подготовка и выполнение запроса
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute($userDataArray);
    }


    public static function deleteFromStorage(int $user_id) : bool {
        $sql = "DELETE FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        return $handler->execute(['id_user' => $user_id]);
    }
}