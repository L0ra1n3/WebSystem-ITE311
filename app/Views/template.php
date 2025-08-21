<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Highlight Example</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">

  <style>
    :root {
      --primary: #53ae7bff;
      --nav-bg: #e0f5e7ff;
      --text-color: #343a40;
    }

    .navbar-custom {
      background-color: var(--nav-bg);
      border-bottom: 1px solid #dee2e6;
      position: relative;
      padding-left: 1rem;
    }

    .navbar-custom .navbar-brand {
      font-weight: bold;
      color: var(--primary);
      margin-right: 2rem;
    }

    .navbar-custom .nav-link {
      color: var(--text-color);
      font-weight: 500;
      padding: 0.75rem 1rem;
      transition: color 0.3s ease;
      position: relative;
    }

    .navbar-custom .nav-link.active,
    .navbar-custom .nav-link:hover {
      color: var(--primary);
    }

    
    .highlight-bar {
      position: absolute;
      bottom: 0;
      height: 3px;
      background-color: var(--primary);
      transition: all 0.3s ease;
      border-radius: 2px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    
    <a class="navbar-brand" href="#">Navigation Sample</a>

    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- for mobile -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto position-relative">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        
        <div class="highlight-bar"></div>
      </ul>
    </div>
  </div>
</nav>

<script>
  const links = document.querySelectorAll('.nav-link');
  const highlight = document.querySelector('.highlight-bar');

  function moveHighlight(link) {
    const rect = link.getBoundingClientRect();
    const navRect = link.closest('.navbar-nav').getBoundingClientRect();
    highlight.style.width = rect.width + "px";
    highlight.style.left = (rect.left - navRect.left) + "px";
  }

  
  window.addEventListener("load", () => {
    const activeLink = document.querySelector(".nav-link.active");
    if (activeLink) moveHighlight(activeLink);
  });

  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      links.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
      moveHighlight(this);
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
