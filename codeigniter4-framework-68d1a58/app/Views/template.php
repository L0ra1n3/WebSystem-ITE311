<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LMS Sidebar Navigation</title>

  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">

  <style>
    :root {
      --primary: #0d6efd;
      --sidebar-bg: #f8f9fa;
      --active-bg: #e2e6ea;
      --highlight: #6c757d;
      --text-color: #343a40;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .sidebar {
      height: 100vh;
      background-color: var(--sidebar-bg);
      padding-top: 1rem;
      border-right: 1px solid #dee2e6;
    }

    .sidebar .nav-link {
      color: var(--text-color);
      padding: 0.75rem 1.25rem;
      display: block;
      position: relative;
      font-weight: 500;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar .nav-link.active {
      background-color: var(--active-bg);
      color: var(--primary);
      font-weight: bold;
    }

    .sidebar .nav-link:hover {
      background-color: #9cbcdbff;
      color: var(--primary);
    }

    .highlight-bar {
      position: absolute;
      left: 0;
      width: 5px;
      height: 40px;
      background-color: var(--highlight);
      transition: top 0.3s ease;
      border-radius: 0 5px 5px 0;
    }

    .logo {
      font-weight: bold;
      font-size: 1.25rem;
      padding: 0 1.25rem 1rem;
      color: var(--primary);
    }

    .content {
      padding: 2rem;
    }

    .sidebar-nav {
      position: relative;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
     
      <div class="col-md-3 col-lg-2 sidebar">
        <div class="logo">Navigation Sample</div>
        <div class="sidebar-nav">
          <div class="highlight-bar" id="highlightBar"></div>

          <a href="#" class="nav-link active" onclick="setActive(this)">Dashboard</a>
          <a href="#" class="nav-link" onclick="setActive(this)">Courses</a>
          <a href="#" class="nav-link" onclick="setActive(this)">Assignments</a>
          <a href="#" class="nav-link" onclick="setActive(this)">Grades</a>
          <a href="#" class="nav-link" onclick="setActive(this)">Profile</a>
        </div>
      </div>

      
      <div class="col-md-9 col-lg-10 content">
        <h1>Welcome!</h1>
        <p>This is where you manage your learning.</p>
      </div>
    </div>
  </div>

 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

  
  <script>
    const highlightBar = document.getElementById('highlightBar');
    const links = document.querySelectorAll('.nav-link');

    function setActive(link) {
      links.forEach(el => el.classList.remove('active'));
      link.classList.add('active');

      const topPosition = link.offsetTop;
      highlightBar.style.top = topPosition + 'px';
    }

  
    window.onload = () => {
      const activeLink = document.querySelector('.nav-link.active');
      highlightBar.style.top = activeLink.offsetTop + 'px';
    };
  </script>
</body>
</html>
