<?php


class Employee
{

    private string $name;

    private int $age;

    private int $salary;

    public function setName(string $name): void
    {

        $this->name = $name;

    }

    public function getName(): string
    {

        return $this->name;

    }

    public function setAge(int $age): void
    {

        $this->age = $age;

    }

    public function getAge(): int
    {

        return $this->age;

    }

    public function setSalary(int $salary): void
    {

        $this->salary = $salary;

    }

    public function getSalary(): int
    {

        return $this->salary;

    }

    public static function whoIsOlder(Employee $employeeA, Employee $employeeB): string
    {

        if ($employeeA->getAge() > $employeeB->getAge()) {

            return $employeeA->getName() . " старше " . $employeeB->getName();

        } else if ($employeeA->getAge() < $employeeB->getAge()) {

            return $employeeB->getName() . " старше " . $employeeA->getName();

        } else {

            return $employeeB->getName() . " и " . $employeeA->getName() . " - ровесники";

        }

    }

    public static function getSalarySum(Employee $employeeA, Employee $employeeB): int
    {

        return $employeeA->getSalary() + $employeeB->getSalary();

    }

}

$oleg = new Employee();

$oleg->setName("Олег");

$oleg->setAge(25);

$oleg->setSalary(1000);

$mariya = new Employee();

$mariya->setName("Мария");

$mariya->setAge(26);

$mariya->setSalary(2000);

echo "Зарплата сотрудника: " . $oleg->getName() . ": " . $oleg->getSalary() . PHP_EOL;

echo "Зарплата сотрудника: " . $mariya->getName() . ": " . $mariya->getSalary() . PHP_EOL;

echo Employee::getSalarySum($oleg, $mariya) . PHP_EOL;

echo Employee::whoIsOlder($oleg, $mariya);