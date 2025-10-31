<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Lost & Found Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .claim-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .claim-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .page-title {
            color: white;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 300;
        }
        
        .item-preview {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #007bff;
        }
        
        .item-image {
            width: 100%;
            max-width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .btn-claim {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-claim:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }
        
        .required {
            color: #dc3545;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container claim-container">
        <h1 class="page-title">
            <i class="bi bi-hand-thumbs-up"></i> <?= esc($title) ?>
        </h1>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <div class="claim-card">
            <!-- Item Preview -->
            <div class="item-preview">
                <h5 class="mb-3">
                    <i class="bi bi-tag"></i> Item Details
                </h5>
                
                <div class="row">
                    <div class="col-md-4">
                        <?php if ($item['image']): ?>
                            <img src="/uploads/<?= esc($item['image']) ?>" 
                                 alt="<?= esc($item['item_name']) ?>" 
                                 class="item-image">
                        <?php else: ?>
                            <div class="item-image bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <h6 class="fw-bold text-primary"><?= esc($item['item_name']) ?></h6>
                        <p><strong>Location Found:</strong> <?= esc($item['location']) ?></p>
                        <p><strong>Date Reported:</strong> <?= date('M j, Y \a\t H:i', strtotime($item['date_reported'])) ?></p>
                        <p><strong>Description:</strong> <?= esc($item['description']) ?></p>
                        <div class="alert alert-info p-2">
                            <small>
                                <i class="bi bi-info-circle"></i>
                                <strong>Found by:</strong> <?= esc($item['founder_name']) ?> | 
                                <strong>Contact:</strong> <?= esc($item['contact_number']) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Claim Form -->
            <form action="/timeline/claim" method="post">
                <input type="hidden" name="item_id" value="<?= esc($item['id']) ?>">
                
                <h5 class="mb-3">
                    <i class="bi bi-person-check"></i> Claim This Item
                </h5>
                
                <p class="text-muted mb-4">
                    Please provide your information and explain why you believe this item belongs to you. 
                    An admin will review your claim and contact you if approved.
                </p>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="claimant_name" class="form-label">
                                Your Full Name <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="claimant_name" 
                                   name="claimant_name" 
                                   value="<?= esc($user['name'] ?? '') ?>"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="claimant_contact" class="form-label">
                                Your Contact Number <span class="required">*</span>
                            </label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="claimant_contact" 
                                   name="claimant_contact" 
                                   placeholder="e.g., +1234567890"
                                   required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="form-label">
                        Why do you believe this item is yours? <span class="required">*</span>
                    </label>
                    <textarea class="form-control" 
                              id="description" 
                              name="description" 
                              rows="4" 
                              placeholder="Please provide specific details about the item that prove ownership (e.g., unique features, contents, when/where you lost it, etc.)"
                              required></textarea>
                    <div class="form-text">
                        Be as specific as possible to help admin verify your ownership.
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Important:</strong> Your claim will be reviewed by an admin. Please ensure all information is accurate. 
                    False claims may result in account suspension.
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="/timeline" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Timeline
                    </a>
                    <button type="submit" class="btn btn-claim">
                        <i class="bi bi-send"></i> Submit Claim
                    </button>
                </div>
            </form>
        </div>
        
        <div class="text-center">
            <a href="/timeline" class="btn btn-outline-light me-2">
                <i class="bi bi-arrow-left"></i> Back to Timeline
            </a>
            <a href="/dashboard" class="btn btn-light">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>