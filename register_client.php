/*
health-system/includes/db.php
*/

<?php
$host = 'localhost';
$db   = 'health_system';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

/*
health-system/includes/functions.php
*/

<?php
require_once 'db.php';

function createProgram($name, $desc) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO programs (program_name, description) VALUES (?, ?)");
    return $stmt->execute([$name, $desc]);
}

function registerClient($fullName, $email, $phone) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO clients (full_name, email, phone) VALUES (?, ?, ?)");
    return $stmt->execute([$fullName, $email, $phone]);
}

function enrollClient($clientId, $programId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO enrollments (client_id, program_id) VALUES (?, ?)");
    return $stmt->execute([$clientId, $programId]);
}

function getClients() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM clients");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPrograms() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM programs");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getClientById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getClientEnrollments($clientId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT p.program_name FROM enrollments e JOIN programs p ON e.program_id = p.id WHERE e.client_id = ?");
    $stmt->execute([$clientId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

/*
health-system/views/create_program.php
*/

<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['program_name'];
    $desc = $_POST['description'];
    
    if (createProgram($name, $desc)) {
        echo "<div class='alert alert-success'>Program created successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to create program.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Health Program</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Create Health Program</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="program_name" class="form-label">Program Name</label>
            <input type="text" name="program_name" id="program_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Program</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

/*
health-system/views/register_client.php
*/

<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (registerClient($name, $email, $phone)) {
        echo "<div class='alert alert-success'>Client registered successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to register client.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Register Client</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" id="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Register Client</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
