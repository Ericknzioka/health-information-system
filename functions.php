<?php
// Always use absolute path for includes
require_once __DIR__ . '/db.php';

// Create a new database connection if not already created
$db = new Database();
$conn = $db->getConnection();

function createProgram($name, $desc) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO programs (program_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $desc);
    return $stmt->execute();
}

function registerClient($fullName, $email, $phone) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO clients (full_name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullName, $email, $phone);
    return $stmt->execute();
}

function enrollClient($clientId, $programId) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO enrollments (client_id, program_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $clientId, $programId);
    return $stmt->execute();
}

function getClients() {
    global $conn;
    $result = $conn->query("SELECT * FROM clients");
    $clients = [];
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    return $clients;
}

function getPrograms() {
    global $conn;
    $result = $conn->query("SELECT * FROM programs");
    $programs = [];
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
    return $programs;
}

function getAllPrograms() {
    global $conn;
    $result = $conn->query("SELECT * FROM programs");
    $programs = [];
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
    return $programs;
}

function getClientById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getClientEnrollments($clientId) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT p.program_name 
        FROM enrollments e 
        JOIN programs p ON e.program_id = p.id 
        WHERE e.client_id = ?
    ");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();
    $enrollments = [];
    while ($row = $result->fetch_assoc()) {
        $enrollments[] = $row;
    }
    return $enrollments;
}
?>