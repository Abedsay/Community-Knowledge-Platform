<?php
class Vote {
    private $conn;
    private $table_name = "votes";

    public $VoteId;
    public $UserId;
    public $PostId;
    public $VoteType;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create Vote
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (UserId, PostId, VoteType) VALUES (:UserId, :PostId, :VoteType)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":VoteType", $this->VoteType);

        return $stmt->execute();
    }

    // Get Votes for a Post
    public function readByPost() {
        $query = "SELECT VoteType, COUNT(*) as count FROM " . $this->table_name . " WHERE PostId = :PostId GROUP BY VoteType";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->execute();
        return $stmt;
    }

    // Delete Vote
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE VoteId = :VoteId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":VoteId", $this->VoteId);
        return $stmt->execute();
    }
    public function getVoteCount() {
        $query = "SELECT 
                    SUM(CASE WHEN VoteType = 'upvote' THEN 1 ELSE 0 END) - 
                    SUM(CASE WHEN VoteType = 'downvote' THEN 1 ELSE 0 END) AS totalVotes 
                  FROM votes 
                  WHERE PostId = :PostId";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['totalVotes'] : 0;
    }
    
}
?>
