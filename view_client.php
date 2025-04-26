
<?php
require_once '../includes/functions.php';

$client = null;
$enrollments = [];

if (isset($_GET['id'])) {
    $client = getClientById($_GET['id']);
    $enrollments = getClientEnrollments($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php if ($client): ?>
        <h2>Client Profile: <?= $client['full_name'] ?></h2>
        <p><strong>Email:</strong> <?= $client['email'] ?></p>
        <p><strong>Phone:</strong> <?= $client['phone'] ?></p>

        <h4>Enrolled Programs</h4>
        <ul>
            <?php foreach ($enrollments as $program): ?>
                <li><?= $program['program_name'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-warning">Client not found.</div>
    <?php endif; ?>
</div>
</body>
</html>
