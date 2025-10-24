<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Course Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                <i class="bi bi-book"></i> Learning Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="bi bi-person-circle"></i> <?= esc($name) ?> (<?= esc(ucfirst($role)) ?>)
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Page Header -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title mb-3">
                            <i class="bi bi-cloud-upload text-primary"></i> Upload Course Material
                        </h2>
                        <p class="text-muted mb-0">
                            <strong>Course:</strong> <?= esc($course['course_code']) ?> - <?= esc($course['course_name']) ?>
                        </p>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Upload Form -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="<?= base_url('/admin/course/' . $course['id'] . '/upload') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            
                            <div class="mb-4">
                                <label for="material_file" class="form-label">
                                    <i class="bi bi-file-earmark-arrow-up"></i> Select File
                                </label>
                                <input type="file" 
                                       class="form-control form-control-lg" 
                                       id="material_file" 
                                       name="material_file" 
                                       required
                                       accept=".pdf,.doc,.docx,.ppt,.pptx,.xlsx,.xls,.txt,.zip,.rar">
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> 
                                    Allowed file types: PDF, DOC, DOCX, PPT, PPTX, XLSX, XLS, TXT, ZIP, RAR (Max size: 10MB)
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-upload"></i> Upload Material
                                </button>
                                <a href="/dashboard" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Upload Instructions -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-lightbulb text-warning"></i> Upload Guidelines
                        </h5>
                        <ul class="mb-0">
                            <li>Ensure the file name is descriptive and professional</li>
                            <li>Check that the file is not corrupted before uploading</li>
                            <li>Only enrolled students will be able to download the materials</li>
                            <li>You can delete materials from the dashboard if needed</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- File name display script -->
    <script>
        document.getElementById('material_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
                console.log(`Selected: ${fileName} (${fileSize} MB)`);
            }
        });
    </script>
</body>
</html>
