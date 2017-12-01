<?php 

namespace Labs\Persistence;

use PDO;

$lite = new UserDao();
//$lite->execute();
//$lite->createTable();
$lite->buildAndSeed();
//echo count($lite->listUsers());
//$lite->dropTable();

class UserDao {

    private $conexao;

    public function __construct() {
        $this->conexao = new PDO("sqlite:test.db");
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$this->conexao = null;
    }

    public function createTable() {
        $sqlString = "CREATE TABLE IF NOT EXISTS `tbUsers` ";
        $sqlString.="(id INTEGER PRIMARY KEY AUTOINCREMENT, login TEXT, name TEXT, email TEXT, pwd TEXT, type TEXT, status TINYINT(1) );";
        $this->conexao->query($sqlString);
    }

    public function dropTable() {
        $sqlString = "DROP TABLE IF EXISTS `tbUsers` ";
        $this->conexao->query($sqlString);
    }

    public function dropDatabase() {
        unlink("test.db"); //destroy the database
    }

    public function buildAndSeed() {
        $this->createTable();
        if(count($this->listUsers())==0){
            $this->addnew("danilo","danilo batista de queiroz", "danilo.queiroz@gmail.com", '123', "admin" ,1);
        }
    }

    public function listUsers() {
        $sqlString = "SELECT * FROM `tbUsers` WHERE status=1";
        $consulta = $this->conexao->query($sqlString);
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sqlString = "SELECT * FROM `tbUsers` WHERE id=" . $id;
        $consulta = $this->conexao->query($sqlString);
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function getByLogin($login) {
        $statement = $this->conexao->prepare("select * from `tbUsers` where login = :login");
        $statement->execute(array(':login' => $login));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByName($name) {
        $sqlString = "SELECT * FROM `tbUsers` WHERE name=" . $name;
        $consulta = $this->conexao->query($sqlString);
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function addNew($login, $name, $email, $pwd, $type, $status) {
        $sqlString = "INSERT INTO `tbUsers` (login,name,email,pwd,type,status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sqlString);
        $stmt->bindParam(1, $login);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $pwd);
        $stmt->bindParam(5, $type);
        $stmt->bindParam(6, $status);
        $stmt->execute();
        return $this->conexao;
    }

}