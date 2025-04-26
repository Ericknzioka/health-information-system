<?php
require_once 'config.php';

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function getLastInsertId() {
        return $this->conn->insert_id;
    }
}

// Create a global database instance
$db = new Database();
// For compatibility with your functions.php that's using mysqli directly
$conn = $db->getConnection();
?>