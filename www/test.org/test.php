<?php
echo "ООП<br>";

/*
class User {
  //public $name;
  //public $pass;
  //public $email;
  //public $city;
  private static $name;
  public static function setname($name1) {
      self::$name = $name1;
  }
  public static function getname() {
      return self::$name;
  }

}

User::setname("ISHUNIN");
echo User::getname();
*/

   
//$myobj = new User("Dmiry","Ishunin","pass","Saransk");

//$str = $myobj->getinfo();
//echo $str;

/*

class myclass{
    public $name;
    public $pass;
    public $email;
    public $city;

    function __construct($name,$pass,$email,$city) {
        $this->name=$name;
        $this->pass=$pass;
        $this->email=$email;
        $this->city=$city;

    }
    function getinfo (){
        $info = $this->name."  ".$this->pass." ".$this->email." ".$this->city;
        return $info;
    }

  //  function __destruct()
    //{
      //  print "Деструктор $this->name";

    //}
}

$obj = new myclass("dmitry","pass","asd@mail.ru","saransk");
//echo $obj->getinfo();
class myclass2 extends myclass {
    public $info;
    public $rights;
    function __construct($name,$pass,$email,$city,$info,$rights){
        parent::__construct($name,$pass,$email,$city);
        $this->info=$info;
        $this->rights=$rights;
    }
        function getinfo (){
            $information = parent::getinfo();
            $information .= "$this->info"."$this->rights";
            return $information;
        }
        function setname(){
            $this->name="NAME+CHANGED";
        }

    
}

$obj2 = new myclass2("dmitry_moderator","pass","asd@mail.ru","saransk","Модератор","Полные права");
$obj2->name="changed";
echo "<br>".$obj2->getinfo();
*/
/*
abstract class myclass {
    public $name;
    public $status;
    abstract public function getstatus();
}

class admin extends myclass {
    public function getstatus() {
        echo "ADMIN";
    }

}
$obj = new admin;
$obj->getstatus();
*/

/*
interface FirstInterface {
    public function getname();
}
interface SecondInterface {
    public function getsurname();
}

interface ThirdInterface extends FirstInterface, SecondInterface {
    public function getage();
}

class myclass implements ThirdInterface {
    public $name = "dmitry";
    public $surnname = "ishunin";
    public $age = 30;

    public function getname(){
        echo $this->name;
    }
    public function getsurname(){
        echo $this->surnname;
    }

    public function getage(){
        echo $this->age;
    }


}

$obj = new myclass;
$obj->getage();
*/

/*
class base{
    public function sayhello(){
        echo "Hello ";
    }
    public function sayhello2(){
        echo "dog ";
    }

}


class base2{
    public function sayhello(){
        echo "byby ";
    }
    public function sayhello2(){
        echo "ZXCy ";
    }
}

trait sayworld {
    public function sayhello(){
        parent::sayhello();
        echo "World";
    }
}

trait saydog {
    public function sayhello2(){
        parent::sayhello2();
        echo "animal";
    }
}

class myclass extends base {
    use sayworld, saydog;
}
$obj = new myclass;
$obj->sayhello2();
echo "<br>";
*/
/*
trait sayhello {
    public function sayhello (){
        echo "hello";
    }
}

trait sayworld {
    public function sayworld(){
        echo "World";
    }
}

class myclass{
use sayhello, sayworld;
}

$obj = new myclass;

$obj->sayhello();
$obj->sayworld();
*/

/*
class user {
    private $name;
    private $city;
    private $id;
    function __construct($name,$city){
        $this->name=$name;
        $this->city=$city;
    }
    function setid($id){
        $this->id=$id;
    }

    public function __clone(){
        $this->id=0;
       
    }
}

$obj = new user("dmitry","saransk");
$obj->setid(100);

$obj2=clone $obj;

var_dump($obj2);
//var_dump($obj2);

*/
//писать  и читать в приватные свойства
/*
class GetSet {
    private $num = 1;
    protected $num2 = 2;


    public function __get($name){
       if (property_exists($this,$name)){
           echo $name;
           echo $this->$name;
       }
       else{
           echo "Нет такого свойства";
       }
    }

    public function __set($property, $value)
    {
      if (property_exists($this, $property)) {
        $this->$property = $value;
      }
    }

    public function  __isset($property){
    return isset($this->$property);
    }

    
}
$obj = new GetSet();
//$obj->num;
//$obj->num = 666;
//$obj->num;
echo (isset($obj->num));
*/

//исключения
$file = 'test2.php';

try{
    if (!file_exists($file)) {
        throw new Exception('file not found<br>');
    }
    if (1==1) {
        throw new Exception("ОШИБКА<br>");
    }
}
catch(Exception $e){
    echo $e->getMessage();
}

?>