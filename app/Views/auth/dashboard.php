<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="text-center">
  <h1 class="text-success">Welcome, <?= session()->get('name') ?>!</h1>
  <p>You are logged in as <b><?= session()->get('role') ?></b></p>
  <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
</div>

<?= $this->endSection() ?>
