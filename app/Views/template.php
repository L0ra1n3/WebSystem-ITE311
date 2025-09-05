<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ITE311-ESYONG</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">

  <style>
    :root {
      --primary: #53ae7bff;
      --nav-bg: #e0f5e7ff;
      --text-color: #343a40;
    }

    .navbar-custom {
      background-color: var(--nav-bg);
      border-bottom: 1px solid #dee2e6;
      position: relative;
      padding-left: 1rem;
    }

    .navbar-custom .navbar-brand {
      font-weight: bold;
      color: var(--primary);
      margin-right: 2rem;
    }

    .navbar-custom .nav-link {
      color: var(--text-color);
      font-weight: 500;
      padding: 0.75rem 1rem;
      transition: color 0.3s ease;
      position: relative;
    }

    .navbar-custom .nav-link.active,
    .navbar-custom .nav-link:hover {
      color: var(--primary);
    } 

    .highlight-bar {
      position: absolute;
      bottom: 0;
      height: 3px;
      background-color: var(--primary);
      transition: all 0.3s ease;
      border-radius: 2px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    
    <a class="navbar-brand" href="<?= base_url('/') ?>">LMS</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Left side -->
      <ul class="navbar-nav position-relative">
        <li class="nav-item"><a class="nav-link <?= url_is('/') ? 'active' : '' ?>" href="<?= base_url('/') ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= url_is('about') ? 'active' : '' ?>" href="<?= base_url('about') ?>">About</a></li>
        <li class="nav-item"><a class="nav-link <?= url_is('contact') ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Contact</a></li>
        <div class="highlight-bar"></div>
      </ul>

      <!-- Right side -->
      <ul class="navbar-nav ms-auto">
        <?php if (session()->get('isLoggedIn')): ?>
          <!-- ✅ Show when logged in -->
          <li class="nav-item">
            <a class="nav-link <?= url_is('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
          </li>
        <?php else: ?>
          <!-- ✅ Show when NOT logged in -->
          <li class="nav-item">
            <a class="nav-link <?= url_is('login') ? 'active' : '' ?>" href="<?= base_url('login') ?>">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= url_is('register') ? 'active' : '' ?>" href="<?= base_url('register') ?>">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- ✅ Flash Messages -->
<div class="container mt-3">
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
</div>

<!-- ✅ Page Content -->
<div class="container mt-4">
  <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
