<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
  <h1>Welcome, <?= session()->get('username') ?> 👋</h1>
  <p>This is your User Dashboard.</p>
  <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
</div>

<?= $this->endSection() ?>
