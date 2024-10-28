<?php

namespace Geekbrains\Application1\Controllers;
use Geekbrains\Application1\Render;
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
        
        return $render->renderPage('content.twig', [
            'title' => 'Главная страница',
            'timeNow' => date('H:i')
            ]);
    }
}