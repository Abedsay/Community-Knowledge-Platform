<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public $CategoryId;
    public $CategoryName;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (CategoryName) VALUES (:CategoryName)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CategoryName", $this->CategoryName);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE CategoryId = :CategoryId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CategoryId", $this->CategoryId);
        return $stmt->execute();
    }
}
?>
