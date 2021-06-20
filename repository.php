<?php

interface StudentRepository {
    public function save(Student $student);
    public function remove(Student $student);
    public function getById($id);
    public function all();
    public function getByField($fieldValue);
}

class PostgreStudentRepository implements StudentRepository {

    protected $pdo;

    public function __construct(PDO $db) {
        $this->pdo = $db;
    }

    public function save(Student $student) {
        $stmt = $this->pdo->prepare("INSERT INTO Student (course, firstName, secondName, UNI, groupNumber) values(?,?,?,?,?)");
        $stmt->bindParam(1, $this->course, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->firstName, PDO::PARAM_STR, 50);
        $stmt->bindParam(3, $this->secondName, PDO::PARAM_INT, 50);
        $stmt->bindParam(4, $this->UNI, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $this->groupNumber, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function remove(Student $student) {
        $stmt = $this->pdo->prepare("Delete from phone where num = ?, naming = ?, imei = ? ");
        $stmt->bindParam(1, $this->course, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->firstName, PDO::PARAM_STR, 50);
        $stmt->bindParam(3, $this->secondName, PDO::PARAM_INT, 50);
        $stmt->bindParam(4, $this->UNI, PDO::PARAM_INT, 10);
        $stmt->bindParam(5, $this->groupNumber, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("Select * from Student where id = ? ");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Student($row['course'], $row['firstName'], $row['secondName'], $row['UNI'], $row['groupNumber']);
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT firstName,secondName,UNI FROM Student");
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('course' => $row['course'], 'firstName' => $row['firstName'], 'secondName' => $row['secondName'], 'UNI' => $row['UNI'], 'groupNumber' => $row['groupNumber']);
        }
        return $tableList;
    }

        public function getByField($fieldValue) {
            $stmt = $this->pdo->prepare("Select ? from Student ");
            $stmt->bindParam(1, $fieldValue, PDO::PARAM_INT);
            $stmt->execute();
            $tableList = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $tableList[] = array('course' => $row['course'], 'firstName' => $row['firstName'], 'secondName' => $row['secondName'], 'UNI' => $row['UNI'], 'groupNumber' => $row['groupNumber']);
            }
            return $tableList;
        }
}