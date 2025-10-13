<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ Clean, light navbar like your login page -->
<nav class="navbar navbar-expand-lg" style="background-color: #dff0d8;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-success" href="<?= site_url('dashboard') ?>"></a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (session()->get('logged_in')): ?>
                    <?php if (session()->get('role') === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('admin/users') ?>">Manage Users</a></li>
                        <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('admin/reports') ?>">Reports</a></li>
                    <?php elseif (session()->get('role') === 'teacher'): ?>
                        <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('teacher/classes') ?>">My Classes</a></li>
                        <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('teacher/grades') ?>">Grades</a></li>
                    <?php elseif (session()->get('role') === 'student'): ?>
                        <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('student/courses') ?>">My Courses</a></li>
                        <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('student/assignments') ?>">Assignments</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('auth/logout') ?>">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
