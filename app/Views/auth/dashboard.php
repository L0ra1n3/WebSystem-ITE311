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
                            
                            <!-- Course Materials -->
                            <?php if (isset($materials[$e['course_id']]) && !empty($materials[$e['course_id']])): ?>
                                <div class="mt-2">
                                    <strong class="text-primary"><i class="bi bi-file-earmark-text"></i> Course Materials:</strong>
                                    <ul class="list-unstyled ms-3 mt-1">
                                        <?php foreach($materials[$e['course_id']] as $material): ?>
                                            <li class="mb-1">
                                                <i class="bi bi-download text-success"></i>
                                                <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="text-decoration-none">
                                                    <?= esc($material['file_name']) ?>
                                                </a>
                                                <small class="text-muted">(<?= date('M d, Y', strtotime($material['created_at'])) ?>)</small>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
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

            <!-- Enrolled Students -->
            <div class="card mt-4">
                <div class="card-header bg-success text-white">
                    <strong>📚 Enrolled Students</strong>
                </div>
                <div class="card-body">
                    <?php if (!empty($enrollments)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Course</th>
                                        <th>Course Code</th>
                                        <th>Units</th>
                                        <th>Enrollment Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($enrollments as $e): ?>
                                        <tr>
                                            <td><?= esc($e['username']) ?></td>
                                            <td><?= esc($e['email']) ?></td>
                                            <td><?= esc($e['course_name']) ?></td>
                                            <td><span class="badge bg-secondary"><?= esc($e['course_code']) ?></span></td>
                                            <td><?= esc($e['units']) ?></td>
                                            <td><?= date('M d, Y', strtotime($e['enrollment_date'])) ?></td>
                                            <td>
                                                <?php if ($e['status'] === 'enrolled'): ?>
                                                    <span class="badge bg-success">Enrolled</span>
                                                <?php elseif ($e['status'] === 'completed'): ?>
                                                    <span class="badge bg-primary">Completed</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Dropped</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No students enrolled yet.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Available Courses -->
            <div class="card mt-4">
                <div class="card-header bg-success text-white">
                    <strong>All Courses & Materials</strong>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if (!empty($courses)): ?>
                        <?php foreach($courses as $c): ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?= esc($c['course_name']) ?></strong> 
                                        <span class="badge bg-secondary"><?= esc($c['course_code']) ?></span>
                                        <br>
                                        <small class="text-muted"><?= esc($c['description']) ?></small>
                                        <div class="mt-1">
                                            <span class="badge bg-info"><?= esc($c['units']) ?> units</span>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="<?= site_url('admin/course/' . $c['id'] . '/upload') ?>" class="btn btn-sm btn-success">
                                            <i class="bi bi-upload"></i> Upload Material
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Course Materials -->
                                <?php if (isset($materials[$c['id']]) && !empty($materials[$c['id']])): ?>
                                    <div class="mt-3">
                                        <strong class="text-primary"><i class="bi bi-file-earmark-text"></i> Course Materials:</strong>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>Uploaded</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($materials[$c['id']] as $material): ?>
                                                        <tr>
                                                            <td>
                                                                <i class="bi bi-file-earmark"></i>
                                                                <?= esc($material['file_name']) ?>
                                                            </td>
                                                            <td><?= date('M d, Y', strtotime($material['created_at'])) ?></td>
                                                            <td>
                                                                <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="btn btn-sm btn-primary">
                                                                    <i class="bi bi-download"></i>
                                                                </a>
                                                                <a href="<?= site_url('materials/delete/' . $material['id']) ?>" 
                                                                   class="btn btn-sm btn-danger"
                                                                   onclick="return confirm('Are you sure you want to delete this material?');">
                                                                    <i class="bi bi-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-2 text-muted small">
                                        <i class="bi bi-info-circle"></i> No materials uploaded yet
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-muted">No courses available</li>
                    <?php endif; ?>
                </ul>
            </div>

        <?php elseif ($role === 'admin'): ?>
            <!-- ✅ Admin Dashboard -->
            <h3 class="text-primary">Admin Panel</h3>
            <ul class="list-group mt-3">
                <li class="list-group-item"><a href="<?= site_url('admin/users') ?>">Manage Users</a></li>
                <li class="list-group-item"><a href="<?= site_url('admin/reports') ?>">View Reports</a></li>
            </ul>

            <!-- Available Courses -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <strong>All Courses & Materials</strong>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if (!empty($courses)): ?>
                        <?php foreach($courses as $c): ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?= esc($c['course_name']) ?></strong> 
                                        <span class="badge bg-secondary"><?= esc($c['course_code']) ?></span>
                                        <br>
                                        <small class="text-muted"><?= esc($c['description']) ?></small>
                                        <div class="mt-1">
                                            <span class="badge bg-info"><?= esc($c['units']) ?> units</span>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="<?= site_url('admin/course/' . $c['id'] . '/upload') ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-upload"></i> Upload Material
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Course Materials -->
                                <?php if (isset($materials[$c['id']]) && !empty($materials[$c['id']])): ?>
                                    <div class="mt-3">
                                        <strong class="text-primary"><i class="bi bi-file-earmark-text"></i> Course Materials:</strong>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>Uploaded</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($materials[$c['id']] as $material): ?>
                                                        <tr>
                                                            <td>
                                                                <i class="bi bi-file-earmark"></i>
                                                                <?= esc($material['file_name']) ?>
                                                            </td>
                                                            <td><?= date('M d, Y', strtotime($material['created_at'])) ?></td>
                                                            <td>
                                                                <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="btn btn-sm btn-primary">
                                                                    <i class="bi bi-download"></i>
                                                                </a>
                                                                <a href="<?= site_url('materials/delete/' . $material['id']) ?>" 
                                                                   class="btn btn-sm btn-danger"
                                                                   onclick="return confirm('Are you sure you want to delete this material?');">
                                                                    <i class="bi bi-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-2 text-muted small">
                                        <i class="bi bi-info-circle"></i> No materials uploaded yet
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-muted">No courses available</li>
                    <?php endif; ?>
                </ul>
            </div>

        <?php else: ?>
            <p>Unknown role. Please contact admin.</p>
        <?php endif; ?>
    </div>
</div>
