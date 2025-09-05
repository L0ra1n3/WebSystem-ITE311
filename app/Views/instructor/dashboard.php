<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="p-5 rounded-4 shadow-lg text-center" 
         style="background: linear-gradient(to right, #a8e6cf, #dcedc1); 
                color: #155724; 
                width: 100%; 
                min-height: 250px;">
        <h1 class="mb-3 display-4 fw-bold">Hello! <?= session()->get('name') ?> </h1>
        <p class="mb-3 fs-5">
            Welcome to your user dashboard! Here you can access your profile, track your activity, and manage your settings easily.
        </p>
        <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-lg px-4 py-2 shadow-sm">
            Logout
        </a>
    </div>
</div>

<?= $this->endSection() ?>
