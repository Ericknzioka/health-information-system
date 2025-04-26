<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$searchResults = [];
$searchTerm = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchTerm = sanitizeInput($_GET['search']);
    $searchResults = searchClients($searchTerm);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <h1 class="mb-4">Search Clients</h1>
        
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search by name, email, or phone" value="<?php echo htmlspecialchars($searchTerm); ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if (!empty($searchTerm)): ?>
            <div class="card">
                <div class="card-header">
                    <h5>Search Results</h5>
                </div>
                <div class="card-body">
                    <?php if (count($searchResults) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($searchResults as $client): ?>
                                        <tr>
                                            <td><?php echo $client['id']; ?></td>
                                            <td><?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?></td>
                                            <td><?php echo $client['date_of_birth']; ?></td>
                                            <td><?php echo $client['gender']; ?></td>
                                            <td><?php echo htmlspecialchars($client['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($client['email']); ?></td>
                                            <td>
                                                <a href="profile.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No clients found matching your search criteria.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>