<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
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

        .timeline-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .timeline-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .item-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e1e8ed;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .item-image {
            width: 100%;
            max-width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .item-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .item-meta {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .contact-info {
            background: #e8f5e8;
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1rem;
            border-left: 4px solid #27ae60;
        }

        .contact-title {
            font-weight: 600;
            color: #27ae60;
            margin-bottom: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #7f8c8d;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #27ae60;
            color: white;
        }

        .nav-link {
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2) !important;
            font-weight: 600;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
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
                <a class="nav-link active" href="/timeline">
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
            <h1 class="display-5 mb-4">
                <i class="bi bi-clock-history"></i> <?= esc($title) ?>
            </h1>
            <p class="lead mb-4">
                Browse found items and help reunite them with their owners.
            </p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="timeline-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <i class="bi bi-list-check"></i> Found Items (<?= count($items) ?>)
                </h4>
                <div>
                    <?php if (isset($user) && $user && $user['role'] === 'user'): ?>
                        <a href="/dashboard/report" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Report Item
                        </a>
                    <?php elseif (!isset($user) || !$user): ?>
                        <a href="/auth" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login to Report
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <?php if (isset($user) && $user): ?>
                    <strong>Welcome back, <?= esc($user['username'] ?? $user['name']) ?>!</strong> These are approved items reported by users. Contact the finder directly if you believe an item is yours.
                    <?php if ($user['role'] === 'user'): ?>
                        <br><small>Found something? <a href="/dashboard/report" class="alert-link">Report it here</a> to help others.</small>
                    <?php endif; ?>
                <?php else: ?>
                    <strong>System Logic:</strong> These are approved items reported by users. Contact the finder directly if you believe an item is yours. All items shown here have been verified by admin.
                <?php endif; ?>
            </div>

            <?php if (empty($items)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h5>No Items Found</h5>
                    <p>There are currently no approved found items to display.</p>
                    <?php if (!isset($user) || !$user): ?>
                        <a href="/auth/register" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Register to Report Found Items
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($items as $item): ?>
                        <div class="col-lg-6 col-xl-4">
                            <div class="item-card">
                                <?php if ($item['image']): ?>
                                    <img src="/uploads/<?= esc($item['image']) ?>"
                                        alt="<?= esc($item['item_name']) ?>"
                                        class="item-image">
                                <?php else: ?>
                                    <div class="item-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="item-title mb-0">
                                        <i class="bi bi-tag"></i> <?= esc($item['item_name']) ?>
                                        <?php if (isset($user) && $user && $item['user_id'] == $user['id']): ?>
                                            <span class="badge bg-primary ms-2">
                                                <i class="bi bi-person-check"></i> Your Post
                                            </span>
                                        <?php endif; ?>
                                    </h5>
                                    <span class="status-badge">Approved</span>
                                </div>

                                <div class="item-meta">
                                    <i class="bi bi-geo-alt"></i> Found at: <strong><?= esc($item['location']) ?></strong>
                                </div>

                                <div class="item-meta">
                                    <i class="bi bi-calendar"></i> Reported: <?= date('M j, Y \a\t H:i', strtotime($item['date_reported'])) ?>
                                </div>

                                <p class="mt-2 mb-3">
                                    <strong>Description:</strong><br>
                                    <?= esc($item['description']) ?>
                                </p>

                                <div class="contact-info">
                                    <div class="contact-title">
                                        <i class="bi bi-person-check"></i> Contact Finder to Claim
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <strong>Name:</strong><br>
                                            <?= esc($item['founder_name']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Phone:</strong><br>
                                            <a href="tel:<?= esc($item['contact_number']) ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone"></i> <?= esc($item['contact_number']) ?>
                                            </a>
                                        </div>
                                    </div>

                                    <?php if (isset($user) && $user): ?>
                                        <?php if ($item['user_id'] == $user['id']): ?>
                                            <!-- User cannot claim their own item -->
                                            <div class="mt-3">
                                                <div class="alert alert-info p-2 mb-0">
                                                    <i class="bi bi-info-circle"></i>
                                                    <small>You reported this item - you cannot claim it yourself</small>
                                                </div>
                                            </div>
                                        <?php elseif (isset($item['claim_status']) && $item['claim_status']): ?>
                                            <!-- Item has a claim -->
                                            <?php if ($item['claim_status']['claimant_user_id'] == $user['id']): ?>
                                                <!-- Current user made the claim -->
                                                <div class="mt-3">
                                                    <div class="alert alert-warning p-2 mb-2">
                                                        <i class="bi bi-clock-history"></i>
                                                        <small>You have claimed this item - pending admin approval</small>
                                                    </div>
                                                    <div class="d-grid">
                                                        <a href="/timeline/cancel-claim/<?= $item['claim_status']['id'] ?>"
                                                            class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to cancel your claim?')">
                                                            <i class="bi bi-x-circle"></i> Cancel Claim
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <!-- Someone else made the claim -->
                                                <div class="mt-3">
                                                    <div class="alert alert-secondary p-2 mb-0">
                                                        <i class="bi bi-hourglass-split"></i>
                                                        <small>Pending for claiming - another user has submitted a claim</small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <!-- No claims yet - user can claim this item -->
                                            <div class="mt-3 d-grid">
                                                <a href="/timeline/claim/<?= $item['id'] ?>" class="btn btn-success">
                                                    <i class="bi bi-hand-thumbs-up"></i> Claim This Item
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if (isset($item['claim_status']) && $item['claim_status']): ?>
                                            <!-- Item has a claim but user not logged in -->
                                            <div class="mt-3">
                                                <div class="alert alert-secondary p-2 mb-0">
                                                    <i class="bi bi-hourglass-split"></i>
                                                    <small>Pending for claiming - a claim has been submitted</small>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- No claims and user not logged in -->
                                            <div class="mt-3 d-grid">
                                                <a href="/auth" class="btn btn-outline-primary">
                                                    <i class="bi bi-box-arrow-in-right"></i> Login to Claim Item
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 text-center">
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i>
                        <strong>Total Found Items:</strong> <?= count($items) ?> approved items available for claiming
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-3">
            <?php if (isset($user) && $user): ?>
                <!-- User is logged in -->
                <a href="/dashboard" class="btn btn-outline-light me-2">
                    <i class="bi bi-speedometer2"></i> Back to Dashboard
                </a>
                <?php if ($user['role'] === 'user'): ?>
                    <a href="/dashboard/report" class="btn btn-light me-2">
                        <i class="bi bi-plus-circle"></i> Report Found Item
                    </a>
                <?php endif; ?>
                <a href="/" class="btn btn-light">
                    <i class="bi bi-house"></i> Home
                </a>
            <?php else: ?>
                <!-- User is not logged in -->
                <a href="/auth" class="btn btn-outline-light me-2">
                    <i class="bi bi-box-arrow-in-right"></i> Login to Report Found Item
                </a>
                <a href="/" class="btn btn-light">
                    <i class="bi bi-house"></i> Back to Home
                </a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>