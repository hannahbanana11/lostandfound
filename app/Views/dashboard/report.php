<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Found Item - Lost & Found Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }
        
        .report-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .report-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-submit {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
        }
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 5px;
        }
        
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container report-container">
        <h1 class="page-title">
            <i class="bi bi-plus-circle-fill"></i> Report Found Item
        </h1>
        
        <div class="report-card">
            <a href="/dashboard" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            
            <div class="info-box">
                <i class="bi bi-info-circle-fill"></i>
                <strong>Please provide accurate information</strong><br>
                <small>Your report will be reviewed by an admin before appearing on the public timeline.</small>
            </div>
            
            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>
            
            <form action="/dashboard/report" method="post" enctype="multipart/form-data" id="reportForm">
                <?= csrf_field() ?>
                
                <h5 class="mb-3">
                    <i class="bi bi-person-badge"></i> Your Information
                </h5>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="founder_name" class="form-label">
                            <i class="bi bi-person"></i> Your Name *
                        </label>
                        <input type="text" class="form-control" id="founder_name" 
                               name="founder_name" required
                               placeholder="Enter your full name"
                               value="<?= old('founder_name') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="contact_number" class="form-label">
                            <i class="bi bi-telephone"></i> Contact Number *
                        </label>
                        <input type="text" class="form-control" id="contact_number" 
                               name="contact_number" required
                               placeholder="e.g., 09123456789"
                               value="<?= old('contact_number') ?>">
                    </div>
                </div>
                
                <hr class="my-4">
                
                <h5 class="mb-3">
                    <i class="bi bi-box-seam"></i> Item Details
                </h5>
                
                <div class="mb-3">
                    <label for="item_name" class="form-label">
                        <i class="bi bi-tag"></i> Item Name *
                    </label>
                    <input type="text" class="form-control" id="item_name" 
                           name="item_name" required
                           placeholder="e.g., Black Wallet, iPhone 13, Student ID"
                           value="<?= old('item_name') ?>">
                    <small class="text-muted">Be specific about the item type</small>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="bi bi-file-text"></i> Description *
                    </label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="4" required
                              placeholder="Describe the item in detail (color, brand, condition, any distinguishing features...)"><?= old('description') ?></textarea>
                    <small class="text-muted">Provide detailed description to help the owner identify their item</small>
                </div>
                
                <div class="mb-3">
                    <label for="location" class="form-label">
                        <i class="bi bi-geo-alt"></i> Location Found *
                    </label>
                    <input type="text" class="form-control" id="location" 
                           name="location" required
                           placeholder="e.g., Library 3rd Floor, Cafeteria Table 5, Parking Lot A"
                           value="<?= old('location') ?>">
                    <small class="text-muted">Where did you find this item?</small>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">
                        <i class="bi bi-camera"></i> Item Photo *
                    </label>
                    <input type="file" class="form-control" id="image" 
                           name="image" accept="image/*" required
                           onchange="previewImage(event)">
                    <small class="text-muted">Upload a clear photo of the item (Max 2MB, JPG/PNG)</small>
                    <br>
                    <img id="imagePreview" class="image-preview" alt="Image preview">
                </div>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Note:</strong> By submitting this form, you confirm that the information provided is accurate 
                    and you have found this item. Your report will be reviewed by an administrator.
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-submit btn-lg">
                        <i class="bi bi-send"></i> Submit Report
                    </button>
                    <a href="/dashboard" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('imagePreview');
            
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
        
        // Form validation
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('image');
            if (fileInput.files.length > 0) {
                const fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 2) {
                    e.preventDefault();
                    alert('File size must be less than 2MB');
                    return false;
                }
            }
        });
    </script>
</body>
</html>
