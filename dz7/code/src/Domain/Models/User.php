<?php

namespace Geekbrains\Application1\Domain\Models;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Infrastructure\Storage;
use Random\RandomException;

class User {

    private ?int $idUser;
    private ?string $userName;
    private ?string $userLastName;
    private ?int $userBirthday;
    private ?string $login;
    private ?string $passwordHash = null;
    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(
        int $idUser = null,
        string $login = null,
        string $name = null,
        string $lastName = null,
        int $birthday = null
    ) {
        $this->idUser = $idUser;
        $this->login = $login;
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
    }

//    ------ сеттеры ------
    public function setName(string $userName) : void {
        $this->userName = htmlspecialchars($userName);
    }
    public function setUserId(string $idUser) : void {
        $this->idUser = $idUser;
    }

    public function setLastName(string $userLastName) : void {
        $this->userLastName = htmlspecialchars($userLastName);
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    public function setPassword(string $password): void {
        $this->passwordHash = Auth::getPasswordHash($password);
    }

//    ---------- геттеры --------
    public function getUserName(): ?string {
        return $this->userName;
    }

    public function getUserLogin(): ?string {
        return $this->login;
    }


    public function getUserId(): ?int {
        return $this->idUser;
    }

    public function getUserLastName(): ?string {
        return $this->userLastName;
    }

    public function getUserBirthday(): ?int {
        return $this->userBirthday;
    }

    public function getPasswordHash(): ?string {
        return $this->passwordHash;
    }

//    ------------ база данных ------------
    public function saveToStorage(): void
    {
        $sql = "INSERT INTO users (
                   login,
                   user_name,
                   user_lastname,
                   user_birthday_timestamp,
                   password_hash)
                VALUES (
                    :user_login,
                    :user_name,
                    :user_lastname,
                    :user_birthday,
                    :password_hash)";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_login' => $this->login,
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday,
            'password_hash' => $this->passwordHash,
        ]);

        $this->idUser = (int) Application::$storage->get()->lastInsertId();
    }

    public static function exists(int $id): bool{
        $sql = "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id_user' => $id
        ]);

        $result = $handler->fetch(\PDO::FETCH_ASSOC);

        return ($result['user_count'] ?? 0) > 0;
    }

    public static function setToken(int $userID, string $token): void {
        $sql = "UPDATE users SET token = :token WHERE id_user = :id";


        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id' => $userID, 'token' => $token]);

        setcookie('auth_token', $token, time() + 60*60*24*30, '/');
    }

    public static function verifyToken(string $token): array {
        $sql = "SELECT * FROM users WHERE token = :token";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['token' => $token]);

        return $handler->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public static function deleteFromStorage(int $user_id) : void {
        $sql = "DELETE FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id_user' => $user_id]);
    }

    public static function getAllUsersFromStorage(): array {
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll(\PDO::FETCH_ASSOC);

        $users = [];

        foreach($result as $item){
            $user = new User(
                $item['id_user'],
                $item['login'],
                $item['user_name'],
                $item['user_lastname'],
                $item['user_birthday_timestamp']
            );

            $users[] = $user;
        }
        
        return $users;
    }

    public static function getUserRolesById(int $id): array {
        $roles = ['user'];

        $sql = "SELECT role FROM user_roles WHERE id_user = :id";
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id' => $id]);

        $result = $handler->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($result as $role) {
            $roles[] = $role['role'];
        }

        return $roles;
    }

    public static function validateRequestData(): bool{
        $result = true;
        
        if(!(
            !empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['birthday'])
        )){
            $result = false;
        }

        if(preg_match('/<([^>]+)>/', $_POST['name']) || preg_match('/<([^>]+)>/', $_POST['lastname'])){
            $result =  false;
        }

        if(!preg_match('/^(\d{2}-\d{2}-\d{4})$/', $_POST['birthday'])){
            $result =  false;
        }

        if(!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']){
            $result = false;
        }

        return $result;
    }

    public function setParamsFromRequestData(): void {
        $this->userName = htmlspecialchars($_POST['name']);
        $this->userLastName = htmlspecialchars($_POST['lastname']);
        $this->login = htmlspecialchars($_POST['login']);
        $this->setBirthdayFromString($_POST['birthday']);
        $this->setPassword($_POST['password']);
    }

    public static function getUserDataByID(int $userID): array {
        $userSql = "SELECT * FROM users WHERE id_user = :id";


        $handler = Application::$storage->get()->prepare($userSql);
        $handler->execute(['id' => $userID]);
        return $handler->fetch();
    }

    public function updateUser(array $userDataArray): void{
        $sql = "UPDATE users SET ";

        $counter = 0;
        foreach($userDataArray as $key => $value) {
            $sql .= $key ." = :".$key;

            if($counter != count($userDataArray)-1) {
                $sql .= ",";
            }

            $counter++;
        }
        $sql .= " WHERE id_user = " . $this->getUserId();


        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute($userDataArray);
    }

    /**
     * @throws RandomException
     */
    public static function destroyToken(): array {
        $userSql = "UPDATE users SET token = :token WHERE id_user = :id";

        $handler = Application::$storage->get()->prepare($userSql);
        $handler->execute(['token' => md5(bin2hex(random_bytes(16))), 'id' => $_SESSION['auth']['id_user']]);
        $result = $handler->fetchAll();

        return $result[0] ?? [];
    }
}