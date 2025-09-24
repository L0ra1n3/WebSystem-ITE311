<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h2 class="mb-4">Register</h2>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('register') ?>">
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
        <input type="password" name="password" class="form-control" required>
      </div>

      <!-- <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-control">
          <option value="student">student</option>
          <option value="instructor">teacher</option>
          <option value="admin">admin</option>
          <option value="user">User</option>
        </select>
      </div> -->

      <button type="submit" class="btn btn-success">Register</button>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
