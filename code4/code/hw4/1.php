<?php

class Room {
    public string $roomName;
    public array $bookShelfs;

    /**
     * @param string $roomName
     * @param BookShelf ...$bookShelfs
     */
    public function __construct(string $roomName, BookShelf ...$bookShelfs)
    {
        $this->roomName = $roomName;
        $this->bookShelfs = $bookShelfs;
    }

    public function findBook(Book $book): ?BookShelf
    {
        foreach ($this->bookShelfs as $bookShelf) {
            if (in_array($book, $bookShelf->books, true)) {
                return $bookShelf;
            }
        }

        return null;
    }
}

class BookShelf {
    public string $bookShelfName;
    public array $books;

    /**
     * @param string $bookShelfName
     * @param Book ...$books
     */
    public function __construct(string $bookShelfName, Book ...$books)
    {
        $this->bookShelfName = $bookShelfName;
        $this->books = $books ?: [];
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function setBooks(Book ...$books): string
    {
        foreach ($books as $book) {
            $this->books[] = $book;
        }

        return "Книги добавлены в шкаф {$this->bookShelfName}";
    }

}

abstract class Book {
    public string $bookName;
    public string $bookAuthor;
    public string $genre;
    public int $readCount;

    /**
     * @param string $bookName
     * @param string $bookAuthor
     * @param string $genre
     */
    public function __construct(string $bookName, string $bookAuthor, string $genre)
    {
        $this->bookName = $bookName;
        $this->bookAuthor = $bookAuthor;
        $this->genre = $genre;
        $this->readCount = 0;
    }

    abstract function giveBook(Room $room);
}

class RealBook extends Book {
    static bool $isIssued = false;

    function giveBook(Room $room): string
    {
        $bookAddress = $room->findBook($this);
        if ($bookAddress) {
            self::$isIssued = true;
            $this->readCount++;
            return "Книга {$this->bookName} находиться в {$room->roomName} на полке {$bookAddress->bookShelfName}";
        }
        else {
            return "Книга {$this->bookName} не найдена в {$room->roomName}";
        }
    }
}

class DigitalBook extends Book {
    private string $url;

    /**
     * @param string $bookName
     * @param string $bookAuthor
     * @param string $genre
     * @param string $url
     */
    public function __construct(string $bookName, string $bookAuthor, string $genre, string $url)
    {
        parent::__construct($bookName, $bookAuthor, $genre);
        $this->url = $url;
    }

    function giveBook(Room $room): string
    {
        $this->readCount++;
        return "Ссылка" . $this->url;
    }
}

$book1 = new RealBook('Буратино', 'Алексей Толстой', 'сказка');
$book2 = new RealBook('Незнайка', 'Носов', 'сказка');
$book3 = new DigitalBook('Пинокио', 'Родари', 'сказка', 'https://google.com');
$book4 = new RealBook('Дюймовочка', 'Андерсон', 'сказка');
$book5 = new RealBook('Снежная королева', 'Андерсон', 'сказка');

$shelf1 = new BookShelf('А - К', $book4);
$shelf1->setBooks($book5);
print_r($shelf1->getBooks());
$shelf2 = new BookShelf('Л - Я', $book1, $book2);
$shelf3 = new BookShelf('сказки', $book3);



$realLibrary = new Room('Детская библиотека', $shelf1, $shelf2);
$virtualLibrary = new Room('Виртуальная бибдиотека', $shelf3);

echo $book1->giveBook($realLibrary) . PHP_EOL;
echo $book1->readCount . PHP_EOL . $book1::$isIssued . PHP_EOL;

echo $book3->giveBook($realLibrary) . PHP_EOL;
echo $book3->giveBook($virtualLibrary) . PHP_EOL;
echo $book3->readCount . PHP_EOL;

class A {
    public function foo(): void
    {
        static $x = 0;
        echo ++$x;
    }
}
class B extends A {
}
$a1 = new A();
$b1 = new B();
$a1->foo();
$b1->foo();
$a1->foo();
$b1->foo();

