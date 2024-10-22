<?php
/*
//Композиция
class Engine {}
class Car {
    private Engine $engine;
    public function __construct()
    {
        $this->engine = new Engine;
    }
}
$car = new Car();
*/
//Композиция
class Engine {}
class Engine2 extends Engine {}
class Audio {}
class Page {}
class Car {
    private Engine $engine;
    public array $option = [];
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }
}
$car = new Car(new Engine2());
$car->option[] = new Audio();
$car->option[] = new Page();