<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;
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
    public function actionIndex(): string
    {
        $message = $_SESSION['message'] ?? null;
        unset($_SESSION['message']);

        $users = User::getAllUsersFromStorage();
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => $message ?? "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users,
                    'message' => $message
                ]);
        }
    }

    #[NoReturn] public function actionSave(): void
    {
        // Получаем данные пользователя через GET-параметры
        $name = $_GET['name'] ?? '';
        $birthday = $_GET['birthday'] ?? '';

        if ($name && $birthday) {
            $user = new User();
            $user->setName($name);
            $user->setBirthdayFromString($birthday);

            if ($user->saveToStorage()) {
                $_SESSION['message'] = "Пользователь $name успешно добавлен!";
            } else {
                $_SESSION['message'] = "Ошибка при сохранении пользователя!";
            }
        }

        header("Location: /user");
        exit;
    }
}