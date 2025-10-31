<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">User Dashboard</span>
            <a href="/LostAndFoundManagement/public/auth/logout" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="alert alert-info text-center">
            <h1>User Dashboard</h1>
            <p>Welcome, <?= esc($user['name']) ?>!</p>
            <p>Role: <?= esc($user['role']) ?></p>
        </div>
    </div>
</body>
</html>