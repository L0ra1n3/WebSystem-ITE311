<nav>
    <a href="/dashboard">Dashboard</a>

    <?php if(session()->get('role') == 'admin'): ?>
        <a href="/admin/users">Manage Users</a>
        <a href="/admin/reports">Reports</a>

    <?php elseif(session()->get('role') == 'teacher'): ?>
        <a href="/teacher/classes">My Classes</a>
        <a href="/teacher/grades">Grades</a>

    <?php else: ?>
        <a href="/student/courses">My Courses</a>
        <a href="/student/assignments">Assignments</a>
    <?php endif; ?>

    <a href="/logout">Logout</a>
</nav>
