<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Lost & Found Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            padding: 3rem 0 1rem 0;
            text-align: center;
            color: white;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .welcome-card, .action-card, .my-items-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .welcome-card {
            text-align: center;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
        }
        
        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .action-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        
        .action-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .my-items-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .item-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #dee2e6;
        }
        
        .item-card.pending { border-left-color: #f39c12; }
        .item-card.approved { border-left-color: #27ae60; }
        .item-card.claimed { border-left-color: #3498db; }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-pending { background: #f39c12; color: white; }
        .status-approved { background: #27ae60; color: white; }
        .status-claimed { background: #3498db; color: white; }
        
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
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
                <a class="nav-link active" href="/dashboard">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a class="nav-link" href="/auth/logout">
                    <i class="bi bi-box-arrow-right"></i> Logout (<?= esc($user['username'] ?? $user['name']) ?>)
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Welcome Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-5 mb-4">
                <i class="bi bi-person-check"></i> User Dashboard
            </h1>
            <p class="lead mb-4">
                Help reunite lost items with their owners by reporting what you've found.
            </p>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Welcome Section -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-3">
                        <i class="bi bi-house-heart"></i> Welcome to Lost & Found Management
                    </h2>
                    <p class="lead">Help reunite lost items with their owners by reporting what you've found.</p>
                    <p class="text-muted">Your role: <strong><?= esc($user['role']) ?></strong></p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-search" style="font-size: 5rem; color: #667eea;"></i>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="action-cards">
            <div class="action-card">
                <div class="action-icon text-primary">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <h5>Report Found Item</h5>
                <p class="text-muted">Found something? Report it here so owners can find it.</p>
                <a href="/dashboard/report" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Report Item
                </a>
            </div>
            
            <div class="action-card">
                <div class="action-icon text-success">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5>Browse Timeline</h5>
                <p class="text-muted">Looking for your lost item? Check our public timeline.</p>
                <a href="/timeline" class="btn btn-success">
                    <i class="bi bi-search"></i> View Timeline
                </a>
            </div>
            
            <div class="action-card">
                <div class="action-icon text-info">
                    <i class="bi bi-list-check"></i>
                </div>
                <h5>My Reported Items</h5>
                <p class="text-muted">Track the status of items you've reported.</p>
                <button class="btn btn-info" onclick="document.getElementById('myItems').scrollIntoView()">
                    <i class="bi bi-list"></i> View My Items
                </button>
            </div>
        </div>

        <!-- My Reported Items -->
        <div class="my-items-card" id="myItems">
            <h4 class="mb-3">
                <i class="bi bi-clipboard-check"></i> My Reported Items
                <span class="badge bg-secondary ms-2"><?= count($myItems ?? []) ?></span>
            </h4>
            
            <?php if (empty($myItems)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                    <h5 class="mt-3">No Items Reported Yet</h5>
                    <p class="text-muted">You haven't reported any found items. Start helping others by reporting items you find!</p>
                    <a href="/dashboard/report" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Report Your First Item
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Status Guide:</strong>
                    <span class="badge bg-warning text-dark ms-2">Pending</span> Waiting for admin approval
                    <span class="badge bg-success ms-2">Approved</span> Visible on timeline
                    <span class="badge bg-info ms-2">Claimed</span> Returned to owner
                </div>
                
                <?php foreach ($myItems as $item): ?>
                    <div class="item-card <?= $item['status'] ?>">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <?php if ($item['image']): ?>
                                    <img src="/uploads/<?= esc($item['image']) ?>" alt="<?= esc($item['item_name']) ?>" class="item-image">
                                <?php else: ?>
                                    <div class="item-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1"><?= esc($item['item_name']) ?></h6>
                                <p class="mb-1"><small><i class="bi bi-geo-alt"></i> Found at: <?= esc($item['location']) ?></small></p>
                                <p class="mb-1"><small><i class="bi bi-calendar"></i> Reported: <?= date('M j, Y \a\t H:i', strtotime($item['date_reported'])) ?></small></p>
                                <p class="mb-0"><small class="text-muted"><?= esc(substr($item['description'], 0, 100)) ?><?= strlen($item['description']) > 100 ? '...' : '' ?></small></p>
                            </div>
                            <div class="col-md-2">
                                <span class="status-badge status-<?= $item['status'] ?>">
                                    <?= ucfirst($item['status']) ?>
                                </span>
                            </div>
                            <div class="col-md-2">
                                <?php if ($item['status'] === 'pending'): ?>
                                    <small class="text-muted">Awaiting admin review</small>
                                <?php elseif ($item['status'] === 'approved'): ?>
                                    <a href="/timeline" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i> View on Timeline
                                    </a>
                                <?php elseif ($item['status'] === 'claimed'): ?>
                                    <small class="text-success">
                                        <i class="bi bi-check-circle"></i> Successfully claimed
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="mt-3 text-center">
                    <a href="/dashboard/report" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Report Another Item
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Help Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-question-circle text-primary" style="font-size: 2rem;"></i>
                        <h6 class="mt-2">How It Works</h6>
                        <p class="small text-muted">Report found items → Admin reviews → Approved items appear on timeline → Owners contact you</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                        <h6 class="mt-2">Safe & Secure</h6>
                        <p class="small text-muted">All reports are reviewed by admins before being made public</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>