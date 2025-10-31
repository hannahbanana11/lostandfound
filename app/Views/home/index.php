<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            padding: 4rem 0;
            text-align: center;
            color: white;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .main-actions {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .btn-custom {
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            margin: 0.5rem;
        }
        
        .nav-link {
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-link.active {
            background-color: rgba(255,255,255,0.2) !important;
            font-weight: 600;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1) !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: rgba(0,0,0,0.1);">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-search-heart"></i> Lost & Found Management
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/timeline">
                    <i class="bi bi-clock-history"></i> Timeline
                </a>
                <?php if (isset($user) && $user): ?>
                    <!-- User is logged in -->
                    <a class="nav-link" href="/dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="/auth/logout">
                        <i class="bi bi-box-arrow-right"></i> Logout (<?= esc($user['username'] ?? $user['name']) ?>)
                    </a>
                <?php else: ?>
                    <!-- User is not logged in -->
                    <a class="nav-link" href="/auth">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <?php if (isset($user) && $user): ?>
                <!-- Logged in user welcome -->
                <h1 class="display-4 mb-4">
                    <i class="bi bi-person-check"></i> Welcome back, <?= esc($user['username'] ?? $user['name']) ?>!
                </h1>
                <p class="lead mb-4">
                    <?php if ($user['role'] === 'admin'): ?>
                        Manage the Lost & Found system and help reunite items with their owners.
                    <?php else: ?>
                        Continue helping reunite lost items with their owners through your reports.
                    <?php endif; ?>
                </p>
                <div class="main-actions">
                    <h4 class="text-dark mb-3">Quick Actions</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="/timeline" class="btn btn-success btn-custom w-100">
                                <i class="bi bi-search"></i><br>
                                Browse Timeline
                            </a>
                            <small class="text-muted">View all found items</small>
                        </div>
                        <div class="col-md-4">
                            <a href="/dashboard" class="btn btn-primary btn-custom w-100">
                                <i class="bi bi-speedometer2"></i><br>
                                Go to Dashboard
                            </a>
                            <small class="text-muted">
                                <?php if ($user['role'] === 'admin'): ?>
                                    Manage system and review items
                                <?php else: ?>
                                    Report items and track status
                                <?php endif; ?>
                            </small>
                        </div>
                        <div class="col-md-4">
                            <a href="/dashboard/report" class="btn btn-info btn-custom w-100">
                                <i class="bi bi-plus-circle"></i><br>
                                Report Item
                            </a>
                            <small class="text-muted">Found something? Report it</small>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Not logged in - original content -->
                <h1 class="display-4 mb-4">
                    <i class="bi bi-search-heart"></i> Lost & Found Management System
                </h1>
                <p class="lead mb-4">
                    Helping reunite lost items with their owners through a simple, secure reporting system.
                </p>
                <div class="main-actions">
                    <h4 class="text-dark mb-3">Get Started</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="/timeline" class="btn btn-success btn-custom w-100">
                                <i class="bi bi-search"></i><br>
                                Search Lost Items
                            </a>
                            <small class="text-muted">Browse found items on timeline</small>
                        </div>
                        <div class="col-md-4">
                            <a href="/auth" class="btn btn-primary btn-custom w-100">
                                <i class="bi bi-plus-circle"></i><br>
                                Report Found Item
                            </a>
                            <small class="text-muted">Help others find their items</small>
                        </div>
                        <div class="col-md-4">
                            <a href="/auth/register" class="btn btn-info btn-custom w-100">
                                <i class="bi bi-person-plus"></i><br>
                                Create Account
                            </a>
                            <small class="text-muted">Join our community</small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon text-primary">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h5>For Users</h5>
                    <ul class="text-start">
                        <li>Report found items with photos</li>
                        <li>Track submission status</li>
                        <li>Browse public timeline</li>
                        <li>Contact item finders directly</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon text-danger">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5>For Admins</h5>
                    <ul class="text-start">
                        <li>Review and approve reports</li>
                        <li>Manage system content</li>
                        <li>Track claimed items</li>
                        <li>View system statistics</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon text-success">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h5>Complete Workflow</h5>
                    <ul class="text-start">
                        <li>Report → Review → Approve</li>
                        <li>Public timeline visibility</li>
                        <li>Direct contact system</li>
                        <li>Claim tracking & history</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="feature-card">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5 class="mt-4 mb-4"><i class="bi bi-info-circle text-info"></i> How It Works</h5>
                    <ol class="list-unstyled">
                        <li class="mb-2"><strong>1. Report:</strong> Users find items and submit reports</li>
                        <li class="mb-2"><strong>2. Review:</strong> Admins verify and approve submissions</li>
                        <li class="mb-2"><strong>3. Publish:</strong> Approved items appear on public timeline</li>
                        <li class="mb-2"><strong>4. Connect:</strong> Item owners contact finders directly</li>
                        <li class="mb-2"><strong>5. Claim:</strong> Admins record successful reunifications</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>