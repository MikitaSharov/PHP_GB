<?php

namespace Geekbrains\Application1;

class Application {

    private const string APP_NAMESPACE = 'Geekbrains\Application1\Controllers\\';


    public function run() : string {

        $routeArray = explode('/', $_SERVER['REQUEST_URI']);

        if(isset($routeArray[1]) && $routeArray[1] != '') {
            $controllerName = $routeArray[1];
        }
        else{
            $controllerName = "page";
        }

        $controllerName1 = Application::APP_NAMESPACE . ucfirst($controllerName) . "Controller";

        if(class_exists($controllerName1)){
            // пытаемся вызвать метод
            if(isset($routeArray[2]) && $routeArray[2] != '') {
                $methodName = $routeArray[2];
            }
            else {
                $methodName = "index";
            }

            $methodName1 = "action" . ucfirst($methodName);

            if(method_exists($controllerName1, $methodName1)){
                $controllerInstance = new $controllerName1();
                //$method = $this->methodName;
                //return $controllerInstance->$method();
                return call_user_func_array(
                    [$controllerInstance, $methodName1],
                    []
                );
            }
            else {
                return "Метод не существует";
            }
        }
        else{
            header(404);
            header("HTTP/1.1 404 Not Found");
            header('Location: /404.html');
            die();
        }
    }
}