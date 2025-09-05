<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="container">
  <h1>Hello, <?= session()->get('name') ?> 👋</h1>
  <p>Welcome to your instructor dashboard.</p>
  <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
</div>

<?= $this->endSection() ?>
