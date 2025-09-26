<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role-Based Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('dashboard') ?>">MyApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <?php if (session()->get('logged_in')): ?>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('admin/users') ?>">Manage Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('admin/reports') ?>">Reports</a>
                            </li>

                        <?php elseif (session()->get('role') === 'teacher'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('teacher/classes') ?>">My Classes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('teacher/grades') ?>">Grades</a>
                            </li>

                        <?php elseif (session()->get('role') === 'student'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('student/courses') ?>">My Courses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('student/assignments') ?>">Assignments</a>
                            </li>
                        <?php endif; ?>

                        <!-- Common logout link for all roles -->
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= site_url('logout') ?>">Logout</a>
                        </li>

                    <?php else: ?>
                        <!-- If not logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('login') ?>">Login</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
