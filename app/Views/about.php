<?php 
include 'template.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            text-align: center;
            margin-bottom: 20px;
            font-size: 3rem;
        }
        p.lead {
            text-align: center;
            font-size: 1.2rem;
            color: #555;
        }
        .card {
            padding: 20px;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            height: 100%;
        }
        h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        p {
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1>About Us</h1>
        <p class="lead">Learn more about our mission and goals for professional development.</p>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card text-center">
                    <h3>Our Mission</h3>
                    <p>To provide quality education and training for career growth.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <h3>Our Vision</h3>
                    <p>To be the leading platform for professional development.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
