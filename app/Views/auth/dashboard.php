<?= $this->include('templates/header') ?>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
       <h2 class="mb-3">Hello, <?= esc($username) ?>!</h2>
        <p>Your role is: <strong><?= esc($role) ?></strong></p>

        <?php if ($role === 'admin'): ?>
            <h3 class="text-primary">Admin Panel</h3>
            <ul class="list-group mt-3">
                <li class="list-group-item"><a href="<?= site_url('admin/users') ?>">Manage Users</a></li>
                <li class="list-group-item"><a href="<?= site_url('admin/reports') ?>">View Reports</a></li>
            </ul>

        <?php elseif ($role === 'teacher'): ?>
            <h3 class="text-success">Teacher Panel</h3>
            <ul class="list-group mt-3">
                <li class="list-group-item"><a href="<?= site_url('teacher/classes') ?>">My Classes</a></li>
                <li class="list-group-item"><a href="<?= site_url('teacher/grades') ?>">Grade Students</a></li>
            </ul>

        <?php else: ?>
            <h3 class="text-info">Student Panel</h3>
            <ul class="list-group mt-3">
                <li class="list-group-item"><a href="<?= site_url('student/courses') ?>">My Courses</a></li>
                <li class="list-group-item"><a href="<?= site_url('student/assignments') ?>">Assignments</a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>
