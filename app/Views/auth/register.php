<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="mb-4">Register</h2>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('register') ?>" onsubmit="return validatePassword()">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">Register</button>
    </form>
  </div>
</div>

<script>
  function validatePassword() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
      alert("Passwords do not match. Please try again.");
      return false;
    }
    return true;
  }
</script>

<?= $this->endSection() ?>
