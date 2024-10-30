<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Exception;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;
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
        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]);
        }
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function actionSave(): string {
        if(User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->saveToStorage();

            $render = new Render();

            return $render->renderPage(
                'user-created.tpl', 
                [
                    'title' => 'Пользователь создан',
                    'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]);
        }
        else {
            throw new Exception("Переданные данные некорректны");
        }
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function actionUpdate(): string {
        if(User::exists($_GET['id'])) {
            $user = new User();
            $user->setUserId($_GET['id']);
            
            $arrayData = [];

            if(isset($_GET['name']))
                $arrayData['user_name'] = $_GET['name'];

            if(isset($_GET['lastname'])) {
                $arrayData['user_lastname'] = $_GET['lastname'];
            }
            
            $user->updateUser($arrayData);
        }
        else {
            throw new Exception("Пользователь не существует");
        }

        $render = new Render();
        return $render->renderPage(
            'user-created.tpl', 
            [
                'title' => 'Пользователь обновлен',
                'message' => "Обновлен пользователь " . $user->getUserId()
            ]);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * @throws Exception
     */
    public function actionDelete(): string {
        if(User::exists($_GET['id'])) {
            User::deleteFromStorage($_GET['id']);

            $render = new Render();
            
            return $render->renderPage(
                'user-removed.tpl', []
            );
        }
        else {
            throw new Exception("Пользователь не существует");
        }
    }

    
}