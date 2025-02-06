<?php
class User {
    private $conn;
    private $table_name = "users";

    public $UserId;
    public $Username;
    public $Email;
    public $Password;
    public $RoleId;
    public $ReputationPoints;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create User (Register)
    public function create() {
        // Check if the email already exists
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE Email = :Email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Email", $this->Email);
        $stmt->execute();
    
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(["message" => "Email already exists."]);
            exit(); // ✅ Ensure execution stops completely
        }
    
        // Insert new user
        $query = "INSERT INTO " . $this->table_name . " (Username, Email, Password, RoleId, ReputationPoints) VALUES (:Username, :Email, :Password, :RoleId, 0)";
        $stmt = $this->conn->prepare($query);
    
        $hashedPassword = password_hash($this->Password, PASSWORD_BCRYPT);
        $stmt->bindParam(":Username", $this->Username);
        $stmt->bindParam(":Email", $this->Email);
        $stmt->bindParam(":Password", $hashedPassword);
        $stmt->bindParam(":RoleId", $this->RoleId);
    
        if ($stmt->execute()) {
            echo json_encode(["message" => "User created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create user."]);
        }
        exit(); // ✅ Ensure nothing runs after this
    }    

    // Read Users
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read Single User
    public function readSingle() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId = :UserId LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->execute();
        return $stmt;
    }

    // Update User
    public function update() {
        // Check if the user exists
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->execute();
    
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(["message" => "User does not exist."]);
            exit();
        }
    
        // Proceed with update if the user exists
        $query = "UPDATE " . $this->table_name . " SET Username = :Username, Email = :Email, RoleId = :RoleId WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":Username", $this->Username);
        $stmt->bindParam(":Email", $this->Email);
        $stmt->bindParam(":RoleId", $this->RoleId);
        $stmt->bindParam(":UserId", $this->UserId);
    
        if ($stmt->execute()) {
            echo json_encode(["message" => "User updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update user."]);
        }
        exit();
    }
    

    // Delete User
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT UserId, Password FROM users WHERE Email = :email"; 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->Email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // 🔴 Debugging: Check what is retrieved
            error_log("Retrieved password: " . $row['Password']);
            error_log("Entered password: " . $this->Password);
    
            // 🔴 Check if passwords match (ensure it's plain text OR hash check)
            if (password_verify($this->Password, $row['Password'])) {  
                // ✅ Generate a simple token (Use JWT in real applications)
                $token = bin2hex(random_bytes(16));
    
                return [
                    "token" => $token,
                    "userId" => $row['UserId']
                ];
            } else {
                return null; // Password is incorrect
            }
        }
        return null; // No user found
    }    
  
}
?>
