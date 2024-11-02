<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Exception;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;
use JetBrains\PhpStorm\NoReturn;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserController {

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function actionIndex(): string {
        $message = $_SESSION['message'] ?? null;
        unset($_SESSION['message']);

        $users = User::getAllUsersFromStorage();
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => $message ?? "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users,
                    'message' => $message
                ]);
        }
    }

    #[NoReturn] public function actionSave(): void {
        if(User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();

            if ($user->saveToStorage()) {
                $_SESSION['message'] = "Пользователь {$user->getUserName()} успешно добавлен!";
            } else {
                $_SESSION['message'] = "Ошибка при сохранении пользователя!";
            }
        }
        else {
            $_SESSION['message'] = "Переданные данные некорректны";
        }

        header("Location: /user");
        exit;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function actionUpdate(): string {
        if (!isset($_GET['id']) || !User::exists($_GET['id'])) {
            throw new Exception("Пользователь не существует");
        }

        $userId = (int)$_GET['id'];
        $user = User::getUserById($userId);

        if ($user === null) {
            throw new Exception("Пользователь не найден");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Массив для обновления данных пользователя
            $arrayData = [
                'id_user' => $userId
            ];

            if (!empty($_POST['name'])) {
                $arrayData['user_name'] = $_POST['name'];
                $user->setName($_POST['name']);
            }

            if (!empty($_POST['lastname'])) {
                $arrayData['user_lastname'] = $_POST['lastname'];
                $user->setLastName($_POST['lastname']);
            }

            // Здесь можно добавить обработку даты рождения
            if (!empty($_POST['birthday'])) {
                $user->setBirthdayFromString($_POST['birthday']);
                $arrayData['user_birthday_timestamp'] = $user->getUserBirthday();
            }

            // Обновляем пользователя в базе данных
            $user->updateUser($arrayData);

            // Сообщение об успешном обновлении
            $_SESSION['message'] = "Пользователь {$user->getUserName()} успешно обновлён!";
            header("Location: /user");
            exit;
        }

        // Рендерим страницу редактирования пользователя
        $render = new Render();
        return $render->renderPage(
            'user-edit.tpl',
            [
                'title' => 'Редактирование пользователя',
                'user' => $user
            ]
        );
    }


    public function actionDelete(): void {
        if(User::exists($_GET['id'])) {
            if(User::deleteFromStorage($_GET['id'])){
                $_SESSION['message'] = "Пользователь успешно удалён!";
            } else {
                $_SESSION['message'] = "Ошибка при удалении пользователя!";
            }
        }
        else {
            $_SESSION['message'] = "Пользователя с таким id не существует!";
        }

        header("Location: /user");
        exit;
    }
}