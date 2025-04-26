<?php
require_once '../includes/functions.php';
$clients = getClients();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Search Clients</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= $client['id'] ?></td>
                <td><?= $client['full_name'] ?></td>
                <td><?= $client['email'] ?></td>
                <td><?= $client['phone'] ?></td>
                <td><a href="view_client.php?id=<?= $client['id'] ?>" class="btn btn-info btn-sm">View Profile</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>