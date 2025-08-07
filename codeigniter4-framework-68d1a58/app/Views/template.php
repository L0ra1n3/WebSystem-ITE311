<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LMS Navigation</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
  <style>
    .navbar-custom {
      background-color: #2c3e50; /* Dark blue-gray */
    }
    .navbar-brand,
    .nav-link {
      color: #ecf0f1 !important; /* Light text for contrast */
    }
    .nav-link:hover {
      color: #3498db !important; /* Hover effect: brighter blue */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand">Navigation</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#items" aria-controls="items" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="items">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="#" class="nav-link active">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Courses</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Grades</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Support</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
