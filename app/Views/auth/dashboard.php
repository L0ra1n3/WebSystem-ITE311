<?php if($role == 'admin'): ?>
    <h1>Welcome Admin!</h1>
    <a href="/admin/users">Manage Users</a>
    <a href="/admin/reports">View Reports</a>

<?php elseif($role == 'teacher'): ?>
    <h1>Welcome Teacher!</h1>
    <a href="/teacher/classes">My Classes</a>
    <a href="/teacher/grades">Grade Students</a>

<?php else: ?>
    <h1>Welcome Student!</h1>
    <a href="/student/courses">My Courses</a>
    <a href="/student/assignments">Assignments</a>
<?php endif; ?>
