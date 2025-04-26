<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: clients.php");
    exit;
}

$client_id = $_GET['id'];
$client = getClientById($client_id);
$programs = getClientPrograms($client_id);

if (!$client) {
    header("Location: clients.php");
    exit;
}

// Handle enrollment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll_program'])) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $program_id = sanitizeInput($_POST['program_id']);
    $enrollment_date = sanitizeInput($_POST['enrollment_date']);
    $notes = sanitizeInput($_POST['notes']);
    
    // Check if already enrolled
    $check = $conn->prepare("SELECT id FROM enrollments WHERE client_id = ? AND program_id = ?");
    $check->bind_param("ii", $client_id, $program_id);
    $check->execute();
    $check->store_result();
    
    if ($check->num_rows > 0) {
        $error = "Client is already enrolled in this program.";
    } else {
        $stmt = $conn->prepare("INSERT INTO enrollments (client_id, program_id, enrollment_date, notes) 
                               VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $client_id, $program_id, $enrollment_date, $notes);
        
        if ($stmt->execute()) {
            $success = "Client enrolled successfully!";
            // Refresh programs list
            $programs = getClientPrograms($client_id);
        } else {
            $error = "Error enrolling client: " . $conn->error;
        }
        
        $stmt->close();
    }
    
    $check->close();
    $db->closeConnection();
}

// Handle unenrollment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unenroll_program'])) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $program_id = sanitizeInput($_POST['program_id']);
    
    $stmt = $conn->prepare("DELETE FROM enrollments WHERE client_id = ? AND program_id = ?");
    $stmt->bind_param("ii", $client_id, $program_id);
    
    if ($stmt->execute()) {
        $success = "Client unenrolled successfully!";
        // Refresh programs list
        $programs = getClientPrograms($client_id);
    } else {
        $error = "Error unenrolling client: " . $conn->error;
    }
    
    $stmt->close();
    $db->closeConnection();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <h1 class="mb-4">Client Profile</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Client Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo $client['date_of_birth']; ?></p>
                        <p><strong>Gender:</strong> <?php echo $client['gender']; ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($client['address']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($client['phone']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($client['email']); ?></p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Enroll in Program</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="program_id" class="form-label">Program</label>
                                <select class="form-select" id="program_id" name="program_id" required>
                                    <option value="">Select a program</option>
                                    <?php 
                                    $all_programs = getAllPrograms();
                                    foreach ($all_programs as $program): 
                                        $enrolled = false;
                                        foreach ($programs as $enrolled_program) {
                                            if ($enrolled_program['id'] == $program['id']) {
                                                $enrolled = true;
                                                break;
                                            }
                                        }
                                        if (!$enrolled):
                                    ?>
                                        <option value="<?php echo $program['id']; ?>"><?php echo htmlspecialchars($program['name']); ?></option>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="enrollment_date" class="form-label">Enrollment Date</label>
                                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                            </div>
                            <button type="submit" name="enroll_program" class="btn btn-primary">Enroll Client</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Current Enrollments</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($programs) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Program</th>
                                            <th>Enrollment Date</th>
                                            <th>Notes</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($programs as $program): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($program['name']); ?></td>
                                                <td><?php echo $program['enrollment_date']; ?></td>
                                                <td><?php echo htmlspecialchars($program['notes']); ?></td>
                                                <td>
                                                    <form method="POST" style="display:
                                                                                                    <td>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="program_id" value="<?php echo $program['id']; ?>">
                                                        <button type="submit" name="unenroll_program" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to unenroll this client from the program?')">Unenroll</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p>This client is not enrolled in any programs yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>API Access</h5>
                    </div>
                    <div class="card-body">
                        <p>Access this client's data via API:</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="apiUrl" value="<?php echo BASE_URL; ?>api/clients.php?id=<?php echo $client_id; ?>" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyApiUrl()">Copy</button>
                        </div>
                        <p class="text-muted">Use this URL to retrieve client data in JSON format.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        function copyApiUrl() {
            const apiUrl = document.getElementById('apiUrl');
            apiUrl.select();
            apiUrl.setSelectionRange(0, 99999);
            document.execCommand('copy');
            alert('API URL copied to clipboard!');
        }
    </script>
</body>
</html>