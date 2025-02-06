<?php
class PostCategory {
    private $conn;
    private $table_name = "postcategories";

    public $PostId;
    public $CategoryId;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Assign Category to Post
    public function assignCategory() {
        $query = "INSERT INTO " . $this->table_name . " (PostId, CategoryId) VALUES (:PostId, :CategoryId)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":CategoryId", $this->CategoryId);

        return $stmt->execute();
    }

    // Get Categories for a Post
    public function getCategoriesByPost() {
        $query = "SELECT categories.CategoryId, categories.CategoryName FROM " . $this->table_name . "
                  INNER JOIN categories ON postcategories.CategoryId = categories.CategoryId
                  WHERE postcategories.PostId = :PostId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->execute();
        return $stmt;
    }
}
?>
