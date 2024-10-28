<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Models\Phone;
use Geekbrains\Application1\Render;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AboutController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function actionIndex() {
        $phone = (new Phone())->getPhone();
        $render = new Render();

        return $render->renderPage('about.twig', [
            'phone' => $phone
        ]);
    }
}