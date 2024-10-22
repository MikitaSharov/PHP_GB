<?php

abstract class Person {
    protected string $name;
    protected array $access = [];
    protected static string $writableName = "Персона"; 
  
    public function __construct(string $name, array $access = []) {
      $this->name = $name;
      $this->access = $access;
    }
  
    public final function checkAccess(string $room) {
      return in_array($room, $this->access);
    }

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) : void {
        if($this->validateName($name)) {
            $this->name = $name;
        }
    }

    abstract public function goToLunch() : string;
    
    public function whoAmI() : string {
        return "Я – " . static::$writableName;
    }    
}

class Teacher extends Person {
    protected static string $writableName = "Учитель"; 

    public function __construct(string $name) {
        parent::__construct($name, ['classroom', 'teachersroom']);
    }

    public function guideLecture() {
    }

    public function goToLunch() : string {
        return "Учитель любит ходить в диетическую столовую";
    }
}

class Student extends Person {
    protected static string $writableName = "Студент"; 

    public function __construct(string $name) {
        parent::__construct($name, ['classroom']);
    }

    public function goToLunch() : string {
        return "Студенту важна экономия!";
    }    
}

/*
$student = new Student("Иван");
$teacher = new Teacher("Ольга");

var_dump($student->checkAccess('teachersroom')); // false
var_dump($teacher->checkAccess('teachersroom')); // true

$persons = [
    new Person("Иван"),
    new Student("Олег"),
    new Teacher("Мария"),
    new Object()
];

foreach ($persons as $person) {
    if($person instanceof Person) {
        echo $person->goToLunch();
    }
}*/

$student = new Student("Иван");
$teacher = new Teacher("Ольга");

var_dump($student->whoAmI());
var_dump($teacher->whoAmI());
