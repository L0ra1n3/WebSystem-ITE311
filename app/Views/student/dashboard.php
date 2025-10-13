<!-- ✅ Include jQuery and CSRF Token -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  var csrfName = '<?= csrf_token() ?>'; // token name
  var csrfHash = '<?= csrf_hash() ?>';  // token value
</script>

<!-- Enrolled Courses -->
<div id="enrolled-section" class="card mb-3">
  <div class="card-header">Enrolled Courses</div>
  <ul id="enrolled-list" class="list-group list-group-flush">
    <?php foreach($enrollments as $e): ?>
      <li class="list-group-item" data-course-id="<?= esc($e['course_id']) ?>">
        <strong><?= esc($e['title']) ?></strong>
        <div class="small text-muted"><?= esc($e['enrollment_date']) ?></div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<!-- Available Courses -->
<div class="card">
  <div class="card-header">Available Courses</div>
  <ul class="list-group list-group-flush">
    <?php foreach($courses as $c): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center" id="course-<?= $c['id'] ?>">
        <div>
          <strong><?= esc($c['title']) ?></strong><br>
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

<!-- ✅ AJAX Script -->
<script>
$(document).ready(function(){
  $('.btn-enroll').on('click', function(e){
    e.preventDefault();
    var btn = $(this);
    var courseId = btn.data('course-id');

    // Disable button to prevent double clicks
    btn.prop('disabled', true).text('Processing...');

    // Build payload with CSRF
    var payload = {};
    payload['course_id'] = courseId;
    payload[csrfName] = csrfHash; // include CSRF token

    $.post("<?= site_url('course/enroll') ?>", payload)
      .done(function(response){
        if(response.status === 'success'){
          // success alert
          var alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                      response.message +
                      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
          $('#alert-placeholder').append(alert);

          // update button
          btn.text('Enrolled').prop('disabled', true);

          // update enrolled list
          if(response.enrollments){
            $('#enrolled-list').empty();
            response.enrollments.forEach(function(e){
              $('#enrolled-list').append(
                '<li class="list-group-item"><strong>' + e.title + '</strong><div class="small text-muted">' + e.enrollment_date + '</div></li>'
              );
            });
          }
        } else {
          // error alert
          var alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                      (response.message || 'Error enrolling') +
                      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
          $('#alert-placeholder').append(alert);
          btn.prop('disabled', false).text('Enroll');
        }
      })
      .fail(function(xhr){
        var message = 'Request failed: ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText);
        var alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        $('#alert-placeholder').append(alert);
        btn.prop('disabled', false).text('Enroll');
      });
  });
});
</script>
