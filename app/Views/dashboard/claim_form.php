<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Item - Lost & Found Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }
        
        .claim-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .claim-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .item-preview {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 2px solid #e9ecef;
        }
        
        .item-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .page-title {
            color: white;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .btn-submit {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container claim-container">
        <h1 class="page-title">
            <i class="bi bi-hand-thumbs-up-fill"></i> Claim Item
        </h1>
        
        <div class="claim-card">
            <a href="/dashboard" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            
            <!-- Item Preview -->
            <div class="item-preview">
                <h5 class="mb-3">
                    <i class="bi bi-box-seam text-primary"></i> Item Details
                </h5>
                <div class="row">
                    <div class="col-md-4">
                        <?php if ($item['image']): ?>
                            <img src="/uploads/<?= esc($item['image']) ?>" 
                                 alt="Item" class="item-image">
                        <?php else: ?>
                            <div class="item-image d-flex align-items-center justify-content-center bg-secondary">
                                <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <p><strong>Item Name:</strong> <?= esc($item['item_name']) ?></p>
                        <p><strong>Description:</strong> <?= esc($item['description']) ?></p>
                        <p><strong>Location Found:</strong> <?= esc($item['location']) ?></p>
                        <p><strong>Found By:</strong> <?= esc($item['founder_name']) ?></p>
                        <p><strong>Contact:</strong> <?= esc($item['contact_number']) ?></p>
                        <p class="mb-0 text-muted">
                            <small>Reported: <?= date('M d, Y h:i A', strtotime($item['date_reported'])) ?></small>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Claim Form -->
            <h5 class="mb-3">
                <i class="bi bi-person-check text-success"></i> Claimant Information
            </h5>
            
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>
            
            <form action="/dashboard/claim/<?= $item['id'] ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="claimant_name" class="form-label">
                        <i class="bi bi-person"></i> Claimant Name *
                    </label>
                    <input type="text" class="form-control" id="claimant_name" 
                           name="claimant_name" required
                           placeholder="Enter the name of the person claiming this item"
                           value="<?= old('claimant_name') ?>">
                    <small class="text-muted">Full name of the person who claims to be the owner</small>
                </div>
                
                <div class="mb-3">
                    <label for="claimant_contact" class="form-label">
                        <i class="bi bi-telephone"></i> Contact Number *
                    </label>
                    <input type="text" class="form-control" id="claimant_contact" 
                           name="claimant_contact" required
                           placeholder="Enter contact number"
                           value="<?= old('claimant_contact') ?>">
                    <small class="text-muted">Phone number of the claimant</small>
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">
                        <i class="bi bi-chat-dots"></i> Verification Notes (Optional)
                    </label>
                    <textarea class="form-control" id="notes" name="notes" rows="4"
                              placeholder="Enter any additional notes about the claim verification..."><?= old('notes') ?></textarea>
                    <small class="text-muted">
                        Add notes about how the claimant verified ownership (e.g., showed ID, described item details, etc.)
                    </small>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Note:</strong> By submitting this form, you confirm that you have verified 
                    the claimant's ownership of this item and authorize its release to them.
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-submit btn-lg">
                        <i class="bi bi-check-circle"></i> Confirm Claim
                    </button>
                    <a href="/dashboard" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
