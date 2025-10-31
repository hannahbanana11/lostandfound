<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Access Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .test-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="test-card">
        <h2 class="mb-4">🧪 Dashboard Access Test</h2>
        
        <?php
        $session = session();
        $user = $session->get('user');
        
        if (!$user) {
            echo '<div class="alert alert-warning">';
            echo '<h5>❌ Not Logged In</h5>';
            echo '<p>You need to login first to access the dashboard.</p>';
            echo '<a href="/auth" class="btn btn-primary">Go to Login Page</a>';
            echo '</div>';
            
            echo '<hr>';
            echo '<h5>Admin Account Available:</h5>';
            echo '<ul>';
            echo '<li><strong>Email:</strong> hannahcamillecunanan@gmail.com</li>';
            echo '<li><strong>Role:</strong> admin</li>';
            echo '</ul>';
        } else {
            echo '<div class="alert alert-success">';
            echo '<h5>✅ Logged In Successfully!</h5>';
            echo '<p><strong>Username:</strong> ' . esc($user['username']) . '</p>';
            echo '<p><strong>Email:</strong> ' . esc($user['email']) . '</p>';
            echo '<p><strong>Role:</strong> <span class="badge bg-primary">' . esc($user['role']) . '</span></p>';
            echo '</div>';
            
            if ($user['role'] === 'admin') {
                echo '<a href="/dashboard" class="btn btn-success btn-lg w-100 mb-2">🚀 Go to Admin Dashboard</a>';
                
                // Test database connection
                try {
                    $foundItemModel = new \App\Models\FoundItemModel();
                    $stats = $foundItemModel->getStatistics();
                    
                    echo '<hr>';
                    echo '<h5>Database Status:</h5>';
                    echo '<div class="alert alert-info">';
                    echo '<ul class="mb-0">';
                    echo '<li>Pending Items: ' . $stats['pending'] . '</li>';
                    echo '<li>Approved Items: ' . $stats['approved'] . '</li>';
                    echo '<li>Claimed Items: ' . $stats['claimed'] . '</li>';
                    echo '<li>Total Items: ' . $stats['total'] . '</li>';
                    echo '</ul>';
                    echo '</div>';
                    
                } catch (\Exception $e) {
                    echo '<div class="alert alert-danger">';
                    echo 'Database Error: ' . $e->getMessage();
                    echo '</div>';
                }
            } else {
                echo '<a href="/dashboard" class="btn btn-primary btn-lg w-100 mb-2">🚀 Go to User Dashboard</a>';
            }
            
            echo '<a href="/auth/logout" class="btn btn-outline-secondary w-100">Logout</a>';
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
