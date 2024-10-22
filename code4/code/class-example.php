<?php



class Person {
    protected string $name;
    protected static string $writableName = "Персона";
    protected array $access;


    public function __construct(string $name, array $access = []) {
      $this->name = $name;
      $this->access = $access;
    }


    public final function checkAccess(string $room) {
      return in_array($room, $this->access);
    }

    public function goToLunch() : string {
      return "Просто кто-то идет пообедать";
    }

    public function whoAmI() : string {
        return "Я – " . static::$writableName;
    }
}
  
class Teacher extends Person {
    protected static string $writableName = "Учитель";

    public function __construct(string $name) {
        parent::__construct($name, ['classroom', 'teachersroom']);
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

$student = new Student("Иван");
$teacher = new Teacher("Ольга");


var_dump($student->whoAmI());
var_dump($teacher->whoAmI());