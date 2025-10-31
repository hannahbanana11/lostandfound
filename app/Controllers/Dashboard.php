<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Admin Dashboard</span>
            <a href="/LostAndFoundManagement/public/auth/logout" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h1 class="display-4">This is dashboard for test</h1>
            <p class="lead">Admin dashboard loaded successfully!</p>
            <p>Welcome, <?= esc($user['name']) ?>!</p>
            <p>Role: <?= esc($user['role']) ?></p>
        </div>
    </div>
</body>
</html>