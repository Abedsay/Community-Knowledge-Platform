<?php
class Post {
    private $conn;
    private $table_name = "posts";

    public $PostId;
    public $Title;
    public $Description;
    public $UserId;
    public $CreatedAt;
    public $UpdatedAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (Title, Description, UserId, CreatedAt) VALUES (:Title, :Description, :UserId, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":Title", $this->Title);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":UserId", $this->UserId);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY CreatedAt DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readSingle() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE PostId = :PostId LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->execute();
        return $stmt;
    }

    public function readByUser() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET Title = :Title, Description = :Description, UpdatedAt = NOW() WHERE PostId = :PostId";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":Title", $this->Title);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":PostId", $this->PostId);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE PostId = :PostId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        return $stmt->execute();
    }
}
?>
