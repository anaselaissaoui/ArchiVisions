<?php

session_start();
require "database.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <title>ArchiVisions</title>
</head>

<body style="background-color: #fff;">


    <header>
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
            <div class="align-items-center d-flex justify-content-between px-5 py-3">
                <a href="./index.html"><img src="./img/logo1.png" alt="" height="60px"></a>
            </div>

            <form class="d-flex w-25 ms-auto">
                <input class="form-control border-0" type="search" placeholder="Search">
            </form>
            <div class="navbar-nav align-items-center ms-auto">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="rounded-circle me-lg-2" src="img/user.png" alt="" style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex"><?php echo $_SESSION['username'] ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="./profile.php" class="dropdown-item">My Profile</a>
                        <a href="./signout.php" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>

    </header>

    <main class="container pt-4 px-4">
  <div class="row row-cols-1 row-cols-md-4 g-4">
    <?php
    $content = $conn->query("SELECT * FROM works");
    while ($row = $content->fetch()) {
      echo '<div class="col">
              <div class="card h-100 border-primary border-1 shadow-lg">
              
                <img src="' . $row['work_img'] . '" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="">
                <div class="card-body mt_auto">
                  <h5 class="card-title text-primary">' . $row['work_title'] . '</h5>
                  <p class="card-text">' . $row['work_author'] . '</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                <a href="booking.php" class="btn btn-primary me-3">Book</a>
                <a href="details.php?item_id='.$row['work_id'].' class="btn btn-outline-primary">Details</a>
                  </div>
              </div>
            </div>';
    }
    ?>
  </div>



    </main>
    <footer>
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light rounded-top p-4">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-start">
                        © <a href="#" class="text-decoration-none">ArchiVisions</a>, All Right Reserved.
                    </div>
                    <div class="col-12 col-sm-6 text-center text-sm-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a href="https://github.com/anaselaissaoui" class="text-decoration-none">El Aissaoui Anas</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>

<style>
   
   .card:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
  }
</style>

