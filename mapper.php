<?php

class Student {
    private $course;
    private $firstName;
    private $secondName;
    private $UNI;
    private $groupNumber;

    public function __construct($course, $firstName, $secondName, $UNI, $groupNumber) {
        $this->course = $course;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->UNI = $UNI;
        $this->groupNumber = $groupNumber;
    }

    public function getCourse() {
        return $this->course;
    }

    public function getfirstName() {
        return $this->firstName;
    }

    public function getsecondName() {
        return $this->secondName;
    }

    public function getUNI() {
        return $this->UNI;
    }

    public function getgroupNumber() {
        return $this->groupNumber;
    }
}

class DataMapper {
    protected $pdo;

    public function __construct(PDO $db) {
        $this->pdo = $db;
    }

    public function save(Student $student) : bool {
        $stmt = $this->pdo->prepare("INSERT INTO Student (course, firstName, secondName, UNI, groupNumber) values(?,?,?,?,?)");
        $stmt->bindParam(1, $this->course, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->firstName, PDO::PARAM_STR, 50);
        $stmt->bindParam(3, $this->secondName, PDO::PARAM_INT, 50);
        $stmt->bindParam(4, $this->UNI, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $this->groupNumber, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function remove($student) {
        $stmt = $this->pdo->prepare("Delete from Student where course = ?, firstName = ?, secondName = ?, UNI = ?, groupNumber = ? ");
        $stmt->bindParam(1, $student->course, PDO::PARAM_INT);
        $stmt->bindParam(2, $student->firstName, PDO::PARAM_STR, 50);
        $stmt->bindParam(3, $student->secondName, PDO::PARAM_INT, 50);
        $stmt->bindParam(4, $student->UNI, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $student->groupNumber, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getById($id): Student {
        $stmt = $this->pdo->prepare("Select * from Student where id = ? ");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Student($row['course'],$row['firstName'],$row['secondName'], $row['UNI'], $row['groupNumber']);
    }
    public function all(): array {
        $stmt = $this->pdo->query("SELECT firstName,secondName,UNI FROM Student");
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('course'=>$row['course'], 'firstName'=>$row['firstName'], 'secondName'=>$row['secondName'], 'UNI'=>$row['UNI'],'groupNumber'=>$row['groupNumber']);
        }
        return $tableList;
    }
    public function getByField($fieldValue): array {
        $stmt = $this->pdo->prepare("Select ? from Student ");
        $stmt->bindParam(1, $fieldValue, PDO::PARAM_INT);
        $stmt->execute();
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('course'=>$row['course'], 'firstName'=>$row['firstName'], 'secondName'=>$row['secondName'], 'UNI'=>$row['UNI'],'groupNumber'=>$row['groupNumber']);
        }
        return $tableList;
    }

}