<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm p-4">
      <h3 class="text-center mb-4 text-primary">Login</h3>

      <!-- Show errors -->
      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <!-- Login Form -->
      <form action="<?= base_url('login') ?>" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Login</button>
      </form>

      <p class="mt-3 text-center">
        Don’t have an account? <a href="<?= base_url('register') ?>">Register here</a>
      </p>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
