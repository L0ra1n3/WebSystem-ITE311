<?= $this->include('templates/header') ?>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2 class="mb-3">Hello, <?= esc($name) ?>!</h2>
        <p>Your role: <strong><?= esc($role) ?></strong></p>

        <?php if ($role === 'student'): ?>
            <!-- ✅ Student Dashboard -->
            <!-- Enrolled Courses -->
            <div id="enrolled-section" class="card mb-3">
                <div class="card-header">Enrolled Courses</div>
                <ul id="enrolled-list" class="list-group list-group-flush">
                    <?php foreach($enrollments as $e): ?>
                        <li class="list-group-item" data-course-id="<?= esc($e['course_id']) ?>">
                            <strong><?= esc($e['course_name']) ?></strong> (<?= esc($e['course_code']) ?>)
                            <div class="small text-muted"><?= esc($e['enrollment_date']) ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Available Courses -->
            <div class="card mb-3">
                <div class="card-header">Available Courses</div>
                <ul class="list-group list-group-flush">
                    <?php foreach($courses as $c): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="course-<?= $c['id'] ?>">
                            <div>
                                <strong><?= esc($c['course_name']) ?></strong> (<?= esc($c['course_code']) ?>)
                                <small><?= esc($c['description']) ?></small>
                            </div>
                            <button class="btn btn-primary btn-enroll" data-course-id="<?= $c['id'] ?>"
                                <?= in_array($c['id'], array_column($enrollments, 'course_id')) ? 'disabled' : '' ?>>
                                <?= in_array($c['id'], array_column($enrollments, 'course_id')) ? 'Enrolled' : 'Enroll' ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Alert placeholder -->
            <div id="alert-placeholder" style="position: fixed; top: 10px; right: 10px; z-index: 9999;"></div>

            <!-- jQuery & AJAX for Enroll -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            var csrfName = '<?= csrf_token() ?>';
            var csrfHash = '<?= csrf_hash() ?>';

            $(document).ready(function(){
                $('.btn-enroll').on('click', function(e){
                    e.preventDefault();
                    var btn = $(this);
                    var courseId = btn.data('course-id');

                    btn.prop('disabled', true).text('Processing...');

                    var payload = { 'course_id': courseId };
                    payload[csrfName] = csrfHash;

                    $.post("<?= site_url('course/enroll') ?>", payload)
                        .done(function(response){
                            if(response.status === 'success'){
                                $('#alert-placeholder').append(
                                    '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                    response.message +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                                );
                                btn.text('Enrolled').prop('disabled', true);

                                if(response.enrollments){
                                    $('#enrolled-list').empty();
                                    response.enrollments.forEach(function(e){
                                        $('#enrolled-list').append(
                                            '<li class="list-group-item"><strong>' + e.course_name + '</strong> (' + e.course_code + ')' +
                                            '<div class="small text-muted">' + e.enrollment_date + '</div></li>'
                                        );
                                    });
                                }
                            } else {
                                $('#alert-placeholder').append(
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    (response.message || 'Error enrolling') +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                                );
                                btn.prop('disabled', false).text('Enroll');
                            }
                        })
                        .fail(function(xhr){
                            var message = 'Request failed: ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText);
                            $('#alert-placeholder').append(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            );
                            btn.prop('disabled', false).text('Enroll');
                        });
                });
            });
            </script>

        <?php elseif ($role === 'teacher'): ?>
            <!-- ✅ Teacher Dashboard -->
            <h3 class="text-success">Teacher Panel</h3>
            <ul class="list-group mt-3">
                <li class="list-group-item"><a href="<?= site_url('teacher/classes') ?>">My Classes</a></li>
                <li class="list-group-item"><a href="<?= site_url('teacher/grades') ?>">Grade Students</a></li>
            </ul>

        <?php elseif ($role === 'admin'): ?>
            <!-- ✅ Admin Dashboard -->
            <h3 class="text-primary">Admin Panel</h3>
            <ul class="list-group mt-3">
                <li class="list-group-item"><a href="<?= site_url('admin/users') ?>">Manage Users</a></li>
                <li class="list-group-item"><a href="<?= site_url('admin/reports') ?>">View Reports</a></li>
            </ul>

        <?php else: ?>
            <p>Unknown role. Please contact admin.</p>
        <?php endif; ?>
    </div>
</div>
