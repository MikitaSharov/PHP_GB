<?php
 
 class Student {
    public string $name;
    public int $age;
    public static float $discount = 0.5;
    
    function __construct(string $name, int $age) {
      $this->name = $name;
      $this->age = $age;
    }
    
    function sayHello(): string {
      return "Привет! Меня зовут {$this->name} и мне {$this->age} лет. \r\n";
    }

    public static function getDiscount(float $mealPrice): float {
      return $mealPrice * Student::$discount;
  }
  
  }

$students = [
    new Student("Ольга", 20),
    new Student("Иван", 18)
];

foreach($students as $student) {
    echo $student->sayHello();  
}

echo Student::getDiscount(50);
  