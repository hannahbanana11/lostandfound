<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lost & Found Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            padding: 3rem 0 2rem 0;
            text-align: center;
            color: white;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .stats-card, .main-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .stats-card:hover, .main-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .pending { color: #f39c12; }
        .approved { color: #27ae60; }
        .claimed { color: #3498db; }
        .total { color: #e74c3c; }
        
        .main-card {
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
        
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-pending { background: #f39c12; color: white; }
        .status-approved { background: #27ae60; color: white; }
        .status-claimed { background: #3498db; color: white; }
        
        .quick-action-btn {
            padding: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }
        
        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .alert {
            border-radius: 15px;
            border: none;
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
                <i class="bi bi-shield-check"></i> Admin Dashboard
            </h1>
            <p class="lead mb-4">
                Manage the Lost & Found system and help reunite items with their owners.
            </p>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="stats-card text-center">
                    <div class="stats-number pending"><?= $statistics['pending'] ?? 0 ?></div>
                    <h6>Pending Approval</h6>
                    <small class="text-muted">Items waiting for review</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center">
                    <div class="stats-number pending"><?= count($pendingClaims ?? []) ?></div>
                    <h6>Pending Claims</h6>
                    <small class="text-muted">Claims to review</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center">
                    <div class="stats-number approved"><?= $statistics['approved'] ?? 0 ?></div>
                    <h6>Approved Items</h6>
                    <small class="text-muted">Visible on timeline</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center">
                    <div class="stats-number claimed"><?= $statistics['claimed'] ?? 0 ?></div>
                    <h6>Claimed Items</h6>
                    <small class="text-muted">Returned to owners</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center">
                    <div class="stats-number total"><?= $statistics['total'] ?? 0 ?></div>
                    <h6>Total Items</h6>
                    <small class="text-muted">All time reports</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center">
                    <a href="/timeline" class="btn btn-outline-primary btn-sm mb-2">
                        <i class="bi bi-eye"></i> View Timeline
                    </a>
                    <br>
                    <small class="text-muted">Public view</small>
                </div>
            </div>
        </div>

        <!-- Quick Actions Panel -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="main-card">
                    <h5 class="mb-3">
                        <i class="bi bi-lightning"></i> Quick Actions
                    </h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="#pending" onclick="document.getElementById('pending-tab').click()" class="btn btn-warning quick-action-btn">
                                    <i class="bi bi-clock"></i> Review Pending Reports
                                    <br><small><?= count($pendingItems ?? []) ?> waiting</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="#pending-claims" onclick="document.getElementById('pending-claims-tab').click()" class="btn btn-info quick-action-btn">
                                    <i class="bi bi-hand-thumbs-up"></i> Review Claims
                                    <br><small><?= count($pendingClaims ?? []) ?> waiting</small>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="/timeline" class="btn btn-success quick-action-btn">
                                    <i class="bi bi-eye"></i> View Public Timeline
                                    <br><small><?= $statistics['approved'] ?? 0 ?> items visible</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Tabs -->
        <div class="main-card">
            <ul class="nav nav-tabs" id="adminTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                        <i class="bi bi-clock"></i> Pending Reports 
                        <span class="badge bg-warning ms-1"><?= count($pendingItems ?? []) ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-claims-tab" data-bs-toggle="tab" data-bs-target="#pending-claims" type="button" role="tab">
                        <i class="bi bi-hand-thumbs-up"></i> Pending Claims 
                        <span class="badge bg-warning ms-1"><?= count($pendingClaims ?? []) ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                        <i class="bi bi-check-circle"></i> Approved Items 
                        <span class="badge bg-success ms-1"><?= count($approvedItems ?? []) ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="claimed-tab" data-bs-toggle="tab" data-bs-target="#claimed" type="button" role="tab">
                        <i class="bi bi-archive"></i> Claimed Items 
                        <span class="badge bg-info ms-1"><?= count($claimedItems ?? []) ?></span>
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="adminTabsContent">
                <!-- Pending Items Tab -->
                <div class="tab-pane fade show active" id="pending" role="tabpanel">
                    <div class="p-3">
                        <h5>Items Awaiting Approval</h5>
                        <?php if (empty($pendingItems)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <h6 class="mt-2">No Pending Items</h6>
                                <p class="text-muted">All items have been reviewed. Great job!</p>
                                <a href="/timeline" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i> View Timeline
                                </a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($pendingItems as $item): ?>
                                <div class="item-card pending">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <?php if ($item['image']): ?>
                                                <img src="/uploads/<?= esc($item['image']) ?>" alt="Item" class="item-image">
                                            <?php else: ?>
                                                <div class="item-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-1"><?= esc($item['item_name']) ?></h6>
                                            <p class="mb-1"><small><i class="bi bi-geo-alt"></i> <?= esc($item['location']) ?></small></p>
                                            <p class="mb-1"><small><i class="bi bi-person"></i> Found by: <?= esc($item['founder_name']) ?></small></p>
                                            <p class="mb-0"><small><i class="bi bi-calendar"></i> <?= date('M j, Y', strtotime($item['date_reported'])) ?></small></p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="status-badge status-pending">Pending</span>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="/dashboard/approve/<?= $item['id'] ?>" class="btn btn-success btn-sm w-100 mb-1" 
                                               onclick="return confirm('Approve this item?')">
                                                <i class="bi bi-check"></i> Approve
                                            </a>
                                            <a href="/dashboard/reject/<?= $item['id'] ?>" class="btn btn-danger btn-sm w-100" 
                                               onclick="return confirm('Reject and delete this item?')">
                                                <i class="bi bi-x"></i> Reject
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pending Claims Tab -->
                <div class="tab-pane fade" id="pending-claims" role="tabpanel">
                    <div class="p-3">
                        <h5>Claims Awaiting Review</h5>
                        <?php if (empty($pendingClaims)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-hand-thumbs-up" style="font-size: 3rem; color: #ccc;"></i>
                                <h6 class="mt-2">No Pending Claims</h6>
                                <p class="text-muted">No claims are waiting for review. Users can claim items from the timeline.</p>
                                <a href="/timeline" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i> View Timeline
                                </a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($pendingClaims as $claim): ?>
                                <div class="item-card pending">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <?php if ($claim['image']): ?>
                                                <img src="/uploads/<?= esc($claim['image']) ?>" alt="Item" class="item-image">
                                            <?php else: ?>
                                                <div class="item-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1"><?= esc($claim['item_name']) ?></h6>
                                            <p class="mb-1"><small><i class="bi bi-geo-alt"></i> Found at: <?= esc($claim['location']) ?></small></p>
                                            <p class="mb-1"><small><i class="bi bi-person"></i> Found by: <?= esc($claim['founder_name']) ?></small></p>
                                            <p class="mb-0"><small><i class="bi bi-calendar"></i> Claimed: <?= date('M j, Y \a\t H:i', strtotime($claim['date_claimed'])) ?></small></p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="bg-light p-2 rounded">
                                                <p class="mb-1"><strong>Claimant:</strong> <?= esc($claim['claimant_name']) ?></p>
                                                <p class="mb-1"><small><i class="bi bi-telephone"></i> <?= esc($claim['claimant_contact']) ?></small></p>
                                                <p class="mb-0"><strong>Reason:</strong></p>
                                                <small class="text-muted"><?= esc($claim['notes']) ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="/dashboard/approve-claim/<?= $claim['id'] ?>" class="btn btn-success btn-sm w-100 mb-1" 
                                               onclick="return confirm('Approve this claim? The item will be marked as claimed.')">
                                                <i class="bi bi-check"></i> Approve Claim
                                            </a>
                                            <a href="/dashboard/reject-claim/<?= $claim['id'] ?>" class="btn btn-danger btn-sm w-100" 
                                               onclick="return confirm('Reject this claim?')">
                                                <i class="bi bi-x"></i> Reject Claim
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Approved Items Tab -->
                <div class="tab-pane fade" id="approved" role="tabpanel">
                    <div class="p-3">
                        <h5>Items on Public Timeline</h5>
                        <?php if (empty($approvedItems)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle" style="font-size: 3rem; color: #ccc;"></i>
                                <h6 class="mt-2">No Approved Items</h6>
                                <p class="text-muted">No items are currently on the timeline. Approve pending reports to make them visible.</p>
                                <button onclick="document.getElementById('pending-tab').click()" class="btn btn-outline-warning">
                                    <i class="bi bi-clock"></i> Check Pending Reports
                                </button>
                            </div>
                        <?php else: ?>
                            <?php foreach ($approvedItems as $item): ?>
                                <div class="item-card approved">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <?php if ($item['image']): ?>
                                                <img src="/uploads/<?= esc($item['image']) ?>" alt="Item" class="item-image">
                                            <?php else: ?>
                                                <div class="item-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-1"><?= esc($item['item_name']) ?></h6>
                                            <p class="mb-1"><small><i class="bi bi-geo-alt"></i> <?= esc($item['location']) ?></small></p>
                                            <p class="mb-1"><small><i class="bi bi-person"></i> Found by: <?= esc($item['founder_name']) ?></small></p>
                                            <p class="mb-0"><small><i class="bi bi-telephone"></i> <?= esc($item['contact_number']) ?></small></p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="status-badge status-approved">Approved</span>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="/dashboard/claim/<?= $item['id'] ?>" class="btn btn-primary btn-sm w-100">
                                                <i class="bi bi-hand-thumbs-up"></i> Mark as Claimed
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Claimed Items Tab -->
                <div class="tab-pane fade" id="claimed" role="tabpanel">
                    <div class="p-3">
                        <h5>Items Successfully Claimed</h5>
                        <?php if (empty($claimedItems)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-archive" style="font-size: 3rem; color: #ccc;"></i>
                                <h6 class="mt-2">No Claimed Items</h6>
                                <p class="text-muted">No items have been successfully claimed yet. Once users claim items and you approve them, they'll appear here.</p>
                                <button onclick="document.getElementById('pending-claims-tab').click()" class="btn btn-outline-info">
                                    <i class="bi bi-hand-thumbs-up"></i> Check Pending Claims
                                </button>
                            </div>
                        <?php else: ?>
                            <?php foreach ($claimedItems as $item): ?>
                                <div class="item-card claimed">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <?php if ($item['image']): ?>
                                                <img src="/uploads/<?= esc($item['image']) ?>" alt="Item" class="item-image">
                                            <?php else: ?>
                                                <div class="item-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-5">
                                            <h6 class="mb-1"><?= esc($item['item_name']) ?></h6>
                                            <p class="mb-1"><small><i class="bi bi-geo-alt"></i> Found at: <?= esc($item['location']) ?></small></p>
                                            <p class="mb-0"><small><i class="bi bi-person"></i> Found by: <?= esc($item['founder_name']) ?></small></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="mb-1"><strong>Claimed by:</strong> <?= esc($item['claimant_name']) ?></p>
                                            <p class="mb-1"><small><i class="bi bi-telephone"></i> <?= esc($item['claimant_contact']) ?></small></p>
                                            <p class="mb-0"><small><i class="bi bi-calendar"></i> <?= date('M j, Y', strtotime($item['date_claimed'])) ?></small></p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="status-badge status-claimed">Claimed</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Admin Footer -->
        <div class="main-card mt-4">
            <div class="row text-center">
                <div class="col-md-3">
                    <h6><i class="bi bi-info-circle"></i> System Status</h6>
                    <p class="text-success mb-0"><i class="bi bi-check-circle"></i> All systems operational</p>
                    <small class="text-muted">Database connected</small>
                </div>
                <div class="col-md-3">
                    <h6><i class="bi bi-people"></i> Quick Access</h6>
                    <p class="mb-0">
                        <span class="text-muted">Logged in as Admin</span>
                    </p>
                    <small class="text-muted">Administrative access</small>
                </div>
                <div class="col-md-3">
                    <h6><i class="bi bi-graph-up"></i> Statistics</h6>
                    <p class="mb-0">Total System Activity: <strong><?= $statistics['total'] ?? 0 ?></strong></p>
                    <small class="text-muted">Items processed all-time</small>
                </div>
                <div class="col-md-3">
                    <h6><i class="bi bi-shield-check"></i> Admin Tools</h6>
                    <p class="mb-0">
                        <a href="/timeline" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-eye"></i> Public View
                        </a>
                    </p>
                    <small class="text-muted">View timeline as users see it</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>