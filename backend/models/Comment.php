<?php
class Comment {
    private $conn;
    private $table_name = "comments";

    public $CommentId;
    public $Content;
    public $UserId;
    public $PostId;
    public $CreatedAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create Comment
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (Content, UserId, PostId, CreatedAt) VALUES (:Content, :UserId, :PostId, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":Content", $this->Content);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":PostId", $this->PostId);

        return $stmt->execute();
    }

    // Read Comments for a Post
    public function readByPost() {
        $query = "SELECT c.*, u.Username 
                  FROM " . $this->table_name . " c
                  LEFT JOIN users u ON c.UserId = u.UserId
                  WHERE c.PostId = :PostId
                  ORDER BY c.CreatedAt DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->execute();
        return $stmt;
    }

    // Delete Comment
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE CommentId = :CommentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CommentId", $this->CommentId);
        return $stmt->execute();
    }
}
?>
