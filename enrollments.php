<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'db.php';

// Create database connection
$db = new Database();
$conn = $db->getConnection();

// Handle different request methods
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get enrollments logic (if needed)
        break;
        
    case 'POST':
        // Add enrollment logic (if needed)
        break;
        
    case 'PUT':
        // Update enrollment logic (if needed)
        break;
        
    case 'DELETE':
        // Delete enrollment logic
        if (isset($_GET['client_id']) && isset($_GET['program_id'])) {
            $client_id = intval($_GET['client_id']);
            $program_id = intval($_GET['program_id']);
            
            // Validate the IDs
            if ($client_id <= 0 || $program_id <= 0) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid client or program ID']);
                exit;
            }
            
            // Prepare and execute delete query
            $stmt = $conn->prepare("DELETE FROM enrollments WHERE client_id = ? AND program_id = ?");
            $stmt->bind_param("ii", $client_id, $program_id);
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Enrollment deleted successfully']);
                } else {
                    header('Content-Type: application/json');
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Enrollment not found']);
                }
            } else {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
            }
            
            $stmt->close();
        } else {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing client_id or program_id parameter']);
        }
        break;
        
    default:
        header('Content-Type: application/json');
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        break;
}

$conn->close();
?>