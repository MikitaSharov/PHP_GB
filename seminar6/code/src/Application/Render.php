<?php

namespace Geekbrains\Application1\Application;

use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Render {

    private string $viewFolder = '/src/Domain/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;


    public function __construct(){
        $this->loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
//            'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function renderPage(string $contentTemplateName = 'page-index.tpl', array $templateVariables = []): string
    {
        $template = $this->environment->load('main.tpl');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
 
        return $template->render($templateVariables);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public static function renderExceptionPage(Exception $exception): string {
        $contentTemplateName = "error.tpl";
        $viewFolder = '/src/Domain/Views/';

        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $viewFolder);
        $environment = new Environment($loader, [
            'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);

        $template = $environment->load('main.tpl');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['error_message'] = $exception->getMessage();
 
        return $template->render($templateVariables);
    }
}