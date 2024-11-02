<?php

namespace Geekbrains\Application1\Domain\Controllers;
use Geekbrains\Application1\Application\Render;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PageController {

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function actionIndex(): string
    {
        $render = new Render();
        
        return $render->renderPage('page-index.tpl', [
            'title' => 'Главная страница',
            'timeNow' => date('H:i')
        ]);
    }
}