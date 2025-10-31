<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Accounts - Lost & Found Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }
        
        .test-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .test-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .account-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 2px solid #e9ecef;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .account-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .admin-card {
            border-left: 5px solid #dc3545;
        }
        
        .user-card {
            border-left: 5px solid #0d6efd;
        }
        
        .page-title {
            color: white;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
        }
        
        .credential-box {
            background: #e3f2fd;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            border-left: 4px solid #2196f3;
        }
        
        .quick-login-btn {
            width: 100%;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container test-container">
        <h1 class="page-title">
            <i class="bi bi-people-fill"></i> Test Accounts
        </h1>
        
        <!-- System Info -->
        <div class="test-card">
            <h4 class="text-center mb-3">
                <i class="bi bi-gear-fill text-primary"></i> Lost & Found Management System
            </h4>
            <p class="text-center text-muted">Quick access to test accounts for demonstration and development</p>
            
            <!-- Messages -->
            <?php if (isset($messages) && !empty($messages)): ?>
                <div class="alert alert-info">
                    <?php foreach ($messages as $message): ?>
                        <div><?= $message ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Login Options -->
        <div class="row">
            <!-- Admin Account -->
            <div class="col-md-6">
                <div class="account-card admin-card">
                    <div class="text-center mb-3">
                        <i class="bi bi-shield-check" style="font-size: 3rem; color: #dc3545;"></i>
                        <h5 class="mt-2">Admin Account</h5>
                    </div>
                    
                    <div class="credential-box">
                        <strong>Quick Login Credentials:</strong><br>
                        <code>Email: admin@test.com</code><br>
                        <code>Password: admin123</code>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Admin Features:</h6>
                        <ul class="small">
                            <li>Review pending item reports</li>
                            <li>Approve/Reject found items</li>
                            <li>Mark items as claimed</li>
                            <li>View system statistics</li>
                            <li>Manage all user submissions</li>
                        </ul>
                    </div>
                    
                    <a href="/test-accounts/login-admin" class="btn btn-danger quick-login-btn">
                        <i class="bi bi-shield-check"></i> Quick Login as Admin
                    </a>
                </div>
            </div>

            <!-- User Account -->
            <div class="col-md-6">
                <div class="account-card user-card">
                    <div class="text-center mb-3">
                        <i class="bi bi-person-circle" style="font-size: 3rem; color: #0d6efd;"></i>
                        <h5 class="mt-2">User Account</h5>
                    </div>
                    
                    <div class="credential-box">
                        <strong>Quick Login Credentials:</strong><br>
                        <code>Email: user@test.com</code><br>
                        <code>Password: user123</code>
                    </div>
                    
                    <div class="mb-3">
                        <h6>User Features:</h6>
                        <ul class="small">
                            <li>Report found items</li>
                            <li>Upload item photos</li>
                            <li>Track submission status</li>
                            <li>Browse public timeline</li>
                            <li>Contact item finders</li>
                        </ul>
                    </div>
                    
                    <a href="/test-accounts/login-user" class="btn btn-primary quick-login-btn">
                        <i class="bi bi-person-circle"></i> Quick Login as User
                    </a>
                </div>
            </div>
        </div>

        <!-- Existing Accounts Info -->
        <div class="test-card">
            <h5><i class="bi bi-database"></i> Existing Database Accounts</h5>
            <div class="alert alert-info">
                <strong>Your database already contains these accounts:</strong>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-danger">Admin Accounts:</h6>
                    <ul class="small">
                        <li><strong>hannahcamillecunanan@gmail.com</strong> (Admin)</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">User Accounts:</h6>
                    <ul class="small">
                        <li><strong>cunananhannahcamille@gmail.com</strong> (User)</li>
                        <li><strong>jerwinagustin032@gmail.com</strong> (User)</li>
                        <li><strong>angiemallari@gmail.com</strong> (User)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="test-card text-center">
            <h5><i class="bi bi-tools"></i> Additional Actions</h5>
            
            <div class="row">
                <div class="col-md-4">
                    <a href="/test-accounts/create" class="btn btn-success w-100 mb-2">
                        <i class="bi bi-plus-circle"></i> Create Test Accounts
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/auth" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-box-arrow-in-right"></i> Regular Login
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/timeline" class="btn btn-outline-success w-100 mb-2">
                        <i class="bi bi-clock-history"></i> View Timeline
                    </a>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-md-6">
                    <a href="/dashboard" class="btn btn-warning w-100">
                        <i class="bi bi-speedometer2"></i> Go to Dashboard
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/test-accounts/logout" class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- System Flow -->
        <div class="test-card">
            <h5><i class="bi bi-diagram-3"></i> System Testing Flow</h5>
            <div class="alert alert-warning">
                <strong>Recommended Testing Sequence:</strong>
            </div>
            
            <ol>
                <li><strong>Login as User</strong> → Report a found item → Submit with photo</li>
                <li><strong>Login as Admin</strong> → Review pending item → Approve it</li>
                <li><strong>Check Timeline</strong> → Verify item appears publicly</li>
                <li><strong>Admin Claims Item</strong> → Mark as claimed with claimant details</li>
                <li><strong>Check Admin Dashboard</strong> → Verify complete workflow</li>
            </ol>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>